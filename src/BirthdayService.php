<?php

class BirthdayService
{
    /** @var Messenger */
    private $messenger;

    /** @var  EmployeeRepository */
    private $employeeRepository;

    public function __construct($messenger, $employeeRepository)
    {
        $this->messenger          = $messenger;
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
     * @param Employee $employee
     */
    private function sendGreeting($employee)
    {
        $message = new Message(
            [$employee->getEmail()],
            sprintf('Happy Birthday, dear %s!', $employee->getFirstName()),
            'Happy Birthday!',
            'sender@here.com'
        );

        $this->messenger->send($message);
    }
}