<?php

namespace App\Models\Traits;

trait GuardsCommonFields
{
    /**
     * Common attributes to guard.
     */
    public static function commonGuarded(): array
    {
        return [
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }
}
