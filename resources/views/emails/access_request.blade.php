<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; color: #333; }
        .box { border: 1px solid #ddd; padding: 20px; border-radius: 5px; background: #f9f9f9; }
        .btn { display: inline-block; background: #000; color: #fff; padding: 10px 20px; text-decoration: none; margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Nova Solicitação de Acesso Private</h2>
    <p>Um novo candidato solicitou acesso à área exclusiva.</p>
    
    <div class="box">
        <p><strong>Nome:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Telefone:</strong> {{ $user->phone_number }}</p>
        <hr>
        <p><strong>Motivação:</strong><br> {{ $user->notes }}</p>
        @if($user->document_path)
            <p>📎 <strong>Documento:</strong> Anexado ao perfil.</p>
        @endif
    </div>

    <p>Acesse o painel para aprovar ou rejeitar:</p>
    <a href="{{ route('admin.requests.index') }}" class="btn">Gerir Solicitações</a>
</body>
</html>