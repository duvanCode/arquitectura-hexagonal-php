<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/ForgotPasswordUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetUserByEmailPort.php';
require_once __DIR__ . '/../Ports/Out/SavePasswordResetPort.php';
require_once __DIR__ . '/../Ports/Out/SendMailPort.php';

final class ForgotPasswordService implements ForgotPasswordUseCase
{
    private GetUserByEmailPort  $getUserByEmailPort;
    private SavePasswordResetPort $savePasswordResetPort;
    private SendMailPort          $sendMailPort;

    public function __construct(
        GetUserByEmailPort    $getUserByEmailPort,
        SavePasswordResetPort $savePasswordResetPort,
        SendMailPort          $sendMailPort
    ) {
        $this->getUserByEmailPort   = $getUserByEmailPort;
        $this->savePasswordResetPort = $savePasswordResetPort;
        $this->sendMailPort          = $sendMailPort;
    }

    public function execute(ForgotPasswordCommand $command): void
    {
        // No revelar si el correo existe o no (seguridad)
        $user = $this->getUserByEmailPort->getByEmail($command->getEmail());
        if ($user === null) {
            return;
        }

        $token     = bin2hex(random_bytes(32)); // 64 chars
        $expiresAt = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

        $this->savePasswordResetPort->savePasswordReset(
            $token,
            $command->getEmail(),
            $expiresAt
        );

        $resetUrl = $command->getBaseUrl() . '?route=auth.reset&token=' . urlencode($token);
        $subject  = 'Recuperación de contraseña';
        $body     = $this->buildEmailBody($user->name()->value(), $resetUrl);

        $this->sendMailPort->send($command->getEmail(), $subject, $body);
    }

    private function buildEmailBody(string $name, string $resetUrl): string
    {
        $safeUrl  = htmlspecialchars($resetUrl, ENT_QUOTES, 'UTF-8');
        $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"></head>
<body style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:20px;">
    <h2>Recuperación de contraseña</h2>
    <p>Hola, <strong>{$safeName}</strong>.</p>
    <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta.</p>
    <p>Haz clic en el siguiente enlace para crear una nueva contraseña.
       El enlace es válido durante <strong>1 hora</strong>.</p>
    <p style="margin:24px 0;">
        <a href="{$safeUrl}"
           style="background:#3b82f6;color:#fff;padding:12px 24px;
                  text-decoration:none;border-radius:4px;">
            Restablecer contraseña
        </a>
    </p>
    <p>Si no puedes hacer clic en el botón, copia y pega este enlace en tu navegador:</p>
    <p style="word-break:break-all;color:#555;">{$safeUrl}</p>
    <hr>
    <p style="color:#888;font-size:12px;">
        Si no solicitaste este cambio, puedes ignorar este correo.
    </p>
</body>
</html>
HTML;
    }
}
