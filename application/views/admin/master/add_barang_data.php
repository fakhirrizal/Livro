<!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->
<script src="<?=base_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#kode_barang').keyup(function() {
			var kode_barang = $('#kode_barang').val();
			if(kode_barang == 0) {
				$('#result').text('');
			}
			else {
				$.ajax({
					url: '<?= site_url('admin/Master/ajax_function'); ?>',
					type: 'POST',
                    data: {kode_barang:kode_barang,modul:'cek_kode_barang'},
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
		<span><a href='<?= site_url('/admin_side/barang'); ?>'>Data Barang</a></span>
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
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('admin_side/simpan_data_barang');?>" method="post"  enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Kode Barang <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" id='kode_barang' name="kode_barang" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span id="result" class="help-block"></span>
										<i class="icon-grid"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nama Barang <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="nama_barang" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<i class="icon-pin"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Stok <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="number" class="form-control" name="stok" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<i class="icon-layers"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Limit Stok <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="number" class="form-control" name="limit" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<i class="icon-layers"></i>
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