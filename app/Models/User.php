<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The roles that belong to the user.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * All media items (photos, vidéos, avatars, etc.) attached to the user.
     *
     * @return MorphMany
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    /**
     * The user's profile (one-to-one relation).
     *
     * @return BelongsTo
     */
    public function babysitterProfile(): BelongsTo
    {
        return $this->belongsTo(BabysitterProfile::class, 'id', 'user_id');
    }

    /**
     * The user's avatar (single media item in the 'avatar' collection).
     *
     * @return MorphOne
     */
    public function avatar(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable')
            ->where('collection_name', 'avatar');
    }

    /**
     * All media in the 'garde' collection (photos/vidéos de gardes effectuées).
     *
     * @return MorphMany
     */
    public function gardeMedia(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable')
            ->where('collection_name', 'garde');
    }

    /**
     * Scope a query to only include parents.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParents($query)
    {
        return $query->whereHas('roles', fn($q) => $q->where('name', env('PARENT_ROLE_NAME')));
    }

    /**
     * Scope a query to only include babysitters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBabysitters($query)
    {
        return $query->whereHas('roles', fn($q) => $q->where('name', env('BABYSITTER_ROLE_NAME')));
    }

    /**
     * Check if the user has a given role name.
     *
     * @param  string  $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles->contains('name', $roleName);
    }

    /**
     * Assign a role to the user.
     *
     * @param  mixed  $role  Role instance or role id
     * @return void
     */
    public function assignRole($role): void
    {
        $this->roles()->attach($role);
    }

    /**
     * Determine if the user is a Parent.
     *
     * @return bool
     */
    public function isParent(): bool
    {
        return $this->hasRole(env('PARENT_ROLE_NAME'));
    }

    /**
     * Determine if the user is a Babysitter.
     *
     * @return bool
     */
    public function isBabysitter(): bool
    {
        return $this->hasRole(env('BABYSITTER_ROLE_NAME'));
    }
}
