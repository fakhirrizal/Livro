<script src="<?=base_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Laporan</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span><a href='<?= site_url('/admin_side/laporan_opname'); ?>'>Stok Opname</a></span>
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
					<div class="form-wizard">
						<div class="form-body">
							<ul class="nav nav-pills nav-justified steps">
								<li class="active">
									<a class="step" aria-expanded="true">
										<span class="number"> 1 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Data Barang </span>
									</a>
								</li>
								<li>
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
						<form role="form" class="form-horizontal" action="<?=base_url('admin_side/tambah_barang_opname');?>" method="post"  enctype='multipart/form-data'>
							<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Barang <span class="required"> * </span></label>
								<div class="col-md-6">
									<div class="input-icon">
										<select name='id_barang' class="form-control select2-allow-clear" required>
											<option value=''></option>
											<?php
											foreach ($barang as $key => $value) {
												echo '<option value="'.$value->id_barang.'">'.$value->kode_barang.' - '.$value->nama_barang.' (Stok: '.number_format($value->stok,0).' item)</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Qty <span class="required"> * </span></label>
								<div class="col-md-6">
									<div class="input-icon">
										<input type="number" class="form-control" name="qty" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<i class="icon-layers"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Keterangan </label>
								<div class="col-md-6">
									<div class="input-icon">
										<input type="text" class="form-control" name="keterangan" placeholder="Type something">
										<div class="form-control-focus"> </div>
										<i class="fa fa-list"></i>
									</div>
								</div>
								<div class="col-md-2">
									<button type="submit" class="btn green">Tambah</button>
								</div>
							</div>
						</form>
					</div>
					<hr>
					<table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl">
						<thead>
							<tr>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Barang </th>
								<th style="text-align: center;"> Qty </th>
								<th style="text-align: center;"> Keterangan </th>
								<th style="text-align: center;" width="7%"> Aksi </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$datacart = $this->cart->contents();
							$no = 1;
							foreach ($datacart as $key => $value) {
							?>
							<tr>
								<td style="text-align: center;"><?= $no++; ?>.</td>
								<td style="text-align: center;"><?= $value['name']; ?></td>
								<td style="text-align: center;"><?= number_format($value['qty'],0); ?></td>
								<td style="text-align: center;"><?= $value['option']['note']; ?></td>
								<td style="text-align: center;">
									<a class="btn btn-xs red" type="button" href='<?=base_url('admin_side/hapus_barang_opname/'.$value['rowid']);?>'> Hapus
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<br>
					<div class="form-actions margin-top-10">
						<div class="row">
							<div class="col-md-offset-2 col-md-10">
								<a class="btn blue" href='<?=base_url('admin_side/tambah_laporan_opname_2/');?>'>Lanjut  <i class='icon-control-play'></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>