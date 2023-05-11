<?php
session_start();
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
var_dump("vao");
$productModel = new ProductModel();
if (!empty($_POST['id'])  && !empty($_POST['imageOld'])) {
    var_dump("vao-1");
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['sale']) && isset($_POST['description']) && isset($_POST['company']) && isset($_POST['category']) && isset($_POST['status'])) {
        var_dump("vao1");
        $nameImg = $_POST['imageOld'];
        if (!empty($_FILES['image']['name'])){
            $upload = move_uploaded_file($_FILES['image']['tmp_name'], 'img/product/' . $_FILES['image']['name']);
            $nameImg = $_FILES['image']['name'];
        }
        $bool=  $productModel->updateProduct($_POST['id'],$_POST['name'], $_POST['price'], $_POST['sale'], $_POST['description'], $nameImg, $_POST['company'], $_POST['category'], $_POST['status']);
        header('location:index_admin.php');
    }
} else {
    var_dump("vao-2");
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['sale']) && isset($_POST['description']) && isset($_POST['company']) && isset($_POST['category']) && isset($_POST['status'])) {
        var_dump("vao2");

        $img = $_FILES['image'];
        $nameImg = $img['name'];
        $upload = move_uploaded_file($img['tmp_name'], 'img/product/' . $img['name']);
        $productModel->createProduct($_POST['name'], $_POST['price'], $_POST['sale'], $_POST['description'], $nameImg, $_POST['company'], $_POST['category'], $_POST['status']);
        header('location:index_admin.php');
    }
}