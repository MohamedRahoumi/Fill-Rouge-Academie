@extends('layouts.app')
@section('title', 'Envoyer une Notification — MiniFoot Academy')
@section('page-title', 'Envoyer une Notification')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-linear-to-r from-slate-50 to-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-bell text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Nouvelle Notification</h2>
                        <p class="text-sm text-slate-500 mt-0.5">Envoyer un message aux utilisateurs</p>
                    </div>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all text-sm font-medium">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Retour
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.notifications.store') }}" id="notif-form" class="p-6">
            @csrf

            <div class="grid grid-cols-1 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Titre</label>
                    <input type="text" name="titre" value="{{ old('titre') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all" placeholder="ex: Séance annulée ce vendredi" required>
                    @error('titre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Message</label>
                    <textarea name="message" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all" rows="5" placeholder="Rédigez votre message ici..." required>{{ old('message') }}</textarea>
                    @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Destinataires</label>
                    <select name="cible" id="cible-select" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all" onchange="toggleSpecific(this.value)">
                        <option value="all" {{ old('cible', 'all') === 'all' ? 'selected' : '' }}>🌐 Tous (coaches + parents)</option>
                        <option value="coaches" {{ old('cible') === 'coaches' ? 'selected' : '' }}>👨‍🏫 Tous les Coaches</option>
                        <option value="parents" {{ old('cible') === 'parents' ? 'selected' : '' }}>👨‍👩‍👧‍👦 Tous les Parents</option>
                        <option value="specific" {{ old('cible') === 'specific' ? 'selected' : '' }}>🎯 Sélection manuelle</option>
                    </select>
                </div>

                <div id="specific-users" style="display:{{ old('cible') === 'specific' ? 'block' : 'none' }};" class="mt-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Choisir les utilisateurs</label>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 max-h-56 overflow-y-auto w-full">
                        @foreach($destinataires as $u)
                        <label class="flex items-center gap-3 p-2 cursor-pointer rounded-lg hover:bg-slate-100 transition-colors">
                            <input type="checkbox" name="user_ids[]" value="{{ $u->id }}" {{ in_array($u->id, old('user_ids', [])) ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-500 border-slate-300">
                            <span class="text-sm font-medium text-slate-700">
                                {{ $u->prenom }} {{ $u->nom }}
                                <span class="text-xs text-slate-500 ml-1">({{ ucfirst($u->role) }})</span>
                            </span>
                        </label>
                        @endforeach
                    </div>
                    @error('user_ids') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3 mt-8 pt-4 border-t border-slate-100">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all">
                    Envoyer la Notification
                </button>
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl font-medium transition-all">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleSpecific(val) {
    document.getElementById('specific-users').style.display = val === 'specific' ? 'block' : 'none';
}
</script>
@endsection
