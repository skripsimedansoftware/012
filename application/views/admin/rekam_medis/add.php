<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Buat<small>Rekam Medis</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="box">
		<div class="box-header with-border"></div>
		<form method="POST" action="<?= base_url($this->router->fetch_class().'/rekam_medis/add/'.$jadwal->id) ?>">
		<div class="box-body">
			<div class="row">
				<div class="col-lg-6" style="border-right: 1px solid gray;">
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label>Waktu</label>
								<input class="form-control dateonly" type="text" name="tanggal" value="<?= set_value('tanggal', nice_date($jadwal->waktu, 'd/m/Y')) ?>">
								<?php echo form_error('tanggal', '<span class="help-block error">', '</span>'); ?>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Pasien</label>
								<select class="form-control" disabled>
								<option value="">- Pilih Pasien -</option>
								<?php foreach ($this->user->read(array('role' => 'pasien'))->result() as $pasien):?>
									<option value="<?= $pasien->id ?>" <?= set_value('pasien', $jadwal->pasien) == $pasien->id ? 'selected':'' ?>><?= $pasien->full_name ?></option>
								<?php endforeach; ?>
								</select>
								<?php echo form_error('pasien', '<span class="help-block error">', '</span>'); ?>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Dokter</label>
								<select class="form-control" disabled>
								<option value="">- Pilih Dokter -</option>
								<?php foreach ($this->user->read(array('role' => 'dokter'))->result() as $dokter):?>
									<option value="<?= $dokter->id ?>" <?= set_value('dokter', $jadwal->dokter) == $dokter->id ? 'selected':'' ?>><?= $dokter->full_name ?></option>
								<?php endforeach; ?>
								</select>
								<?php echo form_error('pasien', '<span class="help-block error">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label>Tempat Lahir</label>
								<input class="form-control" type="text" name="birthplace" placeholder="Tempat Lahir" value="<?= set_value('birthplace', $pasien->birthplace) ?>">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Tanggal Lahir</label>
								<input class="form-control dateonly" type="text" name="birthday" placeholder="Tanggal Lahir" value="<?= set_value('birthday', nice_date($pasien->birthday, 'd/m/Y')) ?>">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select class="form-control" name="gender">
									<option value="">- Pilih Jenis Kelamin -</option>
									<option value="male" <?= set_value('gender', $pasien->gender) == 'male'?'selected':'' ?>>Laki-laki</option>
									<option value="female" <?= set_value('gender', $pasien->gender) == 'female'?'selected':'' ?>>Perempuan</option>
								</select>
								<?= form_error('gender', '<span class="help-block error">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Pekerjaan</label>
								<select name="profession_type" class="form-control">
									<option value="none" <?= set_value('profession_type', $pasien->profession_type) == 'none' ? 'selected' : '' ?>>Tidak Bekerja</option>
									<option value="student" <?= set_value('profession_type', $pasien->profession_type) == 'student' ? 'selected' : '' ?>>Pelajar</option>
									<option value="employee" <?= set_value('profession_type', $pasien->profession_type) == 'employee' ? 'selected' : '' ?>>Karyawan</option>
									<option value="other" <?= set_value('profession_type', $pasien->profession_type) == 'other' ? 'selected' : '' ?>>Lainnya</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Status Menikah</label>
								<select name="marital_status" class="form-control">
									<option value="1" <?= set_value('marital_status', $pasien->marital_status) == '1' ? 'selected' : '' ?>>Menikah</option>
									<option value="2" <?= set_value('marital_status', $pasien->marital_status) == '2' ? 'selected' : '' ?>>Belum Menikah</option>
									<option value="3" <?= set_value('marital_status', $pasien->marital_status) == '3' ? 'selected' : '' ?>>Duda</option>
									<option value="4" <?= set_value('marital_status', $pasien->marital_status) == '4' ? 'selected' : '' ?>>Janda</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Uraian</label>
						<textarea name="keluhan" class="form-control" placeholder="Uraian..."><?= set_value('keluhan') ?></textarea>
						<?php echo form_error('gender', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Diagnosis</label>
						<textarea name="diagnosis" class="form-control" placeholder="Diagnosis..."><?= set_value('diagnosis') ?></textarea>
						<?php echo form_error('diagnosis', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Saran Dokter</label>
						<textarea name="saran" class="form-control" placeholder="Saran..."><?= set_value('saran') ?></textarea>
						<?php echo form_error('saran', '<span class="help-block error">', '</span>'); ?>
					</div>
					<input type="hidden" name="jadwal" value="<?= $jadwal->id ?>">
					<input type="hidden" name="pasien" value="<?= $jadwal->pasien ?>">
				</div>
				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tekanan Darah</label>
								<input type="text" name="tekanan_darah" class="form-control" placeholder="Tekanan Darah" value="<?= set_value('tekanan_darah') ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nadi</label>
								<input type="text" name="nadi" class="form-control" placeholder="Nadi" value="<?= set_value('nadi') ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Pernafasan</label>
								<input type="text" name="pernafasan" class="form-control" placeholder="Pernafasan" value="<?= set_value('pernafasan') ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Suhu</label>
								<input type="text" name="suhu" class="form-control" placeholder="Suhu" value="<?= set_value('suhu') ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Sistem Pencernaan</label>
								<input type="text" name="sistem_pencernaan" class="form-control" placeholder="Sistem Pencernaan" value="<?= set_value('sistem_pencernaan') ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Jantung dan Pembuluh Darah</label>
								<input type="text" name="jantung_pembuluh_darah" class="form-control" placeholder="Jantung dan Pembuluh Darah" value="<?= set_value('jantung_pembuluh_darah') ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Hasil Pemeriksaan Urin Zat</label>
								<input type="text" class="form-control" name="pemeriksaan_urin" placeholder="Pemeriksaan Zat Urin" value="<?= set_value('pemeriksaan_urin') ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Sistem Saraf Pusat</label>
								<input type="text" name="sistem_saraf_pusat" class="form-control" placeholder="Sistem Saraf Pusat" value="<?= set_value('sistem_saraf_pusat') ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>THT dan Kulit</label>
								<input type="text" name="tht_dan_kulit" class="form-control" placeholder="THT dan Kulit" value="<?= set_value('tht_dan_kulit') ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Keterangan</label>
								<textarea name="keterangan" class="form-control" placeholder="Keterangan"><?= set_value('keterangan') ?></textarea>
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
