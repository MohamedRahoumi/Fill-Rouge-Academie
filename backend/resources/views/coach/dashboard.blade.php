@extends('layouts.app')
@section('title', 'Dashboard Coach — MiniFoot Academy')
@section('page-title', 'Espace Coach')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                <i class="fas fa-users text-amber-600"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $groupes->count() }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Groupes gérés</div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                <i class="fas fa-futbol text-emerald-600"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $groupes->sum(fn($g) => $g->joueurs->count()) }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Joueurs suivis</div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <i class="fas fa-calendar-day text-blue-600"></i>
            </div>
            <span class="text-2xl font-black text-slate-800">{{ $prochainesSeances->count() }}</span>
        </div>
        <div class="text-sm font-semibold text-slate-600">Séances à venir</div>
    </div>

    <div class="bg-linear-to-br from-emerald-500 to-emerald-600 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                <i class="fas fa-user text-white"></i>
            </div>
            <span class="text-xl font-black text-white">{{ auth()->user()->prenom }}</span>
        </div>
        <div class="text-sm font-semibold text-white/90">Coach connecté</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-users text-amber-500"></i>
                <h3 class="font-bold text-slate-800">Mes groupes</h3>
            </div>
            <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full">{{ $groupes->count() }}</span>
        </div>
        <div class="p-5">
            @if($groupes->isEmpty())
                <p class="text-sm text-slate-500">Aucun groupe assigné pour le moment.</p>
            @else
                <div class="space-y-3">
                    @foreach($groupes as $groupe)
                        <a href="{{ route('coach.groupes.show', $groupe) }}" class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 hover:bg-white hover:border-amber-200 transition-all">
                            <div>
                                <div class="text-sm font-bold text-slate-800">{{ $groupe->nom }}</div>
                                <div class="text-xs text-slate-500">Catégorie: {{ $groupe->categorie->nom ?? '-' }}</div>
                            </div>
                            <span class="text-xs font-semibold bg-amber-100 text-amber-700 px-2.5 py-1 rounded-full">{{ $groupe->joueurs->count() }} joueurs</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
            <i class="fas fa-calendar-alt text-emerald-500"></i>
            <h3 class="font-bold text-slate-800">Prochaines séances</h3>
        </div>
        <div class="p-5">
            @if($prochainesSeances->isEmpty())
                <p class="text-sm text-slate-500">Aucune séance planifiée.</p>
            @else
                <div class="space-y-3">
                    @foreach($prochainesSeances as $seance)
                        <div class="rounded-xl border border-slate-200 p-4 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center justify-between gap-3 mb-2">
                                <div class="text-sm font-bold text-slate-800">{{ $seance->titre }}</div>
                                <a href="{{ route('coach.seances.appel', $seance) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-semibold hover:bg-emerald-100">
                                    <i class="fas fa-clipboard-check"></i> Appel
                                </a>
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $seance->date_seance->format('d/m/Y') }} | {{ substr($seance->heure_debut, 0, 5) }} - {{ substr($seance->heure_fin, 0, 5) }} | {{ $seance->groupe->nom }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


