<?php

namespace App\Services\Notes;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Models\SharedNote;
use App\Models\User;
use App\Services\Notes\Exceptions\NoteCantBeViewedException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class NotesService implements NoteServiceInterface
{
    private $noteModel;
    private $sharedNoteModel;
    private $userModel;

    public function __construct(Note $note, SharedNote $sharedNote, User $user)
    {
        $this->noteModel = $note;
        $this->sharedNoteModel = $sharedNote;
        $this->userModel = $user;
    }

    public function list(): LengthAwarePaginator
    {
        return $this->noteModel
            ->selectWithoutBody()
            ->where(Note::PRIVACY_STATUS_ATTRIBUTE, Note::PUBLIC)
            ->orderBy(Note::CREATED_AT_ATTRIBUTE, 'desc')
            ->paginate(6);
    }

    public function privateNotesList(): LengthAwarePaginator
    {
        return $this->noteModel
            ->selectWithoutBody()
            ->whereHas('author', function ($query) {
                $query->where(Note::USER_ID_ATTRIBUTE, auth()->user()->id);
            })
            ->where(Note::PRIVACY_STATUS_ATTRIBUTE, Note::PRIVATE)
            ->orderBy(Note::UPDATED_AT_ATTRIBUTE, 'desc')
            ->paginate(6);
    }

    public function sharedNotesList(): LengthAwarePaginator
    {
        return auth()->user()
            ->sharedNotes()
            ->selectWithoutBody()
            ->where(Note::PRIVACY_STATUS_ATTRIBUTE, Note::PUBLIC)
            ->orderBy(Note::UPDATED_AT_ATTRIBUTE, 'desc')
            ->paginate(6);
    }

    public function create(NoteRequest $request): Note
    {
        $data = [
            Note::TITLE_ATTRIBUTE => $request->get(Note::TITLE_ATTRIBUTE),
            Note::BODY_ATTRIBUTE => $request->get(Note::BODY_ATTRIBUTE),
            Note::USER_ID_ATTRIBUTE => auth()->user()->getKey(),
        ];

        $data[Note::PREVIEW_BODY_ATTRIBUTE] = mb_substr(strip_tags($data[Note::BODY_ATTRIBUTE]), 0, 500);

        $note = $this->noteModel->create($data);

        return $note;
    }

    public function store(NoteRequest $request): Note
    {
        $note = $this->get($request->get(Note::ID_ATTRIBUTE));

        $note->{Note::TITLE_ATTRIBUTE} = $request->get(Note::TITLE_ATTRIBUTE);
        $note->{Note::BODY_ATTRIBUTE} = $request->get(Note::BODY_ATTRIBUTE);
        $note->{Note::PREVIEW_BODY_ATTRIBUTE} = mb_substr(strip_tags($note->{Note::BODY_ATTRIBUTE}), 0, 500);

        $note->save();

        return $note;
    }

    public function share(Note $note, string $email): void
    {
        $this->sharedNoteModel->create([
            SharedNote::EMAIL_ATTRIBUTE => $email,
            SharedNote::SLUG_ATTRIBUTE => $note->{Note::SLUG_ATTRIBUTE},
        ]);

        $user = $this->userModel->where(User::EMAIL_ATTRIBUTE, $email)->first();

        if (empty($user)) {
            $toEmail = $email;
            $emailSubject = trans('З Вами поділились запискою');
            Mail::send('emails.note', compact('note'), function ($message) use ($toEmail, $emailSubject) {
                $message->to($toEmail)->subject($emailSubject);
                $message->from($toEmail);
            });
        }
    }

    public function getBySlug(string $slug): Note
    {
        $note = $this->noteModel->where(Note::SLUG_ATTRIBUTE, $slug)->firstOrFail();

        $isNotePrivate = $note->{Note::PRIVACY_STATUS_ATTRIBUTE} === Note::PRIVATE;
        $isOwner = (empty($user)) ? false : $user->getKey() === $note->{Note::USER_ID_ATTRIBUTE};

        if (!$isOwner && $isNotePrivate) {
            throw new NoteCantBeViewedException();
        }

        return $note;
    }

    public function get(int $id): Note
    {
        $note = $this->noteModel->where(Note::USER_ID_ATTRIBUTE, auth()->user()->id)
            ->findOrFail($id);

        return $note;
    }

    public function togglePublish(Note $note): bool
    {
        $note->{Note::PRIVACY_STATUS_ATTRIBUTE}
            = $note->{Note::PRIVACY_STATUS_ATTRIBUTE} == Note::PUBLIC ? Note::PRIVATE : Note::PUBLIC;

        return $note->save();
    }
}
