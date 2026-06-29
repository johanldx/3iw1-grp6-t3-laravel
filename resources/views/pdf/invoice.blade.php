<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #2f2a26;
            background: #fff;
            padding: 40px;
        }

        /* En-tête */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }

        .header-left {
            display: table-cell;
            vertical-align: top;
        }

        .header-right {
            display: table-cell;
            vertical-align: top;
            text-align: right;
        }

        .brand {
            font-size: 26px;
            font-weight: bold;
            color: #6b4f43;
            letter-spacing: 1px;
        }

        .brand-sub {
            font-size: 11px;
            color: #8a7060;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            color: #2f2a26;
        }

        .invoice-number {
            font-size: 13px;
            color: #8a7060;
            margin-top: 4px;
        }

        .invoice-date {
            font-size: 12px;
            color: #8a7060;
            margin-top: 2px;
        }

        /* Séparateur */
        .divider {
            border: none;
            border-top: 1px solid #eaded5;
            margin: 28px 0;
        }

        /* Infos client / livraison */
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 32px;
        }

        .info-block {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .info-label {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #8a7060;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 13px;
            color: #2f2a26;
            line-height: 1.6;
        }

        .info-value strong {
            font-weight: bold;
        }

        /* Badge statut */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: #d1fae5;
            color: #065f46;
        }

        /* Tableau produits */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .products-table thead tr {
            background: #f8efe8;
        }

        .products-table th {
            padding: 10px 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #8a7060;
            text-align: left;
        }

        .products-table th.text-right {
            text-align: right;
        }

        .products-table td {
            padding: 12px 12px;
            border-bottom: 1px solid #f0e6df;
            vertical-align: middle;
            color: #2f2a26;
        }

        .products-table td.text-right {
            text-align: right;
        }

        .product-name {
            font-weight: bold;
        }

        /* Totaux */
        .totals {
            width: 100%;
            display: table;
        }

        .totals-spacer {
            display: table-cell;
            width: 55%;
        }

        .totals-block {
            display: table-cell;
            width: 45%;
            vertical-align: top;
        }

        .totals-row {
            display: table;
            width: 100%;
            padding: 7px 0;
            border-bottom: 1px solid #f0e6df;
        }

        .totals-row-label {
            display: table-cell;
            font-size: 12px;
            color: #72645b;
        }

        .totals-row-value {
            display: table-cell;
            font-size: 12px;
            color: #2f2a26;
            text-align: right;
            font-weight: 500;
        }

        .totals-total {
            display: table;
            width: 100%;
            padding: 10px 0 0;
        }

        .totals-total-label {
            display: table-cell;
            font-size: 14px;
            font-weight: bold;
            color: #2f2a26;
        }

        .totals-total-value {
            display: table-cell;
            font-size: 18px;
            font-weight: bold;
            color: #6b4f43;
            text-align: right;
        }

        /* Pied de page */
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eaded5;
            text-align: center;
            font-size: 11px;
            color: #8a7060;
            line-height: 1.7;
        }
    </style>
</head>
<body>

    <!-- En-tête -->
    <div class="header">
        <div class="header-left">
            <div class="brand">{{ config('app.name') }}</div>
            <div class="brand-sub">Boutique en ligne</div>
        </div>
        <div class="header-right">
            <div class="invoice-title">Facture</div>
            <div class="invoice-number"># {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="invoice-date">Émise le {{ $order->created_at->translatedFormat('d F Y') }}</div>
        </div>
    </div>

    <hr class="divider">

    <!-- Infos client / livraison -->
    <div class="info-grid">
        <div class="info-block">
            <div class="info-label">Client</div>
            <div class="info-value">
                <strong>{{ $order->user->name }}</strong><br>
                {{ $order->user->email }}
            </div>
        </div>
        <div class="info-block">
            <div class="info-label">Adresse de livraison</div>
            <div class="info-value">{{ $order->shipping_address }}</div>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-block">
            <div class="info-label">Statut</div>
            <div class="info-value">
                <span class="status-badge">{{ $order->status }}</span>
            </div>
        </div>
        <div class="info-block">
            <div class="info-label">Date de commande</div>
            <div class="info-value">{{ $order->created_at->translatedFormat('d F Y à H:i') }}</div>
        </div>
    </div>

    <hr class="divider">

    <!-- Tableau des produits -->
    <table class="products-table">
        <thead>
            <tr>
                <th>Produit</th>
                <th class="text-right">Prix unitaire</th>
                <th class="text-right">Qté</th>
                <th class="text-right">Sous-total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->products as $product)
                <tr>
                    <td class="product-name">{{ $product->name }}</td>
                    <td class="text-right">{{ number_format((float) $product->pivot->price, 2, ',', ' ') }} €</td>
                    <td class="text-right">{{ $product->pivot->quantity }}</td>
                    <td class="text-right">{{ number_format((float) $product->pivot->price * $product->pivot->quantity, 2, ',', ' ') }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totaux -->
    <div class="totals">
        <div class="totals-spacer"></div>
        <div class="totals-block">
            <div class="totals-row">
                <div class="totals-row-label">Sous-total</div>
                <div class="totals-row-value">{{ number_format((float) $order->total_price, 2, ',', ' ') }} €</div>
            </div>
            <div class="totals-row">
                <div class="totals-row-label">Livraison</div>
                <div class="totals-row-value" style="color: #059669;">Offerte</div>
            </div>
            <div class="totals-total">
                <div class="totals-total-label">Total TTC</div>
                <div class="totals-total-value">{{ number_format((float) $order->total_price, 2, ',', ' ') }} €</div>
            </div>
        </div>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <p>Merci pour votre commande !</p>
        <p>{{ config('app.name') }} &mdash; {{ config('app.url') }}</p>
    </div>

</body>
</html>
