<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>


               <?php
                  if(isset($_SESSION['add']))//checking whether session is set or not
                  {
                    echo $_SESSION['add'];//displaying session message
                    unset($_SESSION['add']);//removing session message
                  }
               ?>
               <br><br><br>

        <form action="" method="POST" >
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter your username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Enter your password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                         <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php')?>

<?php
     // process the value from form and save it into databse

     //check whether the submit button is clicked or not

     if(isset($_POST['submit']))
     {
        //Button clicked
        //1.get the data from form using name.
        $full_name= $_POST['full_name'];
        $username=$_POST['username'];
        $password=md5($_POST['password']);   // password encryption
        
        //2. sql query to save the data into database
        $sql= "INSERT INTO tbl_admin SET
           full_name='$full_name',
           username='$username',
           password='$password'
        ";

        //Execute query and save data in database
        $res = mysqli_query($conn,$sql) or die(mysqli_error());

        //Check whether the (query is executed) data is inserted or not .
        if($res==true)
        {
            // echo "data stored";
            //create a session variable to display message
            $_SESSION['add']="<div class='success'>Admin added successfully.</div>";
            //Redirect page to manage admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // echo "failed to store data";   
             //create a session variable to display message
             $_SESSION['add']="<div class='error'>Failed to add admin.</div>";
             //Redirect page to manage admin
             header("location:".SITEURL.'admin/add-admin.php'); 
        }
     }
     
?>