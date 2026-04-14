@extends('layouts.app')

@section('title', "Faire l'appel - {{ $seance->titre }}")
@section('page-title', 'Appel seance')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800">{{ $seance->titre }}</h2>
                <p class="text-sm text-slate-500">
                    {{ $seance->groupe->nom }} | {{ $seance->date_seance->format('d/m/Y') }} | {{ substr($seance->heure_debut, 0, 5) }} - {{ substr($seance->heure_fin, 0, 5) }}
                </p>
            </div>
            <a href="{{ route('coach.groupes.show', $seance->groupe) }}" class="px-3 py-2 rounded-lg border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50">Retour groupe</a>
        </div>
    </div>

    <form method="POST" action="{{ route('coach.seances.storeAppel', $seance) }}" class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        @csrf
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Liste des joueurs</h3>
            <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">{{ $joueurs->count() }} joueurs</span>
        </div>

        <div class="overflow-x-auto">
            @if($joueurs->isEmpty())
                <p class="px-6 py-8 text-sm text-slate-500">Aucun joueur dans ce groupe.</p>
            @else
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Joueur</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Present</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Motif d'absence</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Evaluation seance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($joueurs as $joueur)
                            @php
                                $presence = $presences[$joueur->id] ?? null;
                                $estPresent = $presence ? $presence->est_present : true;
                                $evaluationSeance = $evaluationsSeance[$joueur->id] ?? null;
                            @endphp
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3">
                                    <div class="text-sm font-semibold text-slate-800">{{ $joueur->prenom }} {{ $joueur->nom }}</div>
                                    <div class="text-xs text-slate-500">{{ $joueur->age }} ans</div>
                                </td>
                                <td class="px-6 py-3">
                                    <label class="inline-flex items-center gap-2 text-sm text-slate-700 font-medium">
                                        <input type="checkbox" name="presences[]" value="{{ $joueur->id }}" {{ $estPresent ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                        Present
                                    </label>
                                </td>
                                <td class="px-6 py-3">
                                    <input type="text" name="motifs[{{ $joueur->id }}]" value="{{ $presence && !$presence->est_present ? $presence->motif_absence : '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-400" placeholder="Renseigner si absent">
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('coach.seances.evaluations.create', [$seance, $joueur]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-amber-200 bg-amber-50 text-xs font-semibold text-amber-700 hover:bg-amber-100">
                                            <i class="fas fa-clipboard-check"></i>
                                            {{ $evaluationSeance ? 'Modifier' : 'Evaluer' }}
                                        </a>
                                        @if($evaluationSeance)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                                {{ $evaluationSeance->note }}/10
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="px-6 py-4 border-t border-slate-100">
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">Enregistrer l'appel</button>
        </div>
    </form>
</div>
@endsection
