<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>OTP Anda</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px; margin: 0;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td style="padding: 30px 40px;">

                <h2 style="color: #333333; margin-top: 0;">Halo, {{ $name }}</h2>

                <p style="font-size: 16px; color: #555555;">
                    Kami menerima permintaan untuk kode OTP Anda.
                </p>

                <p style="font-size: 18px; color: #333333;">
                    Kode OTP Anda adalah:
                </p>

                <p style="font-size: 32px; font-weight: bold; color: #008970; margin: 20px 0;">
                    {{ $otp }}
                </p>

                <p style="font-size: 14px; color: #888888;">
                    Jangan bagikan kode ini kepada siapa pun. Kode ini bersifat rahasia dan hanya berlaku dalam waktu
                    terbatas.
                </p>

                <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">

                <p style="font-size: 12px; color: #bbbbbb;">
                    Jika Anda tidak meminta kode ini, abaikan email ini.
                </p>

            </td>
        </tr>
    </table>
</body>

</html>
