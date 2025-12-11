@extends('layouts.app')

@section('content')

<div class="bg-brand-black text-white py-24 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="container mx-auto px-6 relative z-10">
        <p class="text-brand-gold text-xs uppercase tracking-[0.4em] mb-4">Ferramentas Exclusivas</p>
        <h1 class="text-3xl md:text-5xl font-serif">Simulador de IMT e Selo 2025</h1>
        <p class="mt-4 text-gray-400 font-light max-w-2xl mx-auto">
            Calcule os impostos de aquisição do seu imóvel, incluindo as novas regras de isenção para jovens até 35 anos.
        </p>
    </div>
</div>

<section class="py-20 bg-neutral-50" 
         x-data="imtCalculator()" 
         x-init="calculate()">
    
    <div class="container mx-auto px-6 md:px-12 relative">
        
        {{-- Botão de Ajuda --}}
        <div class="flex justify-end mb-6">
            <button @click="showHelp = true" class="flex items-center gap-2 text-brand-gold text-xs uppercase tracking-widest font-bold hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Ver Tabelas Oficiais
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- COLUNA ESQUERDA: FORMULÁRIO --}}
            <div class="lg:col-span-7 space-y-8">
                
                <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                    <h3 class="text-lg font-serif mb-6 text-brand-black flex items-center gap-2">
                        <span class="bg-brand-gold text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-sans">1</span>
                        Dados do Imóvel
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Valor de Aquisição (€)</label>
                            <input type="number" x-model.number="propertyValue" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 focus:outline-none focus:border-brand-gold transition-colors text-lg" placeholder="Ex: 350000">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Localização</label>
                                <select x-model="location" @change="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 bg-white focus:outline-none focus:border-brand-gold">
                                    <option value="continente">Portugal Continental</option>
                                    <option value="ilhas">Açores / Madeira</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Finalidade</label>
                                <select x-model="purpose" @change="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 bg-white focus:outline-none focus:border-brand-gold">
                                    <option value="hpp">Habitação Própria Permanente</option>
                                    <option value="secundaria">Habitação Secundária / Investimento</option>
                                    <option value="rustico">Prédio Rústico</option>
                                    <option value="outros">Outros (Terrenos Urbanos/Lojas)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded shadow-sm border border-gray-100" x-show="purpose === 'hpp'">
                    <h3 class="text-lg font-serif mb-6 text-brand-black flex items-center gap-2">
                        <span class="bg-brand-gold text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-sans">2</span>
                        Isenção IMT Jovem (Novo 2025)
                    </h3>
                    
                    <div class="flex items-center gap-4 mb-4">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="isYoung" @change="calculate()" class="accent-brand-gold w-5 h-5">
                            <span class="text-sm text-gray-700">Compradores têm até 35 anos?</span>
                        </label>
                    </div>

                    <div x-show="isYoung" class="bg-green-50 border border-green-200 p-4 rounded text-sm text-green-800">
                        <p class="font-bold mb-1">🎓 Benefício IMT Jovem Ativo</p>
                        <p class="text-xs">
                            Para a 1ª habitação própria permanente. Isenção total até 324.058€ e parcial até 648.022€.
                        </p>
                    </div>
                </div>

            </div>

            {{-- COLUNA DIREITA: RESULTADOS --}}
            <div class="lg:col-span-5">
                <div class="sticky top-32 bg-brand-charcoal text-white p-8 rounded shadow-2xl">
                    <h3 class="text-xl font-serif mb-6 text-brand-gold">Resultado da Simulação</h3>

                    <div class="space-y-4 text-sm font-light">
                        
                        <div class="flex justify-between border-b border-white/10 pb-2">
                            <span class="text-gray-400">IMT Calculado</span>
                            <span>€ <span x-text="formatMoney(imt)"></span></span>
                        </div>

                        <div x-show="isYoung && purpose === 'hpp'" class="flex justify-between border-b border-white/10 pb-2">
                            <span class="text-gray-400">Desconto IMT Jovem</span>
                            <span class="text-green-400">- € <span x-text="formatMoney(youthDiscount)"></span></span>
                        </div>
                        
                        <div class="flex justify-between border-b border-white/10 pb-2">
                            <span class="text-gray-400">Imposto de Selo (0,8%)</span>
                            <span>€ <span x-text="formatMoney(stampDuty)"></span></span>
                        </div>

                        <div x-show="isYoung && purpose === 'hpp'" class="flex justify-between border-b border-white/10 pb-2">
                            <span class="text-gray-400">Desconto Imposto Selo</span>
                            <span class="text-green-400">- € <span x-text="formatMoney(youthStampDiscount)"></span></span>
                        </div>

                        <div class="bg-white/10 p-4 rounded mt-6">
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Total a Pagar (IMT + Selo)</p>
                            <p class="text-3xl font-serif text-brand-gold">€ <span x-text="formatMoney(total)"></span></p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10 text-center">
                        <p class="text-sm text-gray-300 mb-4">À procura do imóvel ideal?</p>
                        <a href="{{ route('portfolio') }}" class="inline-block w-full bg-white text-brand-black font-bold uppercase tracking-widest py-4 text-xs hover:bg-brand-gold hover:text-white transition rounded">
                            Ver Portfólio
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL DE AJUDA --}}
    <div x-show="showHelp" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl overflow-hidden" @click.away="showHelp = false">
            <div class="bg-brand-black text-white p-6 flex justify-between items-center">
                <h3 class="text-xl font-serif">Tabelas IMT 2025 (Continente)</h3>
                <button @click="showHelp = false" class="text-gray-400 hover:text-white">✕</button>
            </div>
            <div class="p-8 space-y-6 overflow-y-auto max-h-[70vh] text-gray-600">
                
                <div>
                    <h4 class="font-bold text-brand-black mb-2">Habitação Própria e Permanente (HPP)</h4>
                    <ul class="text-sm space-y-1 list-disc pl-4">
                        <li>Até 104.261€: <strong>0%</strong></li>
                        <li>De 104.261€ a 142.618€: 2%</li>
                        <li>De 142.618€ a 194.458€: 5%</li>
                        <li>De 194.458€ a 324.058€: 7%</li>
                        <li>De 324.058€ a 648.022€: 8%</li>
                        <li>De 648.022€ a 1.128.287€: Taxa Única 6%</li>
                        <li>Superior a 1.128.287€: Taxa Única 7,5%</li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-brand-black mb-2">IMT Jovem (Novidade 2025)</h4>
                    <p class="text-sm">
                        Jovens até 35 anos na compra da 1ª habitação própria têm:
                        <br>- <strong>Isenção Total</strong> até 324.058€.
                        <br>- <strong>Isenção Parcial</strong> entre 324.058€ e 648.022€ (paga imposto apenas sobre o valor excedente).
                        <br>- Também isento de Imposto de Selo nas mesmas condições.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-brand-black mb-2">Outras Taxas</h4>
                    <p class="text-sm">
                        - Prédios Rústicos: 5%
                        <br>- Outros Prédios Urbanos (Comércio/Terrenos): 6,5%
                        <br>- Offshore: 10%
                    </p>
                </div>

            </div>
            <div class="p-6 border-t border-gray-100 bg-gray-50 text-right">
                <button @click="showHelp = false" class="text-xs uppercase font-bold tracking-widest text-brand-gold hover:text-brand-black transition">Fechar</button>
            </div>
        </div>
    </div>

