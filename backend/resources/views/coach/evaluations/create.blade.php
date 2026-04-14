@extends('layouts.app')

@section('title', 'Evaluer - {{ $joueur->prenom }} {{ $joueur->nom }}')
@section('page-title', 'Nouvelle evaluation')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-bold text-slate-800">Evaluation de {{ $joueur->prenom }} {{ $joueur->nom }}</h2>
            @if(isset($seance))
                <p class="text-xs text-slate-500 mt-1">Seance: {{ $seance->titre }} | {{ $seance->date_seance->format('d/m/Y') }}</p>
            @endif
        </div>

        <form method="POST" action="{{ isset($seance) ? route('coach.seances.evaluations.store', [$seance, $joueur]) : route('coach.evaluations.store', $joueur) }}" class="p-6 space-y-5">
            @csrf

            <div>
                <label for="date_evaluation" class="block text-sm font-semibold text-slate-700 mb-2">Date d'evaluation</label>
                @if(isset($seance))
                    <input id="date_evaluation" type="date" name="date_evaluation" value="{{ old('date_evaluation', $seance->date_seance->format('Y-m-d')) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-sm text-slate-700" readonly>
                @else
                    <input id="date_evaluation" type="date" name="date_evaluation" value="{{ old('date_evaluation', now()->toDateString()) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-400" required>
                @endif
            </div>

            <div>
                <label for="note" class="block text-sm font-semibold text-slate-700 mb-2">Note (1 a 10)</label>
                <input id="note" type="number" min="1" max="10" name="note" value="{{ old('note', $existingEvaluation->note ?? 5) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-400" required>
            </div>

            <div>
                <label for="commentaire" class="block text-sm font-semibold text-slate-700 mb-2">Commentaire</label>
                <textarea id="commentaire" name="commentaire" rows="6" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-400" placeholder="Progression technique, physique et comportementale" required>{{ old('commentaire', $existingEvaluation->commentaire ?? '') }}</textarea>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600">Enregistrer</button>
                @if(isset($seance))
                    <a href="{{ route('coach.seances.appel', $seance) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50">Retour seance</a>
                @elseif($joueur->groupe)
                    <a href="{{ route('coach.groupes.show', $joueur->groupe) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50">Annuler</a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Profil joueur</h3>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <div class="text-sm text-slate-500">Nom</div>
                <div class="text-sm font-semibold text-slate-800">{{ $joueur->prenom }} {{ $joueur->nom }}</div>
            </div>
            <div>
                <div class="text-sm text-slate-500">Age</div>
                <div class="text-sm font-semibold text-slate-800">{{ $joueur->age }} ans</div>
            </div>
            <div>
                <div class="text-sm text-slate-500">Categorie</div>
                <div class="text-sm font-semibold text-slate-800">{{ $joueur->categorie->nom ?? '-' }}</div>
            </div>
            <div>
                <div class="text-sm text-slate-500">Evaluations deja faites</div>
                <div class="text-sm font-semibold text-slate-800">{{ $joueur->evaluations->count() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
