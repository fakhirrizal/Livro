<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#username').keyup(function() {
			var uname = $('#username').val();
			if(uname == 0) {
				$('#result').text('');
			}
			else {
				$.ajax({
					url: '<?= site_url('spv/Master/ajax_function'); ?>',
					type: 'POST',
                    data: {username:uname,user_id:'<?= md5($data_utama->id); ?>',modul:'username_check_when_data_edit'},
					success: function(hasil) {
                        $("#result").html(hasil);
					}
				});
			}
		});
	});
</script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span><a href='<?= site_url('/spv_side/karyawan'); ?>'>Data Karyawan</a></span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Ubah Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-yellow m-bordered" style="background-color:#FAD405;">
		<h3>Catatan</h3>
		<p>1. Kolom isian dengan tanda bintang (<font color='red'>*</font>) adalah wajib untuk di isi.</p>
		<p>2. Field "<b>Kata Sandi</b>" harap dikosongin jika tidak ingin melakukan perubahan.</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('spv_side/perbarui_data_karyawan');?>" method="post" enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<input type="hidden" name="user_id" value="<?= md5($data_utama->id); ?>">
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nama Lengkap <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="fullname" placeholder="Type something" value='<?= $data_utama->fullname; ?>' required>
										<div class="form-control-focus"> </div>
										<i class="fa fa-user"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Alamat</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="alamat" placeholder="Type something" value='<?= $data_utama->alamat; ?>'>
										<div class="form-control-focus"> </div>
										<i class="fa fa-map"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nomor HP</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="no_hp" placeholder="Type something" value='<?= $data_utama->no_hp; ?>'>
										<div class="form-control-focus"> </div>
										<i class="fa fa-phone"></i>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Username <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" id='username' name="un" placeholder="Type something" value='<?= $data_utama->username; ?>' required>
										<div class="form-control-focus"> </div>
										<span id="result" class="help-block"></span>
										<i class="icon-user-following"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Kata Sandi</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="ps" placeholder="Type something">
										<div class="form-control-focus"> </div>
										<i class="fa fa-lock"></i>
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="form-actions margin-top-10">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="reset" class="btn default">Batal</button>
									<button type="submit" class="btn blue">Perbarui</button>
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