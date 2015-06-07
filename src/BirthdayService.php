<?php

class BirthdayService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    public function sendGreetings($fileName, XDate $xDate, $smtpHost, $smtpPort)
    {
        $employees = $this->loadEmployees($fileName);

        foreach ($employees as $employee) {
            if ($employee->isBirthday($xDate)) {
                $this->sendGreeting($smtpHost, $smtpPort, $employee);
            }
        }
    }

    private function sendMessage($smtpHost, $smtpPort, $sender, $subject, $body, $recipient)
    {
        // Create a mail session
        $this->mailer = Swift_Mailer::newInstance(Swift_SmtpTransport::newInstance($smtpHost, $smtpPort));

        // Construct the message
        $msg = Swift_Message::newInstance($subject);
        $msg
            ->setFrom($sender)
            ->setTo([$recipient])
            ->setBody($body)
        ;

        // Send the message
        $this->doSendMessage($msg);
    }

    // made protected for testing :-(
    protected function doSendMessage(Swift_Message $msg)
    {
        $this->mailer->send($msg);
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
     * @param $smtpHost
     * @param $smtpPort
     * @param $employee
     */
    private function sendGreeting($smtpHost, $smtpPort, $employee)
    {
        $body      = sprintf('Happy Birthday, dear %s!', $employee->getFirstName());
        $subject   = 'Happy Birthday!';
        $this->sendMessage($smtpHost, $smtpPort, 'sender@here.com', $subject, $body, $employee->getEmail());
    }
}