<?php include('partials-front/menu.php'); ?>

<?php
if(!isset($_SESSION["cart"])){
    $_SESSION["cart"] = array();
}

if(isset($_GET['action']) == "submit"){
    $products = mysqli_query($conn, "SELECT * FROM tbl_product WHERE `product_id` IN (".implode(",", array_keys($_POST['quantity'])).")");
                $total = 0;
                $orderProducts = array();
                while($row = mysqli_fetch_array($products)) {
                    $orderProducts[] = $row;
                    $total += $row['product_price'] * $_POST['quantity'][$row['product_id']];
                }
                $insertOrder = mysqli_query($conn, "INSERT INTO `tbl_order` (`order_id`, `name`, `phone`, `address`, `total`) VALUES (NULL, '', '', '', '".$total."');");
}
if(!empty($_SESSION["cart"])){
    $products = mysqli_query($conn, "SELECT * FROM tbl_product WHERE `product_id` IN (".implode(",", array_keys($_SESSION['cart'])).")");
}
?>

<section class="payment">
    <div class="payment-container">
        <div class="payment-left">
            <div class="your-email">
                    <h1>Email liên hệ</h1>
                    <input required type="text" placeholder="Email">
                    <p>Bạn sẽ nhận được biên lai và thông báo tại địa chỉ email này.</p>
            </div>
            <div class="shipping">
                <h1>Thông tin vận chuyển</h1>
                <li><input required type="text" placeholder="Họ và tên"><i class="name"></i></li>
                <li><input required type="text" placeholder="Địa chỉ"><i class="address"></i></li>
                <li><input required type="text" placeholder="Số điện thoại"><i class="phone-number"></i></li>
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
                            <td>50.000<sub>VND</sub></td>
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
                            <td>50.000<sub>VND</sub></td>
                        </tr>
                    </tfoot>
                </table>
                <button>Mua hàng</button>
            </div>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>