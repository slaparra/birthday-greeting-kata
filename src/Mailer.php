<?php

/**
 * Class Mailer
 *
 * @package greeting
 */
class Mailer implements Messenger
{
    public function __construct($smtpHost, $smtpPort)
    {
        $this->mailer = Swift_Mailer::newInstance(Swift_SmtpTransport::newInstance($smtpHost, $smtpPort));
    }

    /**
     * @inheritdoc
     */
    public function send(Swift_Message $msg)
    {
        $this->mailer->send($msg);
    }
}
