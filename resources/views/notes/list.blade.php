@extends('layouts.app')

@section('content')
    <div id="article_list_container">
        @foreach($notes as $note)
            <div class="article_list_item">
                <div class="header">
                    <div class="header_link">
                        <a class="need_to_fade"
                           href="{{ route('notes.show_by_slug', ['slug' => $note->{\App\Models\Note::SLUG_ATTRIBUTE}]) }}">
                            {{ $note->{\App\Models\Note::TITLE_ATTRIBUTE} }}
                        </a>
                    </div>
                    <time class="text-center">
                        {{ $note->{\App\Models\Note::UPDATED_AT_ATTRIBUTE}->format('Y.m.d') }}
                    </time>
                </div>
                <div class="note_preview">{{ $note->{\App\Models\Note::PREVIEW_BODY_ATTRIBUTE}  }}…
                    <div class="read_more">
                        <a class="need_to_fade"
                           href="{{ route('notes.show_by_slug', ['slug' => $note->{\App\Models\Note::SLUG_ATTRIBUTE}]) }}">
                            [@lang('notes.read more') →]
                        </a>
                    </div>
                </div>
                <div class="footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-3 text-center align-self-center">
                                @can('update', $note)
                                    <a type="button" class="btn btn-light need_to_fade" data-toggle="tooltip"
                                       data-placement="bottom"
                                       href="{{ route('notes.edit', ['slug' => $note->{\App\Models\Note::SLUG_ATTRIBUTE}]) }}"
                                       title="@lang('notes.edit')">
                                        <span><i class="fas fa-pen-fancy"></i></span>
                                    </a>
                                    <a type="button" class="btn btn-light toggle_publish"
                                       data-toggle="tooltip" data-placement="bottom"
                                       data-id="{{ $note->getKey() }}"
                                       data-url="{{ route('notes.toggle_publish', ['note' => $note->getKey()]) }}"
                                       @if ($note->{\App\Models\Note::PRIVACY_STATUS_ATTRIBUTE} === \App\Models\Note::PUBLIC)
                                       title="@lang('notes.hide')">
                                        <span><i class="fas fa-eye-slash"></i></span>
                                        @else
                                            title="@lang('notes.show')">
                                            <span><i class="fas fa-eye"></i></span>
                                        @endif
                                    </a>
                                @endcan
                            </div>
                            <div class="col-sm-6 text-center align-self-center">
                                {{ $note->author->full_name }}
                            </div>
                            @auth
                                <div class="col-sm-3 text-center align-self-center">
                                    <a type="button" class="btn btn-light share_note"
                                       data-url="{{ route('notes.share', ['note' => $note->getKey()]) }}"
                                       data-toggle="tooltip"
                                       data-placement="bottom"
                                       title="@lang('notes.share')">
                                        <span><i class="fas fa-share-alt"></i></span>
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $notes->links() }}
@endsection