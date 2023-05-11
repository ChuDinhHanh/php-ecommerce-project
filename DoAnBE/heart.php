<?php
session_start();
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

////////////////////////////////////////////////////////////////////////
/////////////////    Khai báo giá trị mặc định      ////////////////////

$bool_like = false;
$bool_dislike = false;
$idAccount = -1;
if (isset($_SESSION['login']['id_user'])) {
    $idAccount = $_SESSION['login']['id_user'];
}

/////////////////       Kết thúc khai báo           ////////////////////
////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////
/////////////////         Khởi tạo class            ////////////////////

$heartModel = new HeartModel();

/////////////////       Kết thúc khởi tạo           ////////////////////
////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////
/////////////////         Sử lí dữ liệu             ////////////////////

if ($idAccount == -1) {
    header('location:loginregister.php');
} else {
    if (isset($_GET['idPL'])) {
        $idP = $_GET['idPL'];
        $bool_like = $heartModel->like($idAccount, $idP);
        header("location:" . $_SESSION['page']);
    }
    if (isset($_GET['idPDL'])){
        $idP = $_GET['idPDL'];
        $bool_dislike = $heartModel->dislike($idAccount, $idP);
        header("location:" . $_SESSION['page']);
    }
}
/////////////////       Kết thúc sử lí dữ liệu      ////////////////////
////////////////////////////////////////////////////////////////////////