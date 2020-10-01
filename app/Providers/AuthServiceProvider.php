<?php

namespace App\Providers;

use App\Models\Note;
use App\Policies\NotePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Note::class => NotePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-note', function ($user, $note) {
            dd(123);
//            $isNotePrivate = $note->{Note::PRIVACY_STATUS_ATTRIBUTE} === Note::PRIVATE;
//            dd($isNotePrivate);
//            $isOwner = (empty($user)) ? false : $user->getKey() === $note->{Note::USER_ID_ATTRIBUTE};
//
//            if (!$isOwner && $isNotePrivate) {
//                return false;
//            }

            return true;
        });
    }
}
