<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
</head>

<body>
<div class="container"
     style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <h2>Redefinição de Senha</h2>
    <p>Olá,</p>
    <p>Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para a sua conta.</p>
    <!-- Use uma tabela para o botão para um melhor suporte em clientes de e-mail -->
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" width="200" height="40" bgcolor="#2800da"
                style="border-radius: 5px; color: #ffffff; display: block;">
                <a href="{{ $url }}"
                   style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; line-height:40px; width:100%; display:inline-block">
                    <span style="color: #ffffff;">Redefinir Senha</span>
                </a>
            </td>
        </tr>
    </table>
    <p>Se você não solicitou uma redefinição de senha, por favor ignore este e-mail ou nos contate se acreditar que isso seja um erro.</p>
    <p>Obrigado,</p>
    <p>Equipe de Suporte</p>
</div>
</body>

</html>
