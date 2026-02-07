@extends('layouts.app')

@section('title', __('access.meta.title') . ' | Porthouse Private Office')

@section('content')

<div class="min-h-screen flex flex-col lg:flex-row font-sans">
    
    {{-- Lado Esquerdo (Mantive igual) --}}
    <div class="lg:w-1/2 bg-brand-secondary relative min-h-[40vh] lg:min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1613545325278-f24b0cae1224?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-40"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-brand-secondary/90 to-transparent"></div>
        
        <div class="relative z-10 p-12 lg:p-24 text-white max-w-xl" data-aos="fade-right">
            <p class="text-brand-sand font-mono text-xs uppercase tracking-[0.4em] mb-6 flex items-center gap-3">
                <span class="w-8 h-[1px] bg-brand-sand"></span>
                {{ __('access.hero.subtitle') }}
            </p>
            <h1 class="text-4xl lg:text-6xl font-serif mb-8 leading-tight">
                {{ __('access.hero.title') }}
            </h1>
            <p class="text-gray-300 font-light text-lg leading-relaxed mb-8">
                {{ __('access.hero.description') }}
            </p>
        </div>
    </div>

    {{-- Lado Direito (Formulário) --}}
    <div class="lg:w-1/2 bg-white flex flex-col justify-center p-8 lg:p-24 overflow-y-auto relative pt-32 lg:pt-24">
        <div class="w-full max-w-lg mx-auto" data-aos="fade-up">
            
            {{-- MENSAGEM DE SUCESSO (Correção de Visibilidade) --}}
            @if(session('success'))
                <div class="mb-8 p-6 bg-green-50 border-l-4 border-green-500 shadow-sm rounded-r-md animate-pulse">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 bg-green-100 p-2 rounded-full">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-green-800 uppercase tracking-wide">Sucesso!</h3>
                            <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- MENSAGEM DE ERRO GERAL --}}
            @if ($errors->any())
                <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 shadow-sm rounded-r-md">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-red-800 uppercase tracking-wide">Atenção</h3>
                            <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <h2 class="font-serif text-3xl text-brand-secondary mb-2">{{ __('access.form.heading') }}</h2>
            <p class="text-gray-500 text-sm mb-10">{{ __('access.form.subheading') }}</p>

            <form action="{{ route('access.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- NOVO: TIPO DE CONTA --}}
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="client" class="peer sr-only" {{ old('type', 'client') == 'client' ? 'checked' : '' }}>
                        <div class="text-center p-4 border border-gray-200 rounded-sm peer-checked:border-brand-primary peer-checked:bg-brand-primary/5 transition-all">
                            <p class="text-xs font-bold uppercase tracking-widest text-brand-secondary peer-checked:text-brand-primary">{{ __('access.type.client') }}</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="dev" class="peer sr-only" {{ old('type') == 'dev' ? 'checked' : '' }}>
                        <div class="text-center p-4 border border-gray-200 rounded-sm peer-checked:border-brand-primary peer-checked:bg-brand-primary/5 transition-all">
                            <p class="text-xs font-bold uppercase tracking-widest text-brand-secondary peer-checked:text-brand-primary">{{ __('access.type.partner') }}</p>
                        </div>
                    </label>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-brand-secondary">{{ __('access.form.name') }}</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           class="w-full bg-gray-50 border border-gray-200 p-4 text-sm focus:outline-none focus:border-brand-primary focus:bg-white transition-colors rounded-sm">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-brand-secondary">{{ __('access.form.email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="w-full bg-gray-50 border border-gray-200 p-4 text-sm focus:outline-none focus:border-brand-primary focus:bg-white transition-colors rounded-sm">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-brand-secondary">{{ __('access.form.phone') }}</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required 
                           class="w-full bg-gray-50 border border-gray-200 p-4 text-sm focus:outline-none focus:border-brand-primary focus:bg-white transition-colors rounded-sm">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-brand-secondary">{{ __('access.form.motivation') }}</label>
                    <textarea name="motivation" rows="4" required 
                              class="w-full bg-gray-50 border border-gray-200 p-4 text-sm focus:outline-none focus:border-brand-primary focus:bg-white transition-colors rounded-sm"
                              placeholder="{{ __('access.form.motivation_placeholder') }}">{{ old('motivation') }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-brand-secondary">Documento (Opcional)</label>
                    <div class="relative border border-dashed border-gray-300 bg-gray-50 p-6 text-center hover:bg-gray-100 transition-colors rounded-sm group cursor-pointer">
                        <input type="file" name="document" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="flex flex-col items-center justify-center gap-2 pointer-events-none">
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <span class="text-xs text-gray-500">Anexar PDF ou Imagem</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input type="checkbox" name="consent" required class="mt-1 w-4 h-4 text-brand-primary border-gray-300 rounded focus:ring-brand-primary">
                        <span class="text-xs text-gray-500 leading-relaxed group-hover:text-gray-700">
                            {{ __('access.form.consent') }} 
                            <a href="{{ route('terms') }}" class="underline text-brand-secondary">{{ __('access.form.terms') }}</a>.
                        </span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-brand-secondary text-white font-bold uppercase tracking-[0.2em] text-sm py-5 hover:bg-brand-primary transition-all duration-300 shadow-lg transform hover:-translate-y-1">
                    {{ __('access.form.submit_btn') }}
                </button>

            </form>
        </div>
    </div>
</div>

@endsection