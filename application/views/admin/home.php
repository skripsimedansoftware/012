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
			<center><img src="<?= base_url('LOGO-BNN.png') ?>" width="120"></center>
			<h2>Selamat Datang</h2>
			<p style="text-align:justify">Badan Narkotika Nasional Provinsi Sumatera Utara (BNNP-SU) adalah Lembaga Pemerintahan Non Kementrian (LPNK) yang mempunyai tugas&nbsp;pemerintahan di bidang pencegahan, pemberantasan, penyalahgunaan dan&nbsp;peredaran gelap narkoba kecuali bahan adiktif seperti tembakau dan alcohol. BNN dipimpin oleh seorang kepala yang bertanggung jawab langsung kepada presiden.</p>

			<p style="text-align:justify"><u>Visi</u><br />
			Menjadi Lembaga &nbsp;Non Kementerian yang profesional dan mampu menggerakkan seluruh koponen masyarakat, bangsa dan negara Indonesia dalam melaksanakan Pencegahan dan Pemberantasan Penyalahgunaan dan Peredaran Gelap Narkotika, Psikotropika, Prekursor dan Bahan Adiktif Lainnya di Indonesia.</p>

			<p><u>Misi</u></p>

			<ol>
				<li>Menyusun kebijakan nasional P4GN</li>
				<li>Melaksanakan operasional P4GN sesuai bidang tugas &nbsp; dan kewenangannya.</li>
				<li>Mengkoordinasikan pencegahan dan pemberantasan penyalahgunaan dan peredaran gelap narkotika, psikotropika, prekursor dan bahan adiktif lainnya (narkoba)</li>
				<li>Memonitor dan mengendalikan pelaksanaan kebijakan nasional P4GN.</li>
				<li>Menyusun laporan pelaksanaan kebijakan nasional P4GN dan diserahkan kepada Presiden.</li>
			</ol>
		</div>
	</div>
</section>
