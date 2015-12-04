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
            <h2>Login</h2>
            <?php $Frontend->DisplayMessage();?>
            <form role="form" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email"  class="form-control email" placeholder="Enter Email" title="Enter Email" value="<?php echo @$Frontend->data['email'];?>">
                </div>

                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" title="Enter Password" value="<?php echo @$Frontend->data['password'];?>">
                    <input type="checkbox" class="show_password"> Show Password
                </div>

                <div class="row">
                    <div class="pull-left col-md-4">
                        <input type="submit" name="submit_login" value="Login" class="btn btn-primary">
                    </div>
                    <div class="pull-right col-md-8 text-right">
                        <a href="<?php echo SITE_URL;?>/register.php">Register</a> |
                        <a href="<?php echo SITE_URL;?>/login.php">Forgot Password ? </a>
                    </div>
                </div>
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