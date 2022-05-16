<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Tambah Data<small>Pasien</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="box">
		<div class="box-header with-border"></div>
		<form method="POST" action="<?= base_url($this->router->fetch_class().'/pasien/add') ?>">
		<div class="box-body">
			<div class="row">
				<div class="col-lg-8">
					<div class="form-group">
						<label>Nama Lengkap</label>
						<input class="form-control" type="text" name="full_name" placeholder="Nama Lengkap" value="<?= set_value('full_name') ?>">
						<?= form_error('full_name', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Kartu Identitas</label>
								<select class="form-control" name="identity_type">
									<option value="KTP" <?= set_value('identity_type') == 'KTP' ? 'selected' : '' ?>>KTP</option>
									<option value="SIM" <?= set_value('identity_type') == 'SIM' ? 'selected' : '' ?>>SIM</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nomor Identitas</label>
								<input class="form-control" type="text" name="identity_number" placeholder="Nomor Identitas" value="<?= set_value('identity_number') ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Ibu</label>
								<input class="form-control" type="text" name="mother_name" placeholder="Nama Ibu" value="<?= set_value('mother_name') ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Ayah</label>
								<input class="form-control" type="text" name="father_name" placeholder="Nama Ayah" value="<?= set_value('father_name') ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label>Tempat Lahir</label>
								<input class="form-control" type="text" name="birthplace" placeholder="Tempat Lahir" value="<?= set_value('birthplace') ?>">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Tanggal Lahir</label>
								<input class="form-control dateonly" type="text" name="birthday" placeholder="Tanggal Lahir" value="<?= set_value('birthday') ?>">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select class="form-control" name="gender">
									<option value="">- Pilih Jenis Kelamin -</option>
									<option value="male" <?= set_value('gender') == 'male'?'selected':'' ?>>Laki-laki</option>
									<option value="female" <?= set_value('gender') == 'female'?'selected':'' ?>>Perempuan</option>
								</select>
								<?= form_error('gender', '<span class="help-block error">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label>Usia</label>
								<input class="form-control" type="number" name="age" placeholder="Usia" onKeyPress="if(this.value.length == 2) return false;" value="<?= set_value('age') ?>">
								<?= form_error('age', '<span class="help-block error">', '</span>'); ?>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Golongan Darah</label>
								<select class="form-control" name="blood">
									<option value="">- Pilih Golongan Darah -</option>
									<option value="A" <?= set_value('blood') == 'A' ? 'selected':'' ?>>A</option>
									<option value="B" <?= set_value('blood') == 'B' ? 'selected':'' ?>>B</option>
									<option value="AB" <?= set_value('blood') == 'AB' ? 'selected':'' ?>>AB</option>
									<option value="O" <?= set_value('blood') == 'O' ? 'selected':'' ?>>O</option>
									<option value="A+" <?= set_value('blood') == 'A+' ? 'selected':'' ?>>A+</option>
									<option value="B+" <?= set_value('blood') == 'B+' ? 'selected':'' ?>>B+</option>
									<option value="AB+" <?= set_value('blood') == 'AB+' ? 'selected':'' ?>>AB+</option>
									<option value="O+" <?= set_value('blood') == 'O+' ? 'selected':'' ?>>O+</option>
								</select>
								<?= form_error('blood', '<span class="help-block error">', '</span>'); ?>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Agama</label>
								<select class="form-control" name="religion">
									<option value="islam" <?= set_value('religion') == 'islam' ? 'selected' : '' ?>>Islam</option>
									<option value="kristen" <?= set_value('religion') == 'kristen' ? 'selected' : '' ?>>Kristen</option>
									<option value="khatolik" <?= set_value('religion') == 'khatolik' ? 'selected' : '' ?>>Khatolik</option>
									<option value="hindu" <?= set_value('religion') == 'hindu' ? 'selected' : '' ?>>Hindu</option>
									<option value="budha" <?= set_value('religion') == 'budha' ? 'selected' : '' ?>>Budha</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label>Suku</label>
								<input class="form-control" type="text" name="ethnic_group" placeholder="Suku" value="<?= set_value('ethnic_group') ?>">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Pendidikan</label>
								<select class="form-control" name="education">
									<option value="NONE" <?= set_value('education') == 'NONE' ? 'selected' : '' ?>>Tidak Sekolah</option>
									<option value="SD" <?= set_value('education') == 'SD' ? 'selected' : '' ?>>SD</option>
									<option value="SLTP" <?= set_value('education') == 'SLTP' ? 'selected' : '' ?>>SLTP</option>
									<option value="SLTA" <?= set_value('education') == 'SLTA' ? 'selected' : '' ?>>SLTA</option>
									<option value="D3" <?= set_value('education') == 'D3' ? 'selected' : '' ?>>D3</option>
									<option value="S1" <?= set_value('education') == 'S1' ? 'selected' : '' ?>>S1</option>
									<option value="S2" <?= set_value('education') == 'S2' ? 'selected' : '' ?>>S2</option>
									<option value="S3" <?= set_value('education') == 'S3' ? 'selected' : '' ?>>S3</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Status Menikah</label>
								<select name="marital_status" class="form-control">
									<option value="1" <?= set_value('marital_status') == '1' ? 'selected' : '' ?>>Menikah</option>
									<option value="2" <?= set_value('marital_status') == '2' ? 'selected' : '' ?>>Belum Menikah</option>
									<option value="3" <?= set_value('marital_status') == '3' ? 'selected' : '' ?>>Duda</option>
									<option value="4" <?= set_value('marital_status') == '4' ? 'selected' : '' ?>>Janda</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label>Pekerjaan</label>
								<select name="profession_type" class="form-control">
									<option value="none" <?= set_value('profession_type') == 'none' ? 'selected' : '' ?>>Tidak Bekerja</option>
									<option value="student" <?= set_value('profession_type') == 'student' ? 'selected' : '' ?>>Pelajar</option>
									<option value="employee" <?= set_value('profession_type') == 'employee' ? 'selected' : '' ?>>Karyawan</option>
									<option value="other" <?= set_value('profession_type') == 'other' ? 'selected' : '' ?>>Lainnya</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Deskrpsi Pekerjaan</label>
								<input class="form-control" type="text" name="profession_name" placeholder="Deskrpsi Pekerjaan" value="<?= set_value('profession_name') ?>">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Kasus Polisi</label>
								<select name="police_case" class="form-control">
									<option value="1" <?= set_value('police_case') == '1' ? 'selected' : '' ?>>Ya</option>
									<option value="2" <?= set_value('police_case') == '2' ? 'selected' : '' ?>>Tidak</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label>Email</label>
								<input class="form-control" type="text" name="email" placeholder="Email" value="<?= set_value('email') ?>">
								<?= form_error('email', '<span class="help-block error">', '</span>'); ?>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Username</label>
								<input class="form-control" type="text" name="username" placeholder="Username" value="<?= set_value('username') ?>">
								<?= form_error('username', '<span class="help-block error">', '</span>'); ?>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Kata Sandi</label>
								<input class="form-control" type="text" name="password" placeholder="Kata Sandi" value="">
								<?= form_error('password', '<span class="help-block error">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<label>Dikirim Oleh</label>
							<select class="form-control" name="sender">
								<option value="voluntary" <?= set_value('sender') == 'voluntary' ? 'selected' : '' ?>>Sukarela</option>
								<option value="sender_1" <?= set_value('sender') == 'sender_1' ? 'selected' : '' ?>>BNN/BNNP</option>
								<option value="sender_2" <?= set_value('sender') == 'sender_2' ? 'selected' : '' ?>>Balai Rehabilitasi</option>
								<option value="sender_3" <?= set_value('sender') == 'sender_3' ? 'selected' : '' ?>>RS/Panti/Puskesmas/Lembaga</option>
								<option value="other" <?= set_value('sender') == 'other' ? 'selected' : '' ?>>Lainnya</option>
							</select>
						</div>
						<div class="col-lg-4 sender_name hidden">
							<label>Pengirim</label>
							<input type="text" name="sender_name" class="form-control" placeholder="Pengirim" value="<?= set_value('sender_name') ?>">
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Status</label>
								<select class="form-control" name="status">
									<option value="">- Pilih Status Akun -</option>
									<option value="active" <?= set_value('status') == 'active'?'selected':'' ?>>Aktif</option>
									<option value="non-active" <?= set_value('status') == 'non-active'?'selected':'' ?>>Non-Aktif</option>
								</select>
								<?= form_error('status', '<span class="help-block error">', '</span>'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<a href="<?= base_url($this->router->fetch_class().'/pasien') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
			<button class="btn pull-right btn-success" type="submit" class="form-control">Simpan <i class="fa fa-save"></i></button>
		</div>
		</form>
	</div>
</section>
