<?php

/**
 * Class SwiftMailer
 *
 * @package greeting
 */
class SwiftMailer implements Messenger
{
    public function __construct($smtpHost, $smtpPort)
    {
        $this->mailer = Swift_Mailer::newInstance(Swift_SmtpTransport::newInstance($smtpHost, $smtpPort));
    }

    /**
     * @inheritdoc
     */
    public function send(Message $msg)
    {
        $msg = Swift_Message::newInstance($msg->subject())
            ->setFrom($msg->from())
            ->setTo([$msg->to()])
            ->setBody($msg->body());

        $this->mailer->send($msg);
    }
}
