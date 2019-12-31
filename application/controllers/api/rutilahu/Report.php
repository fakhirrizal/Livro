<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Report extends REST_Controller {

	function __construct()
	{
		parent::__construct();

		$this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
		$this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
		$this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
	}

	function index_get() {
		if($this->get('id_rutilahu')!=NULL){
			$hasil['data_utama'] = $this->Main_model->getSelectedData('status_laporan_rutilahu a', 'a.*', array('a.id_rutilahu'=>$this->get('id_rutilahu')))->row();
			$hasil['data_laporan'] = $this->Main_model->getSelectedData('laporan_rutilahu a', 'a.id_laporan_rutilahu,b.fullname AS pelapor,a.indikator,a.persentase_fisik,a.anggaran,a.persentase_anggaran,a.persentase_realisasi,a.keterangan,a.created_at',array('a.id_rutilahu'=>$this->get('id_rutilahu'),'a.deleted'=>'0'),'','','','',array(
				'table' => 'user_profile b',
				'on' => 'a.user_id=b.user_id',
				'pos' => 'LEFT'
			))->result();
			$this->response($hasil, 200);
		}elseif($this->get('id_laporan_rutilahu')!=NULL){
			$hasil['data_utama'] = $this->Main_model->getSelectedData('laporan_rutilahu a', 'a.id_laporan_rutilahu,b.fullname AS pelapor,a.indikator,a.persentase_fisik,a.anggaran,a.persentase_anggaran,a.persentase_realisasi,a.keterangan,a.created_at',array('a.id_laporan_rutilahu'=>$this->get('id_laporan_rutilahu'),'a.deleted'=>'0'),'','','','',array(
				'table' => 'user_profile b',
				'on' => 'a.user_id=b.user_id',
				'pos' => 'LEFT'
			))->row();
			$hasil['progres_fisik'] = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_fisik a', 'a.id_laporan_rutilahu,b.master_indikator AS tipe,c.indikator,a.penjelasan_progres_fisik',array('a.id_laporan_rutilahu'=>$this->get('id_laporan_rutilahu')),'','','','',array(
				array(
					'table' => 'master_indikator b',
					'on' => 'a.id_master_indikator=b.id_master_indikator',
					'pos' => 'LEFT'
				),
				array(
					'table' => 'indikator c',
					'on' => 'a.indikator_progres_fisik=c.id_indikator',
					'pos' => 'LEFT'
				)
			))->result();
			$hasil['progres_keuangan'] = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_keuangan a', 'a.id_laporan_rutilahu,b.master_indikator AS tipe,a.progres_keuangan,a.penjelasan_progres_keuangan',array('a.id_laporan_rutilahu'=>$this->get('id_laporan_rutilahu')),'','','','',array(
				'table' => 'master_indikator b',
				'on' => 'a.id_master_indikator=b.id_master_indikator',
				'pos' => 'LEFT'
			))->result();
			$this->response($hasil, 200);
		}
		else{
			$get_id_laporan_rutilahu = $this->Main_model->getLastID('laporan_rutilahu','id_laporan_rutilahu');
			$hasil['id_laporan_rutilahu'] = $get_id_laporan_rutilahu['id_laporan_rutilahu']+1;
			$this->response($hasil, 200);
		}
	}

	/*
	function index_post(){
		if($this->post('id_rutilahu')!=NULL){
			$this->db->trans_start();
			$get_data_anggota = $this->Main_model->getSelectedData('anggota_rutilahu a', 'a.*', array('a.id_anggota_rutilahu'=>$this->post('id_anggota_rutilahu')))->row();
			$data_insert1 = array(
				'id_laporan_rutilahu' => $this->post('id_laporan_rutilahu'),
				'id_anggota_rutilahu' => $this->post('id_anggota_rutilahu'),
				'user_id' => $get_data_anggota->user_id,
				'id_rutilahu' => $this->post('id_rutilahu'),
				'keterangan' => $this->post('keterangan'),
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $get_data_anggota->user_id
			);
			$this->Main_model->insertData('laporan_rutilahu',$data_insert1);
			$this->db->trans_complete();
			if($this->db->trans_status() === false){
				$hasil['status'] = 'Gagal';
				$this->response($hasil, 200);
			}
			else{
				$hasil['status'] = 'Sukses';
				$this->response($hasil, 200);
			}
		}elseif($this->post('indikator_progres_fisik')!=NULL){
			$this->db->trans_start();
			$get_laporan_rutilahu = $this->Main_model->getSelectedData('laporan_rutilahu a', 'a.*', array('a.id_laporan_rutilahu'=>$this->post('id_laporan_rutilahu'),'a.deleted'=>'0'),'a.created_at DESC','1')->row();
			$var_array_push[] = $this->post('indikator_progres_fisik');
			$get_total_indikator = array_unique(array_merge(explode(',',$get_laporan_rutilahu->indikator),$var_array_push));
			$get_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*')->result();
			$data_insert1 = array(
				'indikator' => implode(',',$get_total_indikator),
				'persentase_fisik' => (count($get_total_indikator)/count($get_indikator))*100,
				'persentase_realisasi' => (((count($get_total_indikator)/count($get_indikator))*100)+($get_laporan_rutilahu->persentase_anggaran))/2
			);
			// print_r($data_insert1);
			$this->Main_model->updateData('laporan_rutilahu',$data_insert1,array('id_laporan_indikator'=>$this->post('id_laporan_rutilahu')));
			$data_insert2 = array(
				'id_laporan_rutilahu' => $this->post('id_laporan_rutilahu'),
				'id_master_indikator' => $this->post('id_tipe_indikator'),
				'indikator_progres_fisik' => $this->post('indikator_progres_fisik'),
				'penjelasan_progres_fisik' => $this->post('penjelasan_progres_fisik')
			);
			// print_r($data_insert2);
			$this->Main_model->insertData('detail_laporan_rutilahu_aspek_fisik',$data_insert2);
			$get_status_laporan_rutilahu = $this->Main_model->getSelectedData('status_laporan_rutilahu a', 'a.*', array('a.id_rutilahu'=>$get_laporan_rutilahu->id_rutilahu))->row();
			if($get_status_laporan_rutilahu==NULL){
				$persentase_realisasi = ((count($get_total_indikator)/count($get_indikator))*100)/2;
				$data_insert3 = array(
					'id_rutilahu' => $get_laporan_rutilahu->id_rutilahu,
					'indikator' => implode(',',$get_total_indikator),
					'persentase_fisik' => (count($get_total_indikator)/count($get_indikator))*100,
					'anggaran' => '0',
					'persentase_anggaran' => '0',
					'persentase_realisasi' => $persentase_realisasi
				);
				// print_r($data_insert3);
				$this->Main_model->insertData('status_laporan_rutilahu',$data_insert3);
			}else{
				$bb = explode(',',$get_status_laporan_rutilahu->indikator);
				$c = array_unique(array_merge($get_total_indikator,$bb));
				$d = implode(',',$c);
				$persentase_fisik = (count($c)/count($get_indikator))*100;
				$persentase_realisasi = ($get_status_laporan_rutilahu->persentase_anggaran+$persentase_fisik)/2;
				$data_insert3 = array(
					'indikator' => $d,
					'persentase_fisik' => $persentase_fisik,
					'persentase_realisasi' => $persentase_realisasi
				);
				// print_r($data_insert3);
				$this->Main_model->updateData('status_laporan_rutilahu',$data_insert3,array('id_rutilahu'=>$get_status_laporan_rutilahu->id_rutilahu));
			}
			$this->db->trans_complete();
			if($this->db->trans_status() === false){
				$hasil['status'] = 'Gagal';
				$this->response($hasil, 200);
			}
			else{
				$hasil['status'] = 'Sukses';
				$this->response($hasil, 200);
			}
		}elseif($this->post('progres_keuangan')!=NULL){
			$this->db->trans_start();
			$get_laporan_rutilahu = $this->Main_model->getSelectedData('laporan_rutilahu a', 'a.*,f.rencana_anggaran', array('a.id_laporan_rutilahu'=>$this->post('id_laporan_rutilahu'),'a.deleted'=>'0'),'a.created_at DESC','1','','',array(
				'table' => 'rutilahu f',
				'on' => 'a.id_rutilahu=f.id_rutilahu',
				'pos' => 'LEFT'
			))->row();
			$data_insert1 = array(
				'anggaran' => $get_laporan_rutilahu->anggaran+$this->post('progres_keuangan'),
				'persentase_anggaran' => (($get_laporan_rutilahu->anggaran+$this->post('progres_keuangan'))/($get_laporan_rutilahu->rencana_anggaran))*100,
				'persentase_realisasi' => (((($get_laporan_rutilahu->anggaran+$this->post('progres_keuangan'))/($get_laporan_rutilahu->rencana_anggaran))*100)+($get_laporan_rutilahu->persentase_fisik))/2
			);
			// print_r($data_insert1);
			$this->Main_model->updateData('laporan_rutilahu',$data_insert1,array('id_laporan_indikator'=>$this->post('id_laporan_rutilahu')));
			$data_insert2 = array(
				'id_laporan_rutilahu' => $this->post('id_laporan_rutilahu'),
				'id_master_indikator' => $this->post('id_tipe_indikator'),
				'progres_keuangan' => $this->post('progres_keuangan'),
				'penjelasan_progres_keuangan' => $this->post('penjelasan_progres_keuangan')
			);
			// print_r($data_insert2);
			$this->Main_model->insertData('detail_laporan_rutilahu_aspek_keuangan',$data_insert2);
			$get_status_laporan_rutilahu = $this->Main_model->getSelectedData('status_laporan_rutilahu a', 'a.*', array('a.id_rutilahu'=>$get_laporan_rutilahu->id_rutilahu))->row();
			if($get_status_laporan_rutilahu==NULL){
				$data_insert3 = array(
					'id_rutilahu' => $get_laporan_rutilahu->id_rutilahu,
					'persentase_fisik' => '0',
					'anggaran' => $this->post('progres_keuangan'),
					'persentase_anggaran' => (($get_laporan_rutilahu->anggaran+$this->post('progres_keuangan'))/($get_laporan_rutilahu->rencana_anggaran))*100,
					'persentase_realisasi' => (((($get_laporan_rutilahu->anggaran+$this->post('progres_keuangan'))/($get_laporan_rutilahu->rencana_anggaran))*100)+($get_laporan_rutilahu->persentase_fisik))/2
				);
				// print_r($data_insert3);
				$this->Main_model->insertData('status_laporan_rutilahu',$data_insert3);
			}else{
				$persentase_anggaran = (((($get_laporan_rutilahu->anggaran+$this->post('progres_keuangan'))/($get_laporan_rutilahu->rencana_anggaran))*100)+$get_status_laporan_rutilahu->persentase_anggaran)/2;
				$persentase_realisasi = ($get_status_laporan_rutilahu->persentase_fisik+$persentase_anggaran)/2;
				$data_insert3 = array(
					'anggaran' => $this->post('progres_keuangan')+$get_status_laporan_rutilahu->anggaran,
					'persentase_anggaran' => $persentase_anggaran,
					'persentase_realisasi' => $persentase_realisasi
				);
				// print_r($data_insert3);
				$this->Main_model->updateData('status_laporan_rutilahu',$data_insert3,array('id_rutilahu'=>$get_status_laporan_rutilahu->id_rutilahu));
			}
			$this->db->trans_complete();
			if($this->db->trans_status() === false){
				$hasil['status'] = 'Gagal';
				$this->response($hasil, 200);
			}
			else{
				$hasil['status'] = 'Sukses';
				$this->response($hasil, 200);
			}
		}
	}
	*/
	function index_post(){
		$this->db->trans_start();
		$get_id_laporan_rutilahu = $this->Main_model->getLastID('laporan_rutilahu','id_laporan_rutilahu');
        $get_data_rutilahu = $this->Main_model->getSelectedData('rutilahu a', 'a.*,(SELECT k.id_anggota_rutilahu FROM anggota_rutilahu k WHERE k.id_rutilahu=a.id_rutilahu AND k.jabatan_kelompok="Ketua") AS ketua,(SELECT i.user_id FROM anggota_rutilahu i WHERE i.id_rutilahu=a.id_rutilahu AND i.jabatan_kelompok="Ketua") AS id_ketua', array('a.id_rutilahu'=>$this->post('data_utama')['id_rutilahu']))->row();
        $get_status_laporan_rutilahu = $this->Main_model->getSelectedData('status_laporan_rutilahu a', 'a.*', array('a.id_rutilahu'=>$this->post('data_utama')['id_rutilahu']))->row();
		$get_data_anggota = $this->Main_model->getSelectedData('anggota_rutilahu a', 'a.*', array('a.id_anggota_rutilahu'=>$this->post('data_utama')['id_anggota_rutilahu']))->row();
		$data_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*', array('a.program'=>'2'))->result();
		c 
		$total_uang = 0;
		$progres_keuangan = $this->post('progres_keuangan');
		foreach ($progres_keuangan as $key => $value) {
			$total_uang += $value['progres_keuangan'];
			$data_insert2b = array(
				'id_laporan_rutilahu' => $get_id_laporan_rutilahu['id_laporan_rutilahu']+1,
				'id_master_indikator' => $value['id_tipe_indikator'],
				'progres_keuangan' => $value['progres_keuangan']
			);
			// print_r($data_insert2b);
			$this->Main_model->insertData('detail_laporan_rutilahu_aspek_keuangan',$data_insert2b);
		}

		$get_indikator = array();
		$progres_fisik = $this->post('progres_fisik');
		foreach ($progres_fisik as $key => $value) {
			array_push($get_indikator,$value['indikator_progres_fisik']);
			$data_insert2a = array(
				'id_laporan_rutilahu' => $get_id_laporan_rutilahu['id_laporan_rutilahu']+1,
				'id_master_indikator' => $value['id_tipe_indikator'],
				'indikator_progres_fisik' => $value['indikator_progres_fisik'],
				'penjelasan_progres_fisik' => $value['penjelasan_progres_fisik']
			);
			// print_r($data_insert2a);
			$this->Main_model->insertData('detail_laporan_rutilahu_aspek_fisik',$data_insert2a);
		}
		
		$data_insert1 = array(
            'id_laporan_rutilahu' => $get_id_laporan_rutilahu['id_laporan_rutilahu']+1,
			'id_anggota_rutilahu' => $this->post('data_utama')['id_anggota_rutilahu'],
			'user_id' => $get_data_anggota->user_id,
			'id_rutilahu' => $this->post('data_utama')['id_rutilahu'],
            'indikator' => implode(',',$get_indikator),
            'persentase_fisik' => ((count($get_indikator))/(count($data_indikator)))*100,
            'anggaran' => $total_uang,
            'persentase_anggaran' => ($total_uang/$get_data_rutilahu->rencana_anggaran)*100,
            'persentase_realisasi' => ((((count($get_indikator))/(count($data_indikator)))*100)+(($total_uang/$get_data_rutilahu->rencana_anggaran)*100))/2,
            'keterangan' => $this->post('data_utama')['keterangan'],
			'created_at' => date('Y-m-d H:i:s'),
			'created_by' => $get_data_anggota->user_id
        );
        // print_r($data_insert1);
		$this->Main_model->insertData('laporan_rutilahu',$data_insert1);
		
		if($get_status_laporan_rutilahu==NULL){
            $data_insert3 = array(
                'id_rutilahu' => $this->post('data_utama')['id_rutilahu'],
                'indikator' => implode(',',$get_indikator),
                'persentase_fisik' => ((count($get_indikator))/(count($data_indikator)))*100,
                'anggaran' => $total_uang,
                'persentase_anggaran' => ($total_uang/$get_data_rutilahu->rencana_anggaran)*100,
            	'persentase_realisasi' => ((((count($get_indikator))/(count($data_indikator)))*100)+(($total_uang/$get_data_rutilahu->rencana_anggaran)*100))/2
            );
            // print_r($data_insert3);
            $this->Main_model->insertData('status_laporan_rutilahu',$data_insert3);
        }else{
            $bb = explode(',',$get_status_laporan_rutilahu->indikator);
            $c = array_unique(array_merge($get_indikator,$bb));
            $d = implode(',',$c);
            $persentase_fisik = (count($c)/count($data_indikator))*100;
            $persentase_anggaran = (($total_uang+$get_status_laporan_rutilahu->anggaran)/$get_data_rutilahu->rencana_anggaran)*100;
            $persentase_realisasi = ($persentase_anggaran+$persentase_fisik)/2;
            $data_update1 = array(
                'indikator' => $d,
                'persentase_fisik' => $persentase_fisik,
                'anggaran' => $total_uang+$get_status_laporan_rutilahu->anggaran,
                'persentase_anggaran' => $persentase_anggaran,
                'persentase_realisasi' => $persentase_realisasi
            );
            // print_r($data_update1);
            $this->Main_model->updateData('status_laporan_rutilahu',$data_update1,array('id_rutilahu'=>$get_status_laporan_rutilahu->id_rutilahu));
        }

		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$hasil['status'] = 'Gagal';
			$this->response($hasil, 200);
		}
		else{
			$hasil['status'] = 'Sukses';
			$this->response($hasil, 200);
		}
	}  

	function index_put() {
		$this->db->trans_start();
        $get_id_laporan_rutilahu = $this->Main_model->getSelectedData('laporan_rutilahu a', 'a.*', array('a.id_laporan_rutilahu'=>$this->put('data_utama')['id_laporan_rutilahu']))->row_array();
        $get_data_rutilahu = $this->Main_model->getSelectedData('rutilahu a', 'a.*', array('a.id_rutilahu'=>$get_id_laporan_rutilahu['id_rutilahu']))->row();
        $indikator = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $data_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*', array('a.program'=>'2'))->result();
        $total_uang = 0;
        $get_indikator = array();
		$progres_keuangan = $this->put('progres_keuangan');
        foreach ($indikator as $key => $value) {
			$penanda = 'kosong';
			foreach ($progres_keuangan as $key => $pk) {
				if($pk['id_tipe_indikator']==$value->id_master_indikator){
					$penanda = 'isi';
					$check_value = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_keuangan a', 'a.*', array('a.id_laporan_rutilahu'=>$this->put('data_utama')['id_laporan_rutilahu'],'a.id_master_indikator'=>$value->id_master_indikator))->row();
					if($check_value==NULL){
						$total_uang += $pk['progres_keuangan'];
						$data_insert2b = array(
							'id_laporan_rutilahu' => $this->put('data_utama')['id_laporan_rutilahu'],
							'id_master_indikator' => $value->id_master_indikator,
							'progres_keuangan' => $pk['progres_keuangan'],
							'penjelasan_progres_keuangan' => $pk['penjelasan_progres_keuangan']
						);
						// print_r($data_insert2b);
						$this->Main_model->insertData('detail_laporan_rutilahu_aspek_keuangan',$data_insert2b);
					}else{
						$total_uang += $pk['progres_keuangan'];
						$data_insert2b = array(
							'progres_keuangan' => $pk['progres_keuangan'],
							'penjelasan_progres_keuangan' => $pk['penjelasan_progres_keuangan']
						);
						// print_r($data_insert2b);
						$this->Main_model->updateData('detail_laporan_rutilahu_aspek_keuangan',$data_insert2b,array('id_detail_laporan_rutilahu'=>$check_value->id_detail_laporan_rutilahu));
					}
					break;
				}else{
					echo'';
				}
			}
			if($penanda=='isi'){
				echo'';
			}else{
				$check_value = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_keuangan a', 'a.*', array('a.id_laporan_rutilahu'=>$this->put('data_utama')['id_laporan_rutilahu'],'a.id_master_indikator'=>$value->id_master_indikator))->row();
                if($check_value==NULL){
                    echo'';
                }else{
                    $total_uang -= $check_value->progres_keuangan;
                    $this->Main_model->deleteData('detail_laporan_rutilahu_aspek_keuangan',array('id_detail_laporan_rutilahu'=>$check_value->id_detail_laporan_rutilahu));
                }
			}
		}

		$progres_fisik = $this->put('progres_fisik');
		foreach ($data_indikator as $key => $value) {
			$penanda = 'kosong';
			foreach ($progres_fisik as $key => $pk) {
				if($pk['indikator_progres_fisik']==$value->id_indikator){
					$penanda = 'isi';
					array_push($get_indikator,$pk['indikator_progres_fisik']);
					$check_value = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_fisik a', 'a.*', array('a.id_laporan_rutilahu'=>$this->put('data_utama')['id_laporan_rutilahu'],'a.indikator_progres_fisik'=>$value->id_indikator))->row();
					if($check_value==NULL){
						$data_insert2a = array(
							'id_laporan_rutilahu' => $this->put('data_utama')['id_laporan_rutilahu'],
							'id_master_indikator' => $value->id_master_indikator,
							'indikator_progres_fisik' => $value->id_indikator,
							'penjelasan_progres_fisik' => $pk['penjelasan_progres_fisik']
						);
						// print_r($data_insert2a);
						$this->Main_model->insertData('detail_laporan_rutilahu_aspek_fisik',$data_insert2a);
					}else{
						$data_insert2a = array(
							'penjelasan_progres_fisik' => $pk['penjelasan_progres_fisik']
						);
						// print_r($data_insert2a);
						$this->Main_model->updateData('detail_laporan_rutilahu_aspek_fisik',$data_insert2a,array('id_detail_laporan_rutilahu'=>$check_value->id_detail_laporan_rutilahu));
					}
					break;
				}else{
					echo'';
				}
			}
			if($penanda=='isi'){
				echo'';
			}else{
				$check_value = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_fisik a', 'a.*', array('a.id_laporan_rutilahu'=>$this->put('data_utama')['id_laporan_rutilahu'],'a.indikator_progres_fisik'=>$value->id_indikator))->row();
                if($check_value==NULL){
                    echo'';
                }else{
                    $this->Main_model->deleteData('detail_laporan_rutilahu_aspek_fisik',array('id_detail_laporan_rutilahu'=>$check_value->id_detail_laporan_rutilahu));
                }
			}
        }

        $tampung_indikator = implode(',',$get_indikator);
        $explode_indikator = explode(',',$tampung_indikator);
        $persentase_fisik = (count($explode_indikator)/count($data_indikator))*100;
        $data_insert1 = array(
            'indikator' => $tampung_indikator,
            'persentase_fisik' => $persentase_fisik,
            'anggaran' => $total_uang,
            'persentase_anggaran' => ($total_uang/$get_data_rutilahu->rencana_anggaran)*100,
            'persentase_realisasi' => ((($total_uang/$get_data_rutilahu->rencana_anggaran)*100)+$persentase_fisik)/2,
            'keterangan' => $this->put('data_utama')['keterangan']
        );
        // print_r($data_insert1);
        $this->Main_model->updateData('laporan_rutilahu',$data_insert1,array('id_laporan_rutilahu'=>$get_id_laporan_rutilahu['id_laporan_rutilahu']));
        
        $get_total_uang = $this->Main_model->getSelectedData('rutilahu a', 'a.*,(SELECT SUM(b.anggaran) FROM laporan_rutilahu b WHERE b.id_rutilahu=a.id_rutilahu AND b.deleted="0") AS total_uang', array('a.id_rutilahu'=>$get_id_laporan_rutilahu['id_rutilahu'],'a.deleted'=>'0'))->row();
        $get_total_indikator = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_fisik a', 'a.*', array('b.id_rutilahu'=>$get_id_laporan_rutilahu['id_rutilahu'],'b.deleted'=>'0'),'','','','a.indikator_progres_fisik',array(
            'table' => 'laporan_rutilahu b',
            'on' => 'a.id_laporan_rutilahu=b.id_laporan_rutilahu',
            'pos' => 'LEFT'
        ))->result();
        $total_indikator = array();
        foreach ($get_total_indikator as $key => $value) {
            array_push($total_indikator,$value->indikator_progres_fisik);
        }
        $persentase_realisasi = ((($get_total_uang->total_uang/$get_data_rutilahu->rencana_anggaran)*100)+((count($total_indikator)/count($data_indikator))*100))/2;
        $data_update1 = array(
            'indikator' => implode(',',$total_indikator),
            'persentase_fisik' => (count($total_indikator)/count($data_indikator))*100,
            'anggaran' => $get_total_uang->total_uang,
            'persentase_anggaran' => ($get_total_uang->total_uang/$get_data_rutilahu->rencana_anggaran)*100,
            'persentase_realisasi' => $persentase_realisasi
        );
        // print_r($data_update1);
        $this->Main_model->updateData('status_laporan_rutilahu',$data_update1,array('id_rutilahu'=>$get_id_laporan_rutilahu['id_rutilahu']));

        $this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Update Rutilahu's report data (".$get_data_rutilahu->nama_kelompok.") from Mobile Apps");
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
			$hasil['status'] = 'Gagal';
			$this->response($hasil, 200);
		}
		else{
			$hasil['status'] = 'Sukses';
			$this->response($hasil, 200);
		}
	}

	function index_delete() {
    }
}