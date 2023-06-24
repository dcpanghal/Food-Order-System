<?php
   //include constants.php file because we are using constant $conn.
   include('../config/constants.php');
   // 1.get the id of admin to be deleted
   $id=$_GET['id'];

   // 2.create SQL query to delete admin
   $sql = "DELETE FROM tbl_admin WHERE id=$id";

   //execute the query
   $res = mysqli_query($conn,$sql);

   //check whether the query is executed or not
   if($res==true)
   {
    // echo "Admin deleted successfully";
    //create session variable to display message
    $_SESSION['delete']="<div class='success'>Admin deleted successfully.</div>";
    //redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
   }
   else
   {
    // echo "failed to add admin";
    $_SESSION['delete']="<div class='error'>Failed to add admin, Please try again!</div>";
    //redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
   }


   // 3.redirect to manage admin page with message (success/error)
?>