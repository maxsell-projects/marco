<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório de Simulação de Mais-Valias</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #2E2E2E; margin: 0; padding: 0; font-size: 12px; }
        .container { width: 100%; max-width: 700px; margin: 0 auto; padding: 40px; }
        
        .header { text-align: center; margin-bottom: 50px; border-bottom: 2px solid #C2A86D; padding-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; letter-spacing: 2px; color: #0F2A44; text-transform: uppercase; margin-bottom: 5px; }
        .subtitle { font-size: 9px; text-transform: uppercase; letter-spacing: 3px; color: #C2A86D; }
        
        .summary-box { background-color: #F5F4F1; padding: 30px; border-left: 5px solid #0F2A44; margin-bottom: 40px; }
        .summary-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #6B8F71; margin-bottom: 5px; font-weight: bold; }
        .summary-value { font-size: 32px; font-weight: bold; color: #0F2A44; margin-bottom: 20px; }
        
        .details-table { width: 100%; border-collapse: collapse; }
        .details-table th, .details-table td { padding: 12px 0; border-bottom: 1px solid #E0E0E0; text-align: left; }
        .details-table th { color: #888; font-weight: normal; font-size: 11px; text-transform: uppercase; }
        .details-table td { text-align: right; font-weight: bold; color: #2E2E2E; }
        .details-table .highlight { color: #C2A86D; }
        .details-table .negative { color: #C46A45; }
        
        .section-title { font-size: 14px; color: #0F2A44; font-weight: bold; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px; }
        
        .footer { margin-top: 60px; text-align: center; font-size: 9px; color: #AAA; border-top: 1px solid #EEE; padding-top: 20px; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">José Carvalho</div>
            <div class="subtitle">Private Office & Investment Strategy</div>
        </div>

        <div class="summary-box">
            <div class="summary-label">Imposto Estimado a Pagar (IRS)</div>
            <div class="summary-value">{{ $results['estimated_tax_fmt'] }} €</div>
            
            <table width="100%">
                <tr>
                    <td style="font-size: 11px; color: #666;">Mais-Valia Bruta Apurada</td>
                    <td style="text-align: right; font-weight: bold; font-size: 14px;">{{ $results['gross_gain_fmt'] }} €</td>
                </tr>
            </table>
        </div>

        <div class="section-title">Detalhamento do Cálculo</div>

        <table class="details-table">
            <tr>
                <th>Valor de Realização (Venda)</th>
                <td>{{ $results['sale_fmt'] }} €</td>
            </tr>
            <tr>
                <th>Valor de Aquisição (Histórico)</th>
                <td>{{ $data['acquisition_value'] }} €</td>
            </tr>
            <tr>
                <th>Coeficiente de Desvalorização ({{ $data['acquisition_year'] }})</th>
                <td>x {{ $results['coefficient'] }}</td>
            </tr>
            <tr>
                <th style="color: #0F2A44; font-weight: bold;">Valor de Aquisição Atualizado</th>
                <td class="negative">- {{ $results['acquisition_updated_fmt'] }} €</td>
            </tr>
            <tr>
                <th>Despesas e Encargos Dedutíveis</th>
                <td class="negative">- {{ $results['expenses_fmt'] }} €</td>
            </tr>
            
            @if(isset($results['reinvestment_fmt']) && $results['reinvestment_fmt'] != '0,00')
            <tr>
                <th>Reinvestimento (Habitação Própria)</th>
                <td class="negative">- {{ $results['reinvestment_fmt'] }} €</td>
            </tr>
            @endif

            <tr style="border-top: 2px solid #0F2A44;">
                <th style="padding-top: 15px; color: #0F2A44; font-weight: bold;">Mais-Valia Líquida Tributável (50%)</th>
                <td style="padding-top: 15px; font-size: 16px; color: #0F2A44;">{{ $results['taxable_gain_fmt'] }} €</td>
            </tr>
        </table>

        <div class="footer">
            <p>Simulação gerada automaticamente em {{ $date }}.</p>
            <p>Este documento é uma estimativa baseada nos dados fornecidos e na legislação fiscal em vigor. <br>
            Não dispensa a consulta de um contabilista certificado ou da Autoridade Tributária.</p>
            <p><strong>José Carvalho Real Estate</strong> | Lisboa, Portugal</p>
        </div>
    </div>
</body>
</html>