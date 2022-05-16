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
						<input class="form-control dateonly" type="text" name="tanggal" value="<?= set_value('tanggal', nice_date($rekam_medis->tanggal, 'd/m/Y')) ?>">
						<?php echo form_error('tanggal', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Uraian</label>
						<textarea name="keluhan" class="form-control" placeholder="Uraian..."><?= set_value('keluhan', $rekam_medis->keluhan) ?></textarea>
						<?php echo form_error('keluhan', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Diagnosis</label>
						<textarea name="diagnosis" class="form-control" placeholder="Diagnosis..."><?= set_value('diagnosis', $rekam_medis->diagnosis) ?></textarea>
						<?php echo form_error('diagnosis', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Saran Dokter</label>
						<textarea name="saran" class="form-control" placeholder="Saran..."><?= set_value('saran', $rekam_medis->saran) ?></textarea>
						<?php echo form_error('saran', '<span class="help-block error">', '</span>'); ?>
					</div>
					<input type="hidden" name="pasien" value="<?= $rekam_medis->pasien ?>">
				</div>
				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tekanan Darah</label>
								<input type="text" name="tekanan_darah" class="form-control" placeholder="Tekanan Darah" value="<?= set_value('tekanan_darah', $rekam_medis->tekanan_darah) ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nadi</label>
								<input type="text" name="nadi" class="form-control" placeholder="Nadi" value="<?= set_value('nadi', $rekam_medis->nadi) ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Pernafasan</label>
								<input type="text" name="pernafasan" class="form-control" placeholder="Pernafasan" value="<?= set_value('pernafasan', $rekam_medis->pernafasan) ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Suhu</label>
								<input type="text" name="suhu" class="form-control" placeholder="Suhu" value="<?= set_value('suhu', $rekam_medis->suhu) ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Sistem Pencernaan</label>
								<input type="text" name="sistem_pencernaan" class="form-control" placeholder="Sistem Pencernaan" value="<?= set_value('sistem_pencernaan', $rekam_medis->sistem_pencernaan) ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Jantung dan Pembuluh Darah</label>
								<input type="text" name="jantung_pembuluh_darah" class="form-control" placeholder="Jantung dan Pembuluh Darah" value="<?= set_value('jantung_pembuluh_darah', $rekam_medis->jantung_pembuluh_darah) ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Hasil Pemeriksaan Urin Zat</label>
								<input type="text" class="form-control" name="pemeriksaan_urin" placeholder="Pemeriksaan Zat Urin" value="<?= set_value('pemeriksaan_urin', $rekam_medis->pemeriksaan_urin) ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Sistem Saraf Pusat</label>
								<input type="text" name="sistem_saraf_pusat" class="form-control" placeholder="Sistem Saraf Pusat" value="<?= set_value('sistem_saraf_pusat', $rekam_medis->sistem_saraf_pusat) ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>THT dan Kulit</label>
								<input type="text" name="tht_dan_kulit" class="form-control" placeholder="THT dan Kulit" value="<?= set_value('tht_dan_kulit', $rekam_medis->tht_dan_kulit) ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Keterangan</label>
								<textarea name="keterangan" class="form-control" placeholder="Keterangan"><?= set_value('keterangan', $rekam_medis->keterangan) ?></textarea>
							</div>
						</div>
					</div>
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
