@extends('layouts.app')
@section('title', 'Ajouter un Coach — MiniFoot Academy')
@section('page-title', 'Ajouter un Coach')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-user-tie text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Nouveau Coach</h2>
                        <p class="text-sm text-slate-500 mt-0.5">Ajouter un nouveau coach à l'académie</p>
                    </div>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all text-sm font-medium">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Retour
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.coachs.store') }}" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2" for="prenom">Prénom</label>
                    <input id="prenom" type="text" name="prenom" value="{{ old('prenom') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all" placeholder="Jean" required>
                    @error('prenom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2" for="nom">Nom</label>
                    <input id="nom" type="text" name="nom" value="{{ old('nom') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all" placeholder="Dupont" required>
                    @error('nom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all" placeholder="coach@academie.com" required>
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2" for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all" placeholder="Min. 8 caractères" required>
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2" for="password_confirmation">Confirmer le mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all" required>
                </div>
            </div>

            <div class="flex gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all">
                    Créer le Coach
                </button>
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl font-medium transition-all">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
