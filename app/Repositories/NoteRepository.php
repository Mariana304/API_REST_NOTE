<?php

namespace App\Repositories;

use App\Models\Note;

class NoteRepository
{
    public function all()
    {
        return Note::where('is_archived', false)->get(); // Filtra las notas archivadas
    }

    public function find($id)
    {
        return Note::find($id);
    }

    public function create(array $data)
    {
        return Note::create($data);
    }

    public function update(Note $note, array $data)
    {
        $note->update($data);
        return $note;
    }

    public function delete(Note $note)
    {
        return $note->delete();
    }

    public function archive($id)
    {
        $note = $this->find($id);

        if ($note) {
            $note->is_archived = true;
            $note->save();
            return $note;
        }

        return null;
    }

    // app/Repositories/NoteRepository.php
    public function unarchive($id)
    {
        $note = Note::find($id);

        if ($note) {
            $note->is_archived = false;
            $note->save();
            return $note;
        }

        return null;
    }
}
