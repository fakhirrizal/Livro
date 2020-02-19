<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style media="all" type="text/css">
    .alignCenter { text-align: center; }
</style>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Laporan</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Stok Infus</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-yellow m-bordered" style="background-color:#FAD405;">
		<h3>Catatan</h3>
		<p> 1. Jika permintaan telah dimoderasi maka data tidak akan bisa dihapus oleh Anda.</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<form action="#" method="post" onsubmit="return deleteConfirm();"/>
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-8">
								<div class="btn-group">
									<button type='submit' id="sample_editable_1_new" class="btn sbold red"> Hapus
										<i class="fa fa-trash"></i>
									</button>
								</div>
									<!-- <span class="separator">|</span>
									<a href="<?=base_url('spv_side/tambah_laporan_infus_1');?>" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a> -->
							</div>
							<div class="col-md-4" style='text-align: right;'>
								<a href="#" class="btn btn-default" data-toggle="modal" data-target="#pr">Cetak Data <i class="fa fa-print"></i></a>
							</div>
						</div>
					</div>
					<table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl">
						<thead>
							<tr>
								<th width="3%">
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
										<span></span>
									</label>
								</th>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Requester </th>
								<th style="text-align: center;"> Tanggal Permintaan </th>
								<th style="text-align: center;"> Jumlah Barang </th>
								<th style="text-align: center;"> Status </th>
								<th style="text-align: center;" width="7%"> Aksi </th>
							</tr>
						</thead>
					</table>
					</form>
					<script type="text/javascript" language="javascript" >
						$(document).ready(function(){
							$('#tbl').dataTable({
								"order": [[ 1, "asc" ]],
								"bProcessing": true,
								"ajax" : {
									type:"POST",
									url: "<?php echo site_url('spv/Report/json_stok_infus')?>",
									cache: false
								},
								"aoColumns": [
											{ mData: 'checkbox', sClass: "alignCenter", "bSortable": false} ,
											{ mData: 'number', sClass: "alignCenter" },
											{ mData: 'nm', sClass: "alignCenter" },
											{ mData: 'tanggal_laporan', sClass: "alignCenter" },
											{ mData: 'jumlah_barang', sClass: "alignCenter" },
											{ mData: 'status', sClass: "alignCenter" },
											{ mData: 'action' }
										]
							});
						});
					</script>
					<script type="text/javascript">
					function deleteConfirm(){
						var result = confirm("Yakin akan menghapus data ini?");
						if(result){
							return true;
						}else{
							return false;
						}
					}
					</script>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="pr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Form Cetak Data</h4>
			</div>
			<div class="modal-body">
				<div class="form-body">
					<div class="m-heading-1 border-yellow m-bordered" style="background-color:#FAD405;">
						<h3>Catatan</h3>
						<p> 1. Data yang masuk dalam data rekap adalah yang berstatus <b>Approved</b>.</p>
					</div>
					<form role="form" class="form-horizontal" action="<?=base_url('spv_side/download_rekap_infus_barang');?>" method="post" enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<div class="form-group form-md-line-input has-danger" id='pil'>
							<div class="col-md-2">
							</div>
							<div class="col-md-2">
								<label > Pilihan Cetak Data
										<span></span></label>
							</div>
							<div class="col-md-2">
								<label class="mt-radio"><input type="radio" name="optionsRadios" id="optionsRadios4" value="option1" checked=""> Per Tanggal
										<span></span></label>
							</div>
							<div class="col-md-2">
								<label class="mt-radio"><input type="radio" name="optionsRadios" id="optionsRadios5" value="option2"> Per Bulan
										<span></span></label>
							</div>
						</div>
						<div class="form-group form-md-line-input has-danger" id='pil1'>
							<label class="col-md-2 control-label" for="form_control_1">Pilih Tanggal <span class="required"> * </span></label>
							<div class="col-md-10">
								<div class="input-icon">
									<input type="date" class="form-control" name="d1" placeholder="Type something">
									<div class="form-control-focus"> </div>
									<i class="icon-calendar"></i>
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input has-danger" id='pil2' style='display:none'>
							<label class="col-md-2 control-label" for="form_control_1">Pilih Bulan <span class="required"> * </span></label>
							<div class="col-md-10">
								<div class="input-icon">
									<input type="month" class="form-control" name="d2" placeholder="Type something">
									<div class="form-control-focus"> </div>
									<i class="icon-calendar"></i>
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input has-danger">
							<div class="col-md-2 control-label">
								<button type="submit" class="btn green">Cetak Data</button>
							</div>
						</div>
						<script type="text/javascript"> 
							$("#pil input[name='optionsRadios']").click(function(){
								if($('input:radio[name=optionsRadios]:checked').val() == "option1"){
									document.getElementById("pil1").style.display = "block";
									document.getElementById("pil2").style.display = "none";
								}else{
									document.getElementById("pil1").style.display = "none";
									document.getElementById("pil2").style.display = "block";
								}
							});
						</script>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>