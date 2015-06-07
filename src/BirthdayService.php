<?php

class BirthdayService
{
    /** @var Messenger */
    private $mailer;

    /** @var  EmployeeRepository */
    private $employeeRepository;

    public function __construct($mailer, $employeeRepository)
    {
        $this->mailer             = $mailer;
        $this->employeeRepository = $employeeRepository;
    }

    public function sendGreetings(XDate $xDate)
    {
        $employees = $this->employeeRepository->findAll();

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
    private function loadEmployees()
    {
        $this->employeeRepository = $this->employeeRepository;

        return $this->employeeRepository->findAll();
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