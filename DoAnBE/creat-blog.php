<?php
session_start();
if (!isset($_SESSION['category_now'])) $_SESSION['category_now'] = 0;
require_once './config/database.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
$title;
$content;
$category;
$img;

// if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['category']) && isset($_POST['img'])){
// var_dump(123);
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //cac truong hop sai.
    $error = [];
    $title = $_POST['title_crik'];
    $content = $_POST['content_crik'];
    $category = $_POST['category'];
    //xu ly hinh anh
    $img = $_FILES['img'];
    //size gioi han
    $size_alow = 10; //10 mb
    //thuc hien doi ten truoc khi upload
    $file_name = $img['name'];
    $file_name = explode('.', $file_name);
    $ext = end($file_name);
    $new_file = md5(uniqid()) . '.' . $ext;
    //thuc hien kiem tra dinh dang file
    $allow_ext = ['png', 'jpg', 'jpeg', 'gif', 'ppt', 'zip', 'pptx', 'docx', 'xls', 'xlsx'];
    if (in_array($ext, $allow_ext)) {
        //phu hop dieu kien duoi
        $size = $img['size'] / 1024 / 1024; //doi tu byte sang MB
        if ($size <= $size_alow) {
            //phu hop dieu kien size
            $upload = move_uploaded_file($img['tmp_name'], 'img/blog/' . $new_file);
            if (!$upload) {
                $error[] = 'upload_error';
            }
        } else {
            $error[] = 'size_err';
        }
    } else {
        $error[] = 'ext_err';
    }

    if (empty($error)) {
        $blog = new BlogModel();
        $result =  $blog->createBlog(1, $title, $content, $category, $new_file);
        if ($result) {
?>
            <script>
                alert('Upload success');
            </script>
        <?php
        } else {
        ?>
            <script>
                alert('du lieu ban nhap da qua gioi han');
            </script>
            <?php
        }
    } else {
        foreach ($error as $value) {
            if ($value == 'ext_err') {
            ?>
                <script>
                    alert('sai loai file');
                </script>
            <?php
            } else if ($value == 'size_err') {
            ?>
                <script>
                    alert('kich thuoc vuot qua 10 MB');
                </script>
            <?php
            } else {
            ?>
                <script>
                    alert('khong the upload ngay bay gio');
                </script>
<?php
            }
        }
    }
}



//get all category
$category = new CategoryModel();
$categoryList = $category->getAllCategory();


//contact information
$contact = new ContactModel();
$in4Contact = $contact->getAllContact();
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
            <form action="creat-blog.php" role="form" data-toggle="validator" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Title</label>
                    <!-- <input name="title" type="text" class="form-control" data-error="You must have a name." id="inputName" placeholder="Name" required> -->
                    <textarea name="title_crik">
                      </textarea>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label>Content (<span style="color: red;">warning do not insert img</span>)</label>
                    <textarea name="content_crik">
                      </textarea>
                    <!-- Error -->
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label>Category:</label>
                    <div class="options">
                        <select name="category">
                            <?php
                            foreach ($categoryList as $value) {
                            ?>
                                <option name="category" value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="container">
                    <label for="input-img" class="preview" style="width: 100%; height: 300px;background-color: #2ae281;border-radius: 10px;">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Upload to preview image</span>
                    </label>
                    <input name="img" type="file" hidden id="input-img" />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace('content_crik');
    CKEDITOR.replace('title_crik');
</script>
</body>

</html>