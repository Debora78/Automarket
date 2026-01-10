{{-- 
Template PDF: Fattura ordine (Automarket)

Funzionalità:
- Layout semplice e compatibile con generatori PDF (es. dompdf, snappy)
- Mostra data, elenco articoli e totale
- Utilizza font DejaVu Sans per supporto UTF-8
- Stile minimale per garantire compatibilità con stampa e PDF
--}}

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Fattura Automarket</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #111;
        }

        h1 {
            color: #16a34a;
            margin-bottom: 10px;
        }

        h3 {
            margin-top: 25px;
            margin-bottom: 10px;
        }

        ul {
            padding-left: 18px;
        }

        li {
            margin-bottom: 4px;
        }

        hr {
            margin: 20px 0;
        }
    </style>
</head>

<body>

    <h1>Fattura Automarket</h1>

    <p>Data: {{ now()->format('d/m/Y') }}</p>

    <hr>

    <h3>Dettaglio ordine</h3>

    <ul>
        @foreach ($items as $item)
            <li>
                {{ $item->car->brand }} {{ $item->car->model }} –
                € {{ number_format($item->car->price, 2, ',', '.') }}
            </li>
        @endforeach
    </ul>

    <p>
        <strong>Totale:</strong>
        € {{ number_format($total, 2, ',', '.') }}
    </p>

    <hr>

    <p>Grazie per aver acquistato su Automarket!</p>

</body>

</html>
