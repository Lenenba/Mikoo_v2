<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentProfile extends Model
{
    /**
     * @use HasFactory<\Database\Factories\ParentProfileFactory>
     * @use SoftDeletes<\Illuminate\Database\Eloquent\SoftDeletes>
     */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are NOT mass assignable.
     */
    protected $guarded = [
        'id',
        'user_id',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * One-to-one polymorphic relation to address.
     *
     * @return MorphOne
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
