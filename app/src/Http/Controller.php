<?php

namespace Http;

require_once ('../vendor/autoload.php');
require_once ('../config/database.php');
require_once ('../src/Services/DatabaseConnector.php');

class Controller {
    private $conn;
    private $twig;
    private $mailer; //mailer is yet to be installed via composer


    public function __construct()
    {
        $this->conn = \Services\DatabaseConnector::getConnection();
        //$this->mailer = new \Services\Mailer();

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates/pages/');
        $this->twig = new \Twig\Environment($loader, [
            'auto_reload' => true // set to false on production
        ]);
    }

    public function login() {
        $tpl = $this->twig->load('login.twig');
        echo $tpl->render();
        //in here you type everything you need to do for login (if the method gets too long create smaller methods and call them in here)
        die('login');
    }

    public function index () {

        die('index');
    }

    public function register() {
        $tpl = $this->twig->load('register.twig');
        echo $tpl->render();
        die('register');
        //in here you type everything you need to do for register (if the method gets too long create smaller methods and call them in here)
    }

    public function shop() {
        echo 'zaeazeazeazeazea';
        die('shop');
        //in here you type everything you need to do for shop (if the method gets too long create smaller methods and call them in here)
    }

    public function admin() {
        $tpl = $this->twig->load('admin.twig');
        echo $tpl->render();
        die('admin');
        //in here you type everything you need to do for admin (if the method gets too long create smaller methods and call them in here)
    }
}
