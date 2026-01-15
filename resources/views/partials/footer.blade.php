<footer class="bg-brand-secondary text-white pt-24 pb-12 border-t border-brand-sand/10 relative overflow-hidden font-sans">
    
    {{-- Marca d'água decorativa --}}
    <div class="absolute top-0 right-0 p-0 opacity-[0.03] pointer-events-none select-none">
        <span class="font-serif text-[15rem] leading-none text-white">MM</span>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        
        {{-- TOP SECTION: Brand & Newsletter --}}
        <div class="flex flex-col md:flex-row justify-between items-start border-b border-white/10 pb-16 mb-16 gap-12">
            <div class="max-w-md">
                <a href="{{ route('home') }}" class="block mb-6 group">
                    <span class="font-serif text-3xl text-brand-sand tracking-wide block">MARCO MOURA</span>
                    <span class="text-[9px] uppercase tracking-[0.4em] text-white/60 group-hover:text-white transition-colors">Private Real Estate</span>
                </a>
                <p class="text-white/60 font-light leading-relaxed text-sm">
                    Consultoria imobiliária independente especializada em ativos de investimento e propriedades de luxo em Portugal. 
                    <br><span class="italic text-brand-sand/80">Rigor, Discrição e Estratégia.</span>
                </p>
            </div>

            {{-- Newsletter --}}
            <div class="w-full md:w-auto">
                <h4 class="text-xs font-bold uppercase tracking-widest text-brand-sand mb-4">Junte-se ao Private Circle</h4>
                <form class="flex flex-col md:flex-row gap-4">
                    <input type="email" placeholder="O seu email corporativo" class="bg-white/5 border border-white/10 text-white px-4 py-3 w-full md:w-80 focus:outline-none focus:border-brand-sand transition-colors text-sm font-light placeholder-white/30">
                    <button type="button" class="bg-brand-primary text-white px-6 py-3 text-xs font-bold uppercase tracking-widest hover:bg-white hover:text-brand-secondary transition-colors shadow-lg">
                        Subscrever
                    </button>
                </form>
                <p class="text-[10px] text-white/30 mt-2">Apenas *Market Insights* relevantes. Zero spam.</p>
            </div>
        </div>

        {{-- MAIN GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">
            
            {{-- 1. ESCRITÓRIO --}}
            <div>
                <h5 class="text-xs font-bold uppercase tracking-widest mb-8 text-brand-sand flex items-center gap-2">
                    <span class="w-2 h-2 bg-brand-sand rounded-full"></span> O Escritório
                </h5>
                <ul class="space-y-4 text-sm text-white/70 font-light">
                    <li>
                        <span class="block text-[10px] uppercase opacity-40 mb-1">Morada</span>
                        Avenida da Liberdade, nº 000<br>
                        1250-000 Lisboa, Portugal
                    </li>
                    <li>
                        <span class="block text-[10px] uppercase opacity-40 mb-1">Contacto Directo</span>
                        <a href="tel:+351000000000" class="hover:text-white transition">+351 000 000 000</a>
                        <span class="text-[10px] opacity-50 ml-2">(Chamada para rede móvel nacional)</span>
                    </li>
                    <li>
                        <span class="block text-[10px] uppercase opacity-40 mb-1">Email</span>
                        <a href="mailto:privado@marcomoura.pt" class="hover:text-white transition">privado@marcomoura.pt</a>
                    </li>
                </ul>
            </div>

            {{-- 2. NAVEGAÇÃO --}}
            <div>
                <h5 class="text-xs font-bold uppercase tracking-widest mb-8 text-brand-sand">Menu</h5>
                <ul class="space-y-3 text-sm text-white/70 font-light">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-sand transition-colors hover:pl-2 duration-300">Início</a></li>
                    <li><a href="{{ route('portfolio') }}" class="hover:text-brand-sand transition-colors hover:pl-2 duration-300">Coleção Privada</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-brand-sand transition-colors hover:pl-2 duration-300">A Visão</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-brand-sand transition-colors hover:pl-2 duration-300">Contactos</a></li>
                </ul>
            </div>

            {{-- 3. LEGAL & COMPLIANCE (SOP) --}}
            <div x-data>
                <h5 class="text-xs font-bold uppercase tracking-widest mb-8 text-brand-sand">Legal & Compliance</h5>
                <ul class="space-y-3 text-xs text-white/50 font-light font-mono">
                    <li>AMI: <span class="text-white">12345</span></li>
                    <li>NIF: <span class="text-white">999999999</span></li>
                    <li class="pt-4 border-t border-white/5">
                        <a href="{{ route('terms') }}" class="hover:text-white transition">Termos e Condições</a>
                    </li>
                    {{-- GATILHOS DO MODAL --}}
                    <li><button @click="$dispatch('open-privacy-modal', {tab: 'privacy'})" class="hover:text-white transition text-left">Política de Privacidade</button></li>
                    <li><button @click="$dispatch('open-privacy-modal', {tab: 'cookies'})" class="hover:text-white transition text-left">Política de Cookies</button></li>
                    <li><button @click="$dispatch('open-privacy-modal', {tab: 'ral'})" class="hover:text-white transition text-left">Resolução de Litígios (RAL)</button></li>
                </ul>
            </div>

            {{-- 4. SOCIAL & LIVRO --}}
            <div class="flex flex-col justify-between">
                <div>
                    <h5 class="text-xs font-bold uppercase tracking-widest mb-8 text-brand-sand">Social</h5>
                    <div class="flex gap-4">
                        {{-- Instagram --}}
                        <a href="#" target="_blank" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-brand-primary hover:border-brand-primary hover:text-white transition-all duration-300 group text-brand-sand">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        {{-- Facebook --}}
                        <a href="#" target="_blank" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-brand-primary hover:border-brand-primary hover:text-white transition-all duration-300 group text-brand-sand">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                        </a>
                        {{-- LinkedIn --}}
                        <a href="#" target="_blank" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-brand-primary hover:border-brand-primary hover:text-white transition-all duration-300 group text-brand-sand">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Link Livro Reclamações (Texto Apenas) --}}
                <div class="mt-8">
                    <a href="https://www.livroreclamacoes.pt" target="_blank" class="text-[10px] uppercase tracking-widest text-white/40 hover:text-brand-sand border-b border-transparent hover:border-brand-sand pb-1 transition-all">
                        Livro de Reclamações Eletrónico
                    </a>
                </div>
            </div>
        </div>

        {{-- COPYRIGHT & MAXSELL --}}
        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] uppercase tracking-widest text-white/30">
            <p>&copy; {{ date('Y') }} Marco Moura. Todos os direitos reservados.</p>
            
            {{-- Logo Maxsell Restaurado --}}
            <div class="flex items-center gap-3 opacity-60 hover:opacity-100 transition-opacity">
                <span>Desenvolvido por</span>
                <a href="https://www.maxselladvisor.com" target="_blank" rel="noopener noreferrer">
                    <img src="{{ asset('img/maxsell.png') }}" alt="Maxsell Advisor" class="h-5 w-auto grayscale hover:grayscale-0 transition-all duration-500">
                </a>
            </div>
        </div>
    </div>
</footer>

{{-- INTEGRAR O MODAL DE PRIVACIDADE AQUI PARA EVITAR ERROS DE Z-INDEX --}}
{{-- O Event Listener no Alpine do Modal vai apanhar os cliques do Footer --}}
<div x-data="{ showPrivacyModal: false, activeTab: 'privacy' }"
     @open-privacy-modal.window="showPrivacyModal = true; activeTab = $event.detail.tab || 'privacy'">
    
    @include('partials.privacy-consent')

</div>