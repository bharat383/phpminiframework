CREATE TABLE `bh_cms_webpages` (
  `webpage_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `login_require` int(1) NOT NULL,
  `webpage_url` varchar(250) NOT NULL,
  `webpage_title` varchar(100) NOT NULL,
  `webpage_keywords` text NOT NULL,
  `webpage_description` text NOT NULL,
  `webpage_content` longtext NOT NULL,
  `active_status` int(1) NOT NULL COMMENT '0:Inactive, 1: Active',
  PRIMARY KEY (`webpage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

insert into bh_cms_webpages (`webpage_id` ,`login_require` ,`webpage_url` ,`webpage_title` ,`webpage_keywords` ,`webpage_description` ,`webpage_content` ,`active_status` ) values  ( '5' ,'0' ,'login.php' ,'Login' ,'Login' ,'Login' ,'<p>Login Page Content Here</p>
' ,'1' ) , ( '4' ,'0' ,'register.php' ,'Register' ,'Register' ,'Register' ,'<p>Register Page Content</p>
' ,'1' ) , ( '3' ,'0' ,'contactus.php' ,'Contact Us' ,'Contact Us' ,'Contact Us' ,'<p>Contact Us Page Content</p>
' ,'1' ) , ( '2' ,'0' ,'aboutus.php' ,'About Us' ,'About Us' ,'About Us' ,'<p>About Us Page Content</p>

<p>&nbsp;</p>
' ,'1' ) , ( '1' ,'0' ,'index.php' ,'Home' ,'Bharat Code Home Page' ,'Bharat Code Home Page' ,'<p>Home Page Content Displayed Here</p>
' ,'1' );

-- --------------------------------------------------------

CREATE TABLE `bh_contactus_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `message_date` datetime NOT NULL,
  `ip_address` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE `bh_email_template` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `active_status` int(1) NOT NULL COMMENT '0:Inactive, 1:Active',
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

insert into bh_email_template (`template_id` ,`description` ,`subject` ,`message` ,`active_status` ) values  ( '4' ,'Thank You Mail to User for Contact Us Message' ,'{SiteTitle} : Thank You for Contact Us.' ,'<p>Hello {FirstName}, {LastName},</p>

<p>We have recieved your message from our Contact Us Page.</p>

<p>&nbsp;</p>
' ,'0' ) , ( '3' ,'Thank You Mail to New Subscriber' ,'{SiteTitle} : Thank You For Subscribing Us' ,'<p>Hello {FirstName} {LastName},</p>

<p>Welcome to {SiteTitle}.&nbsp;</p>

<p>Thank you joining us. Your Account details is as below :&nbsp;</p>

<p>Email : {Email}</p>

<p>Thank You.<br />
Admin,<br />
{SiteTitle}<br />
{SiteURL}<br />
&nbsp;</p>
' ,'0' ) , ( '2' ,'Forgot Password Mail' ,'{SiteTitle} : Forgot Password Mail' ,'<p>Hello {FirstName} {LastName},</p>

<p>You have requested for the password.</p>

<p>Your Account details is as below :</p>

<p>Name : {FirstName} {LastName}</p>

<p>Email : {Email}</p>

<p>Password : {Password}</p>

<p>&nbsp;</p>

<p>Thank You.</p>

<p>Admin,</p>

<p>{SiteTitle}</p>

<p>{SiteURL}</p>

<p>&nbsp;</p>
' ,'0' ) , ( '1' ,'New Registration Mail to User' ,'{SiteTitle} : Thank you for Joining Us.' ,'<p>Hello {FirstName} {LastName},</p>

<p>Welcome to {SiteTitle}. Thank you joining us.</p>

<p>Your Account details is as below :</p>

<p>Name : {FirstName} {LastName}</p>

<p>Email : {Email}</p>

<p>Password : {Password}</p>

<p>&nbsp;</p>

<p>Thank You.</p>

<p>Admin,</p>

<p>{SiteTitle}</p>

<p>{SiteURL}</p>

<p>&nbsp;</p>
' ,'0' );

-- --------------------------------------------------------

CREATE TABLE `bh_site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_title` varchar(100) DEFAULT NULL,
  `site_email` varchar(100) DEFAULT NULL,
  `site_meta_keywords` text,
  `site_meta_description` text,
  `logo_image` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `contact_address` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(200) DEFAULT NULL,
  `twitter_url` varchar(200) DEFAULT NULL,
  `google_url` varchar(200) DEFAULT NULL,
  `linkedin_url` varchar(200) DEFAULT NULL,
  `pinterest_url` varchar(200) DEFAULT NULL,
  `enable_smtp` int(1) DEFAULT NULL,
  `smtp_hostname` varchar(100) DEFAULT NULL,
  `smtp_port` varchar(10) DEFAULT NULL,
  `smtp_username` varchar(100) DEFAULT NULL,
  `smtp_password` varchar(255) DEFAULT NULL,
  `smtp_mailfrom` varchar(100) DEFAULT NULL,
  `smtp_replyto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

insert into bh_site_settings (`id` ,`site_title` ,`site_email` ,`site_meta_keywords` ,`site_meta_description` ,`logo_image` ,`contact_number` ,`contact_address` ,`facebook_url` ,`twitter_url` ,`google_url` ,`linkedin_url` ,`pinterest_url` ,`enable_smtp` ,`smtp_hostname` ,`smtp_port` ,`smtp_username` ,`smtp_password` ,`smtp_mailfrom` ,`smtp_replyto` ) values  ( '1' ,'Bharat Code' ,'bharatparmar383@gmail.com' ,'Bharat Code' ,'Bharat Code' ,'' ,'+91 9687766553' ,'Bharat Parmar,
02, Darbargadh,
Khombhadi, Nakhtrana
Dist : Kutch, Gujarat, India
PIN : 370670' ,'http://www.facebook.com/bharat383' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' );

-- --------------------------------------------------------

CREATE TABLE `bh_user_master` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` text NOT NULL,
  `register_date` datetime NOT NULL,
  `register_ipaddress` varchar(40) NOT NULL,
  `user_type` int(1) NOT NULL COMMENT '0:user,1: admin',
  `active_status` int(1) NOT NULL COMMENT '0:inactive, 1:active',
  `verify_code` varchar(100) NOT NULL,
  `verify_status` int(1) NOT NULL COMMENT '0:Pending, 1:Verified',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;