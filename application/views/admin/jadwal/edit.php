<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Sunting Data<small>Jadwal Praktek</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="box">
		<div class="box-header with-border"></div>
		<form method="POST" action="<?= base_url($this->router->fetch_class().'/jadwal/edit/'.$data->id) ?>">
		<div class="box-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Pasien</label>
						<select class="form-control" name="pasien">
						<option value="">- Pilih Pasien -</option>
						<?php foreach ($this->user->read(array('role' => 'pasien'))->result() as $pasien):?>
							<option value="<?= $pasien->id ?>" <?= set_value('pasien', $data->pasien) == $pasien->id ? 'selected':'' ?>><?= $pasien->full_name ?></option>
						<?php endforeach; ?>
						</select>
						<?php echo form_error('pasien', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Dokter</label>
						<select class="form-control" name="dokter">
						<option value="">- Pilih Dokter -</option>
						<?php foreach ($this->user->read(array('role' => 'dokter'))->result() as $dokter):?>
							<option value="<?= $dokter->id ?>" <?= set_value('dokter', $data->dokter) == $dokter->id ? 'selected':'' ?>><?= $dokter->full_name ?></option>
						<?php endforeach; ?>
						</select>
						<?php echo form_error('dokter', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Waktu</label>
						<input class="form-control datemask" type="text" name="waktu" placeholder="Waktu" value="<?= set_value('waktu', $data->waktu) ?>">
						<?php echo form_error('waktu', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Catatan</label>
						<textarea name="catatan" class="form-control" placeholder="Catatan..."><?= set_value('catatan', $data->catatan) ?></textarea>
						<?php echo form_error('gender', '<span class="help-block error">', '</span>'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<a href="<?= base_url($this->router->fetch_class().'/pasien') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
			<button class="btn btn-success" type="submit" class="form-control">Simpan <i class="fa fa-save"></i></button>
		</div>
		</form>
	</div>
</section>
