<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'ok' => true,
        'message' => 'Backend API academie foot operationnel.',
    ]);
});

Route::get('/test', function () {
    return response()->json([
        'ok' => true,
        'service' => 'backend',
        'message' => 'API Laravel operationnelle',
        'timestamp' => now()->toIso8601String(),
    ]);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $route = match($user->role) {
            'superadmin' => 'admin.dashboard',
            'coach'      => 'coach.dashboard',
            'parent'     => 'parent.dashboard',
            default      => 'home',
        };

        return response()->json([
            'ok' => true,
            'message' => 'Redirection frontend geree par client.',
            'data' => [
                'role' => $user->role,
                'dashboard_route' => $route,
            ],
        ]);
    })->name('dashboard');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

Route::prefix('admin')->middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/coachs/create', [SuperAdminController::class, 'createCoach'])->name('admin.coachs.create');
    Route::post('/coachs', [SuperAdminController::class, 'storeCoach'])->name('admin.coachs.store');
    Route::get('/coachs/{coach}/edit', [SuperAdminController::class, 'editCoach'])->name('admin.coachs.edit');
    Route::put('/coachs/{coach}', [SuperAdminController::class, 'updateCoach'])->name('admin.coachs.update');
    Route::delete('/coachs/{coach}', [SuperAdminController::class, 'destroyCoach'])->name('admin.coachs.destroy');

    Route::get('/parents/create', [SuperAdminController::class, 'createParent'])->name('admin.parents.create');
    Route::post('/parents', [SuperAdminController::class, 'storeParent'])->name('admin.parents.store');
    Route::get('/parents/{parent}/edit', [SuperAdminController::class, 'editParent'])->name('admin.parents.edit');
    Route::put('/parents/{parent}', [SuperAdminController::class, 'updateParent'])->name('admin.parents.update');
    Route::delete('/parents/{parent}', [SuperAdminController::class, 'destroyParent'])->name('admin.parents.destroy');

    Route::get('/categories/create', [SuperAdminController::class, 'createCategorie'])->name('admin.categories.create');
    Route::post('/categories', [SuperAdminController::class, 'storeCategorie'])->name('admin.categories.store');
    Route::get('/categories/{categorie}/edit', [SuperAdminController::class, 'editCategorie'])->name('admin.categories.edit');
    Route::put('/categories/{categorie}', [SuperAdminController::class, 'updateCategorie'])->name('admin.categories.update');
    Route::delete('/categories/{categorie}', [SuperAdminController::class, 'destroyCategorie'])->name('admin.categories.destroy');

    Route::get('/groupes/create', [SuperAdminController::class, 'createGroupe'])->name('admin.groupes.create');
    Route::post('/groupes', [SuperAdminController::class, 'storeGroupe'])->name('admin.groupes.store');
    Route::get('/groupes/{groupe}/edit', [SuperAdminController::class, 'editGroupe'])->name('admin.groupes.edit');
    Route::put('/groupes/{groupe}', [SuperAdminController::class, 'updateGroupe'])->name('admin.groupes.update');
    Route::delete('/groupes/{groupe}', [SuperAdminController::class, 'destroyGroupe'])->name('admin.groupes.destroy');
    Route::post('/groupes/{groupe}/assign-coach', [SuperAdminController::class, 'assignCoachToGroupe'])->name('admin.groupes.assignCoach');

    Route::get('/joueurs', [SuperAdminController::class, 'joueurs'])->name('admin.joueurs.index');
    Route::get('/joueurs/create', [SuperAdminController::class, 'createJoueur'])->name('admin.joueurs.create');
    Route::post('/joueurs', [SuperAdminController::class, 'storeJoueur'])->name('admin.joueurs.store');
    Route::get('/joueurs/{joueur}/edit', [SuperAdminController::class, 'editJoueur'])->name('admin.joueurs.edit');
    Route::put('/joueurs/{joueur}', [SuperAdminController::class, 'updateJoueur'])->name('admin.joueurs.update');
    Route::delete('/joueurs/{joueur}', [SuperAdminController::class, 'destroyJoueur'])->name('admin.joueurs.destroy');
    Route::post('/joueurs/{joueur}/assign-categorie', [SuperAdminController::class, 'assignJoueurToCategorie'])->name('admin.joueurs.assignCategorie');

    Route::get('/paiements', [SuperAdminController::class, 'paiements'])->name('admin.paiements.index');
    Route::post('/paiements/{paiement}/valider', [SuperAdminController::class, 'validerPaiement'])->name('admin.paiements.valider');

    Route::get('/notifications/create', [SuperAdminController::class, 'createNotification'])->name('admin.notifications.create');
    Route::post('/notifications', [SuperAdminController::class, 'storeNotification'])->name('admin.notifications.store');
});

Route::prefix('coach')->middleware(['auth:sanctum', 'role:coach'])->group(function () {
    Route::get('/dashboard', [CoachController::class, 'index'])->name('coach.dashboard');
    Route::get('/groupes/{groupe}', [CoachController::class, 'showGroupe'])->name('coach.groupes.show');
    Route::post('/groupes/{groupe}/assign-joueur', [CoachController::class, 'assignJoueur'])->name('coach.groupes.assignJoueur');
    Route::get('/groupes/{groupe}/seances/create', [CoachController::class, 'createSeance'])->name('coach.seances.create');
    Route::post('/groupes/{groupe}/seances', [CoachController::class, 'storeSeance'])->name('coach.seances.store');
    Route::get('/seances/{seance}/appel', [CoachController::class, 'appel'])->name('coach.seances.appel');
    Route::post('/seances/{seance}/appel', [CoachController::class, 'storeAppel'])->name('coach.seances.storeAppel');
    Route::get('/joueurs/{joueur}/evaluation/create', [CoachController::class, 'createEvaluation'])->name('coach.evaluations.create');
    Route::post('/joueurs/{joueur}/evaluation', [CoachController::class, 'storeEvaluation'])->name('coach.evaluations.store');
    Route::get('/seances/{seance}/joueurs/{joueur}/evaluation/create', [CoachController::class, 'createEvaluationForSeance'])->name('coach.seances.evaluations.create');
    Route::post('/seances/{seance}/joueurs/{joueur}/evaluation', [CoachController::class, 'storeEvaluationForSeance'])->name('coach.seances.evaluations.store');
});

Route::prefix('parent')->middleware(['auth:sanctum', 'role:parent'])->group(function () {
    Route::get('/dashboard', [ParentController::class, 'index'])->name('parent.dashboard');
    Route::get('/joueurs/{joueur}', [ParentController::class, 'showJoueur'])->name('parent.joueurs.show');
    Route::get('/paiement', [ParentController::class, 'payer'])->name('parent.paiement');
    Route::post('/paiement/intent', [ParentController::class, 'createStripeIntent'])->name('parent.paiement.intent');
    Route::post('/paiement/confirm', [ParentController::class, 'confirmStripeIntent'])->name('parent.paiement.confirm');
    Route::post('/paiement', [ParentController::class, 'storePaiement'])->name('parent.paiement.store');
});
