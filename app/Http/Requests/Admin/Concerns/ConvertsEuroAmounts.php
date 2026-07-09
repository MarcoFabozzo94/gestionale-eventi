<?php

namespace App\Http\Requests\Admin\Concerns;

trait ConvertsEuroAmounts
{
    protected function eurosToCents(string|int|float|null $amount): int
    {
        if ($amount === null || $amount === '') {
            return 0;
        }

        $normalized = str_replace(',', '.', (string) $amount);

        return (int) round(((float) $normalized) * 100);
    }
}
