@extends('layouts.app')

@section('title', 'Portfólio de Imóveis | Porthouse Private Office')

@section('content')

{{-- HERO SECTION - CLEAN LUXURY --}}
<section class="bg-brand-secondary text-white py-32 text-center relative overflow-hidden">
    {{-- Textura sutil de fundo --}}
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    
    <div class="container mx-auto px-6 relative z-10" data-aos="fade-up">
        {{-- Logo Clean (Sem escrita) --}}
        <div class="flex justify-center mb-8">
            <img src="{{ asset('img/clean.png') }}" alt="Porthouse" class="h-24 w-auto object-contain brightness-0 invert">
        </div>

        <p class="text-brand-sand font-sans text-[10px] font-bold uppercase tracking-[0.5em] mb-4 flex justify-center items-center gap-4">
            <span class="w-8 h-[1px] bg-brand-sand/30"></span>
            Imóveis Exclusivos
            <span class="w-8 h-[1px] bg-brand-sand/30"></span>
        </p>
        <h1 class="text-4xl md:text-5xl font-serif italic text-brand-sand leading-tight">
            Curadoria <span class="text-white not-italic">Private Office</span>
        </h1>
    </div>
</section>

<section class="py-24 bg-white text-brand-text min-h-screen">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-16">
            
            {{-- SIDEBAR DE FILTROS --}}
            <aside class="lg:col-span-1">
                <div class="bg-white p-8 border border-slate-100 shadow-2xl shadow-slate-200/50 sticky top-32" data-aos="fade-right">
                    <div class="flex justify-between items-center mb-10 border-b border-slate-100 pb-5">
                        <h3 class="font-serif text-xl text-brand-secondary font-semibold">Refinar Busca</h3>
                        <a href="{{ route('portfolio') }}" class="text-[9px] font-bold text-slate-400 uppercase hover:text-brand-primary tracking-widest transition-colors">
                            Limpar
                        </a>
                    </div>
                    
                    <form action="{{ route('portfolio') }}" method="GET" class="space-y-8">
                        
                        {{-- Busca Livre --}}
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-brand-secondary mb-3 block">Localização</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cidade ou região..." 
                                       class="w-full bg-white border-b border-slate-200 px-0 py-3 text-sm focus:outline-none focus:border-brand-primary transition-colors placeholder-slate-300 font-light">
                                <svg class="w-4 h-4 text-slate-300 absolute right-0 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                        </div>

                        {{-- Tipo --}}
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-brand-secondary mb-3 block">Tipo de Imóvel</label>
                            <select name="type" class="w-full bg-white border-b border-slate-200 py-3 text-sm focus:outline-none focus:border-brand-primary text-slate-600 appearance-none rounded-none cursor-pointer">
                                <option value="">Todos os Tipos</option>
                                <option value="Apartamento" {{ request('type') == 'Apartamento' ? 'selected' : '' }}>Apartamento</option>
                                <option value="Moradia" {{ request('type') == 'Moradia' ? 'selected' : '' }}>Moradia</option>
                                <option value="Terreno" {{ request('type') == 'Terreno' ? 'selected' : '' }}>Terreno</option>
                                <option value="Comercial" {{ request('type') == 'Comercial' ? 'selected' : '' }}>Comercial</option>
                            </select>
                        </div>

                        {{-- Objetivo --}}
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-brand-secondary mb-4 block">Objetivo</label>
                            <div class="flex gap-8">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="status" value="Venda" {{ request('status') == 'Venda' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="w-4 h-4 border border-slate-200 rounded-full peer-checked:border-brand-primary peer-checked:bg-brand-primary transition-all"></div>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 group-hover:text-brand-primary peer-checked:text-brand-primary">Comprar</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="status" value="Arrendamento" {{ request('status') == 'Arrendamento' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="w-4 h-4 border border-slate-200 rounded-full peer-checked:border-brand-primary peer-checked:bg-brand-primary transition-all"></div>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 group-hover:text-brand-primary peer-checked:text-brand-primary">Arrendar</span>
                                </label>
                            </div>
                        </div>

                        {{-- Preço --}}
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-brand-secondary mb-3 block">Faixa de Preço (€)</label>
                            <div class="grid grid-cols-2 gap-6">
                                <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Mín." 
                                       class="w-full border-b border-slate-200 py-2 text-sm focus:border-brand-primary outline-none transition-colors placeholder-slate-300 font-light">
                                <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Máx." 
                                       class="w-full border-b border-slate-200 py-2 text-sm focus:border-brand-primary outline-none transition-colors placeholder-slate-300 font-light">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-brand-primary text-white font-bold uppercase tracking-[0.25em] text-[10px] py-5 hover:bg-brand-secondary transition-all duration-500 shadow-xl shadow-brand-primary/10">
                            Aplicar Filtros
                        </button>
                    </form>
                </div>
            </aside>

            {{-- GRID DE IMÓVEIS --}}
            <div class="lg:col-span-3">
                <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4 border-b border-slate-100 pb-6">
                    <div>
                        <h2 class="font-serif text-4xl text-brand-text leading-none italic">Resultados</h2>
                        <p class="text-slate-400 text-[10px] mt-3 uppercase tracking-[0.2em] font-bold">{{ $properties->total() }} propriedades encontradas</p>
                    </div>
                    
                    <div class="flex items-center gap-4 text-[10px] uppercase tracking-widest text-slate-400 font-bold">
                        <span>Ordenar:</span>
                        <select onchange="window.location.href=this.value" class="bg-transparent border-none text-brand-secondary focus:ring-0 cursor-pointer text-[10px] font-bold p-0">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Recentes</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Preço (Maior)</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Preço (Menor)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-12">
                    @forelse($properties as $property)
                        <article class="group flex flex-col h-full bg-white transition-all duration-500">
                            
                            {{-- Capa Editorial --}}
                            <div class="relative aspect-[4/5] overflow-hidden mb-6">
                                <a href="{{ route('properties.show', $property->slug) }}" class="block h-full w-full">
                                    <div class="absolute inset-0 bg-brand-secondary/20 opacity-0 group-hover:opacity-100 transition-opacity z-10 duration-500"></div>
                                    <img src="{{ $property->cover_image ? Storage::url($property->cover_image) : asset('img/clean.png') }}" 
                                         alt="{{ $property->title }}" 
                                         class="w-full h-full object-cover grayscale-[20%] group-hover:grayscale-0 transform group-hover:scale-105 transition duration-[1.5s] ease-out">
                                </a>
                                
                                {{-- Badges Luxury --}}
                                <div class="absolute top-6 left-6 flex flex-col gap-2 z-20">
                                    <span class="bg-white px-3 py-1 text-[9px] font-bold uppercase tracking-[0.2em] text-brand-secondary shadow-sm">
                                        {{ $property->type }}
                                    </span>
                                    @if($property->is_featured)
                                        <span class="bg-brand-primary px-3 py-1 text-[9px] font-bold uppercase tracking-[0.2em] text-white shadow-sm">
                                            Destaque
                                        </span>
                                    @endif
                                </div>

                                {{-- Preço no Canto --}}
                                <div class="absolute bottom-6 right-0 bg-brand-secondary text-white px-6 py-3 font-serif text-xl z-20 shadow-xl">
                                    {{ $property->price ? number_format($property->price, 0, ',', '.') . ' €' : 'Sob Consulta' }}
                                </div>
                            </div>

                            {{-- Detalhes --}}
                            <div class="flex flex-col flex-grow">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-sand"></span>
                                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">
                                        {{ $property->city ?? 'Portugal' }}
                                    </span>
                                </div>

                                <h3 class="font-serif text-2xl text-brand-text mb-4 leading-tight group-hover:text-brand-primary transition-colors duration-300">
                                    <a href="{{ route('properties.show', $property->slug) }}">
                                        {{ $property->title }}
                                    </a>
                                </h3>

                                <p class="text-slate-500 text-sm font-light line-clamp-2 mb-8 leading-relaxed">
                                    {{ Str::limit($property->description, 120) }}
                                </p>

                                {{-- Features Bar --}}
                                <div class="mt-auto pt-6 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400 font-bold uppercase tracking-widest">
                                    @if($property->bedrooms)
                                        <span class="flex items-center gap-2" title="Quartos">
                                            <svg class="w-4 h-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                            {{ $property->bedrooms }} T
                                        </span>
                                    @endif

                                    @if($property->area_gross)
                                        <span class="flex items-center gap-2" title="Área">
                                            <svg class="w-4 h-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                            {{ number_format($property->area_gross, 0) }} m²
                                        </span>
                                    @endif
                                    
                                    <a href="{{ route('properties.show', $property->slug) }}" class="text-brand-primary hover:text-brand-secondary transition-colors">
                                        Detalhes →
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full text-center py-40 border border-dashed border-slate-200 bg-slate-50/30">
                            <h3 class="font-serif text-2xl text-slate-300 italic mb-4">Nenhum imóvel corresponde aos seus critérios.</h3>
                            <a href="{{ route('portfolio') }}" class="text-[10px] font-bold uppercase tracking-widest text-brand-primary border-b border-brand-primary pb-1">Ver Portfólio Completo</a>
                        </div>
                    @endforelse
                </div>

                {{-- PAGINAÇÃO CUSTOM --}}
                <div class="mt-24">
                    {{ $properties->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection