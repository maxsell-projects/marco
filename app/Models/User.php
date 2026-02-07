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

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',                 // admin, dev, client
        'parent_id',            // ID do Dev (se for cliente)
        'is_active',            // true/false
        'registration_message', // Mensagem de motivação
        'document_path',        // Caminho do PDF/Imagem
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
            'is_active' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos Hierárquicos (Dev <-> Cliente)
    |--------------------------------------------------------------------------
    */

    // Quem é o "Pai" deste usuário? (Ex: O Dev dono deste Cliente)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // Quem são os "Filhos" deste usuário? (Ex: Clientes deste Dev)
    public function clients(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos de Imóveis
    |--------------------------------------------------------------------------
    */

    // Imóveis Off-Market que este usuário tem permissão para ver
    public function accessibleProperties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_user_access', 'user_id', 'property_id')
                    ->withPivot('granted_by')
                    ->withTimestamps();
    }

    // Imóveis favoritados pelo usuário
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'favorites', 'user_id', 'property_id')
                    ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers de Função (Roles)
    |--------------------------------------------------------------------------
    */

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
}