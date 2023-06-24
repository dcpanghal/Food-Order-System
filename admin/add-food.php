<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1><br><br>

        <?php

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        ?>

        <br><br>

        <form method="POST" enctype="multipart/form-data">
            <!--  enctype property is for image -->
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" placeholder="title of the food" name="title">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                               // create php code to display categories from database
                               //1. create sql query to get all active categories from db
                               $sql="SELECT * FROM tbl_category WHERE active='Yes'";

                               //execute query
                               $res = mysqli_query($conn,$sql);

                               // count rows to check whether we have categories or not
                               $count = mysqli_num_rows($res);

                               // if count is >0 then we have categories
                               if($count>0)
                               {
                                   while($row=mysqli_fetch_assoc($res))
                                   {
                                    // get the details
                                    $id=$row['id'];
                                    $title=$row['title'];

                                    ?>
                                       <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                   }
                               }
                               else
                               {
                                 //no category
                                 ?>
                                   <option value="0">No category found</option>
                                 <?php
                               }
                               //2. display on dropdown

                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" value="Yes" name="featured"> Yes 
                        <input type="radio" value="No" name="featured"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" value="Yes" name="active"> Yes 
                        <input type="radio" value="No" name="active"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" class="btn-secondary" value="Add Food">
                    </td>
                </tr>
            </table>
        </form>

        <?php
           //check whether button is clicked or not
           if(isset($_POST['submit']))
           {
            // echo "clicked";
            // 1. Get the data from form
            $description=$_POST['description'];
            $title=$_POST['title'];
            $category=$_POST['category'];
            $price=$_POST['price'];

            // check whether radio button for featured and active are checked or not
            if(isset($_POST['featured']))
            {
                $featured=$_POST['featured'];
            }
            else
            {
                $featured="No"; //setting the default value.
            }

            if(isset($_POST['active']))
            {
                $active=$_POST['active'];
            }
            else
            {
                $active="No"; //setting the default value.
            }

            // 2. Upload the image
            // check whether the select image is clicked or not and only if upload the image if selected
            if(isset($_FILES['image']['name']))
            {
              // get the details of selected image
              $image_name=$_FILES['image']['name'];

              //check whteher image is selected or not
              if($image_name!="")
              {
                //image is selected
                //rename the image
                //get the extension of selected image
                $ext=end(explode('.',$image_name)); 

                //create image name for image
                $image_name="Food-Name-".rand(0000,9999).".".$ext;

                //upload the image
                // get the source path and dest path

                //source path is the current location of the image
                $src=$_FILES['image']['tmp_name'];

                //dest path
                $dst="../images/food/".$image_name;

                //finally upload the image
                $upload=move_uploaded_file($src,$dst);

                //check whether image is uploaded or not
                if($upload==false)
                {
                    //failed to upload the image
                    //redirect to add-food page with error message and stop the process
                    $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
                    header('location:'.SITEURL.'admin/add-food.php');

                    die();
                }
              }
            }
            else
            {
                $image_name=""; // set default value to image
            }

            // 3. Insert into database
            // create sql query to add food
            // for numerical value we do not need to pass value inside quotes.but for strings it is compolsury
            $sql2="INSERT INTO tbl_food SET
              title='$title',
              description='$description',
              price=$price, 
              image_name='$image_name',
              category_id=$category,
              featured='$featured',
              active='$active'
            ";

            //execute the query
            $res2=mysqli_query($conn,$sql2);

            //check whether data is inserted or not
             // 4. Redirect to manage-food page with message
            if($res2==true)
            {
                //data inserted successfully
                $_SESSION['add']="<div class='success'>Food added successfully</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                $_SESSION['add']="<div class='error'>Failed to add food</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }

           
           }
        ?>


    </div>
</div>


<?php include('partials/footer.php') ?>