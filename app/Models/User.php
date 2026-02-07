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
        'phone_number',         // Importante: Adicionado para bater com o Controller
        'password',
        'role',                 // admin, dev, client
        'parent_id',            // ID do Pai (Dev ou Admin)
        'is_active',            // Status da conta
        'notes',                // Notas internas ou motivação
        'document_path',        // Caminho do documento (upload)
        'registration_message', // Mensagem original do form de solicitação
        'email_verified_at'
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
    | Relacionamentos Hierárquicos (Sistema de Equipe)
    |--------------------------------------------------------------------------
    */

    // Quem cadastrou este usuário? (O "Pai" / Líder)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // Quem são os liderados por este usuário? (A "Equipe" / Clientes)
    // Se for Dev, traz os Clientes. Se for Admin, pode trazer Devs ou Clientes diretos.
    public function team(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos de Imóveis
    |--------------------------------------------------------------------------
    */

    // Imóveis Off-Market que este usuário tem permissão explícita para ver
    // (Renomeado de accessibleProperties para authorizedProperties para manter padrão)
    public function authorizedProperties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_user_access', 'user_id', 'property_id')
                    ->withPivot('granted_by')
                    ->withTimestamps();
    }

    // Imóveis que o usuário favoritou
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'favorites', 'user_id', 'property_id')
                    ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers de Permissão & Papéis (Roles)
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

    // Verifica se um determinado ID pertence à equipe deste usuário
    // Útil para impedir que um Dev veja clientes de outro Dev
    public function isTeamMember($userId): bool
    {
        return $this->team()->where('id', $userId)->exists();
    }
}