<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-yellow m-bordered" style="background-color:#FAD405;">
		<h3>Catatan</h3>
		<!-- <p> Ketika mengklik <b>Atur Ulang Sandi</b>, maka kata sandi otomatis menjadi "<b>1234</b>"</p> -->
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-12">
								<script type="text/javascript">
									$(document).ready(function() {
										$('#g').highcharts({
											credits: { enabled: false },chart: {
												type: 'column',
												options3d: {
													enabled: true,
													alpha: 0,
													beta: 20
												}
											},
											title: {
												text: 'Rekap Data Penanganan Fakir Miskin Perkotaan'
											},
											subtitle: {
												text: 'Kube, Rutilahu, dan Sarling Provinsi <?= $data_provinsi->nm_provinsi; ?>'
											},
											xAxis: {
												categories: [
													<?php
													foreach ($data_all as $key => $value) {
														echo "'".$value->nm_kabupaten."',";
													}
													?>
												]
											},
											yAxis: {
												min: 0,
												title: {
													text: 'Persentase Realisasi (%)'
												}
											},
											tooltip: {
												shared: true
											},
											plotOptions: {
												column: {
													stacking: 'normal'
												}
											},
											series: [
												{
													name: 'Kube',
													data: [
														<?php
															foreach ($data_all as $key => $fff) {
																$persentase = 0;
																if($fff->jumlah_kube=='0'){
																	echo'';
																}else{
																	$persentase = ($fff->persentase_realisasi_kube)/($fff->jumlah_kube);
																}
																echo number_format($persentase,2).",";
															}
														?>
													],

												},
												{
													name: 'Rutilahu',
													data: [
														<?php
															foreach ($data_all as $key => $fff) {
																$persentase = 0;
																if($fff->jumlah_rutilahu=='0'){
																	echo'';
																}else{
																	$persentase = ($fff->persentase_realisasi_rutilahu)/($fff->jumlah_rutilahu);
																}
																echo number_format($persentase,2).",";
															}
														?>
													],

												},
												{
													name: 'Sarling',
													data: [
														<?php
															foreach ($data_all as $key => $fff) {
																$persentase = 0;
																if($fff->jumlah_sarling=='0'){
																	echo'';
																}else{
																	$persentase = ($fff->persentase_realisasi_sarling)/($fff->jumlah_sarling);
																}
																echo number_format($persentase,2).",";
															}
														?>
													],
												}
											]
										});
									});
								</script>
								<div id="g"></div>
								<div class="tabbable-line">
									<table class="table table-striped table-bordered" id="tbl1">
										<thead>
											<tr>
												<th style="text-align: center;" width="4%"> # </th>
												<th style="text-align: center;"> Kabupaten </th>
												<th style="text-align: center;"> Realisasi Kube </th>
												<th style="text-align: center;"> Realisasi Rutilahu </th>
												<th style="text-align: center;"> Realisasi Sarling </th>
												<th style="text-align: center;" width="7%"> Aksi </th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 1;
											foreach ($data_all as $key => $value) {
												$persentase_kube = 0;
												$persentase_fisik_kube = 0;
												$anggaran_kube = 0;
												$persentase_anggaran_kube = 0;
												if($value->jumlah_kube=='0'){
													echo'';
												}else{
													$persentase_kube = ($value->persentase_realisasi_kube)/($value->jumlah_kube);
													$persentase_fisik_kube = ($value->persentase_fisik_kube)/($value->jumlah_kube);
													$anggaran_kube = ($value->anggaran_kube)/($value->jumlah_kube);
													$persentase_anggaran_kube = ($value->persentase_anggaran_kube)/($value->jumlah_kube);
												}
												$persentase_rutilahu = 0;
												$persentase_fisik_rutilahu = 0;
												$anggaran_rutilahu = 0;
												$persentase_anggaran_rutilahu = 0;
												if($value->jumlah_rutilahu=='0'){
													echo'';
												}else{
													$persentase_rutilahu = ($value->persentase_realisasi_rutilahu)/($value->jumlah_rutilahu);
													$persentase_fisik_rutilahu = ($value->persentase_fisik_rutilahu)/($value->jumlah_rutilahu);
													$anggaran_rutilahu = ($value->anggaran_rutilahu)/($value->jumlah_rutilahu);
													$persentase_anggaran_rutilahu = ($value->persentase_anggaran_rutilahu)/($value->jumlah_rutilahu);
												}
												$persentase_sarling = 0;
												$persentase_fisik_sarling = 0;
												$anggaran_sarling = 0;
												$persentase_anggaran_sarling = 0;
												if($value->jumlah_sarling=='0'){
													echo'';
												}else{
													$persentase_sarling = ($value->persentase_realisasi_sarling)/($value->jumlah_sarling);
													$persentase_fisik_sarling = ($value->persentase_fisik_sarling)/($value->jumlah_sarling);
													$anggaran_sarling = ($value->anggaran_sarling)/($value->jumlah_sarling);
													$persentase_anggaran_sarling = ($value->persentase_anggaran_sarling)/($value->jumlah_sarling);
												}
												echo'
												<tr>
													<td style="text-align: center;">'.$no++.'.</td>
													<td><a href="'.site_url().'admin_side/dasbor_grafik_kabupaten/'.md5($value->id_kabupaten).'">'.$value->nm_kabupaten.'</a></td>
													<td style="text-align: center;">'.number_format($persentase_kube,2).'%</td>
													<td style="text-align: center;">'.number_format($persentase_rutilahu,2).'%</td>
													<td style="text-align: center;">'.number_format($persentase_sarling,2).'%</td>
													<td style="text-align: center;">
														<a class="btn btn-xs green" href="'.site_url().'admin_side/dasbor_grafik_kabupaten/'.md5($value->id_kabupaten).'">
														<i class="icon-eye"></i> Detail Data </a>
													</td>
												</tr>
												<tr>
													<td colspan="6">
														<div class="panel-group accordion" id="accordion'.$value->id_kabupaten.'">
															<div class="panel panel-default">
																<div class="panel-heading">
																	<h4 class="panel-title">
																		<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion'.$value->id_kabupaten.'" href="#collapse_'.$value->id_kabupaten.'_1" aria-expanded="false"> Detail Data </a>
																	</h4>
																</div>
																<div id="collapse_'.$value->id_kabupaten.'_1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
																	<div class="panel-body">
																	<h4><b>Kube (Kelompok Usaha Bersama)</b></h4>
																	- Jumlah Kube : '.number_format($value->jumlah_kube).' Kelompok<br>
																	- Rata-rata progres aspek fisik per kelompok '.number_format($persentase_fisik_kube,2).'%<br>
																	- Rata-rata penyerapan anggaran tiap kelompok sebesar Rp '.number_format($anggaran_kube,2).' ('.number_format($persentase_anggaran_kube,2).'%)
																	<h4><b>Rutilahu (Rumah Tidak Layak Huni)</b></h4>
																	- Jumlah Rutilahu : '.number_format($value->jumlah_rutilahu).' Kelompok<br>
																	- Rata-rata progres aspek fisik per kelompok '.number_format($persentase_fisik_rutilahu,2).'%<br>
																	- Rata-rata penyerapan anggaran tiap kelompok sebesar Rp '.number_format($anggaran_rutilahu,2).' ('.number_format($persentase_anggaran_rutilahu,2).'%)
																	<h4><b>Sarling (Sarana Lingkungan)</b></h4>
																	- Jumlah Sarling : '.number_format($value->jumlah_sarling).' Tim<br>
																	- Rata-rata progres aspek fisik per tim '.number_format($persentase_fisik_sarling,2).'%<br>
																	- Rata-rata penyerapan anggaran tiap tim sebesar Rp '.number_format($anggaran_sarling,2).' ('.number_format($persentase_anggaran_sarling,2).'%)
																	</div>
																</div>
															</div>
														</div>
													</td>
												</tr>
												';
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>