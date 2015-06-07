<?php

/**
 * Interface Messenger
 *
 * @package greeting
 */
interface Messenger
{
    /**
     * @param Message $msg
     */
    public function send(Message $msg);
}
