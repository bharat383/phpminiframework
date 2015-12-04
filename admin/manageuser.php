<?php 
@include("class/User.class.php");
$Admin = new User();
$Admin->pagetitle="User Management";
@include("includes/header.php");
?>

<?php if(isset($_GET['action']) && ($_GET['action']=="add" || $_GET['action']=="edit")) { ?>
<div class="row">
  <div class="col-md-12">
      	<form method="post" enctype="multipart/form-data" onsubmit="return validate_webpage(this);">

	        <div class="form-group">
		        <label>First Name</label>
		        <input type="text" name="firstname" id="firstname" class="form-control alpha" value="<?php echo stripslashes(@$Admin->data['firstname']);?>" title="Enter First Name">
	        </div>

	        <div class="form-group">
		        <label>Last Name</label>
		        <input type="text" name="lastname" id="lastname" class="form-control alpha" value="<?php echo stripslashes(@$Admin->data['lastname']);?>" title="Enter Last Name">
	        </div>

	        <div class="form-group">
		        <label>Email</label>
		        <input type="text" name="email" id="email" class="form-control email" value="<?php echo stripslashes(@$Admin->data['email']);?>" title="Enter Email">
	        </div>

	        <div class="form-group">
		        <label>Password</label>
		        <input type="text" name="password" id="password" class="form-control" value="" placeholder="Enter Password Only If You Want to Set/Change it.">
	        </div>

	        <div class="form-group">
		        <label>Active Status</label>
		        <select name="active_status" id="active_status" class="form-control">
		        	<option value="1" <?php if(@$Admin->data['active_status']=="1") echo "selected"; ?>>Active</option>
					<option value="0" <?php if(@$Admin->data['active_status']=="0") echo "selected"; ?>>Inactive</option>	
		        </select>
	        </div>

	        <div class="btn-toolbar list-toolbar">
		      	<input type="submit" name="submit_<?php echo $_GET['action'];?>" value="Save" class="btn btn-primary">
				<input type="button" name="cancel_button" value="Cancel" onclick="window.location='manageuser.php';" class="btn btn-default">
		    </div>
      	</form>
  </div>
</div>

<?php } else { ?>

<div class="btn-toolbar list-toolbar">
    <a href="<?php $Admin->AddLink();?>"><button class="btn btn-primary"><i class="fa fa-plus"></i> Add New</button></a>
  	<div class="btn-group"></div>
</div>
<table class="table table-hover" id="datarecord">
	<thead>
	    <tr>
			<th>Name</th>
			<th>Email</th>
			<th>Register Date</th>
			<th>Register IP Address</th>
			<th>Action</th>
	    </tr>
	</thead>
  	<tbody>
  		<?php foreach($Admin->data as $key=>$value) {?>	
			<tr>
				<td><?php echo stripslashes($value['firstname']." ".$value['lastname']); ?></td>
				<td><?php echo stripslashes($value['email']); ?></td>
				<td><?php echo date("d-m-Y H:i:s",strtotime($value['register_date'])); ?></td>
				<td><?php echo stripslashes($value['register_ipaddress']); ?></td>
				<td>
					<a href="<?php echo $Admin->EditLink($value['user_id']);?>" class="label label-info" style="margin-right:4px;" >
					<i class="fa fa-edit"></i> Edit </a>

					<?php if($value['active_status']==0) { ?>
					 	<a href="<?php echo $Admin->StatusLink($value['user_id'],1);?>"><span  class="label label-danger">Inactive</span></a>
					<?php } else { ?>
						<a href="<?php echo $Admin->StatusLink($value['user_id'],0);?>"><span  class="label label-success">Active</span></a>	
					<?php } ?>

					<a href='#' data-href="<?php echo $Admin->DeleteLink($value['user_id']);?>" class="label label-danger delete-record" style="margin-right:4px;" data-placement="top">
					<i class="fa fa-times"></i> Delete </a>
				</td>
			</tr>
		<?php } ?>
    </tbody>
</table>
<?php $Admin->PagiNation("user_master");?>
<?php } ?>
<?php @include("includes/footer.php"); ?>