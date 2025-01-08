<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Trang Chủ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script>new WOW().init();</script>
</head>
<body>
<?php include('includes/header.php'); ?>

<div class="banner">
    <div class="container">
        <h1 class="wow zoomIn animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">
            Dịch vụ sửa chữa nhà cửa
        </h1>
    </div>
</div>

<div class="container">
    <div class="search-results">
        <?php
        $searchKeyword = isset($_GET['query']) ? trim($_GET['query']) : ''; // Lấy từ khóa tìm kiếm từ người dùng

        if (!empty($searchKeyword)) {
            // Nếu có từ khóa, tìm kiếm theo từ khóa
            $sql = "SELECT * FROM tbltourpackages WHERE PackageName LIKE :keyword ORDER BY rand()";
            $query = $dbh->prepare($sql);
            $query->bindValue(':keyword', '%' . $searchKeyword . '%', PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            // Nếu không có từ khóa, hiển thị tất cả
            $sql = "SELECT * FROM tbltourpackages ORDER BY rand()";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
        }

        if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
                <div class="rom-btm">
                    <div class="col-md-3 room-left wow fadeInLeft animated" data-wow-delay=".5s">
                        <img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage); ?>" class="img-responsive" alt="">
                    </div>
                    <div class="col-md-6 room-midle wow fadeInUp animated" data-wow-delay=".5s">
                        <h4>Tên gói: <?php echo htmlentities($result->PackageName); ?></h4>
                       
                    </div>
                    <div class="col-md-3 room-right wow fadeInRight animated" data-wow-delay=".5s">
                        <h5><?php echo htmlentities($result->PackagePrice); ?> VND</h5>
                        <a href="package-details.php?pkgid=<?php echo htmlentities($result->PackageId); ?>" class="view">Chi tiết</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php
            }
        } else {
            echo "<p>Không tìm thấy dịch vụ nào phù hợp.</p>";
        }
        ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
<!-- Đăng ký -->
<?php include('includes/signup.php'); ?>
<!-- Đăng nhập -->
<?php include('includes/signin.php'); ?>
<!-- Liên hệ -->
<?php include('includes/write-us.php'); ?>
</body>
</html>
