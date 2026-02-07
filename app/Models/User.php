<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'role',
        'parent_id',
        'is_active',
        'notes',
        'document_path',
        'registration_message',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function team(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function authorizedProperties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_user_access', 'user_id', 'property_id')
                    ->withPivot('granted_by')
                    ->withTimestamps();
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'favorites', 'user_id', 'property_id')
                    ->withTimestamps();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDev(): bool
    {
        return $this->role === 'dev';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isTeamMember(int $userId): bool
    {
        return $this->team()->where('id', $userId)->exists();
    }
}