<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @see: Встроенный валидатор придерживается этой спецификации
 *       https://html.spec.whatwg.org/multipage/input.html#valid-e-mail-address
 *       в рамках данного проекта нам необходимо чтобы в email был указан домен
 */
class TrueEmail implements Rule
{
    private const MAX_LENGTH = 250;

    private const VALIDATION_ERROR_MESSAGE = 'В середині EMAIL дозволено використання символів "-", ".", "_"';
    private const EMAIL_REGEX_PATTERN = '/^(?!^[-.,_])[a-zA-Z0-9\.\,\_\-]+@([-a-zA-Z0-9]+\.)+[a-zA-Z]{2,4}$/u';

    /**
     * @inheritdoc
     */
    public function passes($attribute, $value): bool
    {
        preg_match(self::EMAIL_REGEX_PATTERN, $value, $matches);

        return !($matches === false || strlen($value) > self::MAX_LENGTH);
    }

    /**
     * @inheritdoc
     */
    public function message(): string
    {
        return self::VALIDATION_ERROR_MESSAGE;
    }
}
