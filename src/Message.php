<?php

/**
 * Class Message
 *
 * @package ${NAMESPACE}
 */
class Message
{
    /** @var  array */
    private $to;

    /** @var  string */
    private $body;

    /** @var  string */
    private $subject;

    /** @var  string */
    private $from;

    public function __construct($to, $body, $subject, $from)
    {
        $this->setTo($to);
        $this->body    = (string) $body;
        $this->subject = (string) $subject;
        $this->from    = (string) $from;
    }

    /**
     * @return array
     */
    public function to()
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function subject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function from()
    {
        return $this->from;
    }

    /**
     * @param array
     */
    private function setTo(array $to)
    {
        foreach ($to as $recipient) {
            $this->to[$recipient] = $recipient;
        }
    }
}
