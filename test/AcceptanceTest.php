<?php

class AcceptanceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Message[]
     */
    private $messagesSent = [];
    /**
     * @var BirthdayService
     */
    private $service;

    /** @var  TestableMailer */
    private $mailer;


    private $employeeRepository;

    public function setUp()
    {
        $this->mailer  = new TestableMailer('fake_host', 666);
        $this->employeeRepository = new InMemoryEmployeeRepository();

        $this->service = new BirthdayService(
            $this->mailer,
            $this->employeeRepository
        );
    }

    public function tearDown()
    {
        $this->service = $this->messagesSent = null;
    }

    /**
     * @test
     */
    public function willSendGreetings_whenItsSomebodysBirthday()
    {
        $this->service->sendGreetings(new XDate('2008/10/08'));
        $this->messagesSent = $this->mailer->getMessagesSent();

        $this->assertCount(1, $this->messagesSent, 'message not sent?');
        $message = $this->messagesSent[0];
        $this->assertEquals('Happy Birthday, dear John!', $message->body());
        $this->assertEquals('Happy Birthday!', $message->subject());
        $this->assertCount(1, $message->to());
        $this->assertEquals('john.doe@foobar.com', array_keys($message->to())[0]);
    }

    /**
     * @test
     */
    public function willNotSendEmailsWhenNobodysBirthday()
    {
        $this->service->sendGreetings(new XDate('2008/01/01'));

        $this->assertCount(0, $this->messagesSent, 'what? messages?');
    }
}

Class TestableMailer implements Messenger
{
    /** @var string */
    private $host;

    /** @var int */
    private $port;

    /** @var  Message[] */
    private $msg;

    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @inheritdoc
     */
    public function send(Message $msg)
    {
        $this->msg[] = $msg;

        return;
    }

    /**
     * @return Message[]
     */
    public function getMessagesSent()
    {
        return $this->msg;
    }
}

Class InMemoryEmployeeRepository implements EmployeeRepository
{
    /**
     * @return Employee[]|null
     */
    public function findAll()
    {
        return [
            new Employee('John', 'Doe', '1982/10/08', 'john.doe@foobar.com')
        ];
    }
}