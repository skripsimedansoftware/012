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
			<table class="table table-hover table-striped datatable">
				<thead>
					<th>No</th>
					<th>Nama Lengkap</th>
					<th>Jenis Kelamin</th>
					<th>Usia</th>
					<th>Status</th>
					<th>Opsi</th>
				</thead>
				<tbody>
					<?php foreach ($this->user->read(array('role' => 'pasien'))->result() as $key => $data) : ?>
					<tr>
						<td><?= $key+1 ?></td>
						<td><?= $data->full_name ?></td>
						<td><?= ($data->gender == 'male')?'Laki-laki':'Perempuan' ?></td>
						<td><?= ((int) $data->age > 0)?$data->age:'-' ?></td>
						<td>
							<?php if ($data->status == 'active'): ?>
								<a href="<?= base_url($this->router->fetch_class().'/pasien/activate/'.$data->id.'?status=non-active') ?>" class=" btn btn-xs btn-success">Aktif</a>
							<?php else: ?>
								<a href="<?= base_url($this->router->fetch_class().'/pasien/activate/'.$data->id.'?status=active') ?>" class=" btn btn-xs btn-danger">Non-Aktif</a>
							<?php endif; ?>
						</td>
						<td>
							<a href="<?= base_url($this->router->fetch_class().'/pasien/edit/'.$data->id) ?>" class="btn btn-option btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
							<a href="<?= base_url($this->router->fetch_class().'/pasien/info/'.$data->id) ?>" class="btn btn-option btn-xs btn-info"><i class="fa fa-info-circle"></i></a>
							<a href="<?= base_url($this->router->fetch_class().'/pasien/delete/'.$data->id) ?>" class="btn btn-option btn-xs btn-danger"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="box-footer">
			<a href="<?= base_url($this->router->fetch_class().'/pasien/add') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
		</div>
	</div>
</section>
