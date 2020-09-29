@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@lang('auth.Register')</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="{{ \App\Models\User::NAME_ATTRIBUTE }}"
                                       class="col-md-4 col-form-label text-md-right">
                                    @lang('user.' . \App\Models\User::NAME_ATTRIBUTE)
                                </label>

                                <div class="col-md-6">
                                    <input id="{{ \App\Models\User::NAME_ATTRIBUTE }}" type="text"
                                           class="form-control @error(\App\Models\User::NAME_ATTRIBUTE) is-invalid @enderror"
                                           name="{{ \App\Models\User::NAME_ATTRIBUTE }}"
                                           value="{{ old(\App\Models\User::NAME_ATTRIBUTE) }}" required
                                           autocomplete="{{ \App\Models\User::NAME_ATTRIBUTE }}" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                        for="{{ \App\Models\User::SURNAME_ATTRIBUTE }}"
                                        class="col-md-4 col-form-label text-md-right">
                                    @lang('user.' . \App\Models\User::SURNAME_ATTRIBUTE)
                                </label>

                                <div class="col-md-6">
                                    <input id="{{ \App\Models\User::SURNAME_ATTRIBUTE }}" type="text"
                                           class="form-control @error(\App\Models\User::SURNAME_ATTRIBUTE) is-invalid @enderror"
                                           name="{{ \App\Models\User::SURNAME_ATTRIBUTE }}"
                                           value="{{ old(\App\Models\User::SURNAME_ATTRIBUTE) }}" required
                                           autocomplete="{{ \App\Models\User::SURNAME_ATTRIBUTE }}" autofocus>

                                    @error(\App\Models\User::SURNAME_ATTRIBUTE)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="{{ \App\Models\User::EMAIL_ATTRIBUTE }}"
                                       class="col-md-4 col-form-label text-md-right">
                                    @lang('user.' . \App\Models\User::EMAIL_ATTRIBUTE)
                                </label>

                                <div class="col-md-6">
                                    <input id="{{ \App\Models\User::EMAIL_ATTRIBUTE }}" type="email"
                                           class="form-control @error(\App\Models\User::EMAIL_ATTRIBUTE) is-invalid @enderror"
                                           name="{{ \App\Models\User::EMAIL_ATTRIBUTE }}"
                                           value="{{ old('email') }}" required
                                           autocomplete="{{ \App\Models\User::EMAIL_ATTRIBUTE }}">

                                    @error(\App\Models\User::EMAIL_ATTRIBUTE)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="{{ \App\Models\User::PASSWORD_ATTRIBUTE }}"
                                       class="col-md-4 col-form-label text-md-right">@lang('user.' . \App\Models\User::PASSWORD_ATTRIBUTE)</label>

                                <div class="col-md-6">
                                    <input id="{{ \App\Models\User::PASSWORD_ATTRIBUTE }}" type="password"
                                           class="form-control @error(\App\Models\User::PASSWORD_ATTRIBUTE) is-invalid @enderror"
                                           name="{{ \App\Models\User::PASSWORD_ATTRIBUTE }}"
                                           required autocomplete="new-password">

                                    @error(\App\Models\User::PASSWORD_ATTRIBUTE)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">@lang('auth.confirm_password')</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @lang('auth.Register')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
