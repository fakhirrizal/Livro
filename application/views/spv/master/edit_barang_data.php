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
					url: '<?= site_url('spv/Master/ajax_function'); ?>',
					type: 'POST',
                    data: {kode_barang:kode_barang,id_barang:'<?= $data_utama->id_barang; ?>',modul:'cek_kode_barang_by_edit_barang'},
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
		<span><a href='<?= site_url('/spv_side/barang'); ?>'>Data Barang</a></span>
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
		<p> 1. Kolom isian dengan tanda bintang (<font color='red'>*</font>) adalah wajib untuk di isi.</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('spv_side/perbarui_data_barang');?>" method="post" enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<input type="hidden" name="id_barang" value="<?= md5($data_utama->id_barang); ?>">
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Kode Barang <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" id='kode_barang' name="kode_barang" placeholder="Type something" value='<?= $data_utama->kode_barang; ?>' required>
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
										<input type="text" class="form-control" name="nama_barang" placeholder="Type something" value='<?= $data_utama->nama_barang; ?>' required>
										<div class="form-control-focus"> </div>
										<i class="icon-pin"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Stok <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="number" class="form-control" name="stok" placeholder="Type something" value='<?= $data_utama->stok; ?>' required>
										<div class="form-control-focus"> </div>
										<i class="icon-layers"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Limit Stok <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="number" class="form-control" name="limit_stok" placeholder="Type something" value='<?= $data_utama->limit_stok; ?>' required>
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
<script>
	var rupiah = document.getElementById("rupiah");
	rupiah.addEventListener("keyup", function(e) {
		// tambahkan 'Rp.' pada saat form di ketik
		// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
		rupiah.value = formatRupiah(this.value, "Rp. ");
	});

	/* Fungsi formatRupiah */
	function formatRupiah(angka, prefix) {
		var number_string = angka.replace(/[^,\d]/g, "").toString(),
			split = number_string.split(","),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);

		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if (ribuan) {
			separator = sisa ? "." : "";
			rupiah += separator + ribuan.join(".");
		}

		rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
		return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
	}
</script>
<style type="text/css">
	#map {
		height: 300px;
	}
</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize&key=AIzaSyCnjlDXASsyIUKAd1QANakIHIM8jjWWyNU"></script>

<script type="text/javascript">
    //* Fungsi untuk mendapatkan nilai latitude longitude
	function updateMarkerPosition(latLng) {
		document.getElementById('latitude').value = [latLng.lat()]
		document.getElementById('longitude').value = [latLng.lng()]
	}

	var map = new google.maps.Map(document.getElementById('map'), {
	zoom: 12,
	center: new google.maps.LatLng(-6.909718326755971,109.734670017746),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	// posisi awal marker
	var latLng = new google.maps.LatLng(-6.909718326755971,109.734670017746);

	/* buat marker yang bisa di drag lalu
	panggil fungsi updateMarkerPosition(latLng)
	dan letakan posisi terakhir di id=latitude dan id=longitude
	*/
	var marker = new google.maps.Marker({
		position : latLng,
		title : 'lokasi',
		map : map,
		draggable : true
	});

	updateMarkerPosition(latLng);
	google.maps.event.addListener(marker, 'drag', function() {
	// ketika marker di drag, otomatis nilai latitude dan longitude
	// menyesuaikan dengan posisi marker
		updateMarkerPosition(marker.getPosition());
	});
</script>