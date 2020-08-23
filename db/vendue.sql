-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2020 at 10:24 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vendue`
--

-- --------------------------------------------------------

--
-- Table structure for table `vs_bids`
--

CREATE TABLE `vs_bids` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bid_val` int(11) NOT NULL,
  `bid_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vs_bids`
--

INSERT INTO `vs_bids` (`id`, `product_id`, `user_id`, `bid_val`, `bid_datetime`) VALUES
(1, 1, 14, 10, '2020-08-13 08:30:24'),
(2, 2, 14, 10, '2020-08-16 20:17:01'),
(4, 1, 14, 9, '2020-08-17 00:46:31');

-- --------------------------------------------------------

--
-- Table structure for table `vs_category`
--

CREATE TABLE `vs_category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_category`
--

INSERT INTO `vs_category` (`id`, `name`, `description`, `status`) VALUES
(1, 'Furniture', 'Furniture,Wordrobe,Showcase,Luxury Furniture', 'A'),
(2, 'Handicrafts', 'Ajrak blue pottery Camel Bone Camel Skin handicrafts lacquer art metal craft onyx craft Pakistan wood work', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `vs_email_conf`
--

CREATE TABLE `vs_email_conf` (
  `id` int(11) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `email_body` text NOT NULL,
  `email_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_email_conf`
--

INSERT INTO `vs_email_conf` (`id`, `subject`, `email_body`, `email_type`) VALUES
(1, 'Invoice', '<b><br>Dear %displayname%,\r\n</b><br><br>%invoicedetails%<br><br><b>Regards,</b><br><br><b>Team MS</b>', 'compnay_invoice'),
(2, 'Welcome to MyStore', 'Dear %displayname%,\r\n\r\n&nbsp;\r\n<br><br>&nbsp;Thank you for doing business with us, please find bellow your user name, password and the&nbsp;link to our website, if you need&nbsp;assistance&nbsp;give us a call.&nbsp;\r\n\r\n&nbsp;\r\n<br><br>&nbsp;URL: %loginURL%&nbsp;&nbsp;<br>&nbsp;Username : %username%<br>&nbsp;Password : %password%<br><br>Regards,<br><br><b>Team MS</b>', 'new_customer'),
(3, 'Forgot password', '<p>%displayname%</p>\r\n\r\n<p>%password%</p>\r\n', 'forgot_password'),
(4, 'TNT Order ', '<div id=\"print-area\">\r\n<div class=\"pad-top font-big\">\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt=\"Top Notch Tyres Wholesale \" src=\"http://topnotchwholesale.co.uk/images/blogo.png\" /></td>\r\n			<td style=\"text-align:right\"><strong>Top Notch Tyres Wholesale </strong><br />\r\n			<strong>Call:&nbsp;</strong>0207 018 7717<br />\r\n			<strong>Address:</strong> 1 Allum way , Tottridge London N20 9QP<br />\r\n			<strong>VAT NO: 176 0733 03 Company No: 08750170</strong></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n\r\n<div class=\"row text-center topbottomborder\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\" style=\"text-align: center;\">This is an electronic generated receipt , for any issues please contact &nbsp;<strong> info@topnotchwholesale.co.uk </strong></div>\r\n</div>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<h3><strong>Client Details:</strong></h3>\r\n\r\n			<p><strong>%displayname%</strong><br />\r\n			<strong>Email: </strong>%email%<br />\r\n			<strong>Call: </strong>%phone_no%<br />\r\n			%address%<br />\r\n			%postcode%</p>\r\n			</td>\r\n			<td>\r\n			<h3 style=\"text-align:right\"><strong>Order Details:</strong></h3>\r\n\r\n			<p style=\"text-align:right\"><strong>Order No: %orderno%</strong><br />\r\n			<strong>Order On: %orderdate%</strong><br />\r\n			<strong>Order Status : %orderstatus%&nbsp;</strong></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n&nbsp;\r\n\r\n<h3><strong>Order Products</strong></h3>\r\n\r\n<div class=\"row\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\">\r\n<div class=\"table-responsive\"><strong>%orderdetails%</strong></div>\r\n\r\n<div class=\"table-responsive\">&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<hr />\r\n<div class=\"row\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\"><strong>IMPORTANT INSTRUCTIONS : </strong>\r\n\r\n<h5># This is an electronic receipt so doesn&#39;t require any signature.</h5>\r\n\r\n<h5># All perticulars are listed Without Applying Any Taxes , so if any issue please contact us immediately.</h5>\r\n\r\n<h5># You can contact us between 10:am to 6:00 pm on all working days.</h5>\r\n</div>\r\n</div>\r\n</div>\r\n', 'new_order'),
(5, 'Completed ', '<div id=\"print-area\">\r\n<div class=\"pad-top font-big\">\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt=\"Top Notch Tyres Wholesale \" src=\"http://topnotchwholesale.co.uk/images/blogo.png\" /></td>\r\n			<td style=\"text-align:right\"><strong>Top Notch Tyres Wholesale </strong><br />\r\n			<strong>Call :</strong>0207 018 7717<br />\r\n			<strong>Address:</strong> 1 Allum way , Tottridge London N20 9QP<br />\r\n			<strong>VAT NO: 176 0733 03 Company No: 08750170</strong></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n\r\n<div class=\"row text-center topbottomborder\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\" style=\"text-align: center;\">This is an electronic generated receipt , for any issues please contact &nbsp;<strong> info@topnotchwholesale.co.uk </strong></div>\r\n</div>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<h3><strong>Client Details:</strong></h3>\r\n\r\n			<p><strong>%displayname%</strong><br />\r\n			<strong>Email: </strong>%email%<br />\r\n			<strong>Call: </strong>%phone_no%<br />\r\n			%address%<br />\r\n			%postcode%</p>\r\n			</td>\r\n			<td>\r\n			<h3 style=\"text-align:right\"><strong>Order Details:</strong></h3>\r\n\r\n			<p style=\"text-align:right\"><strong>Order No: %orderno%</strong><br />\r\n			<strong>Order On: %orderdate%</strong><br />\r\n			<strong>Order Status : %orderstatus%&nbsp;</strong></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n&nbsp;\r\n\r\n<h3><strong>Order Products</strong></h3>\r\n\r\n<div class=\"row\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\">\r\n<div class=\"table-responsive\"><strong>%orderdetails%</strong></div>\r\n\r\n<div class=\"table-responsive\">&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<hr />\r\n<div class=\"row\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\"><strong>IMPORTANT INSTRUCTIONS : </strong>\r\n\r\n<h5># This is an electronic receipt so doesn&#39;t require any signature.</h5>\r\n\r\n<h5># All perticulars are listed Without Applying Any Taxes , so if any issue please contact us immediately.</h5>\r\n\r\n<h5># You can contact us between 10:am to 6:00 pm on all working days.</h5>\r\n</div>\r\n</div>\r\n</div>\r\n', 'completed'),
(6, 'TNT Cancelled ', '<div id=\"print-area\">\r\n<div class=\"pad-top font-big\">\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt=\"Top Notch Tyres Wholesale \" src=\"http://topnotchwholesale.co.uk/images/blogo.png\" /></td>\r\n			<td style=\"text-align:right\"><strong>Top Notch Tyres Wholesale </strong><br />\r\n			<strong>Call :</strong>0207 018 7717<br />\r\n			<strong>Address:</strong> 1 Allum way , Tottridge London N20 9QP<br />\r\n			<strong>VAT NO: 176 0733 03 Company No: 08750170</strong></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n\r\n<div class=\"row text-center topbottomborder\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\" style=\"text-align: center;\">This is an electronic generated receipt , for any issues please contact &nbsp;<strong> info@topnotchwholesale.co.uk </strong></div>\r\n</div>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<h3><strong>Client Details:</strong></h3>\r\n\r\n			<p><strong>%displayname%</strong><br />\r\n			<strong>Email: </strong>%email%<br />\r\n			<strong>Call: </strong>%phone_no%<br />\r\n			%address%<br />\r\n			%postcode%</p>\r\n			</td>\r\n			<td>\r\n			<h3 style=\"text-align:right\"><strong>Order Details:</strong></h3>\r\n\r\n			<p style=\"text-align:right\"><strong>Order No: %orderno%</strong><br />\r\n			<strong>Order On: %orderdate%</strong><br />\r\n			<strong>Order Status : %orderstatus%&nbsp;</strong></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n&nbsp;\r\n\r\n<h3><strong>Order Products</strong></h3>\r\n\r\n<div class=\"row\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\">\r\n<div class=\"table-responsive\"><strong>%orderdetails%</strong></div>\r\n\r\n<div class=\"table-responsive\">&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<hr />\r\n<div class=\"row\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\"><strong>IMPORTANT INSTRUCTIONS : </strong>\r\n\r\n<h5># This is an electronic receipt so doesn&#39;t require any signature.</h5>\r\n\r\n<h5># All perticulars are listed Without Applying Any Taxes , so if any issue please contact us immediately.</h5>\r\n\r\n<h5># You can contact us between 10:am to 6:00 pm on all working days.</h5>\r\n</div>\r\n</div>\r\n</div>\r\n', 'cancelled'),
(7, 'Account statement', '<p><strong>Dear %displayname%,</strong><strong>&nbsp;</strong></p>\r\n\r\n<p><strong>%statement%</strong></p>\r\n', 'account-statement'),
(8, 'Outstanding ', '<div id=\"print-area\">\r\n<div class=\"pad-top font-big\">\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt=\"Top Notch Tyres Wholesale \" src=\"http://topnotchwholesale.co.uk/images/blogo.png\" /></td>\r\n			<td style=\"text-align:right\"><strong>Top Notch Tyres Wholesale </strong><br />\r\n			<strong>Call :</strong>0207 018 7717<br />\r\n			<strong>Address:</strong> 1 Allum way , Tottridge London N20 9QP<br />\r\n			<strong>VAT NO: 176 0733 03 Company No: 08750170</strong></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n\r\n<div class=\"row text-center topbottomborder\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\" style=\"text-align: center;\">This is an electronic generated receipt , for any issues please contact &nbsp;<strong> info@topnotchwholesale.co.uk </strong></div>\r\n</div>\r\n\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<h3><strong>Client Details:</strong></h3>\r\n\r\n			<p><strong>%displayname%</strong><br />\r\n			<strong>Email: </strong>%email%<br />\r\n			<strong>Call: </strong>%phone_no%<br />\r\n			%address%<br />\r\n			%postcode%</p>\r\n			</td>\r\n			<td>\r\n			<h3 style=\"text-align:right\"><strong>Order Details:</strong></h3>\r\n\r\n			<p style=\"text-align:right\"><strong>Order No: %orderno%</strong><br />\r\n			<strong>Order On: %orderdate%</strong><br />\r\n			<strong>Order Status : %orderstatus%&nbsp;</strong></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n&nbsp;\r\n\r\n<h3><strong>Order Products</strong></h3>\r\n\r\n<div class=\"row\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\">\r\n<div class=\"table-responsive\"><strong>%orderdetails%</strong></div>\r\n\r\n<div class=\"table-responsive\">&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<hr />\r\n<div class=\"row\">\r\n<div class=\"col-lg-12 col-md-12 col-sm-12\"><strong>IMPORTANT INSTRUCTIONS : </strong>\r\n\r\n<h5># This is an electronic receipt so doesn&#39;t require any signature.</h5>\r\n\r\n<h5># All perticulars are listed Without Applying Any Taxes , so if any issue please contact us immediately.</h5>\r\n\r\n<h5># You can contact us between 10:am to 6:00 pm on all working days.</h5>\r\n</div>\r\n</div>\r\n</div>\r\n', 'outstanding'),
(9, 'New Company', 'Company', 'new_company');

-- --------------------------------------------------------

--
-- Table structure for table `vs_google_analytic`
--

CREATE TABLE `vs_google_analytic` (
  `id` int(11) NOT NULL DEFAULT 0,
  `analytic_code` text NOT NULL,
  `seo_code` text NOT NULL,
  `seo_code1` text NOT NULL,
  `seo_code2` text NOT NULL,
  `domain_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_google_analytic`
--

INSERT INTO `vs_google_analytic` (`id`, `analytic_code`, `seo_code`, `seo_code1`, `seo_code2`, `domain_id`) VALUES
(1, '<script>\r\n  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){\r\n  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\r\n  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\r\n  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');\r\n\r\n  ga(\'create\', \'UA-64129530-1\', \'auto\');\r\n  ga(\'send\', \'pageview\');\r\n\r\n</script>', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vs_menus`
--

CREATE TABLE `vs_menus` (
  `menu_id` int(6) NOT NULL,
  `menu_lable` varchar(100) NOT NULL,
  `menu_action` varchar(100) NOT NULL,
  `parent_id` int(6) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A',
  `icon` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_menus`
--

INSERT INTO `vs_menus` (`menu_id`, `menu_lable`, `menu_action`, `parent_id`, `status`, `icon`, `sort`) VALUES
(1, 'Administration', '', 0, 'A', 'fas fa-users-cog', 1),
(2, 'Message Template', 'message-template', 1, 'A', 'far fa-circle', 0),
(3, 'Email Template', 'email-template', 1, 'A', 'far fa-circle', 0),
(4, 'Content Management', 'content-management', 1, 'A', 'far fa-circle', 0),
(6, 'Categories', 'category', 24, 'A', 'far fa-circle', 1),
(11, 'Product & Services', '', 0, 'A', ' icon-support', 3),
(12, 'Products', 'products', 24, 'A', 'far fa-circle', 3),
(13, 'Customers', 'customers', 0, 'A', ' icon-user-following', 4),
(14, 'Manage Orders', '', 0, 'A', 'icon-layers', 2),
(15, 'Products', 'products', 0, 'A', 'fab fa-product-hunt', 1),
(16, 'Accessories', 'accessories', 11, 'A', ' icon-globe-alt', 11),
(17, 'Users', 'users', 0, 'A', 'far fa-user', 12),
(18, 'Services', 'services', 11, 'A', ' icon-layers', 3),
(19, 'All Orders', 'orders', 14, 'A', 'icon-grid', 1),
(20, 'My Bids', 'bids', 0, 'A', 'fas fa-gavel', 2),
(21, 'Sales - Customer', 'sales', 20, 'A', ' icon-calculator', 1),
(22, 'Sales - Product', 'sales-product', 20, 'A', ' icon-calculator', 2),
(24, 'PDM', '', 0, 'A', 'fab fa-product-hunt', 3),
(26, 'Cashup', 'b-cashup', 0, 'A', 'fas fa-cash-register', 1),
(27, 'Deposit', 'deposit', 0, 'A', 'fab fa-deploydog', 2),
(28, 'Stock Update', 'stock-update', 0, 'A', 'fas fa-boxes', 3),
(29, 'Purchase', 'new-purchase', 0, 'A', 'fas fa-warehouse', 4),
(30, 'Dues-in', 'dues-in', 0, 'A', 'fas fa-indent', 5),
(31, 'Sale', 'new-order', 0, 'A', 'fas fa-check-circle', 6),
(32, 'Product & Services', '', 0, 'A', 'fab fa-product-hunt', 7),
(33, 'Products', 'products', 32, 'A', 'far fa-circle', 1),
(34, 'services', 'Services', 32, 'A', 'far fa-circle', 2),
(35, 'Parts', 'parts', 32, 'A', 'far fa-circle', 3),
(36, 'Open Bids', 'open-bids', 0, 'A', 'fas fa-box-open', 1),
(37, 'My Wins', 'wins', 0, 'A', 'fas fa-trophy', 3),
(38, 'Time-over Bids', 'timeover-bids', 0, 'A', 'fas fa-stopwatch', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vs_msg_manage`
--

CREATE TABLE `vs_msg_manage` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_msg_manage`
--

INSERT INTO `vs_msg_manage` (`id`, `title`, `message`, `type`) VALUES
(1, 'Unauthorized access  ', 'Unauthorized access', 'unauthorizedaccess'),
(2, 'Unknown Error', '<p>&nbsp;There is some error in our system! Please try again later</p>\r\n', 'error'),
(3, 'Invalid User', 'Your user is currently inactive please contact system administrator!\r\n', 'inactiveuser'),
(4, 'Contact Us', '<p>Thank you for contacting &nbsp;Autoblock&nbsp;. One of our friendly members of staff will contact you shortly to help you with your enquiry.</p>\r\n', 'contact_us'),
(5, 'Logout', 'You are logout successfully.........', 'logout'),
(6, 'new record added', 'new record added', 'add'),
(7, 'record updated', 'record updated', 'update'),
(8, 'changepassword', 'changepassword', 'changepassword'),
(9, 'changepassword_error', 'changepassword_error', 'changepassword_error'),
(10, 'invalid_current_password', 'invalid_current_password', 'invalid_current_password'),
(11, 'add_update_error', 'add_update_error', 'add_update_error'),
(12, 'status_update', 'status_update', 'status_update'),
(13, 'status_update_error', 'status_update_error', 'status_update_error'),
(14, 'delete', 'delete', 'delete'),
(15, 'delete_error', 'delete_error', 'delete_error'),
(16, 'emailupdateerror', 'emailupdateerror', 'emailupdateerror'),
(17, 'No Record found', 'No Record Found', 'norecordfound'),
(18, 'Password Reset', 'User password updated successfully. Default password are VS12345', 'password_reset'),
(19, 'password_reset_error', 'There are some error in password resetting.', 'password_reset_error'),
(20, 'purchase_order_received', 'purchase_order_received', 'purchase_order_received');

-- --------------------------------------------------------

--
-- Table structure for table `vs_pagecontent`
--

CREATE TABLE `vs_pagecontent` (
  `id` int(6) NOT NULL,
  `pagename` varchar(100) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_heading` varchar(250) NOT NULL,
  `page_subheading` varchar(250) NOT NULL,
  `meta_keyword` longtext DEFAULT NULL,
  `meta_phrase` longtext DEFAULT NULL,
  `meta_description` longtext DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_pagecontent`
--

INSERT INTO `vs_pagecontent` (`id`, `pagename`, `page_title`, `page_heading`, `page_subheading`, `meta_keyword`, `meta_phrase`, `meta_description`, `status`) VALUES
(1, 'login', 'login', '', '', NULL, NULL, NULL, 'A'),
(2, 'dashboard', 'dashboard', '', '', NULL, NULL, NULL, 'A'),
(3, 'my-profile', 'my-profile', '', '', NULL, NULL, NULL, 'A'),
(4, 'content-management', 'Content Management        ', 'Content Management        ', 'Content Management        ', 'Content Management ', 'Content Management ', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.&nbsp;', 'A'),
(5, 'message-template', 'Message Template ', 'Message Template ', 'Message Template ', 'Message Template ', 'Message Template ', 'Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry.', 'A'),
(6, 'email-template', 'Email Template ', 'Email Template ', 'Email Template ', 'Email Template ', 'Email Template ', 'Email Template&nbsp;', 'A'),
(7, 'error', ' 404 Error ', 'Oops! You\'re lost. ', '404 ', ' 404 Error', ' 404 Error', 'We can not find the page you\'re looking for.&nbsp;', 'A'),
(8, 'brands', 'brands', '', '', NULL, NULL, NULL, 'A'),
(9, 'category', 'category', '', '', NULL, NULL, NULL, 'A'),
(10, 'package', 'package', '', '', NULL, NULL, NULL, 'A'),
(11, 'company', 'company', 'Company', '', 'company', 'company', '', 'A'),
(12, 'comp-invoice', 'comp-invoice', '', '', NULL, NULL, NULL, 'A'),
(13, 'products', 'products', 'products', 'products', 'products', NULL, NULL, 'A'),
(14, 'customers', 'customers', 'customers', 'customers', 'customers', NULL, NULL, 'A'),
(15, 'new-order', 'new-order', 'new-order', 'new-order', 'new-order', NULL, NULL, 'A'),
(16, 'parts', 'parts', 'parts', '', 'accessories', NULL, NULL, 'A'),
(17, 'users', 'users', 'users', 'users', 'users', 'users', NULL, 'A'),
(18, 'services', 'services', 'services', 'services', NULL, NULL, NULL, 'A'),
(19, 'branch', 'branch', 'branch', 'branch', 'branch', NULL, NULL, 'A'),
(20, 'tyrecat', 'tyrecat', 'Tyrecat', 'Import', NULL, NULL, NULL, 'A'),
(21, 'stock-update', 'stock-update', 'stock-update', 'stock-update', 'stock-update', 'stock-update', 'stock-update', 'A'),
(22, 'dues-in', 'dues-in', 'dues-in', 'dues-in', 'dues-in', NULL, NULL, 'A'),
(23, 'new-purchase', 'new-purchase', 'new-purchase', '', NULL, NULL, NULL, 'A'),
(24, 'index', 'Welcome to Vendue System', 'Welcome to Vendue System', '', 'Welcome to Vendue System', NULL, NULL, 'A'),
(25, 'bids', 'Bids', 'Bids', 'Bids', 'Bids', NULL, NULL, 'A'),
(26, 'open-bids', 'open-bids', 'open-bids', '', NULL, NULL, NULL, 'A'),
(49, 'wins', 'wins', 'wins', '', NULL, NULL, NULL, 'A'),
(50, 'timeover-bids', 'timeover-bids', 'timeover-bids', '', NULL, NULL, NULL, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `vs_payment`
--

CREATE TABLE `vs_payment` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `winner_id` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Address` varchar(250) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vs_payment`
--

INSERT INTO `vs_payment` (`id`, `product_id`, `winner_id`, `Name`, `Address`, `amount`, `status`, `date`) VALUES
(1, 1, 14, 'ss', 'ss', 10, 'Paid', '2020-08-16');

-- --------------------------------------------------------

--
-- Table structure for table `vs_product`
--

CREATE TABLE `vs_product` (
  `id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bid_start_price` int(11) NOT NULL,
  `bid_winner_price` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `winner_id` int(11) NOT NULL,
  `valid_till` datetime NOT NULL,
  `win_date` datetime NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'A',
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vs_product`
--

INSERT INTO `vs_product` (`id`, `title`, `description`, `cat_id`, `user_id`, `bid_start_price`, `bid_winner_price`, `bid_id`, `winner_id`, `valid_till`, `win_date`, `status`, `created_on`) VALUES
(1, 'dsfsdf', 'sdfsdf', 1, 9, 44, 10, 1, 14, '2020-08-14 11:45:51', '2020-08-16 20:50:39', 'A', '2020-08-05 11:18:51'),
(2, 'dsfsdf', 'sdfsdf', 1, 9, 44, 0, 0, 0, '2020-08-18 11:45:51', '0000-00-00 00:00:00', 'A', '2020-08-05 11:18:51'),
(3, 'dsfsdf', 'sdfsdf', 1, 9, 44, 0, 0, 0, '2020-08-18 11:45:51', '0000-00-00 00:00:00', 'A', '2020-08-05 11:18:51'),
(4, 'dsfsdf', 'sdfsdf', 1, 9, 44, 0, 0, 0, '2020-08-18 11:45:51', '0000-00-00 00:00:00', 'A', '2020-08-05 11:18:51'),
(5, 'dsfsdf', 'sdfsdf', 1, 9, 44, 0, 0, 0, '2020-08-18 11:45:51', '0000-00-00 00:00:00', 'A', '2020-08-05 11:18:51');

-- --------------------------------------------------------

--
-- Table structure for table `vs_product_img`
--

CREATE TABLE `vs_product_img` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vs_product_img`
--

INSERT INTO `vs_product_img` (`id`, `product_id`, `image`) VALUES
(1, 1, 'uploads/product/1597144373boxed-bg.jpg'),
(2, 1, 'uploads/product/1597144373boxed-bg.png'),
(3, 1, 'uploads/product/1597144373default-150x150.png');

-- --------------------------------------------------------

--
-- Table structure for table `vs_roles`
--

CREATE TABLE `vs_roles` (
  `role_id` int(11) NOT NULL,
  `role_lable` varchar(150) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A',
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_roles`
--

INSERT INTO `vs_roles` (`role_id`, `role_lable`, `status`, `description`) VALUES
(1, 'System Administrator', 'A', 'Only can see new order, us seen, unseen cancelled, outstanding, today order and pending assign'),
(2, 'Seller', 'A', 'Seller '),
(3, 'Buyer', 'A', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vs_roles_menus`
--

CREATE TABLE `vs_roles_menus` (
  `rolemenu_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_roles_menus`
--

INSERT INTO `vs_roles_menus` (`rolemenu_id`, `role_id`, `menu_id`, `status`) VALUES
(2, 1, 12, 'A'),
(13, 1, 1, 'A'),
(14, 1, 2, 'A'),
(15, 1, 3, 'A'),
(16, 1, 4, 'A'),
(17, 1, 5, 'A'),
(18, 1, 6, 'A'),
(19, 1, 7, 'A'),
(20, 1, 8, 'A'),
(21, 1, 9, 'A'),
(22, 1, 10, 'A'),
(23, 1, 17, 'A'),
(24, 1, 23, 'A'),
(25, 1, 24, 'A'),
(26, 1, 25, 'A'),
(38, 3, 20, 'A'),
(39, 2, 15, 'A'),
(40, 3, 36, 'A'),
(41, 3, 37, 'A'),
(42, 1, 38, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `vs_seometatags`
--

CREATE TABLE `vs_seometatags` (
  `tag_id` int(11) NOT NULL DEFAULT 0,
  `classification` text NOT NULL,
  `robots` text NOT NULL,
  `google_site_verification` text NOT NULL,
  `language` text NOT NULL,
  `resource_type` text NOT NULL,
  `copyright` text NOT NULL,
  `author` text NOT NULL,
  `PICS_Label` text NOT NULL,
  `distribution` text NOT NULL,
  `coverage` text NOT NULL,
  `country` text NOT NULL,
  `location` text NOT NULL,
  `entry_by` int(11) NOT NULL,
  `entry_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `domain_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_seometatags`
--

INSERT INTO `vs_seometatags` (`tag_id`, `classification`, `robots`, `google_site_verification`, `language`, `resource_type`, `copyright`, `author`, `PICS_Label`, `distribution`, `coverage`, `country`, `location`, `entry_by`, `entry_date`, `modified_date`, `modified_by`, `domain_id`) VALUES
(1, '', 'index.php', '', '', '', '', '', '', '', 'WorldWide', 'united kingdom', 'united kingdom', 1, '2012-02-21 23:33:07', '2015-08-04 16:38:23', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vs_users`
--

CREATE TABLE `vs_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'A',
  `role_id` int(11) NOT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT 0,
  `entryon` datetime NOT NULL,
  `entryby` int(11) NOT NULL,
  `updatedon` datetime NOT NULL,
  `updatedby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_users`
--

INSERT INTO `vs_users` (`id`, `name`, `email`, `password`, `status`, `role_id`, `flag`, `entryon`, `entryby`, `updatedon`, `updatedby`) VALUES
(1, 'System Administrators', 'superadmin', 'b03e2c3e9017d9d316ca8ec0be4601c682fbd809', 'A', 1, 1, '0000-00-00 00:00:00', 0, '2018-08-27 12:54:45', 1),
(9, 'AA Tyres', 'aatyres@gmail.com', '72143ca5e9c34caefc8204e1549940fb9c374c8c', 'A', 2, 0, '2020-07-20 16:36:11', 1, '0000-00-00 00:00:00', 0),
(10, 'Awan Tyres', 'shakeel.zafar@gmail.com', '17b5c80c444c141651ab41823e855c14de5a971e', 'A', 2, 0, '2020-07-20 18:30:31', 1, '0000-00-00 00:00:00', 0),
(12, 'london', 'london', '72143ca5e9c34caefc8204e1549940fb9c374c8c', 'A', 3, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(13, 'Star Tyres', 'star@gmail.com', '17b5c80c444c141651ab41823e855c14de5a971e', 'A', 3, 0, '2020-07-23 11:34:20', 1, '0000-00-00 00:00:00', 0),
(14, 'London Branch', 'slondon', '17b5c80c444c141651ab41823e855c14de5a971e', 'A', 3, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vs_bids`
--
ALTER TABLE `vs_bids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_category`
--
ALTER TABLE `vs_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_email_conf`
--
ALTER TABLE `vs_email_conf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_menus`
--
ALTER TABLE `vs_menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `vs_msg_manage`
--
ALTER TABLE `vs_msg_manage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `vs_pagecontent`
--
ALTER TABLE `vs_pagecontent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_payment`
--
ALTER TABLE `vs_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_product`
--
ALTER TABLE `vs_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_product_img`
--
ALTER TABLE `vs_product_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_roles`
--
ALTER TABLE `vs_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `vs_roles_menus`
--
ALTER TABLE `vs_roles_menus`
  ADD PRIMARY KEY (`rolemenu_id`);

--
-- Indexes for table `vs_users`
--
ALTER TABLE `vs_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vs_bids`
--
ALTER TABLE `vs_bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vs_category`
--
ALTER TABLE `vs_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vs_email_conf`
--
ALTER TABLE `vs_email_conf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vs_menus`
--
ALTER TABLE `vs_menus`
  MODIFY `menu_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `vs_msg_manage`
--
ALTER TABLE `vs_msg_manage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vs_pagecontent`
--
ALTER TABLE `vs_pagecontent`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `vs_payment`
--
ALTER TABLE `vs_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vs_product`
--
ALTER TABLE `vs_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vs_product_img`
--
ALTER TABLE `vs_product_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vs_roles`
--
ALTER TABLE `vs_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vs_roles_menus`
--
ALTER TABLE `vs_roles_menus`
  MODIFY `rolemenu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `vs_users`
--
ALTER TABLE `vs_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
