@extends('layouts.app')

@section('title', 'Paiements - MiniFoot Academy')
@section('page-title', 'Historique des paiements')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-2">
            <i class="fas fa-credit-card text-emerald-500"></i>
            <h2 class="text-base font-bold text-slate-800">Tous les paiements</h2>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
            {{ $paiements->total() }} paiements
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[900px]">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Parent</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Montant</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mois</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Reference Stripe</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($paiements as $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3 text-xs font-semibold text-slate-400">{{ $p->id }}</td>
                        <td class="px-6 py-3">
                            <div class="text-sm font-semibold text-slate-800">{{ $p->parent->prenom }} {{ $p->parent->nom }}</div>
                            <div class="text-xs text-slate-500">{{ $p->parent->email }}</div>
                        </td>
                        <td class="px-6 py-3 text-sm font-bold text-slate-800">{{ number_format($p->montant, 2) }} EUR</td>
                        <td class="px-6 py-3 text-sm text-slate-600">{{ $p->mois_concerne->format('M Y') }}</td>
                        <td class="px-6 py-3">
                            @if($p->statut === 'paid')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <i class="fas fa-check-circle text-[10px]"></i> {{ $p->statut_label }}
                                </span>
                            @elseif($p->statut === 'pending')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                    <i class="fas fa-clock text-[10px]"></i> {{ $p->statut_label }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="fas fa-times-circle text-[10px]"></i> {{ $p->statut_label }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-xs font-mono text-slate-500">{{ $p->stripe_transaction_id ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-slate-500">{{ $p->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-3 text-right">
                            @if($p->statut === 'pending')
                                <form method="POST" action="{{ route('admin.paiements.valider', $p) }}" onsubmit="return confirm('Valider ce paiement et notifier le parent ?');" class="inline-block">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 text-xs font-semibold hover:bg-emerald-100 transition-colors">
                                        <i class="fas fa-check"></i> Valider
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-sm text-slate-400">Aucun paiement enregistre.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-slate-100">
        {{ $paiements->links() }}
    </div>
</div>
@endsection
