<?php
include_once('./lib/connect.php');
require_once('./lib/database.php');
require_once('./lib/session.php');
session_start();

$sql = 'SELECT * FROM shoes';
$result = db_get_list($sql);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    // Them
    if ($action == "add") {
        $sl = 1;
        $query = "SELECT * FROM shoes WHERE id=" . $id;
        $product = db_get_row($query);
        $flag = false;
        if (isset($_SESSION['cart'])) {
            print_r($_SESSION['cart']);
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($key == $id) {
                    $_SESSION['cart'][$id]['soluong'] = $_SESSION['cart'][$id]['soluong'] +  1;
                    $flag = true;
                }
            }
            if ($flag == false) {
                $_SESSION['cart'][$id]['name'] = $product['name'];
                $_SESSION['cart'][$id]['soluong'] =  1;
                $_SESSION['cart'][$id]['image'] =  $product['image'];
                $_SESSION['cart'][$id]['price'] =  $product['price'];
            }
        } else {
            $_SESSION['cart'][$id]['name'] = $product['name'];
            $_SESSION['cart'][$id]['soluong'] =  1;
            $_SESSION['cart'][$id]['image'] =  $product['image'];
            $_SESSION['cart'][$id]['price'] =  $product['price'];
        }
        header("Location: index.php");
    }

    // Xoa
    if ($action == "delete") {
        unset($_SESSION['cart'][$id]);
        header("Location: index.php");
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin - Golden Sneaker</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="icon" href="./assets/icon/favicon.ico">

</head>

<body>
    <div class="header">

        <div class="container">
            <div class="bgyellow">
            </div>

            <div class="cart mr">
                <div class="top">
                    <img src="./assets/img/nike.png" alt="">
                </div>
                <div class="title" style="display:flex; font-family:Tahoma Verdana, Geneva, Tahoma, sans-serif; color: #333333;">
                    <h3><strong>Your Products</strong></h3>
                </div>
                <div class="body">
                    <?php
                    foreach ($result as $item) {
                        echo
                        '
                        <div class="item">
                            <img name="img" style="width: inherit; background-color:' . $item['color'] . '" src="' . $item['image'] . '" alt="">
                            <h2 class="name" name ="name">' . $item['name'] . '</h2>
                            <h5 style="color:grey;" class="description">' . $item['description'] . '</h5>
                            <h3 style="float:left;" name="price" class="price">$' . $item['price'] . '</h4>
                            <a style="float:right;"  class="button" href="index.php?action=add&id=' . $item['id'] . '" >ADD TO CART</a>
                      
                        </div>
                        ';
                    }
                    ?>
                </div>
            </div>

            <div class="cart">

                <div class="top">
                    <img src="./assets/img/nike.png" alt="">
                </div>
                <div class="title" style="display:flex; justify-content: space-between; font-family:Tahoma Verdana, Geneva, Tahoma, sans-serif; color: #333333;">
                    <h3>Your Cart</h3>
                    <?php
                    $product = $_SESSION['cart'];
                    $index = 0;
                    $total = 0;
                    foreach ($product as $key => $row) {
                        $item_cost = $row['price'] * $row['soluong'];
                        $total += $item_cost;
                    }
                    ?>
                    <h3 id="dola" style="padding-right:20px;">$ <span><?= number_format($total) ?></span></h3>

                </div>

                <div class="body " id="carts" style="text-align:left;">
                    <table class="container" style="height: fit-content;">
                        <tbody>
                            <?php
                            $product = $_SESSION['cart'];
                            $index = 0;
                            $total = 0;
                            foreach ($product as $key => $row) {
                                $item_cost = $row['price'] * $row['soluong'];
                                $total += $item_cost;
                                echo '
                        <tr>
                            <td class="img" rowspan = "2"> 
                                <img src="' . $row['image'] . '" alt="" height="150px" width="125px">
                            </td>
                            <td class="name" colspan = "2">
                                <h4>' . $row['name'] . '</h4>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="price">
                                <h4 style="margin-top:-50px;"> $ ' . $row['price'] . ' </h4>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td class="soluong">
                                <h5 style="text-align:center; margin-top: -20px;"><img src="./assets/img/minus.png" alt="" height="10px" width="10px"> ' . $row['soluong'] . ' <img src="./assets/img/plus.png" alt="" height="10px" width="10px"></h5>
                            </td>
                            <td>
                                <div class="circle">
                                    <a style="float:right;" href="index.php?action=delete&id=' . $key . '"><img src="./assets/img/trash.png" alt="" height="25px" width="25px"></a>
                                </div>
                            </td>
                        </tr>
                        ';
                            }
                            ?>
                        </tbody>


                    </table>
                </div>

            </div>
        </div>

        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="#FFFF00" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="#FFFF00" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="#FFFF00" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="#FFFF00" />
            </g>
        </svg>
    </div>

</body>

</html>