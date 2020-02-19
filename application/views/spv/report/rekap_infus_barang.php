<?php 
date_default_timezone_set('Asia/Jakarta');
?>
<div class='entry'>
    <?php
    if($tanda=='b1'){
    ?>
    <table border='1' align='left'>
        <tr>
            <td bgcolor='yellow' colspan='7' style='text-transform: uppercase;text-align:center;'><b>LAPORAN BELANJA <?php echo $this->Main_model->convert_tanggal($isian)?></b></td>
        </tr>
        <tr>
            <td bgcolor='yellow' style="text-align: center;"><b>HARI</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>TANGGAL</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>NAMA BARANG</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>JUMLAH</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>HARGA SATUAN</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>HARGA</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>KET</b></td>
        </tr>
        <?php
        $q_get_data = "SELECT b.*,c.nama_barang FROM stok_infus a LEFT JOIN stok_infus_detail b ON a.id_stok_infus=b.id_stok_infus LEFT JOIN barang c ON b.id_barang=c.id_barang WHERE a.status='1' AND a.approval LIKE '%".$isian."%'";
        $get_data = $this->db->query($q_get_data)->result();
        $no = 1;
        $total = 0;
        foreach ($get_data as $key => $value) {
            $total += $value->total_harga;
            if($no=='1'){
                $jumlah_row = count($get_data)+1;
                echo'
                <tr>
                    <td rowspan="'.$jumlah_row.'" style="vertical-align : middle;text-transform: uppercase;">'.$this->Main_model->convert_hari($isian).'</td>
                    <td rowspan="'.$jumlah_row.'" style="vertical-align : middle;">'.$this->Main_model->convert_tanggal($isian).'</td>
                    <td>'.$value->nama_barang.'</td>
                    <td style="text-align: center;">'.$value->qty.'</td>
                    <td>Rp '.number_format($value->harga_satuan,2).'</td>
                    <td>Rp '.number_format($value->total_harga,2).'</td>
                    <td>'.$value->keterangan.'</td>
                </tr>
                ';
            }else{
                echo'
                <tr>
                    <td>'.$value->nama_barang.'</td>
                    <td style="text-align: center;">'.$value->qty.'</td>
                    <td>Rp '.number_format($value->harga_satuan,2).'</td>
                    <td>Rp '.number_format($value->total_harga,2).'</td>
                    <td>'.$value->keterangan.'</td>
                </tr>';
            }
            $no++;
        }
        echo'
        <tr>
            <td colspan="3" style="text-align: center;"><b>TOTAL</b></td>
            <td><b>Rp '.number_format($total,2).'</b></td>
            <td></td>
        </tr>';
        // $n=1;
        // foreach ($data_cetak as $key => $value) {
        //     echo'
        //     <tr>
        //         <td style="text-align: center;">'.$n.'</td>
        //         <td style="text-align: center;">'.$value->nama_kelompok.'</td>
        //         <td style="text-align: center;">'.number_format($value->persentase_fisik,2).'%</td>
        //         <td style="text-align: center;">Rp '.number_format($value->rencana_anggaran,2).'</td>
        //         <td style="text-align: center;">Rp '.number_format($value->anggaran,2).'</td>
        //         <td style="text-align: center;">'.number_format($value->persentase_anggaran,2).'%</td>
        //     </tr>
        //     ';
        //     $n++;
        // }
        //     header("Content-type: application/vnd-ms-excel");
        //     header("Content-Disposition: attachment; filename=rekap_data_rutilahu.xls");
        ?>
    </table>
    <?php
    }else{
        $data_tanggal = cal_days_in_month(CAL_GREGORIAN, substr($isian,5,2), substr($isian,0,4));
    ?>
    <table border='1' align='left'>
        <tr>
            <td bgcolor='yellow' colspan='7' style='text-transform: uppercase;text-align:center;'><b>LAPORAN BELANJA <?php echo $this->Main_model->convert_bulan_tahun($isian)?></b></td>
        </tr>
        <tr>
            <td bgcolor='yellow' style="text-align: center;"><b>HARI</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>TANGGAL</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>NAMA BARANG</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>JUMLAH</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>HARGA SATUAN</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>HARGA</b></td>
            <td bgcolor='yellow' style="text-align: center;"><b>KET</b></td>
        </tr>
        <!-- <tr>
            <td rowspan='2'>-</td>
            <td rowspan='2'>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr> -->
        <?php
        for ($i=1; $i <= $data_tanggal ; $i++) { 
            $get_string_tanggal = substr($isian,0,4).'-'.substr($isian,5,2).'-'.$i;
            $where1_tanggal = date('Y-m-d', strtotime($get_string_tanggal));
            $q_get_data_group = "SELECT b.*,c.nama_barang FROM stok_infus a LEFT JOIN stok_infus_detail b ON a.id_stok_infus=b.id_stok_infus LEFT JOIN barang c ON b.id_barang=c.id_barang WHERE a.status='1' AND a.approval LIKE '%".$where1_tanggal."%'";
            $get_data = $this->db->query($q_get_data_group)->result();
            if($get_data==NULL){
                echo'';
            }else{
                $no = 1;
                $total = 0;
                foreach ($get_data as $key => $value) {
                    $total += $value->total_harga;
                    if($no=='1'){
                        $jumlah_row = count($get_data)+1;
                        echo'
                        <tr>
                            <td rowspan="'.$jumlah_row.'" style="vertical-align : middle;text-transform: uppercase;">'.$this->Main_model->convert_hari($where1_tanggal).'</td>
                            <td rowspan="'.$jumlah_row.'" style="vertical-align : middle;">'.$this->Main_model->convert_tanggal($where1_tanggal).'</td>
                            <td>'.$value->nama_barang.'</td>
                            <td style="text-align: center;">'.$value->qty.'</td>
                            <td>Rp '.number_format($value->harga_satuan,2).'</td>
                            <td>Rp '.number_format($value->total_harga,2).'</td>
                            <td>'.$value->keterangan.'</td>
                        </tr>
                        ';
                    }else{
                        echo'
                        <tr>
                            <td>'.$value->nama_barang.'</td>
                            <td style="text-align: center;">'.$value->qty.'</td>
                            <td>Rp '.number_format($value->harga_satuan,2).'</td>
                            <td>Rp '.number_format($value->total_harga,2).'</td>
                            <td>'.$value->keterangan.'</td>
                        </tr>';
                    }
                    $no++;
                }
                echo'
                <tr>
                    <td colspan="3" style="text-align: center;"><b>TOTAL</b></td>
                    <td><b>Rp '.number_format($total,2).'</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td bgcolor="yellow" colspan="7"></td>
                </tr>';
            }
        }
        // $n=1;
        // foreach ($data_cetak as $key => $value) {
        //     echo'
        //     <tr>
        //         <td style="text-align: center;">'.$n.'</td>
        //         <td style="text-align: center;">'.$value->nama_kelompok.'</td>
        //         <td style="text-align: center;">'.number_format($value->persentase_fisik,2).'%</td>
        //         <td style="text-align: center;">Rp '.number_format($value->rencana_anggaran,2).'</td>
        //         <td style="text-align: center;">Rp '.number_format($value->anggaran,2).'</td>
        //         <td style="text-align: center;">'.number_format($value->persentase_anggaran,2).'%</td>
        //     </tr>
        //     ';
        //     $n++;
        // }
        ?>
    </table>
    <?php
    }
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=rekap_data.xls");
    ?>
</div>