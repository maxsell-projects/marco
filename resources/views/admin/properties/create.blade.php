<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Imóvel | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Estilo extra para o botão de remover a foto */
        .remove-btn {
            opacity: 0;
            transition: opacity 0.2s;
        }
        .photo-container:hover .remove-btn {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    <div class="flex h-screen">
        <aside class="w-64 bg-neutral-900 text-white p-6">
            <h1 class="font-serif text-xl mb-8">Diogo Maia</h1>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block text-gray-400 hover:text-white">Dashboard</a>
                <a href="{{ route('admin.properties.index') }}" class="block text-[#c5a059] font-bold">Imóveis</a>
            </nav>
        </aside>

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-3xl font-serif mb-8">Novo Imóvel (Padrão Idealista)</h2>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Ops! Algo correu mal:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">1. Informações Básicas</h3>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div class="md:col-span-1">
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Ref. Interna</label>
                                    <input type="text" name="reference_code" value="{{ old('reference_code') }}" class="w-full border border-gray-200 rounded px-4 py-3 bg-gray-50 focus:bg-white transition" placeholder="Ex: IMO-2024">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Título do Anúncio</label>
                                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full border border-gray-200 rounded px-4 py-3" placeholder="Ex: Moradia T4 de Luxo com Piscina">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Tipo</label>
                                    <select name="type" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                        <option value="Apartamento" {{ old('type') == 'Apartamento' ? 'selected' : '' }}>Apartamento</option>
                                        <option value="Moradia" {{ old('type') == 'Moradia' ? 'selected' : '' }}>Moradia / Villa</option>
                                        <option value="Terreno" {{ old('type') == 'Terreno' ? 'selected' : '' }}>Terreno</option>
                                        <option value="Comercial" {{ old('type') == 'Comercial' ? 'selected' : '' }}>Comercial</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Status</label>
                                    <select name="status" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                        <option value="Venda" {{ old('status') == 'Venda' ? 'selected' : '' }}>Venda</option>
                                        <option value="Arrendamento" {{ old('status') == 'Arrendamento' ? 'selected' : '' }}>Arrendamento</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Preço (€)</label>
                                    <input type="number" name="price" value="{{ old('price') }}" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="0.00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">2. Localização e Dimensões</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Concelho / Zona</label>
                                <input type="text" name="location" value="{{ old('location') }}" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="Ex: Cascais, Quinta da Marinha">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Morada (Opcional)</label>
                                <input type="text" name="address" value="{{ old('address') }}" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="Rua...">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Área Bruta (m²)</label>
                                <input type="number" name="area_gross" value="{{ old('area_gross') }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Quartos</label>
                                <input type="number" name="bedrooms" value="{{ old('bedrooms') }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Casas de Banho</label>
                                <input type="number" name="bathrooms" value="{{ old('bathrooms') }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Garagem (Lugares)</label>
                                <input type="number" name="garages" value="{{ old('garages') }}" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="Ex: 2">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Cert. Energética</label>
                                <select name="energy_rating" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                    <option value="">Selecione</option>
                                    <option value="A+" {{ old('energy_rating') == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A" {{ old('energy_rating') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('energy_rating') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ old('energy_rating') == 'C' ? 'selected' : '' }}>C</option>
                                    <option value="D" {{ old('energy_rating') == 'D' ? 'selected' : '' }}>D</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Andar</label>
                                <input type="text" name="floor" value="{{ old('floor') }}" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="Ex: 2º Esq, R/C">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Orientação Solar</label>
                                <select name="orientation" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                    <option value="">Selecione</option>
                                    <option value="Norte" {{ old('orientation') == 'Norte' ? 'selected' : '' }}>Norte</option>
                                    <option value="Sul" {{ old('orientation') == 'Sul' ? 'selected' : '' }}>Sul</option>
                                    <option value="Este" {{ old('orientation') == 'Este' ? 'selected' : '' }}>Este</option>
                                    <option value="Oeste" {{ old('orientation') == 'Oeste' ? 'selected' : '' }}>Oeste</option>
                                    <option value="Nascente/Poente" {{ old('orientation') == 'Nascente/Poente' ? 'selected' : '' }}>Nascente/Poente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">3. Comodidades</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="has_pool" class="accent-[#c5a059] w-5 h-5" {{ old('has_pool') ? 'checked' : '' }}> <span class="text-sm">Piscina</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="has_garden" class="accent-[#c5a059] w-5 h-5" {{ old('has_garden') ? 'checked' : '' }}> <span class="text-sm">Jardim</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="has_lift" class="accent-[#c5a059] w-5 h-5" {{ old('has_lift') ? 'checked' : '' }}> <span class="text-sm">Elevador</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="has_terrace" class="accent-[#c5a059] w-5 h-5" {{ old('has_terrace') ? 'checked' : '' }}> <span class="text-sm">Terraço</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="has_air_conditioning" class="accent-[#c5a059] w-5 h-5" {{ old('has_air_conditioning') ? 'checked' : '' }}> <span class="text-sm">Ar Condicionado</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="is_furnished" class="accent-[#c5a059] w-5 h-5" {{ old('is_furnished') ? 'checked' : '' }}> <span class="text-sm">Mobilado</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="is_kitchen_equipped" class="accent-[#c5a059] w-5 h-5" {{ old('is_kitchen_equipped') ? 'checked' : '' }}> <span class="text-sm">Cozinha Equipada</span>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">4. Mídia e Links</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">WhatsApp (Nº Telemóvel)</label>
                                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="351912345678">
                                <p class="text-[10px] text-gray-400 mt-1">Insira o código do país sem + (Ex: 351...)</p>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Tour YouTube (Link)</label>
                                <input type="url" name="video_url" value="{{ old('video_url') }}" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="https://youtube.com/watch?v=...">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Foto de Capa (Principal)</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#c5a059]/10 file:text-[#c5a059] hover:file:bg-[#c5a059]/20">
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Galeria de Fotos (Múltiplas)</label>
                            
                            <input type="file" 
                                   id="gallery-input" 
                                   name="gallery[]" 
                                   multiple 
                                   accept="image/*" 
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                            
                            <p class="text-[10px] text-gray-400 mt-1">
                                Pode selecionar várias vezes. As fotos acumulam-se abaixo.
                            </p>

                            <div id="gallery-preview" class="grid grid-cols-3 md:grid-cols-5 gap-4 mt-4">
                                </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Descrição Completa</label>
                        <textarea name="description" rows="6" class="w-full border border-gray-200 rounded px-4 py-3 resize-y">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#c5a059] text-white px-10 py-4 rounded text-xs uppercase tracking-widest font-bold hover:bg-[#b08d4b] transition shadow-lg transform hover:-translate-y-1">
                            Publicar Imóvel
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('gallery-input');
            const previewContainer = document.getElementById('gallery-preview');
            const dt = new DataTransfer(); 

            input.addEventListener('change', function() {
                for(let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    dt.items.add(file);

                    const div = document.createElement('div');
                    div.className = "photo-container relative h-24 w-full rounded-lg overflow-hidden border border-gray-200 shadow-sm group";
                    
                    const img = document.createElement('img');
                    img.className = "h-full w-full object-cover";
                    
                    const btn = document.createElement('button');
                    btn.innerHTML = '&times;';
                    btn.className = "remove-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md hover:bg-red-600 focus:outline-none";
                    btn.title = "Remover foto";

                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };

                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        div.remove();
                        updateInputFiles(file);
                    });

                    div.appendChild(img);
                    div.appendChild(btn);
                    previewContainer.appendChild(div);
                }
                this.files = dt.files;
            });

            function updateInputFiles(fileToRemove) {
                const newDt = new DataTransfer();
                for (let i = 0; i < dt.files.length; i++) {
                    const file = dt.files[i];
                    if (file !== fileToRemove) {
                        newDt.items.add(file);
                    }
                }
                dt.items.clear();
                for (let i = 0; i < newDt.files.length; i++) {
                    dt.items.add(newDt.files[i]);
                }
                input.files = dt.files;
            }
        });
    </script>
</body>
</html>