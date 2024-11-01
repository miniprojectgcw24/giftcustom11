<!-- Header Area Start -->
<?php
   include("includes/header.php");
   include("includes/dbconnect.php");
?>
<!-- Header Area End -->

<!-- Product Catagories Area Start -->
<div class="products-catagories-area clearfix">
    <div class="amado-pro-catagory clearfix">
        <div class="row" id="category-container">
            <?php
            // Load initial categories (5 at a time)
            $select_cat = "SELECT * FROM tbl_category LIMIT 5";
            $res_cat = mysqli_query($conn, $select_cat);
            while ($data = mysqli_fetch_array($res_cat)) {
                echo '<div class="col-md-2" style="margin-top:25px">';
                echo '<a href="?category=' . $data['cat_id'] . '" class="btn btn-success" style="width:90%">';
                echo $data['cat_name'];
                echo '</a></div>';
            }
            ?>
        </div>

        <!-- 'View More' Button -->
        <div class="text-left">
            <button id="load-more" class="btn btn-primary" style="margin-top:25px;">View More</button>
           &nbsp; <a class="btn btn-warning" style="margin-top:25px;" href="index.php">View less</a>
        </div>

        <!-- Work Display Area -->
        <div class="row">
            <?php
            $target_dir = "assets/img/product-img/";
            $cat_data = "";
            if (isset($_GET['category'])) {
                $cat_id = $_GET['category'];
                $cat_data = "WHERE cat_id='$cat_id'";
            }

            // Select work based on category
            $select_work = "SELECT * FROM tbl_work $cat_data";
            $res_work = mysqli_query($conn, $select_work);
            while ($datawork = mysqli_fetch_array($res_work)) {
            ?>
                <div class="col-md-4" style="margin-top:25px; display: flex; align-items: stretch;">
                    <div style="width: 90%; background-color: #ebebeb; color: #fff; padding: 20px; border-radius: 10px; text-align: center;">
                        <img style="height: 150px; object-fit: cover; width: 100%; border-radius: 10px;" src="<?php echo $target_dir . $datawork['image']; ?>" alt="Work Image">
                        <h2 style="margin: 15px 0; font-size: 1.5em;"><?php echo $datawork['work_name']; ?></h2>
                        <p style="font-size: 1.1em; margin-bottom: 10px;"><?php echo $datawork['details']; ?></p>
                        <p style="font-size: 1.2em; font-weight: bold;">Prize: <?php echo $datawork['price']; ?></p>

                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <a href="checkout.php?book=<?php echo $datawork['work_id']; ?>" class="btn btn-info" style="background-color: #17a2b8; padding: 10px 20px; border-radius: 5px; text-decoration: none; color: #fff; display: inline-block;">Book</a>
                        <?php } else { ?>
                            <p>You are not logged in/ please login</p>
                            <a href="log_register.php" class="btn amado-btn mb-15">Login / Register</a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Product Catagories Area End -->
</div>

<!-- ##### Footer Area Start ##### -->
<?php
   include("includes/footer.php");
?>
<!-- ##### Footer Area End ##### -->

<!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
<script src="assets/js/jquery/jquery-2.2.4.min.js"></script>
<!-- Popper js -->
<script src="assets/js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- Plugins js -->
<script src="assets/js/plugins.js"></script>
<!-- Active js -->
<script src="assets/js/active.js"></script>

<!-- AJAX for Loading More Categories -->
<script>
$(document).ready(function() {
    var offset = 5;  // Start loading from the 6th category
    var limit = 5;   // Load 5 categories at a time

    $('#load-more').on('click', function() {
        $.ajax({
            url: 'load_categories.php',  // PHP file that handles loading more categories
            type: 'POST',
            data: {
                limit: limit,
                offset: offset
            },
            success: function(response) {
                if (response) {
                    $('#category-container').append(response);
                    offset += limit;  // Increase the offset for next batch
                } else {
                    // Hide the 'View More' button if no more categories
                    $('#load-more').hide();
                }
            }
        });
    });
});
</script>

</body>
</html>
