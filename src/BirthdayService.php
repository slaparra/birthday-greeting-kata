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
        $fileHandler = fopen($fileName, 'r');
        fgetcsv($fileHandler);

        $employees = [];
        while ($employeeData = fgetcsv($fileHandler, null, ',')) {
            $employeeData = array_map('trim', $employeeData);
            $employees[]  = new Employee($employeeData[1], $employeeData[0], $employeeData[2], $employeeData[3]);
        }

        return $employees;
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