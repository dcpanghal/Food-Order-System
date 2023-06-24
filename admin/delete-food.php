<?php 
   // include constants page
   include('../config/constants.php');

   if(isset($_GET['id']) && isset($_GET['image_name']))
   {
    // process to delete
    // 1. get id and image name
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];

    // 2.remove the image if available
    //check whether if image is available and delete if available
    if($image_name!="")
    {
        // get the image path
        $path="../images/food/".$image_name;
        // remove image file from folder
        $remove=unlink($path);

        //check whether if image is deleted or not
        if($remove==false)
        {
            //failed to remove
            // redirect to manage admin page with session message and stop the process
            $_SESSION['upload']="<div class='error'>Failed to remove image file</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');

            die();
        }
    }

    // 3.delete food from db
    // create sql query
    $sql = "DELETE FROM tbl_food WHERE id=$id";

    //execute the query
    $res=mysqli_query($conn,$sql);

    //check whether query is executed or not
    if($res==true)
    {
        // food deleted
        $_SESSION['delete']="<div class='success'>Food deleted successfully!</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
         // failed to delete food
         $_SESSION['delete']="<div class='error'>Failed to delete food!</div>";
         header('location:'.SITEURL.'admin/manage-food.php');
    }

    // 4.redirect to manage-food with session message
   }
   else
   {
    //redirect to manage-food page
    $_SESSION['delete']="<div class='error'>Unauthorized access</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
   }
?>