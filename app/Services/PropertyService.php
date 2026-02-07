<?php

namespace App\Services;

use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PropertyService
{
    public function createProperty(array $data, User $creator): Property
    {
        return DB::transaction(function () use ($data, $creator) {
            $status = $creator->isAdmin() ? 'published' : 'draft';
            
            $property = Property::create([
                ...$data,
                'user_id' => $creator->id,
                'status' => $status,
                'approved_at' => $creator->isAdmin() ? now() : null,
            ]);

            return $property;
        });
    }

    public function updateProperty(Property $property, array $data): Property
    {
        $property->update($data);
        return $property;
    }

    public function grantAccess(Property $property, User $client, User $granter): void
    {
        if ($property->visibility === 'public') {
            return;
        }

        if (!$granter->isAdmin() && $granter->id !== $property->user_id) {
            throw new Exception("Unauthorized to grant access to this property.");
        }

        $property->authorizedUsers()->syncWithoutDetaching([
            $client->id => ['granted_by' => $granter->id]
        ]);
    }

    public function revokeAccess(Property $property, User $client): void
    {
        $property->authorizedUsers()->detach($client->id);
    }
}