<?php

use App\Http\Controllers\Admin\BulletinController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EtudiantController;
use App\Http\Controllers\Admin\ExamenController;
use App\Http\Controllers\Admin\MatiereController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\EtudiantController as UserEtudiantController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'show'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::put('/user/update', [AuthController::class, 'update'])->name('user.update');

Route::middleware([AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::get('etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
    Route::get('etudiants/create', [EtudiantController::class, 'create'])->name('etudiants.create');
    Route::post('etudiants', [EtudiantController::class, 'store'])->name('etudiants.store');
    Route::get('etudiants/{etudiant}/edit', [EtudiantController::class, 'edit'])->name('etudiants.edit');
    Route::put('etudiants/{etudiant}', [EtudiantController::class, 'update'])->name('etudiants.update');
    Route::delete('etudiants/{etudiant}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy');
    Route::get('etudiants/{etudiant}', [EtudiantController::class, 'show'])->name('etudiants.show');

    Route::get('examens', [ExamenController::class, 'index'])->name('examens.index');
    Route::get('examens/create', [ExamenController::class, 'create'])->name('examens.create');
    Route::post('examens', [ExamenController::class, 'store'])->name('examens.store');
    Route::get('examens/{examen}/edit', [ExamenController::class, 'edit'])->name('examens.edit');
    Route::put('examens/{examen}', [ExamenController::class, 'update'])->name('examens.update');
    Route::delete('examens/{examen}', [ExamenController::class, 'destroy'])->name('examens.destroy');

    Route::get('matieres', [MatiereController::class, 'index'])->name('matieres.index');
    Route::get('matieres/create', [MatiereController::class, 'create'])->name('matieres.create');
    Route::post('matieres', [MatiereController::class, 'store'])->name('matieres.store');
    Route::get('matieres/{matiere}/edit', [MatiereController::class, 'edit'])->name('matieres.edit');
    Route::put('matieres/{matiere}', [MatiereController::class, 'update'])->name('matieres.update');
    Route::delete('matieres/{matiere}', [MatiereController::class, 'destroy'])->name('matieres.destroy');
    Route::get('matieres/{matiere}/notes', [MatiereController::class, 'notes'])->name('matieres.notes');

    Route::get('notes/formulaire/{etudiant}', [NoteController::class, 'formulaire'])->name('notes.formulaire');
    Route::post('notes', [NoteController::class, 'store'])->name('notes.store');

    Route::get('bulletins/{etudiant}', [BulletinController::class, 'show'])->name('etudiants.bulletin');
    Route::get('bulletins/anciens/{etudiant}', [BulletinController::class, 'anciens'])->name('etudiants.bulletins-anciens');
});

Route::middleware([UserMiddleware::class])->prefix('user')->name('user.')->group(function () {
    Route::get('profile/{etudiant}',[UserEtudiantController::class,'profile'])->name('profile');
    Route::get('bulletin/{etudiant}',[UserEtudiantController::class,'bulletin'])->name('bulletin');
    Route::get('bulletins/anciens/{etudiant}',[UserEtudiantController::class,'anciens'])->name('bulletins-anciens');
    Route::get('matieres/{etudiant}',[UserEtudiantController::class,'matieres'])->name('matieres');
    Route::get('examens/{etudiant}',[UserEtudiantController::class,'examens'])->name('examens');
});