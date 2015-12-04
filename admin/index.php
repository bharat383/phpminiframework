<?php 
@include("class/Dashboard.class.php");
$Admin = new Dashboard();
$Admin->pagetitle="Dashboard";
@include("includes/header.php");
?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading no-collapse">Statistics</div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td>Total Users</td>
                        <td><?php echo $Admin->statisticdata['total_users']; ?></td>
                        <td>Total Contact Messages</td>
                        <td><?php echo $Admin->statisticdata['total_messages']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading no-collapse">Last 10 Users</div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Register Date</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php foreach ($Admin->LatestUsers as $key => $value) { ?>
                        <tr>
                            <td><?php echo $value['firstname']." ".$value['lastname']; ?></td>
                            <td><?php echo $value['email'];?></td>
                            <td><?php echo date("d-m-Y H:i:s",strtotime($value['register_date'])); ?></td>
                            <td><?php echo $value['register_ipaddress']; ?></td>
                        </tr>
                    <?php } ?>    
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?php @include("includes/footer.php");?>