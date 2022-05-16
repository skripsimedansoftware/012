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
				<div class="col-lg-4">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<th colspan="2" class="text-center">Informasi Akun</th>
						</thead>
						<tbody>
							<tr>
								<td>Email</td><td><?= $data->email ?></td>
							</tr>
							<tr>
								<td>Username</td><td><?= $data->username ?></td>
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
						</tbody>
					</table>
				</div>
				<div class="col-lg-4">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<th colspan="2" class="text-center">Informasi Pasien</th>
						</thead>
						<tbody>
							<?php if (!empty($data->identity_type)) : ?>
							<tr>
								<td><?= $data->identity_type ?></td><td><?= exists_value($data->identity_number) ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<td>Nama Pasien</td><td><?= $data->full_name ?></td>
							</tr>
							<tr>
								<td>Email</td><td><?= $data->email ?></td>
							</tr>
							<tr>
								<td>Username</td><td><?= $data->username ?></td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td><td><?= ($data->gender == 'male')?'Laki-laki':'Perempuan' ?></td>
							</tr>
							<?php if (!empty($data->birthplace)) : ?>
							<tr>
								<td>Tempat/Tanggal Lahir</td><td><?= $data->birthplace.' '.(!empty($data->birthdate) ? nice_date($data->birthdate, 'd-m-Y') : '') ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<td>Usia</td><td><?= exists_value($data->age) ?></td>
							</tr>
							<tr>
								<td>Golongan Darah</td><td><?= exists_value($data->blood) ?></td>
							</tr>
							<tr>
								<td>Profesi</td><td><?= exists_value($data->profession_type, '').' '.exists_value($data->profession_name, '') ?></td>
							</tr>
							<tr>
								<td>Status Pernikahan</td>
								<td>
								<?php
								switch ($data->marital_status)
								{
									case '1':
										echo 'Menikah';
									break;

									case '2':
										echo 'Belum Menikah';
									break;

									case '3':
										echo 'Duda';
									break;

									case '4':
										echo 'Janda';
									break;

									default:
										echo '-';
									break;
								}
								?>
								</td>
							</tr>
							<tr>
								<td>Alamat</td><td><?= exists_value($data->address) ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-lg-4">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<th colspan="2" class="text-center">Informasi Tambahan</th>
						</thead>
						<tbody>
							<tr>
								<td>Orangtua Laki-laki</td><td><?= exists_value($data->father_name) ?></td>
							</tr>
							<tr>
								<td>Orangtua Perempuan</td><td><?= exists_value($data->mother_name) ?></td>
							</tr>
							<tr>
								<td>Suku</td><td><?= exists_value($data->ethnic_group) ?></td>
							</tr>
							<tr>
								<td>Agama</td><td><?= !empty($data->religion) ? ucfirst($data->religion) : '-' ?></td>
							</tr>
							<tr>
								<td>Pendidikan</td><td><?= exists_value($data->education) ?></td>
							</tr>
							<tr>
								<td>Kasus Polisi</td><td><?= exists_value($data->police_case) == 1 ? 'Ya' : 'Tidak' ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<a href="<?= base_url($this->router->fetch_class()) ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
			<a href="<?= base_url($this->router->fetch_class().'/print_report/'.$data->id) ?>" class="btn btn-info"><i class="fa fa-print"></i> Cetak Laporan</a>
			<a href="<?= base_url($this->router->fetch_class().'/data_pasien/edit/'.$data->id) ?>" class="btn btn-primary pull-right"><i class="fa fa-edit"></i> Sunting Informasi</a>
		</div>
	</div>
</section>
