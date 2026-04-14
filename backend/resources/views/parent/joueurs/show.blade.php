@extends('layouts.app')
@section('title', $joueur->prenom . ' ' . $joueur->nom . ' - MiniFoot Academy')
@section('page-title', 'Profil joueur')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $joueur->prenom }} {{ $joueur->nom }}</h2>
                <p class="text-sm text-slate-500">{{ $joueur->age }} ans | {{ $joueur->categorie->nom ?? '-' }} @if($joueur->groupe) | {{ $joueur->groupe->nom }} @endif</p>
            </div>
            <a href="{{ route('parent.dashboard') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50 w-fit">Retour</a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="text-2xl font-black text-slate-800">{{ $joueur->evaluations->count() }}</div>
            <div class="text-sm font-semibold text-slate-600">Evaluations</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="text-2xl font-black text-slate-800">{{ $joueur->evaluations->count() > 0 ? number_format($joueur->evaluations->avg('note'), 1) : '-' }}</div>
            <div class="text-sm font-semibold text-slate-600">Moyenne /10</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="text-2xl font-black text-emerald-600">{{ $joueur->presences->where('est_present', true)->count() }}</div>
            <div class="text-sm font-semibold text-slate-600">Presences</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="text-2xl font-black text-red-600">{{ $joueur->presences->where('est_present', false)->count() }}</div>
            <div class="text-sm font-semibold text-slate-600">Absences</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Evaluations</h3>
                <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">{{ $joueur->evaluations->count() }}</span>
            </div>
            <div class="p-5">
                @if($joueur->evaluations->isEmpty())
                    <p class="text-sm text-slate-500">Aucune evaluation pour le moment.</p>
                @else
                    <div class="space-y-3">
                        @foreach($joueur->evaluations->sortByDesc('date_evaluation') as $eval)
                            <div class="rounded-xl border border-slate-200 p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="text-xs text-slate-500">{{ $eval->date_evaluation->format('d/m/Y') }} @if($eval->coach) | {{ $eval->coach->prenom }} @endif</div>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $eval->note >= 8 ? 'bg-emerald-100 text-emerald-700' : ($eval->note >= 6 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">{{ $eval->note }}/10</span>
                                </div>
                                <p class="text-sm text-slate-600">{{ $eval->commentaire }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800">Presence et evaluation par seance</h3>
                    <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">{{ $seancesGroupe->count() }} seances</span>
                </div>
                <div class="overflow-x-auto">
                    @php
                        $presencesBySeance = $joueur->presences->keyBy('seance_id');
                        $evaluationsBySeance = $joueur->evaluations->whereNotNull('seance_id')->keyBy('seance_id');
                        $evaluationsByDate = $joueur->evaluations->groupBy(fn($e) => optional($e->date_evaluation)->format('Y-m-d'));
                    @endphp

                    @if($seancesGroupe->isEmpty())
                        <p class="px-6 py-8 text-sm text-slate-500">Aucune seance disponible.</p>
                    @else
                        <table class="w-full min-w-[760px]">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Seance</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Presence</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Evaluation</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($seancesGroupe as $seance)
                                    @php
                                        $presence = $presencesBySeance->get($seance->id);
                                        $evalDateKey = optional($seance->date_seance)->format('Y-m-d');
                                        $sessionEval = $evaluationsBySeance->get($seance->id);
                                        if (!$sessionEval) {
                                            $evalsForSession = $evaluationsByDate->get($evalDateKey, collect());
                                            $sessionEval = $evalsForSession->first();
                                        }
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-3 text-sm font-semibold text-slate-800">{{ $seance->titre }}</td>
                                        <td class="px-6 py-3 text-sm text-slate-600">{{ $seance->date_seance->format('d/m/Y') }}</td>
                                        <td class="px-6 py-3">
                                            @if($presence)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $presence->est_present ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                                    {{ $presence->est_present ? 'Present' : 'Absent' }}
                                                </span>
                                            @else
                                                <span class="text-xs text-slate-400">Non renseignee</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3">
                                            @if($sessionEval)
                                                <div class="text-sm font-semibold text-slate-800">{{ $sessionEval->note }}/10</div>
                                                <div class="text-xs text-slate-500">{{ $sessionEval->commentaire }}</div>
                                            @else
                                                <span class="text-xs text-slate-400">Pas d'evaluation</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">Planning des seances</h3>
                </div>
                <div class="p-5">
                    @if($seancesGroupe->isEmpty())
                        <p class="text-sm text-slate-500">Aucune seance planifiee.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($seancesGroupe as $seance)
                                <div class="rounded-xl border border-slate-200 p-3">
                                    <div class="text-sm font-semibold text-slate-800">{{ $seance->titre }}</div>
                                    <div class="text-xs text-slate-500 mt-1">{{ $seance->date_seance->format('d/m/Y') }} | {{ substr($seance->heure_debut, 0, 5) }} - {{ substr($seance->heure_fin, 0, 5) }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">Historique des presences</h3>
                </div>
                <div class="overflow-x-auto">
                    @if($joueur->presences->isEmpty())
                        <p class="px-6 py-8 text-sm text-slate-500">Aucune presence enregistree.</p>
                    @else
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Seance</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Motif</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($joueur->presences->sortByDesc(fn($p) => $p->seance->date_seance ?? now()) as $presence)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-3 text-sm text-slate-600">{{ $presence->seance->date_seance?->format('d/m/Y') ?? '-' }}</td>
                                        <td class="px-6 py-3 text-sm text-slate-600">{{ $presence->seance->titre ?? '-' }}</td>
                                        <td class="px-6 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $presence->est_present ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $presence->est_present ? 'Present' : 'Absent' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 text-sm text-slate-500">{{ $presence->motif_absence ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
