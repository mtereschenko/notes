<a href="{{ route('notes.show_by_slug', ['slug' => $note->{\App\Models\Note::SLUG_ATTRIBUTE}]) }}">
    {{ $note->{\App\Models\Note::TITLE_ATTRIBUTE} }}
</a>

<div id="article_item">
    <div id="header">
        <h1>{{ $note->{\App\Models\Note::TITLE_ATTRIBUTE} }}</h1>
        <time class="text-center">
            {{ $note->{\App\Models\Note::CREATED_AT_ATTRIBUTE}->format('Y.m.d') }}
        </time>
    </div>
    <div id="note_body">
        {!! $note->{\App\Models\Note::BODY_ATTRIBUTE} !!}
    </div>
</div>