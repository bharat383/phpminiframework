<?php 
@include("class/Admin.class.php");
$Admin = new Admin();
$Admin->pagetitle="Site Settings";
@include("includes/header.php");
?>
<ul class="nav nav-tabs">
	<li class="active"><a href="#basic" data-toggle="tab">Basic Settings</a></li>
	<li><a href="#contact" data-toggle="tab">Contact Settings</a></li>
	<li><a href="#email" data-toggle="tab">Email Settings</a></li>
</ul>
<div class="row">
	<div class="col-md-10">
		<br/>
			<div id="myTabContent" class="tab-content">

				<!-- BEGIN BASIC SETTING CODE  -->
				<div class="tab-pane active in" id="basic">
					<form method="post" enctype="multipart/form-data">
						<div class="form-group">
					        <label>Site Title</label>
					        <input type="text" name="site_title" id="site_title" class="form-control" value="<?php echo stripslashes($Admin->sitedata['site_title']);?>" title="Please Enter Site Title">
				        </div>

				        <div class="form-group">
					        <label>Site Email</label>
					        <input type="text" name="site_email" id="site_email" class="form-control" value="<?php echo stripslashes($Admin->sitedata['site_email']);?>" title="Please Enter Site Email">
				        </div>

				        <div class="form-group">
					        <label>Site Meta Keywords</label>
					        <textarea name="site_meta_keywords" id="site_meta_keywords" class="form-control"><?php echo stripslashes($Admin->sitedata['site_meta_keywords']);?></textarea>
				        </div>

				        <div class="form-group">
					        <label>Site Meta Description</label>
					        <textarea name="site_meta_description" id="site_meta_description" class="form-control"><?php echo stripslashes($Admin->sitedata['site_meta_description']);?></textarea>
				        </div>

				        <div class="form-group">
					        <label>Logo Images</label>
					        <input type="file" name="logo_image" id="logo_image" class="" value="">
				        </div>

						<div class="panel panel-default">
					        <p class="panel-heading">Uploaded Logo Image</p>
					        <div class="panel-body gallery">
								<div style="display:inline-block;padding:10px;margin:4px;float:left;background:gray;" class="img-polaroid">	
									<img src="<?php echo SITE_URL;?>/images/<?php echo stripslashes($Admin->sitedata['logo_image']);?>">
								</div>
								<div class="clearfix"></div>
					        </div>
					    </div>

					    <div class="btn-toolbar list-toolbar">
					      	<input type="submit" name="submit_settings" value="Save" class="btn btn-primary">
					    </div>

					</form>
				</div>	
				<!-- END BASIC SETTING CODE  -->

				<!-- BEGIN CONTACT SETTING CODE  -->
				<div class="tab-pane fade" id="contact">
					<form method="post" enctype="multipart/form-data">
						<div class="form-group">
					        <label>Conctact Number</label>
					        <input type="text" name="contact_number" id="contact_number" class="form-control" value="<?php echo stripslashes($Admin->sitedata['contact_number']);?>" title="Please Enter Contact Number">
				        </div>

				        <div class="form-group">
					        <label>Contact Address</label>
					        <textarea name="contact_address" id="contact_address" class="form-control"><?php echo stripslashes($Admin->sitedata['contact_address']);?></textarea>
				        </div>

				        <div class="form-group">
					        <label>Facebook URL</label>
					        <input type="text" name="facebook_url" id="facebook_url" class="form-control" value="<?php echo stripslashes($Admin->sitedata['facebook_url']);?>">
				        </div>

				        <div class="form-group">
					        <label>Twitter URL</label>
					        <input type="text" name="twitter_url" id="twitter_url" class="form-control" value="<?php echo stripslashes($Admin->sitedata['twitter_url']);?>">
				        </div>

				        <div class="form-group">
					        <label>Google Plus URL</label>
					        <input type="text" name="google_url" id="google_url" class="form-control" value="<?php echo stripslashes($Admin->sitedata['google_url']);?>">
				        </div>

				        <div class="form-group">
					        <label>Linkedin URL</label>
					        <input type="text" name="linkedin_url" id="linkedin_url" class="form-control" value="<?php echo stripslashes($Admin->sitedata['linkedin_url']);?>">
				        </div>	

				        <div class="form-group">
					        <label>Pinterest URL</label>
					        <input type="text" name="pinterest_url" id="pinterest_url" class="form-control" value="<?php echo stripslashes($Admin->sitedata['pinterest_url']);?>">
				        </div>	

				        <div class="btn-toolbar list-toolbar">
					      	<input type="submit" name="submit_settings" value="Save" class="btn btn-primary">
					    </div>
					</form>    	
				</div>	
				<!-- END CONTACT SETTING CODE  -->

				<!-- BEGIN EMAIL SETTING CODE  -->
				<div class="tab-pane fade" id="email">
					<form method="post" enctype="multipart/form-data">
						<div class="form-group">
					        <label>Enable SMTP for Mail Sending </label>
					       	<select name="enable_smtp" id="enable_smtp" class="form-control" onchange="if(this.value==0){$('#smtp_setting').hide();}else{$('#smtp_setting').show();}">
				               	<option <?php if($Admin->sitedata['enable_smtp']==1){echo "selected"; } ?> value="1">Yes</option>
				               	<option <?php if($Admin->sitedata['enable_smtp']==0){echo "selected"; } ?> value="0">No</option>
					       	</select> 
				        </div>
						<div name="smtp_setting" id="smtp_setting"  <?php if(@$Admin->sitedata['enable_smtp']=="0") echo "style='display:none;'"; ?>>
					        <div class="form-group">
						        <label>SMTP Hostname </label>
						        <input type="text" name="smtp_hostname" id="smtp_hostname" class="form-control" value="<?php echo stripslashes($Admin->sitedata['smtp_hostname']);?>">
					        </div>
					        <div class="form-group">
						        <label>SMTP Port</label>
						        <input type="text" name="smtp_port" id="smtp_port" class="form-control" value="<?php echo stripslashes($Admin->sitedata['smtp_port']);?>">
					        </div>
					        <div class="form-group">
						        <label>SMTP Username</label>
						        <input type="text" name="smtp_username" id="smtp_username" class="form-control" value="<?php echo stripslashes($Admin->sitedata['smtp_username']);?>">
					        </div>
					        <div class="form-group">
						        <label>SMTP Password</label>
						        <input type="password" name="smtp_password" id="smtp_password" class="form-control" value="<?php echo base64_decode($Admin->sitedata['smtp_password']);?>">
						        <input type="checkbox" onclick="if(this.checked){$('#smtp_password').attr('type','text');}else{$('#smtp_password').attr('type','password');}"> Show Password
					        </div>
					        <div class="form-group">
						        <label>SMTP Mail from </label>
						        <input type="email" name="smtp_mailfrom" id="smtp_mailfrom" class="form-control" value="<?php echo stripslashes($Admin->sitedata['smtp_mailfrom']);?>">
					        </div>
					        <div class="form-group">
						        <label>SMTP Reply To</label>
						        <input type="email" name="smtp_replyto" id="smtp_replyto" class="form-control" value="<?php echo stripslashes($Admin->sitedata['smtp_replyto']);?>">
					        </div>
						</div>	
						<div class="btn-toolbar list-toolbar">
					      	<input type="submit" name="submit_settings" value="Save" class="btn btn-primary">
					    </div>
					</form>    	
				</div>
				<!-- END EMAIL SETTING CODE  -->
			</div>	
	</div>
</div>
<?php @include("includes/footer.php"); ?>