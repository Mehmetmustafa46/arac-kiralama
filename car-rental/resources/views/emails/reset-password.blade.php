<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifre Sıfırlama</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #f8f9fa;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #0d6efd;
            text-decoration: none;
        }
        .content {
            padding: 30px 20px;
            background-color: #ffffff;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0d6efd;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            font-size: 14px;
            color: #6c757d;
        }
        .text-center {
            text-align: center;
        }
        .mt-4 {
            margin-top: 1.5rem;
        }
        .mb-4 {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ config('app.url') }}" class="logo">Araç Kiralama</a>
        </div>

        <div class="content">
            <h2 class="text-center">Şifre Sıfırlama</h2>

            <p>Merhaba,</p>

            <p>Hesabınız için bir şifre sıfırlama talebinde bulundunuz. Şifrenizi sıfırlamak için aşağıdaki butona tıklayın:</p>

            <div class="text-center">
                <a href="{{ url('reset-password/'.$token) }}" class="button">Şifremi Sıfırla</a>
            </div>

            <p>Bu şifre sıfırlama bağlantısı {{ config('auth.passwords.users.expire') }} dakika içinde sona erecektir.</p>

            <p>Eğer şifre sıfırlama talebinde bulunmadıysanız, bu e-postayı görmezden gelebilirsiniz.</p>
        </div>

        <div class="footer">
            <p>Bu e-posta {{ config('app.name') }} tarafından gönderilmiştir.</p>
        </div>
    </div>
</body>
</html> 