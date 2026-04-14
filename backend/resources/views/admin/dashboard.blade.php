@extends('layouts.app')

@section('title', 'Dashboard Admin — MiniFoot Academy')
@section('page-title', 'Tableau de bord')
@section('topbar_actions')
    <span id="adminStatsToggle" role="button" tabindex="0" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100 cursor-pointer transition-colors">
        <i class="fas fa-chart-column text-[11px]"></i>
        Vue complete de gestion
    </span>
@endsection

@section('content')

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5 mb-8">
    <!-- Stats Card - Coachs -->
    <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-all hover:-translate-y-0.5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                <i class="fas fa-chalkboard-user text-emerald-600 text-lg"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $stats['coachs'] }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Coachs</div>
        <div class="text-xs text-slate-400 mt-1">Encadrants techniques</div>
    </div>

    <!-- Stats Card - Parents -->
    <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-all hover:-translate-y-0.5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-lg"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $stats['parents'] }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Parents</div>
        <div class="text-xs text-slate-400 mt-1">Tuteurs légaux</div>
    </div>

    <!-- Stats Card - Joueurs -->
    <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-all hover:-translate-y-0.5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                <i class="fas fa-futbol text-amber-600 text-lg"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $stats['joueurs'] }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Joueurs</div>
        <div class="text-xs text-slate-400 mt-1">Jeunes talents</div>
    </div>

    <!-- Stats Card - Groupes -->
    <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-all hover:-translate-y-0.5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                <i class="fas fa-layer-group text-purple-600 text-lg"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $stats['groupes'] }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Groupes</div>
        <div class="text-xs text-slate-400 mt-1">Sections d'entraînement</div>
    </div>

    <!-- Stats Card - Catégories -->
    <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-all hover:-translate-y-0.5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                <i class="fas fa-tags text-indigo-600 text-lg"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $stats['categories'] }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Catégories</div>
        <div class="text-xs text-slate-400 mt-1">U9, U11, U13...</div>
    </div>

    <!-- Stats Card - Revenus -->
    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-5 hover:shadow-lg transition-all hover:-translate-y-0.5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                <i class="fas fa-euro-sign text-white text-lg"></i>
            </div>
            <span class="text-2xl font-black text-white">{{ number_format($stats['paiements'], 0, ',', ' ') }} €</span>
        </div>
        <div class="text-sm font-semibold text-white/90">Revenus totaux</div>
        <div class="text-xs text-white/70 mt-1">Paiements validés</div>
    </div>
</div>

