<script src="<?=base_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
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
			<div class="portlet light ">
				<div class="portlet-body">
					<div class="form-body">
						<form role="form" class="form-horizontal" action="<?=base_url('spv_side/perbarui_data_stok_infus');?>" method="post" enctype='multipart/form-data'>
							<input type="hidden" name="id" value="<?= md5($data_utama->id_stok_infus); ?>">
							<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Keterangan </label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="ket" value="<?= $data_utama->keterangan; ?>" placeholder="Type something">
										<div class="form-control-focus"> </div>
										<i class="fa fa-list"></i>
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
					<hr>
					<h4>Detail data barang</h4>
					<table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl">
						<thead>
							<tr>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Barang </th>
								<th style="text-align: center;"> Qty </th>
								<th style="text-align: center;"> Harga Satuan </th>
								<th style="text-align: center;"> Total Harga </th>
								<th style="text-align: center;"> Keterangan </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($data_detail_laporan as $key => $value) {
							$total_harga = $value['qty'] * $value['harga_satuan'];
							?>
							<tr>
								<td style="text-align: center;"><?= $no++; ?>.</td>
								<td style="text-align: center;"><?= $value['nama_barang']; ?></td>
								<td style="text-align: center;"><?= number_format($value['qty'],0); ?></td>
								<td style="text-align: center;"><?= 'Rp '.number_format($value['harga_satuan'],2); ?></td>
								<td style="text-align: center;"><?= 'Rp '.number_format($total_harga,2); ?></td>
								<td style="text-align: center;"><?= $value['keterangan']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>