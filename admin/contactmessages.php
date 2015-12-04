<?php 
@include("class/Contact.class.php");
$Admin = new Contact();
$Admin->pagetitle="Contact Messages";
@include("includes/header.php");
?>

<table class="table table-hover" id="datarecord">
	<thead>
	    <tr>
		    <th>Sr. No</th>
			<th>Sender Name</th>
			<th>Sender Email</th>
			<th>Message</th>
			<th>Message Date</th>
			<th>Action</th>
	    </tr>
	</thead>
  	<tbody>
  		<?php

  			$startfrom = 0;
  			$limit=$_SESSION['pagerecords_limit'];

  			if(isset($_GET['page']) && is_numeric($_GET['page']))
  			{
  				$startfrom= ($_GET['page']*$_SESSION['pagerecords_limit']-$_SESSION['pagerecords_limit']);	
  			} 

			$info_array = array(
									"orderby"=>"id",
									"ordertype"=>"desc",
									"limit"=>$limit,
									"startfrom"=>$startfrom
								);
			$records = $Admin->GetRecord("contactus_messages",$info_array);

			$srno=$startfrom;
			if(@count($records)>0)
			{	
				foreach($records as $key=>$value)
				{
					?>	
						<tr>
							<td><?php echo ++$srno; ?></td>
							<td><?php echo stripslashes($value['fullname']); ?></td>
							<td><?php echo stripslashes($value['email']); ?></td>
							<td style="width:40%">
								<?php if(strlen($value['message'])>75) { ?>
								<?php echo stripslashes(substr($value['message'],0,60))." . . . ";?>
								<a href="javascript:void();" onclick="$('#readmore<?php echo $key; ?>').show();">Read More</a>

								<div id="readmore<?php echo $key;?>" class="overlay_popup" style="position:fixed;top:10%;left:25%;display:none;background:#60708E;width:50%;transition: opacity 500ms;z-index:1000;">
									<div class="popup_main" style="position: relative; transition: all 5s ease-in-out;margin:5px;padding:15px;background:#fff;">
										<?php echo stripslashes(nl2br($value['message']));?>	
										<br><br>
										<div align="right"><button onclick="$('#readmore<?php echo $key; ?>').hide();" class="btn purple" type="button">Close</button></div>
									</div>		
								</div>	
								<?php } else {echo nl2br(stripslashes($value['message']));} ?>
								
							</td>
							<td><?php echo date("d-m-Y H:i:s",strtotime($value['message_date'])); ?></td>
							<td>
								<a href='#' data-href="contactmessages.php?do=contactmessages&action=delete&id=<?php echo $key;?>" class="label label-danger delete-record" style="margin-right:4px;" data-placement="top" data-title="Are You Sure to Delete This Message ?">
								<i class="fa fa-times"></i> Delete </a>
							</td>
						</tr>
					<?php	
				}
			}
			else
			{
				echo "<tr><td colspan='6' align='center'>Records not available.</td></tr>";
			}

		?>
    </tbody>
</table>

<?php $Admin->PagiNation("contactus_messages");?>
<?php @include("includes/footer.php"); ?>