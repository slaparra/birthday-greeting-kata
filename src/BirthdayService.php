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
        $this->messenger->send($this->buildBirthdayMessage($employee));
    }

    /**
     * @param Employee $employee
     *
     * @return Message
     */
    private function buildBirthdayMessage($employee)
    {
        return new Message(
            [$employee->getEmail()],
            sprintf('Happy Birthday, dear %s!', $employee->getFirstName()),
            'Happy Birthday!',
            'sender@here.com'
        );
    }
}