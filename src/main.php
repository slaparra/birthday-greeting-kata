<?php

$service = new BirthdayService(
    new SwiftMailer('localhost', 25),
    new EmployeeFileRepository('employee_data.txt')
);
$service->sendGreetings(new XDate('2008/10/08'));
