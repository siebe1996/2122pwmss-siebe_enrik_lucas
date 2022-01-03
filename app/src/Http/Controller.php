<?php
namespace Http;
class Controller
{
    private $conn;
    private $twig;
    private $mailer; //mailer is yet to be installed via composer


    public function __construct()
    {
        $this->conn = \Services\DatabaseConnector::getConnection();
        $this->mailer = new \Services\Mailer();

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
        $this->twig = new \Twig\Environment($loader, [
            'auto_reload' => true // set to false on production
        ]);
    }

    public function login() {
        //in here you type everything you need to do for login (if the method gets too long create smaller methods and call them in here)
    }

    public function register() {
        //in here you type everything you need to do for register (if the method gets too long create smaller methods and call them in here)
    }

    public function shop() {
        //in here you type everything you need to do for shop (if the method gets too long create smaller methods and call them in here)
    }

    public function admin() {
        //in here you type everything you need to do for admin (if the method gets too long create smaller methods and call them in here)
    }

}