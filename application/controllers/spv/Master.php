<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	/* Karyawan */
	public function karyawan_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'karyawan';
		$data['grand_child'] = '';
		$this->load->view('spv/template/header',$data);
		$this->load->view('spv/master/karyawan_data',$data);
		$this->load->view('spv/template/footer');
	}
	public function json_karyawan()
	{
		$get_data = $this->Main_model->getSelectedData('karyawan a', 'a.*,b.fullname,c.is_active,ccc.name', array('c.deleted'=>'0'), '', '', '', '', array(
			array(
				'table' => 'user_profile b',
				'on' => 'a.user_id=b.user_id',
				'pos' => 'LEFT'
			),
			array(
				'table' => 'user c',
				'on' => 'a.user_id=c.id',
				'pos' => 'LEFT'
			),
			array(
				'table' => 'user_to_role cc',
				'on' => 'a.user_id=cc.user_id',
				'pos' => 'LEFT'
			),
			array(
				'table' => 'user_role ccc',
				'on' => 'cc.role_id=ccc.id',
				'pos' => 'LEFT'
			)
		))->result();
		$data_tampil = array();
		$no = 1;
		foreach ($get_data as $key => $value) {
            if($value->user_id==$this->session->userdata('id')){
                echo'';
            }else{
                $isi['checkbox'] =	'
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value->user_id.'"/>
                                        <span></span>
                                    </label>
                                    ';
                $isi['number'] = $no++.'.';
                $isi['nama'] = $value->fullname;
                $isi['alamat'] = $value->alamat;
                $isi['no_hp'] = $value->no_hp;
                if($value->is_active=='1'){
                    $isi['status'] = '<span class="label label-success"> Aktif </span>';
                }else{
                    $isi['status'] = '<span class="label label-danger"> Non-Aktif </span>';
                }
                $isi['role'] = $value->name;
                $return_on_click = "return confirm('Anda yakin?')";
                $isi['action'] =	'
                                    <div class="btn-group" style="text-align: center;">
                                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="'.site_url('spv_side/ubah_data_karyawan/'.md5($value->user_id)).'">
                                                    <i class="icon-wrench"></i> Ubah Data </a>
                                            </li>
                                            <li>
                                                <a onclick="'.$return_on_click.'" href="'.site_url('spv_side/hapus_data_karyawan/'.md5($value->user_id)).'">
                                                    <i class="icon-trash"></i> Hapus Data </a>
                                            </li>
                                            <li class="divider"> </li>
                                            <li>
                                                <a href="'.site_url('spv_side/atur_ulang_kata_sandi_karyawan/'.md5($value->user_id)).'">
                                                    <i class="fa fa-refresh"></i> Atur Ulang Sandi
                                                </a>
                                            </li>
                                            <li>
                                                <a href="'.site_url('spv_side/non_aktifkan_akun_karyawan/'.md5($value->user_id)).'">
                                                    <i class="fa fa-close"></i> Non-aktifkan Akun
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    ';
                $data_tampil[] = $isi;
            }
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data_tampil),
			"iTotalDisplayRecords" => count($data_tampil),
			"aaData"=>$data_tampil);
		echo json_encode($results);
	}
	public function add_karyawan_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'karyawan';
		$data['grand_child'] = '';
		$this->load->view('spv/template/header',$data);
		$this->load->view('spv/master/add_karyawan_data',$data);
		$this->load->view('spv/template/footer');
	}
	public function save_karyawan_data()
	{
		$cek_ = $this->Main_model->getSelectedData('user a', 'a.*', array('a.username'=>$this->input->post('un')))->row();
		if($cek_==NULL){
			$this->db->trans_start();
			$get_user_id = $this->Main_model->getLastID('user','id');

			$data_insert1 = array(
				'id' => $get_user_id['id']+1,
				'username' => $this->input->post('un'),
				'pass' => $this->input->post('ps'),
				'is_active' => '1',
				'created_by' => $this->session->userdata('id'),
				'created_at' => date('Y-m-d H:i:s')
			);
			$this->Main_model->insertData('user',$data_insert1);
			// print_r($data_insert1);

			$data_insert2 = array(
				'user_id' => $get_user_id['id']+1,
				'fullname' => $this->input->post('fullname')
			);
			$this->Main_model->insertData('user_profile',$data_insert2);
			// print_r($data_insert2);

			$data_insert3 = array(
				'user_id' => $get_user_id['id']+1,
				'role_id' => $this->input->post('role')
			);
			$this->Main_model->insertData('user_to_role',$data_insert3);
			// print_r($data_insert3);

			$data_insert4 = array(
				'user_id' => $get_user_id['id']+1,
				'alamat' => $this->input->post('alamat'),
				'no_hp' => $this->input->post('no_hp')
			);
			$this->Main_model->insertData('karyawan',$data_insert4);
			// print_r($data_insert4);

			$this->db->trans_complete();
			if($this->db->trans_status() === false){
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."spv_side/tambah_data_karyawan/'</script>";
			}
			else{
				$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."spv_side/karyawan/'</script>";
			}
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Username telah digunakan.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/tambah_data_karyawan/'</script>";
		}
		
	}
	public function detail_karyawan_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'karyawan';
		$data['grand_child'] = '';
		$this->load->view('spv/template/header',$data);
		$this->load->view('spv/master/detail_karyawan_data',$data);
		$this->load->view('spv/template/footer');
	}
	public function edit_karyawan_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'karyawan';
		$data['grand_child'] = '';
		$data['data_utama'] = $this->Main_model->getSelectedData('user a', 'a.*,b.fullname,c.alamat,c.no_hp', array('md5(a.id)'=>$this->uri->segment(3),'a.deleted'=>'0'), '', '', '', '', array(
			array(
				'table' => 'user_profile b',
				'on' => 'a.id=b.user_id',
				'pos' => 'LEFT'
			),
			array(
				'table' => 'karyawan c',
				'on' => 'a.id=c.user_id',
				'pos' => 'LEFT'
			)
		))->row();
		$this->load->view('spv/template/header',$data);
		$this->load->view('spv/master/edit_karyawan_data',$data);
		$this->load->view('spv/template/footer');
	}
	public function update_karyawan_data()
	{
		if($this->input->post('un')!=NULL){
			$cek_ = $this->db->query("SELECT a.* FROM user a WHERE a.username='".$this->input->post('un')."' AND md5(a.id) NOT IN ('".$this->input->post('user_id')."')")->row();
			if($cek_==NULL){
				$this->db->trans_start();
				if($this->input->post('ps')!=NULL){
					$data_insert1 = array(
						'username' => $this->input->post('un'),
						'pass' => $this->input->post('ps')
					);
					$this->Main_model->updateData('user',$data_insert1,array('md5(id)'=>$this->input->post('user_id')));
					// print_r($data_insert1);
				}
				else{
					$data_insert1 = array(
						'username' => $this->input->post('un')
					);
					$this->Main_model->updateData('user',$data_insert1,array('md5(id)'=>$this->input->post('user_id')));
					// print_r($data_insert1);
				}
				$data_insert2 = array(
					'fullname' => $this->input->post('fullname')
				);
				$this->Main_model->updateData('user_profile',$data_insert2,array('md5(user_id)'=>$this->input->post('user_id')));
				// print_r($data_insert2);
				$data_insert3 = array(
					'alamat' => $this->input->post('alamat'),
					'no_hp' => $this->input->post('no_hp')
				);
				$this->Main_model->updateData('karyawan',$data_insert3,array('md5(user_id)'=>$this->input->post('user_id')));
				// print_r($data_insert3);
				$this->db->trans_complete();
				if($this->db->trans_status() === false){
					$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
					echo "<script>window.location='".base_url()."spv_side/ubah_data_karyawan/".$this->input->post('user_id')."'</script>";
				}
				else{
					$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
					echo "<script>window.location='".base_url()."spv_side/karyawan/'</script>";
				}
			}else{
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Username telah digunakan.<br /></div>' );
				echo "<script>window.location='".base_url()."spv_side/ubah_data_karyawan/".$this->input->post('user_id')."'</script>";
			}
		}elseif($this->input->post('ps')!=NULL){
			$this->db->trans_start();

			$data_insert1 = array(
				'pass' => $this->input->post('ps')
			);
			$this->Main_model->updateData('user',$data_insert1,array('md5(id)'=>$this->input->post('user_id')));
			// print_r($data_insert1);

			$this->db->trans_complete();
			if($this->db->trans_status() === false){
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
				echo "<script>window.location='".base_url()."spv_side/tambah_data_karyawan/'</script>";
			}
			else{
				$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
				echo "<script>window.location='".base_url()."spv_side/karyawan/'</script>";
			}
		}else{
			echo "<script>window.location='".base_url()."spv_side/karyawan/'</script>";
		}
	}
	public function reset_password_karyawan_account()
	{
		$this->db->trans_start();
		$user_id = '';
		$name = '';
		$get_data = $this->Main_model->getSelectedData('user_profile a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3)))->row();
		$user_id = $get_data->user_id;
		$name = $get_data->fullname;

		$this->Main_model->updateData('user', array('pass'=>'1234'),array('id'=>$user_id));

		$this->Main_model->log_activity($this->session->userdata('id'),"Update employee's data","Reset password employee's account (".$name.")",$this->session->userdata('location'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/karyawan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/karyawan/'</script>";
		}
	}
	public function non_aktifkan_akun_karyawan()
	{
		$this->db->trans_start();
		$user_id = '';
		$name = '';
		$get_data = $this->Main_model->getSelectedData('user_profile a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3)))->row();
		$user_id = $get_data->user_id;
		$name = $get_data->fullname;

		$this->Main_model->updateData('user', array('is_active'=>'0'),array('id'=>$user_id));

		$this->Main_model->log_activity($this->session->userdata('id'),"Update employee's data","Deactivate employee account (".$name.")",$this->session->userdata('location'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/karyawan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/karyawan/'</script>";
		}
	}
	public function delete_karyawan_data(){
		$this->db->trans_start();
		$user_id = '';
		$name = '';
		$get_data = $this->Main_model->getSelectedData('user_profile a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3)))->row();
		$user_id = $get_data->user_id;
		$name = $get_data->fullname;

		// $this->Main_model->deleteData('karyawan', array('user_id'=>$user_id));
		// $this->Main_model->deleteData('user_profile', array('user_id'=>$user_id));
		// $this->Main_model->deleteData('user_to_role', array('user_id'=>$user_id));
        // $this->Main_model->deleteData('user', array('id'=>$user_id));
        $this->Main_model->updateData('user', array('is_active'=>'0','deleted'=>'1'),array('id'=>$user_id));

		$this->Main_model->log_activity($this->session->userdata('id'),"Deleting employee's data","Delete employee's data (".$name.")",$this->session->userdata('location'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/karyawan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/karyawan/'</script>";
		}
	}
	/* Barang */
	public function barang_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'barang';
		$data['grand_child'] = '';
		$this->load->view('spv/template/header',$data);
		$this->load->view('spv/master/barang_data',$data);
		$this->load->view('spv/template/footer');
	}
	public function json_barang()
	{
		$get_data = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.deleted'=>'0'))->result();
		$data_tampil = array();
		$no = 1;
		foreach ($get_data as $key => $value) {
			$isi['checkbox'] =	'
								<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
									<input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value->id_barang.'"/>
									<span></span>
								</label>
								';
			$isi['number'] = $no++.'.';
			$isi['kode_barang'] = $value->kode_barang;
			$isi['nama_barang'] = $value->nama_barang;
			$isi['stok'] = number_format($value->stok,0);
			$isi['limit_stok'] = number_format($value->limit_stok,0);
			if($value->stok>$value->limit_stok){
				$isi['status'] = '<span class="label label-success"> Aman </span>';
			}else{
				$isi['status'] = '<span class="label label-danger"> Limit </span>';
			}
			$return_on_click = "return confirm('Anda yakin?')";
			$isi['action'] =	'
								<div class="btn-group" style="text-align: center;">
									<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
										<i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="'.site_url('spv_side/ubah_data_barang/'.md5($value->id_barang)).'">
												<i class="icon-wrench"></i> Ubah Data </a>
										</li>
										<li>
											<a onclick="'.$return_on_click.'" href="'.site_url('spv_side/hapus_data_barang/'.md5($value->id_barang)).'">
												<i class="icon-trash"></i> Hapus Data </a>
										</li>
									</ul>
								</div>
								';
			$data_tampil[] = $isi;
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data_tampil),
			"iTotalDisplayRecords" => count($data_tampil),
			"aaData"=>$data_tampil);
		echo json_encode($results);
	}
	public function add_barang_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'barang';
		$data['grand_child'] = '';
		$this->load->view('spv/template/header',$data);
		$this->load->view('spv/master/add_barang_data',$data);
		$this->load->view('spv/template/footer');
	}
	public function save_barang_data(){
		$this->db->trans_start();
		$get_id_barang = $this->Main_model->getLastID('barang','id_barang');
		$data_insert1 = array(
			'id_barang' => $get_id_barang['id_barang']+1,
			'kode_barang' => $this->input->post('kode_barang'),
			'nama_barang' => $this->input->post('nama_barang'),
			'stok' => $this->input->post('stok'),
			'limit_stok' => $this->input->post('limit'),
			'created_by' => $this->session->userdata('id'),
			'created_at' => date('Y-m-d H:i:s')
		);
		$this->Main_model->insertData('barang',$data_insert1);
		$this->Main_model->log_activity($this->session->userdata('id'),'Adding data',"Add barang data",$this->session->userdata('location'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/tambah_data_barang/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/barang/'</script>";
		}
	}
	public function detail_barang_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'barang';
		$data['grand_child'] = '';
		$data['data_utama'] = $this->Main_model->getSelectedData('barang a', 'a.*,e.jenis_usaha,f.nm_provinsi,b.nm_kabupaten,c.nm_kecamatan,d.nm_desa,g.jenis_usaha_pengembangan,gh.pendamping,gh.no_pendamping', array('md5(a.id_barang)'=>$this->uri->segment(3),'a.deleted'=>'0'), '', '', '', '', array(
			array(
				'table' => 'provinsi f',
				'on' => 'a.id_provinsi=f.id_provinsi',
				'pos' => 'left',
			),
			array(
				'table' => 'kabupaten b',
				'on' => 'a.id_kabupaten=b.id_kabupaten',
				'pos' => 'left',
			),
			array(
				'table' => 'kecamatan c',
				'on' => 'a.id_kecamatan=c.id_kecamatan',
				'pos' => 'left',
			),
			array(
				'table' => 'desa d',
				'on' => 'a.id_desa=d.id_desa',
				'pos' => 'left',
			),
			array(
				'table' => 'jenis_usaha e',
				'on' => 'a.id_jenis_usaha=e.id_jenis_usaha',
				'pos' => 'left',
			),
			array(
				'table' => 'jenis_usaha_pengembangan g',
				'on' => 'a.id_jenis_usaha_pengembangan=g.id_jenis_usaha_pengembangan',
				'pos' => 'LEFT'
			),
			array(
				'table' => 'pendamping gh',
				'on' => 'a.id_pendamping=gh.id_pendamping',
				'pos' => 'LEFT'
			)
		))->result();
		$this->load->view('spv/template/header',$data);
		$this->load->view('spv/master/detail_barang_data',$data);
		$this->load->view('spv/template/footer');
	}
	public function edit_barang_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'barang';
		$data['grand_child'] = '';
		$data['data_utama'] = $this->Main_model->getSelectedData('barang a', 'a.*', array('md5(a.id_barang)'=>$this->uri->segment(3),'a.deleted'=>'0'))->row();
		$this->load->view('spv/template/header',$data);
		$this->load->view('spv/master/edit_barang_data',$data);
		$this->load->view('spv/template/footer');
	}
	public function update_barang_data(){
		$this->db->trans_start();
		$data_update = array(
			'kode_barang' => $this->input->post('kode_barang'),
			'nama_barang' => $this->input->post('nama_barang'),
			'stok' => $this->input->post('stok'),
			'limit_stok' => $this->input->post('limit_stok')
		);
		$this->Main_model->updateData('barang',$data_update,array('md5(id_barang)'=>$this->input->post('id_barang')));
		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Update barang data",$this->session->userdata('location'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/ubah_data_barang/".$this->input->post('id_barang')."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/barang/'</script>";
		}
	}
	public function download_barang_data()
	{
		$get_data = '';
		if($this->input->post('kab')!=NULL){
			$get_data = $this->Main_model->getSelectedData('barang a', 'a.*,b.jenis_usaha,c.nm_provinsi,d.nm_kabupaten,e.nm_kecamatan,f.nm_desa', array('a.id_kabupaten'=>$this->input->post('kab'),'a.deleted'=>'0'), '', '', '', '', array(
				array(
					'table' => 'jenis_usaha b',
					'on' => 'a.id_jenis_usaha=b.id_jenis_usaha',
					'pos' => 'LEFT'
				),
				array(
					'table' => 'provinsi c',
					'on' => 'a.id_provinsi=c.id_provinsi',
					'pos' => 'LEFT'
				),
				array(
					'table' => 'kabupaten d',
					'on' => 'a.id_kabupaten=d.id_kabupaten',
					'pos' => 'LEFT'
				),
				array(
					'table' => 'kecamatan e',
					'on' => 'a.id_kecamatan=e.id_kecamatan',
					'pos' => 'LEFT'
				),
				array(
					'table' => 'desa f',
					'on' => 'a.id_desa=f.id_desa',
					'pos' => 'LEFT'
				)
			))->result();
		}else{
			$get_data = $this->Main_model->getSelectedData('barang a', 'a.*,b.jenis_usaha,c.nm_provinsi,d.nm_kabupaten,e.nm_kecamatan,f.nm_desa', array('a.id_provinsi'=>$this->input->post('prov'),'a.deleted'=>'0'), '', '', '', '', array(
				array(
					'table' => 'jenis_usaha b',
					'on' => 'a.id_jenis_usaha=b.id_jenis_usaha',
					'pos' => 'LEFT'
				),
				array(
					'table' => 'provinsi c',
					'on' => 'a.id_provinsi=c.id_provinsi',
					'pos' => 'LEFT'
				),
				array(
					'table' => 'kabupaten d',
					'on' => 'a.id_kabupaten=d.id_kabupaten',
					'pos' => 'LEFT'
				),
				array(
					'table' => 'kecamatan e',
					'on' => 'a.id_kecamatan=e.id_kecamatan',
					'pos' => 'LEFT'
				),
				array(
					'table' => 'desa f',
					'on' => 'a.id_desa=f.id_desa',
					'pos' => 'LEFT'
				)
			))->result();
		}
		$data['data_cetak'] = $get_data;
		$this->load->view('spv/master/cetak_data_barang',$data);
	}
	public function delete_barang_data(){
		$this->db->trans_start();
		$this->Main_model->updateData('barang', array('deleted'=>'1'),array('md5(id_barang)'=>$this->uri->segment(3)));

		$this->Main_model->log_activity($this->session->userdata('id'),'Deleting data',"Delete barang data",$this->session->userdata('location'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/barang/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/barang/'</script>";
		}
	}
	public function save_barang_member(){
		$this->db->trans_start();
		$cek = $this->Main_model->getSelectedData('user a', 'a.*', array('a.username'=>$this->input->post('nik')))->result();
		if($cek==NULL){
			$cek_nik = $this->Main_model->getSelectedData('anggota_barang a', 'a.*', array('a.nik'=>$this->input->post('nik')))->result();
			if($cek_nik==NULL){
				$cek_bdt = $this->Main_model->getSelectedData('anggota_barang a', 'a.*', array('b.bdt_id'=>$this->input->post('bdt'),'c.role_id'=>'2'), '', '', '', '', array(
					array(
						'table' => 'user_profile b',
						'on' => 'a.user_id=b.user_id',
						'pos' => 'left'
					),
					array(
						'table' => 'user_to_role c',
						'on' => 'a.user_id=c.user_id',
						'pos' => 'left'
					)
				))->result();
				if($cek_bdt==NULL){
					$get_barang = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.id_barang'=>$this->input->post('id_barang')))->row();
					$this->Main_model->updateData('barang a', array('a.rencana_anggaran'=>(($get_barang->rencana_anggaran)+'2000000')),array('a.id_barang'=>$this->input->post('id_barang'))); 				

					$get_user_id = $this->Main_model->getLastID('user','id');

					$data_insert1 = array(
						'id' => $get_user_id['id']+1,
						'username' => $this->input->post('nik'),
						'pass' => $this->input->post('nik'),
						'is_active' => '1',
						'created_by' => $this->session->userdata('id'),
						'created_at' => date('Y-m-d H:i:s')
					);
					$this->Main_model->insertData('user',$data_insert1);

					$data_insert2 = array(
						'user_id' => $get_user_id['id']+1,
						'fullname' => $this->input->post('nama'),
						'nin' => $this->input->post('nik'),
						'bdt_id' => $this->input->post('bdt')
					);
					$this->Main_model->insertData('user_profile',$data_insert2);

					$data_insert3 = array(
						'user_id' => $get_user_id['id']+1,
						'role_id' => '2'
					);
					$this->Main_model->insertData('user_to_role',$data_insert3);

					$data_insert4 = array(
						'user_id' => $get_user_id['id']+1,
						'id_barang' => $this->input->post('id_barang'),
						'nama' => $this->input->post('nama'),
						'nik' => $this->input->post('nik'),
						'jabatan_kelompok' => $this->input->post('jabatan_kelompok'),
						'no_kk' => $this->input->post('no_kk'),
						'no_hp' => $this->input->post('no_hp')
					);
					$this->Main_model->insertData('anggota_barang',$data_insert4);

					$this->Main_model->log_activity($this->session->userdata('id'),"Adding barang's member","Add barang member (".$this->input->post('nama').")",$this->session->userdata('location'));
					$this->db->trans_complete();
					if($this->db->trans_status() === false){
						$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
						echo "<script>window.location='".base_url()."spv_side/detil_data_barang/".md5($this->input->post('id_barang'))."'</script>";
					}
					else{
						$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
						echo "<script>window.location='".base_url()."spv_side/detil_data_barang/".md5($this->input->post('id_barang'))."'</script>";
					}
				}else{
					$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>BDT telah digunakan.<br /></div>' );
					echo "<script>window.location='".base_url()."spv_side/detil_data_barang/".md5($this->input->post('id_barang'))."'</script>";
				}
			}else{
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>NIK telah digunakan.<br /></div>' );
				echo "<script>window.location='".base_url()."spv_side/detil_data_barang/".md5($this->input->post('id_barang'))."'</script>";
			}
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>username telah digunakan.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/detil_data_barang/".md5($this->input->post('id_barang'))."'</script>";
		}
	}
	public function update_barang_member(){
		$this->db->trans_start();

		$data_update1 = array(
			'fullname' => $this->input->post('nama')
		);
		$this->Main_model->updateData('user_profile',$data_update1,array('md5(user_id)'=>$this->input->post('user_id')));

		$data_update2 = array(
			'nama' => $this->input->post('nama'),
			'nik' => $this->input->post('nik'),
			'jabatan_kelompok' => $this->input->post('jabatan_kelompok'),
			'no_kk' => $this->input->post('no_kk')
		);
		$this->Main_model->updateData('anggota_barang',$data_update2,array('md5(id_anggota_barang)'=>$this->input->post('id_anggota_barang')));

		$this->Main_model->log_activity($this->session->userdata('id'),"Updating barang's member","Update barang member (".$this->input->post('nama').")",$this->session->userdata('location'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/detil_data_barang/".$this->input->post('id_barang')."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/detil_data_barang/".$this->input->post('id_barang')."'</script>";
		}
	}
	public function json_anggota_barang(){
		$get_data = $this->Main_model->getSelectedData('anggota_barang a', 'a.*', array('md5(a.id_barang)'=>$this->input->get('id'),'b.deleted'=>'0'), '', '', '', '', array(
			'table' => 'barang b',
			'on' => 'a.id_barang=b.id_barang',
			'pos' => 'LEFT',
		))->result();
		$data_tampil = array();
		$no = 1;
		foreach ($get_data as $key => $value) {
			$isi['number'] = $no++.'.';
			$isi['nama'] = $value->nama;
			$isi['nik'] = $value->nik;
			$isi['jabatan'] = $value->jabatan_kelompok;
			$isi['no_kk'] = $value->no_kk;
			$return_on_click = "return confirm('Anda yakin?')";
			$isi['action'] =	'
								<div class="btn-group">
									<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
										<i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a class="ubahdata" data-toggle="modal" data-target="#ubahdata" id="'. md5($value->id_anggota_barang).'" data-code="'. md5($value->id_anggota_barang).'">
												<i class="icon-wrench"></i> Ubah Data </a>
										</li>
										<li>
											<a onclick="'.$return_on_click.'" href="'.site_url('spv_side/hapus_data_anggota_barang/'.md5($value->id_anggota_barang)).'">
												<i class="icon-trash"></i> Hapus Data </a>
										</li>
										<li class="divider"> </li>
										<li>
											<a href="'.site_url('spv_side/atur_ulang_kata_sandi_anggota_barang/'.md5($value->id_anggota_barang)).'">
												<i class="fa fa-refresh"></i> Atur Ulang Sandi
											</a>
										</li>
									</ul>
								</div>
								';
			$data_tampil[] = $isi;
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data_tampil),
			"iTotalDisplayRecords" => count($data_tampil),
			"aaData"=>$data_tampil);
		echo json_encode($results);
	}
	public function reset_password_barang_member_account(){
		$this->db->trans_start();
		$id_barang = '';
		$user_id = '';
		$name = '';
		$get_data = $this->Main_model->getSelectedData('anggota_barang a', 'a.*', array('md5(a.id_anggota_barang)'=>$this->uri->segment(3)))->row();
		$id_barang = md5($get_data->id_barang);
		$user_id = $get_data->user_id;
		$name = $get_data->nama;

		$this->Main_model->updateData('user', array('pass'=>'1234'),array('id'=>$user_id));

		$this->Main_model->log_activity($this->session->userdata('id'),"Update barang's member data","Reset password barang's member account (".$name.")",$this->session->userdata('location'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/detil_data_barang/".$id_barang."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/detil_data_barang/".$id_barang."'</script>";
		}
	}
	public function delete_barang_member(){
		$this->db->trans_start();
		$id_barang = '';
		$user_id = '';
		$name = '';
		$get_data = $this->Main_model->getSelectedData('anggota_barang a', 'a.*', array('md5(a.id_anggota_barang)'=>$this->uri->segment(3)))->row();
		$id_barang = md5($get_data->id_barang);
		$user_id = $get_data->user_id;
		$name = $get_data->nama;

		$this->Main_model->updateData('barang', array('a.rencana_anggaran'=>(($get_data->rencana_anggaran)-'2000000')),array('a.id_barang'=>$get_data->id_barang));

		$this->Main_model->deleteData('anggota_barang', array('user_id'=>$user_id));
		$this->Main_model->deleteData('user_profile', array('user_id'=>$user_id));
		$this->Main_model->deleteData('user_to_role', array('user_id'=>$user_id));
		$this->Main_model->deleteData('user', array('id'=>$user_id));

		$this->Main_model->log_activity($this->session->userdata('id'),"Deleting barang's member","Delete barang's member (".$name.")",$this->session->userdata('location'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/detil_data_barang/".$id_barang."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."spv_side/detil_data_barang/".$id_barang."'</script>";
		}
	}
	/* Other Function */
	public function ajax_function(){
		if($this->input->post('modul')=='username_check'){
			$data = $this->Main_model->getSelectedData('user a', 'a.*', array('a.username'=>$this->input->post('username')))->result();
			if($data==NULL){
				echo 'Username tersedia';
			}else{
				echo '<font color="red">Username tidak tersedia</font>';
			}
		}
		elseif($this->input->post('modul')=='username_check_when_data_edit'){
			$cek = $this->Main_model->getSelectedData('user a', 'a.*', array('md5(a.id)'=>$this->input->post('user_id')))->row();
			if($cek->username==$this->input->post('username')){
				echo'';
			}else{
				$data = $this->Main_model->getSelectedData('user a', 'a.*', array('a.username'=>$this->input->post('username')))->result();
				if($data==NULL){
					echo 'Username tersedia';
				}else{
					echo '<font color="red">Username tidak tersedia</font>';
				}
			}
		}
		elseif($this->input->post('modul')=='cek_kode_barang'){
			$data = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.kode_barang'=>$this->input->post('kode_barang')))->result();
			if($data==NULL){
				echo 'Kode barang tersedia';
			}else{
				echo '<font color="red">Kode barang tidak tersedia</font>';
			}
		}
		elseif($this->input->post('modul')=='get_desa_by_id_kecamatan'){
			$data = $this->Main_model->getSelectedData('desa a', 'a.*', array('a.id_kecamatan'=>$this->input->post('id')))->result();
			echo'<option value=""></option>';
			foreach ($data as $key => $value) {
				echo'<option value="'.$value->id_desa.'">'.$value->nm_desa.'</option>';
			}
		}
		elseif($this->input->post('modul')=='get_anggota_barang_by_id_barang'){
			$data = $this->Main_model->getSelectedData('anggota_barang a', 'a.*', array('a.id_barang'=>$this->input->post('id')))->result();
			echo'<option value=""></option>';
			foreach ($data as $key => $value) {
				echo'<option value="'.$value->id_anggota_barang.'-'.$value->user_id.'">'.$value->nama.'</option>';
			}
		}
		elseif($this->input->post('modul')=='get_anggota_rutilahu_by_id_rutilahu'){
			$data = $this->Main_model->getSelectedData('anggota_rutilahu a', 'a.*', array('a.id_rutilahu'=>$this->input->post('id')))->result();
			echo'<option value=""></option>';
			foreach ($data as $key => $value) {
				echo'<option value="'.$value->id_anggota_rutilahu.'-'.$value->user_id.'">'.$value->nama.'</option>';
			}
		}
		elseif($this->input->post('modul')=='modul_ubah_data_anggota_barang'){
			$data = $this->Main_model->getSelectedData('anggota_barang a', 'a.*', array('md5(a.id_anggota_barang)'=>$this->input->post('id')))->row();
			echo'
			<form role="form" class="form-horizontal" action="'.base_url('spv_side/perbarui_data_anggota_barang').'" method="post" >
				<input type="hidden" name="id_anggota_barang" value="'.md5($data->id_anggota_barang).'">
				<input type="hidden" name="user_id" value="'.md5($data->user_id).'">
				<input type="hidden" name="id_barang" value="'.md5($data->id_barang).'">
				<div class="form-body">
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">Nama Lengkap <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="nama" value="'.$data->nama.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="fa fa-user"></i>
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">NIK (Nomor Induk Kependudukan) <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="nik" value="'.$data->nik.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="fa fa-credit-card"></i>
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">Jabatan Kelompok <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="jabatan_kelompok" value="'.$data->jabatan_kelompok.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="icon-badge"></i>
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">Nomor KK <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="no_kk" value="'.$data->no_kk.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="fa fa-credit-card"></i>
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">Nomor HP</label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="no_hp" value="'.$data->no_hp.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="fa fa-credit-card"></i>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="form-actions margin-top-9">
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<button type="reset" class="btn default">Batal</button>
							<button type="submit" class="btn blue">Perbarui</button>
						</div>
					</div>
				</div>
			</form>
			';
		}
		elseif($this->input->post('modul')=='modul_ubah_data_anggota_rutilahu'){
			$data = $this->Main_model->getSelectedData('anggota_rutilahu a', 'a.*', array('md5(a.id_anggota_rutilahu)'=>$this->input->post('id')))->row();
			echo'
			<form role="form" class="form-horizontal" action="'.base_url('spv_side/perbarui_data_anggota_rutilahu').'" method="post" >
				<input type="hidden" name="id_anggota_rutilahu" value="'.md5($data->id_anggota_rutilahu).'">
				<input type="hidden" name="user_id" value="'.md5($data->user_id).'">
				<input type="hidden" name="id_rutilahu" value="'.md5($data->id_rutilahu).'">
				<div class="form-body">
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">Nama Lengkap <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="nama" value="'.$data->nama.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="fa fa-user"></i>
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">NIK (Nomor Induk Kependudukan) <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="nik" value="'.$data->nik.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="fa fa-credit-card"></i>
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">Jabatan Kelompok <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="jabatan_kelompok" value="'.$data->jabatan_kelompok.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="icon-badge"></i>
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">Nomor KK <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="no_kk" value="'.$data->no_kk.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="fa fa-credit-card"></i>
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">Nomor HP</label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="no_hp" value="'.$data->no_hp.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="fa fa-credit-card"></i>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="form-actions margin-top-9">
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<button type="reset" class="btn default">Batal</button>
							<button type="submit" class="btn blue">Perbarui</button>
						</div>
					</div>
				</div>
			</form>
			';
		}
		elseif($this->input->post('modul')=='modul_ubah_data_anggota_sarling'){
			$data = $this->Main_model->getSelectedData('anggota_sarling a', 'a.*', array('md5(a.id_anggota_sarling)'=>$this->input->post('id')))->row();
			echo'
			<form role="form" class="form-horizontal" action="'.base_url('spv_side/perbarui_data_anggota_sarling').'" method="post" >
				<input type="hidden" name="id_anggota_sarling" value="'.md5($data->id_anggota_sarling).'">
				<input type="hidden" name="user_id" value="'.md5($data->user_id).'">
				<input type="hidden" name="id_sarling" value="'.md5($data->id_sarling).'">
				<div class="form-body">
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">Nama Lengkap <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="nama" value="'.$data->nama.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="fa fa-user"></i>
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">NIK (Nomor Induk Kependudukan) <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="nik" value="'.$data->nik.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="fa fa-credit-card"></i>
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">Jabatan Tim <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="jabatan_kelompok" value="'.$data->jabatan_kelompok.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="icon-badge"></i>
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input has-danger">
						<label class="col-md-3 control-label" for="form_control_1">Jabatan di Masyarakat <span class="required"> * </span></label>
						<div class="col-md-9">
							<div class="input-icon">
								<input type="text" class="form-control" name="jabatan_masyarakat" value="'.$data->jabatan_masyarakat.'" required>
								<div class="form-control-focus"> </div>
								<span class="help-block">Some help goes here...</span>
								<i class="icon-badge"></i>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="form-actions margin-top-9">
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<button type="reset" class="btn default">Batal</button>
							<button type="submit" class="btn blue">Perbarui</button>
						</div>
					</div>
				</div>
			</form>
			';
		}
		elseif($this->input->post('modul')=='get_isian_indikator_by_id_barang'){
			$data['indikator'] = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
			$data['data_master'] = $this->Main_model->getSelectedData('status_laporan_barang a', 'a.*', array('a.id_barang'=>$this->input->post('id')), '','1')->row();
			$this->load->view('spv/report/ajax_list_indicator1',$data);
			// print_r($data);
		}
		elseif($this->input->post('modul')=='get_isian_indikator_by_id_rutilahu'){
			$data['indikator'] = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
			$data['data_master'] = $this->Main_model->getSelectedData('status_laporan_rutilahu a', 'a.*', array('a.id_rutilahu'=>$this->input->post('id')), '','1')->row();
			$this->load->view('spv/report/ajax_list_indicator2',$data);
			// print_r($data);
		}
		elseif($this->input->post('modul')=='get_isian_indikator_by_id_sarling'){
			$data['indikator'] = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
			$data['data_master'] = $this->Main_model->getSelectedData('status_laporan_sarling a', 'a.*', array('a.id_sarling'=>$this->input->post('id')), '','1')->row();
			$this->load->view('spv/report/ajax_list_indicator3',$data);
			// print_r($data);
		}
		elseif($this->input->post('modul')=='get_isian_rencana_anggaran_pengadaan_by_id_barang'){
			$id_barang = $this->input->post('id');
			$get_anggaran = $this->db->query("SELECT a.* FROM laporan_barang a LEFT JOIN detail_laporan_barang_aspek_keuangan b ON a.id_laporan_barang=b.id_laporan_barang WHERE id_barang='".$id_barang."' AND a.deleted='0' AND b.id_master_indikator='1'")->result();
			$nilai = 0;
			foreach ($get_anggaran as $key => $value) {
				$nilai += $value->anggaran;
			}
			echo'Telah dilaporkan Rp '.number_format($nilai,2).' pada laporan sebelumnya';
		}
		elseif($this->input->post('modul')=='get_isian_rencana_anggaran_proses_by_id_barang'){
			$id_barang = $this->input->post('id');
			$get_anggaran = $this->db->query("SELECT a.* FROM laporan_barang a LEFT JOIN detail_laporan_barang_aspek_keuangan b ON a.id_laporan_barang=b.id_laporan_barang WHERE id_barang='".$id_barang."' AND a.deleted='0' AND b.id_master_indikator='2'")->result();
			$nilai = 0;
			foreach ($get_anggaran as $key => $value) {
				$nilai += $value->anggaran;
			}
			echo'Telah dilaporkan Rp '.number_format($nilai,2).' pada laporan sebelumnya';
		}
		elseif($this->input->post('modul')=='get_isian_rencana_anggaran_benefit_by_id_barang'){
			$id_barang = $this->input->post('id');
			$get_anggaran = $this->db->query("SELECT a.* FROM laporan_barang a LEFT JOIN detail_laporan_barang_aspek_keuangan b ON a.id_laporan_barang=b.id_laporan_barang WHERE id_barang='".$id_barang."' AND a.deleted='0' AND b.id_master_indikator='3'")->result();
			$nilai = 0;
			foreach ($get_anggaran as $key => $value) {
				$nilai += $value->anggaran;
			}
			echo'Telah dilaporkan Rp '.number_format($nilai,2).' pada laporan sebelumnya';
		}
		elseif($this->input->post('modul')=='get_isian_rencana_anggaran_pengadaan_by_id_rutilahu'){
			$id_rutilahu = $this->input->post('id');
			$get_anggaran = $this->db->query("SELECT a.* FROM laporan_rutilahu a LEFT JOIN detail_laporan_rutilahu_aspek_keuangan b ON a.id_laporan_rutilahu=b.id_laporan_rutilahu WHERE id_rutilahu='".$id_rutilahu."' AND a.deleted='0' AND b.id_master_indikator='1'")->result();
			$nilai = 0;
			foreach ($get_anggaran as $key => $value) {
				$nilai += $value->anggaran;
			}
			echo'Telah dilaporkan Rp '.number_format($nilai,2).' pada laporan sebelumnya';
		}
		elseif($this->input->post('modul')=='get_isian_rencana_anggaran_proses_by_id_rutilahu'){
			$id_rutilahu = $this->input->post('id');
			$get_anggaran = $this->db->query("SELECT a.* FROM laporan_rutilahu a LEFT JOIN detail_laporan_rutilahu_aspek_keuangan b ON a.id_laporan_rutilahu=b.id_laporan_rutilahu WHERE id_rutilahu='".$id_rutilahu."' AND a.deleted='0' AND b.id_master_indikator='2'")->result();
			$nilai = 0;
			foreach ($get_anggaran as $key => $value) {
				$nilai += $value->anggaran;
			}
			echo'Telah dilaporkan Rp '.number_format($nilai,2).' pada laporan sebelumnya';
		}
		elseif($this->input->post('modul')=='get_isian_rencana_anggaran_benefit_by_id_rutilahu'){
			$id_rutilahu = $this->input->post('id');
			$get_anggaran = $this->db->query("SELECT a.* FROM laporan_rutilahu a LEFT JOIN detail_laporan_rutilahu_aspek_keuangan b ON a.id_laporan_rutilahu=b.id_laporan_rutilahu WHERE id_rutilahu='".$id_rutilahu."' AND a.deleted='0' AND b.id_master_indikator='3'")->result();
			$nilai = 0;
			foreach ($get_anggaran as $key => $value) {
				$nilai += $value->anggaran;
			}
			echo'Telah dilaporkan Rp '.number_format($nilai,2).' pada laporan sebelumnya';
		}
		elseif($this->input->post('modul')=='get_isian_rencana_anggaran_pengadaan_by_id_sarling'){
			$id_sarling = $this->input->post('id');
			$get_anggaran = $this->db->query("SELECT a.* FROM laporan_sarling a LEFT JOIN detail_laporan_sarling_aspek_keuangan b ON a.id_laporan_sarling=b.id_laporan_sarling WHERE id_sarling='".$id_sarling."' AND a.deleted='0' AND b.id_master_indikator='1'")->result();
			$nilai = 0;
			foreach ($get_anggaran as $key => $value) {
				$nilai += $value->anggaran;
			}
			echo'Telah dilaporkan Rp '.number_format($nilai,2).' pada laporan sebelumnya';
		}
		elseif($this->input->post('modul')=='get_isian_rencana_anggaran_proses_by_id_sarling'){
			$id_sarling = $this->input->post('id');
			$get_anggaran = $this->db->query("SELECT a.* FROM laporan_sarling a LEFT JOIN detail_laporan_sarling_aspek_keuangan b ON a.id_laporan_sarling=b.id_laporan_sarling WHERE id_sarling='".$id_sarling."' AND a.deleted='0' AND b.id_master_indikator='2'")->result();
			$nilai = 0;
			foreach ($get_anggaran as $key => $value) {
				$nilai += $value->anggaran;
			}
			echo'Telah dilaporkan Rp '.number_format($nilai,2).' pada laporan sebelumnya';
		}
		elseif($this->input->post('modul')=='get_isian_rencana_anggaran_benefit_by_id_sarling'){
			$id_sarling = $this->input->post('id');
			$get_anggaran = $this->db->query("SELECT a.* FROM laporan_sarling a LEFT JOIN detail_laporan_sarling_aspek_keuangan b ON a.id_laporan_sarling=b.id_laporan_sarling WHERE id_sarling='".$id_sarling."' AND a.deleted='0' AND b.id_master_indikator='3'")->result();
			$nilai = 0;
			foreach ($get_anggaran as $key => $value) {
				$nilai += $value->anggaran;
			}
			echo'Telah dilaporkan Rp '.number_format($nilai,2).' pada laporan sebelumnya';
		}
		// elseif($this->input->post('modul')=='get_indikator_by_tipe'){
		// 	$data = $this->Main_model->getSelectedData('indikator a', 'a.*', array('a.id_master_indikator'=>$this->input->post('id')))->result();
		// 	echo'<div class="md-checkbox-list">';
		// 		foreach ($data as $key => $value) {
		// 			echo'
		// 			<div class="md-checkbox">
		// 				<input type="checkbox" id="'.$value->id_indikator.'" value="'.$value->id_indikator.'" name="indikator[]" class="md-check">
		// 				<label for="'.$value->id_indikator.'">
		// 					<span class="inc"></span>
		// 					<span class="check"></span>
		// 					<span class="box"></span> '.$value->indikator.' </label>
		// 			</div>
		// 			';
		// 		}
		// 	echo'</div>';
			// echo'<option value=""></option>';
			// foreach ($data as $key => $value) {
			// 	echo'<option value="'.$value->id_indikator.'">'.$value->indikator.'</option>';
			// }
		// }
	}
	public function hapus_anggota_barang(){
		$get_data = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.role_id'=>'2'))->result();
		foreach ($get_data as $key => $value) {
			$user_id = $value->user_id;
			$this->Main_model->deleteData('user_profile', array('user_id'=>$user_id));
			$this->Main_model->deleteData('user_to_role', array('user_id'=>$user_id));
			$this->Main_model->deleteData('user', array('id'=>$user_id));
		}
	}
}