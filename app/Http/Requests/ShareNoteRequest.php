<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\TrueEmail;
use Illuminate\Foundation\Http\FormRequest;

class ShareNoteRequest extends FormRequest
{

    public const EMAIL_FIELD = User::EMAIL_ATTRIBUTE;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            self::EMAIL_FIELD => [
                'required',
                new TrueEmail(),
            ],
        ];
    }
}
