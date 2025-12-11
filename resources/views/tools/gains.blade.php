@extends('layouts.app')

@section('content')

<div class="bg-brand-black text-white py-24 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="container mx-auto px-6 relative z-10">
        <p class="text-brand-gold text-xs uppercase tracking-[0.4em] mb-4">Ferramentas Exclusivas</p>
        <h1 class="text-3xl md:text-5xl font-serif">Simulador de Mais-Valias</h1>
        <p class="mt-4 text-gray-400 font-light max-w-2xl mx-auto">
            Calcule o imposto estimado sobre a venda do seu imóvel, considerando reinvestimento, encargos e coeficientes de desvalorização monetária.
        </p>
    </div>
</div>

<section class="py-20 bg-neutral-50" 
         x-data="capitalGainsCalculator()" 
         x-init="calculate()">
    
    <div class="container mx-auto px-6 md:px-12 relative">
        
        <div class="flex justify-end mb-6">
            <button @click="showHelp = true" class="flex items-center gap-2 text-brand-gold text-xs uppercase tracking-widest font-bold hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Entenda o Cálculo
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <div class="lg:col-span-7 space-y-8">
                
                <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                    <h3 class="text-lg font-serif mb-6 text-brand-black flex items-center gap-2">
                        <span class="bg-brand-gold text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-sans">1</span>
                        Dados da Venda (Realização)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Valor da Venda (€)</label>
                            <input type="number" x-model.number="saleValue" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 focus:outline-none focus:border-brand-gold transition-colors" placeholder="Ex: 350000">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Despesas de Venda (€)</label>
                            <input type="number" x-model.number="saleExpenses" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 focus:outline-none focus:border-brand-gold transition-colors" placeholder="Comissão imobiliária, Energético...">
                            <p class="text-[10px] text-gray-400 mt-1">Comissões, Certificado Energético, etc.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                    <h3 class="text-lg font-serif mb-6 text-brand-black flex items-center gap-2">
                        <span class="bg-brand-gold text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-sans">2</span>
                        Dados da Aquisição
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Valor de Compra (€)</label>
                            <input type="number" x-model.number="purchaseValue" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 focus:outline-none focus:border-brand-gold transition-colors" placeholder="Ex: 150000">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Ano de Aquisição</label>
                            <select x-model.number="purchaseYear" @change="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 bg-white focus:outline-none focus:border-brand-gold">
                                <template x-for="year in years" :key="year">
                                    <option :value="year" x-text="year"></option>
                                </template>
                            </select>
                            <p x-show="purchaseYear < 1989" class="text-xs text-green-600 mt-1 font-bold">Imóvel isento (Adquirido antes de 1989)</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Despesas de Compra (€)</label>
                            <input type="number" x-model.number="purchaseExpenses" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 focus:outline-none focus:border-brand-gold transition-colors" placeholder="IMT, Escritura, Selo...">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Obras (Últimos 12 anos) (€)</label>
                            <input type="number" x-model.number="improvements" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 focus:outline-none focus:border-brand-gold transition-colors" placeholder="Manutenção e valorização">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                    <h3 class="text-lg font-serif mb-6 text-brand-black flex items-center gap-2">
                        <span class="bg-brand-gold text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-sans">3</span>
                        Reinvestimento & IRS
                    </h3>

                    <div class="mb-6">
                        <label class="flex items-center gap-3 cursor-pointer mb-4">
                            <input type="checkbox" x-model="isHPP" @change="calculate()" class="accent-brand-gold w-5 h-5">
                            <span class="text-sm text-gray-700">Era Habitação Própria e Permanente (HPP)?</span>
                        </label>

                        <div x-show="isHPP" x-collapse>
                            <div class="bg-gray-50 p-4 rounded border border-gray-200 space-y-4">
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Valor do Empréstimo a Liquidar (€)</label>
                                    <input type="number" x-model.number="loanValue" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 bg-white" placeholder="Valor em dívida ao banco">
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Valor a Reinvestir (Nova Casa) (€)</label>
                                    <input type="number" x-model.number="reinvestmentValue" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3 bg-white" placeholder="Quanto vai usar na nova casa?">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-6">

                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Rendimentos Anuais (Englobamento) (€)</label>
                        <input type="number" x-model.number="annualIncome" @input="calculate()" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="Seu salário bruto anual aproximado">
                        <p class="text-[10px] text-gray-400 mt-1">Necessário para determinar a taxa de IRS aplicável.</p>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-5">
                <div class="sticky top-32 bg-brand-charcoal text-white p-8 rounded shadow-2xl">
                    <h3 class="text-xl font-serif mb-6 text-brand-gold">Resultado da Simulação</h3>

                    <div class="space-y-4 text-sm font-light">
                        <div class="flex justify-between border-b border-white/10 pb-2">
                            <span class="text-gray-400">Mais-Valia Bruta</span>
                            <span>€ <span x-text="formatMoney(grossGain)"></span></span>
                        </div>
                        
                        <div class="flex justify-between border-b border-white/10 pb-2">
                            <span class="text-gray-400">Coeficiente Inflação (<span x-text="coefficient"></span>)</span>
                            <span class="text-green-400">- € <span x-text="formatMoney(inflationDeduction)"></span></span>
                        </div>

                        <div x-show="isHPP && reinvestmentBenefit > 0" class="flex justify-between border-b border-white/10 pb-2">
                            <span class="text-gray-400">Benefício Reinvestimento</span>
                            <span class="text-green-400">- € <span x-text="formatMoney(reinvestmentBenefit)"></span></span>
                        </div>

                        <div class="flex justify-between border-b border-white/10 pb-2 pt-2">
                            <span class="text-gray-200 font-medium">Mais-Valia Tributável (50%)</span>
                            <span class="font-bold">€ <span x-text="formatMoney(taxableGain)"></span></span>
                        </div>

                        <div class="bg-white/10 p-4 rounded mt-6">
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Imposto Estimado (IRS)</p>
                            <p class="text-3xl font-serif text-brand-gold">€ <span x-text="formatMoney(estimatedTax)"></span></p>
                            <p class="text-[10px] text-gray-500 mt-2 italic">*Valor meramente indicativo baseado nos escalões de 2024. Consulte um contabilista.</p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10 text-center">
                        <p class="text-sm text-gray-300 mb-4">Precisa de ajuda com a venda ou reinvestimento?</p>
                        <a href="{{ route('contact') }}" class="inline-block w-full bg-white text-brand-black font-bold uppercase tracking-widest py-4 text-xs hover:bg-brand-gold hover:text-white transition rounded">
                            Falar com Diogo Maia
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
                <h3 class="text-xl font-serif">Como funciona o cálculo?</h3>
                <button @click="showHelp = false" class="text-gray-400 hover:text-white">✕</button>
            </div>
            <div class="p-8 space-y-6 overflow-y-auto max-h-[70vh] text-gray-600">
                
                <div>
                    <h4 class="font-bold text-brand-black mb-2">1. Fórmula Geral</h4>
                    <p class="text-sm bg-gray-50 p-3 rounded border border-gray-200 font-mono">
                        Mais-Valia = Valor Venda - (Valor Aquisição × Coeficiente) - Despesas
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-brand-black mb-2">2. Coeficiente de Desvalorização</h4>
                    <p class="text-sm">
                        O Estado aplica um multiplicador ao valor de compra para corrigir a inflação. Imóveis comprados há mais tempo têm um coeficiente maior, o que reduz o imposto a pagar. Utilizamos os coeficientes da Portaria mais recente.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-brand-black mb-2">3. Despesas Dedutíveis</h4>
                    <p class="text-sm">
                        Você pode abater custos como: IMT e Imposto de Selo pagos na compra, Comissões imobiliárias, Certificado energético e Obras de valorização realizadas nos últimos 12 anos.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-brand-black mb-2">4. Tributação (IRS)</h4>
                    <p class="text-sm">
                        Apenas 50% do lucro (mais-valia) é tributado. Este valor é somado aos seus rendimentos anuais (salários, pensões) e taxado de acordo com o seu escalão de IRS.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-brand-black mb-2">5. Isenção por Reinvestimento</h4>
                    <p class="text-sm">
                        Se o imóvel vendido era sua Habitação Própria e Permanente (HPP) e você usar o dinheiro para comprar outra HPP (em até 36 meses), o imposto pode ser reduzido ou anulado proporcionalmente ao valor reinvestido.
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
    function capitalGainsCalculator() {
        return {
            showHelp: false,
            saleValue: 0,
            saleExpenses: 0,
            purchaseValue: 0,
            purchaseYear: new Date().getFullYear(),
            purchaseExpenses: 0,
            improvements: 0,
            isHPP: false,
            loanValue: 0,
            reinvestmentValue: 0,
            annualIncome: 30000,
            years: [],
            coefficients: {
                2024: 1.00, 2023: 1.00, 2022: 1.01, 2021: 1.01, 2020: 1.01,
                2019: 1.01, 2018: 1.02, 2017: 1.03, 2016: 1.03, 2015: 1.04,
                2010: 1.08, 2005: 1.15, 2000: 1.35, 1995: 1.55, 1990: 2.50
            },
            grossGain: 0,
            inflationDeduction: 0,
            reinvestmentBenefit: 0,
            taxableGain: 0,
            estimatedTax: 0,
            coefficient: 1,

            init() {
                const currentYear = new Date().getFullYear();
                for (let i = currentYear; i >= 1980; i--) {
                    this.years.push(i);
                }
            },

            getCoef(year) {
                if (year >= 2023) return 1.00;
                if (this.coefficients[year]) return this.coefficients[year];
                if (year > 2010) return 1.05;
                if (year > 2000) return 1.25;
                return 2.0; 
            },

            formatMoney(value) {
                return new Intl.NumberFormat('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
            },

            calculate() {
                if (this.purchaseYear < 1989) {
                    this.grossGain = 0;
                    this.taxableGain = 0;
                    this.estimatedTax = 0;
                    return;
                }

                this.coefficient = this.getCoef(this.purchaseYear);
                const purchaseUpdated = this.purchaseValue * this.coefficient;
                this.inflationDeduction = purchaseUpdated - this.purchaseValue;

                const totalExpenses = (this.saleExpenses || 0) + (this.purchaseExpenses || 0) + (this.improvements || 0);
                let gain = (this.saleValue || 0) - purchaseUpdated - totalExpenses;

                if (gain < 0) gain = 0;
                this.grossGain = gain;

                let taxableAmount = gain;
                this.reinvestmentBenefit = 0;

                if (this.isHPP && gain > 0 && this.reinvestmentValue > 0) {
                    const netSaleValue = Math.max(0, (this.saleValue || 0) - (this.loanValue || 0));
                    if (netSaleValue > 0) {
                        const ratio = Math.min(1, this.reinvestmentValue / netSaleValue);
                        this.reinvestmentBenefit = gain * ratio;
                        taxableAmount = gain - this.reinvestmentBenefit;
                    }
                }

                this.taxableGain = taxableAmount * 0.5;

                const totalIncomeForTax = (this.annualIncome || 0) + this.taxableGain;
                let taxRate = 0.13;
                if (totalIncomeForTax > 7700) taxRate = 0.1325;
                if (totalIncomeForTax > 11600) taxRate = 0.18;
                if (totalIncomeForTax > 16400) taxRate = 0.23;
                if (totalIncomeForTax > 21300) taxRate = 0.26;
                if (totalIncomeForTax > 27100) taxRate = 0.32;
                if (totalIncomeForTax > 39700) taxRate = 0.355;
                if (totalIncomeForTax > 51900) taxRate = 0.435;
                if (totalIncomeForTax > 81000) taxRate = 0.48;

                this.estimatedTax = this.taxableGain * taxRate;
            }
        }
    }
</script>

@endsection