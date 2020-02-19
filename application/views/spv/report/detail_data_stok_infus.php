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
		<span><a href='<?= site_url('/spv_side/laporan_infus'); ?>'>Stok Infus</a></span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Detil Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<?php
	$st = '';
	$role_id = '';
	$user_id = '';
?>
<div class="page-content-inner">
	<div class="m-heading-1 border-yellow m-bordered" style="background-color:#FAD405;">
		<h3>Catatan</h3>
		<!-- <p> 1. Jika laporan telah "<b>disetujui</b>" ataupun "<b>ditolak</b>" maka data tidak dapat diubah kembali.</p> -->
		<p> 1. Jika permintaan "<b>disetujui</b>" maka akan dialihkan ke halaman selanjutnya untuk pengisian item yang diminta.</p>
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
								$st = $row->status;
								$role_id = $row->role_id;
								$user_id = $row->created_by;
								$approval = '';
								if($row->approval==NULL){
									echo'';
								}else{
									$explode_tgl = explode(' ',$row->approval);
									$get_verificator = $this->Main_model->getSelectedData('user_profile a', 'a.*', array('a.user_id'=>$row->verificator))->row();
									$approval = '&nbsp;&nbsp;'.$this->Main_model->convert_tanggal($explode_tgl[0]).' '.substr($explode_tgl[1],0,5).'&nbsp;&nbsp;oleh '.$get_verificator->fullname;
								}
						?>
								<div class="col-md-10">
									<table class="table">
										<tbody>
                                            <tr>
												<td> Requester </td>
												<td> : </td>
												<td><?php echo $row->fullname; ?></td>
											</tr>
                                            <tr>
												<td> Tanggal Permintaan </td>
												<td> : </td>
												<td><?php $pecah_tanggal = explode(' ',$row->created_at); echo $this->Main_model->convert_tanggal($pecah_tanggal[0]).' '.substr($pecah_tanggal[1],0,5); ?></td>
											</tr>
											<tr>
												<td> Status </td>
												<td> : </td>
												<td><?php
												if($row->status=='1'){
													$isi = '<span class="label label-success"> Approved </span>'.$approval;
												}elseif($row->status=='9'){
													$isi = '<span class="label label-danger"> Rejected </span>'.$approval;
												}else{
													if($row->created_by==$this->session->userdata('id')){
														$isi = '<span class="label label-warning"> Pending </span>';
													}else{
														if($role_id=='3'){
															$isi = '<span class="label label-warning"> Pending </span>&nbsp;&nbsp;
															<a title="Ubah Status" data-toggle="modal" data-target="#ubahdata" id="'.md5($row->id_stok_infus).'" class="ubahdata">
															<i class="icon-note"></i>
															</a>';
														}else{
															$isi = '<span class="label label-warning"> Pending </span>';
														}
													}
												}
												echo $isi;
												?></td>
											</tr>
											<?php
											if($row->keterangan==NULL){
												echo'';
											}else{
												echo'
												<tr>
													<td> Keterangan </td>
													<td> : </td>
													<td>'.$row->keterangan.'</td>
												</tr>
												';
											}
											?>
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
											<a href="<?php echo site_url('spv_side/tambah_laporan_infus_1'); ?>" class="btn green uppercase">Tambah Data Laporan <i class="fa fa-plus"></i> </a>
										</div>
									</div>
								</div> -->
								<?php
								if($role_id=='2'){
								?>
								<div class="tabbable-line">
									<ul class="nav nav-tabs ">
										<li class="active">
											<a href="#tab_15_1" data-toggle="tab"> Request List </a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab_15_1">
											<table class="table table-striped table-bordered" id="tbl1">
												<thead>
													<tr>
														<th style="text-align: center;" width="4%"> # </th>
														<th style="text-align: center;"> Barang </th>
														<th style="text-align: center;"> Qty </th>
														<th style="text-align: center;"> Harga Satuan </th>
														<th style="text-align: center;"> Total Harga </th>
														<th style="text-align: center;"> Keterangan </th>
														<?php if($user_id==$this->session->userdata('id')){echo'<th style="text-align: center;" width="7%"> Aksi </th>';}else{echo'';}  ?>
													</tr>
												</thead>
												<tbody>
													<?php
													$no = 1;
													$data_detil = $this->Main_model->getSelectedData('stok_infus_detail a', 'a.*,b.nama_barang', array('md5(a.id_stok_infus)'=>$this->uri->segment(3)), '', '', '', '', array(
														'table' => 'barang b',
														'on' => 'a.id_barang=b.id_barang',
														'pos' => 'LEFT'
													))->result();
													foreach ($data_detil as $key => $value) {
														$total_harga = $value->qty * $value->harga_satuan;
														$return_on_click = "return confirm('Anda yakin?')";
														$btn_del = '';
														$td_aksi = '';
														if($st=='0'){
															$btn_del = '<a onclick="'.$return_on_click.'" class="btn btn-xs red" href="'.site_url('spv_side/hapus_data_stok_infus_barang/'.md5($value->id_stok_infus_detail)).'">
															Hapus Data <i class="fa fa-trash"></i> </a>';
														}else{
															$btn_del = '<a class="btn btn-xs red" href="#" disabled>
															Hapus Data <i class="fa fa-trash"></i> </a>';
														}
														if($user_id==$this->session->userdata('id')){$td_aksi = '<td style="text-align: center;">'.$btn_del.'</td>';}else{echo'';}
														echo'
														<tr>
															<td style="text-align: center;">'.$no++.'.</td>
															<td style="text-align: center;">'.$value->nama_barang.'</td>
															<td style="text-align: center;">'.number_format($value->qty,0).'</td>
															<td style="text-align: center;">Rp '.number_format($value->harga_satuan,2).'</td>
															<td style="text-align: center;">Rp '.number_format($total_harga,2).'</td>
															<td style="text-align: center;">'.$value->keterangan.'</td>
															'.$td_aksi.'
														</tr>
														';
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<?php
								}elseif($role_id=='3' OR $role_id=='4'){
								?>
								<div class="tabbable-line">
									<ul class="nav nav-tabs ">
										<li class="active">
											<a href="#tab_15_1" data-toggle="tab"> Request List </a>
										</li>
										<?php
										if($st=='1'){
										?>
										<li>
											<a href="#tab_15_2" data-toggle="tab"> Approved </a>
										</li>
										<?php
										}else{echo'';}
										?>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab_15_1">
											<table class="table table-striped table-bordered" id="tbl1">
												<thead>
													<tr>
														<th style="text-align: center;" width="4%"> # </th>
														<th style="text-align: center;"> Barang </th>
														<th style="text-align: center;"> Qty </th>
														<th style="text-align: center;"> Keterangan </th>
														<!-- <th style="text-align: center;" width="7%"> Aksi </th> -->
													</tr>
												</thead>
												<tbody>
													<?php
													$no = 1;
													foreach ($data_detail_laporan as $key => $value) {
														// $total_harga = $value->qty * $value->harga_satuan;
														$return_on_click = "return confirm('Anda yakin?')";
														if($st=='0'){
															$btn_del = '<a onclick="'.$return_on_click.'" class="btn btn-xs red" href="'.site_url('spv_side/hapus_data_stok_infus_barang/'.md5($value->id_stok_infus_request)).'">
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
														</tr>
														';
													}
													?>
												</tbody>
											</table>
										</div>
										<?php
										if($st=='1'){
											$data_detail = $this->Main_model->getSelectedData('stok_infus_detail a', 'a.*,b.nama_barang', array('md5(a.id_stok_infus)'=>$this->uri->segment(3)), '', '', '', '', array(
												'table' => 'barang b',
												'on' => 'a.id_barang=b.id_barang',
												'pos' => 'LEFT'
											))->result();
										?>
										<div class="tab-pane" id="tab_15_2">
											<table class="table table-striped table-bordered" id="tbl1">
												<thead>
													<tr>
														<th style="text-align: center;" width="4%"> # </th>
														<th style="text-align: center;"> Barang </th>
														<th style="text-align: center;"> Qty </th>
														<th style="text-align: center;"> Harga Satuan </th>
														<th style="text-align: center;"> Total Harga </th>
														<th style="text-align: center;"> Keterangan </th>
														<!-- <th style="text-align: center;" width="7%"> Aksi </th> -->
													</tr>
												</thead>
												<tbody>
													<?php
													$no = 1;
													foreach ($data_detail as $key => $value) {
														$total_harga = $value->qty * $value->harga_satuan;
														$return_on_click = "return confirm('Anda yakin?')";
														if($st=='0'){
															$btn_del = '<a onclick="'.$return_on_click.'" class="btn btn-xs red" href="'.site_url('spv_side/hapus_data_stok_infus_barang/'.md5($value->id_stok_infus_request)).'">
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
															<td style="text-align: center;">Rp '.number_format($value->harga_satuan,2).'</td>
															<td style="text-align: center;">Rp '.number_format($total_harga,2).'</td>
															<td style="text-align: center;">'.$value->keterangan.'</td>
														</tr>
														';
													}
													?>
												</tbody>
											</table>
										</div>
										<?php
										}else{echo'';}
										?>
									</div>
								</div>
								<?php }else{echo'';} ?>
							</div>
						</div>
						<div class="col-md-12" >
						<hr><a href="<?php echo base_url()."spv_side/laporan_infus"; ?>" class="btn btn-info" role="button"><i class="fa fa-angle-double-left"></i> Kembali</a></div>
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
				<h4 class="modal-title" id="myModalLabel">Form Permohonan</h4>
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
			url: "<?php echo site_url(); ?>spv/Report/ajax_function",
			cache: false,
		});
		$('.ubahdata').click(function(){
		var id = $(this).attr("id");
		var modul = 'modul_ubah_data_status_laporan_stok_infus';
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