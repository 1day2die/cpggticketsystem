<?php

use OneDayToDie\Ticketsystem\Controllers\TicketsController;
use OneDayToDie\Ticketsystem\Controllers\Admin\AdminTicketsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    #ticket user
    Route::get('ticket', [TicketsController::class, 'index'])->name('ticket.index');
    Route::get('ticket/datatable', [TicketsController::class, 'datatable'])->name('ticket.datatable');
    Route::get('ticket/new', [TicketsController::class, 'create'])->name('ticket.new');
    Route::post('ticket/new', [TicketsController::class, 'store'])->name('ticket.new.store');
    Route::get('ticket/show/{ticket_id}', [TicketsController::class, 'show'])->name('ticket.show');
    Route::post('ticket/reply', [TicketsController::class, 'reply'])->name('ticket.reply');
});



    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
        #TicketAdmin
        Route::get('ticket', [AdminTicketsController::class, 'index'])->name('ticket.index');
        Route::get('ticket/datatable', [AdminTicketsController::class, 'datatable'])->name('ticket.datatable');
        Route::get('ticket/show/{ticket_id}', [AdminTicketsController::class, 'show'])->name('ticket.show');
        Route::post('ticket/reply', [AdminTicketsController::class, 'reply'])->name('ticket.reply');
        Route::post('ticket/close/{ticket_id}', [AdminTicketsController::class, 'close'])->name('ticket.close');
        Route::post('ticket/delete/{ticket_id}', [AdminTicketsController::class, 'delete'])->name('ticket.delete');
        #ticket moderation blacklist
        Route::get('ticket/blacklist', [AdminTicketsController::class, 'blacklist'])->name('ticket.blacklist');
        Route::post('ticket/blacklist', [AdminTicketsController::class, 'blacklistAdd'])->name('ticket.blacklist.add');
        Route::post('ticket/blacklist/delete/{id}', [AdminTicketsController::class, 'blacklistDelete'])->name('ticket.blacklist.delete');
        Route::post('ticket/blacklist/change/{id}', [AdminTicketsController::class, 'blacklistChange'])->name('ticket.blacklist.change');
        Route::get('ticket/blacklist/datatable', [AdminTicketsController::class, 'dataTableBlacklist'])->name('ticket.blacklist.datatable');
    });
