<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
        }
        ?>

        <form action="" method="POST">
            <table>
                <tr>
                    <td>Change Password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
      if(isset($_POST['submit']))
      {
        // echo "clicked";
        // 1. get the data from form
        $id=$_POST['id'];
        $current_password=md5($_POST['current_password']);
        $new_password=md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);

        // 2. check whether the user with current password and id exists
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        // execute the query
        $res=mysqli_query($conn,$sql);

        if($res==true)
        {
            //check whether the data is available or not
            $count = mysqli_num_rows($res);
            if($count==1)
            {
                //user found and password can be changed
                // echo "user found";
                // check whether new password and current password match
                if($confirm_password==$new_password)
                {
                    // echo "password match";
                    $sql2="UPDATE tbl_admin SET
                     password='$new_password'
                     WHERE
                     id=$id
                    ";

                    //execute the query
                    $res2=mysqli_query($conn,$sql2);

                    //check whether the query is executed or not
                    if($res2==true)
                    {
                        //display message
                         //Redirect to manage-admin page with success
                        $_SESSION['change-pwd']="<div class='success'>Password changed successfully</div>";
                        //redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        // display error message
                         //Redirect to manage-admin page with error
                       $_SESSION["change-pwd"]="<div class='error'>Failed to change password</div>";
                       //redirect the user
                       header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //Redirect to manage-admin page with error
                    $_SESSION['pwd-not-match']="<div class='error'>Password did not match! </div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //user not found and set message and redirect
                $_SESSION['user-not-found']="<div class='error'>User not found! </div>";
                //redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
      }
?>

<?php include('partials/footer.php') ?>
