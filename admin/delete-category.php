<?php
   // include constants.php
   include('../config/constants.php');

   //check whether id and image_name are obtained
   if(isset($_GET['id']) && isset($_GET['image_name']))
   {
    //  echo "got it";
    //get the value and delete
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];

    // remove the physical file if available
    if($image_name!="")
    {
        $path = "../images/category/".$image_name;
        //remove the image
        $remove=unlink($path);
        //if failed to remove an image , then add an error message and stop the process
        if($remove==false)
        {
            //set the session message
            $_SESSION['remove']="<div class='error'>Failed to remove image!</div>";
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
            //stop the process
            die();
        }
    }

    //delete data from database
    // make sql query to delete category
    $sql = "DELETE FROM tbl_category WHERE id=$id";

     // execute the query
    $res=mysqli_query($conn,$sql);

    //check whether data is deleted from database or not
    if($res==true)
    {
        //set session message
        $_SESSION['delete']="<div class='success'>Category deleted successfully!</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        //set session message
        $_SESSION['delete']="<div class='error'>Failed to delete category!</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }

    //redirect to manage category page with message
   }
   else
   {
    //redirect to manage-category page
     header('location:'.SITEURL.'admin/manage-category.php');
   }
?>