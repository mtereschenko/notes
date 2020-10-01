@extends('layouts.app')

@section('content')
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
        <div id="footer" class="text-center">
            <a class="button need_to_fade" href="{{ route('notes.index') }}">← @lang('notes.back to the notes')</a>
        </div>
    </div>
@endsection