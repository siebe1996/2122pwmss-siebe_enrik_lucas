<?php

namespace Http;
use SplFileInfo;
use DateTime;

use Services\Helper;
use Services\Mailer;
use const http\Client\Curl\VERSIONS;


require_once ('../vendor/autoload.php');
require_once ('../config/database.php');
require_once ('../src/Services/DatabaseConnector.php');
require_once ('../src/Services/Helper.php');
require_once ('../src/Services/Mailer.php');



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
        session_start();

        $test =  isset($_COOKIE['PopupTimer']) ? (string)$_COOKIE['PopupTimer'] : '';

        if(empty(trim($test))) {
            $cookie_name = "PopupTimer";
            $cookie_value = date('d');
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
            $this->x = 11;
        }

    }




    public function order1() {
        //$formData = unserialize($_COOKIE['formData']);
        //var_dump($formData);
        if(isset($_POST['moduleAction1']) && $_POST['moduleAction1'] == 'moduleAction1') {
            $formInfo['customerInfo'] = $this->procesOrderDetails1();
            if($formInfo['customerInfo']['errors']) {
                var_dump('error');
                var_dump($formInfo['customerInfo']['errors']);
                $tpl = $this->twig->load('orderForm1.twig');
                echo $tpl->render($formInfo['customerInfo']);
            }
            else {
                setcookie('formData',serialize($formInfo));
                header(
                    'Location: /order/2'
                );
            }
        }
        else {
            $tpl = $this->twig->load('orderForm1.twig');
            echo $tpl->render();
        }
    }
    public function getCategories() {
        return $this->conn->prepare('SELECT * FROM categories')->executeQuery()->fetchAllAssociative();
    }

    public function order2() {
        $categories = $this->getCategories();
        $this->getArrayOfCategoryIds();
        $orderedProducts = isset($_COOKIE['orderedProducts']) ? (string)$_COOKIE['orderedProducts'] : '';
        echo('Ordered products array: ' . $orderedProducts . PHP_EOL);

        $formData = unserialize($_COOKIE['formData']);
        var_dump($formData);
        if(!$formData['customerInfo']) {
            header('Location: /order/1');
        }
        if(isset($_POST['moduleAction']) && $_POST['moduleAction'] == 'moduleAction') {
            $choice = $this->procesOrderDetails2();
            //var_dump('Selected item' . $choice['selectedItem']);
            if($choice['errors']) {
                $tpl = $this->twig->load('orderForm2.twig');
                echo $tpl->render([
                    'orderedProducts' => $orderedProducts,
                    'categories' => $categories
                ]);
            }
            else {
                if(in_array($choice['selectedItem'],['1','2','3','4','5'])) {
                    header('Location: /order/3/'.$choice['selectedItem']);
                }
                else {
                    header('Location: /order/2');
                }
            }
        }
        else {
            $tpl = $this->twig->load('orderForm2.twig');
            echo $tpl->render([
                'orderedProducts' => $orderedProducts,
                'categories' => $categories
            ]);
        }
    }

    public function booking() {
        if(isset($_POST['moduleAction']) && $_POST['moduleAction'] == 'moduleAction') {
            $form = $this->procesBookingDetails();
            if($form['errors']) {
                $tpl = $this->twig->load('orderCart.twig');
                echo $tpl->render(
                    $form
                );
            }
            else {
                $booking = [
                    'name' => $form['name'],
                    'description' => $form['description'],
                    'address' => $form['address'],
                    'fromTime' => ''

                ];
                header('location: /thankyou');
            }
        }
        else {
            $tpl = $this->twig->load('orderCart.twig');
            echo $tpl->render();
        }
    }

    public function insertBookingIntoDB($booking) {
        $stmt = $this->conn->prepare('INSERT into arrangements VALUES(?,?,?,?,?,?,?,?,?)');
        $rowCount = $stmt->executeStatement([null,$booking['name'],$booking['description'],$booking['address'], $booking['fromTime'],$booking['untilTime'],1,1,'www.google.com']);

    }

    public function procesBookingDetails() {
        $email = isset($_POST['email']) ? (string)$_POST['email'] : '';
        $name = isset($_POST['name']) ? (string)$_POST['name'] : '';
        $address = isset($_POST['address']) ? (string)$_POST['address'] : '';
        $phone = isset($_POST['phone']) ? (string)$_POST['phone'] : '';
        $date = isset($_POST['date']) ? (string)$_POST['date'] : '';
        $fromTime = isset($_POST['fromTime']) ? (string)$_POST['fromTime'] : '';
        var_dump($fromTime);
        $untilTime = isset($_POST['untilTime']) ? (string)$_POST['untilTime'] : '';
        var_dump($untilTime);
        $formErrors = [];
        if(Helper::validateDate($date)) $formErrors[]=Helper::validateDate($date);
        if(Helper::checkIfTimesAreLogical($fromTime,$untilTime)) $formErrors[] = Helper::checkIfTimesAreLogical($fromTime,$untilTime);
        if(!\Services\Helper::validatePhonenumber($phone) && ''!=trim($phone))  $formErrors[] = '*This phone number is invalid';
        if (trim($email) == '') {
            $formErrors[] = '*Please fill in an email';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $formErrors[] = '*Email address is not valid.';
        }
        if (trim($name) == '') $formErrors[] = '*Please fill in a name';

        return [
            'errors' => $formErrors,
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
            'date' => $date,
            'fromTime' => $fromTime,
            'untilTime' => $untilTime
        ];
    }

    public function getProductIdWithName($name) : string {
        $stmt = $this->conn->prepare('SELECT id FROM products WHERE name = :name');
        $stmt->bindParam(':name',$name);
        return $stmt->executeQuery()->fetchAssociative()['id'];
    }

    public function getCategoryNameWithId($id) : array {
        return $this->conn->prepare('SELECT name from categories WHERE id ='.$id)->executeQuery()->fetchAssociative();
    }

    public function getProductsOfCategory($categoryId) : array {
        $stmt = $this->conn->prepare('SELECT * FROM products WHERE categories_id ='. $categoryId);
        $products = $stmt->executeQuery()->fetchAllAssociative();
        return $products;
    }
    public function orderProduct($categoryId) {
        $formData = unserialize($_COOKIE['formData']);
        if(!($formData['customerInfo'])) {
            header('Location: /order/1');
        }
        $products = $this->getProductsOfCategory($categoryId);
        $tpl = $this->twig->load('orderForm3.twig');
        echo $tpl->render([
            'products' => $products,
            'form' => $categoryId
        ]);
        if(isset($_POST['moduleAction']) && $_POST['moduleAction'] == 'moduleAction') {
            $orderedProductsString = isset($_COOKIE['orderedProducts']) ? (string)$_COOKIE['orderedProducts'] : '';
            $orderedProducts = unserialize($orderedProductsString);
            $orderedProducts[] = $this->verifyProduct($categoryId);
            setcookie('orderedProducts',serialize($orderedProducts),0,'/');
            var_dump($_COOKIE['orderedProducts']);
            header('Location: /order/2');
        }
    }

    public function reformProductarray($arr) : array {
        $name = key($arr[0]);
        $amount = $arr[0][$name];
        $name = Helper::replaceUnderscoresWithSpaces($name);
        return [
            'name' => $name,
            'amount' => $amount
        ];
    }

    public function getStockOfProduct($product)  {
        $stmt = $this->conn->prepare('SELECT stock FROM products WHERE name = :name');
        $stmt->bindParam(':name',$product);
        return $stmt->executeQuery()->fetchAssociative();
    }

    public function checkIfOrderIsCorrect($price,$reformedProduct) : array {
        $error = [];
        if(!$price) $error[]='This product is currently not for sale';
        if($this->getStockOfProduct($reformedProduct['name'])>$reformedProduct['amount']) $error[]='We currently only have '. $this->getStockOfProduct($reformedProduct['name']) . 'of the product: '.$reformedProduct['name'] .'.';
        return $error;
    }

    public function finishOrder() {
        $formData = unserialize($_COOKIE['formData']);
        if(!$_COOKIE['orderedProducts']) header('Location: /order/2');
        $orderedProducts = unserialize(($_COOKIE['orderedProducts']));
        $products = [];
        $totalPrice = 0;
        if($formData && $orderedProducts) {
            foreach($orderedProducts as $orderedProduct) {
                $reformedProduct = $this->reformProductarray($orderedProduct);
                $price = $this->getPriceOfProduct($reformedProduct['name'],$reformedProduct['amount']);
                $product = [
                    'name' => $reformedProduct['name'],
                    'amount' => $reformedProduct['amount'],
                    'priceProduct' => $price['each'],
                    'priceProducts' => $price['total']
                ];
                $products[] = $product;
                $totalPrice+=$price['total'];
            }
            $customerInfo = $formData['customerInfo'];
            $tpl = $this->twig->load('finishOrder.twig');
            echo $tpl->render([
                'products' => $products,
                'contact' => $customerInfo,
                'totalPrice' => $totalPrice
            ]);
        }
        if(isset($_POST['moduleAction']) && $_POST['moduleAction'] == 'moduleAction') $this->submitForm([
            'products' => $products,
            'contact' => $customerInfo,
            'totalPrice' => $totalPrice
        ]);

    }
    public function getUniqueOrderId() {
        return $this->conn->executeQuery('SELECT MAX(order_id) from order_has_product ')->fetchAssociative()["MAX(order_id)"]+1;
    }

    public function submitForm($var) {
        $this->insertOrders($var);
        $mailer = new Mailer();
        $mailer->send($this->twig->load('mail.twig'),$var);
        //header('location: /shop.php');
    }

    public function createTemporaryCustomer($contact) {
        $query = 'insert into users (address,email,name,password,phonenumber) VALUES(:address,:email,:name,:password,:phonenumber)';
        $stmt = $this->conn->prepare($query);
        var_dump($contact['address']);
        var_dump($contact['email']);
        var_dump($contact['name']);
        var_dump($contact['address']);

        $stmt->bindParam(':address',$contact['address']);
        $stmt->bindParam(':email',$contact['email']);
        $stmt->bindParam(':name',$contact['name']);
        $password_hash = password_hash('temporaryCustomer',PASSWORD_DEFAULT);
        var_dump($password_hash);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':phonenumber',$contact['phone']);
        $stmt->executeQuery();
        var_dump('succes');
    }

    public function getUserIdWithName() {
        return $this->conn->executeQuery('SELECT MAX(id) from users')->fetchAssociative()['MAX(id)'];
    }







    public function insertOrders($var) {
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
        if(!$user) {
            $this->createTemporaryCustomer($var['contact']);
            echo 'test';
            $userId = $this->getUserIdWithName();
        }
        else {
            $userId = $_SESSION['id'];
        }
        $orderId = $this->getUniqueOrderId();
        $stmt = $this->conn->prepare('INSERT INTO orders (date,id,user_id) VALUES(:date,:orderId,:userId)');
        var_dump($orderId);
        var_dump($userId);
        $stmt->bindParam(':date',$var['contact']['date']);
        $stmt->bindParam(':orderId',$orderId);
        $stmt->bindParam(':userId',$userId);
        $stmt->executeQuery();
        foreach($var['products'] as $product) {
            $id = $this->getProductIdWithName($product['name']);
            var_dump($orderId);
            if($id) {
                var_dump($var['contact']['date']);
                var_dump($orderId);
                var_dump($userId);
                $stmt = $this->conn->prepare('INSERT INTO order_has_product (product_id,order_id,quantity) VALUES(:productId,:orderId,:amount)');
                $stmt->bindParam(':productId',$id);
                $stmt->bindParam(':orderId',$orderId);
                $stmt->bindParam(':amount',$product['amount']);
                $stmt->executeQuery();
            }
        }
    }

    public function getPriceOfProduct($product,$amount) {
        $query = 'SELECT price FROM products WHERE name = :name';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name',$product);
        $price = $stmt->executeQuery()->fetchAssociative()['price'];
        return [
            'each' => $price,
            'total' => round($price * $amount,2)
        ];
    }


    public function verifyProduct($categoryId) : array
    {
        $stmt = $this->conn->prepare('SELECT name FROM products WHERE categories_id =' . $categoryId);
        $productNames = $stmt->executeQuery()->fetchAllAssociative();
        var_dump($productNames);
        $orderedProducts = [];
        var_dump($_POST);
        foreach ($productNames as $productName) {
            $productName = Helper::replaceSpacesWithUnderscores($productName['name']);
            var_dump($productName);
            if ($_POST[$productName]) {
                $orderedProduct = [$productName => $_POST[$productName]];
                $orderedProducts[] = $orderedProduct;
            }
        }
        if(!$orderedProducts) {
            var_dump('tis leeg');
        }
        var_dump($orderedProducts);
        return $orderedProducts;
    }

    public function getArrayOfCategoryIds() {
        return $categoryIds = $this->conn->prepare('SELECT id FROM categories')->executeQuery()->fetchAllAssociative();
    }


    public function procesOrderDetails2() : array {
        $selectedItem = isset($_POST['selectedItem']) ? (string)$_POST['selectedItem'] : '';
        $sqlArray = $this->conn->prepare('SELECT id from categories')->executeQuery()->fetchAllAssociative();
        $allowedItems = Helper::getValuesFromSQLArray($sqlArray,'id');
        echo  ' Selected Item ' . $selectedItem;
        if(in_array($selectedItem,$allowedItems)) {
            return [
                'errors' =>'',
                'selectedItem' =>$selectedItem,
            ];
        }
        else return ['errors' => '*Please submit a valid value'];
    }


    public function procesOrderDetails1() : array {
        $email = isset($_POST['email']) ? (string)$_POST['email'] : '';
        $name = isset($_POST['name']) ? (string)$_POST['name'] : '';
        $address = isset($_POST['address']) ? (string)$_POST['address'] : '';
        $phone = isset($_POST['phone']) ? (string)$_POST['phone'] : '';
        $date = isset($_POST['date']) ? (string)$_POST['date'] : '';
        $formErrors = [];

        echo 'The date problem: ';
        var_dump(Helper::validateDate($date));
        echo' End of the date problem';
        if(Helper::validateDate($date)) {
            $formErrors[]=Helper::validateDate($date);
            echo 'The date problem: ';
            var_dump(Helper::validateDate($date));
            echo' End of the date problem';
        }
        if(!\Services\Helper::validatePhonenumber($phone))  $formErrors[] = '*This phone number is invalid';
        if (trim($email) == '') {
            $formErrors[] = '*Please fill in an email';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $formErrors[] = '*Email address is not valid.';
        }
        if (trim($name) == '') {
            $formErrors[] = '*Please fill in a name';
        }
        return [
            'errors' => $formErrors,
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
            'date' => $date
        ];
    }





    public function calendar(){
        $eventsdate = $this->conn->fetchAllAssociative('SELECT start_time FROM arrangements');
        $eventsdate2 = $this->conn->fetchAllAssociative('SELECT end_time FROM arrangements');
        $eventsname = $this->conn->fetchAllAssociative('SELECT name FROM arrangements');

        $simple_array = array();
        $simple_array2 = array();
        $simple_array3 = array();

        foreach($eventsdate as $d)
        {
            $simple_array[]=$d['start_time'];
        }
        foreach($eventsdate2 as $d)
        {
            $simple_array2[]=$d['end_time'];
        }
        foreach($eventsname as $d)
        {
            $simple_array3[]=$d['name'];
        }

        $test = [];
        for ($x = 0; $x <= count($simple_array3) - 1; $x++) {
            $test[] = [$simple_array[$x],$simple_array2[$x],$simple_array3[$x]];
        }
        $tpl = $this->twig->load('calendar.twig');
        echo $tpl->render([
            'events' => $test
        ]);

    }

    public function login() {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $formErrors = [];
        $result = [];

        $user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
        if ($user){
            header('location: index');
            exit();
        }
        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'login')) {
            $user = $this->conn->fetchAssociative('SELECT * FROM users WHERE email = ?', [$email]);

            if ($user !== false) {

                if (password_verify($password, $user['password'])) {

                    $_SESSION['user'] = $user;
                    header('location: index');
                    exit();
                }

                else {
                    $formErrors[] = 'Invalid login credentials';

                }
            }
            // username & password are not valid
            else {
                $formErrors[] = 'Invalid login credentials';

            }
        }

        $tpl = $this->twig->load('login.twig');
        echo $tpl->render([
            'email' => $email,
            'errors' => $formErrors,
            'res'=>$result
        ]);
    }

    public function logout(){
        session_destroy();
        header("location: index");
    }

    public function register(){
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';
        $telephone = $_POST['telephone'] ?? '';
        $password = $_POST['password'] ?? '';

        $formErrors = [];

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'register')) {

            if(empty(trim($_POST["name"]))) {
                $formErrors[] = "Please enter your name.";
            }

            if(empty(trim($_POST["email"]))) {
                $formErrors[] = "Please enter your email.";
            }

            if(empty(trim($_POST["address"]))) {
                $formErrors[] = "Please enter your address.";
            }

            if(empty(trim($_POST["password"]))) {
                $formErrors[] = "Please enter your password.";
            }

            if (sizeof($formErrors) == 0){
                $stmt = $this->conn->prepare('INSERT INTO users (name, email, address, phonenumber, password) VALUES (?, ?, ?, ?, ?)');
                $result = $stmt->executeStatement([$name, $email, $address, $telephone, password_hash($password, PASSWORD_DEFAULT)]);
                header('Location: login.php');
            }


        }

        $tpl = $this->twig->load('register.twig');
        echo $tpl->render([
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'telephone' => $telephone,
            'errors' => $formErrors
        ]);

    }

    public function index () {
        $popup = $this->conn->fetchOne('select frequency FROM popups where id = 1');
        $popupName = $this->conn->fetchOne('select message FROM popups where id = 1');
        $productlist = $this->conn->fetchAllAssociative('SELECT * FROM products WHERE featured = 1');
        $productlist2 = $this->conn->fetchAllAssociative('SELECT * FROM products');
        $date2 = new DateTime('today');
        $V = $date2->getTimestamp();

        $test =  isset($_COOKIE['PopupTimer']) ? (string)$_COOKIE['PopupTimer'] : '';


        $cook = 0;
        if(!empty(trim($test))) {
            if ($V > $_COOKIE['PopupTimer']){
                $date1 = new DateTime('today');
                $date1->modify('+'.$popup.'day');
                setcookie('PopupTimer', $date1->getTimestamp(), time() + (86400 * 30), "/");
                $cook = 1;
            }else{
                $cook = 0;
            }

        }
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
        if ($user){
            $url = 'logout';
            $text = 'logout';


        }else{
            $url = 'login';
            $text = 'login';

        }
        $tpl = $this->twig->load('index.twig');
        echo $tpl->render([
            'products' => $productlist,
            'products2' => $productlist2,
            'popup' => $popupName,
            'cook' => $cook,
            'url'=> $url,
            'text'=> $text
        ]);
    }


    public function shop () {
        $productlist = $this->conn->fetchAllAssociative('SELECT * FROM products');
        $categories = $this->getCategories();
        $tpl = $this->twig->load('shop.twig');
        echo $tpl->render([
            'products'=>$productlist,
            'categories' => $categories
        ]);
    }

    public function insertCategories(){

        $formErrors1 = [];
        $categorieName = isset($_POST['categorieName']) ? $_POST['categorieName'] : '';

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'insertCategorie')) {

            if(empty(trim($_POST["categorieName"]))) {
                $formErrors1[] = "*Please enter a categorie name.";
            }

            if (sizeof($formErrors1) == 0){
                $stmt = $this->conn->prepare('insert into categories VALUES(?,?)');
                $rowCount = $stmt->executeStatement([null,$categorieName]);

            }
        }
        return $formErrors1;

    }

    public function deleteProduct(){

        $formErrors2 = [];
        $toRemove = isset($_POST['productCategorie']) ? $_POST['productCategorie'] : '';


        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'DeleteProduct')) {
            if (sizeof($formErrors2) == 0){
                $stmt = $this->conn->prepare('DELETE FROM products WHERE id = ?');
                $rowCount = $stmt->executeStatement([$toRemove]);

            }
        }
    }

    public function deleteOrder(){

        $delOrderId = isset($_POST['delOrderId']) ? $_POST['delOrderId'] : '';

        $formErrors1 = [];
        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'DeleteOrder')) {

            if(empty(trim($_POST["delOrderId"]))) {
                $formErrors1[] = "*Please insert an order id to remove.";
            }

            if (sizeof($formErrors1) == 0){
                $stmt = $this->conn->prepare('DELETE FROM order_has_product WHERE order_id = ?');
                $rowCount = $stmt->executeStatement([$delOrderId]);
                $stmt = $this->conn->prepare('DELETE FROM orders WHERE id = ?');
                $rowCount = $stmt->executeStatement([$delOrderId]);
            }
        }

        return $formErrors1;
    }

    public function insertEvent(){
        $formErrors = [];
        $eventname = isset($_POST['eventname']) ? $_POST['eventname'] : '';
        $eventdescription = isset($_POST['eventdescription']) ? $_POST['eventdescription'] : '';
        $eventlocation= isset($_POST['eventlocation']) ? $_POST['eventlocation'] : '';
        $sdate = isset($_POST['sdate']) ? $_POST['sdate'] : '';
        $edate= isset($_POST['edate']) ? $_POST['edate'] : '';

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'insertEvent')) {

            if(empty(trim($_POST["eventname"]))) {
                $formErrors[] = "*Please enter an event name.";
            }

            if(empty(trim($_POST["eventdescription"]))) {
                $formErrors[] = "*Please enter an event description.";
            }

            if(empty(trim($_POST["eventlocation"]))) {
                $formErrors[] = "*Please enter the event location.";
            }

            if(empty(trim($_POST["sdate"]))) {
                $formErrors[] = "*Please enter a start date.";
            }
            if(empty(trim($_POST["edate"]))) {
                $formErrors[] = "*Please enter an end date.";
            }

            if (sizeof($formErrors) == 0){
                $stmt = $this->conn->prepare('INSERT into arrangements VALUES(?,?,?,?,?,?,?,?,?)');
                $rowCount = $stmt->executeStatement([null,$eventname,$eventdescription,$eventlocation, $sdate,$edate,1,1,'www.google.com']);
            }
        }
        return $formErrors;
    }

    public function insertProduct(){

        $formErrors = [];
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $stock = isset($_POST['stock']) ? $_POST['stock'] : '0';
        $type = isset($_POST['type']) ? $_POST['type'] : '';
        $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
        $weight = isset($_POST['weight']) ? $_POST['weight'] : '';
        $featured = isset($_POST['yes_no']) ? $_POST['yes_no'] : '0';

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'insertProduct')) {

            if(empty(trim($_POST["name"]))) {
                $formErrors[] = "*Please enter a product name.";
            }

            if(empty(trim($_POST["price"]))) {
                $formErrors[] = "*Please enter a product price.";
            }

            if(empty(trim($_POST["stock"]))) {
                $formErrors[] = "*Please enter a product stock.";
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
                $numItems = $this->conn->fetchOne('SELECT id FROM products where name = ?', array($name));

                if (sizeof($formErrors) == 0){
                    if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'insertProduct')) {
                        if (isset($_FILES['avatar']) && ($_FILES['avatar']['error'] === UPLOAD_ERR_OK) && sizeof($formErrors) == 0) {
                            if (in_array((new SplFileInfo($_FILES['avatar']['name']))->getExtension(), ['jpeg', 'jpg', 'png', 'gif'])) {
                                $moved = @move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/../../public/images/' . $numItems . '.jpg');
                                if ($moved) {
                                    echo '<p><img src="' . $_FILES['avatar']['name'] . '" alt="" /><p>';
                                } else {
                                    echo('<p>Error while saving file in the uploads folder</p>');
                                }
                            } else {
                                echo('<p>Invalid extension. Only .jpeg, .jpg, .png or .gif allowed</p>');
                            }
                        }
                    }
                }

            }
        }

        return $formErrors;
    }

    public function deleteEvent(){

        $formErrors2 = [];
        $eventid  = isset($_POST['eventid']) ? $_POST['eventid'] : '';

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'deleteEvent')) {
            if(empty(trim($_POST["eventid"]))) {
                $formErrors2[] = "*Please enter event id to remove.";
            }

            if (sizeof($formErrors2) == 0){
                $stmt = $this->conn->prepare('DELETE FROM arrangements WHERE id = ?');
                $rowCount = $stmt->executeStatement([$eventid]);

            }
        }

        return $formErrors2;
    }

    public function selectProduct(){
        $selected = isset($_POST['selectProduct']) ? $_POST['selectProduct'] : '';
        $prod = [];
        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'selectProduct')) {
            $prod = $this->conn->fetchAllAssociative('SELECT * FROM products WHERE id = '.$selected);
        }
        return $prod;
    }

    public function editProduct(){

        $formErrors3 = [];
        $nameUpdate = isset($_POST['nameUpdate']) ? $_POST['nameUpdate'] : '';
        $descriptionUpdate = isset($_POST['descriptionUpdate']) ? $_POST['descriptionUpdate'] : '';
        $priceUpdate = isset($_POST['priceUpdate']) ? $_POST['priceUpdate'] : '';
        $stockUpdate = isset($_POST['stockUpdate']) ? $_POST['stockUpdate'] : '';
        $weightUpdate = isset($_POST['weightUpdate']) ? $_POST['weightUpdate'] : '';
        $typeUpdate= isset($_POST['typeUpdate']) ? $_POST['typeUpdate'] : '';
        $categorieUpdate= isset($_POST['categorieUpdate']) ? $_POST['categorieUpdate'] : '';
        $featuredUpdate= isset($_POST['yes_no_update']) ? $_POST['yes_no_update'] : '';
        $idin = isset($_POST['idin']) ? $_POST['idin'] : '';


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

                echo $typeUpdate;
                $stmt = $this->conn->prepare('UPDATE products SET  name = ?, stock = ? , description = ? , price  = ?  , featured = ? , categories_id = ?, sortweight = ? WHERE id = ?');
                $rowCount = $stmt->executeStatement([$nameUpdate, $stockUpdate , $descriptionUpdate, $priceUpdate,  $featuredUpdate, $categorieUpdate, $weightUpdate , $idin]);

            }


        }

        return $formErrors3;
    }

    public function selectOrder(){

        $orderid = isset($_POST['orderid']) ? $_POST['orderid'] : '';

        $selectedOrder = [];
        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'SelectedOrder')) {
            $selectedOrder = $this->conn->fetchAllAssociative('select * FROM order_has_product INNER JOIN products ON order_has_product.product_id = products.id WHERE order_id = ?', array($orderid));

        }

        return $selectedOrder;

    }

    public function editOrder(){
        $orderid =  isset($_POST['orderid']) ? $_POST['orderid'] : '';
        $quantity1 = isset($_POST['quantity1']) ? $_POST['quantity1'] : '';
        $productid1 = isset($_POST['productid1']) ? $_POST['productid1'] : '';
        $order_id1 = isset($_POST['order_id1']) ? $_POST['order_id1'] : '';
        $quantity2 = isset($_POST['quantity2']) ? $_POST['quantity2'] : '';
        $productid2 = isset($_POST['productid2']) ? $_POST['productid2'] : '';
        $order_id2 = isset($_POST['order_id2']) ? $_POST['order_id2'] : '';
        $quantity3 = isset($_POST['quantity3']) ? $_POST['quantity3'] : '';
        $productid3 = isset($_POST['productid3']) ? $_POST['productid3'] : '';
        $order_id3= isset($_POST['order_id3']) ? $_POST['order_id3'] : '';

        $quantity4 = isset($_POST['quantity4']) ? $_POST['quantity4'] : '';
        $productid4 = isset($_POST['productid4']) ? $_POST['productid4'] : '';
        $order_id4 = isset($_POST['order_id4']) ? $_POST['order_id4'] : '';
        $quantity5 = isset($_POST['quantity5']) ? $_POST['quantity5'] : '';
        $productid5 = isset($_POST['productid5']) ? $_POST['productid5'] : '';
        $order_id5= isset($_POST['order_id5']) ? $_POST['order_id5'] : '';
        $quantity6 = isset($_POST['quantity6']) ? $_POST['quantity6'] : '';
        $productid6 = isset($_POST['productid6']) ? $_POST['productid6'] : '';
        $order_id6 = isset($_POST['order_id6']) ? $_POST['order_id6'] : '';
        $quantity7 = isset($_POST['quantity7']) ? $_POST['quantity7'] : '';
        $productid7 = isset($_POST['productid7']) ? $_POST['productid7'] : '';
        $order_id7= isset($_POST['order_id7']) ? $_POST['order_id7'] : '';

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'editOrder')) {
            if(empty(trim($_POST["quantity1"]))) {
            }else{
                $stmt = $this->conn->prepare('UPDATE order_has_product SET quantity = ? WHERE product_id = ? AND order_id = ?');
                $rowCount = $stmt->executeStatement([$quantity1, $productid1 , $order_id1]);
            }
            if(empty(trim($_POST["quantity2"]))) {
            }else{
                $stmt = $this->conn->prepare('UPDATE order_has_product SET quantity = ? WHERE product_id = ? AND order_id = ?');
                $rowCount = $stmt->executeStatement([$quantity2, $productid2 , $order_id2]);
            }
            if(empty(trim($_POST["quantity3"]))) {
            }else{
                $stmt = $this->conn->prepare('UPDATE order_has_product SET quantity = ? WHERE product_id = ? AND order_id = ?');
                $rowCount = $stmt->executeStatement([$quantity3, $productid3 , $order_id3]);
            }
            if(empty(trim($_POST["quantity4"]))) {
            }else{
                $stmt = $this->conn->prepare('UPDATE order_has_product SET quantity = ? WHERE product_id = ? AND order_id = ?');
                $rowCount = $stmt->executeStatement([$quantity1, $productid4 , $order_id4]);
            }
            if(empty(trim($_POST["quantity5"]))) {
            }else{
                $stmt = $this->conn->prepare('UPDATE order_has_product SET quantity = ? WHERE product_id = ? AND order_id = ?');
                $rowCount = $stmt->executeStatement([$quantity1, $productid5 , $order_id5]);
            }
            if(empty(trim($_POST["quantity6"]))) {
            }else{
                $stmt = $this->conn->prepare('UPDATE order_has_product SET quantity = ? WHERE product_id = ? AND order_id = ?');
                $rowCount = $stmt->executeStatement([$quantity1, $productid6 , $order_id6]);
            } if(empty(trim($_POST["quantity7"]))) {
            }else{
                $stmt = $this->conn->prepare('UPDATE order_has_product SET quantity = ? WHERE product_id = ? AND order_id = ?');
                $rowCount = $stmt->executeStatement([$quantity1, $productid7 , $order_id7]);
            }
        }
    }


    public function addTag(){

        $formErrors1 = [];
        $Product = isset($_POST['orderidTag']) ? $_POST['orderidTag'] : '';
        $tag = isset($_POST['tag']) ? $_POST['tag'] : '';

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'SelectedPID')) {

            if(empty(trim($_POST["orderidTag"]))) {
                $formErrors1[] = "*Please enter a product id.";
            }
            if(empty(trim($_POST["tag"]))) {
                $formErrors1[] = "*Please enter a tag.";
            }


            if (sizeof($formErrors1) == 0){
                $id = $this->conn->fetchOne('select  COUNT(*) FROM tags ') + 1;
                $stmt = $this->conn->prepare('insert into tags VALUES(?,?)');
                $rowCount = $stmt->executeStatement([$id,$tag]);




                $stmt = $this->conn->prepare('insert into product_has_tag VALUES(?,?)');
                $rowCount = $stmt->executeStatement([$Product,$id]);
            }
        }

        return $formErrors1;
    }

    public function admin() {

        $user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
        if (!$user){
            header('location: index');
            exit();
        }else{
            if ($user['is_admin'] == 0){
                header('location: index');
                exit();
            }
        }

        $formErrors1 = $this->deleteOrder();
        $formErrors7 = $this->addTag();
        $formErrors2 = $this->insertCategories();
        $formErrors5 = $this->deleteEvent();
        $formErrors3 = $this->insertProduct();
        $formErrors4 = $this->insertEvent();
        $prod = $this->selectProduct();
        $selectedOrder = $this->selectOrder();
        $formErrors6 = $this->editProduct();
        $this->deleteProduct();


        $this->editOrder();


        $output1 = array_slice($selectedOrder, 0, 1);
        $output2 = array_slice($selectedOrder, 1,1);
        $output3 = array_slice($selectedOrder, 2,1);
        $output4 = array_slice($selectedOrder, 3,1);
        $output5 = array_slice($selectedOrder, 4,1);
        $output6 = array_slice($selectedOrder, 5,1);
        $output7 = array_slice($selectedOrder, 6,1);

        $events = $this->conn->fetchAllAssociative('SELECT * FROM arrangements');
        $productlist = $this->conn->fetchAllAssociative('SELECT * FROM products');
        $orderlist = $this->conn->fetchAllAssociative('SELECT * FROM orders');
        $cats = $this->conn->fetchAllAssociative('SELECT * FROM categories');


        $tpl = $this->twig->load('admin.twig');
        echo $tpl->render([
            'selected' => $prod,
            'events' => $events,
            'output1'=> $output1,
            'output2' =>$output2,
            'output3' =>$output3,
            'output4' =>$output4,
            'output5' => $output5,
            'output6' =>$output6,
            'output7' => $output7,
            'selectedOrder' => $selectedOrder,
            'errors1' => $formErrors1,
            'errors2' => $formErrors2,
            'errors3' => $formErrors3,
            'errors4' => $formErrors4,
            'errors5' => $formErrors5,
            'errors6' => $formErrors6,
            'orders' => $orderlist,
            'items' => $productlist,
            'products' => $productlist,
            'cats'=> $cats
        ]);

    }
}