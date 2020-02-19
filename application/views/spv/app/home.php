<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<div class="alert alert-info alert-dismissible" role="alert" style="text-align: justify;">
	<!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
	<i class="fa fa-warning"></i> <strong>Selamat Datang</strong></a>
</div>
<div class="page-content-inner">
	<div class="row widget-row">
		<div class="col-md-6">
			<!-- BEGIN WIDGET THUMB -->
			<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
				<h4 class="widget-thumb-heading">Limit Stok</h4>
				<div class="widget-thumb-wrap">
					<i class="widget-thumb-icon bg-red icon-layers"></i>
					<div class="widget-thumb-body">
						<span class="widget-thumb-subtitle">Barang</span>
						<?php
						$total_barang = 0;
						$get_data_detail_barang = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.deleted'=>'0'))->result();
						foreach ($get_data_detail_barang as $key => $value) {
							if($value->stok>$value->limit_stok){
								echo'';
							}else{
								$total_barang++;
							}
						}
						?>
						<span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?= number_format($total_barang,0); ?>"><?= number_format($total_barang,0); ?></span>
					</div>
				</div>
			</div>
			<!-- END WIDGET THUMB -->
		</div>
		<div class="col-md-6">
			<!-- BEGIN WIDGET THUMB -->
			<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
				<h4 class="widget-thumb-heading">Pengeluaran Hari Ini</h4>
				<div class="widget-thumb-wrap">
					<i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
					<div class="widget-thumb-body">
						<span class="widget-thumb-subtitle">Rupiah</span>
						<?php
						$total_pengeluaran = 0;
						$cur_date = date('Y-m-d');
						$pengeluaran = $this->db->query("SELECT * FROM stok_infus WHERE approval LIKE '%".$cur_date."%'")->result();
						foreach ($pengeluaran as $key => $value) {
							$total_pengeluaran += $value->total_harga;
						}
						?>
						<span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?= number_format($total_pengeluaran,2); ?>"><?= number_format($total_pengeluaran,2); ?></span>
					</div>
				</div>
			</div>
			<!-- END WIDGET THUMB -->
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-share font-dark hide"></i>
						<span class="caption-subject font-dark bold">Profil Livro Coffee - Semarang</span>
					</div>
				</div>
				<div class="portlet-body">
					<article>
						<h4>Visi</h4>
						<div dir="ltr"><br></div>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum..</p>
						<h4>Misi</h4>
						<div dir="ltr"><br></div>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Mauris commodo quis imperdiet massa:</p>
						<div dir="ltr"></div>
						<ol class="decimal">
							<li>congue mauris rhoncus aenean vel elit scelerisque mauris pellentesque pulvinar.</li>
							<li>eget arcu dictum varius duis at consectetur lorem donec massa.</li>
							<li>venenatis tellus in metus vulputate eu scelerisque felis imperdiet proin fermentum leo.</li>
							<li>id neque aliquam vestibulum morbi blandit cursus risus at ultrices mi tempus.</li>
							<li>quis varius quam quisque id diam vel quam elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere lorem ipsum dolor sit amet consectetur adipiscing.</li>
							<li>ornare arcu dui vivamus arcu felis bibendum ut tristique et egestas quis ipsum suspendisse ultrices gravida dictum fusce ut placerat orci nulla pellentesque dignissim enim.</li>
							<li>amet volutpat consequat mauris nunc congue nisi vitae suscipit tellus mauris a diam maecenas sed enim ut sem viverra aliquet.</li>
							<li>pellentesque elit eget gravida cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus mauris vitae ultricies leo.</li>
							<li>felis imperdiet proin fermentum leo vel orci porta non pulvinar neque laoreet suspendisse interdum consectetur libero id faucibus nisl tincidunt eget.<p>&nbsp;</p></li>
						</ol>
						<div dir="ltr"><br></div>
					</article>
					<!-- <div style="text-align:center;">
						<iframe width="100%" height="500" src="https://www.youtube.com/embed/dYB6hosRR2U" frameborder="0" allowfullscreen=""></iframe>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</div>