<!-- Deux colonnes principales -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    <!-- Derniers Paiements -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-credit-card text-emerald-500 text-lg"></i>
                <h3 class="font-bold text-slate-800">Derniers paiements</h3>
            </div>
            <a href="{{ route('admin.paiements.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition-colors flex items-center gap-1">
                Voir tout
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            @if($recentPaiements->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-receipt text-slate-300 text-4xl mb-3"></i>
                    <p class="text-slate-400 text-sm">Aucun paiement enregistré</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Parent</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Montant</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentPaiements as $p)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600">
                                        {{ strtoupper(substr($p->parent->prenom ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-slate-700">{{ $p->parent->prenom ?? '?' }} {{ $p->parent->nom ?? '' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3">
                                <span class="text-sm font-bold text-slate-800">{{ number_format($p->montant, 2) }} €</span>
                            </td>
                            <td class="px-6 py-3">
                                @if($p->statut === 'paid')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                        <i class="fas fa-check-circle text-[10px]"></i> Payé
                                    </span>
                                @elseif($p->statut === 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                        <i class="fas fa-clock text-[10px]"></i> En attente
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        <i class="fas fa-times-circle text-[10px]"></i> Échoué
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Actions Rapides -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <i class="fas fa-bolt text-amber-500 text-lg"></i>
                <h3 class="font-bold text-slate-800">Actions rapides</h3>
            </div>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="{{ route('admin.coachs.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-200 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                        <i class="fas fa-chalkboard-user text-emerald-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-700">Ajouter un coach</div>
                        <div class="text-xs text-slate-400">Encadrant technique</div>
                    </div>
                </a>

                <a href="{{ route('admin.parents.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-users text-blue-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-700">Ajouter un parent</div>
                        <div class="text-xs text-slate-400">Tuteur légal</div>
                    </div>
                </a>

                <a href="{{ route('admin.joueurs.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 hover:bg-amber-50 border border-slate-200 hover:border-amber-200 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                        <i class="fas fa-futbol text-amber-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-700">Ajouter un joueur</div>
                        <div class="text-xs text-slate-400">Jeune talent</div>
                    </div>
                </a>

                <a href="{{ route('admin.groupes.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200 hover:border-purple-200 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-purple-100 flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <i class="fas fa-layer-group text-purple-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-700">Créer un groupe</div>
                        <div class="text-xs text-slate-400">Section d'entraînement</div>
                    </div>
                </a>

                <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                        <i class="fas fa-tags text-indigo-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-700">Créer une catégorie</div>
                        <div class="text-xs text-slate-400">U9, U11, U13...</div>
                    </div>
                </a>

                <a href="{{ route('admin.notifications.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 hover:bg-rose-50 border border-slate-200 hover:border-rose-200 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-rose-100 flex items-center justify-center group-hover:bg-rose-200 transition-colors">
                        <i class="fas fa-bell text-rose-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-700">Envoyer une notification</div>
                        <div class="text-xs text-slate-400">Communication</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Gestion complète -->
<div id="admin-gestion-panel" class="hidden bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
        <i class="fas fa-table-list text-slate-500 text-lg"></i>
        <h3 class="font-bold text-slate-800">Vue complète de gestion</h3>
    </div>

    <div class="p-6 grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h4 class="font-semibold text-slate-800">Catégories</h4>
                <span class="text-xs font-semibold bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full">{{ $allCategories->count() }}</span>
            </div>
            <div class="max-h-72 overflow-auto">
                <table class="w-full">
                    <thead class="bg-slate-50/60">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Nom</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Groupes</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Joueurs</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($allCategories as $cat)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm font-medium text-slate-700">{{ $cat->nom }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $cat->groupes_count }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $cat->joueurs_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-4 text-sm text-slate-400">Aucune catégorie.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h4 class="font-semibold text-slate-800">Groupes</h4>
                <span class="text-xs font-semibold bg-purple-100 text-purple-700 px-2 py-1 rounded-full">{{ $allGroupes->count() }}</span>
            </div>
            <div class="max-h-72 overflow-auto">
                <table class="w-full">
                    <thead class="bg-slate-50/60">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Nom</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Catégorie</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Coach</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Joueurs</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($allGroupes as $g)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm font-medium text-slate-700">{{ $g->nom }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $g->categorie->nom ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $g->coach ? $g->coach->prenom . ' ' . $g->coach->nom : '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $g->joueurs_count }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.groupes.edit', $g) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100">
                                            <i class="fas fa-pen text-[10px]"></i> Modifier
                                        </a>
                                        <form method="POST" action="{{ route('admin.groupes.destroy', $g) }}" onsubmit="return confirm('Supprimer ce groupe ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-red-200 bg-red-50 text-xs font-semibold text-red-700 hover:bg-red-100">
                                                <i class="fas fa-trash text-[10px]"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-4 text-sm text-slate-400">Aucun groupe.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 overflow-hidden xl:col-span-2">
            <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h4 class="font-semibold text-slate-800">Joueurs</h4>
                <span class="text-xs font-semibold bg-amber-100 text-amber-700 px-2 py-1 rounded-full">{{ $allJoueurs->count() }}</span>
            </div>
            <div class="max-h-72 overflow-auto">
                <table class="w-full min-w-[900px]">
                    <thead class="bg-slate-50/60">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Joueur</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Parent</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Catégorie</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Groupe</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Date naissance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($allJoueurs as $j)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm font-medium text-slate-700">{{ $j->prenom }} {{ $j->nom }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $j->parent ? $j->parent->prenom . ' ' . $j->parent->nom : '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $j->categorie->nom ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $j->groupe->nom ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ optional($j->date_naissance)->format('d/m/Y') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-4 text-sm text-slate-400">Aucun joueur.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h4 class="font-semibold text-slate-800">Coachs</h4>
                <span class="text-xs font-semibold bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full">{{ $allCoachs->count() }}</span>
            </div>
            <div class="max-h-72 overflow-auto">
                <table class="w-full">
                    <thead class="bg-slate-50/60">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Nom</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Groupes</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($allCoachs as $c)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm font-medium text-slate-700">{{ $c->prenom }} {{ $c->nom }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $c->email }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $c->groupes_geres_count }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.coachs.edit', $c) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100">
                                            <i class="fas fa-pen text-[10px]"></i> Modifier
                                        </a>
                                        <form method="POST" action="{{ route('admin.coachs.destroy', $c) }}" onsubmit="return confirm('Supprimer ce coach ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-red-200 bg-red-50 text-xs font-semibold text-red-700 hover:bg-red-100">
                                                <i class="fas fa-trash text-[10px]"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-4 text-sm text-slate-400">Aucun coach.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h4 class="font-semibold text-slate-800">Parents</h4>
                <span class="text-xs font-semibold bg-blue-100 text-blue-700 px-2 py-1 rounded-full">{{ $allParents->count() }}</span>
            </div>
            <div class="max-h-72 overflow-auto">
                <table class="w-full">
                    <thead class="bg-slate-50/60">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Nom</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Enfants</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-slate-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($allParents as $p)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm font-medium text-slate-700">{{ $p->prenom }} {{ $p->nom }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $p->email }}</td>
                                <td class="px-4 py-2 text-sm text-slate-600">{{ $p->joueurs_count }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.parents.edit', $p) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100">
                                            <i class="fas fa-pen text-[10px]"></i> Modifier
                                        </a>
                                        <form method="POST" action="{{ route('admin.parents.destroy', $p) }}" onsubmit="return confirm('Supprimer ce parent ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-red-200 bg-red-50 text-xs font-semibold text-red-700 hover:bg-red-100">
                                                <i class="fas fa-trash text-[10px]"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-4 text-sm text-slate-400">Aucun parent.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (() => {
        const toggle = document.getElementById('adminStatsToggle');
        const panel = document.getElementById('admin-gestion-panel');

        if (!toggle || !panel) {
            return;
        }

        const togglePanel = () => {
            panel.classList.toggle('hidden');
            if (!panel.classList.contains('hidden')) {
                panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };

        toggle.addEventListener('click', togglePanel);
        toggle.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                togglePanel();
            }
        });
    })();
</script>
@endpush

@endsection
