<?php
require_once("connect.php");

$did = $_GET["did"];
$pid = $_GET["pid"];
// var_dump($id);
// var_dump($pid);

// 取出商品尺碼
$sizeSql = <<<sqlStatement
    SELECT s.sizeId,o.pdId, pdName, price, pdColor,o.pdType, s.size
    FROM `odd` o
    INNER JOIN `detail` d
    ON d.pdId = o.pdId
    INNER JOIN `size` s
    ON s.pdType = o.pdType
    WHERE d.id = $did 
sqlStatement;
$allSize = mysqli_query($link, $sizeSql);


// 取出被選顏色&內容等單一選項
$chooseSql = <<<sqlStatement
    SELECT d.id,pdName,pdColor,content ,price ,ROUND(price/2, 2) as EUPrice ,ROUND(price/2/1.21, 2) as taxFree
    FROM `detail` d 
    JOIN `odd` o ON d.pdId = o.pdId
    WHERE d.id= $did 
sqlStatement;
$choose = mysqli_query($link, $chooseSql);
$row = mysqli_fetch_assoc($choose);
// echo $row["id"];

$pic=$row["id"];
// 取出商品照片
$picture = <<<sqlStatement
    SELECT d.id,img
    FROM `images` i
    JOIN `detail` d ON d.id = i.mid
    WHERE d.id= $pic
sqlStatement;
// echo $picture;
$allImg = mysqli_query($link, $picture);



// 取出顏色碼
$colorSql = <<<sqlStatement
    SELECT d.id,d.pdId,pdName,price,pdColor
    FROM `detail` d 
    JOIN `odd` o ON d.pdId = o.pdId
    WHERE d.pdId = $pid
sqlStatement;
$allColor = mysqli_query($link, $colorSql);


// 送出訂單    
if (isset($_POST["okButton"])) {

    $apple = <<<sqlCommand
    insert into orders (pdId,sizeId)
    values ('{$_POST["color"]}','{$_POST["pdSize"]}');
   sqlCommand;
//    echo $apple;
   mysqli_query($link, $apple);
//    header("Location: product_page.php");
//    exit();
}

// 訂單資訊   
$orders = <<<sqlCommand

SELECT o.id,o.pdId,x.pdName,pdColor,o.sizeId,size,x.pdType,ROUND(price/2/1.21, 2)as taxFree
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
    <title>LT 01 Blueberry | ETQ Amsterdam</title>
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
        <form action="" class="shopNumberTable" id="shopNumberTable" >

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

    <nav class="smart-scroll" id="smart-scroll">
        <div>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
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

    <div class="productDiv container-fluid">
        <div class="row">
            <div class="col-8">
                <div>
                    <img src="./_img/<?=str_replace(" ","-",$row["pdName"])."-".$row["pdColor"]."-01.jpg"?>" alt="">
                    <?php while($img= mysqli_fetch_assoc($allImg)): ?>
                    <img src="./_img/<?=$img["img"]?>.jpg" alt="">
                    <?php endwhile;?>
                    <!-- <img src="./_img/christian-koch-mQ4Ty8VmnPk-unsplash.jpg" alt=""> -->
                </div>

            </div>
            <!--col-8-collapse.// -->
            <!--col-8-collapse.// -->
            <!--col-8-collapse.// -->





            <div class="col-4">
                <!-- Product-condent -->
                <h3><?= $row["pdName"]." ".$row["pdColor"] ?></h3>
                <span style="color:gray;text-decoration: line-through;font-weight: 500;"><?="&euro;".$row["price"]?> </span>&nbsp;<span style="color: indianred;font-weight: 500;"><?="&euro;".$row["taxFree"]?> (-50%)</span>
                <br>
                <span>EU price <?="&euro;".$row["EUPrice"]?>. Tax free (21%) outside EU.</span>
                <br>
                <span><?=$row["content"]?></span>
                <p>More information</p>

                <!-- button-menu -->
                <!-- Default dropup button -->
                <form method="post" action="" >
                    <div class="input-group mb-3">
                        <!-- <div class="input-group-prepend"> -->
                        <!-- <label class="input-group-text" for="inputGroupSelect01">Options</label> -->
                        <!-- </div> -->
                        <select name="color" class="custom-select" id="inputGroupSelect01">
                            <!-- <option selected>EU 36</option> -->
                            <?php while ( $color = mysqli_fetch_assoc($allColor)) :?>
                            <option  value="<?= $color["id"] ?>" <?= ( $color["id"] == $row["id"]) ? "selected" : "" ?> ><?= $color["pdColor"] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <!-- <div class="input-group-prepend"> -->
                        <!-- <label class="input-group-text" for="inputGroupSelect01">Options</label> -->
                        <!-- </div> -->
                        <select name="pdSize" class="custom-select" id="inputGroupSelect01">
                        
                            <?php while ( $size = mysqli_fetch_assoc($allSize)) :?>
                            <option value="<?= $size["sizeId"] ?>"><?= $size["size"] ?></option>
                            <?php endwhile; ?>

                        </select>
                    </div>


                    <button type="submit" name="okButton" class="btn btn-dark" onclick="addBag()">Add to bag</button>
                </form>
                <!-- <iframe id="id_iframe" name="nm_iframe" style="display:none;"></iframe> -->
                <!-- table -->
                <table>
                    <tr>
                        <td><i class="fas fa-check" style='font-size:10px'></i></td>
                        <td> Order before 22:00 to receive between 25th - 1st February.</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-check" style='font-size:10px'></i></td>
                        <td> Pay with iDeal, Apple Pay, Mastercard, Visa, PayPal, Klarna</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-check" style='font-size:10px'></i></td>
                        <td> Worldwide shipping</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-check" style='font-size:10px'></i></td>
                        <td> Replenishment service: free new laces</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-check" style='font-size:10px'></i></td>
                        <td> Orders can be returned within 14 days</td>
                    </tr>
                </table>


            </div>
            <!--col-4-collapse.// -->
            <!--col-4-collapse.// -->
            <!--col-4-collapse.// -->


        </div>
    </div>


    <!-- <br> -->



    <div class="footerDiv">
        <div class="row ">
            <div class="col-4">
                <h6>About</h6>
                <span>Founded in 2010 in Amsterdam, ETQ derived under the mindset of eliminating over-accessorized
                    branding
                    and focusing primarily on letting the quality of the product speak for itself.</span>
            </div>
            <div class="col-2">
                <h6>Address</h6>
                <span> Singel 465</span><br><span>1012 WP Amsterdam</span><br><span>The Netherlands</span><br>
            </div>
            <div class="col-2">
                <h6>Contact</h6>
                <p>Email us</p>
                <p>+31 (0) 202 615 614</p>
            </div>
            <div class="col-2">
                <h6>Info</h6>
                <p>Shipping info</p><br>
                <p>Careers</p><br>
                <p>Wholesale</p>
            </div>
            <div class="col-2">
                <h6>Follow us</h6>
                <p>Instagram</p><br>
                <p>Facebook</p>
            </div>
        </div>
    </div>
    <!--footerDiv-collapse.// -->


    <script>
    </script>

</body>

</html>