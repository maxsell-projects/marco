<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Diogo Maia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-900">

    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-neutral-900 text-white flex flex-col">
            <div class="p-6 text-center border-b border-white/10">
                <h1 class="font-serif text-xl">Diogo Maia</h1>
                <p class="text-[10px] uppercase tracking-widest text-gray-500 mt-1">Admin Panel</p>
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 bg-[#c5a059] text-white rounded text-sm font-medium">Dashboard</a>
                <a href="{{ route('admin.properties.index') }}" class="block px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded text-sm font-medium transition">Gerir Imóveis</a>
            </nav>
            <div class="p-4 border-t border-white/10">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-xs uppercase tracking-widest text-gray-500 hover:text-white transition">
                        Sair
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-serif text-gray-800">Visão Geral</h2>
                
                <a href="{{ route('admin.properties.create') }}" class="flex items-center gap-2 bg-[#c5a059] text-white px-6 py-3 rounded shadow hover:bg-[#b08d4b] transition font-bold uppercase text-xs tracking-widest">
                    <span>+</span> Cadastrar Novo Imóvel
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded shadow-sm border border-gray-100">
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Imóveis Ativos</p>
                    <p class="text-3xl font-serif text-[#c5a059]">{{ \App\Models\Property::count() }}</p>
                </div>
            </div>
        </main>
    </div>

</body>
</html>