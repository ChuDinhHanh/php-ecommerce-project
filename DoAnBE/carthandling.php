<?php
session_start();
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
////////////////////////////////////////////////////////////////////////
/////////////////    Khai báo giá trị mặc định      ////////////////////
$listCartByIdAcount = null;

$idAccount = -1;
if (isset($_SESSION['login']['id_user'])) {
    $idAccount = $_SESSION['login']['id_user'];
}
/////////////////       Kết thúc khai báo           ////////////////////
////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////
/////////////////         Khởi tạo class            ////////////////////
$cartModel = new CartModel();
/////////////////       Kết thúc khởi tạo           ////////////////////
////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////
/////////////////         Sử lí dữ liệu             ////////////////////

///Lấy toàn bộ cart của người dùng có id chuyền vào là $idAccount
$listCartByIdAcount = $cartModel->getCartByIdUser($idAccount);

///Thêm sản phẩm có $idP vào giỏ hàng của người dùng có $idAccount
if ($idAccount == -1) {
    header('location:loginregister.php');
} else {
    if (isset($_GET['idP'])) {
        $idP = $_GET['idP'];
        $bool_AddToCart = $cartModel->addToCart($idAccount, $idP);
        if ($bool_AddToCart == true) {
            //Thêm thành công
            //Gửi lại trang vừa rồi và cập nhật số lượng trong giỏ hàng
            $countProductInCartByIdAccount = $cartModel->getCountCartByIdAccount($idAccount);
            //Cập nhật số lượng vào session
            $_SESSION['quantityProductByCart'] = $countProductInCartByIdAccount;
            header("location:" . $_SESSION['page']);
        } else {
            //Thêm thất bại do sản phẩm đã tồn tại trong giỏ hàng
            //Gửi lại trang vừa rồi
            header("location:" . $_SESSION['page']);
        }
    }
}
///Kết thúc thêm

///Xóa sản phẩm khỏi giỏ hàng
if ($idAccount == -1) {
    header('location:loginregister.php');
} else {
    if (isset($_GET['idPD'])) {
        $idP = $_GET['idPD'];
        $bool_delete = $cartModel->deleteProductInCart($idAccount, $idP);
        if ($bool_delete == true) {
            //Xóa thành công
            //Gửi lại trang vừa rồi và cập nhật số lượng trong giỏ hàng
            $countProductInCartByIdAccount = $cartModel->getCountCartByIdAccount($idAccount);
            //Cập nhật số lượng vào session
            $_SESSION['quantityProductByCart'] = $countProductInCartByIdAccount;
            header("location:" . $_SESSION['page']);
        } else {
            //Thêm thất bại do sản phẩm đã tồn tại trong giỏ hàng
            //Gửi lại trang vừa rồi
            header("location:" . $_SESSION['page']);
        }
    }
}
///Kết thúc xóa

///Thay đổi số lượng sản phẩm

if ($idAccount == -1) {
    header('location:loginregister.php');
} else {
    if (isset($_POST['idPA'])) {
        $idP = $_POST['idPA'];
        $quantity = $_POST["qty$idP"];
        if (isset($_POST["btn-tru$idP"])){   
            $quantity--; 
        }
        if (isset($_POST["btn-cong$idP"])){  
            $quantity++; 
        }
        if ($quantity == 0) {
            $bool_delete = $cartModel->deleteProductInCart($idAccount, $idP);
        if ($bool_delete == true) {
            //Xóa thành công
            //Gửi lại trang vừa rồi và cập nhật số lượng trong giỏ hàng
            $countProductInCartByIdAccount = $cartModel->getCountCartByIdAccount($idAccount);
            //Cập nhật số lượng vào session
            $_SESSION['quantityProductByCart'] = $countProductInCartByIdAccount;
            header("location:" . $_SESSION['page']);
        } else {
            //Thêm thất bại do sản phẩm đã tồn tại trong giỏ hàng
            //Gửi lại trang vừa rồi
            header("location:" . $_SESSION['page']);
        }
        }
        $bool_updateQty = $cartModel->updateQuantityInCartByAccount($idAccount, $idP+0, $quantity);
        if ($bool_updateQty == true) {
            header("location:" . $_SESSION['page']);
        }
        else{
            header("location:" . $_SESSION['page']);
        }
    }
}
///Kết thúc thay đổi số lượng sản phẩm


/////////////////       Kết thúc sử lí dữ liệu      ////////////////////
////////////////////////////////////////////////////////////////////////
