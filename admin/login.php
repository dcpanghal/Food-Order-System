<?php  include('../config/constants.php'); ?>


<html>
    <head>
        <title>Login-Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">

    </head>
    <body>
        <div class="login">
            <h1 class="text-center logo">Login</h1><br><br>
            
            <?php 
               if(isset($_SESSION['login']))
               {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
               }
               if(isset($_SESSION['no-login-message']))
               {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
               }
            ?>
            <br><br>
            <!-- login form starts here -->

            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter username"><br><br>
                Password: <br>
                <input type="password" name="password" placeholder="Enter password"><br><br>

                <input type="submit" name="submit" value="Login" class="btn-primary"><br><br>
            </form>

            <!-- login form ends here -->

            <p class="text-center">Created by- <a href="#">Mandeep Panghal</a></p>
        </div>
    </body>
</html>

<?php
      //check whether submit button clicked or not
      if(isset($_POST['submit']))
      {
         //process login
         // 1. get the data from login form
         $username=$_POST['username'];
         $password=md5($_POST['password']);

         // 2. sql query to check whether user with this username or password exists.
         $sql="SELECT * FROM tbl_admin WHERE password='$password' AND username='$username'";

         // 3.execute the query
         $res=mysqli_query($conn,$sql);

         // 4.count rows to check whether user exists or not
         $count=mysqli_num_rows($res);

         if($count==1)
         {
            //user available and login success
            $_SESSION['login']="<div class='success'>Login successful!</div>";
            $_SESSION['user']=$username; //to check whether the user is logged in or not and logut will unset it
            //redirect to homepage
            header('location:'.SITEURL.'admin/index.php');
         }
         else
         {
            $_SESSION['login']="<div class='error text-center'>Usename or Password didn't match!</div>";
            //redirect to homepage
            header('location:'.SITEURL.'admin/login.php');
         }
      }
?>