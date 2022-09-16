<?php 
ob_start();
session_start();
include(__DIR__ . "/config.php");

if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}
// allow only for owner
if(!empty($_SESSION['login_type']) && (int)$_SESSION['login_type'] != 2){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
//

$image = WEB_URL . 'img/no_image.jpg';	
if(isset($_SESSION['objLogin']['image'])){
	if(file_exists(ROOT_PATH . '/img/upload/' . $_SESSION['objLogin']['image']) && $_SESSION['objLogin']['image'] != ''){
		$image = WEB_URL . 'img/upload/' . $_SESSION['objLogin']['image'];
	}
}
//
include(ROOT_PATH.'partial/report_top_common_header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_left_menu.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
include(ROOT_PATH.'library/helper.php');
include(ROOT_PATH."library/encryption.php");
//instance 
$ams_helper = new ams_helper();
$converter = new Encryption;
$page_name = $ams_helper->curPageUrlInfo('page');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $building_name; ?></title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<?php include(ROOT_PATH.'/partial/header_script.php'); ?>
</head>
<body class="skin-yellow sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
<header class="main-header">
  <!-- Logo -->
  <a href="#" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini"><i class="fa fa-bank"></i></span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg" style="text-transform:uppercase;font-weight:bold;overflow:hidden;"><i class="fa fa-bank"></i> <?php echo $building_name; ?> </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <ul class="dropdown-menu">
          <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
              <li>
                <!-- start message -->
                <a href="#">
                <div class="pull-left"> <img src="<?php echo $image; ?>" class="img-circle" alt="User Image"/> </div>
                </a> </li>
              <!-- end message -->
            </ul>
          </li>
          <li class="footer"><a href="#"></a></li>
        </ul>
        </li>
        <!-- Notifications: style can be found in dropdown.less -->
        <ul class="dropdown-menu">
          <li class="header"></li>
          <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
              <li></li>
            </ul>
          </li>
          <li class="footer"><a href="#">View all</a></li>
        </ul>
        </li>
        <!-- Tasks: style can be found in dropdown.less -->
        <ul class="dropdown-menu">
          <li class="header"></li>
          <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
              <li>
                <!-- Task item -->
                <a href="#">
                <h3> Design some buttons <small class="pull-right">20%</small> </h3>
                <div class="progress xs">
                  <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"> <span class="sr-only">20% Complete</span> </div>
                </div>
                </a> </li>
              <!-- end task item -->
            </ul>
          </li>
          <li class="footer"> <a href="#">View all tasks</a> </li>
        </ul>
        </li>
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img class="user-image" src="<?php echo !empty($image) ? $image : WEB_URL.'img/no_image.jpg'; ?>" class="img-circle" alt="User Image" /> <span class="hidden-xs">
          <?php echo $_SESSION['objLogin']['o_name']; ?>
          </span> </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header"> <img src="<?php echo !empty($image) ? $image : WEB_URL.'img/no_image.jpg'; ?>" class="img-circle" alt="User Image" />
              <p>
                <?php echo $_SESSION['objLogin']['o_name']; ?>
                <small>
                <?php if($_SESSION['login_type'] == '1'){echo $_data['user_admin'];} else if($_SESSION['login_type'] == '2'){echo $_data['user_owner'];}?>
                <br/><?php echo $_SESSION['objLogin']['branch_name']; ?></small> </p>
            </li>
            <!-- Menu Body -->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left"><a data-target="#user_profile" data-toggle="modal" class="btn btn-success btn-flat">Profile</a></div>
              <div class="pull-right"> <a href="<?php echo WEB_URL; ?>logout.php" class="btn btn-danger btn-flat">Sign out</a> </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
<!-- =============================================== -->
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <div class="user-panel" style="background:#000;">
    <div class="pull-left image"> <img src="<?php echo $image; ?>" class="img-circle" alt="User Image"> </div>
    <div class="pull-left info">
      <p><?php echo $_SESSION['objLogin']['o_name']; ?></p>
      <a href="#"><i class="fa fa-circle text-success" style="color:#00a65a !important;"></i> <?php echo $_data['lang_online']; ?></a> </div>
  </div>
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="<?php if($page_name != '' && $page_name == 'o_dashboard'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>o_dashboard.php"><i class="fa fa-line-chart"></i> <span><?php echo $_data['text_1']; ?></span></a> </li>
       <li class="<?php if($page_name != '' && $page_name == 'unitdetails'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>o_dashboard/unitdetails.php"><i class="fa fa-server"></i> <span><?php echo $_data['text_2']; ?></span></a></li>
       <li class="<?php if($page_name != '' && $page_name == 'tenantdetails'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>o_dashboard/tenantdetails.php"><i class="fa fa-user-o"></i><span><?php echo $_data['text_3']; ?></span></a></li>
      <li class="<?php if($page_name != '' && $page_name == 'employeedetails'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>o_dashboard/employeedetails.php"><i class="fa fa-users"></i> <span><?php echo $_data['text_4']; ?></span></a></li>
	  <li class="<?php if($page_name != '' && $page_name == 'fairdetails'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>o_dashboard/fairdetails.php"><i class="fa fa-money"></i> <span><?php echo $_data['text_5']; ?></span></a></li>
	  <li class="<?php if($page_name != '' && $page_name == 'owner_utility_details'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>o_dashboard/owner_utility_details.php"><i class="fa fa-gear"></i> <span><?php echo $_data['text_6']; ?></span></a></li>
	  <li class="<?php if($page_name != '' && $page_name == 'maintenance_cost'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>o_dashboard/maintenance_cost.php"><i class="fa fa-wrench"></i> <span><?php echo $_data['text_7']; ?></span></a></li>
	   <li class="<?php if($page_name != '' && $page_name == 'fund_status'){echo 'active';}?>"><a target="_blank" href="<?php echo WEB_URL; ?>o_dashboard/fund_status.php"><i class="fa fa-money"></i> <span><?php echo $_data['text_8']; ?></span></a></li>
	   <li class="<?php if($page_name != '' && $page_name == 'complainlist'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>o_dashboard/complainlist.php"><i class="fa fa-gavel"></i> <span><?php echo $_data['text_88']; ?></span></a></li>
       <li class="<?php if($page_name != '' && $page_name == 'rented_report'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>o_dashboard/rented_report.php"><i class="fa fa-bar-chart"></i> <span><?php echo $_data['text_9']; ?></span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">



<!-- Add the sidebar's background. This div must be placed
 immediately after the control sidebar -->
<form id="updateprofile" action="<?php echo WEB_URL; ?>ajax/updateProfile.php" method="post">
  <div class="modal fade" role="dialog" id="user_profile" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel"><?php echo $_data['profile_update_title']; ?></h4>
        </div>
        <div class="modal-body">
          <?php 
			$image = WEB_URL . 'img/no_image.jpg';	
			if(isset($_SESSION['objLogin']['image'])){
				if(file_exists(ROOT_PATH . '/img/upload/' . $_SESSION['objLogin']['image']) && $_SESSION['objLogin']['image'] != ''){
					$image = WEB_URL . 'img/upload/' . $_SESSION['objLogin']['image'];
				}
			}
		  ?>
          <div align="center"><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
          <h4 align="center"><?php echo $_SESSION['objLogin']['o_name']; ?></h4>
          <h5 align="center"><?php echo $_data['user_owner']; ?></h5>
          <div class="form-group">
            <label class="control-label"><?php echo $_data['profile_update_name']; ?> :&nbsp;&nbsp;</label>
            <input type="text" class="form-control" id="txtProfileName" name="txtProfileName" value="<?php echo $_SESSION['objLogin']['o_name']; ?>">
          </div>
          <div class="form-group">
            <label class="control-label"><?php echo $_data['profile_update_email']; ?> :&nbsp;&nbsp;</label>
            <input type="text" class="form-control" id="txtProfileEmail" name="txtProfileEmail" value="<?php echo $_SESSION['objLogin']['o_email']; ?>">
          </div>
		  <div class="form-group">
            <label class="control-label"><?php echo $_data['profile_update_contact']; ?> :&nbsp;&nbsp;</label>
            <input type="text" class="form-control" id="txtProfileContact" name="txtProfileContact" value="<?php echo $_SESSION['objLogin']['o_contact']; ?>">
          </div>
          <div class="form-group">
            <label class="control-label"><?php echo $_data['profile_update_password']; ?> :&nbsp;&nbsp;</label>
            <input type="text" class="form-control" id="txtProfilePassword" name="txtProfilePassword" value="<?php echo $converter->decode($_SESSION['objLogin']['o_password']); ?>">
          </div>
          <div style="color:orange;font-weight:bold;text-align:left;font-size:15px;"><?php echo $_data['profile_update_information']; ?></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onClick="javascript:$('#updateprofile').submit();"><?php echo $_data['profile_update_button']; ?></button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <input type="hidden" name="user_id" value="<?php echo $_SESSION['objLogin']['ownid']; ?>" >
</form>
