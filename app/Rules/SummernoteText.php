<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SummernoteText implements Rule
{
    private $min = 0;
    private $max = 0;

    public function __construct($min = 0, $max = 0)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @inheritdoc
     * @see NAMES https://nkb.atlassian.net/wiki/spaces/SME/pages/234324124
     */
    public function passes($attribute, $value): bool
    {
        $stripedValue = strip_tags($value);
        $length = strlen($stripedValue);

        if ($length < $this->min || $length > $this->max) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function message(): string
    {
        return "Довжина тексту має бути більшою ніж {$this->min} і меньшою ніж {$this->max}";
    }
}
