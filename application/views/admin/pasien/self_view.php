<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Data<small>Pasien</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<?php if ($this->session->has_userdata('data_query')) : ?>
		<div class="alert alert-info">
			<?= $this->session->userdata('data_query'); ?>
		</div>
	<?php endif; ?>
	<div class="box">
		<div class="box-header with-border">
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-lg-6">
					<table class="table table-hover table-striped table-bordered">
						<tr>
							<td>Nama Pasien</td><td><?= $data->full_name ?></td>
						</tr>
						<tr>
							<td>Email</td><td><?= $data->email ?></td>
						</tr>
						<tr>
							<td>Nama Pengguna</td><td><?= $data->username ?></td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td><td><?= ($data->gender == 'male')?'Laki-laki':'Perempuan' ?></td>
						</tr>
						<tr>
							<td>Waktu Registrasi</td><td><?= (!empty($data->registration_time))?nice_date($data->registration_time, 'd-m-Y'):'-' ?></td>
						</tr>
						<tr>
							<td>Kontak</td><td><?= $data->phone ?></td>
						</tr>
						<tr>
							<td>Alamat</td><td><?= $data->address ?></td>
						</tr>
						<tr>
							<td>Status</td>
							<td>
							<?php if ($data->status == 'active'): ?>
								<button class=" btn btn-xs btn-success">Aktif</button>
							<?php else: ?>
								<button class=" btn btn-xs btn-danger">Non-Aktif</button>
							<?php endif; ?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<a href="<?= base_url($this->router->fetch_class()) ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
			<a href="<?= base_url($this->router->fetch_class().'/print_report/'.$data->id) ?>" class="btn btn-info"><i class="fa fa-print"></i> Cetak Laporan</a>
		</div>
	</div>
</section>
