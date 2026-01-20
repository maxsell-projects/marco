@extends('layouts.app')

@section('title', __('tools.credit.meta.title') . ' | Porthouse Private Office')

@section('content')

{{-- HERO SECTION: FINANCIAL TOOLS --}}
<div class="bg-brand-primary text-white pt-32 pb-20 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    
    <div class="container mx-auto px-6 relative z-10" data-aos="fade-up">
        <p class="text-brand-premium font-mono text-xs uppercase tracking-[0.4em] mb-6">
            {{ __('tools.credit.hero.category') }}
        </p>
        <h1 class="text-4xl md:text-6xl font-didot leading-tight">
            {{ __('tools.credit.hero.title') }}
        </h1>
        <p class="text-gray-300 font-light max-w-2xl mx-auto mt-6 text-lg">
            {{ __('tools.credit.hero.description') }}
        </p>
    </div>
</div>

{{-- Passamos as traduções do JS via init do Alpine --}}
<section class="py-20 bg-brand-background" 
         x-data="creditCalculator({
            warning_term: '{{ __('tools.credit.js.warning_term') }}',
            warning_age: '{{ __('tools.credit.js.warning_age') }}'
         })" 
         x-init="calculate()">
         
    <div class="container mx-auto px-6 max-w-7xl">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
            
            {{-- COLUNA DA ESQUERDA: FORMULÁRIO --}}
            <div class="lg:col-span-7 space-y-8">
                
                {{-- 1. Dados do Operação --}}
                <div class="bg-white p-8 rounded-lg shadow-sm border-t-4 border-brand-premium" data-aos="fade-up">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-primary text-white font-serif font-bold text-sm">1</span>
                        <h3 class="text-xl font-didot text-brand-primary">{{ __('tools.credit.form.section_1_title') }}</h3>
                    </div>
                    
                    <div class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Valor do Imóvel --}}
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">{{ __('tools.credit.form.acquisition_value') }} (€)</label>
                                <div class="relative">
                                    <input type="number" x-model.number="propertyValue" @input="updateLoanAmount()" 
                                           class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium transition-colors text-lg font-serif text-brand-primary placeholder-gray-300">
                                </div>
                            </div>

                            {{-- Entrada Inicial --}}
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">{{ __('tools.credit.form.equity') }} (€)</label>
                                <div class="relative">
                                    <input type="number" x-model.number="downPayment" @input="updateLoanAmount()" 
                                           class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium transition-colors text-lg font-serif text-brand-primary placeholder-gray-300">
                                </div>
                            </div>
                        </div>

                        {{-- Montante de Empréstimo (Auto-calculado) --}}
                        <div class="bg-[#F5F7FA] p-6 rounded border border-gray-200 flex justify-between items-center">
                            <div>
                                <span class="block text-[10px] font-bold uppercase tracking-widest text-gray-500">{{ __('tools.credit.form.loan_amount') }}</span>
                                <span class="text-xs text-brand-cta font-bold mt-1" x-text="'LTV: ' + ltv.toFixed(1) + '%'"></span>
                            </div>
                            <div class="text-3xl font-didot text-brand-primary">
                                <span x-text="formatMoney(loanAmount)"></span> €
                            </div>
                        </div>
                        <div x-show="ltv > 90" class="text-brand-cta text-xs font-bold flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ __('tools.credit.form.ltv_warning') }}
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Prazo --}}
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">{{ __('tools.credit.form.term') }}</label>
                                <select x-model.number="years" @change="calculate()" class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium cursor-pointer text-brand-primary">
                                    @foreach(range(40, 5) as $y)
                                        <option value="{{ $y }}">{{ $y }} {{ __('tools.credit.form.years_label') }} ({{ $y * 12 }} {{ __('tools.credit.form.months_label') }})</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- Idade --}}
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">{{ __('tools.credit.form.age') }}</label>
                                <input type="number" x-model.number="age" @input="checkMaxTerm()" class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium transition-colors text-brand-primary">
                            </div>
                        </div>
                        <div x-show="ageWarning" class="text-brand-cta text-xs font-bold" x-text="ageWarning"></div>
                    </div>
                </div>

                {{-- 2. Taxas de Juro --}}
                <div class="bg-white p-8 rounded-lg shadow-sm border-t-4 border-brand-premium" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-primary text-white font-serif font-bold text-sm">2</span>
                        <h3 class="text-xl font-didot text-brand-primary">{{ __('tools.credit.rates.title') }}</h3>
                    </div>

                    <div class="space-y-8">
                        {{-- Tipo de Taxa --}}
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">{{ __('tools.credit.rates.mode_label') }}</label>
                            <div class="flex gap-6">
                                <label class="cursor-pointer flex-1 group">
                                    <input type="radio" name="rateType" value="variable" x-model="rateType" @change="calculate()" class="peer sr-only">
                                    <div class="py-4 border-2 border-gray-100 rounded text-center text-sm font-bold text-gray-500 peer-checked:border-brand-primary peer-checked:bg-brand-primary peer-checked:text-white transition-all group-hover:border-gray-300">
                                        {{ __('tools.credit.rates.variable') }}
                                    </div>
                                </label>
                                <label class="cursor-pointer flex-1 group">
                                    <input type="radio" name="rateType" value="fixed" x-model="rateType" @change="calculate()" class="peer sr-only">
                                    <div class="py-4 border-2 border-gray-100 rounded text-center text-sm font-bold text-gray-500 peer-checked:border-brand-primary peer-checked:bg-brand-primary peer-checked:text-white transition-all group-hover:border-gray-300">
                                        {{ __('tools.credit.rates.fixed') }}
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Seleção Euribor --}}
                        <div x-show="rateType === 'variable'" x-transition>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">{{ __('tools.credit.rates.index') }}</label>
                            <select x-model.number="euriborRate" @change="calculate()" class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium cursor-pointer text-brand-primary">
                                <option value="2.31">Euribor 12 {{ __('tools.credit.form.months_label') }} (2.31%)</option>
                                <option value="2.17">Euribor 6 {{ __('tools.credit.form.months_label') }} (2.17%)</option>
                                <option value="2.07">Euribor 3 {{ __('tools.credit.form.months_label') }} (2.07%)</option>
                            </select>
                            <p class="text-[10px] text-gray-400 mt-2">*{{ __('tools.credit.rates.disclaimer') }}</p>
                        </div>

                        {{-- Taxa Fixa Manual --}}
                        <div x-show="rateType === 'fixed'" x-transition>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">{{ __('tools.credit.rates.fixed_value') }} (%)</label>
                            <input type="number" step="0.01" x-model.number="fixedRate" @input="calculate()" class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium text-brand-primary">
                        </div>

                        {{-- Spread --}}
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Spread (%)</label>
                            <div class="relative">
                                <input type="number" step="0.01" x-model.number="spread" @input="calculate()" class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium text-brand-primary" placeholder="Ex: 0.85">
                            </div>
                        </div>

                        {{-- TAN Total --}}
                        <div class="flex justify-between items-center border-t border-gray-100 pt-6">
                            <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ __('tools.credit.rates.tan') }}</span>
                            <span class="text-2xl font-didot text-brand-primary" x-text="tan.toFixed(3) + '%'"></span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- COLUNA DA DIREITA: RESULTADOS (STICKY) --}}
            <div class="lg:col-span-5" id="results-area">
                <div class="sticky top-32 space-y-8">
                    
                    {{-- Cartão Principal --}}
                    <div class="bg-brand-primary text-white p-10 shadow-2xl relative overflow-hidden group">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-premium/20 rounded-full blur-3xl group-hover:bg-brand-premium/30 transition-all duration-700"></div>

                        <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-premium mb-4">{{ __('tools.credit.results.monthly_installment') }}</h3>
                        
                        <div class="flex items-baseline gap-2 mb-8">
                            <span class="text-5xl md:text-6xl font-didot">
                                <span x-text="formatMoney(monthlyPayment)"></span>
                            </span>
                            <span class="text-xl font-light opacity-60">€</span>
                        </div>

                        <div class="space-y-4 text-sm font-light border-t border-white/10 pt-6">
                            <div class="flex justify-between">
                                <span class="text-gray-400">{{ __('tools.credit.results.breakdown_capital') }}</span>
                                <span>€ <span x-text="formatMoney(monthlyPayment)"></span></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">{{ __('tools.credit.results.breakdown_stamp') }}</span>
                                <span>€ <span x-text="formatMoney(monthlyStampDuty)"></span></span>
                            </div>
                            <div class="flex justify-between font-bold text-brand-premium pt-2 border-t border-white/5">
                                <span>{{ __('tools.credit.results.breakdown_total') }}</span>
                                <span>€ <span x-text="formatMoney(monthlyTotal)"></span></span>
                            </div>
                        </div>
                    </div>

                    {{-- Cartão Secundário: Resumo --}}
                    <div class="bg-white p-8 shadow-sm border border-gray-100">
                        <h4 class="font-didot text-xl text-brand-primary mb-6">{{ __('tools.credit.results.summary_title') }}</h4>
                        
                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 text-xs uppercase tracking-wide">{{ __('tools.credit.results.summary_equity') }}</span>
                                <span class="font-bold text-brand-primary">€ <span x-text="formatMoney(downPayment)"></span></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 text-xs uppercase tracking-wide">{{ __('tools.credit.results.summary_taxes') }}</span>
                                <span class="font-bold text-brand-cta">€ <span x-text="formatMoney(openingStampDuty)"></span></span>
                            </div>
                            <div class="h-px bg-gray-100 my-2"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 text-xs uppercase tracking-wide">{{ __('tools.credit.results.summary_cash') }}</span>
                                <span class="font-bold text-lg text-brand-primary">€ <span x-text="formatMoney(upfrontTotal)"></span></span>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-500 text-xs uppercase tracking-wide">{{ __('tools.credit.results.mtic') }}</span>
                                <span class="font-bold text-brand-primary">€ <span x-text="formatMoney(mtic)"></span></span>
                            </div>
                            <p class="text-[10px] text-gray-400 leading-tight">
                                {{ __('tools.credit.results.mtic_desc') }}
                            </p>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="text-center space-y-4">
                        <a href="{{ route('contact') }}" class="block w-full bg-brand-cta text-white font-bold uppercase tracking-[0.2em] py-5 shadow-lg hover:bg-brand-primary transition-all duration-300 text-xs">
                            {{ __('tools.credit.cta.btn') }}
                        </a>
                        <p class="text-[10px] text-gray-400">
                            {{ __('tools.credit.cta.legal') }}
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<script>
    function creditCalculator(translations) {
        return {
            propertyValue: 350000,
            downPayment: 70000,
            loanAmount: 280000,
            years: 30,
            age: 35,
            rateType: 'variable', 
            euriborRate: 2.17, 
            fixedRate: 3.5, 
            spread: 0.85,
            tan: 0,
            
            // Outputs
            monthlyPayment: 0,
            monthlyStampDuty: 0,
            monthlyTotal: 0,
            
            openingStampDuty: 0,
            upfrontTotal: 0,
            totalInterest: 0,
            mtic: 0,
            
            ltv: 0,
            ageWarning: '',
            translations: translations,

            formatMoney(value) {
                return new Intl.NumberFormat('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
            },

            updateLoanAmount() {
                if (this.downPayment > this.propertyValue) this.downPayment = this.propertyValue;
                this.loanAmount = this.propertyValue - this.downPayment;
                this.calculate();
            },

            checkMaxTerm() {
                if (!this.age) {
                    this.ageWarning = '';
                    return;
                }
                const maxAge = 75;
                const projectedAge = this.age + this.years;
                
                let maxTermAllowed = 40;
                if (this.age > 30 && this.age <= 35) maxTermAllowed = 37;
                if (this.age > 35) maxTermAllowed = 35;

                if (this.years > maxTermAllowed) {
                    // Usamos replace para inserir as variáveis na string traduzida
                    this.ageWarning = this.translations.warning_term
                        .replace(':age', this.age)
                        .replace(':max', maxTermAllowed);
                } else if (projectedAge > maxAge) {
                    this.ageWarning = this.translations.warning_age;
                } else {
                    this.ageWarning = '';
                }
            },

            calculate() {
                if(this.propertyValue > 0) {
                    this.ltv = (this.loanAmount / this.propertyValue) * 100;
                } else {
                    this.ltv = 0;
                }

                this.checkMaxTerm();

                if (this.rateType === 'variable') {
                    this.tan = this.euriborRate + this.spread;
                } else {
                    this.tan = this.fixedRate; 
                }

                let i = (this.tan / 100) / 12;
                let n = this.years * 12;

                if (i === 0) {
                    this.monthlyPayment = this.loanAmount / n;
                } else {
                    this.monthlyPayment = (this.loanAmount * i) / (1 - Math.pow(1 + i, -n));
                }

                // Imposto de Selo (4% sobre juros)
                let firstMonthInterest = this.loanAmount * i;
                this.monthlyStampDuty = firstMonthInterest * 0.04;
                this.monthlyTotal = this.monthlyPayment + this.monthlyStampDuty;

                // Custos Iniciais (IS sobre Capital)
                this.openingStampDuty = this.loanAmount * 0.006; // 0.6%
                this.upfrontTotal = this.downPayment + this.openingStampDuty;

                // MTIC Aproximado
                let totalPayments = this.monthlyPayment * n;
                this.totalInterest = totalPayments - this.loanAmount;
                let totalStampOnInterest = this.totalInterest * 0.04; // Estimativa linear
                
                this.mtic = totalPayments + totalStampOnInterest + this.openingStampDuty;
            }
        }
    }
</script>

@endsection