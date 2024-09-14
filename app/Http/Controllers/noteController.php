<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Services\NoteService;
use Illuminate\Http\Request;

class noteController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function index()
    {
        $notes = $this->noteService->getAllNotes();

        return response()->json([
            'notes' => $notes,
            'status' => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->noteService->createNote($request->all());

        return response()->json([
            'message' => $response['message'] ?? 'Nota creada exitosamente',
            'note' => $response['note'] ?? null,
            'errors' => $response['errors'] ?? null,
            'status' => $response['status']
        ], $response['status']);
    }

    public function show($id)
    {
        $note = $this->noteService->getNoteById($id);

        if (!$note) {
            return response()->json([
                'message' => 'Nota no encontrada',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'note' => $note,
            'status' => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $response = $this->noteService->updateNote($id, $request->all());

        return response()->json([
            'message' => $response['message'] ?? 'Nota actualizada',
            'note' => $response['note'] ?? null,
            'errors' => $response['errors'] ?? null,
            'status' => 200
        ], $response['status']);
    }

    public function destroy($id)
    {
        $response = $this->noteService->deleteNote($id);

        return response()->json([
            'message' => $response['message'],
            'status' => $response['status']
        ], $response['status']);
    }

    // Nuevo método para archivar notas
    public function archive($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json([
                'message' => 'Nota no encontrada',
                'status' => 404
            ], 404);
        }

        $note->is_archived = true;
        $note->save();

        return response()->json([
            'message' => 'Nota archivada exitosamente',
            'note' => $note,
            'status' => 200
        ], 200);
    }


    // NoteController.php
    public function getArchivedNotes()
    {
        $archivedNotes = Note::where('is_archived', true)->get();

        if ($archivedNotes->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron notas archivadas',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'notes' => $archivedNotes
        ], 200);
    }

    // app/Http/Controllers/NoteController.php
    public function unarchive($id)
    {
        $response = $this->noteService->unarchiveNote($id);

        return response()->json([
            'message' => $response['message'],
            'note' => $response['note'] ?? null,
            'status' => $response['status']
        ], $response['status']);
    }
}
