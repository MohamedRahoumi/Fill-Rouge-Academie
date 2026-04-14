@extends('layouts.app')
@section('title', 'Paiements - MiniFoot Academy')
@section('page-title', 'Gestion des paiements')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="text-2xl font-black text-emerald-600">{{ number_format($paiements->where('statut', 'paid')->sum('montant'), 2) }} EUR</div>
        <div class="text-sm font-semibold text-slate-600">Total paye</div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="text-2xl font-black text-amber-600">{{ number_format($paiements->where('statut', 'pending')->sum('montant'), 2) }} EUR</div>
        <div class="text-sm font-semibold text-slate-600">En attente</div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="text-2xl font-black text-slate-800">{{ $paiements->count() }}</div>
        <div class="text-sm font-semibold text-slate-600">Transactions</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Effectuer un paiement</h3>
        </div>
        <form id="stripe-payment-form" class="p-6 space-y-5">
            @csrf

            @if($errors->has('stripe'))
                <div class="rounded-xl border border-red-200 bg-red-50 text-red-700 text-sm px-4 py-3">
                    {{ $errors->first('stripe') }}
                </div>
            @endif

            <div class="rounded-xl border border-blue-200 bg-blue-50 text-blue-700 text-sm px-4 py-3">
                Paiement Stripe Elements (test): utilise la carte 4242 4242 4242 4242, date 12/34, CVC 123.
            </div>

            <div>
                <label for="montant" class="block text-sm font-semibold text-slate-700 mb-2">Montant (EUR)</label>
                <input id="montant" type="number" min="1" step="0.01" name="montant" value="{{ old('montant') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-400" placeholder="150.00" required>
            </div>

            <div>
                <label for="mois_concerne" class="block text-sm font-semibold text-slate-700 mb-2">Mois concerne</label>
                <input id="mois_concerne" type="month" name="mois_concerne" value="{{ old('mois_concerne', now()->format('Y-m')) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-400" required>
            </div>

            <div>
                <label for="card-element" class="block text-sm font-semibold text-slate-700 mb-2">Carte bancaire</label>
                <div id="card-element" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm text-slate-700"></div>
                <p class="mt-2 text-xs text-slate-500">Carte test recommandee: 4242 4242 4242 4242</p>
            </div>

            <div id="stripe-error" class="hidden rounded-xl border border-red-200 bg-red-50 text-red-700 text-sm px-4 py-3"></div>
            <div id="stripe-success" class="hidden rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 text-sm px-4 py-3"></div>

            <button id="stripe-submit" type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Payer maintenant</button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Historique des paiements</h3>
        </div>
        <div class="overflow-x-auto">
            @if($paiements->isEmpty())
                <p class="px-6 py-8 text-sm text-slate-500">Aucun paiement enregistre.</p>
            @else
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Montant</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mois</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Reference</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($paiements as $p)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3 text-sm font-semibold text-slate-800">{{ number_format($p->montant, 2) }} EUR</td>
                                <td class="px-6 py-3 text-sm text-slate-600">{{ $p->mois_concerne?->format('M Y') ?? '-' }}</td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $p->statut === 'paid' ? 'bg-emerald-100 text-emerald-700' : ($p->statut === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $p->statut_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-xs font-mono text-slate-500">{{ $p->stripe_transaction_id ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
(() => {
    const stripeKey = @json($stripeKey ?? '');
    const form = document.getElementById('stripe-payment-form');
    const submitBtn = document.getElementById('stripe-submit');
    const errorBox = document.getElementById('stripe-error');
    const successBox = document.getElementById('stripe-success');
    const csrf = form.querySelector('input[name="_token"]').value;

    const showError = (message) => {
        errorBox.textContent = message;
        errorBox.classList.remove('hidden');
        successBox.classList.add('hidden');
    };

    const showSuccess = (message) => {
        successBox.textContent = message;
        successBox.classList.remove('hidden');
        errorBox.classList.add('hidden');
    };

    if (!stripeKey) {
        showError('Cle Stripe publique manquante. Verifie STRIPE_KEY dans .env.');
        submitBtn.disabled = true;
        return;
    }

    const stripe = Stripe(stripeKey);
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        hidePostalCode: false,
    });
    cardElement.mount('#card-element');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        submitBtn.disabled = true;
        submitBtn.textContent = 'Paiement en cours...';
        errorBox.classList.add('hidden');
        successBox.classList.add('hidden');

        const montant = document.getElementById('montant').value;
        const moisConcerne = document.getElementById('mois_concerne').value;

        try {
            const intentResponse = await fetch(@json(route('parent.paiement.intent')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    montant: montant,
                    mois_concerne: moisConcerne,
                }),
            });

            const intentData = await intentResponse.json();
            if (!intentResponse.ok || !intentData.client_secret) {
                throw new Error(intentData.message || 'Impossible de creer le paiement Stripe.');
            }

            const confirmResult = await stripe.confirmCardPayment(intentData.client_secret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: @json(($parent->prenom ?? '') . ' ' . ($parent->nom ?? '')),
                    },
                },
            });

            if (confirmResult.error) {
                throw new Error(confirmResult.error.message || 'Le paiement Stripe a echoue.');
            }

            const paymentIntentId = confirmResult.paymentIntent && confirmResult.paymentIntent.id
                ? confirmResult.paymentIntent.id
                : null;

            if (!paymentIntentId) {
                throw new Error('Reference du paiement Stripe manquante.');
            }

            const saveResponse = await fetch(@json(route('parent.paiement.confirm')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    payment_intent_id: paymentIntentId,
                    montant: montant,
                    mois_concerne: moisConcerne,
                }),
            });

            const saveData = await saveResponse.json();
            if (!saveResponse.ok) {
                throw new Error(saveData.message || 'Le paiement a ete accepte, mais la sauvegarde a echoue.');
            }

            showSuccess(saveData.message || 'Paiement effectue avec succes.');
            setTimeout(() => {
                window.location.reload();
            }, 1200);
        } catch (error) {
            showError(error.message || 'Une erreur est survenue pendant le paiement.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Payer maintenant';
        }
    });
})();
</script>
@endsection
