<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class ParentController extends Controller
{
    // === DASHBOARD ===
    public function index()
    {
        $parent = auth()->user();

        $joueurs = $parent->joueurs()
            ->with('categorie', 'groupe.seances', 'evaluations')
            ->get();

        $paiements = $parent->paiements()->latest()->take(5)->get();

        $notifications = $parent->notificationsRecues()
            ->where('est_lu', false)
            ->with('expediteur')
            ->latest()
            ->get();

        return $this->success([
            'parent' => $parent,
            'joueurs' => $joueurs,
            'paiements' => $paiements,
            'notifications' => $notifications,
        ]);
    }

    // === JOUEURS ===
    public function showJoueur(Joueur $joueur)
    {
        abort_unless($joueur->parent_id === auth()->id(), 403);

        $joueur->load(
            'categorie',
            'groupe.coach',
            'evaluations.coach',
            'presences.seance'
        );

        $seancesGroupe = $joueur->groupe
            ? $joueur->groupe->seances()->orderBy('date_seance', 'desc')->take(10)->get()
            : collect();

        return $this->success([
            'joueur' => $joueur,
            'seances_groupe' => $seancesGroupe,
        ]);
    }

    // === PAIEMENTS ===
    public function payer()
    {
        $parent    = auth()->user();
        $paiements = $parent->paiements()->latest()->get();
        $dernierPaiement = $paiements->first();
        $stripeKey = (string) config('services.stripe.key');

        return $this->success([
            'parent' => $parent,
            'paiements' => $paiements,
            'dernier_paiement' => $dernierPaiement,
            'stripe_key' => $stripeKey,
        ]);
    }

    public function createStripeIntent(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:1',
            'mois_concerne' => 'required|date_format:Y-m',
        ]);

        $parent = auth()->user();

        try {
            $stripeSecret = (string) config('services.stripe.secret');
            if ($stripeSecret === '') {
                throw new \RuntimeException('La cle Stripe secret est manquante dans le fichier .env.');
            }

            Stripe::setApiKey($stripeSecret);

            $intent = PaymentIntent::create([
                'amount' => (int) round(((float) $request->montant) * 100),
                'currency' => 'eur',
                'payment_method_types' => ['card'],
                'metadata' => [
                    'parent_id' => (string) $parent->id,
                    'mois_concerne' => $request->mois_concerne,
                ],
            ]);

            return response()->json([
                'client_secret' => $intent->client_secret,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Creation du paiement Stripe impossible: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function confirmStripeIntent(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'montant' => 'required|numeric|min:1',
            'mois_concerne' => 'required|date_format:Y-m',
        ]);

        $parent = auth()->user();

        try {
            $stripeSecret = (string) config('services.stripe.secret');
            if ($stripeSecret === '') {
                throw new \RuntimeException('La cle Stripe secret est manquante dans le fichier .env.');
            }

            Stripe::setApiKey($stripeSecret);

            $intent = PaymentIntent::retrieve($request->payment_intent_id);

            if (($intent->metadata->parent_id ?? null) !== (string) $parent->id) {
                return response()->json([
                    'message' => 'Paiement invalide pour cet utilisateur.',
                ], 403);
            }

            if (($intent->metadata->mois_concerne ?? null) !== $request->mois_concerne) {
                return response()->json([
                    'message' => 'Le mois de paiement ne correspond pas.',
                ], 422);
            }

            $statut = match ($intent->status) {
                // Parent payment is captured, but remains pending until admin validates it.
                'succeeded', 'processing', 'requires_capture' => 'pending',
                default => 'failed',
            };

            Paiement::updateOrCreate(
                ['stripe_transaction_id' => $intent->id],
                [
                    'montant' => $request->montant,
                    'mois_concerne' => $request->mois_concerne . '-01',
                    'statut' => $statut,
                    'parent_id' => $parent->id,
                ]
            );

            return response()->json([
                'message' => $statut === 'pending'
                    ? 'Paiement enregistre. En attente de validation par l\'administration.'
                    : 'Paiement refuse ou echoue.',
                'statut' => $statut,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Confirmation Stripe impossible: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function storePaiement(Request $request)
    {
        $request->validate([
            'montant'       => 'required|numeric|min:1',
            'mois_concerne' => 'required|date_format:Y-m',
        ]);

        $parent = auth()->user();

        try {
            $stripeSecret = (string) config('services.stripe.secret');
            if ($stripeSecret === '') {
                throw new \RuntimeException('La cle Stripe secret est manquante dans le fichier .env.');
            }

            Stripe::setApiKey($stripeSecret);

            // Use Stripe's test payment method to simulate a successful card payment.
            $intent = PaymentIntent::create([
                'amount' => (int) round(((float) $request->montant) * 100),
                'currency' => 'eur',
                'payment_method_types' => ['card'],
                'payment_method' => 'pm_card_visa',
                'confirm' => true,
                'metadata' => [
                    'parent_id' => (string) $parent->id,
                    'mois_concerne' => $request->mois_concerne,
                ],
            ]);

            Paiement::create([
                'montant'               => $request->montant,
                'mois_concerne'         => $request->mois_concerne . '-01',
                'statut'                => $intent->status === 'succeeded' ? 'pending' : 'failed',
                'stripe_transaction_id' => $intent->id,
                'parent_id'             => $parent->id,
            ]);

            return $this->success([], 'Paiement enregistre. En attente de validation par l\'administration.', 201);
        } catch (\Throwable $e) {
            Paiement::create([
                'montant'               => $request->montant,
                'mois_concerne'         => $request->mois_concerne . '-01',
                'statut'                => 'failed',
                'stripe_transaction_id' => null,
                'parent_id'             => $parent->id,
            ]);

            return $this->error('Paiement Stripe test echoue: ' . $e->getMessage(), 422);
        }
    }
}
