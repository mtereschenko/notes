<?php

Route::get('/', 'NotesController@index')->name('notes.index');
Route::group([
    'middleware' => 'auth',
], function () {
    Route::get('/notes/create', 'NotesController@createForm')->name('notes.create_form');
    Route::post('/notes/create', 'NotesController@create')->name('notes.create');
    Route::get('/notes/private', 'NotesController@privateNotesList')->name('notes.private_notes');
    Route::get('/notes/shared', 'NotesController@sharedNotesList')->name('notes.shared_notes');
    Route::get('/notes/{slug}/edit', 'NotesController@editForm')->name('notes.edit');
    Route::post('/notes/{slug}/store', 'NotesController@store')->name('notes.store');
    Route::post('/notes/{note}/toggle_publish', 'NotesController@togglePublish')->name('notes.toggle_publish');
    Route::post('/notes/{note}/share', 'NotesController@share')->name('notes.share');
});
Route::get('/notes/{slug}', 'NotesController@showBySlug')->name('notes.show_by_slug');
