<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../Application/Ports/Out/SendMailPort.php';

final class SmtpMailer implements SendMailPort
{
    private string $host;
    private int    $port;
    private string $username;
    private string $password;
    private string $from;
    private string $fromName;
    private string $encryption; // 'ssl', 'tls', o ''

    public function __construct(
        string $host,
        int    $port,
        string $username,
        string $password,
        string $from,
        string $fromName,
        string $encryption
    ) {
        $this->host       = $host;
        $this->port       = $port;
        $this->username   = $username;
        $this->password   = $password;
        $this->from       = $from;
        $this->fromName   = $fromName;
        $this->encryption = strtolower(trim($encryption));
    }

    public function send(string $to, string $subject, string $htmlBody): void
    {
        $socket = $this->connect();

        try {
            // Saludo del servidor
            $this->read($socket, 220);

            // EHLO
            $this->write($socket, 'EHLO ' . $this->getLocalHostname());
            $this->read($socket, 250);

            // STARTTLS si la encriptación es 'tls'
            if ($this->encryption === 'tls') {
                $this->write($socket, 'STARTTLS');
                $this->read($socket, 220);
                stream_socket_enable_crypto(
                    $socket,
                    true,
                    STREAM_CRYPTO_METHOD_TLS_CLIENT
                );
                // Repetir EHLO tras el handshake TLS
                $this->write($socket, 'EHLO ' . $this->getLocalHostname());
                $this->read($socket, 250);
            }

            // Autenticación
            $this->write($socket, 'AUTH LOGIN');
            $this->read($socket, 334);
            $this->write($socket, base64_encode($this->username));
            $this->read($socket, 334);
            $this->write($socket, base64_encode($this->password));
            $this->read($socket, 235);

            // Sobre del mensaje
            $this->write($socket, 'MAIL FROM:<' . $this->from . '>');
            $this->read($socket, 250);
            $this->write($socket, 'RCPT TO:<' . $to . '>');
            $this->read($socket, 250);

            // Cuerpo del mensaje
            $this->write($socket, 'DATA');
            $this->read($socket, 354);

            $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $message =
                'From: ' . $this->fromName . ' <' . $this->from . ">\r\n" .
                'To: ' . $to . "\r\n" .
                'Subject: ' . $encodedSubject . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                'Content-Transfer-Encoding: base64' . "\r\n" .
                "\r\n" .
                chunk_split(base64_encode($htmlBody)) .
                "\r\n.";

            fwrite($socket, $message . "\r\n");
            $this->read($socket, 250);

            // Cerrar sesión
            $this->write($socket, 'QUIT');
            @$this->read($socket, 221);

        } finally {
            fclose($socket);
        }
    }

    /** @return resource */
    private function connect()
    {
        $address = ($this->encryption === 'ssl')
            ? 'ssl://' . $this->host . ':' . $this->port
            : 'tcp://' . $this->host . ':' . $this->port;

        $context = stream_context_create(array(
            'ssl' => array(
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ),
        ));

        $socket = stream_socket_client(
            $address,
            $errno,
            $errstr,
            30,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if ($socket === false) {
            throw new RuntimeException(
                'No se pudo conectar al servidor SMTP (' . $this->host . ':' . $this->port . '): ' . $errstr
            );
        }

        stream_set_timeout($socket, 30);

        return $socket;
    }

    /** @param resource $socket */
    private function write($socket, string $command): void
    {
        fwrite($socket, $command . "\r\n");
    }

    /**
     * Lee la respuesta del servidor y lanza excepción si el código no coincide.
     *
     * @param resource $socket
     */
    private function read($socket, int $expectedCode): string
    {
        $response = '';
        while (($line = fgets($socket, 512)) !== false) {
            $response .= $line;
            // Una respuesta de múltiples líneas termina cuando el 4.° carácter es espacio
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }

        $actualCode = (int) substr($response, 0, 3);
        if ($actualCode !== $expectedCode) {
            throw new RuntimeException(
                'Error SMTP (esperado ' . $expectedCode . ', recibido ' . $actualCode . '): ' . trim($response)
            );
        }

        return $response;
    }

    private function getLocalHostname(): string
    {
        $host = gethostname();
        return ($host !== false && $host !== '') ? $host : 'localhost';
    }
}
