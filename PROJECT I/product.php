<?php include('partials-front/menu.php'); ?>

<section class="product">
    <div class="product-container">
        <div class="product-top">
            <?php
            $sql = "SELECT * FROM tbl_product WHERE `product_id` = ".$_GET['product_id'];
            $res = mysqli_query($conn, $sql);
            $product = mysqli_fetch_assoc($res);

            // $cartegory_id = isset($product['cartegory_id']);
            // $product_id = isset($product['product_id']);
            // $product_name = isset($product['product_name']);
            // $product_price = isset($product['product_price']);
            // $product_desc = isset($product['product_desc']);

            $sql2 = "SELECT * FROM tbl_product_img_desc WHERE `product_id` = ".$_GET['product_id'];
            $res2 =  mysqli_query($conn, $sql2);
            $product['images'] = mysqli_fetch_all($res2, MYSQLI_ASSOC);
            ?>
                    <div class="product-top-left">
                        <div class="product-top-left-big-img">
                            <img src="<?php echo SITEURL; ?>admin/uploads/<?php echo $product['product_img']; ?>" alt=""> 
                        </div>    
                        <div class="box-scroll">
                            <div class="product-top-left-small-img">
                                <?php foreach($product['images'] as $img) {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>admin/uploads/<?php echo $img['product_img_desc']; ?>" alt="">          
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="product-top-right">
                        <div class="product-top-right-container">
                            <div class="ten-gia">
                                <h1><?php echo $product['product_name']; ?></h1>
                                <p><?php echo number_format($product['product_price'], 0, ",", "."); ?><sup>VND</sup></p>
                            </div>
                            <div class="in4">
                                <p><?php echo $product['product_desc']; ?></p>
                            </div>
                        </div>
                        <div class="add-to-cart">
                            <form id="add-to-cart-form" action="cart.php?action=add" method="POST">
                            <div class="quantity">
                                <p>Số lượng:</p>
                                <input type="text" value="1" name="quantity[<?=$product['product_id']?>]"size=2/>
                            </div>
                            <div class="button-to-add">
                                <input type="submit" value="Thêm vào giỏ hàng"/>
                            </div>
                            </form>
                        </div>
                    </div>
        </div>
        <div class="product-bottom">
            <div class="details">

            </div>
            <div class="care">

            </div>
            <div class="shipping">

            </div>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>