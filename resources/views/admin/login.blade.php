<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Diogo Maia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="bg-neutral-900 font-sans antialiased text-white h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white/5 border border-white/10 p-8 rounded-lg backdrop-blur-sm shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="font-serif text-3xl mb-2">Diogo Maia</h1>
            <p class="text-xs uppercase tracking-[0.2em] text-gray-400">Área Administrativa</p>
        </div>

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="email" class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Email</label>
                <input type="email" name="email" id="email" required autofocus
                       class="w-full bg-black/20 border border-white/10 rounded px-4 py-3 text-white focus:outline-none focus:border-[#c5a059] transition-colors">
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Senha</label>
                <input type="password" name="password" id="password" required
                       class="w-full bg-black/20 border border-white/10 rounded px-4 py-3 text-white focus:outline-none focus:border-[#c5a059] transition-colors">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="accent-[#c5a059]">
                    <span class="text-xs text-gray-400">Lembrar-me</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-[#c5a059] text-white font-bold py-3 uppercase tracking-widest text-xs hover:bg-[#b08d4b] transition-colors rounded">
                Entrar
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-white transition-colors">← Voltar ao Site</a>
        </div>
    </div>

</body>
</html>