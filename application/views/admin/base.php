<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= $this->config->item('app_name') ?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?= base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/adminlte/') ?>bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/adminlte/') ?>bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/adminlte/') ?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/adminlte/') ?>dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/plugins/') ?>SweetAlert2/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/plugins/') ?>DataTables/datatables.min.css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- Google Font -->
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
	<style type="text/css">
	.help-block.error {
		color: red;
	}

	.user-panel > .image > img {
		width: 45px;
		height: 45px;
		/*height: auto;*/
	}

	.swal2-popup { font-size: 1.6rem !important; }
	</style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="sidebar-mini hold-transition skin-blue fixed">
<div class="wrapper">

	<!-- Main Header -->
	<header class="main-header">

		<!-- Logo -->
		<a href="<?= base_url() ?>" target="_blank" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini"><b>SRM</b></span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><b><?= strtoupper($user->role)  ?></b></span>
		</a>

		<!-- Header Navbar -->
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<!-- Navbar Right Menu -->
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<!-- User Account Menu -->
					<li class="dropdown user user-menu">
						<!-- Menu Toggle Button -->
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<!-- The user image in the navbar-->
							<img src="<?= (!empty($user->photo))?base_url('uploads/'.$user->photo):base_url('assets/adminlte/dist/img/user2-160x160.jpg') ?>" class="user-image" alt="User Image">
							<!-- hidden-xs hides the username on small devices so only the image appears. -->
							<span class="hidden-xs"><?= $user->full_name ?></span>
						</a>
						<ul class="dropdown-menu">
							<!-- The user image in the menu -->
							<li class="user-header">
								<img src="<?= (!empty($user->photo))?base_url('uploads/'.$user->photo):base_url('assets/adminlte/dist/img/user2-160x160.jpg') ?>" class="img-circle" alt="User Image">
								<p>
									<?= $user->full_name ?> - <?= strtoupper($user->role)  ?>
								</p>
							</li>
							<!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-left">
									<a href="<?= base_url($this->router->fetch_class().'/profile') ?>" class="btn btn-default btn-flat">Profil</a>
								</div>
								<div class="pull-right">
									<a href="<?= base_url($this->router->fetch_class().'/logout') ?>" class="btn btn-default btn-flat">Keluar</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">

		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">

			<!-- Sidebar user panel (optional) -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="<?= (!empty($user->photo))?base_url('uploads/'.$user->photo):base_url('assets/adminlte/dist/img/user2-160x160.jpg') ?>" class="img-circle" alt="User Image" style="max-height: 45px;">
				</div>
				<div class="pull-left info">
					<p><?= $user->full_name ?></p>
					<!-- Status -->
					<a href="#"><i class="fa fa-circle text-success"></i> online</a>
				</div>
			</div>

			<!-- Sidebar Menu -->
			<ul class="sidebar-menu" data-widget="tree">
				<li class="header">MENU</li>
				<!-- Optionally, you can add icons to the links -->
				<li class="<?= $this->router->fetch_method() == 'index'?'active':'' ?>"><a href="<?= base_url($this->router->fetch_class()) ?>"><i class="fa fa-home"></i> <span>Beranda</span></a></li>
				<?php if  ($user->role == 'admin'): ?>
				<li class="<?= $this->router->fetch_method() == 'dokter'?'active':'' ?>"><a href="<?= base_url($this->router->fetch_class().'/dokter') ?>"><i class="fa fa-user-md"></i> <span>Dokter</span></a></li>
				<li class="<?= $this->router->fetch_method() == 'pasien'?'active':'' ?>"><a href="<?= base_url($this->router->fetch_class().'/pasien') ?>"><i class="fa fa-wheelchair"></i> <span>Pasien</span></a></li>
				<li class="<?= $this->router->fetch_method() == 'jadwal'?'active':'' ?>"><a href="<?= base_url($this->router->fetch_class().'/jadwal') ?>"><i class="fa fa-stethoscope"></i> <span>Jadwal Praktik</span></a></li>
				<?php elseif  ($user->role == 'dokter'): ?>
				<li class="<?= $this->router->fetch_method() == 'jadwal'?'active':'' ?>"><a href="<?= base_url($this->router->fetch_class().'/jadwal') ?>"><i class="fa fa-stethoscope"></i> <span>Jadwal Praktik</span></a></li>
				<?php else: ?>
				<li class="<?= $this->router->fetch_method() == 'jadwal'?'active':'' ?>"><a href="<?= base_url($this->router->fetch_class().'/jadwal') ?>"><i class="fa fa-stethoscope"></i> <span>Jadwal Check-Up</span></a></li>
				<li class="<?= $this->router->fetch_method() == 'data_pasien'?'active':'' ?>"><a href="<?= base_url($this->router->fetch_class().'/data_pasien') ?>"><i class="fa fa-wheelchair"></i> <span>Data Pasien</span></a></li>
				<?php endif; ?>
			</ul>
			<!-- /.sidebar-menu -->
		</section>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<?= $page ?>
	</div>
	<!-- /.content-wrapper -->

	<!-- Main Footer -->
	<footer class="main-footer">
		<!-- To the right -->
		<div class="pull-right hidden-xs">
			<?= $this->config->item('app_user'); ?>
		</div>
		<!-- Default to the left -->
		<strong>Copyright &copy; <?= date('Y') ?> <a href="#"><?= $this->config->item('app_name'); ?></a>.</strong> All rights reserved.
	</footer>

	<!-- /.control-sidebar -->
	<!-- Add the sidebar's background. This div must be placed
	immediately after the control sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="<?= base_url('assets/adminlte/') ?>bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- JQuery InputMask -->
<script src="<?= base_url('assets/adminlte/') ?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?= base_url('assets/adminlte/') ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?= base_url('assets/adminlte/') ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>

<!-- SweetAlert2 -->
<script src="<?= base_url('assets/plugins/') ?>SweetAlert2/dist/sweetalert2.all.min.js"></script>

<script src="<?= base_url('assets/plugins/') ?>jQuery-Mask/dist/jquery.mask.min.js"></script>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/') ?>DataTables/datatables.min.js"></script>

<!-- AdminLTE App -->
<script src="<?= base_url('assets/adminlte/') ?>dist/js/adminlte.min.js"></script>

<script type="text/javascript">
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#profile-upload-preview').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

$('.datatable').DataTable();
$('.datemask').inputmask({
	placeholder: "dd/mm/yyyy hh:mm",
	alias: "datetime",
	hourFormat: "24"
});

$('.dateonly').inputmask({
	placeholder: "dd/mm/yyyy",
	alias: "date"
});

$('select[name="sender"]').on('change', function() {
	if (this.value !== 'voluntary') {
		$('.sender_name').removeClass('hidden');
	} else {
		$('.sender_name').addClass('hidden');
	}
});
</script>
</body>
</html>
