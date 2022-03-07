<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>plugins/iCheck/square/blue.css">
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
	<style type="text/css">
		.help-block.error {
			color: red;
		}

		.col-xs-12, .sign-up-btn {
			margin-top: 2%;
		}
	</style>
</head>
<body class="hold-transition login-page" style="margin-bottom: 2%; border: 1px solid #d2d6de;">
<div class="login-box">
	<div class="login-logo">
		<a href="<?php echo base_url() ?>"><img src="<?= base_url('LOGO-BNN.png') ?>" height="200"></a>
		<br>
		<a href="<?php echo base_url() ?>">Welcome to <b><?= $this->config->item('app_name') ?></b></a>
	</div>
	<div class="login-box-body">
		<p class="login-box-msg">Masuk untuk memulai sesi anda</p>
		<?php
		if ($this->session->has_userdata('login'))
		{
			?>
			<div class="alert alert-danger alert-dismissible" role="alert"><?php echo $this->session->userdata('login')['message']; ?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
			<?php
		}

		if ($this->session->has_userdata('register'))
		{
			?>
			<div class="alert alert-success alert-dismissible" role="alert"><?php echo $this->session->userdata('register')['message']; ?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
			<?php
		}
		?>
		<form action="<?php echo base_url($this->router->fetch_class().'/login') ?>" method="post">
			<div class="form-group has-feedback">
				<input type="text" class="form-control" placeholder="Email / Nama Pengguna" name="identity" value="<?php echo set_value('identity') ?>">
				<span class="fa fa-user form-control-feedback"></span>
				<?php echo form_error('identity', '<span class="help-block error">', '</span>'); ?>
			</div>
			<div class="form-group has-feedback">
				<input type="password" class="form-control" placeholder="Kata Sandi" name="password">
				<span class="fa fa-lock form-control-feedback"></span>
				<?php echo form_error('password', '<span class="help-block error">', '</span>'); ?>
			</div>
			<div class="row" style="margin-top: -4%;">
				<div class="col-lg-6 col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Masuk <i class="fa fa-sign-in"></i></button>
				</div>
				<div class="col-lg-6 col-xs-12">
					<a href="<?php echo base_url('web/register') ?>" class="btn btn-default btn-block btn-flat"><i class="fa fa-users"></i> Mendaftar</a>
				</div>
			</div>
		</form>
		<br>
		<a href="<?php echo base_url() ?>" class="text-center"><i class="fa fa-arrow-left"></i> Beranda</a>
		<a href="<?php echo base_url('web/forgot_password') ?>" class="text-center pull-right"><i class="fa fa-lock"></i> Lupa Kata Sandi?</a>
	</div>
</div>

<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/adminlte/') ?>plugins/iCheck/icheck.min.js"></script>
</body>
</html>
