@extends('layouts.app')

@section('title', 'Groupe - {{ $groupe->nom }} - MiniFoot')
@section('page-title', 'Details du groupe')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-800">{{ $groupe->nom }}</h2>
            <p class="text-sm text-slate-500">Categorie {{ $groupe->categorie->nom ?? '-' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('coach.dashboard') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-50">Retour</a>
            <a href="{{ route('coach.seances.create', $groupe) }}" class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">Nouvelle seance</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <div class="text-xs uppercase tracking-wider text-slate-500 font-semibold mb-2">Joueurs</div>
            <div class="text-2xl font-black text-slate-800">{{ $groupe->joueurs->count() }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <div class="text-xs uppercase tracking-wider text-slate-500 font-semibold mb-2">Seances</div>
            <div class="text-2xl font-black text-slate-800">{{ $groupe->seances->count() }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <div class="text-xs uppercase tracking-wider text-slate-500 font-semibold mb-2">Categorie</div>
            <div class="text-lg font-bold text-slate-800">{{ $groupe->categorie->nom ?? '-' }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Effectif du groupe</h3>
                <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">{{ $groupe->joueurs->count() }} joueurs</span>
            </div>

            <div class="overflow-x-auto">
                @if($groupe->joueurs->isEmpty())
                    <p class="px-6 py-8 text-sm text-slate-500">Aucun joueur assigne a ce groupe.</p>
                @else
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Joueur</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Age</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Evaluations</th>
                                <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($groupe->joueurs as $joueur)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="text-sm font-semibold text-slate-800">{{ $joueur->prenom }} {{ $joueur->nom }}</div>
                                        <div class="text-xs text-slate-500">Ne le {{ $joueur->date_naissance->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-slate-600">{{ $joueur->age }} ans</td>
                                    <td class="px-6 py-3 text-sm text-slate-600">{{ $joueur->evaluations->count() }}</td>
                                    <td class="px-6 py-3 text-right">
                                        <a href="{{ route('coach.evaluations.create', $joueur) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200">
                                            <i class="fas fa-clipboard-check"></i> Evaluer
                                        </a>
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
                <h3 class="font-bold text-slate-800">Assigner un joueur</h3>
            </div>
            <form method="POST" action="{{ route('coach.groupes.assignJoueur', $groupe) }}" class="p-6 space-y-4">
                @csrf
                <div>
                    <label for="joueur_id" class="block text-sm font-semibold text-slate-700 mb-2">Joueur</label>
                    <select id="joueur_id" name="joueur_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-400" required>
                        <option value="">Selectionner un joueur</option>
                        @foreach($joueursCategorie as $joueur)
                            <option value="{{ $joueur->id }}" {{ $joueur->groupe_id == $groupe->id ? 'disabled' : '' }}>
                                {{ $joueur->prenom }} {{ $joueur->nom }}
                                {{ $joueur->groupe_id == $groupe->id ? '(Deja dans ce groupe)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Confirmer</button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Planning des seances</h3>
            <a href="{{ route('coach.seances.create', $groupe) }}" class="text-sm font-semibold text-amber-600 hover:text-amber-700">+ Ajouter</a>
        </div>
        <div class="overflow-x-auto">
            @if($groupe->seances->isEmpty())
                <p class="px-6 py-8 text-sm text-slate-500">Aucune seance planifiee.</p>
            @else
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Titre</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Horaire</th>
                            <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($groupe->seances->sortByDesc('date_seance') as $seance)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3 text-sm font-semibold text-slate-800">{{ $seance->titre }}</td>
                                <td class="px-6 py-3 text-sm text-slate-600">{{ $seance->date_seance->format('d/m/Y') }}</td>
                                <td class="px-6 py-3 text-sm text-slate-600">{{ substr($seance->heure_debut, 0, 5) }} - {{ substr($seance->heure_fin, 0, 5) }}</td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('coach.seances.appel', $seance) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-amber-50 hover:text-amber-700 hover:border-amber-200">
                                        <i class="fas fa-clipboard-list"></i> Appel
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
