@extends('layouts.app')
@section('title', 'Modifier Catégorie — MiniFoot Academy')
@section('page-title', 'Modifier une Catégorie')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-edit text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">{{ $categorie->nom }}</h2>
                        <p class="text-sm text-slate-500 mt-0.5">Modifier les informations de la catégorie</p>
                    </div>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all text-sm font-medium">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Retour
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.categories.update', $categorie) }}" class="p-6">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nom de la catégorie</label>
                    <input type="text" name="nom" value="{{ old('nom', $categorie->nom) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all" required>
                    @error('nom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                    <textarea name="description" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all" rows="3">{{ old('description', $categorie->description) }}</textarea>
                    @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all">
                    Enregistrer les modifications
                </button>
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl font-medium transition-all">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <form action="{{ route('admin.categories.destroy', $categorie) }}" method="POST" class="mt-4 text-center">
        @csrf @method('DELETE')
        <button type="submit" onclick="return confirm('Vraiment supprimer cette catégorie ?')" class="text-red-500 hover:text-red-700 text-sm font-medium transition-colors">
            <i class="fas fa-trash-alt mr-1"></i> Supprimer définitivement cette catégorie
        </button>
    </form>
</div>
@endsection