</section>

<script>
    function imtCalculator() {
        return {
            showHelp: false,
            propertyValue: 0,
            location: 'continente',
            purpose: 'hpp',
            isYoung: false,
            
            imt: 0,
            stampDuty: 0,
            youthDiscount: 0,
            youthStampDiscount: 0,
            total: 0,

            formatMoney(value) {
                return new Intl.NumberFormat('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
            },

            calculate() {
                let valor = this.propertyValue || 0;
                let taxa = 0;
                let parcelaAbater = 0;
                let imtCalc = 0;

                // 1. CÁLCULO IMT PADRÃO (Tabelas 2025 - Continente)
                if (this.purpose === 'rustico') {
                    imtCalc = valor * 0.05;
                } else if (this.purpose === 'outros') {
                    imtCalc = valor * 0.065;
                } else if (this.purpose === 'hpp') {
                    // Tabela HPP Continente 2025
                    if (valor <= 104261) { taxa = 0; parcelaAbater = 0; }
                    else if (valor <= 142618) { taxa = 0.02; parcelaAbater = 2085.22; }
                    else if (valor <= 194458) { taxa = 0.05; parcelaAbater = 6363.76; }
                    else if (valor <= 324058) { taxa = 0.07; parcelaAbater = 10252.92; }
                    else if (valor <= 648022) { taxa = 0.08; parcelaAbater = 13493.50; }
                    else if (valor <= 1128287) { taxa = 0.06; parcelaAbater = 0; } // Taxa única
                    else { taxa = 0.075; parcelaAbater = 0; } // Taxa única

                    // Se for taxa única, não usa parcela a abater da fórmula padrão
                    if (valor > 648022) imtCalc = valor * taxa;
                    else imtCalc = (valor * taxa) - parcelaAbater;

                } else {
                    // Habitação Secundária Continente 2025
                    if (valor <= 104261) { taxa = 0.01; parcelaAbater = 0; }
                    else if (valor <= 142618) { taxa = 0.02; parcelaAbater = 1042.61; }
                    else if (valor <= 194458) { taxa = 0.05; parcelaAbater = 5321.15; }
                    else if (valor <= 324058) { taxa = 0.07; parcelaAbater = 9210.31; }
                    else if (valor <= 621501) { taxa = 0.08; parcelaAbater = 12450.89; }
                    else if (valor <= 1128287) { taxa = 0.06; parcelaAbater = 0; }
                    else { taxa = 0.075; parcelaAbater = 0; }

                    if (valor > 621501) imtCalc = valor * taxa;
                    else imtCalc = (valor * taxa) - parcelaAbater;
                }

                if (imtCalc < 0) imtCalc = 0;
                this.imt = imtCalc;

                // 2. IMPOSTO DE SELO
                // 0.8% sobre o valor de aquisição
                let seloCalc = valor * 0.008;
                this.stampDuty = seloCalc;

                // 3. ISENÇÃO JOVEM (Regras 2025)
                this.youthDiscount = 0;
                this.youthStampDiscount = 0;

                if (this.purpose === 'hpp' && this.isYoung) {
                    const limiteIsencao = 324058;
                    const limiteMaximo = 648022;

                    if (valor <= limiteIsencao) {
                        // Isenção Total
                        this.youthDiscount = this.imt;
                        this.youthStampDiscount = this.stampDuty;
                    } else if (valor <= limiteMaximo) {
                        // Isenção Parcial (Paga apenas sobre o excedente de 324k)
                        // A lógica fiscal é: IMT Total - IMT que pagaria se custasse 324k (que é isento)
                        // Mas simplificando conforme a lei: Isenta a parcela até 324k.
                        
                        // Cálculo correto da parcela isenta de IMT:
                        // O imposto devido é calculado sobre a parte que excede.
                        // Mas para mostrar o desconto, calculamos o total e subtraímos o que é devido.
                        // Parte Isenta = 324.058. Parte Tributável = Valor - 324.058.
                        // Taxa Marginal nessa faixa é 8%.
                        
                        let imtDevidoJovem = (valor - limiteIsencao) * 0.08; 
                        this.youthDiscount = Math.max(0, this.imt - imtDevidoJovem);

                        // Selo Jovem (Proporcional)
                        // Paga selo apenas sobre o excedente
                        let seloDevidoJovem = (valor - limiteIsencao) * 0.008;
                        this.youthStampDiscount = Math.max(0, this.stampDuty - seloDevidoJovem);
                    }
                    // Acima de 648k não tem isenção
                }

                // 4. TOTAL
                this.total = (this.imt - this.youthDiscount) + (this.stampDuty - this.youthStampDiscount);
            }
        }
    }
</script>

@endsection