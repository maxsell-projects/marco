@component('mail::message')
# Nova Oportunidade | Private Office

Caro **José Carvalho**,

Recebeu uma nova solicitação de contacto através do seu portal oficial. Seguem os detalhes do potencial cliente:

@component('mail::table')
| Dado | Informação |
| :--- | :--- |
| **Nome** | {{ $data['name'] }} |
| **Email** | [{{ $data['email'] }}](mailto:{{ $data['email'] }}) |
| **Telefone** | {{ $data['phone'] ?? 'Não indicado' }} |
| **Interesse** | {{ $data['subject'] }} |
@endcomponent

### Mensagem:
@component('mail::panel')
{{ $data['message'] }}
@endcomponent

@component('mail::button', ['url' => 'mailto:' . $data['email'], 'color' => 'primary'])
Responder ao Cliente
@endcomponent

Atenciosamente,<br>
**Sistema Digital José Carvalho**
@endcomponent