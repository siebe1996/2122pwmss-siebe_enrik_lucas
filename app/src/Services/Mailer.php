<?php

namespace Services;
use Swift_Message;
use Swift_SmtpTransport;



class Mailer {

    private $host = 'smtp.mailtrap.io';
    private $username = '791275d54d09bd';
    private $password = '9c224bb2de4d42';
    private $mailer;
    private $port = '2525';

    public function __construct() {
        $transport = (new Swift_SmtpTransport($this->host, $this->port))
            ->setUsername($this->username)
            ->setPassword($this->password)
        ;
        $this->mailer = new \Swift_Mailer($transport);
    }
    public function send($body,$variables) {
        $date = date('d/m/Y');
        $message = (new Swift_Message('Nieuwe bestelling ' . $date))
            ->setFrom(['noreply-orders@gmail.com' => 'New order notifier'])
            ->setTo(['sven.ijswinkel@gmail.com'])
            ->setBody($body->render($variables),'text/html');
        $this->mailer->send($message);
    }




}












