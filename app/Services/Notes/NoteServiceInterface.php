<?php


namespace App\Services\Notes;

use App\Http\Requests\NoteRequest;
use App\Models\Note;

interface NoteServiceInterface
{
    public function list();

    public function create(NoteRequest $request);

    public function getBySlug(string $slug);

    public function get(int $id);

    public function store(NoteRequest $request);

    public function share(Note $note, string $email);

    public function togglePublish(Note $id);

}