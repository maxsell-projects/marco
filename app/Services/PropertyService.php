<?php

namespace App\Services;

use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Exception;

class PropertyService
{
    public function createProperty(array $data, User $creator): Property
    {
        return DB::transaction(function () use ($data, $creator) {
            // 1. Definição de Status (Dev vs Admin)
            $status = $creator->isAdmin() ? ($data['status'] ?? 'published') : 'pending';
            
            // 2. Upload da Imagem de Capa
            if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
                $data['cover_image'] = $data['cover_image']->store('properties/covers', 'public');
            }

            // 3. Separar Galeria (não é coluna na tabela properties)
            $galleryImages = $data['gallery'] ?? [];
            unset($data['gallery']);

            // 4. Criação do Imóvel
            $property = Property::create([
                ...$data,
                'user_id' => $creator->id,
                'status' => $status,
                'approved_at' => $creator->isAdmin() ? now() : null,
            ]);

            // 5. Upload da Galeria
            $this->processGallery($property, $galleryImages);

            return $property;
        });
    }

    public function updateProperty(Property $property, array $data): Property
    {
        return DB::transaction(function () use ($property, $data) {
            
            // 1. Upload da Capa (Substituição)
            if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
                // Remove antiga se existir
                if ($property->cover_image) {
                    Storage::disk('public')->delete($property->cover_image);
                }
                $data['cover_image'] = $data['cover_image']->store('properties/covers', 'public');
            }

            // 2. Separar Galeria
            $galleryImages = $data['gallery'] ?? [];
            unset($data['gallery']);

            // 3. Atualiza Dados
            $property->update($data);

            // 4. Adiciona novas imagens à galeria
            $this->processGallery($property, $galleryImages);

            return $property;
        });
    }

    protected function processGallery(Property $property, array $images): void
    {
        if (empty($images)) return;

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $path = $image->store('properties/gallery', 'public');
                $property->images()->create([
                    'path' => $path,
                    'order' => 0 // Lógica de ordem pode ser implementada futuramente
                ]);
            }
        }
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