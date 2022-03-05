<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Buat<small>Rekam Medis</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="box">
		<div class="box-header with-border"></div>
		<form method="POST" action="<?= base_url($this->router->fetch_class().'/rekam_medis/edit/'.$rekam_medis->id) ?>">
		<div class="box-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Pasien</label>
						<select class="form-control" disabled>
						<option value="">- Pilih Pasien -</option>
						<?php foreach ($this->user->read(array('role' => 'pasien'))->result() as $pasien):?>
							<option value="<?= $pasien->id ?>" <?= set_value('pasien', $rekam_medis->pasien) == $pasien->id ? 'selected':'' ?>><?= $pasien->full_name ?></option>
						<?php endforeach; ?>
						</select>
						<?php echo form_error('pasien', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Waktu</label>
						<input class="form-control datemask" type="text" name="tanggal" value="<?= set_value('tanggal', nice_date($rekam_medis->tanggal, 'd/m/Y')) ?>">
						<?php echo form_error('tanggal', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Keluhan</label>
						<textarea name="keluhan" class="form-control" placeholder="Keluhan..."><?= set_value('keluhan', $rekam_medis->keluhan) ?></textarea>
						<?php echo form_error('keluhan', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Diagnosis</label>
						<textarea name="diagnosis" class="form-control" placeholder="Diagnosis..."><?= set_value('diagnosis', $rekam_medis->diagnosis) ?></textarea>
						<?php echo form_error('diagnosis', '<span class="help-block error">', '</span>'); ?>
					</div>
					<input type="hidden" name="pasien" value="<?= $rekam_medis->pasien ?>">
				</div>
			</div>
		</div>
		<div class="box-footer">
			<a href="<?= base_url($this->router->fetch_class().'/jadwal') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
			<button class="btn btn-success" type="submit" class="form-control">Simpan <i class="fa fa-save"></i></button>
		</div>
		</form>
	</div>
</section>
