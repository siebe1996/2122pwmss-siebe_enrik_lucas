<?php

namespace Http;
use SplFileInfo;

use Services\Helper;
use Services\Mailer;



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
        if(isset($_POST['moduleAction1']) && $_POST['moduleAction1'] == 'moduleAction1') {
            $formInfo = $this->procesOrderDetails1();
            if($formInfo['errors']) {
                $tpl = $this->twig->load('orderForm1.twig');
                echo $tpl->render($formInfo);
            }
            else {
                $tpl = $this->twig->load('orderForm2.twig');
                echo $tpl->render($formInfo);
            }
        }
        if(isset($_POST['moduleAction2']) && $_POST['moduleAction2'] == 'moduleAction2') {
            $formInfo2 = $this->procesOrderDetails2();
            if($formInfo2['errors2']) {
                $tpl = $this->twig->load('orderForm2.twig');
                echo $tpl->render($formInfo2);
            }
        }
        else {
            $tpl = $this->twig->load('orderForm1.twig');
            echo $tpl->render();
        }
    }

    public function order1() {
        $formData = unserialize($_COOKIE['formData']);
        var_dump($formData);
        if(isset($_POST['moduleAction1']) && $_POST['moduleAction1'] == 'moduleAction1') {
            $formInfo['customerInfo'] = $this->procesOrderDetails1();
            if($formInfo['customerInfo']['errors']) {
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

    public function order2() {
        $formData = unserialize($_COOKIE['formData']);
        if(!$formData['customerInfo']) {
            header('Location: /order/1');
        }
        if(isset($_POST['moduleAction']) && $_POST['moduleAction'] == 'moduleAction') {
            $choice = $this->procesOrderDetails2();
            if($choice['errors']) {
                $tpl = $this->twig->load('orderForm2.twig');
                echo $tpl->render($choice);
            }
            else {
                if(in_array($choice['selectedItem'],['ijs','ijskar','alcoholijs'])) {
                    if($choice['selectedItem'] == 'ijs') {
                        header('Location: /order/3/ijs');
                    }
                    if($choice['selectedItem'] == 'ijskar') {
                        header('Location: /order/3/ijskar');
                    }
                    if($choice['selectedItem'] == 'alcoholijs') {
                        header('Location: /order/3/alcoholijs');
                    }
                }
                else {
                    header('Location: /order/2');
                }
            }
        }
        else {
            var_dump('zefroihjnzefgohijkuzefghojuizefuioh');
            $tpl = $this->twig->load('orderForm2.twig');
            echo $tpl->render();
        }
    }

    public function getProductsOfCategory($categoryId) : array {
        $stmt = $this->conn->prepare('SELECT * FROM products WHERE categories_id ='. $categoryId);
        $products = $stmt->executeQuery()->fetchAllAssociative();
        return $products;
    }

    public function order3Icecream() {
        $formData = unserialize($_COOKIE['formData']);
        if(!($formData['customerInfo'])) {
            if($formData['customerInfo']) header('Location: /order/2');
            else header('Location: /order/1');
        }
        $products = $this->getProductsOfCategory(1);
        $tpl = $this->twig->load('orderForm3.twig');
        echo $tpl->render([
            'products' => $products
        ]);
        if(isset($_POST['moduleAction']) && $_POST['moduleAction'] == 'moduleAction') {
            $orderedProducts = $this->verifyProduct(1);
            setcookie('orderedProducts',serialize($orderedProducts),0,'/');
            var_dump($_COOKIE['orderedProducts']);
            header('Location: /order/2');
        }
    }

    public function order3Alcohol() {
        var_dump($_COOKIE['formData'] . PHP_EOL . ' sheesh');
        $formData = unserialize($_COOKIE['formData']);
        if(!($formData['customerInfo'])) {
            header('Location: /order/1');
        }
        $products = $this->getProductsOfCategory(2);
        $tpl = $this->twig->load('orderForm3.twig');
        echo $tpl->render([
            'products' => $products
        ]);
        if(isset($_POST['moduleAction']) && $_POST['moduleAction'] == 'moduleAction') {
            $orderedProducts = $this->verifyProduct(1);
            setcookie('orderedProducts',serialize($orderedProducts),0,'/');
            var_dump($_COOKIE['orderedProducts']);
            header('Location: /order/2');
        }
    }

    public function reformProductarray($arr) {
        $name = key($arr);
        $amount = $arr[$name];
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
    public function submitForm($var) {
        $mailer = new Mailer();
        $mailer->send($this->twig->load('mail.twig'),$var);
        header('location: /shop.php');
    }

    public function getPriceOfProduct($product,$amount) {
        $query = 'SELECT price FROM products WHERE name = :name';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name',$product);
        $price = $stmt->executeQuery()->fetchAssociative()['price'];

        echo'eerezrezerzerzer';
        return [
            'each' => $price,
            'total' => round($price * $amount,2)
        ];
    }

    public function verifyProduct($categoryId) : array
    {
        $stmt = $this->conn->prepare('SELECT name FROM products WHERE categories_id =' . $categoryId);
        $productNames = $stmt->executeQuery()->fetchAllAssociative();
        //var_dump($productNames);
        $orderedProducts = [];
        foreach ($productNames as $productName) {
            if ($_POST[$productName['name']]) {
                $orderedProduct = [$productName['name'] => $_POST[$productName['name']]];
                $orderedProducts[] = $orderedProduct;

            }
        }
        var_dump($orderedProducts);
        return $orderedProducts;
    }


    public function procesOrderDetails2() : array {
        $selectedItem = isset($_POST['selectedItem']) ? (string)$_POST['selectedItem'] : '';
        $allowedItems = ['ijs','alcoholijs','ijskar'];
        echo $selectedItem;
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
        $formErrors = [];
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
            'phone' => $phone
        ];
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
        $product_id[] = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $quantity[] = isset($_POST['quantity']) ? $_POST['quantity'] : '';
        $featured = isset($_POST['yes_no']) ? $_POST['yes_no'] : '0';
        $orderid =  isset($_POST['orderid']) ? $_POST['orderid'] : '';
        $toRemove = isset($_POST['productCategorie']) ? $_POST['productCategorie'] : '';
        $selected = isset($_POST['SelectedProduct']) ? $_POST['SelectedProduct'] : '';
        $nameUpdate = isset($_POST['nameUpdate']) ? $_POST['nameUpdate'] : '';
        $delOrderId = isset($_POST['delOrderId']) ? $_POST['delOrderId'] : '';
        $descriptionUpdate = isset($_POST['descriptionUpdate']) ? $_POST['descriptionUpdate'] : '';
        $priceUpdate = isset($_POST['priceUpdate']) ? $_POST['priceUpdate'] : '';
        $stockUpdate = isset($_POST['stockUpdate']) ? $_POST['stockUpdate'] : '';
        $weightUpdate = isset($_POST['weightUpdate']) ? $_POST['weightUpdate'] : '';
        $typeUpdate= isset($_POST['typeUpdate']) ? $_POST['typeUpdate'] : '';
        $categorieUpdate= isset($_POST['categorieUpdate']) ? $_POST['categorieUpdate'] : '';
        $featuredUpdate= isset($_POST['yes_no_update']) ? $_POST['yes_no_update'] : '';
        $idin = isset($_POST['idin']) ? $_POST['idin'] : '';
        $eventid  = isset($_POST['eventid']) ? $_POST['eventid'] : '';

        $eventname = isset($_POST['eventname']) ? $_POST['eventname'] : '';
        $eventdescription = isset($_POST['eventdescription']) ? $_POST['eventdescription'] : '';
        $eventlocation= isset($_POST['eventlocation']) ? $_POST['eventlocation'] : '';
        $sdate = isset($_POST['sdate']) ? $_POST['sdate'] : '';
        $edate= isset($_POST['edate']) ? $_POST['edate'] : '';

        //////////////


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


        $formErrors = [];
        $formErrors1 = [];
        $formErrors2 = [];
        $formErrors3 = [];
        $selectedOrder = [];

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
                $numItems = $this->conn->fetchOne('SELECT id FROM products where name = ?', array($name));

                if (sizeof($formErrors3) == 0){
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

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'insertCategorie')) {

            if(empty(trim($_POST["categorieName"]))) {
                $formErrors1[] = "*Please enter a categorie name.";
            }

            if (sizeof($formErrors1) == 0){
                $stmt = $this->conn->prepare('insert into categories VALUES(?,?)');
                $rowCount = $stmt->executeStatement([null,$categorieName]);

            }
        }

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

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'deleteEvent')) {
            if(empty(trim($_POST["eventid"]))) {
                $formErrors2[] = "*Please enter event id to remove.";
            }

            if (sizeof($formErrors2) == 0){
                $stmt = $this->conn->prepare('DELETE FROM arrangements WHERE id = ?');
                $rowCount = $stmt->executeStatement([$eventid]);

            }
        }

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'DeleteOrder')) {

            if(empty(trim($_POST["delOrderId"]))) {
                $formErrors2[] = "*Please insert an order id to remove.";
            }

            if (sizeof($formErrors2) == 0){
                $stmt = $this->conn->prepare('DELETE FROM order_has_product WHERE order_id = ?');
                $rowCount = $stmt->executeStatement([$delOrderId]);
                $stmt = $this->conn->prepare('DELETE FROM orders WHERE id = ?');
                $rowCount = $stmt->executeStatement([$delOrderId]);
            }
        }



        $output1 = [];
        $output2 = [];
        $output3 = [];
        $output4 = [];
        $output5 = [];
        $output6 = [];
        $output7 = [];


        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'SelectedOrder')) {
             $selectedOrder = $this->conn->fetchAllAssociative('select * FROM order_has_product INNER JOIN products ON order_has_product.product_id = products.id WHERE order_id = ?', array($orderid));
             $output1 = array_slice($selectedOrder, 0, 1);
             $output2 = array_slice($selectedOrder, 1,1);
             $output3 = array_slice($selectedOrder, 2,1);
             $output4 = array_slice($selectedOrder, 3,1);
             $output5 = array_slice($selectedOrder, 4,1);
             $output6 = array_slice($selectedOrder, 5,1);
             $output7 = array_slice($selectedOrder, 6,1);
         }

        if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'EditOrder')) {
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
                $rowCount = $stmt->executeStatement([$quantity4, $productid4 , $order_id4]);
            }

            if(empty(trim($_POST["quantity5"]))) {

             }else{
                $stmt = $this->conn->prepare('UPDATE order_has_product SET quantity = ? WHERE product_id = ? AND order_id = ?');
                $rowCount = $stmt->executeStatement([$quantity5, $productid5 , $order_id5]);
            }
            if(empty(trim($_POST["quantity6"]))) {
             }else{
                $stmt = $this->conn->prepare('UPDATE order_has_product SET quantity = ? WHERE product_id = ? AND order_id = ?');
                $rowCount = $stmt->executeStatement([$quantity6, $productid6 , $order_id6]);
            } if(empty(trim($_POST["quantity7"]))) {
             }else{
                $stmt = $this->conn->prepare('UPDATE order_has_product SET quantity = ? WHERE product_id = ? AND order_id = ?');
                $rowCount = $stmt->executeStatement([$quantity7, $productid7 , $order_id7]);
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
        }
        $events = $this->conn->fetchAllAssociative('SELECT * FROM arrangements');
        $productlist = $this->conn->fetchAllAssociative('SELECT * FROM products');
        $orderlist = $this->conn->fetchAllAssociative('SELECT * FROM orders');
        $cats = $this->conn->fetchAllAssociative('SELECT * FROM categories');
        $tpl = $this->twig->load('admin.twig');
        echo $tpl->render([
            'events' => $events,
           'output1'=> $output1,
        'output2' =>$output2  ,
        'output3' =>$output3 ,
        'output4' =>$output4  ,
        'output5' => $output5 ,
            'output6' =>$output6  ,
            'output7' => $output7 ,
            'selectedOrder' => $selectedOrder,
            'errors' => $formErrors,
            'errors1' => $formErrors1,
            'errors2' => $formErrors2,
            'errors3' => $formErrors3,
            'name' => $name,
            'stock' => $stock,
            'orders' => $orderlist,
            'orderid' => $orderid,
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
