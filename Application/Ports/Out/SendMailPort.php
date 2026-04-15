<?php
declare(strict_types=1);

interface SendMailPort
{
    public function send(string $to, string $subject, string $htmlBody): void;
}
