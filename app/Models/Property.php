<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'price',
        'area',
        'address',
        'city',
        'state',
        'zip_code',
        'bedrooms',
        'bathrooms',
        'garage',
        'features',
        'status',
        'visibility', // public, private, off-market
        'approved_at'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area' => 'decimal:2',
        'approved_at' => 'datetime',
        'features' => 'array',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function authorizedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'property_user_access', 'property_id', 'user_id')
                    ->withPivot('granted_by')
                    ->withTimestamps();
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'property_id', 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes de Segurança e Visibilidade
    |--------------------------------------------------------------------------
    */

    public function scopeVisibleTo(Builder $query, ?User $user): Builder
    {
        // 1. Admin: Omnipresente (vê absolutamente tudo)
        if ($user && $user->isAdmin()) {
            return $query;
        }

        return $query->where(function ($q) use ($user) {
            // Regra 1: O que é público e está publicado, todos vêem
            $q->where('visibility', 'public')
              ->where('status', 'published');

            if ($user) {
                // Regra 2: O dono do imóvel (Dev que cadastrou) sempre vê o seu
                $q->orWhere('user_id', $user->id);

                // Regra 3: Acesso granular via Pivot (O Admin deu acesso ao Dev, ou o Dev ao Cliente)
                $q->orWhereHas('authorizedUsers', function ($subQ) use ($user) {
                    $subQ->where('users.id', $user->id);
                });
            }
        });
    }

    public function scopeOffMarket(Builder $query): Builder
    {
        return $query->where('visibility', '!=', 'public');
    }
}