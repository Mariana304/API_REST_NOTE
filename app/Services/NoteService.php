<?php

namespace App\Services;

use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Validator;

class NoteService
{
    protected $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function getAllNotes()
    {
        return $this->noteRepository->all();
    }

    public function getNoteById($id)
    {
        return $this->noteRepository->find($id);
    }

    public function createNote(array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'message' => 'Error de validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
        }

        $note = $this->noteRepository->create($data);

        if (!$note) {
            return [
                'message' => 'Error al crear la nota',
                'status' => 500
            ];
        }

        return [
            'note' => $note,
            'status' => 200
        ];
    }

    public function updateNote($id, array $data)
    {
        $note = $this->noteRepository->find($id);

        if (!$note) {
            return [
                'message' => 'Nota no encontrada',
                'status' => 404
            ];
        }

        // Validaciones y actualizaciones
        $note->fill($data);
        $note->save();

        return [
            'message' => 'Nota actualizada',
            'note' => $note,
            'status' => 200
        ];
    }

    public function deleteNote($id)
    {
        $note = $this->noteRepository->find($id);

        if (!$note) {
            return [
                'message' => 'Nota no encontrada',
                'status' => 404
            ];
        }

        $this->noteRepository->delete($note);

        return [
            'message' => 'Nota eliminada',
            'status' => 200
        ];
    }

    // Nuevo método para archivar la nota
    public function archiveNote($id)
    {
        $note = $this->noteRepository->find($id);

        if (!$note) {
            return [
                'message' => 'Nota no encontrada',
                'status' => 404
            ];
        }

        $archivedNote = $this->noteRepository->archive($id);

        if (!$archivedNote) {
            return [
                'message' => 'Error al archivar la nota',
                'status' => 500
            ];
        }

        return [
            'message' => 'Nota archivada exitosamente',
            'note' => $archivedNote,
            'status' => 200
        ];
    }

    // app/Services/NoteService.php
    public function unarchiveNote($id)
    {
        $note = $this->noteRepository->unarchive($id);

        if (!$note) {
            return [
                'message' => 'Nota no encontrada',
                'status' => 404
            ];
        }

        return [
            'message' => 'Nota desarchivada exitosamente',
            'note' => $note,
            'status' => 200
        ];
    }
}
