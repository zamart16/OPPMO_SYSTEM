<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;


Route::get('/', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Admin
Route::middleware(['auth','role:administrator'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users/inactive', [AdminController::class, 'getInactiveUsers']);
    Route::post('/admin/users/{id}/activate', [AdminController::class, 'activateUser']);

});

// End user
Route::middleware(['auth','role:end_user'])->group(function () {
    Route::get('/end-user', [UserController::class,'dashboard'])->name('user.dashboard');
});

// Evaluation routes
Route::middleware(['auth'])->group(function () {
    Route::post('/evaluation/store', [EvaluationController::class,'store'])->name('evaluation.store');
    Route::get('/evaluation/list', [EvaluationController::class,'list'])->name('evaluation.list');
    Route::get('/evaluation/{id}', [EvaluationController::class,'show']);
    Route::get('/partials/evaluation_view', fn() => view('partials.evaluation_view'));
    Route::get('/evaluation/{id}/pdf', [PDFController::class, 'downloadPdf'])
     ->name('evaluation.pdf')
     ->middleware('auth');
    Route::get('/evaluation/download/{id}', [EvaluationController::class, 'downloadPdf'])
    ->name('evaluation.download');
});
