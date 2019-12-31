<script src="<?=base_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Laporan</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span><a href='<?= site_url('/admin_side/laporan_infus'); ?>'>Stok Infus</a></span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Tambah Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-yellow m-bordered" style="background-color:#FAD405;">
		<h3>Catatan</h3>
		<p> 1. Kolom isian dengan tanda bintang (<font color='red'>*</font>) adalah wajib untuk di isi.</p>
		<p> 2. Barang yang tercantum adalah barang yang sudah masuk kriteria limit stok.</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('admin_side/simpan_data_laporan_infus');?>" method="post"  enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<div class="form-wizard">
							<div class="form-body">
								<ul class="nav nav-pills nav-justified steps">
									<li >
										<a class="step" aria-expanded="true">
											<span class="number"> 1 </span>
											<span class="desc">
												<i class="fa fa-check"></i> Data Barang </span>
										</a>
									</li>
									<li class="active">
										<a class="step">
											<span class="number"> 2 </span>
											<span class="desc">
												<i class="fa fa-check"></i> Keterangan Tambahan </span>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Pelapor <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<select name='created_by' class="form-control select2-allow-clear" required>
											<option value=''></option>
											<?php
											foreach ($karyawan as $key => $value) {
												echo '<option value="'.$value->user_id.'">'.$value->fullname.'</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Tanggal Laporan <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="date" class="form-control" name="created_at" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<i class="icon-calendar"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Keterangan </label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="ket" placeholder="Type something">
										<div class="form-control-focus"> </div>
										<i class="icon-list"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Status <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<select name='status' class="form-control select2-allow-clear" required>
											<option value=''></option>
											<option value='0'>Pending</option>
											<option value='1'>Approved</option>
											<option value='9'>Rejected</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="form-actions margin-top-10">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="reset" class="btn default">Batal</button>
									<button type="submit" class="btn blue">Simpan</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>