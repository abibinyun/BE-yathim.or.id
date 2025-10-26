<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Donasi Baru Diterima</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px; color: #333;">

  <div style="max-width: 600px; margin: auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 6px; padding: 20px;">
    <h2 style="color: #2c3e50; border-bottom: 2px solid #4CAF50; padding-bottom: 10px;">Donasi Baru Diterima</h2>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
      <tr>
        <td style="padding: 8px 0;"><strong>Kampanye:</strong></td>
        <td style="padding: 8px 0;">{{ $campaign->title }}</td>
      </tr>
      <tr>
        <td style="padding: 8px 0;"><strong>Jumlah:</strong></td>
        <td style="padding: 8px 0;">Rp{{ number_format($donation->amount, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td style="padding: 8px 0;"><strong>Metode Pembayaran:</strong></td>
        <td style="padding: 8px 0;">{{ $donation->payment_method }}</td>
      </tr>
      <tr>
        <td style="padding: 8px 0;"><strong>No Rekening Tujuan:</strong></td>
        <td style="padding: 8px 0;">{{ $donation->bank_account }}</td>
      </tr>
      <tr>
        <td style="padding: 8px 0;"><strong>Catatan Donatur:</strong></td>
        <td style="padding: 8px 0;">{{ $donation->notes ?? '-' }}</td>
      </tr>
    </table>

    @if($donation->payment_proof)
      <div style="margin-top: 20px;">
        <p><strong>Bukti Transfer:</strong></p>
        <img src="{{ asset('storage/' . $donation->payment_proof) }}" alt="Bukti Transfer" style="max-width: 100%; border: 1px solid #ccc; border-radius: 4px;">
      </div>
    @endif

    <p style="margin-top: 30px; font-size: 12px; color: #777;">
      Email ini dikirim otomatis oleh sistem donasi Yathim. Mohon tidak membalas email ini.
    </p>
  </div>

</body>
</html>
