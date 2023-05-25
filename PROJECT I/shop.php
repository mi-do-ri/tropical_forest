<?php include('partials-front/menu.php'); ?>

<!--category starts-->
<section class = "container">
    <div class="grid">
        <div class="grid__row category">
            <div class="grid__column-2">
                <div class="category-left">
                    <li class="category-left-li"><a href="">All</a></li>
                    <li class="category-left-li"><a href="">Collection</a></li>
                    <li class="category-left-li"><a href="">Plants</a></li>  
                </div>
            </div>
            <div class="grid__column-8">
                <div class="category-right"> 
                    <div class="grid__row">
                        
                        <?php 
                        // Create SQL Query to Display Products from Database
                        $sql = "SELECT * FROM tbl_product";
                        //Execute the Query
                        $res = mysqli_query($conn, $sql);
                        //Count rows to check whether the product is available or not
                        $count = mysqli_num_rows($res);

                        if($count>0)
                        {
                            //products available
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //Get the values like id, title, image_name
                                $product_id = $row['product_id'];
                                $product_name = $row['product_name'];
                                $product_price = $row['product_price'];
                                $product_img = $row['product_img'];
                                ?>
                                <div class="grid__column-25">
                                    <div class="category-right-item">
                                        <a href="product.php?product_id=<?= $product_id?>">
                                            <?php
                                            if($product_name=="")
                                            {
                                                //Display message
                                                echo "<div class='error'>Image not available</div>";
                                            }
                                            else
                                            {   
                                                ?>
                                                <img src="<?php echo SITEURL; ?>admin/uploads/<?php echo $product_img; ?>" alt="">
                                                <?php
                                            }
                                            ?>
                                            </a>
                                        <h1><?php echo $product_name; ?></h1>
                                        <p><?php echo number_format($product_price, 0, ",", ".") ; ?><sup>VND</sup></p>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        else
                        {
                            echo"<div class='error'>Product not added.</div>";
                        }
                        ?>

                        
                        
                    </div> 
                    <div class="category-right-bottom">
                        <div class="category-right-bottom-items">
                            <!-- <p><span>&#171;</span>1 2 3 4 5<span>&#187;</span>Trang cuối</p> -->
                        </div>
                    </div>                   
                </div>   
            </div>
        </div>
    </div>    
</section>
<!--category ends-->

<?php include('partials-front/footer.php'); ?>