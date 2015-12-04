<?php 
@include("class/Frontend.class.php");
$Frontend = new Frontend();
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
        <h2>Contact Us</h2>
        <?php $Frontend->DisplayMessage();?>
        <form role="form" method="post">
        	<div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter Fullname" title="Enter Fullname" value="<?php echo @$Frontend->data['fullname'];?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email"  class="form-control email" placeholder="Enter Email" title="Enter Email" value="<?php echo @$Frontend->data['email'];?>">
            </div>

            <div class="form-group">
                <label for="pwd">Message:</label>
                <textarea name="message" id="message" class="form-control" title="Please Enter Your Message"><?php echo @$Frontend->data['message'];?></textarea>
            </div>

            <div class="row">
                <div class="pull-left col-md-4">
                    <input type="submit" name="submit_contact" value="Send Message" class="btn btn-primary">
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
