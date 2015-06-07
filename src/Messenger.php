<?php

/**
 * Interface Messenger
 *
 * @package greeting
 */
interface Messenger
{
    /**
     * @param $msg
     */
    public function send(Swift_Message $msg);
}
