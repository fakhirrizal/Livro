<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style media="all" type="text/css">
    .alignCenter { text-align: center; }
</style>
<ul class="page-breadcrumb breadcrumb">
	<!-- <li>
		<span>Laporan</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span><a href='<?= site_url('/admin_side/laporan_infus'); ?>'>Stok Infus</a></span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Detil Data</span>
	</li> -->
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<?php $st = ''; ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-yellow m-bordered" style="background-color:#FAD405;">
        <h3>Catatan</h3>
        <p> 1. Kolom isian dengan tanda bintang (<font color='red'>*</font>) adalah wajib untuk di isi.</p>
		<!-- <p> 1. Jika laporan telah "<b>disetujui</b>" ataupun "<b>ditolak</b>" maka data tidak dapat diubah kembali.</p>
		<p> 2. Jika permintaan "<b>disetujui</b>" maka akan dialihkan ke halaman selanjutnya untuk pengisian item yang diminta.</p> -->
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
                    <h4>Form Laporan Stok Infus Barang</h4>
                    <hr>
					<div class='row'>
						<div class="col-md-12" >
							<div class="tabbable-line">
								<!-- <div class="table-toolbar">
									<div class="row">
										<div class="col-md-6">
											<a href="<?php echo site_url('admin_side/tambah_laporan_infus_1'); ?>" class="btn green uppercase">Tambah Data Laporan <i class="fa fa-plus"></i> </a>
										</div>
									</div>
								</div> -->
								<div class="form-body">
                                    <form role="form" class="form-horizontal" action="<?=base_url('admin_side/simpan_laporan_stok_infus_barang');?>" method="post" enctype='multipart/form-data'>
                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                                        <div class="form-group form-md-line-input has-danger">
                                            <div class="col-md-3" style='text-align:center'>
                                                <label>Nama Barang </label>
                                            </div>
                                            <div class="col-md-2" style='text-align:center'>
                                                <label>Qty </label>
                                            </div>
                                            <div class="col-md-3" style='text-align:center'>
                                                <label>Harga Satuan <span class="required"> * </span></label>
                                            </div>
                                            <div class="col-md-4" style='text-align:center'>
                                                <label>Keterangan </label>
                                            </div>
                                        </div>
                                        <?php
                                        foreach ($data_detail_laporan as $key => $value) {
                                        ?>
                                        <input type="hidden" name="id_barang_<?= $value->id_stok_infus_request; ?>" value='<?= $value->id_barang; ?>'>
                                        <input type="hidden" name="id_stok_infus_request[]" value='<?= $value->id_stok_infus_request; ?>'>
                                        <input type="hidden" name="id_stok_infus" value='<?= $value->id_stok_infus; ?>'>
                                        <div class="form-group form-md-line-input has-danger">
                                            <div class="col-md-3">
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" name="nama_barang" placeholder="Type something" value='<?= $value->nama_barang; ?>' readonly>
                                                    <div class="form-control-focus"> </div>
                                                    <i class="icon-pin"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-icon">
                                                    <input type="number" class="form-control" name="qty_<?= $value->id_stok_infus_request; ?>" placeholder="Type something" value='<?= $value->qty; ?>' readonly>
                                                    <div class="form-control-focus"> </div>
                                                    <i class="icon-layers"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-icon">
                                                    <input type="number" class="form-control" name="harga_satuan_<?= $value->id_stok_infus_request; ?>" placeholder="Harga Satuan" required>
                                                    <div class="form-control-focus"> </div>
                                                    <i class="fa fa-dollar"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" name="keterangan_<?= $value->id_stok_infus_request; ?>" placeholder="Keterangan">
                                                    <div class="form-control-focus"> </div>
                                                    <i class="icon-list"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <br>
                                        <div class="form-group form-md-line-input has-danger">
                                            <div class="col-md-4">
                                                <button type="reset" class="btn default">Batal</button>
                                                <button type="submit" class="btn blue">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>