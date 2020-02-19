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
		<span><a href='<?= site_url('/member_side/laporan_opname'); ?>'>Stok Opname</a></span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Detil Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<?php $st = ''; ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-yellow m-bordered" style="background-color:#FAD405;">
		<h3>Catatan</h3>
		<p> 1. Jika laporan telah "<b>disetujui</b>" ataupun "<b>ditolak</b>" maka data tidak dapat diubah kembali.</p>
		<!-- <p> 2. Jika menghapus data barang maka stok di master barang akan bertambah.</p> -->
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<div class='row'>
						<?php
						if(isset($data_utama)){
							foreach($data_utama as $row)
							{
						?>
								<div class="col-md-6">
									<table class="table">
										<tbody>
                                            <tr>
												<td> Pelapor </td>
												<td> : </td>
												<td><?php echo $row->fullname; ?></td>
											</tr>
                                            <tr>
												<td> Tanggal Lapor </td>
												<td> : </td>
												<td><?php $pecah_tanggal = explode(' ',$row->created_at); echo $this->Main_model->convert_tanggal($pecah_tanggal[0]).' '.substr($pecah_tanggal[1],0,5); ?></td>
											</tr>
											<tr>
												<td> Status Laporan </td>
												<td> : </td>
												<td><?php
												$st = $row->status;
												if($row->status=='1'){
													$isi = '<span class="label label-success"> Approved </span>';
												}elseif($row->status=='9'){
													$isi = '<span class="label label-danger"> Rejected </span>';
												}else{
													$isi = '<span class="label label-warning"> Pending </span>';
												}
												echo $isi;
												?></td>
											</tr>
											<tr>
												<td> Keterangan </td>
												<td> : </td>
												<td><?php echo $row->keterangan; ?></td>
											</tr>
											<tr>
												<td> </td>
												<td> </td>
												<td> </td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-6">
									<table class="table">
										<!-- <tbody>
                                            <tr>
												<td> </td>
												<td> </td>
												<td> </td>
											</tr>
                                            <tr>
												<td> </td>
												<td> </td>
												<td> </td>
											</tr>
											<tr>
												<td> </td>
												<td> </td>
												<td> </td>
											</tr>
											<tr>
												<td> </td>
												<td> </td>
												<td> </td>
											</tr>
										</tbody> -->
									</table>
								</div>
						<?php }} ?>
					</div>
					<div class='row'>
						<div class="col-md-12" >
							<div class="tabbable-line">
								<!-- <div class="table-toolbar">
									<div class="row">
										<div class="col-md-6">
											<a href="<?php echo site_url('member_side/tambah_laporan_opname_1'); ?>" class="btn green uppercase">Tambah Data Laporan <i class="fa fa-plus"></i> </a>
										</div>
									</div>
								</div> -->
								<table class="table table-striped table-bordered" id="tbl1">
									<thead>
										<tr>
											<th style="text-align: center;" width="4%"> # </th>
											<th style="text-align: center;"> Barang </th>
											<th style="text-align: center;"> Qty </th>
											<!-- <th style="text-align: center;"> Harga Satuan </th> -->
											<!-- <th style="text-align: center;"> Total Harga </th> -->
											<th style="text-align: center;"> Keterangan </th>
											<th style="text-align: center;" width="7%"> Aksi </th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										foreach ($data_detail_laporan as $key => $value) {
											// $total_harga = $value->qty * $value->harga_satuan;
											$return_on_click = "return confirm('Anda yakin?')";
											if($st=='0'){
												$btn_del = '<a onclick="'.$return_on_click.'" class="btn btn-xs red" href="'.site_url('member_side/hapus_data_stok_opname_barang/'.md5($value->id_stok_opname_detail)).'">
												Hapus Data <i class="fa fa-trash"></i> </a>';
											}else{
												$btn_del = '<a class="btn btn-xs red" href="#" disabled>
												Hapus Data <i class="fa fa-trash"></i> </a>';
											}
											echo'
											<tr>
												<td style="text-align: center;">'.$no++.'.</td>
												<td style="text-align: center;">'.$value->nama_barang.'</td>
												<td style="text-align: center;">'.number_format($value->qty,0).'</td>
												<td style="text-align: center;">'.$value->keterangan.'</td>
												<td>
													'.$btn_del.'
												</td>
											</tr>
											';
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-md-12" >
						<hr><a href="<?php echo base_url()."member_side/laporan_opname"; ?>" class="btn btn-info" role="button"><i class="fa fa-angle-double-left"></i> Kembali</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ubahdata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Form Ubah Data</h4>
			</div>
			<div class="modal-body">
				<div class="box box-primary" id='formubahdata' >
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url(); ?>member/Report/ajax_function",
			cache: false,
		});
		$('.ubahdata').click(function(){
		var id = $(this).attr("id");
		var modul = 'modul_ubah_data_status_laporan_stok_opname';
		$.ajax({
			data: {id:id,modul:modul},
			success:function(data){
			$('#formubahdata').html(data);
			$('#ubahdata').modal("show");
			}
		});
		});
	});
</script>