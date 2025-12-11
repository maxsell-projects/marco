<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Imóvel | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
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

                <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">1. Informações Básicas</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Título do Anúncio</label>
                                <input type="text" name="title" required class="w-full border border-gray-200 rounded px-4 py-3" placeholder="Ex: Moradia T4 de Luxo com Piscina">
                            </div>
                            
                            <div class="grid grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Tipo</label>
                                    <select name="type" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                        <option value="Apartamento">Apartamento</option>
                                        <option value="Moradia">Moradia / Villa</option>
                                        <option value="Terreno">Terreno</option>
                                        <option value="Comercial">Comercial</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Status</label>
                                    <select name="status" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                        <option value="Venda">Venda</option>
                                        <option value="Arrendamento">Arrendamento</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Preço (€)</label>
                                    <input type="number" name="price" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="0.00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">2. Localização e Dimensões</h3>
                        <div class="grid grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Concelho / Zona</label>
                                <input type="text" name="location" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="Ex: Cascais, Quinta da Marinha">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Morada (Opcional)</label>
                                <input type="text" name="address" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="Rua...">
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Área Bruta (m²)</label>
                                <input type="number" name="area_gross" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Quartos</label>
                                <input type="number" name="bedrooms" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Casas de Banho</label>
                                <input type="number" name="bathrooms" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Cert. Energética</label>
                                <select name="energy_rating" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                    <option value="">Selecione</option>
                                    <option value="A+">A+</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6 mt-4">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Andar</label>
                                <input type="text" name="floor" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="Ex: 2º Esq, R/C">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Orientação Solar</label>
                                <select name="orientation" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                    <option value="">Selecione</option>
                                    <option value="Norte">Norte</option>
                                    <option value="Sul">Sul</option>
                                    <option value="Este">Este</option>
                                    <option value="Oeste">Oeste</option>
                                    <option value="Nascente/Poente">Nascente/Poente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">3. Comodidades</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="has_pool" class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Piscina</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="has_garden" class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Jardim</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="has_lift" class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Elevador</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="has_terrace" class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Terraço</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="has_air_conditioning" class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Ar Condicionado</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_furnished" class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Mobilado</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_kitchen_equipped" class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Cozinha Equipada</span>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">4. Mídia e Links</h3>
                        
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">WhatsApp (Nº Telemóvel)</label>
                                <input type="text" name="whatsapp_number" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="351912345678">
                                <p class="text-[10px] text-gray-400 mt-1">Insira o código do país sem + (Ex: 351...)</p>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Tour YouTube (Link)</label>
                                <input type="url" name="video_url" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="https://youtube.com/watch?v=...">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Foto de Capa (Principal)</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#c5a059]/10 file:text-[#c5a059] hover:file:bg-[#c5a059]/20">
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Galeria de Fotos (Múltiplas)</label>
                            <input type="file" name="gallery[]" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            <p class="text-[10px] text-gray-400 mt-1">Pressione Ctrl (ou Cmd) para selecionar várias fotos.</p>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Descrição Completa</label>
                        <textarea name="description" rows="6" class="w-full border border-gray-200 rounded px-4 py-3 resize-y"></textarea>
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
</body>
</html>