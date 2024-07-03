<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend;
use App\Events\ConsultationEvent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect('login');
});

Auth::routes(['register' => false]);

Route::middleware('role:admin')->group(function () {
    Route::get('dashboard', [Backend\DashboardController::class, 'index'])->name('dashboard');
    Route::resources([
        'foods' => Backend\FoodController::class,
        'snacks' => Backend\SnackController::class,
        'drinks' => Backend\DrinkController::class,
        'sports' => Backend\SportController::class,
        'educations' => Backend\EducationController::class,
        'users' => Backend\UserController::class,
        'profile' => Backend\ProfileController::class,
        'change-password' => Backend\ChangePasswordController::class,
    ]);
    Route::get('consultations', [Backend\ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('consultations/list', [Backend\ConsultationController::class, 'list'])->name('consultations.list');
    Route::get('consultations/new', [Backend\ConsultationController::class, 'new'])->name('consultations.new');
    Route::get('consultations/person/{id}', [Backend\ConsultationController::class, 'person'])->name('consultations.person');
    Route::get('consultations/content/{id}', [Backend\ConsultationController::class, 'content'])->name('consultations.content');
    Route::post('consultations/send', [Backend\ConsultationController::class, 'send'])->name('consultations.send');
    Route::post('consultations/attachment', [Backend\ConsultationController::class, 'attachment'])->name('consultations.attachment');
    Route::post('consultations/delete-all', [Backend\ConsultationController::class, 'deleteAll'])->name('consultations.delete-all');
});
