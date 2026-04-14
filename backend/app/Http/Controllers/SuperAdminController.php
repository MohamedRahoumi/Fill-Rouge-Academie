<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Categorie;
use App\Models\Groupe;
use App\Models\Joueur;
use App\Models\Paiement;
use App\Models\NotificationAcademie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    // === DASHBOARD ===
    public function index()
    {
        $stats = [
            'coachs'    => User::where('role', 'coach')->count(),
            'parents'   => User::where('role', 'parent')->count(),
            'joueurs'   => Joueur::count(),
            'groupes'   => Groupe::count(),
            'categories'=> Categorie::count(),
            'paiements' => Paiement::where('statut', 'paid')->sum('montant'),
        ];
        $recentPaiements = Paiement::with('parent')->latest()->take(5)->get();
        $notifications   = NotificationAcademie::with('destinataire')->latest()->take(5)->get();

        $allCategories = Categorie::withCount(['groupes', 'joueurs'])
            ->orderBy('nom')
            ->get();

        $allGroupes = Groupe::with(['categorie', 'coach'])
            ->withCount('joueurs')
            ->orderBy('nom')
            ->get();

        $allJoueurs = Joueur::with(['parent', 'categorie', 'groupe'])
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        $allCoachs = User::where('role', 'coach')
            ->withCount('groupesGeres')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        $allParents = User::where('role', 'parent')
            ->withCount('joueurs')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return $this->success([
            'stats' => $stats,
            'recentPaiements' => $recentPaiements,
            'notifications' => $notifications,
            'categories' => $allCategories,
            'groupes' => $allGroupes,
            'joueurs' => $allJoueurs,
            'coachs' => $allCoachs,
            'parents' => $allParents,
        ]);
    }

    // === COACHS ===
    public function createCoach()
    {
        return $this->success([], 'Endpoint JSON: creation coach.');
    }

    public function storeCoach(Request $request)
    {
        $data = $request->validate([
            'nom'      => 'required|string|max:100',
            'prenom'   => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $coach = User::create([
            'nom'      => $data['nom'],
            'prenom'   => $data['prenom'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'coach',
        ]);

        return $this->success(['coach' => $coach], 'Coach cree avec succes.', 201);
    }

    public function editCoach(User $coach)
    {
        abort_if($coach->role !== 'coach', 404);
        return $this->success(['coach' => $coach]);
    }

    public function updateCoach(Request $request, User $coach)
    {
        abort_if($coach->role !== 'coach', 404);
        $data = $request->validate([
            'nom'    => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email'  => 'required|email|unique:users,email,' . $coach->id,
        ]);
        $coach->update($data);
        return $this->success(['coach' => $coach->fresh()], 'Coach mis a jour.');
    }

    public function destroyCoach(User $coach)
    {
        abort_if($coach->role !== 'coach', 404);
        $coach->delete();
        return $this->success([], 'Coach supprime.');
    }

    // === PARENTS ===
    public function createParent()
    {
        return $this->success([], 'Endpoint JSON: creation parent.');
    }

    public function storeParent(Request $request)
    {
        $data = $request->validate([
            'nom'      => 'required|string|max:100',
            'prenom'   => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $parent = User::create([
            'nom'      => $data['nom'],
            'prenom'   => $data['prenom'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'parent',
        ]);

        return $this->success(['parent' => $parent], 'Parent cree avec succes.', 201);
    }

    public function editParent(User $parent)
    {
        abort_if($parent->role !== 'parent', 404);
        return $this->success(['parent' => $parent]);
    }

    public function updateParent(Request $request, User $parent)
    {
        abort_if($parent->role !== 'parent', 404);
        $data = $request->validate([
            'nom'    => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email'  => 'required|email|unique:users,email,' . $parent->id,
        ]);
        $parent->update($data);
        return $this->success(['parent' => $parent->fresh()], 'Parent mis a jour.');
    }

    public function destroyParent(User $parent)
    {
        abort_if($parent->role !== 'parent', 404);
        $parent->delete();
        return $this->success([], 'Parent supprime.');
    }

    // === CATÉGORIES ===
    public function createCategorie()
    {
        return $this->success([], 'Endpoint JSON: creation categorie.');
    }

    public function storeCategorie(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);
        $categorie = Categorie::create($request->only('nom', 'description'));
        return $this->success(['categorie' => $categorie], 'Categorie creee.', 201);
    }

    public function editCategorie(Categorie $categorie)
    {
        return $this->success(['categorie' => $categorie]);
    }

    public function updateCategorie(Request $request, Categorie $categorie)
    {
        $request->validate(['nom' => 'required|string|max:50']);
        $categorie->update($request->only('nom', 'description'));
        return $this->success(['categorie' => $categorie->fresh()], 'Categorie mise a jour.');
    }

    public function destroyCategorie(Categorie $categorie)
    {
        $categorie->delete();
        return $this->success([], 'Categorie supprimee.');
    }

    // === GROUPES ===
    public function createGroupe()
    {
        $categories = Categorie::all();
        $coachs     = User::where('role', 'coach')->get();
        return $this->success([
            'categories' => $categories,
            'coachs' => $coachs,
        ]);
    }

    public function storeGroupe(Request $request)
    {
        $request->validate([
            'nom'          => 'required|string|max:100',
            'categorie_id' => 'required|exists:categories,id',
            'coach_id'     => 'nullable|exists:users,id',
        ]);
        $groupe = Groupe::create($request->only('nom', 'categorie_id', 'coach_id'));
        return $this->success(['groupe' => $groupe], 'Groupe cree.', 201);
    }

    public function editGroupe(Groupe $groupe)
    {
        $categories = Categorie::all();
        $coachs     = User::where('role', 'coach')->get();
        return $this->success([
            'groupe' => $groupe,
            'categories' => $categories,
            'coachs' => $coachs,
        ]);
    }

    public function updateGroupe(Request $request, Groupe $groupe)
    {
        $request->validate([
            'nom'          => 'required|string|max:100',
            'categorie_id' => 'required|exists:categories,id',
            'coach_id'     => 'nullable|exists:users,id',
        ]);
        $groupe->update($request->only('nom', 'categorie_id', 'coach_id'));
        return $this->success(['groupe' => $groupe->fresh()], 'Groupe mis a jour.');
    }

    public function destroyGroupe(Groupe $groupe)
    {
        $groupe->delete();
        return $this->success([], 'Groupe supprime.');
    }

    public function assignCoachToGroupe(Request $request, Groupe $groupe)
    {
        $request->validate(['coach_id' => 'required|exists:users,id']);
        $groupe->update(['coach_id' => $request->coach_id]);
        return $this->success(['groupe' => $groupe->fresh()], 'Coach assigne au groupe.');
    }

    // === JOUEURS ===
    public function joueurs()
    {
        $joueurs = Joueur::with(['parent', 'categorie', 'groupe'])->latest()->paginate(20);
        return $this->success(['joueurs' => $joueurs]);
    }

    public function createJoueur()
    {
        $parents    = User::where('role', 'parent')->get();
        $categories = Categorie::all();
        return $this->success([
            'parents' => $parents,
            'categories' => $categories,
        ]);
    }

    public function storeJoueur(Request $request)
    {
        $request->validate([
            'nom'             => 'required|string|max:100',
            'prenom'          => 'required|string|max:100',
            'date_naissance'  => 'required|date',
            'parent_id'       => 'required|exists:users,id',
            'categorie_id'    => 'nullable|exists:categories,id',
        ]);
        $joueur = Joueur::create($request->only('nom', 'prenom', 'date_naissance', 'parent_id', 'categorie_id'));
        return $this->success(['joueur' => $joueur], 'Joueur cree.', 201);
    }

    public function editJoueur(Joueur $joueur)
    {
        $parents    = User::where('role', 'parent')->get();
        $categories = Categorie::all();
        return $this->success([
            'joueur' => $joueur,
            'parents' => $parents,
            'categories' => $categories,
        ]);
    }

    public function updateJoueur(Request $request, Joueur $joueur)
    {
        $request->validate([
            'nom'            => 'required|string|max:100',
            'prenom'         => 'required|string|max:100',
            'date_naissance' => 'required|date',
            'parent_id'      => 'required|exists:users,id',
            'categorie_id'   => 'nullable|exists:categories,id',
        ]);
        $joueur->update($request->only('nom', 'prenom', 'date_naissance', 'parent_id', 'categorie_id'));
        return $this->success(['joueur' => $joueur->fresh()], 'Joueur mis a jour.');
    }

    public function destroyJoueur(Joueur $joueur)
    {
        $joueur->delete();
        return $this->success([], 'Joueur supprime.');
    }

    public function assignJoueurToCategorie(Request $request, Joueur $joueur)
    {
        $request->validate(['categorie_id' => 'required|exists:categories,id']);
        $joueur->update(['categorie_id' => $request->categorie_id, 'groupe_id' => null]);
        return $this->success(['joueur' => $joueur->fresh()], 'Joueur affecte a la categorie.');
    }

    // === PAIEMENTS ===
    public function paiements()
    {
        $paiements = Paiement::with('parent')->latest()->paginate(20);
        return $this->success(['paiements' => $paiements]);
    }

    public function validerPaiement(Paiement $paiement)
    {
        if ($paiement->statut !== 'pending') {
            return $this->error('Seuls les paiements en attente peuvent etre valides.', 422);
        }

        try {
            $paiement->update(['statut' => 'paid']);

            $mois = optional($paiement->mois_concerne)->format('m/Y') ?? 'ce mois';
            $senderId = auth()->id() ?? User::where('role', 'superadmin')->value('id');

            if (!$senderId) {
                return $this->error('Paiement valide, mais aucun expediteur de notification n\'a ete trouve.', 500);
            }

            NotificationAcademie::create([
                'titre' => 'Paiement valide',
                'message' => 'Votre paiement du mois ' . $mois . ' a ete valide avec succes.',
                'user_id' => $paiement->parent_id,
                'sender_id' => $senderId,
                'est_lu' => false,
            ]);

            return $this->success(['paiement' => $paiement->fresh()], 'Paiement valide et notification envoyee au parent.');
        } catch (\Throwable $e) {
            return $this->error('Paiement valide, mais la notification a echoue: ' . $e->getMessage(), 500);
        }
    }

    // === NOTIFICATIONS ===
    public function createNotification()
    {
        $destinataires = User::where('role', '!=', 'superadmin')->get();
        return $this->success(['destinataires' => $destinataires]);
    }

    public function storeNotification(Request $request)
    {
        $request->validate([
            'titre'    => 'required|string|max:200',
            'message'  => 'required|string',
            'cible'    => 'required|in:all,coaches,parents,specific',
            'user_ids' => 'required_if:cible,specific|array',
        ]);

        $sender = auth()->user();

        $destinataires = match($request->cible) {
            'all'      => User::where('role', '!=', 'superadmin')->get(),
            'coaches'  => User::where('role', 'coach')->get(),
            'parents'  => User::where('role', 'parent')->get(),
            'specific' => User::whereIn('id', $request->user_ids)->get(),
        };

        foreach ($destinataires as $user) {
            NotificationAcademie::create([
                'titre'     => $request->titre,
                'message'   => $request->message,
                'user_id'   => $user->id,
                'sender_id' => $sender->id,
                'est_lu'    => false,
            ]);
        }

        return $this->success([
            'sent_count' => $destinataires->count(),
        ], 'Notification envoyee.');
    }
}
