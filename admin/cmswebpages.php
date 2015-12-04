<?php 
@include("class/CMS.class.php");
$Admin = new CMS();
$Admin->pagetitle="CMS Web Pages";
@include("includes/header.php");
?>

<?php if(isset($_GET['action']) && ($_GET['action']=="add" || $_GET['action']=="edit")) { ?>
<div class="row">
  <div class="col-md-12">
    <br>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
      	<form method="post" enctype="multipart/form-data">
      		<div class="form-group">
		        <label>Login Requirement</label>
		        <select name="login_require" id="login_require" class="form-control">
					<option value="0" <?php if(@$Admin->data['login_require']=="0") echo "selected"; ?>>No</option>	
					<option value="1" <?php if(@$Admin->data['login_require']=="1") echo "selected"; ?>>Yes</option>
		        </select>
	        </div>

      		<div class="form-group">
		        <label>File Name (eg. login.php, register.php etc)</label>
		        <input type="text" name="webpage_url" id="webpage_url" class="form-control" value="<?php echo stripslashes(@$Admin->data['webpage_url']);?>" title="Please Enter Web Page URL">
	        </div>

	        <div class="form-group">
		        <label>WebPage Title</label>
		        <input type="text" name="webpage_title" id="webpage_title" class="form-control" value="<?php echo stripslashes(@$Admin->data['webpage_title']);?>" title="Please Enter Web Page Title">
	        </div>

	        <div class="form-group">
		        <label>Webpage Meta Keywords</label>
		        <textarea name="webpage_keywords" id="webpage_keywords" class="form-control"><?php echo stripslashes(@$Admin->data['webpage_keywords']);?></textarea>
	        </div>

	        <div class="form-group">
		        <label>Webpage Meta Description</label>
		        <textarea name="webpage_description" id="webpage_description" class="form-control"><?php echo stripslashes(@$Admin->data['webpage_description']);?></textarea>
	        </div>

	        <div class="form-group">
		        <label>Webpage Content</label>
		        <textarea name="webpage_content" id="webpage_content" class="ckeditor form-control"><?php echo stripslashes(@$Admin->data['webpage_content']);?></textarea>
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
				<input type="button" name="cancel_button" value="Cancel" onclick="window.location='<?php echo $Admin->pagefilename;?>';" class="btn btn-default">
		    </div>
      	</form>
      </div>
    </div>
  </div>
</div>

<?php } else { ?>

<div class="btn-toolbar list-toolbar">
    <a href="<?php $Admin->AddLink();?>"><button class="btn btn-primary"><i class="fa fa-plus"></i> Add New</button></a>
  	<div class="btn-group"></div>
</div>
<?php if(!empty($Admin->data)) {?>
<table class="table table-hover" id="datarecord">
	<thead>
	    <tr>
		    <th>Sr. No</th>
		    <th>Webpage URL</th>
			<th>Title</th>
			<th>Login</th>
			<th>Action</th>
	    </tr>
	</thead>
  	<tbody>
  		<?php foreach($Admin->data as $key=>$value){ ?>
			<tr>
				<td><?php echo ++$Admin->Startfrom; ?></td>
				<td><?php echo stripslashes($value['webpage_url']); ?></td>
				<td><?php echo stripslashes($value['webpage_title']); ?></td>
				<td>	
					<?php if($value['login_require']==1) echo "Required"; else echo "Not Required"; ?>	
				</td>
				<td>
					<a href="<?php echo $Admin->EditLink($value['webpage_id']);?>" class="label label-info" style="margin-right:4px;" >
					<i class="fa fa-edit"></i> Edit </a>

					<?php if($value['active_status']==0) { ?>
					 	<a href="<?php echo $Admin->StatusLink($value['webpage_id'],1);?>"><span  class="label label-danger">Inactive</span></a>
					<?php } else { ?>
						<a href="<?php echo $Admin->StatusLink($value['webpage_id'],0);?>"><span  class="label label-success">Active</span></a>	
					<?php } ?>

					<a href="" data-href="<?php echo $Admin->DeleteLink($value['webpage_id']);?>" class="label label-danger delete-record" style="margin-right:4px;" data-placement="top">
					<i class="fa fa-times"></i> Delete </a>

				</td>
			</tr>
		<?php } ?>
    </tbody>
</table>
<?php $Admin->PagiNation("cms_webpages");?>
<?php } ?>
<?php } ?>
<?php @include("includes/footer.php"); ?>