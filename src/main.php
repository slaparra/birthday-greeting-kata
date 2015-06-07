<?php

$service = new BirthdayService(
    new Mailer('localhost', 25)
);
$service->sendGreetings('employee_data.txt', new XDate('2008/10/08'));
