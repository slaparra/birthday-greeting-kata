<?php

class BirthdayService
{
    /** @var Messenger */
    private $mailer;

    public function __construct($mailer)
    {
        $this->mailer  = $mailer;
    }

    public function sendGreetings($fileName, XDate $xDate)
    {
        $employees = $this->loadEmployees($fileName);

        /** @var Employee $employee */
        foreach ($employees as $employee) {
            if ($employee->isBirthday($xDate)) {
                $this->sendGreeting($employee);
            }
        }
    }

    /**
     * @param $fileName
     *
     * @return array
     */
    private function loadEmployees($fileName)
    {
        return (new EmployeeFileRepository($fileName))->findAll();
    }

    /**
     * @param Employee $employee
     */
    private function sendGreeting($employee)
    {
        $body      = sprintf('Happy Birthday, dear %s!', $employee->getFirstName());
        $subject   = 'Happy Birthday!';
        $this->mailer->send(new Message([$employee->getEmail()], $body, $subject, 'sender@here.com'));
    }
}