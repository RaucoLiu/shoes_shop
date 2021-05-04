<?php
$link = mysqli_connect("localhost","root","","shoes")or die(mysqli_connect_error());
$result = mysqli_query($link,"set names utf8");
// var_dump($link);

$sql = <<<sqlStatement
    SELECT d.id, o.pdId, pdName, price, pdColor FROM `detail`d JOIN `odd`o
    on d.pdId = o.pdId
sqlStatement;

$result = mysqli_query($link, $sql);

$orders = <<<sqlCommand

SELECT o.pdId,x.pdName,pdColor,size,x.pdType,ROUND(price/2/1.21, 2)as taxFree
FROM `orders` o
INNER JOIN `detail` d
 ON d.id = o.pdId
INNER JOIN `odd` x
 ON x.pdid = d.pdId
INNER JOIN `size` s
 ON s.sizeId = o.sizeId

sqlCommand;
$pdOrders2 = mysqli_query($link, $orders);

// 總價跟qty 
$sum = <<<sqlCommand
SELECT SUM(qty)as qty,SUM(ROUND(price/2/1.21, 2)*qty) as total
FROM `orders` o
INNER JOIN `detail` d
 ON d.id = o.pdId
INNER JOIN `odd` x
 ON x.pdid = d.pdId
sqlCommand;

$subTotal = mysqli_query($link, $sum);
$total = mysqli_fetch_assoc($subTotal);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All footwear | ETQ Amsterdam</title>
    <link rel="icon" href="./_img/icon.png" type="png">

    <script src="https://kit.fontawesome.com/4c603a83a6.js" crossorigin="anonymous"></script>
    <script src="./_js/modernizr-custom.js"></script>

    <link rel="stylesheet" href="./_css/bootstrap.min.css">
    <script src="./_js/jquery.min.js"></script>
    <script src="./_js/popper.min.js"></script>
    <script src="./_js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./_css/demo.css">

    <style>

    </style>
</head>

<body>

    <script src="./_js/demo.js" defer></script>

    <div class="shopNumber_dropdown">
        <!-- 到時候要創建PHP的地方 -->
        <div class="shopNumber" onClick="shopDropdown()" style="cursor: pointer">
        <?= (isset($total["qty"]) == NULL) ? 0 : $total["qty"]  ?></div>
        <form action="" class="shopNumberTable" id="shopNumberTable">

        <table class="table">
                <tbody>
                <?php if( (isset($total["qty"]) ) == NULL): ?>
                    <tr>
                        <th scope="col">Your bag is currently empty</th>
                    </tr>
                <?php else: ?>
                    <?php while($apple = mysqli_fetch_assoc($pdOrders2)): ?>
                    <tr>
                        <th scope="col">
                        <?= $apple["pdName"]." ".$apple["pdColor"]." [" ?>
                        <?=($apple["pdType"]=="w")?"woman":"man"?>
                        <?= "]"?><br>
                        <?= $apple["pdColor"] ?><br>
                        <?= $apple["size"] ?>
                        </th>
                        <td scope="col"><?="&euro;".$apple["taxFree"]?></td>
                    </tr>
                    <?php endwhile;?>
                    <tr>
                        <th scope="col">Shopping:</th>
                        <td scope="col">Free</td>
                    </tr>
                    <tr>
                        <th scope="col">Subtotal:</th>
                        <td scope="col"><?="&euro;".$total["total"] ?></td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
            <p><a href="./bag.php" target="_top">View bag</a></p>
            <button class="btn btn-dark">Check0ut</button>

        </form>
    </div>
    <!-- shopNumber_dropdown-collapse.// -->

    <div class="darkDiv" onClick="BGdark()"></div>
    <!-- darkDiv-collapse.// -->

    <nav class="smart-scroll-2" id="smart-scroll-2">
        <div>
            <a href="javascript:void(0);" class="icon" onclick="myFunction2()">
                <i class="fas fa-bars"></i>
            </a>
            <h2><a href="./index.php"> E.T.Q</a></h2>
        </div>
        <div>
            <p>Sale</p>
            <p><a href="./man.php" target="_top">Men</a></p>
            <p>Women</p>
            <p>Shoe care</p>
        </div>
    </nav>
    <!-- navbar-collapse.// -->

    <div class="white-bg-change"></div>

    <div class="buttonDiv">
        <button class="bigger">
            <i class="fa fa-th-large" style='font-size:10px'></i>
        </button>
        <button class="smaller">
            <i class="fa fa-th" style='font-size:10px'></i>
        </button>
    </div>

    <div class="shoes_head">
        <div class="card-deck">

        <?php while ( $row = mysqli_fetch_assoc($result) ) : 
                // echo gettype($row) ; 
                // $row = array;
                $name = $row["pdName"];
                $color = $row["pdColor"];
                $nameReplace = str_replace(" ","-",$name);
                $imgName = $nameReplace."-".strtolower($color)."-01.jpg";
                // echo $row['pdId'] ;?>
        
        <div class="card shoes-card">
            <a href="./product_page.php?pid=<?= $row['pdId']?>&did=<?= $row['id']?>"><img class="card-img-top" src="./_img/<?=$imgName?>" alt=""></a>
            <h5 class="card-title"><?= $name." ".$color ?></h5>
            <span class="card-text"><?= "&euro;".$row["price"] ?></span>
        </div>
        
        <?php endwhile; ?>

        </div>
    </div>

    <div class="footerDiv ">
        <div class="row ">
            <div class="col-4 ">
                <h6>About</h6>
                <span>Founded in 2010 in Amsterdam, ETQ derived under the mindset of eliminating over-accessorized
                    branding
                    and focusing primarily on letting the quality of the product speak for itself.</span>
            </div>
            <div class="col-2 ">
                <h6>Address</h6>
                <span> Singel 465</span><br><span>1012 WP Amsterdam</span><br><span>The Netherlands</span><br>
            </div>
            <div class="col-2 ">
                <h6>Contact</h6>
                <p>Email us</p>
                <p>+31 (0) 202 615 614</p>
            </div>
            <div class="col-2 ">
                <h6>Info</h6>
                <p>Shipping info</p><br>
                <p>Careers</p><br>
                <p>Wholesale</p>
            </div>
            <div class="col-2 ">
                <h6>Follow us</h6>
                <p>Instagram</p><br>
                <p>Facebook</p>
            </div>
        </div>

    </div>





    <script>
    </script>
</body>

</html>