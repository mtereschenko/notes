<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Name;
use App\Rules\Password;
use App\Rules\TrueEmail;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public const NAME_FIELD = User::NAME_ATTRIBUTE;
    public const SURNAME_FIELD = User::SURNAME_ATTRIBUTE;
    public const EMAIL_FIELD = User::EMAIL_ATTRIBUTE;
    public const PASSWORD_FIELD = User::PASSWORD_ATTRIBUTE;
    public const PASSWORD_CONFIRMATION_FIELD = 'password_confirmation';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            self::NAME_FIELD => [
                'required',
                new Name(),
            ],
            self::SURNAME_FIELD => [
                'required',
                new Name(),
            ],
            self::EMAIL_FIELD => [
                'required',
                new TrueEmail(),
                'unique:users',
            ],
            self::PASSWORD_FIELD => [
                'required',
                new Password(),
                'confirmed',
            ],
            self::PASSWORD_CONFIRMATION_FIELD => [
                'required',
                'same:' . User::PASSWORD_ATTRIBUTE,
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            self::NAME_FIELD => trans('validation.attributes.' . self::NAME_FIELD),
            self::SURNAME_FIELD => trans('validation.attributes.' . self::SURNAME_FIELD),
            self::EMAIL_FIELD => trans('validation.attributes.' . self::EMAIL_FIELD),
            self::PASSWORD_FIELD => trans('validation.attributes.' . self::PASSWORD_FIELD),
            self::PASSWORD_CONFIRMATION_FIELD => trans('validation.attributes.' . self::PASSWORD_CONFIRMATION_FIELD),
        ];
    }
}
