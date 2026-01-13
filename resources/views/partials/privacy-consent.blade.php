{{-- BARRA DE CONSENTIMENTO (FIXA NO RODAPÉ) --}}
<div x-show="showConsent" 
     style="display: none;"
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="translate-y-full opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-y-0 opacity-100"
     x-transition:leave-end="translate-y-full opacity-0"
     class="fixed bottom-0 left-0 w-full z-[60] bg-brand-primary/95 backdrop-blur-md border-t border-white/10 p-6 md:p-8 shadow-2xl">
    
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="text-center md:text-left">
            <p class="text-sm text-gray-300 leading-relaxed font-light">
                Utilizamos cookies para personalizar a sua experiência exclusiva. Ao continuar a navegar, aceita a nossa 
                <button @click="showPrivacyModal = true" class="text-brand-premium hover:text-white underline decoration-brand-premium/50 hover:decoration-white transition-all">Política de Privacidade e Cookies</button>.
            </p>
        </div>
        <div class="flex gap-4">
            <button @click="acceptCookies()" class="px-8 py-3 bg-brand-premium text-brand-primary text-xs font-bold uppercase tracking-widest hover:bg-white transition-all duration-300 rounded-sm whitespace-nowrap shadow-lg">
                Aceitar
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
     class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-brand-primary/90 backdrop-blur-sm">
    
    <div @click.outside="showPrivacyModal = false" 
         class="bg-white w-full max-w-5xl max-h-[85vh] flex flex-col rounded shadow-2xl relative overflow-hidden border-t-4 border-brand-premium"
         x-data="{ activeTab: 'privacy' }">
        
        {{-- Header do Modal --}}
        <div class="bg-gray-50 border-b border-gray-200 px-8 pt-8 pb-0 flex-none">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-didot text-brand-primary">Legal & Privacidade</h2>
                    <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">José Carvalho Real Estate</p>
                </div>
                <button @click="showPrivacyModal = false" class="text-gray-400 hover:text-brand-cta transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="flex space-x-8">
                <button @click="activeTab = 'privacy'" 
                        :class="activeTab === 'privacy' ? 'border-brand-premium text-brand-primary' : 'border-transparent text-gray-400 hover:text-gray-600'"
                        class="pb-4 border-b-2 text-xs font-bold uppercase tracking-widest transition-colors duration-300">
                    Política de Privacidade
                </button>
                <button @click="activeTab = 'cookies'" 
                        :class="activeTab === 'cookies' ? 'border-brand-premium text-brand-primary' : 'border-transparent text-gray-400 hover:text-gray-600'"
                        class="pb-4 border-b-2 text-xs font-bold uppercase tracking-widest transition-colors duration-300">
                    Política de Cookies
                </button>
            </div>
        </div>

        {{-- Conteúdo (Scrollable) --}}
        <div class="flex-1 overflow-y-auto p-8 md:p-12 bg-white scrollbar-hide">
            
            {{-- TAB: PRIVACIDADE --}}
            <div x-show="activeTab === 'privacy'" class="prose prose-sm max-w-none text-gray-600 font-light text-justify">
                <p>A <strong>José Carvalho | Real Estate</strong>, com escritório na <strong>Av. da Liberdade, 100, Lisboa, Portugal</strong>, é a entidade responsável pelo domínio <strong>josecarvalho.pt</strong>, onde se encontra alojado este WEBSITE.</p>
                <p>ESTAMOS EMPENHADOS EM PROTEGER A PRIVACIDADE E OS DADOS PESSOAIS DOS NOSSOS CLIENTES E UTILIZADORES, PELO QUE ELABORÁMOS E ADOTÁMOS A PRESENTE POLÍTICA, EM CONFORMIDADE COM O RGPD.</p>
                
                <h3 class="text-brand-primary font-bold mt-6 mb-2">1. ÂMBITO DE APLICAÇÃO</h3>
                <p>1.1. Esta Política de Privacidade explica como recolhemos e tratamos os dados pessoais necessários para o fornecimento de serviços de consultoria imobiliária de luxo disponíveis através do WEBSITE.</p>
                
                <h3 class="text-brand-primary font-bold mt-6 mb-2">2. DADOS PESSOAIS</h3>
                <p>2.1. Dados pessoais são todas as informações relativas a uma pessoa que a identificam ou tornam identificável (ex: nome, e-mail, telefone, preferências de investimento).</p>
                
                <h3 class="text-brand-primary font-bold mt-6 mb-2">3. FINALIDADES DO TRATAMENTO</h3>
                <p>3.1. Utilizamos os dados para:</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Gestão de pedidos de contacto e agendamento de reuniões;</li>
                    <li>Processos de mediação imobiliária (compra, venda ou arrendamento);</li>
                    <li>Cumprimento de obrigações legais (ex: identificação de beneficiários efetivos);</li>
                    <li>Envio de oportunidades exclusivas (apenas com consentimento explícito).</li>
                </ul>

                <h3 class="text-brand-primary font-bold mt-6 mb-2">4. LEGITIMIDADE</h3>
                <div class="overflow-x-auto my-4 border border-gray-100 rounded">
                    <table class="min-w-full text-xs text-left">
                        <thead class="bg-brand-primary text-white">
                            <tr><th class="p-3 border-b border-white/10">Finalidade</th><th class="p-3 border-b border-white/10">Fundamento</th><th class="p-3 border-b border-white/10">Dados</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr><td class="p-3">Resposta a contactos</td><td class="p-3">Diligências pré-contratuais</td><td class="p-3">Nome, telefone, email</td></tr>
                            <tr><td class="p-3">Marketing / Newsletter</td><td class="p-3">Consentimento</td><td class="p-3">Email</td></tr>
                            <tr><td class="p-3">Segurança do Site</td><td class="p-3">Interesse legítimo</td><td class="p-3">IP, Logs</td></tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="text-brand-primary font-bold mt-6 mb-2">5. PARTILHA DE DADOS</h3>
                <p>Não vendemos os seus dados. Apenas partilhamos informação com terceiros estritamente necessários à prestação do serviço (ex: advogados, solicitadores, instituições bancárias) e sempre com o seu conhecimento.</p>

                <h3 class="text-brand-primary font-bold mt-6 mb-2">6. SEGURANÇA</h3>
                <p>Implementamos medidas técnicas e organizativas rigorosas (protocolo HTTPS, servidores seguros, controlo de acessos) para proteger os seus dados contra perda, uso indevido ou alteração.</p>

                <h3 class="text-brand-primary font-bold mt-6 mb-2">7. DIREITOS DO TITULAR</h3>
                <p>Pode exercer os seus direitos de acesso, retificação, esquecimento, limitação ou oposição contactando-nos diretamente através do e-mail oficial: <strong>contacto@josecarvalho.pt</strong>.</p>
            </div>

            {{-- TAB: COOKIES --}}
            <div x-show="activeTab === 'cookies'" style="display: none;" class="prose prose-sm max-w-none text-gray-600 font-light text-justify">
                <h3 class="text-brand-primary font-bold mt-0 mb-2">1. O que são cookies?</h3>
                <p>“Cookies” são pequenas etiquetas de software armazenadas no seu navegador, retendo apenas informação relacionada com preferências e navegação, não incluindo dados pessoais sensíveis.</p>

                <h3 class="text-brand-primary font-bold mt-6 mb-2">2. Utilidade</h3>
                <p>Servem para otimizar a sua navegação, permitindo que o website reconheça o seu dispositivo e melhore a experiência de utilizador (ex: não precisar de introduzir dados repetidamente).</p>

                <h3 class="text-brand-primary font-bold mt-6 mb-2">3. Tipologia</h3>
                <ul class="list-disc pl-5 space-y-1">
                    <li><strong>Estritamente necessários:</strong> Essenciais para a segurança e funcionamento básico do site.</li>
                    <li><strong>Analíticos:</strong> Utilizamos para entender como os utilizadores interagem com o site (dados anónimos via Google Analytics).</li>
                    <li><strong>Funcionalidade:</strong> Guardam as suas preferências de idioma ou visualização.</li>
                </ul>

                <h3 class="text-brand-primary font-bold mt-6 mb-2">4. Gestão</h3>
                <p>Pode, a qualquer momento, desativar os cookies nas definições do seu navegador (browser), embora isso possa afetar o funcionamento correto de algumas ferramentas do site.</p>
                
                <p class="text-xs mt-6 pt-4 border-t border-gray-100">Para mais informações técnicas, consulte <a href="https://allaboutcookies.org" target="_blank" class="text-brand-premium hover:underline">allaboutcookies.org</a>.</p>
            </div>

        </div>

        {{-- Footer do Modal --}}
        <div class="bg-gray-50 border-t border-gray-200 p-6 flex justify-end flex-none">
            <button @click="showPrivacyModal = false; acceptCookies()" class="px-8 py-3 bg-brand-primary text-white text-xs font-bold uppercase tracking-widest hover:bg-brand-cta transition-all duration-300 rounded-sm shadow-lg">
                Compreendo e Aceito
            </button>
        </div>
    </div>
</div>