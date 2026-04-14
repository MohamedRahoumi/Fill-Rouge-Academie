<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Joueur;
use App\Models\Seance;
use App\Models\Presence;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    // === DASHBOARD ===
    public function index()
    {
        $coach   = auth()->user();
        $groupes = $coach->groupesGeres()->with('categorie', 'joueurs')->get();

        $prochainesSeances = Seance::whereIn('groupe_id', $groupes->pluck('id'))
            ->where('date_seance', '>=', now()->toDateString())
            ->orderBy('date_seance')
            ->take(5)
            ->with('groupe')
            ->get();

        return $this->success([
            'coach' => $coach,
            'groupes' => $groupes,
            'prochaines_seances' => $prochainesSeances,
        ]);
    }

    // === GROUPES ===
    public function showGroupe(Groupe $groupe)
    {
        $this->authorizeGroupe($groupe);

        $groupe->load('joueurs.categorie', 'seances', 'categorie');
        $joueursCategorie = Joueur::where('categorie_id', $groupe->categorie_id)
            ->whereNull('groupe_id')
            ->orWhere('groupe_id', $groupe->id)
            ->get();

        return $this->success([
            'groupe' => $groupe,
            'joueurs_categorie' => $joueursCategorie,
        ]);
    }

    public function assignJoueur(Request $request, Groupe $groupe)
    {
        $this->authorizeGroupe($groupe);

        $request->validate(['joueur_id' => 'required|exists:joueurs,id']);

        $joueur = Joueur::findOrFail($request->joueur_id);
        abort_if($joueur->categorie_id !== $groupe->categorie_id, 422, 'Ce joueur n\'appartient pas à la catégorie de ce groupe.');

        $joueur->update(['groupe_id' => $groupe->id]);

        return $this->success(['joueur' => $joueur->fresh()], 'Joueur assigne au groupe.');
    }

    // === SÉANCES ===
    public function createSeance(Groupe $groupe)
    {
        $this->authorizeGroupe($groupe);
        return $this->success(['groupe' => $groupe]);
    }

    public function storeSeance(Request $request, Groupe $groupe)
    {
        $this->authorizeGroupe($groupe);

        $request->validate([
            'titre'       => 'required|string|max:200',
            'date_seance' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin'   => 'required|after:heure_debut',
        ]);

        $seance = Seance::create([
            'titre'       => $request->titre,
            'date_seance' => $request->date_seance,
            'heure_debut' => $request->heure_debut,
            'heure_fin'   => $request->heure_fin,
            'groupe_id'   => $groupe->id,
            'coach_id'    => auth()->id(),
        ]);

        return $this->success(['seance' => $seance], 'Seance planifiee.', 201);
    }

    // === APPEL / PRÉSENCES ===
    public function appel(Seance $seance)
    {
        $this->authorizeSeance($seance);
        $seance->load('groupe.joueurs', 'presences.joueur');

        $joueurs   = $seance->groupe->joueurs;
        $presences = $seance->presences->keyBy('joueur_id');
        $evaluationsSeance = Evaluation::where('seance_id', $seance->id)
            ->whereIn('joueur_id', $joueurs->pluck('id'))
            ->get()
            ->keyBy('joueur_id');

        return $this->success([
            'seance' => $seance,
            'joueurs' => $joueurs,
            'presences' => $presences,
            'evaluations_seance' => $evaluationsSeance,
        ]);
    }

    public function storeAppel(Request $request, Seance $seance)
    {
        $this->authorizeSeance($seance);

        $request->validate([
            'presences'               => 'nullable|array',
            'motifs'                  => 'nullable|array',
        ]);

        $joueurs     = $seance->groupe->joueurs;
        $presentsIds = $request->input('presences', []);

        foreach ($joueurs as $joueur) {
            $estPresent = in_array($joueur->id, $presentsIds);
            Presence::updateOrCreate(
                ['seance_id' => $seance->id, 'joueur_id' => $joueur->id],
                [
                    'est_present'    => $estPresent,
                    'motif_absence'  => !$estPresent ? ($request->input("motifs.{$joueur->id}") ?? null) : null,
                ]
            );
        }

        return $this->success([], 'Appel enregistre.');
    }

    // === ÉVALUATIONS ===
    public function createEvaluation(Joueur $joueur)
    {
        $coach = auth()->user();
        abort_unless($joueur->groupe && $joueur->groupe->coach_id === $coach->id, 403);
        return $this->success(['joueur' => $joueur]);
    }

    public function storeEvaluation(Request $request, Joueur $joueur)
    {
        $coach = auth()->user();
        abort_unless($joueur->groupe && $joueur->groupe->coach_id === $coach->id, 403);

        $request->validate([
            'note'            => 'required|integer|min:1|max:10',
            'commentaire'     => 'required|string|min:10',
            'date_evaluation' => 'required|date',
        ]);

        $evaluation = Evaluation::create([
            'note'            => $request->note,
            'commentaire'     => $request->commentaire,
            'date_evaluation' => $request->date_evaluation,
            'joueur_id'       => $joueur->id,
            'coach_id'        => $coach->id,
        ]);

        return $this->success(['evaluation' => $evaluation], 'Evaluation enregistree.', 201);
    }

    public function createEvaluationForSeance(Seance $seance, Joueur $joueur)
    {
        $this->authorizeSeance($seance);
        abort_unless($joueur->groupe_id === $seance->groupe_id, 403, 'Ce joueur ne fait pas partie de cette seance.');

        $existingEvaluation = Evaluation::where('seance_id', $seance->id)
            ->where('joueur_id', $joueur->id)
            ->first();

        return $this->success([
            'joueur' => $joueur,
            'seance' => $seance,
            'existing_evaluation' => $existingEvaluation,
        ]);
    }

    public function storeEvaluationForSeance(Request $request, Seance $seance, Joueur $joueur)
    {
        $this->authorizeSeance($seance);
        abort_unless($joueur->groupe_id === $seance->groupe_id, 403, 'Ce joueur ne fait pas partie de cette seance.');

        $request->validate([
            'note'        => 'required|integer|min:1|max:10',
            'commentaire' => 'required|string|min:10',
        ]);

        $evaluation = Evaluation::updateOrCreate(
            [
                'seance_id' => $seance->id,
                'joueur_id' => $joueur->id,
            ],
            [
                'note' => $request->note,
                'commentaire' => $request->commentaire,
                'date_evaluation' => $seance->date_seance,
                'coach_id' => auth()->id(),
            ]
        );

        return $this->success(['evaluation' => $evaluation], 'Evaluation de la seance enregistree.');
    }

    // === HELPERS ===
    private function authorizeGroupe(Groupe $groupe): void
    {
        abort_unless($groupe->coach_id === auth()->id(), 403, 'Ce groupe ne vous est pas assigné.');
    }

    private function authorizeSeance(Seance $seance): void
    {
        abort_unless($seance->coach_id === auth()->id(), 403, 'Cette séance ne vous est pas assignée.');
    }
}
