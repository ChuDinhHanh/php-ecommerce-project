<?php
session_start();
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

//get all company
$companyModel = new CompanyModel();
$listCompany = $companyModel->getAllCompany();

//get all category
$category = new CategoryModel();
$categoryList = $category->getAllCategory();


//contact information
$contact = new ContactModel();
$in4Contact = $contact->getAllContact();
$product = null;
$productModel = new ProductModel();
if (!empty($_GET["idPU"])) {
    $product = $productModel->getProductById($_GET["idPU"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
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
    <link rel="stylesheet" href="css/creat-blog.css" type="text/css">
</head>
<?php
include 'header.php';
?>

<body>

</html>
<div class="container mt-5">
    <div class="card">
        <h5 class="card-header text-center">CREATE YOUR BLOG</h5>
        <div class="card-body">
            <form action="upload-product.php" role="form" data-toggle="validator" method="POST" enctype="multipart/form-data">

                <?php if (!empty($_GET["idPU"])) { ?>
                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                    <input type="hidden" name="imageOld" value="<?php echo $product['image'] ?>">
                <?php } ?>

                <div class="form-group">
                    <label>Title</label>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" <?php if (!empty($_GET["idPU"])) { ?> value="<?php echo $product["name"] ?>" <?php } ?> placeholder="Enter name">
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price" <?php if (!empty($_GET["idPU"])) { ?> value="<?php echo $product["price"] ?>" <?php } ?> placeholder="Enter price">
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <div class="mb-3">
                        <label for="sale-off" class="form-label">Sale off</label>
                        <input type="text" class="form-control" id="sale-off" name="sale" <?php if (!empty($_GET["idPU"])) { ?> value="<?php echo $product["sale_off"] ?>" <?php } ?> placeholder="Enter sale off">
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" <?php if (!empty($_GET["idPU"])) { ?> value="<?php echo $product["description"] ?>" <?php } ?> placeholder="Enter description">
                    </div>
                    <div class="help-block with-errors"></div>
                </div>


                <div class="form-group">
                    <label>Company:</label>
                    <div class="options">
                        <select name="company">
                            <?php
                            foreach ($listCompany as $item) {
                            ?>
                                <option <?php if (!empty($_GET["idPU"])) { ?> <?php if ($product['id_company'] == $item['id']) { ?>selected<?php } ?> <?php } ?> value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Category:</label>
                    <div class="options">
                        <select name="category">
                            <?php
                            foreach ($categoryList as $value) {
                            ?>
                                <option <?php if (!empty($_GET["idPU"])) { ?> <?php if ($product['id_category'] == $value['id']) { ?>selected<?php } ?> <?php } ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status:</label>
                    <div class="options">
                        <select name="status">
                            <option <?php if (!empty($_GET["idPU"])) { ?> <?php if ($product['status'] == 0) { ?>selected<?php } ?> <?php } ?> value="0">Stop selling</option>
                            <option <?php if (!empty($_GET["idPU"])) { ?> <?php if ($product['status'] == 1) { ?>selected<?php } ?> <?php } ?> value="1">Still for sale</option>

                        </select>
                    </div>
                </div>

                <div class="container">
                    <label for="input-img" class="preview" style="width: 100%; height: 300px;background-color: #2ae281;border-radius: 10px;">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Upload to preview image</span>
                    </label>
                    <input name="image" type="file" hidden id="input-img" />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>

</html>