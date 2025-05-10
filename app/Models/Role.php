<?php

namespace App\Models;

use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // N’oubliez pas d’importer User
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Role model.
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 */
class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the users that belong to the role.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Override the default factory to use RoleFactory.
     *
     * @return RoleFactory
     */
    protected static function newFactory()
    {
        return \Database\Factories\RoleFactory::new();
    }
}
