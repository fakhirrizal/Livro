<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    /* Stok Infus */
    public function laporan_infus()
    {
        $data['parent'] = 'report';
        $data['child'] = 'infus';
        $data['grand_child'] = '';
        $this->load->view('spv/template/header',$data);
        $this->load->view('spv/report/laporan_infus',$data);
        $this->load->view('spv/template/footer');
    }
    public function json_stok_infus()
    {
        $get_data = $this->Main_model->getSelectedData('stok_infus a', 'a.*,b.fullname', '', '', '', '', '', array(
            'table' => 'user_profile b',
            'on' => 'a.verificator=b.user_id',
            'pos' => 'LEFT'
        ))->result();
        $data_tampil = array();
        $no = 1;
        foreach ($get_data as $key => $value) {
            $isi['checkbox'] =	'
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value->id_stok_infus.'"/>
                                    <span></span>
                                </label>
                                ';
            $isi['number'] = $no++.'.';
            $pisah_tanggal = explode(' ',$value->created_at);
            $isi['tanggal_laporan'] = $this->Main_model->convert_tanggal($pisah_tanggal[0]);
            $get_nm = $this->Main_model->getSelectedData('user_profile a', 'a.*', array('a.user_id'=>$value->created_by))->row();
            $isi['nm'] = $get_nm->fullname;
            // $isi['pelapor'] = $value->fullname;
            $isi['jumlah_barang'] = number_format($value->total_barang,0).' ('.number_format($value->total_item,0).' item)';
            $isi['total_harga'] = 'Rp '.number_format($value->total_harga,2);
            $href_ubah_data = 'href="#"';
            $href_hapus_data = 'href="#"';
            $return_on_click = "return confirm('Anda yakin?')";
            $approval = '';
            if($value->approval==NULL){
                echo'';
            }else{
                $explode_tgl = explode(' ',$value->approval);
                $approval = $this->Main_model->convert_tanggal($explode_tgl[0]).' '.substr($explode_tgl[1],0,5);
            }
            if($value->status=='1'){
                $isi['status'] = '<span class="label label-success"> Approved </span>&nbsp;&nbsp;'.$approval.'&nbsp;&nbsp;oleh '.$value->fullname;
			}elseif($value->status=='9'){
				$isi['status'] = '<span class="label label-danger"> Rejected </span>&nbsp;&nbsp;'.'&nbsp;&nbsp;oleh '.$approval.$value->fullname;
            }else{
                $isi['status'] = '<span class="label label-warning"> Pending </span>';
                $href_ubah_data = 'href="'.site_url('spv_side/ubah_data_stok_infus/'.md5($value->id_stok_infus)).'"';
                $href_hapus_data = 'onclick="'.$return_on_click.'" href="'.site_url('spv_side/hapus_data_stok_infus/'.md5($value->id_stok_infus)).'"';
            }
            
            $isi['action'] =	'
                                <div class="btn-group" style="text-align: center;">
                                    <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="'.site_url('spv_side/detail_data_stok_infus/'.md5($value->id_stok_infus)).'">
                                                <i class="icon-eye"></i> Detil Data </a>
                                        </li>
                                        <li>
                                            <a '.$href_hapus_data.'>
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
    public function tambah_laporan_infus_1()
    {
        $data['parent'] = 'report';
        $data['child'] = 'infus';
        $data['grand_child'] = '';
        $data['barang'] = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.deleted'=>'0'))->result();
        $this->load->view('spv/template/header',$data);
        $this->load->view('spv/report/tambah_laporan_infus_1',$data);
        $this->load->view('spv/template/footer');
    }
    public function tambah_laporan_infus_2()
    {
        if($this->cart->contents()==NULL){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data barang masih kosong.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/tambah_laporan_infus_1/'</script>";
        }else{
            $data['parent'] = 'report';
            $data['child'] = 'infus';
            $data['grand_child'] = '';
            $data['karyawan'] = $this->Main_model->getSelectedData('karyawan a', 'a.*,b.fullname', '', '', '', '', '', array(
                'table' => 'user_profile b',
                'on' => 'a.user_id=b.user_id',
                'pos' => 'LEFT'
            ))->result();
            $this->load->view('spv/template/header',$data);
            $this->load->view('spv/report/tambah_laporan_infus_2',$data);
            $this->load->view('spv/template/footer');
        }
    }
    public function tambah_barang_infus()
    {
        $this->db->trans_start();
        $product = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.id_barang'=>$this->input->post('id_barang')))->row_array();
        $data = array(
			'id' => $this->input->post('id_barang'),
			'qty' => $this->input->post('qty'),
			'price' => $this->input->post('harga_satuan'),
			'name' => $product['nama_barang'],
			'option' => array('note'=>$this->input->post('keterangan'))
		);
        $this->cart->insert($data);
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/tambah_laporan_infus_1/'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/tambah_laporan_infus_1/'</script>";
        }
    }
    public function hapus_barang_infus()
    {
        $this->db->trans_start();
        $this->cart->remove($this->uri->segment(3));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/tambah_laporan_infus_1/'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/tambah_laporan_infus_1/'</script>";
        }
    }
    public function simpan_data_laporan_infus()
    {
        $this->db->trans_start();
        $get_id_stok_infus = $this->Main_model->getLastID('stok_infus','id_stok_infus');
        $isi = $this->cart->contents();
        $total_item = 0;
        $total_harga_ = 0;
        foreach ($isi as $key => $value) {
            $total_harga = $value['qty'] * $value['price'];
            $total_item += $value['qty'];
            $total_harga_ += $total_harga;
            $data_insert1b = array(
                'id_stok_infus' => $get_id_stok_infus['id_stok_infus']+1,
                'id_barang' => $value['id'],
                'qty' => $value['qty'],
                'harga_satuan' => $value['price'],
                'total_harga' => $total_harga,
                'keterangan' => $value['option']['note']
            );
            // print_r($data_insert1b);
            $this->Main_model->insertData('stok_infus_detail',$data_insert1b);
            // $databarang = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.id_barang'=>$value['id']))->row();
            // $tambah_qty = ($databarang->stok)+$value['qty'];
            // $this->Main_model->updateData('barang', array('stok'=>$tambah_qty),array('id_barang'=>$value['id']));
        }
        $data_insert1a = array(
            'id_stok_infus' => $get_id_stok_infus['id_stok_infus']+1,
            'total_barang' => count($isi),
            'total_item' => $total_item,
            'total_harga' => $total_harga_,
            'created_by' => $this->session->userdata('id'),
            'created_at' => date('Y-m-d H:i:s'),
            'status' => '0',
            'keterangan' => $this->input->post('ket')
        );
        // print_r($data_insert1a);
        $this->Main_model->insertData('stok_infus',$data_insert1a);
        $this->cart->destroy();
        $this->Main_model->log_activity($this->session->userdata('id'),'Adding data',"Menambahkan stok infus",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/laporan_infus/'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/laporan_infus/'</script>";
        }
    }
    public function simpan_laporan_stok_infus_barang()
    {
        $this->db->trans_start();
        // $get_id_stok_infus = $this->Main_model->getLastID('stok_infus','id_stok_infus');
        // $isi = $this->cart->contents();
        // $total_item = 0;
        $total_harga_ = 0;
        for ($i=0; $i < count($this->input->post('id_stok_infus_request')); $i++) {
            $total_harga = $this->input->post('qty_'.$this->input->post('id_stok_infus_request')[$i]) * $this->input->post('harga_satuan_'.$this->input->post('id_stok_infus_request')[$i]);
            // $total_item += $value['qty'];
            $total_harga_ += $total_harga;
            $data_insert1b = array(
                'id_stok_infus_request' => $this->input->post('id_stok_infus_request')[$i],
                'id_stok_infus' => $this->input->post('id_stok_infus'),
                'id_barang' => $this->input->post('id_barang_'.$this->input->post('id_stok_infus_request')[$i]),
                'qty' => $this->input->post('qty_'.$this->input->post('id_stok_infus_request')[$i]),
                'harga_satuan' => $this->input->post('harga_satuan_'.$this->input->post('id_stok_infus_request')[$i]),
                'total_harga' => $total_harga,
                'keterangan' => $this->input->post('keterangan_'.$this->input->post('id_stok_infus_request')[$i])
            );
            // print_r($data_insert1b);
            $this->Main_model->insertData('stok_infus_detail',$data_insert1b);
            $databarang = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.id_barang'=>$this->input->post('id_barang_'.$this->input->post('id_stok_infus_request')[$i])))->row();
            $tambah_qty = ($databarang->stok)+$this->input->post('qty_'.$this->input->post('id_stok_infus_request')[$i]);
            $this->Main_model->updateData('barang', array('stok'=>$tambah_qty),array('id_barang'=>$this->input->post('id_barang_'.$this->input->post('id_stok_infus_request')[$i])));
        }
        $data_insert1a = array(
            'total_harga' => $total_harga_,
            'status' => '1',
            'approval' => date('Y-m-d H:i:s'),
            'verificator' => $this->session->userdata('id')
        );
        // print_r($data_insert1a);
        $this->Main_model->updateData('stok_infus', $data_insert1a, array('id_stok_infus'=>$this->input->post('id_stok_infus')));
        // $this->cart->destroy();
        $this->Main_model->log_activity($this->session->userdata('id'),'Approval request',"Menyetujui permintaan stok infus",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/laporan_infus/'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/detail_data_stok_infus/".md5($this->input->post('id_stok_infus'))."'</script>";
        }
    }
    public function detail_data_stok_infus()
    {
        $data['parent'] = 'report';
        $data['child'] = 'infus';
        $data['grand_child'] = '';
        $data['data_detail_laporan'] = $this->Main_model->getSelectedData('stok_infus_request a', 'a.*,b.nama_barang', array('md5(a.id_stok_infus)'=>$this->uri->segment(3)), '', '', '', '', array(
            'table' => 'barang b',
            'on' => 'a.id_barang=b.id_barang',
            'pos' => 'LEFT'
        ))->result();
        $data['data_utama'] = $this->Main_model->getSelectedData('stok_infus a', 'a.*,f.fullname,ff.role_id', array('md5(a.id_stok_infus)'=>$this->uri->segment(3)), '', '', '', '', array(
            array(
                'table' => 'user_profile f',
                'on' => 'a.created_by=f.user_id',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'user_to_role ff',
                'on' => 'a.created_by=ff.user_id',
                'pos' => 'LEFT'
            )
        ))->result();
        $this->load->view('spv/template/header',$data);
        $this->load->view('spv/report/detail_data_stok_infus',$data);
        $this->load->view('spv/template/footer');
    }
    public function daftar_barang_stok_infus()
    {
        $data['parent'] = 'report';
        $data['child'] = 'infus';
        $data['grand_child'] = '';
        $data['data_detail_laporan'] = $this->Main_model->getSelectedData('stok_infus_request a', 'a.*,b.nama_barang', array('md5(a.id_stok_infus)'=>$this->uri->segment(3)), '', '', '', '', array(
            'table' => 'barang b',
            'on' => 'a.id_barang=b.id_barang',
            'pos' => 'LEFT'
        ))->result();
        $data['data_utama'] = $this->Main_model->getSelectedData('stok_infus a', 'a.*,f.fullname', array('md5(a.id_stok_infus)'=>$this->uri->segment(3)), '', '', '', '', array(
            'table' => 'user_profile f',
            'on' => 'a.created_by=f.user_id',
            'pos' => 'LEFT'
        ))->result();
        $this->load->view('spv/template/header',$data);
        $this->load->view('spv/report/daftar_barang_stok_infus',$data);
        $this->load->view('spv/template/footer');
    }
    public function ubah_data_stok_infus()
    {
        $data['parent'] = 'report';
        $data['child'] = 'infus';
        $data['grand_child'] = '';
        $data['karyawan'] = $this->Main_model->getSelectedData('karyawan a', 'a.*,b.fullname', '', '', '', '', '', array(
            'table' => 'user_profile b',
            'on' => 'a.user_id=b.user_id',
            'pos' => 'LEFT'
        ))->result();
        $data['data_detail_laporan'] = $this->Main_model->getSelectedData('stok_infus_detail a', 'a.*,b.nama_barang', array('md5(a.id_stok_infus)'=>$this->uri->segment(3)), '', '', '', '', array(
            'table' => 'barang b',
            'on' => 'a.id_barang=b.id_barang',
            'pos' => 'LEFT'
        ))->result_array();
        $data['data_utama'] = $this->Main_model->getSelectedData('stok_infus a', 'a.*,f.fullname', array('md5(a.id_stok_infus)'=>$this->uri->segment(3)), '', '', '', '', array(
            'table' => 'user_profile f',
            'on' => 'a.created_by=f.user_id',
            'pos' => 'LEFT'
        ))->row();
        $this->load->view('spv/template/header',$data);
        $this->load->view('spv/report/ubah_data_stok_infus',$data);
        $this->load->view('spv/template/footer');
    }
    public function perbarui_data_stok_infus()
    {
        $this->db->trans_start();
        $data_insert1 = array(
            'keterangan' => $this->input->post('ket')
        );
        // print_r($data_insert1);
        $this->Main_model->updateData('stok_infus',$data_insert1,array('md5(id_stok_infus)'=>$this->input->post('id')));
        $this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Memperbarui laporan data stok infus (".$this->input->post('stts').")",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/ubah_data_stok_infus/".$this->input->post('id')."'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/laporan_infus/'</script>";
        }
    }
    public function perbarui_status_data_stok_infus()
    {
        if($this->input->post('stts')=='9'){
            $this->db->trans_start();
            $data_insert1 = array(
                'keterangan' => $this->input->post('ket'),
                'status' => $this->input->post('stts'),
                'approval' => date('Y-m-d H:i:s'),
                'verificator' => $this->session->userdata('id')
            );
            // print_r($data_insert1);
            $this->Main_model->updateData('stok_infus',$data_insert1,array('md5(id_stok_infus)'=>$this->input->post('id')));
            $this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Memperbarui status data stok infus (".$this->input->post('stts').")",$this->session->userdata('location'));
            $this->db->trans_complete();
            if($this->db->trans_status() === false){
                $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diperbarui.<br /></div>' );
                echo "<script>window.location='".base_url()."spv_side/detail_data_stok_infus/".$this->input->post('id')."'</script>";
            }
            else{
                $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diperbarui.<br /></div>' );
                echo "<script>window.location='".base_url()."spv_side/detail_data_stok_infus/".$this->input->post('id')."'</script>";
            }
        }else{
            $data_insert1 = array(
                'keterangan' => $this->input->post('ket')
            );
            // print_r($data_insert1);
            $this->Main_model->updateData('stok_infus',$data_insert1,array('md5(id_stok_infus)'=>$this->input->post('id')));
            echo "<script>window.location='".base_url()."spv_side/daftar_barang_stok_infus/".$this->input->post('id')."'</script>";
        }
    }
    public function hapus_data_stok_infus_barang()
    {
        $this->db->trans_start();
        $id = '';
        $qty = 0;
        $totalharga = 0;
        $datadetail = $this->Main_model->getSelectedData('stok_infus_detail a', 'a.*', array('md5(a.id_stok_infus_detail)'=>$this->uri->segment(3)))->result();
        foreach ($datadetail as $key => $value) {
            $id = $value->id_stok_infus;
            $qty += $value->qty;
            $harga = $value->qty * $value->harga_satuan;
            $totalharga += $harga;
            // $databarang = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.id_barang'=>$value->id_barang))->row();
            // $hasil_qty = ($databarang->stok)-($value->qty);
            // $this->Main_model->updateData('barang', array('stok'=>$hasil_qty),array('id_barang'=>$value->id_barang));
        }
        $this->Main_model->deleteData('stok_infus_detail', array('md5(id_stok_infus_detail)'=>$this->uri->segment(3)));
        $get_data_utama = $this->Main_model->getSelectedData('stok_infus a', 'a.*', array('a.id_stok_infus'=>$id))->row();
        $data_update = array(
            'total_barang' => ($get_data_utama->total_barang)-1,
            'total_item' => ($get_data_utama->total_item)-$qty,
            'total_harga' => ($get_data_utama->total_harga)-$totalharga
        );
        $this->Main_model->updateData('stok_infus',$data_update,array('id_stok_infus'=>$id));
        $this->Main_model->log_activity($this->session->userdata('id'),"Deleting data","Menghapus barang dari laporan stok infus",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/detail_data_stok_infus/".md5($id)."'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/detail_data_stok_infus/".md5($id)."'</script>";
        }
    }
    public function hapus_data_stok_infus()
    {
        $this->db->trans_start();
        $this->Main_model->deleteData('stok_infus', array('md5(id_stok_infus)'=>$this->uri->segment(3)));
        $datadetail = $this->Main_model->getSelectedData('stok_infus_detail a', 'a.*', array('md5(a.id_stok_infus)'=>$this->uri->segment(3)))->result();
        foreach ($datadetail as $key => $value) {
            $databarang = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.id_barang'=>$value->id_barang))->row();
            $hasil_qty = ($databarang->stok)-($value->qty);
            $this->Main_model->updateData('barang', array('stok'=>$hasil_qty),array('id_barang'=>$value->id_barang));
        }
        $this->Main_model->deleteData('stok_infus_detail', array('md5(id_stok_infus)'=>$this->uri->segment(3)));
        $this->Main_model->deleteData('stok_infus_request', array('md5(id_stok_infus)'=>$this->uri->segment(3)));
        $this->Main_model->log_activity($this->session->userdata('id'),"Deleting stok infus's report","Delete stok infus's report",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/laporan_infus/'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/laporan_infus/'</script>";
        }
    }
    /* Stok Opname */
    public function laporan_opname()
    {
        $data['parent'] = 'report';
        $data['child'] = 'opname';
        $data['grand_child'] = '';
        $this->load->view('spv/template/header',$data);
        $this->load->view('spv/report/laporan_opname',$data);
        $this->load->view('spv/template/footer');
    }
    public function json_stok_opname()
    {
        $get_data = $this->Main_model->getSelectedData('stok_opname a', 'a.*,b.fullname', array('a.created_by'=>$this->session->userdata('id')), '', '', '', '', array(
            'table' => 'user_profile b',
            'on' => 'a.created_by=b.user_id',
            'pos' => 'LEFT'
        ))->result();
        $data_tampil = array();
        $no = 1;
        foreach ($get_data as $key => $value) {
            $isi['checkbox'] =	'
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value->id_stok_opname.'"/>
                                    <span></span>
                                </label>
                                ';
            $isi['number'] = $no++.'.';
            $pisah_tanggal = explode(' ',$value->created_at);
            $isi['tanggal_laporan'] = $this->Main_model->convert_tanggal($pisah_tanggal[0]);
            $isi['pelapor'] = $value->fullname;
            $isi['jumlah_barang'] = number_format($value->total_barang,0).' ('.number_format($value->total_item,0).' item)';
            $href_ubah_data = 'href="#"';
            $href_hapus_data = 'href="#"';
            $return_on_click = "return confirm('Anda yakin?')";
            if($value->status=='1'){
				$isi['status'] = '<span class="label label-success"> Approved </span>';
			}elseif($value->status=='9'){
				$isi['status'] = '<span class="label label-danger"> Rejected </span>';
            }else{
                $isi['status'] = '<span class="label label-warning"> Pending </span>';
                $href_ubah_data = 'href="'.site_url('spv_side/ubah_data_stok_opname/'.md5($value->id_stok_opname)).'"';
                $href_hapus_data = 'onclick="'.$return_on_click.'" href="'.site_url('spv_side/hapus_data_stok_opname/'.md5($value->id_stok_opname)).'"';
            }
            $isi['action'] =	'
                                <div class="btn-group" style="text-align: center;">
                                    <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="'.site_url('spv_side/detail_data_stok_opname/'.md5($value->id_stok_opname)).'">
                                                <i class="icon-eye"></i> Detil Data </a>
                                        </li>
                                        <li>
                                            <a '.$href_ubah_data.'>
                                                <i class="icon-wrench"></i> Ubah Data </a>
                                        </li>
                                        <li>
                                            <a '.$href_hapus_data.'>
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
    public function tambah_laporan_opname_1()
    {
        $data['parent'] = 'report';
        $data['child'] = 'opname';
        $data['grand_child'] = '';
        $data['barang'] = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.deleted'=>'0'))->result();
        $this->load->view('spv/template/header',$data);
        $this->load->view('spv/report/tambah_laporan_opname_1',$data);
        $this->load->view('spv/template/footer');
    }
    public function tambah_laporan_opname_2()
    {
        if($this->cart->contents()==NULL){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data barang masih kosong.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/tambah_laporan_opname_1/'</script>";
        }else{
            $data['parent'] = 'report';
            $data['child'] = 'opname';
            $data['grand_child'] = '';
            $data['karyawan'] = $this->Main_model->getSelectedData('karyawan a', 'a.*,b.fullname', '', '', '', '', '', array(
                'table' => 'user_profile b',
                'on' => 'a.user_id=b.user_id',
                'pos' => 'LEFT'
            ))->result();
            $this->load->view('spv/template/header',$data);
            $this->load->view('spv/report/tambah_laporan_opname_2',$data);
            $this->load->view('spv/template/footer');
        }
    }
    public function tambah_barang_opname()
    {
        $this->db->trans_start();
        $product = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.id_barang'=>$this->input->post('id_barang')))->row_array();
        $datacart = $this->cart->contents();
        if($datacart==NULL){
            if($product['stok']<$this->input->post('qty')){
                $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>stok tidak memenuhi.<br /></div>' );
                echo "<script>window.location='".base_url()."spv_side/tambah_laporan_opname_1/'</script>";
            }else{
                $data = array(
                    'id' => $this->input->post('id_barang'),
                    'qty' => $this->input->post('qty'),
                    'price' => '0',
                    'name' => $product['nama_barang'],
                    'option' => array('note'=>$this->input->post('keterangan'))
                );
                $this->cart->insert($data);
                $this->db->trans_complete();
                if($this->db->trans_status() === false){
                    $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
                    echo "<script>window.location='".base_url()."spv_side/tambah_laporan_opname_1/'</script>";
                }
                else{
                    $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
                    echo "<script>window.location='".base_url()."spv_side/tambah_laporan_opname_1/'</script>";
                }
            }
        }else{
            $kata_kunci = $this->input->post('id_barang');
            $hasil_pencarian = 0;
            foreach ($datacart as $key => $value) {
                if($value['id']==$kata_kunci){
                    $hasil_pencarian = ($value['qty'])+($this->input->post('qty'));
                    break;
                }else{
                    echo'';
                }
            }
            if($product['stok']<$hasil_pencarian){
                $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>stok tidak memenuhi.<br /></div>' );
                echo "<script>window.location='".base_url()."spv_side/tambah_laporan_opname_1/'</script>";
            }else{
                $data = array(
                    'id' => $this->input->post('id_barang'),
                    'qty' => $this->input->post('qty'),
                    'price' => '0',
                    'name' => $product['nama_barang'],
                    'option' => array('note'=>$this->input->post('keterangan'))
                );
                $this->cart->insert($data);
                $this->db->trans_complete();
                if($this->db->trans_status() === false){
                    $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
                    echo "<script>window.location='".base_url()."spv_side/tambah_laporan_opname_1/'</script>";
                }
                else{
                    $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
                    echo "<script>window.location='".base_url()."spv_side/tambah_laporan_opname_1/'</script>";
                }
            }
        }
    }
    public function hapus_barang_opname()
    {
        $this->db->trans_start();
        $this->cart->remove($this->uri->segment(3));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/tambah_laporan_opname_1/'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/tambah_laporan_opname_1/'</script>";
        }
    }
    public function simpan_data_laporan_opname()
    {
        $this->db->trans_start();
        $get_id_stok_opname = $this->Main_model->getLastID('stok_opname','id_stok_opname');
        $isi = $this->cart->contents();
        $total_item = 0;
        // $total_harga_ = 0;
        foreach ($isi as $key => $value) {
            // $total_harga = $value['qty'] * $value['price'];
            $total_item += $value['qty'];
            // $total_harga_ += $total_harga;
            $data_insert1b = array(
                'id_stok_opname' => $get_id_stok_opname['id_stok_opname']+1,
                'id_barang' => $value['id'],
                'qty' => $value['qty'],
                // 'harga_satuan' => $value['price'],
                // 'total_harga' => $total_harga,
                'keterangan' => $value['option']['note']
            );
            // print_r($data_insert1b);
            $this->Main_model->insertData('stok_opname_detail',$data_insert1b);
            // $databarang = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.id_barang'=>$value['id']))->row();
            // $tambah_qty = ($databarang->stok)-$value['qty'];
            // $this->Main_model->updateData('barang', array('stok'=>$tambah_qty),array('id_barang'=>$value['id']));
        }
        $data_insert1a = array(
            'id_stok_opname' => $get_id_stok_opname['id_stok_opname']+1,
            'total_barang' => count($isi),
            'total_item' => $total_item,
            // 'total_harga' => $total_harga_,
            'created_by' => $this->session->userdata('id'),
            'created_at' => date('Y-m-d H:i:s'),
            'status' => '0',
            'keterangan' => $this->input->post('ket')
        );
        // print_r($data_insert1a);
        $this->Main_model->insertData('stok_opname',$data_insert1a);
        $this->cart->destroy();
        $this->Main_model->log_activity($this->session->userdata('id'),'Adding data',"Menambahkan stok opname",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/laporan_opname/'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/laporan_opname/'</script>";
        }
    }
    public function detail_data_stok_opname()
    {
        $data['parent'] = 'report';
        $data['child'] = 'opname';
        $data['grand_child'] = '';
        $data['data_detail_laporan'] = $this->Main_model->getSelectedData('stok_opname_detail a', 'a.*,b.nama_barang', array('md5(a.id_stok_opname)'=>$this->uri->segment(3)), '', '', '', '', array(
            'table' => 'barang b',
            'on' => 'a.id_barang=b.id_barang',
            'pos' => 'LEFT'
        ))->result();
        $data['data_utama'] = $this->Main_model->getSelectedData('stok_opname a', 'a.*,f.fullname', array('md5(a.id_stok_opname)'=>$this->uri->segment(3)), '', '', '', '', array(
            'table' => 'user_profile f',
            'on' => 'a.created_by=f.user_id',
            'pos' => 'LEFT'
        ))->result();
        $this->load->view('spv/template/header',$data);
        $this->load->view('spv/report/detail_data_stok_opname',$data);
        $this->load->view('spv/template/footer');
    }
    public function ubah_data_stok_opname()
    {
        $data['parent'] = 'report';
        $data['child'] = 'opname';
        $data['grand_child'] = '';
        $data['karyawan'] = $this->Main_model->getSelectedData('karyawan a', 'a.*,b.fullname', '', '', '', '', '', array(
            'table' => 'user_profile b',
            'on' => 'a.user_id=b.user_id',
            'pos' => 'LEFT'
        ))->result();
        $data['data_detail_laporan'] = $this->Main_model->getSelectedData('stok_opname_detail a', 'a.*,b.nama_barang', array('md5(a.id_stok_opname)'=>$this->uri->segment(3)), '', '', '', '', array(
            'table' => 'barang b',
            'on' => 'a.id_barang=b.id_barang',
            'pos' => 'LEFT'
        ))->result_array();
        $data['data_utama'] = $this->Main_model->getSelectedData('stok_opname a', 'a.*,f.fullname', array('md5(a.id_stok_opname)'=>$this->uri->segment(3)), '', '', '', '', array(
            'table' => 'user_profile f',
            'on' => 'a.created_by=f.user_id',
            'pos' => 'LEFT'
        ))->row();
        $this->load->view('spv/template/header',$data);
        $this->load->view('spv/report/ubah_data_stok_opname',$data);
        $this->load->view('spv/template/footer');
    }
    public function perbarui_data_stok_opname()
    {
        $this->db->trans_start();
        $data_insert1 = array(
            'keterangan' => $this->input->post('ket')
        );
        // print_r($data_insert1);
        $this->Main_model->updateData('stok_opname',$data_insert1,array('md5(id_stok_opname)'=>$this->input->post('id')));
        $this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Memperbarui laporan data stok opname (".$this->input->post('stts').")",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/ubah_data_stok_opname/".$this->input->post('id')."'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/laporan_opname/'</script>";
        }
    }
    public function perbarui_status_data_stok_opname()
    {
        $this->db->trans_start();
        $data_insert1 = array(
            'status' => $this->input->post('stts')
        );
        // print_r($data_insert1);
        $this->Main_model->updateData('stok_opname',$data_insert1,array('md5(id_stok_opname)'=>$this->input->post('id')));
        $this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Memperbarui status data stok opname (".$this->input->post('stts').")",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/detail_data_stok_opname/".$this->input->post('id')."'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/detail_data_stok_opname/".$this->input->post('id')."'</script>";
        }
    }
    public function hapus_data_stok_opname_barang()
    {
        $this->db->trans_start();
        $id = '';
        $qty = 0;
        // $totalharga = 0;
        $datadetail = $this->Main_model->getSelectedData('stok_opname_detail a', 'a.*', array('md5(a.id_stok_opname_detail)'=>$this->uri->segment(3)))->result();
        foreach ($datadetail as $key => $value) {
            $id = $value->id_stok_opname;
            $qty += $value->qty;
            // $harga = $value->qty * $value->harga_satuan;
            // $totalharga += $harga;
            $databarang = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.id_barang'=>$value->id_barang))->row();
            $hasil_qty = ($databarang->stok)+($value->qty);
            $this->Main_model->updateData('barang', array('stok'=>$hasil_qty),array('id_barang'=>$value->id_barang));
        }
        $this->Main_model->deleteData('stok_opname_detail', array('md5(id_stok_opname_detail)'=>$this->uri->segment(3)));
        $get_data_utama = $this->Main_model->getSelectedData('stok_opname a', 'a.*', array('a.id_stok_opname'=>$id))->row();
        $data_update = array(
            'total_barang' => ($get_data_utama->total_barang)-1,
            'total_item' => ($get_data_utama->total_item)-$qty
            // 'total_harga' => ($get_data_utama->total_harga)-$totalharga
        );
        $this->Main_model->updateData('stok_opname',$data_update,array('id_stok_opname'=>$id));
        $this->Main_model->log_activity($this->session->userdata('id'),"Deleting data","Menghapus barang dari laporan stok opname",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/detail_data_stok_opname/".md5($id)."'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/detail_data_stok_opname/".md5($id)."'</script>";
        }
    }
    public function hapus_data_stok_opname()
    {
        $this->db->trans_start();
        $this->Main_model->deleteData('stok_opname', array('md5(id_stok_opname)'=>$this->uri->segment(3)));
        $datadetail = $this->Main_model->getSelectedData('stok_opname_detail a', 'a.*', array('md5(a.id_stok_opname)'=>$this->uri->segment(3)))->result();
        foreach ($datadetail as $key => $value) {
            $databarang = $this->Main_model->getSelectedData('barang a', 'a.*', array('a.id_barang'=>$value->id_barang))->row();
            $hasil_qty = ($databarang->stok)-($value->qty);
            $this->Main_model->updateData('barang', array('stok'=>$hasil_qty),array('id_barang'=>$value->id_barang));
        }
		$this->Main_model->deleteData('stok_opname_detail', array('md5(id_stok_opname)'=>$this->uri->segment(3)));
        $this->Main_model->log_activity($this->session->userdata('id'),"Deleting stok opname's report","Delete stok opname's report",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/laporan_opname/'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."spv_side/laporan_opname/'</script>";
        }
    }
    /* Other Function */
    public function ajax_function()
    {
        if($this->input->post('modul')=='modul_ubah_data_status_laporan_stok_infus'){
            $data = $this->Main_model->getSelectedData('stok_infus a', 'a.*,b.fullname', array('md5(a.id_stok_infus)'=>$this->input->post('id')), '', '', '', '', array(
                'table' => 'user_profile b',
                'on' => 'a.created_by=b.user_id',
                'pos' => 'LEFT'
            ))->row();
            $pecah_tanggal = explode(' ',$data->created_at);
            echo'
            <form role="form" class="form-horizontal" action="'.base_url('spv_side/perbarui_status_data_stok_infus').'" method="post">
                <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">
                <input type="hidden" name="id" value="'.$this->input->post('id').'">
                <div class="form-body">
                    <div class="form-group form-md-line-input has-danger">
                        <label class="col-md-2 control-label" for="form_control_1">Requester </label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <input type="text" class="form-control" value="'.$data->fullname.'" readonly>
                                <div class="form-control-focus"> </div>
                                <i class="icon-user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-md-line-input has-danger">
                        <label class="col-md-2 control-label" for="form_control_1">Tanggal Permintaan </label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <input type="text" class="form-control" value="'.$this->Main_model->convert_tanggal($pecah_tanggal[0]).' '.substr($pecah_tanggal[1],0,5).'" readonly>
                                <div class="form-control-focus"> </div>
                                <i class="icon-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-md-line-input has-danger">
                        <label class="col-md-2 control-label" for="form_control_1">Keterangan </label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <input type="text" name="ket" class="form-control" value="'.$data->keterangan.'">
                                <div class="form-control-focus"> </div>
                                <i class="icon-list"></i>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group form-md-line-input has-danger">
                        <label class="col-md-2 control-label" for="form_control_1">Status <span class="required"> * </span></label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <select name="stts" class="form-control select2-allow-clear" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="1">Approved</option>
                                    <option value="9">Rejected</option>
                                </select>
                                <i class="icon-pin"></i>
                            </div>
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
            ';
        }elseif($this->input->post('modul')=='modul_ubah_data_status_laporan_stok_opname'){
            $data = $this->Main_model->getSelectedData('stok_opname a', 'a.*,b.fullname', array('md5(a.id_stok_opname)'=>$this->input->post('id')), '', '', '', '', array(
                'table' => 'user_profile b',
                'on' => 'a.created_by=b.user_id',
                'pos' => 'LEFT'
            ))->row();
            $pecah_tanggal = explode(' ',$data->created_at);
            echo'
            <form role="form" class="form-horizontal" action="'.base_url('spv_side/perbarui_status_data_stok_opname').'" method="post">
                <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">
                <input type="hidden" name="id" value="'.$this->input->post('id').'" readonly>
                <div class="form-body">
                    <div class="form-group form-md-line-input has-danger">
                        <label class="col-md-2 control-label" for="form_control_1">Pelapor </label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <input type="text" class="form-control" value="'.$data->fullname.'" readonly>
                                <div class="form-control-focus"> </div>
                                <i class="icon-user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-md-line-input has-danger">
                        <label class="col-md-2 control-label" for="form_control_1">Tanggal Lapor </label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <input type="text" class="form-control" value="'.$this->Main_model->convert_tanggal($pecah_tanggal[0]).' '.substr($pecah_tanggal[1],0,5).'" readonly>
                                <div class="form-control-focus"> </div>
                                <i class="icon-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-md-line-input has-danger">
                        <label class="col-md-2 control-label" for="form_control_1">Keterangan </label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <input type="text" class="form-control" value="'.$data->keterangan.'" readonly>
                                <div class="form-control-focus"> </div>
                                <i class="icon-list"></i>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group form-md-line-input has-danger">
                        <label class="col-md-2 control-label" for="form_control_1">Status <span class="required"> * </span></label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <select name="stts" class="form-control select2-allow-clear" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="1">Approved</option>
                                    <option value="9">Rejected</option>
                                </select>
                                <i class="icon-pin"></i>
                            </div>
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
            ';
        }
    }
}