<?php

namespace App\Http\Requests;

use App\Models\Note;
use App\Rules\SummernoteText;
use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{

    public const TITLE_FIELD = Note::TITLE_ATTRIBUTE;
    public const BODY_FIELD = Note::BODY_ATTRIBUTE;

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
            self::TITLE_FIELD => [
                'required',
                'max:100',
            ],
            self::BODY_FIELD => [
                'required',
                new SummernoteText(250, 1000)
            ],
        ];
    }
}
