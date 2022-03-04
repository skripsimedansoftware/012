<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Sunting Data<small>Dokter</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="box">
		<div class="box-header with-border"></div>
		<form method="POST" action="<?= base_url($this->router->fetch_class().'/dokter/edit/'.$data->id) ?>">
		<div class="box-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Nama Lengkap</label>
						<input class="form-control" type="text" name="full_name" placeholder="Nama Lengkap" value="<?= set_value('full_name', $data->full_name) ?>">
						<?php echo form_error('full_name', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input class="form-control" type="text" name="email" placeholder="Email" value="<?= set_value('email', $data->email) ?>">
						<?php echo form_error('email', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Nama Pengguna</label>
						<input class="form-control" type="text" name="username" placeholder="Nama Pengguna" value="<?= set_value('username', $data->username) ?>">
						<?php echo form_error('username', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Jenis Kelamin</label>
						<select class="form-control" name="gender">
							<option value="">- Pilih Jenis Kelamin -</option>
							<option value="male" <?= set_value('gender', $data->gender) == 'male'?'selected':'' ?>>Laki-laki</option>
							<option value="female" <?= set_value('gender', $data->gender) == 'female'?'selected':'' ?>>Perempuan</option>
						</select>
						<?php echo form_error('gender', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Golongan Darah</label>
						<select class="form-control" name="blood">
							<option value="">- Pilih Golongan Darah -</option>
							<option value="A" <?= set_value('blood', $data->blood) == 'A' ? 'selected':'' ?>>A</option>
							<option value="B" <?= set_value('blood', $data->blood) == 'B' ? 'selected':'' ?>>B</option>
							<option value="AB" <?= set_value('blood', $data->blood) == 'AB' ? 'selected':'' ?>>AB</option>
							<option value="O" <?= set_value('blood', $data->blood) == 'O' ? 'selected':'' ?>>O</option>
							<option value="A+" <?= set_value('blood', $data->blood) == 'A+' ? 'selected':'' ?>>A+</option>
							<option value="B+" <?= set_value('blood', $data->blood) == 'B+' ? 'selected':'' ?>>B+</option>
							<option value="AB+" <?= set_value('blood', $data->blood) == 'AB+' ? 'selected':'' ?>>AB+</option>
							<option value="O+" <?= set_value('blood', $data->blood) == 'O+' ? 'selected':'' ?>>O+</option>
						</select>
						<?php echo form_error('blood', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Usia</label>
						<input class="form-control" type="number" name="age" placeholder="Usia" onKeyPress="if(this.value.length == 2) return false;" value="<?= set_value('age', $data->age) ?>">
						<?php echo form_error('age', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Kata Sandi</label>
						<input class="form-control" type="text" name="password" placeholder="Kata Sandi" value="">
						<?php echo form_error('password', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status">
							<option value="">- Pilih Status Akun -</option>
							<option value="active" <?= set_value('status', $data->status) == 'active'?'selected':'' ?>>Aktif</option>
							<option value="non-active" <?= set_value('status', $data->status) == 'non-active'?'selected':'' ?>>Non-Aktif</option>
						</select>
						<?php echo form_error('status', '<span class="help-block error">', '</span>'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<a href="<?= base_url($this->router->fetch_class().'/dokter') ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
			<button class="btn btn-success" type="submit" class="form-control">Simpan <i class="fa fa-save"></i></button>
		</div>
		</form>
	</div>
</section>
