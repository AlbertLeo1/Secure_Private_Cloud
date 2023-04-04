<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'tickets'], function () {
    Route::get('/ticket/departmental', 'TicketController@departmental')->name('ticket.departmental');
    Route::get('/ticket/initials', 'TicketController@initials')->name('ticket.initials');
    Route::get('/ticket/personal', 'TicketController@personal')->name('ticket.personal');
    
    Route::apiResources([
        '/comments'      => 'CommentController',
        '/ticket'       => 'TicketController',
        '/priority'     => 'PriorityController',
    ]);
});