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
<?php } else { //IF PAGE IS INACTIVE FROM BACKEND ?>
	<div class="col-md-12">
	    <h4>Admin has disabled this page.</h4>
	</div>
<?php } ?>
<!-- END WEB PAGE CONTENT FROM BACKEND  -->

<?php @include("includes/footer.php");?>
