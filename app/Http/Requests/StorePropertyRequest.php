<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StorePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autenticação já feita no middleware/rota
    }

    protected function prepareForValidation()
    {
        // Gera o slug automaticamente se não vier preenchido
        if (!$this->input('slug')) {
            $this->merge([
                'slug' => Str::slug($this->input('title')) . '-' . uniqid()
            ]);
        }
        
        // Garante valores booleanos para checkboxes não marcados
        $checkboxes = ['has_lift', 'has_garden', 'has_pool', 'has_terrace', 'has_balcony', 'has_air_conditioning', 'has_heating', 'is_accessible', 'is_furnished', 'is_kitchen_equipped', 'is_featured', 'is_visible'];
        foreach ($checkboxes as $field) {
            $this->merge([
                $field => $this->boolean($field)
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:properties,slug',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'status' => 'required|in:draft,published,pending', // Adicionado 'pending'
            'visibility' => 'required|in:public,off_market,private',
            
            // Localização
            'location' => 'nullable|string',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'city' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',

            // Áreas e Preços
            'price' => 'required|numeric|min:0',
            'area_gross' => 'nullable|numeric|min:0', // Corrigido de 'area'
            'area_useful' => 'nullable|numeric|min:0',
            'area_land' => 'nullable|numeric|min:0',

            // Detalhes
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'garages' => 'nullable|integer|min:0',
            'floor' => 'nullable|string',
            'orientation' => 'nullable|string',
            'built_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'condition' => 'nullable|string',
            'energy_rating' => 'nullable|string',

            // Booleans
            'has_lift' => 'boolean',
            'has_garden' => 'boolean',
            'has_pool' => 'boolean',
            'has_terrace' => 'boolean',
            'has_balcony' => 'boolean',
            'has_air_conditioning' => 'boolean',
            'has_heating' => 'boolean',
            'is_accessible' => 'boolean',
            'is_furnished' => 'boolean',
            'is_kitchen_equipped' => 'boolean',
            'is_featured' => 'boolean',
            'is_visible' => 'boolean',

            // Mídia
            'video_url' => 'nullable|url',
            'whatsapp_number' => 'nullable|string',
            'cover_image' => 'nullable|image|max:5120', // 5MB Max
            'gallery.*' => 'nullable|image|max:5120',   // Validação para array de imagens
        ];
    }
}