<?php include('partials-front/menu.php'); ?>

<?php
   // check whether id is set or not
   if(isset($_GET['food_id']))
   {
     // Get food id and other details
     $food_id=$_GET['food_id'];

     $sql="SELECT * FROM tbl_food WHERE id=$food_id";

     $res=mysqli_query($conn,$sql);

     $count=mysqli_num_rows($res);

     //check whether data is available or not
     if($count==1)
     {
        // we have data
        //get the data from db
        $row=mysqli_fetch_assoc($res);
        $title=$row['title'];
        $price=$row['price'];
        $image_name=$row['image_name'];
     }
     else
     {
        // Food not available
        header('location:'.SITEURL);
     }
   }
   else
   {
    // Redirect to homepage
    header('location:'.SITEURL);
   }
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php
                          // Check whether the image is available or not
                          if($image_name=="")
                          {
                            //Image not available
                            echo "<div class='error text-center'>Image not available!</div>";
                          }
                          else
                          {
                            //image is available
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                            <?php
                          }
                        ?>
                    </div>
    
                    <div class="food-menu-desc">
                        <input type="hidden" name="food" value="<?php echo $title; ?>">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <p class="food-price"><?php echo $price; ?></p>

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php

            // check whether submit button is clicked or not
            if(isset($_POST['submit']))
            {
              // Get all the details from form
              $food=$_POST['food'];
              $price=$_POST['price'];
              $qty=$_POST['qty'];
              $total = $price * $qty;
              $order_date= date("y-m-d h:i:sa");/////////////////////////
              $status="Ordered";// we have four statuses-ordered,on delievery,delievered,cancelled.
              $customer_name=$_POST['full-name'];
              $customer_contact=$_POST['contact'];
              $customer_email=$_POST['email'];
              $customer_address=$_POST['address'];

              // Save the data in db
              $sql2="INSERT INTO tbl_order SET 
              food='$food',
              price=$price,
              qty=$qty,
              total=$total,
              order_date='$order_date',
              status='$status',
              customer_name='$customer_name',
              customer_contact='$customer_contact',
              customer_email='$customer_email',
              customer_address='$customer_address'
              ";

              $res2=mysqli_query($conn,$sql2);

              // Check whether query executed or not
              if($res2==true)
              {
                // Query executed
                $_SESSION['order']="<div class='success text-center'>Order placed successfully!</div>";
                header('location:'.SITEURL);
              }
              else
              {
                // Failed to save order
                $_SESSION['order']="<div class='error text-center'>Failed to place order!</div>";
                header('location:'.SITEURL);
              }

            }

            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
