<?php
session_start();
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
////////////////////////////////////////////////'////////////////////////
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

$productModel = new ProductModel();
$billModel = new BillModel();
//contact information
$contact = new ContactModel();


/////////////////       Kết thúc khởi tạo           ////////////////////
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
/////////////////         Sử lí dữ liệu             ////////////////////

//header and footer
$in4Contact = $contact->getAllContact();
//check out
if ($idAccount == -1) {
    header('location:404.php');
}
$listBillByAccount = $billModel->getAllBillByIdAccount($idAccount);


/////////////////       Kết thúc sử lí dữ liệu      ////////////////////
////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/stylebill.css" type="text/css">
    <style>
        .header {
            background: #fff;
        }
    </style>
</head>

<body>
    <?php include "header.php" ?>
    <?php if ($listBillByAccount != null) { ?>


        <?php foreach ($listBillByAccount as $bill) { ?>
            <div class="container">
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="invoice-container">
                                    <div class="invoice-header">



                                        <!-- Row start -->
                                        <div class="row gutters">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <a href="index.php" class="invoice-logo">
                                                    <img src="img/logo.png" alt="">
                                                </a>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <address class="text-right">
                                                    <?php echo $in4Contact['addres'] ?>
                                                </address>
                                            </div>
                                        </div>
                                        <!-- Row end -->

                                        <!-- Row start -->
                                        <div class="row gutters">
                                            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                                <div class="invoice-details">
                                                    <address>
                                                        <?php echo $bill['receive_name'] ?><br>
                                                        <?php echo $bill['receive_address'] ?>
                                                    </address>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                                <div class="invoice-details">
                                                    <div class="invoice-num">
                                                        <div>Invoice - #<?php echo $bill['id'] ?></div>
                                                        <div><?php echo $bill['order_date'] ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Row end -->

                                    </div>

                                    <div class="invoice-body">

                                        <!-- Row start -->
                                        <div class="row gutters">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table custom-table m-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Items</th>
                                                                <th>Product ID</th>
                                                                <th>Quantity</th>
                                                                <th>Sub Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $tong = 0; ?>
                                                            <?php foreach ($billModel->getItemInBillByIdBill($bill['id']) as $item) {
                                                                $tong += $productModel->getProductById($item['id_sp'])['price'] * $item['qty'];
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $productModel->getProductById($item['id_sp'])['name'] ?>
                                                                        <p class="m-0 text-muted">
                                                                            <?php echo $productModel->getProductById($item['id_sp'])['description'] ?>
                                                                        </p>
                                                                    </td>
                                                                    <td>#<?php echo $item['id_sp'] ?></td>
                                                                    <td><?php echo $item['qty'] ?></td>
                                                                    <td>$<?php echo ($productModel->getProductById($item['id_sp'])['price'] * $item['qty']) ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="2">
                                                                    <p>
                                                                        Subtotal<br>
                                                                    </p>
                                                                    <h5 class="text-success"><strong>Grand Total</strong></h5>
                                                                </td>
                                                                <td>
                                                                    <p>
                                                                        $<?php echo $tong ?><br>
                                                                    </p>
                                                                    <h5 class="text-success"><strong>$<?php echo $tong ?></strong></h5>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Row end -->

                                    </div>

                                    <div class="invoice-footer">
                                        Thank you for your Business.
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else {
        ?>
        <div style="padding-top: 100px; padding-bottom: 100px; text-align: center;"><h1 style="color:red;">No bills</h1></div>
        <?php
    }?>
    <?php include "footer.php" ?>
</body>

</html>