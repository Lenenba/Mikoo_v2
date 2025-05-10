<?php

namespace App\Models\Traits;

trait GuardsCommonFields
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
