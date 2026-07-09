<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventStaffAssignmentController;
use App\Http\Controllers\Admin\StaffMemberController;
use App\Http\Controllers\Admin\StaffRoleController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::resource('events', EventController::class)->except(['destroy']);
    Route::resource('staff-members', StaffMemberController::class)->except(['destroy']);
    Route::resource('staff-roles', StaffRoleController::class)->except(['show', 'destroy']);

    Route::post('events/{event}/assignments', [EventStaffAssignmentController::class, 'store'])
        ->name('events.assignments.store');
    Route::patch('events/{event}/assignments/{assignment}', [EventStaffAssignmentController::class, 'update'])
        ->name('events.assignments.update');
    Route::delete('events/{event}/assignments/{assignment}', [EventStaffAssignmentController::class, 'destroy'])
        ->name('events.assignments.destroy');
});

require __DIR__.'/settings.php';
