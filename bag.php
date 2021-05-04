<?php
    require_once("connect.php");



   // 修改qty
   if(isset($_POST["ok"])){ 
    foreach ($_POST['mid'] as $key => $mid) {
        $id = $mid;
        $qty = $_POST['qty'][$key];
    
        $sql = "UPDATE `orders` SET qty= $qty WHERE id= $id ; ";
        // echo $sql."<hr>";
        // $query = $db->prepare($sql);
        // $query->execute(array($qty,$id));
        $endcheck = mysqli_query($link, $sql);
        
    }
}   



    // 訂單資訊   
    $orders = <<<sqlCommand

    SELECT o.id,o.pdId,x.pdName,pdColor,qty,size,x.pdType,ROUND(price/2/1.21, 2)*qty as taxFree
    FROM `orders` o
    INNER JOIN `detail` d
    ON d.id = o.pdId
    INNER JOIN `odd` x
    ON x.pdid = d.pdId
    INNER JOIN `size` s
    ON s.sizeId = o.sizeId

    sqlCommand;

    $pdOrders = mysqli_query($link, $orders);
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

    // echo empty($total);

    // if( (isset($total["qty"]) ) == NULL){
    //     echo "NULL";
    // }else{
    //     echo "ok";
    // }


    


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <?= (isset($total["qty"]) == NULL) ? 0 : $total["qty"] ?>
        </div>
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


    <div class="bag-left-item">
        <h6>Your bag</h6><br>
        <a href="./man.php" style="color:black;"><span> &lt; Keep shopping</span></a>
    </div>

    <div class="bag-right-item">
        <?php if( (isset($total["qty"]) ) == NULL): ?>

            <p>Your bag is currently empty</p>

        <?php else: ?>
        <form method="post"  action="">
            
                        
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Color</th>
                        <th scope="col">Size</th>
                        <th scope="col">QTY</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>

                <tbody>
                <?php while($row = mysqli_fetch_assoc($pdOrders)):
                    $name = $row["pdName"];
                    $color = $row["pdColor"];
                    $nameReplace = str_replace(" ","-",$name);
                    $imgName = $nameReplace."-".strtolower($color)."-01.jpg";?>
                    <tr>                           
                        <th>
                            <img src="./_img/<?=$imgName?>" alt="">
                            <?= $row["pdName"]." ".$row["pdColor"]." ["?><?=($row["pdType"]=="w")?"woman":"man"?><?="]"?>
                        </th>
                        
                        <td><?= $row["pdColor"] ?></td>

                        <td><?= $row["size"] ?></td>

                        <td>
                            <input type="hidden" name="mid[]" value="<?= $row["id"] ?>">
                            <select name="qty[]" id="aaa">
                                <option value="1" <?= ($row["qty"] == 1) ? "selected" : "" ?> >1</option>
                                <option value="2" <?= ($row["qty"] == 2) ? "selected" : "" ?> >2</option>
                                <option value="3" <?= ($row["qty"] == 3) ? "selected" : "" ?> >3</option>
                                <option value="4" <?= ($row["qty"] == 4) ? "selected" : "" ?> >4</option>
                                <option value="5" <?= ($row["qty"] == 5) ? "selected" : "" ?> >5</option>
                            </select> &emsp;
                            <a href="./delete.php?id=<?=$row["id"]?>" style="color:black;text-decoration: underline;">Delete</a>
                
                        </td>

                        <td><?= $row["taxFree"] ?></td>   
                    </tr>
                <?php endwhile;?>
                </tbody>
            </table>
            <table class="table">
                <tbody>

                    <tr>
                        <th scope="col">Subtotal</th>
                        <td scope="col"><?= $total["total"] ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Total</th>
                        <td scope="col"><?= $total["total"] ?></td>
                    </tr>

                </tbody>
            </table>
            <input type="checkbox">
            <span>I have a cupon code</span>
            <span>Shipping costs will be calculated once you <br> have provided your address</span>

            <table class="table">
                <tbody>
                    <tr>
                        <th scope="col">Subtotal</th>
                        <th scope="col"><?= $total["total"] ?></th>
                    </tr>
                    <tr>
                        <th scope="row"><b>Total</b></th>
                        <td><b><?= $total["total"] ?></b></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" name="ok" class="btn btn-dark">Submit</button>



        </form>
        <?php endif; ?>

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

</body>

</html>