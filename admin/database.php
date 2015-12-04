<?php 
@include("class/Database.class.php");
$Admin = new Database();
$Admin->pagetitle="Manage Database";
@include("includes/header.php");
?>

<div class="btn-toolbar list-toolbar pull-right">
    <a href="database.php?action=backup"><button class="btn btn-primary"><i class="fa fa-download"></i> Backup Latest Database</button></a>
  	<div class="btn-group"></div>
</div>

<table class="table table-hover" id="datarecord">
	<thead>
	    <tr>
		    <th>File Name</th>
			<th>File Size</th>
			<th>Created Date</th>
			<th>Action</th>
	    </tr>
	</thead>
  	<tbody>
  		<?php foreach($Admin->data as $key=>$value){?>	
			<tr>
				<td><?php echo stripslashes($value); ?></td>
				<td><?php echo round(filesize("database/".$value)/1024,2)." KB"; ?></td>
				<td><?php echo date("d-m-Y H:i:s",filectime("database/".$value));?></td>
				<td>
					<a href="database/download.php?filename=<?php echo $value;?>" class="label label-info" style="margin-right:4px;">
					<i class="fa fa-download"></i> Download </a>

					<a href='#' data-href="database.php?action=restore&filename=<?php echo $value;?>" class="label label-warning delete-record" data-title="Are You Sure To Restore This Database File ? New Record after that will be deleted and not recover. Backup the lastest database before Restore this Database." style="margin-right:4px;" data-placement="top" data-btnOkLabel="Yes">
					<i class="fa fa-recycle"></i> Restore </a>

					<a href='#' data-href="database.php?action=delete&filename=<?php echo $value;?>" class="delete-record label label-danger" data-placement="top" style="margin-right:4px;">
					<i class="fa fa-times"></i> Delete </a>
				</td>
			</tr>
		<?php } ?>
    </tbody>
</table>
<?php @include("includes/footer.php"); ?>