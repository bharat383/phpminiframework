<?php 
@include("class/Admin.class.php");
$Admin = new Admin();
$Admin->pagetitle="Admin Settings";
@include("includes/header.php");
?>
<div class="row">
  <div class="col-md-6">
    <br>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
      	<form method="post" enctype="multipart/form-data" onsubmit="return validate_epaper(this);">

	        <div class="form-group">
		        <label>First Name</label>
		        <input type="text" name="firstname" id="firstname" class="form-control alpha" value="<?php echo stripslashes($Admin->data['firstname']);?>" title="Please Enter First Name">
	        </div>

	        <div class="form-group">
		        <label>Last Name</label>
		        <input type="text" name="lastname" id="lastname" class="form-control alpha" value="<?php echo stripslashes($Admin->data['lastname']);?>" title="Please Enter Last Name">
	        </div>

	        <div class="form-group">
		        <label>Email</label>
		        <input type="email" name="email" id="email" class="form-control alpha" value="<?php echo stripslashes($Admin->data['email']);?>" title="Please Enter Email">
	        </div>

	        <div class="form-group">
		        <label>Password</label>
		        <input type="password" name="password" id="password" class="form-control" value="" placeholder="Leave Blank if you do not want to change the password.">
		        <input type="checkbox" class="show_password"> Show Password
	        </div>

	        <div class="form-group">
		        <label>Confirm Password</label>
		        <input type="password" name="confirm_password" id="confirm_password" class="form-control" value="" placeholder="Leave Blank if you do not want to change the password.">
		        <input type="checkbox" class="show_password"> Show Password
	        </div>
	        
	        <div class="btn-toolbar list-toolbar">
		      	<input type="submit" name="submit_profile" value="Save" class="btn btn-primary">
		    </div>
      	</form>
      </div>
    </div>
  </div>
</div>
<?php @include("includes/footer.php"); ?>