<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1><br><br>

        <?php
              if(isset($_SESSION['add']))
              {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
              }

              if(isset($_SESSION['upload']))
              {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
              }
        ?>
         <br><br>

        <!-- add category form starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                
                <tr>
                    <td>Select image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
             
             // check whether submit button is clicked or not
             if(isset($_POST['submit']))
             {
                // echo "clicked";
                // 1. get the value from category form
                $title = $_POST['title'];
                if(isset($_POST['featured']))
                {
                    // get the value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //default value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    // get the value from form
                    $active = $_POST['active'];
                }
                else
                {
                    //default value
                    $active = "No";
                }

                // check whether the image is selected or name and set the value for image name accordingly
                // print_r($_FILES['image']);
                // die(); //break the code here 
                if(isset($_FILES['image']['name']))
                {
                    //upload the image
                    // to upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                  if($image_name != "")
                  {

                    // auto rename our image
                    //get the extension of the image(e.g- png,jpg etc.)
                    $ext=end(explode('.',$image_name));

                    //rename the image
                    $image_name = "Food_Category_".rand(000,999).'.'.$ext; // e.g-Food_Category_342.png

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    // finally upload the image
                    $upload = move_uploaded_file($source_path,$destination_path);

                    //check whether the image is uploaded or not
                    // if not, then we stop the process and redirect with error message
                    if($upload==false)
                    {
                        // set message
                        $_SESSION['upload']="<div class='error'>Failed to upload image! </div>";
                        // redirect to add category page
                        header('location:'.SITEURL.'admin/add-category.php');
                        // stop the process
                        die();
                    }

                  }
                }
                else
                {
                    // don't upload image and set the image_name as blank
                    $image_name="";
                }

                // 2. create sql query to insert category into database
                $sql="INSERT INTO tbl_category SET
                   title='$title',
                   image_name='$image_name',
                   featured='$featured',
                   active='$active'
                 ";

                 // 3. execute the query and save in database
                 $res = mysqli_query($conn,$sql);

                 // 4. check whether the query executed or not
                 if($res==true)
                 {
                    // query executed and data added
                    $_SESSION['add'] = "<div class='success'>Category added successfully!</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                 }
                 else
                 {
                    // failed to add category
                    $_SESSION['add'] = "<div class='error'>Failed to add category!</div>";
                    //redirect to add category page
                    header('location:'.SITEURL.'admin/add-category.php');
                 }

             }

        ?>

        <!-- add category form ends -->
    </div>
</div>

<?php include('partials/footer.php'); ?>
