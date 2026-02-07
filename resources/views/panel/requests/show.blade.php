@extends('layouts.panel')

@section('content')
<div class="max-w-5xl mx-auto">
    
    <a href="{{ route('admin.requests.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-brand-dark uppercase tracking-widest mb-6">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Voltar para Lista
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center text-3xl font-serif text-gray-400">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h2 class="font-serif text-2xl text-brand-dark">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>
                
                <span class="inline-block px-3 py-1 bg-yellow-50 text-yellow-700 text-[10px] font-bold uppercase tracking-widest rounded-full mb-6">
                    Pendente Aprovação
                </span>

                <div class="border-t border-gray-100 pt-6 text-left space-y-3">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400">Data de Registro</p>
                        <p class="text-sm font-medium">{{ $user->created_at->format('d/m/Y - H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400">Função Solicitada</p>
                        <p class="text-sm font-medium capitalize">{{ $user->role }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-serif text-lg text-brand-dark mb-4">Decisão</h3>
                <div class="space-y-3">
                    <form action="{{ route('admin.requests.approve', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-green-600 text-white font-bold uppercase tracking-widest hover:bg-green-700 transition-colors rounded-sm shadow-md">
                            Aprovar Acesso
                        </button>
                    </form>

                    <form action="{{ route('admin.requests.reject', $user->id) }}" method="POST" onsubmit="return confirm('Tem certeza? Isso apagará o registro.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-3 border border-red-200 text-red-600 font-bold uppercase tracking-widest hover:bg-red-50 transition-colors rounded-sm">
                            Rejeitar & Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-serif text-xl text-brand-dark mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    Mensagem do Usuário
                </h3>
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 text-gray-600 italic leading-relaxed">
                    @if($user->registration_message)
                        "{{ $user->registration_message }}"
                    @else
                        <span class="text-gray-400 not-italic">Nenhuma mensagem enviada.</span>
                    @endif
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 h-full">
                <h3 class="font-serif text-xl text-brand-dark mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Documento Anexado
                </h3>

                @if($user->document_path)
                    <div class="border-2 border-dashed border-gray-200 rounded-lg p-8 text-center bg-gray-50">
                        <p class="text-sm text-gray-500 mb-4">Documento disponível para visualização</p>
                        
                        <div class="flex justify-center gap-4">
                            <a href="{{ asset('storage/' . $user->document_path) }}" target="_blank" class="px-6 py-2 bg-brand-dark text-white text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors">
                                Visualizar / Baixar
                            </a>
                        </div>
                        
                        @php $ext = pathinfo($user->document_path, PATHINFO_EXTENSION); @endphp
                        @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                            <div class="mt-6">
                                <img src="{{ asset('storage/' . $user->document_path) }}" class="max-w-full h-auto rounded shadow-sm mx-auto max-h-96">
                            </div>
                        @endif
                    </div>
                @else
                    <div class="border-2 border-dashed border-gray-200 rounded-lg p-12 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <p class="text-gray-400">Nenhum documento enviado.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection