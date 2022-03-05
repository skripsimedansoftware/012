<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Data<small>Jadwal Praktek</small></h1>
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
			<?php if ($user->role == 'admin'): ?>
			<table class="table table-hover table-striped datatable">
				<thead>
					<th>No</th>
					<th>Pasien</th>
					<th>Dokter</th>
					<th>Waktu</th>
					<th>Catatan</th>
					<th>Status</th>
					<th>Opsi</th>
				</thead>
				<tbody>
					<?php foreach ($this->jadwal->read()->result() as $key => $data) : ?>
					<tr>
						<td><?= $key+1 ?></td>
						<td><?= $this->user->read(array('id' => $data->pasien))->row()->full_name ?></td>
						<td><?= $this->user->read(array('id' => $data->dokter))->row()->full_name ?></td>
						<td><?= nice_date($data->waktu, 'd-m-Y H:i A') ?></td>
						<td><?= $data->catatan ?></td>
						<td><?= ($data->status == 'dijadwalkan') ? '<a class="btn btn-xs btn-warning">Dijadwalkan</a>' : '<a class="btn btn-xs btn-success" href="'.base_url($this->router->fetch_class().'/print_report/'.$data->pasien).'">Lihat Laporan</a>' ?></td>
						<td>
							<?php
							if ($data->status !== 'dijadwalkan')
							{
								$rekam_medis = $this->rekam_medis->read(array('jadwal' => $data->id));
								if ($rekam_medis->num_rows() < 1)
								{
									echo '<a class="btn btn-xs btn-info" href="'.base_url($this->router->fetch_class().'/rekam_medis/add/'.$data->id).'">Buat Rekam Medis</a>';
								}
								else
								{
									echo '<a class="btn btn-xs btn-primary" href="'.base_url($this->router->fetch_class().'/rekam_medis/edit/'.$rekam_medis->row()->id).'">Sunting Rekam Medis</a>';
								}
							}
							else
							{
								echo '<a class="btn btn-xs btn-success" href="'.base_url($this->router->fetch_class().'/jadwal/done/'.$data->id).'">Selesaikan jadwal</a>';
							}
							?>
							<a href="<?= base_url($this->router->fetch_class().'/jadwal/edit/'.$data->id) ?>" class="btn btn-option btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
							<a href="<?= base_url($this->router->fetch_class().'/jadwal/delete/'.$data->id) ?>" class="btn btn-option btn-xs btn-danger"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php elseif ($user->role == 'dokter'): ?>
			<table class="table table-hover table-striped datatable">
				<thead>
					<th>No</th>
					<th>Pasien</th>
					<th>Dokter</th>
					<th>Waktu</th>
					<th>Catatan</th>
					<th>Status</th>
				</thead>
				<tbody>
					<?php foreach ($this->jadwal->read(array('dokter' => $user->id, 'status' => 'dijadwalkan'))->result() as $key => $data) : ?>
					<tr>
						<td><?= $key+1 ?></td>
						<td><?= $this->user->read(array('id' => $data->pasien))->row()->full_name ?></td>
						<td><?= $this->user->read(array('id' => $data->dokter))->row()->full_name ?></td>
						<td><?= nice_date($data->waktu, 'd-m-Y H:i A') ?></td>
						<td><?= $data->catatan ?></td>
						<td><?= ($data->status == 'dijadwalkan') ? '<a class="btn btn-xs btn-warning">Dijadwalkan</a>' : '<a class="btn btn-xs btn-success" href="'.base_url($this->router->fetch_class().'/print_report/'.$data->pasien).'">Lihat Laporan</a>' ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php elseif ($user->role == 'pasien'): ?>
			<table class="table table-hover table-striped datatable">
				<thead>
					<th>No</th>
					<th>Pasien</th>
					<th>Dokter</th>
					<th>Waktu</th>
					<th>Catatan</th>
					<th>Status</th>
				</thead>
				<tbody>
					<?php foreach ($this->jadwal->read(array('pasien' => $user->id))->result() as $key => $data) : ?>
					<tr>
						<td><?= $key+1 ?></td>
						<td><?= $this->user->read(array('id' => $data->pasien))->row()->full_name ?></td>
						<td><?= $this->user->read(array('id' => $data->dokter))->row()->full_name ?></td>
						<td><?= nice_date($data->waktu, 'd-m-Y H:i A') ?></td>
						<td><?= $data->catatan ?></td>
						<td><?= ($data->status == 'dijadwalkan') ? '<a class="btn btn-xs btn-warning">Dijadwalkan</a>' : '<a class="btn btn-xs btn-success" href="'.base_url($this->router->fetch_class().'/print_report/'.$data->pasien).'">Lihat Laporan</a>' ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
		</div>
		<div class="box-footer">
			<?php if ($user->role == 'admin'): ?>
			<a href="<?= base_url($this->router->fetch_class().'/jadwal/add') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Buat Jadwal</a>
			<?php endif; ?>
		</div>
	</div>
</section>
