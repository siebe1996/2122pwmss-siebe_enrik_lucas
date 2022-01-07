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

    public function order() {
        $tpl = $this->twig->load('orderForm1.twig');
        echo $tpl->render();
    }

    public function admin() {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $categorieName = isset($_POST['categorieName']) ? $_POST['categorieName'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $stock = isset($_POST['stock']) ? $_POST['stock'] : '0';
        $type = isset($_POST['type']) ? $_POST['type'] : '';
        $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
        $weight = isset($_POST['weight']) ? $_POST['weight'] : '';
        $featured = isset($_POST['yes_no']) ? $_POST['yes_no'] : '0';
        $toRemove = isset($_POST['productCategorie']) ? $_POST['productCategorie'] : '';
        $selected = isset($_POST['SelectedProduct']) ? $_POST['SelectedProduct'] : '';
        $nameUpdate = isset($_POST['nameUpdate']) ? $_POST['nameUpdate'] : '';
        $descriptionUpdate = isset($_POST['descriptionUpdate']) ? $_POST['descriptionUpdate'] : '';
        $priceUpdate = isset($_POST['priceUpdate']) ? $_POST['priceUpdate'] : '';
        $stockUpdate = isset($_POST['stockUpdate']) ? $_POST['stockUpdate'] : '';
        $weightUpdate = isset($_POST['weightUpdate']) ? $_POST['weightUpdate'] : '';
        $typeUpdate= isset($_POST['typeUpdate']) ? $_POST['typeUpdate'] : '';
        $categorieUpdate= isset($_POST['categorieUpdate']) ? $_POST['categorieUpdate'] : '';
        $featuredUpdate= isset($_POST['yes_no_update']) ? $_POST['yes_no_update'] : '';
        $idin = isset($_POST['idin']) ? $_POST['idin'] : '';
        $formErrors = [];
        $formErrors1 = [];
        $formErrors2 = [];
        $formErrors3 = [];

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'insertProduct')) {

            if(empty(trim($_POST["name"]))) {
                $formErrors[] = "*Please enter a product name.";
            }

            if(empty(trim($_POST["price"]))) {
                $formErrors[] = "*Please enter a product price.";
            }

            if(empty(trim($_POST["weight"]))) {
                $formErrors[] = "*Please enter the product weight.";
            }

            if(empty(trim($_POST["stock"]))) {
                $stock = 0;
            }

            if (sizeof($formErrors) == 0){
                $stmt = $this->conn->prepare('INSERT into products VALUES(?,?,?,?,?,?,?,?,?,?)');
                $rowCount = $stmt->executeStatement([null,$name,$stock,$description,$price,$type,'NULL',$featured,$categorie,$weight]);

            }
        }

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'insertCategorie')) {

            if(empty(trim($_POST["categorieName"]))) {
                $formErrors1[] = "*Please enter a categorie name.";
            }

            if (sizeof($formErrors1) == 0){
                $stmt = $this->conn->prepare('insert into categories VALUES(?,?)');
                $rowCount = $stmt->executeStatement([null,$categorieName]);

            }
        }

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'DeleteProduct')) {

            if(empty(trim($_POST["productCategorie"]))) {
                $formErrors2[] = "*Please select a product to remove.";
            }

            if (sizeof($formErrors2) == 0){
                $stmt = $this->conn->prepare('DELETE FROM products WHERE id = ?');
                $rowCount = $stmt->executeStatement([$toRemove]);

            }
        }

        $prod = [];
        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'SelectedProduct')) {
            $prod = $this->conn->fetchAllAssociative('SELECT * FROM products WHERE id = '.$selected);
        }

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'EditProduct')) {

            if(empty(trim($_POST["nameUpdate"]))) {
                $formErrors3[] = "*Please enter a product name.";
            }

            if(empty(trim($_POST["priceUpdate"]))) {
                $formErrors3[] = "*Please enter a product price.";
            }

            if(empty(trim($_POST["weightUpdate"]))) {
                $formErrors3[] = "*Please enter the product weight.";
            }

            if(empty(trim($_POST["stockUpdate"]))) {
                $stockUpdate = 0;
            }

            if (sizeof($formErrors3) == 0){
                $stmt = $this->conn->executeStatement('UPDATE products set name = ?,stock = ?,description= ?,price= ?,sortweight = ?,categories_id = ?,featured = ? WHERE id = ?',array($nameUpdate,$stockUpdate,$descriptionUpdate,$priceUpdate,$weightUpdate,$categorieUpdate,$featuredUpdate,$idin));
                // $rowCount = $stmt->executeStatement([$nameUpdate,$stockUpdate,$descriptionUpdate,$priceUpdate,$weightUpdate]);

            }
        }

        $productlist = $this->conn->fetchAllAssociative('SELECT * FROM products');
        $cats = $this->conn->fetchAllAssociative('SELECT * FROM categories');
        $tpl = $this->twig->load('admin.twig');
        echo $tpl->render([
            'errors' => $formErrors,
            'errors1' => $formErrors1,
            'errors2' => $formErrors2,
            'errors3' => $formErrors3,
            'name' => $name,
            'stock' => $stock,
            'description' => $description,
            'price' => $price,
            'weight' => $weight,
            'categorieName' => $categorieName,
            'items' => $productlist,
            'selected' => $prod,
            'idin' => $selected,
            'cats'=> $cats
        ]);

        //in here you type everything you need to do for admin (if the method gets too long create smaller methods and call them in here)
    }
}
