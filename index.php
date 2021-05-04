<?php
require_once("connect.php");

// 訂單資訊   
$orders = <<<sqlCommand

SELECT o.pdId,x.pdName,pdColor,size,x.pdType,price,ROUND(price/2/1.21, 2)as taxFree
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
    <title>Home | ETQ Amsterdam</title>
    <link rel="icon" href="./_img/icon.png" type="png">

    <script src="https://kit.fontawesome.com/4c603a83a6.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="./_css/bootstrap.min.css">
    <script src="./_js/modernizr-custom.js"></script>
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

    <div class="white-bg-change"></div>

    <!-- navbar-collapse.// -->

    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
        <!-- <ol class="carousel-indicators"> -->
        <!-- <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li> -->
        <!-- <li data-target="#carouselExampleIndicators" data-slide-to="1"></li> -->
        <!-- <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> -->
        <!-- </ol> -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="" class="d-block w-100" id="imgbigger" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./_img/david-lezcano-NfZiOJzZgcg-unsplash.jpg " class="d-block w-100" alt="...">
                <div class="carousel-caption  mb-5 ">
                    <h5 style="font-size: 21px;font-weight:normal">Get the most out of your product</h5>
                    <h6 style="font-size: 28px;font-weight:lighter">Explore our shoe care solutions</h6>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./_img/josh-applegate-bAf3r92aewQ-unsplash.jpg " class="d-block w-100" alt="...">
                <div class="carousel-caption  mb-5 ">
                    <h5 style="font-size: 21px;font-weight:normal;color: black">Harmless yet effective</h5>
                    <h6 style="font-size: 28px;font-weight:lighter;color: black;">Standing by our product’s quality and design
                    </h6>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- carouselExampleCaptions-collapse.// -->



    <div class="index-contentDiv1 ">
        <div class="card">
            <img class="card-img-top " src="./_img/irene-kredenets-KStSiM1UvPw-unsplash.jpg " alt="Card image cap ">
            <div class="card-body ">
                <h5 class="card-title ">2010 - 2020</h5>
                <p class="card-text ">Our journey explained</p>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top " src="./_img/spencer-davis-9zoQLRTqEvI-unsplash.jpg " alt="Card image cap ">
            <div class="card-body ">
                <h5 class="card-title ">How it's made</h5>
                <p class="card-text ">Sneaker made like shoes</p>

            </div>
        </div>
        <div class="card ">
            <img class="card-img-top " src="./_img/irene-kredenets-KYGxmu7i1Rc-unsplash.jpg " alt="Card image cap ">
            <div class="card-body ">
                <h5 class="card-title ">Shoecare</h5>
                <p class="card-text ">Get the most out of your sneakers</p>

            </div>
        </div>

    </div>

    <div class="index-contentDiv2 ">
        <div class="card">
            <img class="card-img-top " src="./_img/gabriel-benois-hzBjCbryk0g-unsplash.jpg " alt="Card image cap ">
            <div class="card-body ">
                <h5 class="card-title ">ETQ Laundry Store</h5>
                <p class="card-text ">Let us clean your shoes</p>

            </div>
        </div>
        <div class="card">
            <img class="card-img-top " src="./_img/christian-koch-mQ4Ty8VmnPk-unsplash.jpg " alt="Card image cap ">
            <div class="card-body ">
                <h5 class="card-title ">Amsterdam Flagship Store</h5>
                <p class="card-text ">Find us at Singel 465</p>

            </div>
        </div>
    </div>

    <div class="footerDiv ">
        <div class="row ">
            <div class="col-4 ">
                <h5>About</h5>
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