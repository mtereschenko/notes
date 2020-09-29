<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Password implements Rule
{
    private const PASSWORD_REGEX_PATTERN = '/^[\w]{8,15}$/';
    private const VALIDATION_ERROR_MESSAGE =
        'Пароль складається з латинських літер та цифр  без розділових знаків, пропусків і інших спеціальних знаків.';

    /**
     * @inheritdoc
     */
    public function passes($attribute, $value): bool
    {
        return (bool) preg_match(self::PASSWORD_REGEX_PATTERN, $value);
    }

    /**
     * @inheritdoc
     */
    public function message(): string
    {
        return self::VALIDATION_ERROR_MESSAGE;
    }
}
