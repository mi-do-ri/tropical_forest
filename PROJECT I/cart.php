<?php 
include('partials-front/menu.php'); 
?>

<?php
if(!isset($_SESSION["cart"])){
    $_SESSION["cart"] = array();
}
$error = false;
$success = false;
if(isset($_GET['action'])){
    function update_cart($add = false){
        foreach($_POST['quantity'] as $id => $quantity){
            if ($quantity == 0){
                unset($_SESSION["cart"][$id]);
            } else {
                if ($add) {
                    $_SESSION["cart"][$id] += $quantity;
                }else{
                    $_SESSION["cart"][$id] = $quantity;
                }
            }  
        }
    }
    switch($_GET['action']){
        case "add":
            update_cart(true);
            header('Location: ./cart.php');
            break;
        case "delete":
            if(isset($_GET['product_id'])){
                unset($_SESSION["cart"][$_GET['product_id']]);
            }
            header('Location: ./cart.php');
            break;
        case "submit":
            // echo "SUBMIT BUTTON"; exit;
            if(isset($_POST['update_click'])) {
                update_cart();
                header('Location: ./cart.php');
            }elseif($_POST['order_click']){
                if (empty($_POST['name'])){
                    $error = "Bạn chưa nhập tên của người nhận";
                }elseif(empty($_POST['address'])) {
                    $error = "Bạn chưa nhập đại chỉ của người nhận";
                }elseif(empty($_POST['phone'])) {
                    $error = "Bạn chưa nhập số điện thoại của người nhận";
                }elseif(empty($_POST['quantity'])){
                    $error = "Giỏ hàng rỗng";
                }
                if ($error == false && !empty($_POST['quantity'])) {
                    $products = mysqli_query($conn, "SELECT * FROM tbl_product WHERE `product_id` IN (".implode(",", array_keys($_POST['quantity'])).")");
                $total = 0;
                $orderProducts = array();
                while($row = mysqli_fetch_array($products)) {
                    $orderProducts[] = $row;
                    $total += $row['product_price'] * $_POST['quantity'][$row['product_id']];
                }
                $insertOrder = mysqli_query($conn, "INSERT INTO `tbl_order` (`order_id`, `email`, `name`, `address`, `phone`, `total`) VALUES (NULL, '".$_POST['email']."', '".$_POST['name']."', '".$_POST['address']."', '".$_POST['phone']."', '".$total."');");
                $orderID = $conn->insert_id;
                $insertString = "";
                foreach($orderProducts as $key => $product) {
                    
                    $insertString .= "(NULL, '".$orderID."', '".$product['product_id']."', '".$_POST['quantity'][$product['product_id']]."', '".$product['product_price']."')";
                    if($key != count($orderProducts) - 1) {
                        $insertString .= ",";
                    }
                }
                $insertOrder = mysqli_query($conn, "INSERT INTO `tbl_order_detail` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES ".$insertString.";");
                $success = "Đặt hàng thành công";
                unset($_SESSION['cart']);
                }     
            }
            break;
    }
}

if(!empty($_SESSION["cart"])){
    $products = mysqli_query($conn, "SELECT * FROM tbl_product WHERE `product_id` IN (".implode(",", array_keys($_SESSION["cart"])).")");
}
?>
<?php if (!empty($error)) { ?>
            <div id="notify-msg">
                <?=$error?>.<a href="javascript:history.back()">Quay lại</a>
            </div>
        <?php } elseif(!empty($success)) { ?>
            <div id="notify-msg">
            <?=$success?>.<a href="shop.php">Tiếp tục mua hàng</a>
        </div>
        <?php } else { ?>
            <form id="cart-form" action="cart.php?action=submit" method="POST">
<seciton class="cart">
    <div class="cart-container">
        
        <div class="cart-top">
            <p>Giỏ hàng</p>
        </div>
        
        <div class="list-items">
            <table>
                <tbody>
                    <?php 
                    if(!empty($products)){
                        $total = 0;
                    while($row = mysqli_fetch_array($products)) { ?>
                    <tr>
                        <td><img src="<?php echo SITEURL; ?>admin/uploads/<?php echo $row['product_img']; ?>" alt=""> </td>
                        <td><h1><?=$row['product_name']?></h1></td>
                        <td><input type="text" value="<?=$_SESSION["cart"][$row['product_id']]?>" name="quantity[<?=$row['product_id']?>]"></td>
                        <td><p><?=number_format($row['product_price'] * $_SESSION["cart"][$row['product_id']], 0, ",", ".")?><sub>VND</sub></p></td>
                        <td><a href="cart.php?action=delete&product_id=<?=$row['product_id']?>"><span>X</span></a></td>
                    </tr> 
                    <?php 
                    $total += $row['product_price'] * $_SESSION["cart"][$row['product_id']];
                    }         
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Tổng tiền</th>
                        <th colspan="2"><?= number_format($total, 0, ",", ".")?><span>VND</span></th>
                    </tr>
                </tfoot> 
                <?php
            }
            ?>                   
            </table>
        </div>
        <div class = "pay">
            <input type="submit" name="update_click" value="Cập nhật"/>
        </div>
    </div>
</seciton>

<section class="payment">
    <div class="payment-container">
        <div class="payment-left">
            <div class="your-email">
                    <h1>Email liên hệ</h1>
                    <input type="text" placeholder="Email" value="" name="email">
                    <p>Bạn sẽ nhận được biên lai và thông báo tại địa chỉ email này.</p>
            </div>
            <div class="shipping">
                <h1>Thông tin vận chuyển</h1>
                <li><input type="text" placeholder="Họ và tên" value="" name="name"><i class="name"></i></li>
                <li><input type="text" placeholder="Địa chỉ" value="" name="address"><i class="address"></i></li>
                <li><input type="text" placeholder="Số điện thoại" value="" name="phone"><i class="phone-number"></i></li>
            </div>        
        </div>
        <div class="payment-right">
            <div class="payment-discount">
                <h1>Thanh toán</h1>
                <p>Phương thức thanh toán</p>
                <div class="phuongthuc">
                    <input checked name="method-payment" type="radio">
                    <label for="">Thanh toán bằng thẻ tín dụng</label>
                    <p>Mọi giao dịch đều được bảo mật và mã hóa</p>
                </div>
                <div class="phuongthuc">
                    <input checked name="method-payment" type="radio">
                    <label for="">Thanh toán COD</label>
                </div>
                <div class="discount">
                    <input type="text" placeholder="Mã giảm giá">
                    <button><i class="fas fa-check"></i></button>
                </div>
            </div>
            <div class="order-summary">
                <h1>Hóa đơn</h1>
                <table>
                    <tbody>
                        <tr>
                            <td>Tạm tính</td>
                            <td>1.100.000<sub>VND</sub></td>
                        </tr>
                        <tr>
                            <td>Thuế giá trị gia tăng</td>
                            <td>0<sub>VND</sub></td>
                        </tr>
                        <tr>
                            <td>Phí vận chuyển</td>
                            <td>0<sub>VND</sub></td>
                        </tr>       
                    </tbody>
                
                    <tfoot>
                        <tr>
                            <td>Tổng tiền</td>
                            <td>1.100.000<sub>VND</sub></td>
                        </tr>
                    </tfoot>
                </table>
                <input type="submit" name="order_click" value="Đặt hàng"/>
            </div>
        </div>
    </div>
</section>
</form>
        <?php } ?>

<?php include('partials-front/footer.php'); ?>
