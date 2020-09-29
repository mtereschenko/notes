<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Name implements Rule
{
    private const MIN_LENGTH = 2;
    private const MAX_LENGTH = 250;

    /**
     * @inheritdoc
     * @see NAMES https://nkb.atlassian.net/wiki/spaces/SME/pages/234324124
     */
    public function passes($attribute, $value): bool
    {
        $preg =
            '/^(?!^[\n .,!\'?\/’№@()=+*"”:`-])([0123456789а-ее-щьюяєіїґА-ЕЕ-ЩЬЮЯЄІЇҐ\/, .\'`\n’\-?№@!()=+*"”:])+$/u';
        preg_match($preg, $value, $matches);

        if (empty($matches)) {
            return false;
        }

        $length = strlen($value);

        if ($length < self::MIN_LENGTH || $length > self::MAX_LENGTH) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function message(): string
    {
        return 'Українські букви і спеціальні символи:   «’» - апостроф,  «-» - дефіс.';
    }
}
