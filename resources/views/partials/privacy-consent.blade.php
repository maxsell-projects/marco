{{-- BARRA DE CONSENTIMENTO (FIXA NO RODAPÉ) --}}
<div x-show="showConsent" 
     style="display: none;"
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="translate-y-full opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-y-0 opacity-100"
     x-transition:leave-end="translate-y-full opacity-0"
     class="fixed bottom-0 left-0 w-full z-[100] bg-brand-secondary/95 backdrop-blur-md border-t border-brand-sand/20 p-6 md:p-8 shadow-[0_-10px_40px_rgba(0,0,0,0.2)] print:hidden">
    
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="text-center md:text-left flex-1">
            <p class="text-sm text-white/80 leading-relaxed font-light">
                {!! __('legal.consent_banner.text') !!}
                <button @click="showPrivacyModal = true" class="text-brand-sand hover:text-white underline decoration-brand-sand/50 hover:decoration-white transition-all">{{ __('legal.consent_banner.link') }}</button>.
            </p>
        </div>
        <div class="flex gap-4 w-full md:w-auto">
            <button @click="acceptCookies()" class="w-full md:w-auto px-8 py-3 bg-brand-primary text-white text-xs font-bold uppercase tracking-widest hover:bg-brand-sand hover:text-brand-primary transition-all duration-300 rounded-sm whitespace-nowrap shadow-lg">
                {{ __('legal.consent_banner.accept_btn') }}
            </button>
        </div>
    </div>
</div>

