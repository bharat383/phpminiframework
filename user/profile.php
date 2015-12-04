<?php 
@include("../class/User.class.php");
$Frontend = new User();
@include("../includes/header.php");
?>

    <!-- BEGIN WEB PAGE CONTENT FROM BACKEND  -->
    <?php if(@$Frontend->webpage_data['active_status']==1) { ?>
        <div class="col-md-12">                    
            <?php echo stripslashes(@$Frontend->webpage_data['webpage_content']); ?>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    <?php } else { //IF PAGE IS INACTIVE FROM BACKEND ?>
        <div class="col-md-12">
            <h4>Admin has disabled this page.</h4>
        </div>
    <?php } ?>
    <!-- END WEB PAGE CONTENT FROM BACKEND  -->
    <div class="clearfix"></div>

    <?php $Frontend->DisplayMessage();?>
    <div class="col-md-6">
        <h2>Account Info</h2>
        <form role="form" method="post">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" class="form-control alpha" id="firstname" name="firstname" placeholder="Enter First Name" title="Enter First Name" value="<?php echo stripslashes($Frontend->UserData['firstname']);?>">
            </div>

            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" class="form-control alpha" id="lastname" name="lastname" placeholder="Enter Last Name" title="Enter Last Name" value="<?php echo stripslashes($Frontend->UserData['lastname']);?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control email" id="email" placeholder="Enter Email" title="Enter Email" value="<?php echo stripslashes($Frontend->UserData['email']);?>">
            </div>

            <input type="submit" name="submit_profile" value="Update Profile" class="btn btn-primary">
        </form>
    </div>

    <div class="col-md-6">
        <h2>Change Password</h2>
        <form role="form" method="post">
            <div class="form-group">
                <label for="current_password">Current Password :</label>
                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter Current Password" title="Enter Current Password" value="">
            </div>

            <div class="form-group">
                <label for="new_password">New Password :</label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter New Password" title="Enter New Password" value="">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password :</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter Confirm New Password" title="Enter Confirm New Password" value="">
            </div>

            <input type="submit" name="submit_changepassword" value="Change Password" class="btn btn-primary">
        </form>
    </div>

<?php @include("../includes/footer.php");?>