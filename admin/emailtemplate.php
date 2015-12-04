<?php 
@include("class/CMS.class.php");
$Admin = new CMS();
$Admin->pagetitle="Email Templates";
@include("includes/header.php");
?>

<?php if(isset($_GET['action']) && ($_GET['action']=="addnew" || $_GET['action']=="edit")) { ?>
<div class="row">
  <div class="col-md-12">
    <br>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
      	<form method="post" enctype="multipart/form-data">

	        <div class="form-group">
		        <label>Mail Subject</label>
		        <input type="text" name="description" id="description" class="form-control" value="<?php echo stripslashes(@$Admin->data['description']);?>" title="Please Enter Mail Description">
	        </div>
	        <div class="form-group">
		        <lable>Mail Subject</lable>
		        <input type="text" name="subject" id="subject" class="form-control" value="<?php echo stripslashes(@$Admin->data['subject']);?>" title="Please Enter Mail Subject">
	        </div>
	        <div class="form-group">
		        <lable>Template Tags</lable>
		        <ul class="list-inline clearfix">
		        	<li class="col-md-3">First Name : {FirstName}</li>
		        	<li class="col-md-3">Last Name : {LastName}</li>
		        	<li class="col-md-3">Email : {Email}</li>
		        	<li class="col-md-3">Password : {Password}</li>
		        	<li class="col-md-3">User ID : {UserId}</li>
		        	<li class="col-md-3">IP Address : {IpAddress}</li>
		        	<li class="col-md-3">Message : {Message}</li>
		        	<li class="col-md-3">Contact Number : {ContactNumber}</li>
		        	<li class="col-md-3">Date : {Date}</li>
		        	<li class="col-md-3">Site Title : {SiteTitle}</li>
		        	<li class="col-md-3">Site URL : {SiteURL}</li>
		        </ul>
	        </div>

	        <div class="form-group">
		        <lable>Message</lable>
		        <textarea name="message" id="message" class="ckeditor form-control" style="height:450px !important;"><?php echo stripslashes(@$Admin->data['message']);?></textarea>
		        <script type="text/javascript">CKEDITOR.replace("message",{height: 400});</script>
	        </div>

	        <div class="form-group">
		        <lable>Active Status</lable>
		        <select name="active_status" id="active_status" class="form-control">
		        	<option value="1" <?php if(@$Admin->data['active_status']=="1") echo "selected"; ?>>Active</option>
					<option value="0" <?php if(@$Admin->data['active_status']=="0") echo "selected"; ?>>Inactive</option>	
		        </select>
	        </div>

	        <div class="btn-toolbar list-toolbar">
		      	<input type="submit" name="submit_<?php echo $_GET['action'];?>" value="Save" class="btn btn-primary">
				<input type="button" name="cancel_button" value="Cancel" onclick="window.location='emailtemplate.php';" class="btn btn-default">
		    </div>
      	</form>
      </div>
    </div>
  </div>
</div>

<?php } else { ?>


<div class="btn-toolbar list-toolbar">
    <a href="<?php $Admin->AddLink(); ?>"><button class="btn btn-primary"><i class="fa fa-plus"></i> Add New</button></a>
  	<div class="btn-group"></div>
</div>
<?php if(!empty($Admin->data)) {?>
<table class="table table-hover" id="datarecord">
	<thead>
	    <tr>
	    	<th>Description</th>
			<th>Subject</th>
			<th>Action</th>
	    </tr>
	</thead>
  	<tbody>
  		<?php foreach($Admin->data as $key=>$value){?>	
			<tr>
				<td><?php echo stripslashes($value['description']); ?></td>
				<td><?php echo stripslashes($value['subject']); ?></td>
				<td>

					<a href="<?php echo $Admin->EditLink($value['template_id']);?>" class="label label-info" style="margin-right:4px;" >
					<i class="fa fa-edit"></i> Edit </a>

					<?php if($value['active_status']==0) { ?>
					 	<a href="<?php echo $Admin->StatusLink($value['template_id'],1);?>"><span  class="label label-danger">Inactive</span></a>
					<?php } else { ?>
						<a href="<?php echo $Admin->StatusLink($value['template_id'],0);?>"><span  class="label label-success">Active</span></a>	
					<?php } ?>

					<?php /* ?>	
					<a href="<?php echo $Admin->DeleteLink($value['template_id']);?>" class="label label-danger" onclick="return confirm('Are You Sure To Delete This Record?');" style="margin-right:4px;">
					<i class="fa fa-times"></i> Delete </a><?php */ ?>

						

				</td>
			</tr>
		<?php } ?>
    </tbody>
</table>

<?php $Admin->PagiNation("email_template");?>

<?php } ?>
<?php } ?>
<?php @include("includes/footer.php"); ?>