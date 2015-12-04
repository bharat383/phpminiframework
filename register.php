<?php 
@include("class/User.class.php");
$Frontend = new User();
@include("includes/header.php");
?>

    <!-- BEGIN WEB PAGE CONTENT FROM BACKEND  -->
    <?php if(@$Frontend->webpage_data['active_status']==1) { ?>
        <div class="col-md-12">                    
            <?php echo stripslashes(@$Frontend->webpage_data['webpage_content']); ?>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        
        <div class="col-md-6">
            <h2>Register</h2>
            <?php $Frontend->DisplayMessage();?>
            <form role="form" method="post">
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" class="form-control alpha" id="firstname" name="firstname" placeholder="Enter First Name" title="Enter First Name" value="<?php echo @$Frontend->data['firstname'];?>">
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control alpha" id="lastname" name="lastname" placeholder="Enter Last Name" title="Enter Last Name" value="<?php echo @$Frontend->data['lastname'];?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control email" id="email" placeholder="Enter Email" title="Enter Email"  value="<?php echo @$Frontend->data['email'];?>">
                </div>

                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" title="Enter Password" value="<?php echo @$Frontend->data['password'];?>">
                    <input type="checkbox" class="show_password"> Show Password
                </div>

                <div class="form-group">
                    <label for="pwd">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password" title="Enter Confirm Password" value="<?php echo @$Frontend->data['confirm_password'];?>">
                    <input type="checkbox" class="show_password"> Show Password
                </div>

                <input type="submit" name="submit_register" value="Signup" class="btn btn-primary">
            </form>
        </div>
    <?php } else { //IF PAGE IS INACTIVE FROM BACKEND ?>
        <div class="col-md-12">
            <h4>Admin has disabled this page.</h4>
        </div>
    <?php } ?>
    <!-- END WEB PAGE CONTENT FROM BACKEND  -->
    <div class="clearfix"></div>

    
<?php @include("includes/footer.php");?>