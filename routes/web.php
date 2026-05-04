<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [TicketController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

    Route::get('/mis-tickets', [TicketController::class, 'misTickets'])->name('tickets.mis');
    Route::get('/tickets-asignados', [TicketController::class, 'ticketsAsignados'])->name('tickets.asignados');

    Route::get('/tickets/sin-asignar', [TicketController::class, 'sinAsignar'])->name('tickets.sinAsignar');
    Route::post('/tickets/{id}/asignar', [TicketController::class, 'asignar'])->name('tickets.asignar');

    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{id}/comments', [TicketController::class, 'addComment'])->name('tickets.comments.store');

    Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');

    Route::post('/tickets/{id}/cerrar', [TicketController::class, 'cerrar'])->name('tickets.cerrar');
    Route::post('/tickets/{id}/reabrir', [TicketController::class, 'reabrir'])->name('tickets.reabrir');

    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

});

require __DIR__.'/auth.php';