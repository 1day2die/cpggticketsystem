<?php

$namespace = "OneDayToDie\TicketSystem\Http\Controllers";

use OneDayToDie\TicketSystem\Http\Controllers\TicketsController;
use OneDayToDie\TicketSystem\Http\Controllers\Admin\AdminTicketsController;
use Illuminate\Support\Facades\Route;

#ticket user
Route::middleware('web')->group(function () {
    Route::get('ticket', [TicketsController::class, 'index'])->name('ticket.index');
    Route::get('ticket/datatable', [TicketsController::class, 'datatable'])->name('ticket.datatable');
    Route::get('ticket/new', [TicketsController::class, 'create'])->name('ticket.new');
    Route::post('ticket/new', [TicketsController::class, 'store'])->name('ticket.new.store');
    Route::get('ticket/show/{ticket_id}', [TicketsController::class, 'show'])->name('ticket.show');
    Route::post('ticket/reply', [TicketsController::class, 'reply'])->name('ticket.reply');
    Route::post('ticket/close/{ticket_id}', [TicketsController::class, 'close'])->name('ticket.close');

    #TicketAdmin
    Route::get('admin/ticket', [AdminTicketsController::class, 'index'])->name('admin.ticket.index');
    Route::get('admin/ticket/datatable', [AdminTicketsController::class, 'datatable'])->name('admin.ticket.datatable');
    Route::get('admin/ticket/show/{ticket_id}', [AdminTicketsController::class, 'show'])->name('admin.ticket.show');
    Route::post('admin/ticket/reply', [AdminTicketsController::class, 'reply'])->name('admin.ticket.reply');
    Route::post('admin/ticket/close/{ticket_id}', [AdminTicketsController::class, 'close'])->name('admin.ticket.close');
    Route::post('admin/ticket/delete/{ticket_id}', [AdminTicketsController::class, 'delete'])->name('admin.ticket.delete');
    #ticket moderation blacklist
    Route::get('admin/ticket/blacklist', [AdminTicketsController::class, 'blacklist'])->name('admin.ticket.blacklist');
    Route::post('admin/ticket/blacklist', [AdminTicketsController::class, 'blacklistAdd'])->name('admin.ticket.blacklist.add');
    Route::post('admin/ticket/blacklist/delete/{id}', [AdminTicketsController::class, 'blacklistDelete'])->name('admin.ticket.blacklist.delete');
    Route::post('admin/ticket/blacklist/change/{id}', [AdminTicketsController::class, 'blacklistChange'])->name('admin.ticket.blacklist.change');
    Route::get('admin/ticket/blacklist/datatable', [AdminTicketsController::class, 'dataTableBlacklist'])->name('ticket.blacklist.datatable');
});
