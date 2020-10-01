<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Note;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Note $note
     *
     * @return mixed
     */
    public function publicView(User $user, Note $note)
    {
        if ($note->{Note::PRIVACY_STATUS_ATTRIBUTE} === Note::PUBLIC) {
            return true;
        }

        if ($user->getKey() === $note->{Note::USER_ID_ATTRIBUTE}) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Note $note
     *
     * @return mixed
     */
    public function update(User $user, Note $note)
    {
        return $user->getKey() === $note->{Note::USER_ID_ATTRIBUTE};
    }

    /**
     * Determine whether the user can show the model.
     *
     * @param \App\Models\Note $note
     *
     * @return mixed
     */
    public function show(User $user, Note $note)
    {
        return $note->{Note::PRIVACY_STATUS_ATTRIBUTE} === Note::PUBLIC ||
            $user->getKey() === $note->{Note::USER_ID_ATTRIBUTE};
    }
}
