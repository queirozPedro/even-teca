<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->middleware('auth');
Route::get('/home/user', [HomeController::class, 'index'])->name('home.user')->middleware('auth');
Route::get('/home/organizer', [HomeController::class, 'index'])->name('home.organizer')->middleware('auth');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/my-registrations', [HomeController::class, 'myRegistrations'])->name('my.registrations');
    Route::get('/profile/edit', [HomeController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [HomeController::class, 'updateProfile'])->name('profile.update');

    // Pagamento de inscrição
    Route::post('/registrations/{registration}/pay', [EventController::class, 'payRegistration'])->name('registrations.pay');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/{event}/attendees', [EventController::class, 'attendees'])->name('events.attendees');
    Route::get('/events/{event}/approve/{user}', [EventController::class, 'approve'])->name('events.approve');
    Route::get('/events/{event}/reject/{user}', [EventController::class, 'reject'])->name('events.reject');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('can:is-admin')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::get('/admin/events', [AdminController::class, 'events'])->name('admin.events');
        Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/admin/events/{event}/edit', [AdminController::class, 'editEvent'])->name('admin.events.edit');
        Route::put('/admin/events/{event}', [AdminController::class, 'updateEvent'])->name('admin.events.update');
        Route::delete('/admin/events/{event}', [AdminController::class, 'deleteEvent'])->name('admin.events.delete');
    });
    Route::middleware('can:manage-events')->group(function () {
        Route::get('/organizer/reports', [AdminController::class, 'reports'])->name('organizer.reports');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/events/{event}/delete', [App\Http\Controllers\EventController::class, 'delete'])->name('events.delete');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/events/{event}/subscribe', [App\Http\Controllers\EventController::class, 'subscribe'])->name('events.subscribe');
    Route::delete('/events/{event}/unsubscribe', [App\Http\Controllers\EventController::class, 'unsubscribe'])->name('events.unsubscribe');
});