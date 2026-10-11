<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran KostHub</title>
    <style>
        body { font-family: sans-serif; color: #333; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #2563eb; margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0; font-size: 12px; color: #666; }
        .badge { display: inline-block; padding: 6px 12px; background-color: #16a34a; color: white; font-weight: bold; border-radius: 4px; font-size: 14px; float: right; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; font-size: 13px; }
        .table th { background-color: #f8fafc; font-weight: bold; }
        .total { font-size: 16px; font-weight: bold; color: #2563eb; }
        .footer { margin-top: 40px; text-align: right; font-size: 12px; }
        .signature { margin-top: 50px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KOSTHUB MANAGEMENT</h1>
        <p>Kwitansi Bukti Pembayaran Resmi Sewa Kamar Kost</p>
    </div>

    <div>
        <span class="badge">LUNAS / PAID</span>
        <p style="font-size: 12px; margin: 0;"><strong>No. Transaksi:</strong> #INV-{{ $payment->invoice_id }}</p>
        <p style="font-size: 12px; margin: 5px 0 0;"><strong>Tanggal Verifikasi:</strong> {{ \Carbon\Carbon::parse($payment->updated_at)->format('d M Y, H:i') }} WIB</p>
    </div>

    <table class="table">
        <tr>
            <th>Nama Penghuni</th>
            <td>{{ $payment->invoice?->tenant?->user?->name ?? 'Penghuni' }}</td>
        </tr>
        <tr>
            <th>Nomor Kamar</th>
            <td>Kamar {{ $payment->invoice?->room?->room_number ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nomor WhatsApp</th>
            <td>{{ $payment->invoice?->tenant?->phone ?? '-' }}</td>
        </tr>
        <tr>
            <th>Periode Tagihan</th>
            <td>{{ \Carbon\Carbon::parse($payment->invoice?->due_date)->format('F Y') }}</td>
        </tr>
        <tr>
            <th>Total Pembayaran</th>
            <td class="total">Rp {{ number_format($payment->invoice?->amount ?? 0, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Medan, {{ \Carbon\Carbon::parse($payment->updated_at)->format('d M Y') }}</p>
        <p>Pengelola KostHub,</p>
        <div class="signature">( Pemilik Kost )</div>
    </div>
</body>
</html>