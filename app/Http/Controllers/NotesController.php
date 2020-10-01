<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShareNoteRequest;
use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Services\Notes\Exceptions\NoteCantBeViewedException;
use App\Services\Notes\NotesService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class NotesController extends Controller
{

    private $notesService;

    public function __construct(NotesService $notesService)
    {
        $this->notesService = $notesService;
    }

    /**
     * Show the application dashboard.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function index()
    {
        $notes = $this->notesService->list();

        return view('notes.list')->with(compact('notes'));
    }

    /**
     * Show the application dashboard.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function privateNotesList()
    {
        $notes = $this->notesService->privateNotesList();

        return view('notes.list')->with(compact('notes'));
    }

    /**
     * Show the application dashboard.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function sharedNotesList()
    {
        $notes = $this->notesService->sharedNotesList();

        return view('notes.list')->with(compact('notes'));
    }

    /**
     * @param $slug
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function showBySlug($slug)
    {
        try {
            $note = $this->notesService->getBySlug($slug);

            return view('notes.show_by_slug')->with(compact('note'));
        } catch (NoteCantBeViewedException $e) {
            return abort(404);
        }
    }

    /**
     * @param $slug
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function editForm($slug)
    {
        $note = $this->notesService->getBySlug($slug);

        if (auth()->user()->cant('update', $note)) {
            return abort(403);
        }

        return view('notes.edit')->with(compact('note'));
    }

    /**
     * @param $slug
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function createForm()
    {
        return view('notes.create');
    }

    /**
     * @param $slug
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function create(NoteRequest $request)
    {
        $note = $this->notesService->create($request);

        return redirect(route('notes.private_notes'));
    }

    /**
     * @param NoteRequest $request
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\View\View|void
     */
    public function store(NoteRequest $request)
    {
        $note = $this->notesService->store($request);

        if (auth()->user()->cant('update', $note)) {
            return abort(403);
        }

        return redirect(route('notes.index'));
    }

    /**
     * @param NoteRequest $request
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\View\View|void
     */
    public function togglePublish(Note $note)
    {
        if (auth()->user()->cant('update', $note)) {
            return abort(403);
        }

        $note = $this->notesService->togglePublish($note);

        return response()->json([true]);
    }

    /**
     * @param NoteRequest $request
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\View\View|void
     */
    public function share(ShareNoteRequest $request, Note $note)
    {
        $note = $this->notesService->share($note, $request->get(ShareNoteRequest::EMAIL_FIELD));

        return response()->json([true]);
    }
}
