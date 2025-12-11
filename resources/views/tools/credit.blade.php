@extends('layouts.app')

@section('content')

<div class="bg-brand-black text-white py-24 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="container mx-auto px-6 relative z-10">
        <p class="text-brand-gold text-xs uppercase tracking-[0.4em] mb-4">Ferramentas Exclusivas</p>
        <h1 class="text-3xl md:text-5xl font-serif">Simulador de Crédito Habitação</h1>
        <p class="mt-4 text-gray-400 font-light max-w-2xl mx-auto">
            Planeie o seu futuro com precisão. Calcule a sua prestação mensal, taxas de juro e viabilidade financeira com base nas taxas Euribor atuais.
        </p>
    </div>
</div>

<section class="py-20 bg-neutral-50" 
         x-data="creditCalculator()" 
         x-init="calculate()">
    
    <div class="container mx-auto px-6 md:px-12 relative">
        
        <div class="flex justify-end mb-6">
            <button @click="showHelp = true" class="flex items-center gap-2 text-brand-gold text-xs uppercase tracking-widest font-bold hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Entenda as Taxas
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- COLUNA ESQUERDA: DADOS DO CRÉDITO --}}
            <div class="lg:col-span-7 space-y-8">
                
                <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                    <h3 class="text-lg font-serif mb-6 text-brand-black flex items-center gap-2">
                        <span class="bg-brand-gold text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-sans">1</span>
                        Dados do Financiamento
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Valor do Imóvel (€)</label>
                            <input type="number" x-model.number="propertyValue" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 focus:outline-none focus:border-brand-gold transition-colors" placeholder="350000">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Entrada Inicial (€)</label>
                            <input type="number" x-model.number="downPayment" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 focus:outline-none focus:border-brand-gold transition-colors" placeholder="35000">
                            <p class="text-[10px] text-gray-400 mt-1" x-show="percentage < 10"><span class="text-red-500">Atenção:</span> Mínimo recomendado de 10%.</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Prazo (Anos)</label>
                        <input type="range" x-model.number="years" @input="calculate()" min="10" max="40" step="1" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-brand-gold">
                        <div class="flex justify-between text-xs text-gray-400 mt-2">
                            <span>10 Anos</span>
                            <span class="font-bold text-brand-gold" x-text="years + ' Anos'"></span>
                            <span>40 Anos</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Euribor</label>
                            <select x-model.number="euriborRate" @change="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 bg-white focus:outline-none focus:border-brand-gold">
                                <option value="2.168">6 Meses (2.168%)</option>
                                <option value="2.088">3 Meses (2.088%)</option>
                                <option value="2.268">12 Meses (2.268%)</option>
                                <option value="3.0">Taxa Fixa (3.0%)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Spread (%)</label>
                            <input type="number" x-model.number="spread" @input="calculate()" step="0.1" class="w-full border border-gray-200 rounded px-4 py-3 focus:outline-none focus:border-brand-gold" placeholder="1.0">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">TAN Global (%)</label>
                            <div class="w-full bg-gray-50 border border-gray-200 rounded px-4 py-3 text-gray-500 cursor-not-allowed">
                                <span x-text="(euriborRate + spread).toFixed(3)"></span> %
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                    <h3 class="text-lg font-serif mb-6 text-brand-black flex items-center gap-2">
                        <span class="bg-brand-gold text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-sans">2</span>
                        Análise de Viabilidade
                    </h3>
                    
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Rendimento Mensal Líquido do Agregado (€)</label>
                        <input type="number" x-model.number="monthlyIncome" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 focus:outline-none focus:border-brand-gold" placeholder="Ex: 2500">
                    </div>

                    <div class="mt-6">
                        <div class="flex justify-between text-xs uppercase tracking-widest mb-2">
                            <span class="text-gray-500">Taxa de Esforço</span>
                            <span :class="effortRate > 35 ? 'text-red-500 font-bold' : 'text-green-500 font-bold'" x-text="effortRate + '%'"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full transition-all duration-500" 
                                 :class="effortRate > 35 ? 'bg-red-500' : 'bg-green-500'" 
                                 :style="'width: ' + Math.min(effortRate, 100) + '%'"></div>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-2">
                            <span x-show="effortRate <= 35">✅ Taxa saudável (Abaixo de 35%)</span>
                            <span x-show="effortRate > 35 && effortRate <= 50">⚠️ Atenção: Taxa elevada (Entre 35% e 50%)</span>
                            <span x-show="effortRate > 50">⛔ Risco: Dificuldade de aprovação (Acima de 50%)</span>
                        </p>
                    </div>
                </div>

            </div>

            {{-- COLUNA DIREITA: RESULTADOS --}}
            <div class="lg:col-span-5">
                <div class="sticky top-32 bg-brand-charcoal text-white p-8 rounded shadow-2xl">
                    <h3 class="text-xl font-serif mb-6 text-brand-gold">A Sua Prestação Mensal</h3>

                    <div class="text-center mb-8">
                        <p class="text-5xl font-serif text-white">€ <span x-text="formatMoney(monthlyPayment)"></span></p>
                        <p class="text-xs uppercase tracking-widest text-gray-400 mt-2">+ Seguros (Est.) € <span x-text="formatMoney(insuranceCost)"></span></p>
                    </div>

                    <div class="space-y-4 text-sm font-light border-t border-white/10 pt-6">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Montante Financiado</span>
                            <span>€ <span x-text="formatMoney(loanAmount)"></span></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Juros Totais Pagos</span>
                            <span>€ <span x-text="formatMoney(totalInterest)"></span></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">MTIC (Montante Total)</span>
                            <span class="font-bold text-brand-gold">€ <span x-text="formatMoney(totalAmount)"></span></span>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10 text-center">
                        <p class="text-sm text-gray-300 mb-4">Gostou da simulação? Vamos avançar.</p>
                        <div class="space-y-3">
                            <a href="{{ route('contact') }}" class="block w-full bg-white text-brand-black font-bold uppercase tracking-widest py-4 text-xs hover:bg-brand-gold hover:text-white transition rounded">
                                Pedir Proposta Bancária
                            </a>
                            <a href="{{ route('portfolio') }}" class="block w-full border border-white/20 text-white font-bold uppercase tracking-widest py-4 text-xs hover:bg-white hover:text-brand-black transition rounded">
                                Ver Imóveis Compatíveis
                            </a>
                        </div>
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
                <h3 class="text-xl font-serif">Entenda o Crédito Habitação</h3>
                <button @click="showHelp = false" class="text-gray-400 hover:text-white">✕</button>
            </div>
            <div class="p-8 space-y-6 overflow-y-auto max-h-[70vh] text-gray-600">
                
                <div>
                    <h4 class="font-bold text-brand-black mb-2">1. Euribor + Spread (TAN)</h4>
                    <p class="text-sm">
                        A prestação é calculada somando a taxa de referência europeia (Euribor) com o lucro do banco (Spread). Usamos as taxas Euribor atuais de 2025.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-brand-black mb-2">2. Taxa de Esforço</h4>
                    <p class="text-sm">
                        O Banco de Portugal recomenda que as prestações de crédito não ultrapassem 35% a 50% do seu rendimento mensal líquido. Se o simulador mostrar a barra a vermelho, considere aumentar o prazo ou a entrada inicial.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-brand-black mb-2">3. Seguros Obrigatórios</h4>
                    <p class="text-sm">
                        Além da prestação ao banco, terá de pagar Seguro de Vida e Seguro Multirriscos. O simulador estima um valor médio de mercado para estes custos, para que não tenha surpresas.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-brand-black mb-2">4. Entradas Mínimas</h4>
                    <p class="text-sm">
                        Para Habitação Própria Permanente, os bancos financiam geralmente até 90% do valor. Isso significa que precisa de ter, pelo menos, 10% para a entrada inicial.
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
    function creditCalculator() {
        return {
            showHelp: false,
            propertyValue: 350000,
            downPayment: 35000,
            years: 30,
            euriborRate: 2.168, // Taxa Euribor 6M Atualizada Dez 2025
            spread: 1.0,
            monthlyIncome: 2500,
            
            loanAmount: 0,
            monthlyPayment: 0,
            totalInterest: 0,
            totalAmount: 0,
            percentage: 0,
            insuranceCost: 0,
            effortRate: 0,

            formatMoney(value) {
                return new Intl.NumberFormat('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
            },

            calculate() {
                // 1. Montante do Empréstimo
                this.loanAmount = this.propertyValue - this.downPayment;
                if (this.loanAmount < 0) this.loanAmount = 0;

                // Percentual de Entrada
                if (this.propertyValue > 0) {
                    this.percentage = (this.downPayment / this.propertyValue) * 100;
                } else {
                    this.percentage = 0;
                }

                // 2. Taxa Mensal (TAN / 12)
                let annualRate = (this.euriborRate + this.spread) / 100;
                let monthlyRate = annualRate / 12;
                let totalMonths = this.years * 12;

                // 3. Fórmula Price (Sistema Francês)
                if (monthlyRate > 0) {
                    this.monthlyPayment = this.loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, totalMonths)) / (Math.pow(1 + monthlyRate, totalMonths) - 1);
                } else {
                    this.monthlyPayment = this.loanAmount / totalMonths;
                }

                // 4. Totais
                this.totalAmount = this.monthlyPayment * totalMonths;
                this.totalInterest = this.totalAmount - this.loanAmount;

                // 5. Estimativa de Seguros (Vida + Multirriscos)
                // Estimativa conservadora: 0.04% do capital em dívida por mês (varia com idade)
                this.insuranceCost = this.loanAmount * 0.00045; 

                // 6. Taxa de Esforço
                let totalMonthlyCost = this.monthlyPayment + this.insuranceCost;
                if (this.monthlyIncome > 0) {
                    this.effortRate = (totalMonthlyCost / this.monthlyIncome) * 100;
                    this.effortRate = Math.round(this.effortRate * 10) / 10;
                } else {
                    this.effortRate = 0;
                }
            }
        }
    }
</script>

@endsection