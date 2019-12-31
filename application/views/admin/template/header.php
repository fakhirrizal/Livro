<?php
if(($this->session->userdata('id'))==NULL OR ($this->session->userdata('role_id'))!='1'){
            echo "<script>alert('Harap login terlebih dahulu')</script>";
            echo "<script>window.location='".base_url('Auth/logout')."'</script>";
        }
else{
?>
<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->

	<head>
		<meta charset="utf-8" />
		<title>Sistem Informasi - LIVRO Coffee Semarang</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<meta content="LIVRO Coffee" name="description" />
		<meta content="LIVRO Coffee" name="author" />
		<!-- BEGIN GLOBAL MANDATORY STYLES -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');?>" rel="stylesheet" type="text/css" />
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN THEME GLOBAL STYLES -->
		<link href="<?=base_url('assets/global/plugins/datatables/datatables.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/select2/css/select2.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/select2/css/select2-bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/cubeportfolio/css/cubeportfolio.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/ladda/ladda-themeless.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/css/components-md.min.css');?>" rel="stylesheet" id="style_components" type="text/css" />
		<link href="<?=base_url('assets/global/css/plugins-md.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/pages/css/blog.min.css');?>" rel="stylesheet" type="text/css" />
		<!-- END THEME GLOBAL STYLES -->
		<!-- BEGIN THEME LAYOUT STYLES -->
		<link href="<?=base_url('assets/layouts/layout3/css/layout.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/layouts/layout3/css/themes/default.min.css');?>" rel="stylesheet" type="text/css" id="style_color" />
		<link href="<?=base_url('assets/layouts/layout3/css/custom.min.css');?>" rel="stylesheet" type="text/css" />
		<!-- END THEME LAYOUT STYLES -->
		<link href="<?= site_url(); ?>assets/icon.png" rel="icon" type="image/x-icon">
	</head>
    <!-- END HEAD -->

		<body class="page-container-bg-solid page-md">
		<!-- BEGIN HEADER -->
		<div class="page-header">
			<!-- BEGIN HEADER TOP -->
			<div class="page-header-top">
				<div class="container">
					<!-- BEGIN LOGO -->
					<div id="logo" class="pull-left">
						<h4><img src="<?=base_url('assets/pages/img/logo.png');?>" width='30%'></h4>
					</div>
					<!-- END LOGO -->
					<!-- BEGIN RESPONSIVE MENU TOGGLER -->
					<a href="javascript:;" class="menu-toggler"></a>
					<!-- END RESPONSIVE MENU TOGGLER -->
					<!-- BEGIN TOP NAVIGATION MENU -->
					<div class="top-menu">
						<ul class="nav navbar-nav pull-right">
							<li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
								<?php
									// $q = "SELECT a.*,b.last_login,c.fullname,(SELECT COUNT(d.id) FROM user d WHERE d.role='radiografer' AND d.company_id=a.id AND d.deleted='0') AS jumlah_radiografer FROM company a LEFT JOIN admin_to_company b ON a.id=b.company_id LEFT JOIN user_profile c ON b.user_id=c.user_id WHERE a.deleted='0' AND b.user_id='".$this->session->userdata('id')."' AND b.deleted='0' AND c.deleted='0'";
									// $data_notif = $this->Main_model->manualQuery($q);
									$data_notif = 0;
								?>
								<a href="#" class="dropdown-toggle" title="Notifikasi">
									<i class="icon-bell"></i>
									<span class="badge badge-default"><?= count($data_notif); ?></span>
								</a>
								<ul class="dropdown-menu">
									<li class="external">
										<h3>Ada
											<strong><?= count($data_notif); ?></strong> pemberitahuan</h3>
										<a href="#">lihat semua</a>
									</li>
									<li>
										<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
											<?php
											// foreach ($data_notif as $key => $value) {
											?>
											<li>
												<a href="javascript:;">
													<span class="time">just now</span>
													<span class="details">
														<span class="label label-sm label-icon label-success">
															<i class="fa fa-user"></i>
														</span> <?= $value->fullname; ?> </span>
												</a>
											</li>
											<?php // } ?>
											<li>
												<a href="javascript:;">
													<span class="time">3 mins</span>
													<span class="details">
														<span class="label label-sm label-icon label-danger">
															<i class="fa fa-bolt"></i>
														</span> Server #12 overloaded. </span>
												</a>
											</li>
										</ul>
									</li>
								</ul>
							</li>
							<li class="droddown dropdown-separator">
								<span class="separator"></span>
							</li>
							<!-- BEGIN USER LOGIN DROPDOWN -->
							<li class="dropdown dropdown-user dropdown-dark">
								<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									<img alt="" class="img-circle" src="https://i-love-png.com/images/profile_png_1113533.png">
									<span class="username username-hide-mobile">Administrator</span>
								</a>
								<ul class="dropdown-menu dropdown-menu-default">
									<li>
										<a href="#!">
											<i class="icon-user"></i> Profil </a>
									</li>
									<li>
										<a href="<?php echo site_url('admin_side/bantuan'); ?>">
											<i class="icon-rocket"></i> Bantuan
											<!-- <span class="badge badge-success"> 7 </span> -->
										</a>
									</li>
									<li class="divider"> </li>
									<li>
										<a href="<?php echo site_url('Auth/logout'); ?>">
											<i class="icon-key"></i> Keluar </a>
									</li>
								</ul>
							</li>
							<!-- END USER LOGIN DROPDOWN -->
						</ul>
					</div>
					<!-- END TOP NAVIGATION MENU -->
				</div>
			</div>
			<!-- END HEADER TOP -->
			<!-- BEGIN HEADER MENU -->
			<div class="page-header-menu">
				<div class="container">
					<!-- BEGIN HEADER SEARCH BOX -->
					<form class="search-form" action="javascript:;" method="GET">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Cari" name="query">
							<span class="input-group-btn">
								<a href="javascript:;" class="btn submit">
									<i class="icon-magnifier"></i>
								</a>
							</span>
						</div>
					</form>
					<!-- END HEADER SEARCH BOX -->
					<!-- BEGIN MEGA MENU -->
					<div class="hor-menu  ">
						<ul class="nav navbar-nav">
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='home'){echo 'active';}else{echo '';} ?>">
								<a href="<?php echo site_url('admin_side/beranda'); ?>"><i class="icon-home"></i> Beranda
								</a>
							</li>
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='master'){echo 'active';}else{echo '';} ?>">
								<a href="javascript:;"><i class="icon-drawer"></i> Master
									<span class="arrow <?php if($parent=='master'){echo 'open';}else{echo '';} ?>"></span>
								</a>
								<ul class="dropdown-menu pull-left">
									<li class=" <?php if($child=='karyawan'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('admin_side/karyawan'); ?>" class="nav-link nav-toggle ">
											<i class="icon-user-following"></i> Data Karyawan
										</a>
									</li>
									<li class=" <?php if($child=='barang'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('admin_side/barang'); ?>" class="nav-link nav-toggle ">
											<i class="icon-layers"></i> Data Barang
										</a>
									</li>
								</ul>
							</li>
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='report'){echo 'active';}else{echo '';} ?>">
								<a href="javascript:;"><i class="icon-notebook"></i> Laporan
									<span class="arrow <?php if($parent=='report'){echo 'open';}else{echo '';} ?>"></span>
								</a>
								<ul class="dropdown-menu pull-left">
									<li class=" <?php if($child=='infus'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('admin_side/laporan_infus'); ?>" class="nav-link nav-toggle ">
											<i class="icon-action-redo"></i> Stok Infus
										</a>
									</li>
									<li class=" <?php if($child=='opname'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('admin_side/laporan_opname'); ?>" class="nav-link nav-toggle ">
											<i class="icon-action-undo"></i> Stok Opname
										</a>
									</li>
								</ul>
							</li>
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='log_activity'){echo 'active';}else{echo '';} ?>">
								<a href="<?php echo site_url('admin_side/log_activity'); ?>"><i class="fa fa-rss"></i> Log Aktifitas
								</a>
							</li>
						</ul>
					</div>
					<!-- END MEGA MENU -->
				</div>
			</div>
			<!-- END HEADER MENU -->
		</div>
		<!-- END HEADER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<!-- BEGIN CONTENT BODY -->
				<!-- BEGIN PAGE HEAD-->
				<div class="page-head">
					<div class="container">
						<!-- BEGIN PAGE TITLE -->
						<div class="page-title">
							<h1>Dashboard
								<small>Sistem Informasi</small>
							</h1>
						</div>
						<!-- END PAGE TITLE -->
						<!-- BEGIN PAGE TOOLBAR -->
						<div class="page-toolbar">
							<!-- BEGIN THEME PANEL -->
							<div class="btn-group btn-theme-panel">
								<script type="text/javascript">function startTime(){var today=new Date(),curr_hour=today.getHours(),curr_min=today.getMinutes(),curr_sec=today.getSeconds();curr_hour=checkTime(curr_hour);curr_min=checkTime(curr_min);curr_sec=checkTime(curr_sec);document.getElementById('clock').innerHTML=curr_hour+":"+curr_min+":"+curr_sec;}function checkTime(i){if(i<10){i="0"+i;}return i;}setInterval(startTime,500);</script>
								<span class="tanggalwaktu">
								<?= $this->Main_model->convert_hari(date('Y-m-d')).', '.$this->Main_model->convert_tanggal(date('Y-m-d')) ?>  -  Pukul  <span id="clock">13:53:45</span>
								</span>
							</div>
						</div>
						<!-- END PAGE TOOLBAR -->
					</div>
				</div>
				<!-- END PAGE HEAD-->
				<!-- BEGIN PAGE CONTENT BODY -->
				<div class="page-content">
					<div class="container">
						<!-- BEGIN PAGE BREADCRUMBS -->
<?php } ?>