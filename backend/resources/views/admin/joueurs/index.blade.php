@extends('layouts.app')

@section('title', 'Gestion des Joueurs — MiniFoot Academy')
@section('page-title', 'Gestion des Joueurs')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-futbol text-amber-600 text-lg"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Liste des joueurs</h2>
                    <p class="text-sm text-slate-500">Modifier ou supprimer les profils joueurs</p>
                </div>
            </div>
            <a href="{{ route('admin.joueurs.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition-all">
                <i class="fas fa-plus text-xs"></i>
                Nouveau joueur
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            @if($joueurs->isEmpty())
                <div class="text-center px-6 py-14">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 mx-auto mb-3 flex items-center justify-center">
                        <i class="fas fa-child text-2xl"></i>
                    </div>
                    <p class="text-slate-500 font-medium">Aucun joueur enregistre</p>
                    <p class="text-sm text-slate-400 mt-1">Commencez par creer le premier joueur.</p>
                </div>
            @else
                <table class="w-full min-w-[860px]">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Joueur</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Age</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Parent</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Categorie</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Groupe</th>
                            <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($joueurs as $joueur)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-700 font-bold flex items-center justify-center text-xs">
                                        {{ strtoupper(substr($joueur->prenom, 0, 1)) }}{{ strtoupper(substr($joueur->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">{{ $joueur->prenom }} {{ $joueur->nom }}</p>
                                        <p class="text-xs text-slate-500">Ne le: {{ optional($joueur->date_naissance)->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-700">{{ $joueur->age }} ans</td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-700">{{ $joueur->parent->prenom ?? '-' }} {{ $joueur->parent->nom ?? '' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($joueur->categorie)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">{{ $joueur->categorie->nom }}</span>
                                @else
                                    <span class="text-xs text-slate-400">Non definie</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($joueur->groupe)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">{{ $joueur->groupe->nom }}</span>
                                @else
                                    <span class="text-xs text-slate-400">Non assigne</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition-all">
                                        <i class="fas fa-pen text-[10px]"></i>
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('admin.joueurs.destroy', $joueur) }}" onsubmit="return confirm('Supprimer ce joueur ? Cette action est irreversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 text-xs font-semibold transition-all">
                                            <i class="fas fa-trash text-[10px]"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @if($joueurs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/70">
                {{ $joueurs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