{{-- MODAL DE POLÍTICA DE PRIVACIDADE --}}
<div x-show="showPrivacyModal" 
     style="display: none;"
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-brand-secondary/90 backdrop-blur-sm overflow-hidden">
    
    <div @click.outside="showPrivacyModal = false" 
         class="bg-white w-full max-w-5xl max-h-[85vh] flex flex-col rounded-sm shadow-2xl relative border-t-8 border-brand-primary font-sans overflow-hidden"
         x-data="{ activeTab: 'privacy' }">
        
        {{-- Header do Modal --}}
        <div class="bg-gray-50 border-b border-gray-200 px-6 py-6 md:px-8 md:pt-8 md:pb-0 flex-none">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-xl md:text-2xl font-serif text-brand-secondary">{{ __('legal.modal.title') }}</h2>
                    <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Porthouse Private Office</p>
                </div>
                <button @click="showPrivacyModal = false" class="text-gray-400 hover:text-brand-primary transition-colors p-2 -mr-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="flex space-x-6 md:space-x-8 overflow-x-auto scrollbar-hide -mx-6 px-6 md:mx-0 md:px-0">
                <button @click="activeTab = 'privacy'" 
                        :class="activeTab === 'privacy' ? 'border-brand-primary text-brand-secondary' : 'border-transparent text-gray-400 hover:text-gray-600'"
                        class="pb-4 border-b-2 text-[10px] font-bold uppercase tracking-widest transition-colors duration-300 whitespace-nowrap">
                    {{ __('legal.tabs.privacy') }}
                </button>
                <button @click="activeTab = 'cookies'" 
                        :class="activeTab === 'cookies' ? 'border-brand-primary text-brand-secondary' : 'border-transparent text-gray-400 hover:text-gray-600'"
                        class="pb-4 border-b-2 text-[10px] font-bold uppercase tracking-widest transition-colors duration-300 whitespace-nowrap">
                    {{ __('legal.tabs.cookies') }}
                </button>
                <button @click="activeTab = 'ral'" 
                        :class="activeTab === 'ral' ? 'border-brand-primary text-brand-secondary' : 'border-transparent text-gray-400 hover:text-gray-600'"
                        class="pb-4 border-b-2 text-[10px] font-bold uppercase tracking-widest transition-colors duration-300 whitespace-nowrap">
                    {{ __('legal.tabs.ral') }}
                </button>
            </div>
        </div>

        {{-- Conteúdo (Scrollable) --}}
        <div class="flex-1 overflow-y-auto p-6 md:p-12 bg-white scrollbar-thin scrollbar-thumb-gray-200">
            
            {{-- TAB: PRIVACIDADE --}}
            <div x-show="activeTab === 'privacy'" class="prose prose-sm max-w-none text-gray-600 font-light text-justify">
                <p>{!! __('legal.privacy.intro') !!}</p>
                <p class="font-bold text-brand-secondary">{{ __('legal.privacy.commitment') }}</p>
                
                <h3 class="text-brand-secondary font-serif font-bold mt-8 mb-2 text-lg">1. {{ __('legal.privacy.scope_title') }}</h3>
                <p>{{ __('legal.privacy.scope_text') }}</p>
                
                <h3 class="text-brand-secondary font-serif font-bold mt-8 mb-2 text-lg">2. {{ __('legal.privacy.data_title') }}</h3>
                <p>{{ __('legal.privacy.data_text') }}</p>
                <ul class="list-disc pl-5 space-y-1 marker:text-brand-primary">
                    <li>{{ __('legal.privacy.data_list_1') }}</li>
                    <li>{{ __('legal.privacy.data_list_2') }}</li>
                    <li>{{ __('legal.privacy.data_list_3') }}</li>
                    <li>{{ __('legal.privacy.data_list_4') }}</li>
                </ul>

                <h3 class="text-brand-secondary font-serif font-bold mt-8 mb-2 text-lg">3. {{ __('legal.privacy.security_title') }}</h3>
                <p>{{ __('legal.privacy.security_text') }}</p>

                <h3 class="text-brand-secondary font-serif font-bold mt-8 mb-2 text-lg">4. {{ __('legal.privacy.rights_title') }}</h3>
                <p>{!! __('legal.privacy.rights_text') !!}</p>
            </div>

            {{-- TAB: COOKIES --}}
            <div x-show="activeTab === 'cookies'" style="display: none;" class="prose prose-sm max-w-none text-gray-600 font-light text-justify">
                <h3 class="text-brand-secondary font-serif font-bold mt-0 mb-2 text-lg">{{ __('legal.cookies.title') }}</h3>
                <p>{{ __('legal.cookies.intro') }}</p>

                <h4 class="text-brand-secondary font-bold mt-6 mb-2 text-sm uppercase tracking-wide">{{ __('legal.cookies.categories_title') }}</h4>
                <ul class="list-disc pl-5 space-y-2 marker:text-brand-primary">
                    <li>{!! __('legal.cookies.cat_1') !!}</li>
                    <li>{!! __('legal.cookies.cat_2') !!}</li>
                    <li>{!! __('legal.cookies.cat_3') !!}</li>
                </ul>

                <p class="mt-6 text-xs italic">{{ __('legal.cookies.manage') }}</p>
            </div>

            {{-- TAB: RAL --}}
            <div x-show="activeTab === 'ral'" style="display: none;" class="prose prose-sm max-w-none text-gray-600 font-light text-justify">
                <h3 class="text-brand-secondary font-serif font-bold mt-0 mb-4 text-lg">{{ __('legal.ral.title') }}</h3>
                
                <p>{{ __('legal.ral.text') }}</p>
                
                <div class="bg-gray-50 border border-gray-200 p-6 rounded-sm mt-6">
                    <p class="font-bold text-brand-secondary mb-1">CNIACC - {{ __('legal.ral.entity_name') }}</p>
                    <p class="text-xs text-gray-500 mb-4">{{ __('legal.ral.competence') }}</p>
                    
                    <a href="https://www.cniacc.pt" target="_blank" class="flex items-center gap-2 text-brand-primary hover:text-brand-secondary transition-colors font-bold text-xs uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        www.cniacc.pt
                    </a>
                </div>
                
                <p class="text-xs mt-6 text-gray-400">{!! __('legal.ral.more_info') !!}</p>
            </div>

        </div>

        {{-- Footer do Modal --}}
        <div class="bg-gray-50 border-t border-gray-200 p-6 flex justify-end flex-none">
            <button @click="showPrivacyModal = false; acceptCookies()" class="px-8 py-3 bg-brand-primary text-white text-[10px] font-bold uppercase tracking-widest hover:bg-brand-secondary transition-all duration-300 rounded-sm shadow-lg border border-transparent hover:border-brand-sand">
                {{ __('legal.modal.accept_btn') }}
            </button>
        </div>
    </div>
</div>