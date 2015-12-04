<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo SITE_TITLE." : ".stripslashes($Frontend->webpage_data['webpage_title']);?></title>
        <meta charset="utf-8">
        <!--  Meta keywords -->
        <meta name="keywords" content="<?php echo stripslashes(@$Frontend->webpage_data['webpage_keywords']); ?>">

        <!--  Meta Description -->
        <meta name="description" content="<?php echo stripslashes(@$Frontend->webpage_data['webpage_description']); ?>">
        
        <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo SITE_URL;?>/css/bootstrap.min.css">
        <!--<script src="<?php echo SITE_URL;?>/js/jquery.min.js"></script>
        <script src="<?php echo SITE_URL;?>/js/bootstrap.min.js"></script>-->
    </head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo SITE_URL;?>" style="color:#fff;"><?php echo SITE_TITLE;?></a>
            </div>
            <div>
                <ul class="nav navbar-nav">
                    <li class="<?php if($Frontend->pagefilename=='index.php') echo 'active'; ?>"><a  href="<?php echo SITE_URL;?>">Home</a><li>
                    <li class="<?php if($Frontend->pagefilename=='aboutus.php') echo 'active'; ?>"><a  href="<?php echo SITE_URL;?>/aboutus.php">About Us</a><li>
                    <li class="<?php if($Frontend->pagefilename=='contactus.php') echo 'active'; ?>"><a  href="<?php echo SITE_URL;?>/contactus.php">Contact Us</a><li>

                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']!="") { // LOGIN REQUIRED PAGE?>
                        <li class="<?php if($Frontend->pagefilename=='profile.php') echo 'active'; ?>"><a  href="<?php echo USER_URL;?>/profile.php">Profile</a><li> 
                        <li><a href="?logout">Logout</a></li>
                    <?php } else { ?>
                        <li class="<?php if($Frontend->pagefilename=='register.php') echo 'active'; ?>"><a  href="<?php echo SITE_URL;?>/register.php">Register</a><li>
                        <li class="<?php if($Frontend->pagefilename=='login.php') echo 'active'; ?>"><a  href="<?php echo SITE_URL;?>/login.php">Login</a><li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">