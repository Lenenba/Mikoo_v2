<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    /**
     * @use HasFactory<\Database\Factories\AddressFactory>
     * @use SoftDeletes<\Illuminate\Database\Eloquent\SoftDeletes>
     */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are NOT mass assignable.
     *
     * @var array<int,string>
     */
    protected $guarded = [
        'id',
        'addressable_id',
        'addressable_type',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the owning model (ParentProfile or BabysitterProfile).
     *
     * @return MorphTo
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
