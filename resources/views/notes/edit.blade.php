@extends('layouts.app')

@section('content')
    <div id="article_item">
        <div class="col-md-12" id="note_form">
            <form method="post"
                 action="{{ route('notes.store', ['slug' => $note->{\App\Models\Note::SLUG_ATTRIBUTE}]) }}">
                @csrf
                <input type="hidden" name="{{ $note->getKeyName() }}" value="{{ $note->getKey() }}">
                <div class="form-group">
                    <label for="title">@lang('notes.' . \App\Models\Note::TITLE_ATTRIBUTE)</label>
                    <input type="text"
                           class="form-control  @error(\App\Models\Note::TITLE_ATTRIBUTE) is-invalid @enderror"
                           name="{{ \App\Models\Note::TITLE_ATTRIBUTE }}"
                           id="title" aria-describedby="titleHelp"
                           placeholder="@lang('notes.fill your note title')"
                           value="{{ old(\App\Models\Note::TITLE_ATTRIBUTE) ?? $note->{\App\Models\Note::TITLE_ATTRIBUTE} }}">
                    @if ($errors->has(\App\Models\Note::TITLE_ATTRIBUTE))
                        <div class="text-danger">
                            {{ $errors->first(\App\Models\Note::TITLE_ATTRIBUTE) }}
                        </div>
                    @endif
                    <small id="titleHelp"
                           class="form-text text-muted">@lang('notes.title should represent your note message')</small>
                </div>
                <div class="form-group">
                    <label
                            for="body"
                            aria-describedby="bodyeHelp"
                    >@lang('notes.' . \App\Models\Note::BODY_ATTRIBUTE)</label>
                    @if ($errors->has(\App\Models\Note::BODY_ATTRIBUTE))
                        <div class="text-danger">
                            {{ $errors->first(\App\Models\Note::BODY_ATTRIBUTE) }}
                        </div>
                    @endif
                    <small id="bodyHelp"
                           class="form-text text-muted">@lang('notes.show yourself')</small>
                    <textarea
                            name="{{ \App\Models\Note::BODY_ATTRIBUTE }}"
                            id="body"
                            class="summernote form-control"
                    >{!! old(\App\Models\Note::BODY_ATTRIBUTE) ?? $note->{\App\Models\Note::BODY_ATTRIBUTE} !!}</textarea>
                </div>
                <div id="form_save_buttons">
                    <button
                            type="submit" class="btn btn-outline-success">
                        <span class="fas fa-save"></span> @lang('notes.save')
                    </button>
                    <a href="{{ url()->previous() }}"
                       type="button"
                       class="btn btn-outline-danger need_to_fade">
                        <span class="fas fa-ban"></span> @lang('notes.cancel')
                    </a>
                </div>
                </form>
            </form>
        </div>
@endsection