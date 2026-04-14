@extends('layouts.app')
@section('title', 'Dashboard Parent - MiniFoot Academy')
@section('page-title', 'Espace parent')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                <i class="fas fa-child text-emerald-600"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $joueurs->count() }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Enfants inscrits</div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                <i class="fas fa-clipboard-check text-amber-600"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $joueurs->sum(fn($j) => $j->evaluations->count()) }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Evaluations</div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <i class="fas fa-credit-card text-blue-600"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $paiements->where('statut', 'paid')->count() }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Paiements valides</div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center">
                <i class="fas fa-bell text-rose-600"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $notifications->count() }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Notifications non lues</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Mes enfants</h3>
            <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">{{ $joueurs->count() }}</span>
        </div>
        <div class="p-5">
            @if($joueurs->isEmpty())
                <p class="text-sm text-slate-500">Aucun enfant inscrit.</p>
            @else
                <div class="space-y-3">
                    @foreach($joueurs as $joueur)
                        <a href="{{ route('parent.joueurs.show', $joueur) }}" class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 hover:bg-white hover:border-emerald-200 transition-all">
                            <div>
                                <div class="text-sm font-bold text-slate-800">{{ $joueur->prenom }} {{ $joueur->nom }}</div>
                                <div class="text-xs text-slate-500">{{ $joueur->age }} ans | {{ $joueur->categorie->nom ?? '-' }}</div>
                            </div>
                            <span class="text-xs font-semibold bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-full">{{ $joueur->evaluations->count() }} eval.</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-800">Prochaines seances</h3>
            </div>
            <div class="p-5">
                @php
                    $seancesAvenir = collect();
                    foreach ($joueurs as $j) {
                        if ($j->groupe) {
                            foreach ($j->groupe->seances->where('date_seance', '>=', now()->toDateString())->take(3) as $s) {
                                $seancesAvenir->push(['seance' => $s, 'joueur' => $j]);
                            }
                        }
                    }
                    $seancesAvenir = $seancesAvenir->sortBy(fn($item) => $item['seance']->date_seance)->take(5);
                @endphp

                @if($seancesAvenir->isEmpty())
                    <p class="text-sm text-slate-500">Aucune seance a venir.</p>
                @else
                    <div class="space-y-3">
                        @foreach($seancesAvenir as $item)
                            <div class="rounded-xl border border-slate-200 p-3 hover:bg-slate-50 transition-colors">
                                <div class="text-sm font-semibold text-slate-800">{{ $item['seance']->titre }}</div>
                                <div class="text-xs text-slate-500 mt-1">
                                    {{ $item['seance']->date_seance->format('d/m/Y') }} | {{ substr($item['seance']->heure_debut, 0, 5) }} - {{ substr($item['seance']->heure_fin, 0, 5) }} | {{ $item['joueur']->prenom }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Derniers paiements</h3>
                <a href="{{ route('parent.paiement') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Voir tout</a>
            </div>
            <div class="p-5">
                @if($paiements->isEmpty())
                    <p class="text-sm text-slate-500">Aucun paiement enregistre.</p>
                @else
                    <div class="space-y-2">
                        @foreach($paiements->take(5) as $p)
                            <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-b-0">
                                <div class="text-sm text-slate-700">{{ number_format($p->montant, 2) }} EUR - {{ $p->mois_concerne?->format('M Y') ?? '-' }}</div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $p->statut === 'paid' ? 'bg-emerald-100 text-emerald-700' : ($p->statut === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $p->statut_label }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Notifications recentes</h3>
                <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">{{ $notifications->count() }}</span>
            </div>
            <div class="p-5">
                @if($notifications->isEmpty())
                    <p class="text-sm text-slate-500">Aucune nouvelle notification.</p>
                @else
                    <div class="space-y-3">
                        @foreach($notifications->take(5) as $notification)
                            <div class="rounded-xl border border-slate-200 p-3 hover:bg-slate-50 transition-colors">
                                <div class="text-sm font-semibold text-slate-800">{{ $notification->titre }}</div>
                                <div class="text-xs text-slate-500 mt-1">{{ $notification->message }}</div>
                                <div class="text-[11px] text-slate-400 mt-2">
                                    {{ $notification->created_at->format('d/m/Y H:i') }}
                                    @if($notification->expediteur)
                                        | Par {{ $notification->expediteur->prenom }} {{ $notification->expediteur->nom }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
