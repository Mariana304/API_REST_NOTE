<?php

use App\Http\Controllers\noteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/notes', [noteController::class, 'index']);

Route::get('/notes/archived', [noteController::class, 'getArchivedNotes']);

Route::get('/notes/{id}', [noteController::class, 'show']);//por si solo quiere llamar un estudiante

Route::post('/notes', [noteController::class, 'store']);

Route::put('/notes/{id}',[noteController::class, 'update']); //se ponen las llaves {} para especificar el id del estudiante que se va a actualizar
// routes/api.php

Route::put('/notes/{id}/unarchive', [NoteController::class, 'unarchive']);


Route::patch('/notes/{id}',[noteController::class, 'updatePartial']); //se ponen las llaves {} para especificar el id del estudiante que se va a actualizar parcialmente

Route::delete('/notes/{id}', [noteController::class, 'destroy']);//se ponen las llaves {} para especificar el id del estudiante que se va a eliminar

Route::put('/notes/{id}/archive', [noteController::class, 'archive']);


