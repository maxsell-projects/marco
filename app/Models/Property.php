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
        'slug', // <--- ADICIONADO
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
        'features', // <--- ADICIONADO
        'status',
        'visibility',
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

    // --- SCOPES ---

    public function scopeVisibleTo(Builder $query, ?User $user): Builder
    {
        // 1. Admin vê tudo
        if ($user && $user->isAdmin()) {
            return $query;
        }

        return $query->where(function ($q) use ($user) {
            // Regra A: Imóveis Públicos e Publicados (Todo mundo vê)
            $q->where('visibility', 'public')
              ->where('status', 'published');

            // Regra B: Se estiver logado...
            if ($user) {
                // ...vê os seus próprios imóveis (Dev/Owner)
                $q->orWhere('user_id', $user->id);

                // ...vê imóveis Off-Market/Privados onde tem permissão explícita
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