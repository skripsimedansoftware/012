<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><?php if ($user->role == 'admin') : ?>Administrator<?php elseif ($user->role == 'dokter') : ?>Dokter<?php else : ?>Pasien<?php endif; ?><small>Beranda</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<?php if  ($this->session->has_userdata('admin')): ?>
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?= $this->user->dokter() ?></h3>
					<p>Dokter</p>
				</div>
				<div class="icon">
					<i class="fa fa-user-md"></i>
				</div>
				<a href="<?= base_url($this->router->fetch_class().'/dokter') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?= $this->user->pasien() ?></h3>
					<p>Pasien</p>
				</div>
				<div class="icon">
					<i class="fa fa-wheelchair"></i>
				</div>
				<a href="<?= base_url($this->router->fetch_class().'/pasien') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?= $this->jadwal->count(array('status' => 'dijadwalkan')) ?></h3>
					<p>Jadwal Praktek</p>
				</div>
				<div class="icon">
					<i class="fa fa-stethoscope"></i>
				</div>
				<a href="<?= base_url($this->router->fetch_class().'/jadwal') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?= $this->user->pasien_baru() ?></h3>
					<p>Pendaftaran Baru</p>
				</div>
				<div class="icon">
					<i class="fa fa-user-plus"></i>
				</div>
				<a href="<?= base_url($this->router->fetch_class().'/pasien') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
	</div>
	<?php elseif  ($this->session->has_userdata('dokter')): ?>
	<?php else: ?>
	<?php endif; ?>
	<!-- Small boxes (Stat box) -->
	<!-- /.row -->
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Selamat Datang Di <?= $this->config->item('app_name'); ?></h3>
		</div>
		<div class="box-body">
			<img src="<?= base_url('LOGO-BNN.png') ?>" width="120">
			<p>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</p>
		</div>
	</div>
</section>
