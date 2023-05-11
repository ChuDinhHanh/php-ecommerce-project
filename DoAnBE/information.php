<?php
session_start();
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
////////////////////////////////////////////////////////////////////////
/////////////////    Khai báo giá trị mặc định      ////////////////////

$viewInformation = null;
$bool_update = false;
$_SESSION['page'] = "information.php";

/////////////////       Kết thúc khai báo           ////////////////////
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
/////////////////         Khởi tạo class            ////////////////////
$informationModel = new InformationModel();

/////////////////       Kết thúc khởi tạo           ////////////////////
////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////
/////////////////         Sử lí dữ liệu             ////////////////////

//lấy thông tin của account theo id
if (isset($_SESSION['login']['id_user'])) {
    $viewInformation = $informationModel->getInformationByIdAccount($_SESSION['login']['id_user']);
}
//chỉnh sửa thông tin cá nhân
if ($viewInformation != null) {
    if (isset($_SESSION['login']['id_user'])) {
        if (isset($_POST['idA']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['phone'])) {
            $bool_update = $informationModel->updateInformationByIdAccount($_SESSION['login']['id_user'], $_POST['name'], $_POST['address'], $_POST['phone'],);
            if ($bool_update == true){
                echo '<script> alert("Successful update");</script>';
            }
            else{
                echo '<script> alert("Update failed");</script>';
            }
        }
        $viewInformation = $informationModel->getInformationByIdAccount($_SESSION['login']['id_user']);
    }
} else{
    if (isset($_SESSION['login']['id_user'])) {
        if (isset($_POST['idA']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['phone'])) {
            $bool_insert = $informationModel->insertInformationByIdAccount($_SESSION['login']['id_user'], $_POST['name'], $_POST['address'], $_POST['phone'],);
            if ($bool_insert == true){
                echo '<script> alert("Successful update");</script>';
            }
            else{
                echo '<script> alert("Update failed");</script>';
            }
        }
        $viewInformation = $informationModel->getInformationByIdAccount($_SESSION['login']['id_user']);
    }
}
/////////////////       Kết thúc sử lí dữ liệu      ////////////////////
////////////////////////////////////////////////////////////////////////


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Header Section Begin -->
    <?php include 'header.php'; ?>
    <!-- Header Section End -->

    <div class="conntainer">
        <form action="information.php" method="post">
            <div class="container">
                <?php if (isset($_SESSION['login']['id_user'])) { ?>
                    <input type="hidden" name="idA" value="<?php echo $_SESSION['login']['id_user'] ?>" />
                <?php } ?>
                <div class="checkout__input">
                    <p>Name<span>*</span></p>
                    <input type="text" placeholder="Enter Name" name="name" value="<?php if ($viewInformation != null) {
                                                                                        echo $viewInformation['name'];
                                                                                    } ?>">
                </div>
                <div class="checkout__input">
                    <p>Address<span>*</span></p>
                    <input type="text" placeholder="Enter Address" name="address" value="<?php if ($viewInformation != null) {
                                                                                                echo $viewInformation['addres'];
                                                                                            } ?>">
                </div>
                <div class="checkout__input">
                    <p>Phone<span>*</span></p>
                    <input type="text" placeholder="Enter your phone number" name="phone" value="<?php if ($viewInformation != null) {
                                                                                                        echo $viewInformation['phone_number'];
                                                                                                    } ?>">
                </div>
                <button type="submit" class="site-btn">Update</button>
            </div>
        </form>
    </div>


    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>