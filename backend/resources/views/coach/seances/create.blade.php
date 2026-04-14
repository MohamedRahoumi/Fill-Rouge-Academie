@extends('layouts.app')

@section('title', 'Planifier une seance - MiniFoot Academy')
@section('page-title', 'Planifier une seance')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-800">Nouvelle seance</h2>
                <p class="text-sm text-slate-500">Groupe: {{ $groupe->nom }}</p>
            </div>
            <a href="{{ route('coach.groupes.show', $groupe) }}" class="px-3 py-2 rounded-lg border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50">Retour</a>
        </div>

        <form method="POST" action="{{ route('coach.seances.store', $groupe) }}" class="p-6 space-y-5">
            @csrf

            <div>
                <label for="titre" class="block text-sm font-semibold text-slate-700 mb-2">Titre</label>
                <input id="titre" type="text" name="titre" value="{{ old('titre') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400" placeholder="Ex: Seance technique" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="date_seance" class="block text-sm font-semibold text-slate-700 mb-2">Date</label>
                    <input id="date_seance" type="date" name="date_seance" value="{{ old('date_seance') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400" required>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="heure_debut" class="block text-sm font-semibold text-slate-700 mb-2">Debut</label>
                        <input id="heure_debut" type="time" name="heure_debut" value="{{ old('heure_debut') }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400" required>
                    </div>
                    <div>
                        <label for="heure_fin" class="block text-sm font-semibold text-slate-700 mb-2">Fin</label>
                        <input id="heure_fin" type="time" name="heure_fin" value="{{ old('heure_fin') }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400" required>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">Enregistrer la seance</button>
                <a href="{{ route('coach.groupes.show', $groupe) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
