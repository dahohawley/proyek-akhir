<?php
	class Laporan extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('model_laporan','model');
			$this->load->library('pagination');
			date_default_timezone_set("Asia/Bangkok");
			$check_session = $this->Account_model->check_session();
			if(!$check_session){
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
				redirect('account');
			}
		}
		public function index(){
			$this->jurnal();
		}
		public function jurnal(){
			if(isset($_POST['btnsubmit'])){
				$this->model->tanggal_awal = $this->input->post('tgl_awal');
				$this->model->tanggal_akhir = $this->input->post('tgl_akhir');
			}else{
				$this->model->tanggal_awal = '0000-00-00';
				$this->model->tanggal_akhir = '9999-12-12';
			}
			$this->my_page->set_page('Jurnal Umum');
			
			$data['jurnal'] = $this->model->data();
			$this->template->load('template','laporan/jurnal',$data);
		}
		public function jurnal_peny(){
			if(isset($_POST['btnsubmit'])){
				$this->model->tanggal_awal = $this->input->post('tgl_awal');
				$this->model->tanggal_akhir = $this->input->post('tgl_akhir');
			}else{
				$this->model->tanggal_awal = '0000-00-00';
				$this->model->tanggal_akhir = '9999-12-12';
			}
			$this->my_page->set_page('Jurnal Penyesuaian');
			
			$data['jurnal'] = $this->model->data_peny();
			$this->template->load('template','laporan/jurnal_peny',$data);
		}
		public function buku_besar(){
			$this->my_page->set_page('Buku Besar');
			$data['tahun'] = $this->db->query("SELECT tgl_trans, year(tgl_trans) as tahun FROM `transaksi`  WHERE tgl_trans is not null and tgl_trans != 0 group by year(tgl_trans)")->result();
			$this->db->where('no_akun like','___');
			$data['akun'] = $this->db->get('coa')->result();
			$this->template->load('template','laporan/buku_besar',$data);
		}
		public function get_bukbesar($no_akun = '',$bulan='',$tahun=''){
			$saldo_awal = $this->model->get_saldo_awal_buku_besar($tahun,$bulan,$no_akun);
			$buku_besar = $this->model->get_bukbesar($no_akun,$bulan,$tahun);
			echo '<tr>
				<td></td>
				<td>Saldo Awal</td>
				<td></td>
				<td></td>
				<td></td>';
				if($saldo_awal <= 0){
					echo '<td></td>
					<td style="text-align:right;">'.format_rp(abs($saldo_awal)).'</td></tr>';
				}else{
					echo '<td style="text-align:right;">'.format_rp($saldo_awal).'</td>
					<td></td></tr>';	
				}
			
			foreach($buku_besar as $data){
				$nama_akun = $data->nama_akun;
				$no_akun = $no_akun;
				echo'<tr>
					<td>'.$data->tgl_trans.'</td>
					<td>'.$data->nama_akun.'</td>';
				if ($data->tipe == '0') {
					echo '
					<td>JU</td>';
				}else{
					echo '
					<td>JP</td>';
					//<td>JU</td>';
				}
				if($data->posisi_dr_cr =='d'){
					$saldo_awal = $saldo_awal + $data->nominal;
					echo '
						<td style="text-align:right;">'.format_rp($data->nominal).'</td>
						<td></td>
					';
				}else{
					$saldo_awal = $saldo_awal - $data->nominal;
					echo '
						<td></td>
						<td style="text-align:right;">'.format_rp($data->nominal).'</td>
					';
				}
				if($saldo_awal > 0){
				echo '<td style="text-align:right;">'.format_rp($saldo_awal).'</td>
						<td></td>';
				}else{
				echo '<td></td>
						<td style="text-align:right;">'.format_rp(str_replace("-",'',$saldo_awal)).'</td>';
				}
			}
				echo '|'.$no_akun.'|'.$nama_akun;

		}
		public function neraca_saldo(){
			$this->my_page->set_page('Neraca Saldo');
			$data['tahun'] = $this->db->query("SELECT year(tgl_trans) as tahun FROM `transaksi` WHERE tgl_trans is not null and tgl_trans != 0 group by year(tgl_trans)")->result();
			$this->template->load('template','laporan/neraca_saldo',$data);
		}
		public function get_neraca_saldo($bulan = '',$tahun = ''){
			$coa = $this->db->get('coa')->result();
			$total_debit = 0;
			$total_kredit = 0;
			foreach($coa as $coa){
				$this->db->where('no_akun',$coa->no_akun);
				$this->db->join('transaksi','transaksi.id_trans = jurnal.id_trans');
				$this->db->where('tgl_trans between "'.$tahun.'-'.$bulan.'-1"AND "'.$tahun.'-'.$bulan.'-31"');
				$jurnal = $this->db->get('jurnal')->result();
				$saldo = $saldo_awal = $this->model->get_saldo_awal_buku_besar($tahun,$bulan,$coa->no_akun);
				foreach($jurnal as $jurnal){
					if($jurnal->posisi_dr_cr == 'd'){
						$saldo = $saldo+$jurnal->nominal;
						
					}elseif ($jurnal->posisi_dr_cr == 'k') {
						$saldo = $saldo-$jurnal->nominal;	
						
					}
				}
				echo '<tr>
					<td>'.$coa->no_akun.'</td>
					<td>'.$coa->nama_akun.'</td>';
				if($saldo < 0){
					$total_kredit = $total_kredit + $saldo;
					echo '
					<td>-</td>
					<td style="text-align:right;">'.format_rp(abs($saldo)).'</td>';
				}elseif($saldo == 0){
					echo'<td>-</td>
					<td>-</td>';
				}
				else{
					$total_debit = $total_debit + $saldo;
					echo '
					<td style="text-align:right;">'.format_rp($saldo).'</td>
					<td>-</td>';
				}
			}
			echo '<tr style="background-color:#6C7A89; color: white;">
				<td colspan="2">TOTAL</td>
				<td>'.format_rp($total_debit).'</td>
				<td>'.format_rp(abs($total_kredit)).'</td>
			</tr>';
		}
		public function arus_kas(){
			$this->my_page->set_page('Arus Kas');
			$data['tahun'] = $this->db->query("SELECT year(tgl_trans) as tahun FROM `transaksi` WHERE tgl_trans is not null and tgl_trans != 0 group by year(tgl_trans)")->result();
			$this->template->load('template','laporan/arus_kas',$data);
		}
		public function get_arus_kas($tahun,$bulan){
			header('Content-type: application/json');
			//get penjualan
				$saldo_penjualan = $this->model->get_saldo_awal_buku_besar($tahun,$bulan,'501');
				$this->db->where('no_akun','411');
				$this->db->join('transaksi','transaksi.id_trans = jurnal.id_trans');
				$this->db->where('tgl_trans between "'.$tahun.'-'.$bulan.'-1"AND "'.$tahun.'-'.$bulan.'-31"');
				$jurnal = $this->db->get('jurnal')->result();
				foreach($jurnal as $jurnal){
					if($jurnal->posisi_dr_cr == 'd'){
						$saldo_penjualan = $saldo_penjualan+$jurnal->nominal;
					}elseif ($jurnal->posisi_dr_cr == 'k') {
						$saldo_penjualan = $saldo_penjualan-$jurnal->nominal;	
					}
				}
				$penjualan = str_replace("-","",$saldo_penjualan)*1;
			//get persediaan barang dagang
				$saldo_pbd = $this->model->get_saldo_awal_buku_besar($tahun,$bulan,'102');
				$this->db->where('no_akun','511');
				$this->db->join('transaksi','transaksi.id_trans = jurnal.id_trans');
				$this->db->where('tgl_trans between "'.$tahun.'-'.$bulan.'-1"AND "'.$tahun.'-'.$bulan.'-31"');
				$jurnal = $this->db->get('jurnal')->result();
				foreach($jurnal as $jurnal){
					if($jurnal->posisi_dr_cr == 'd'){
						$saldo_pbd = $saldo_pbd+$jurnal->nominal;
					}elseif ($jurnal->posisi_dr_cr == 'k') {
						$saldo_pbd = $saldo_pbd-$jurnal->nominal;	
					}
				}
				$pbd = str_replace("-","",$saldo_pbd);
			// get beban
				$this->db->where('year(tgl_bayar)',$tahun);
				$this->db->where('month(tgl_bayar)',$bulan);
				$this->db->select('sum(jml_bayar) as jumlah_bayar');
				$jumlah_beban = $this->db->get('pembayaran')->row()->jumlah_bayar;
				if($jumlah_beban == null){
					$jumlah_beban = 0;
				}
			// get simpanan (212,213,214)
				$this->db->select('sum(jml_simpanan) as total_simpanan');
				$this->db->where('month(tgl_simpan)',$bulan);
				$this->db->where('year(tgl_simpan)',$tahun);
				$total_simpanan = $this->db->get('simpanan')->row()->total_simpanan;
			// Pinjaman
				$pinjaman = $this->db->query("SELECT sum(jml_pinjam) as pinjaman FROM `pinjaman` WHERE month(tgl_pencairan) = '".$bulan."' and year(tgl_pencairan) = '".$tahun."' and (status = '2' or status = '3')")->row()->pinjaman;
			// Angsuran
				$this->db->where('year(tgl_angsur)',$tahun);
				$this->db->where('month(tgl_angsur)',$bulan);
				$this->db->select('sum(jml_angsur) as angsuran');
				$angsuran = $this->db->get('angsuran_pinj')->row()->angsuran;
			// saldo awal_kas 
				$saldo_awal_kas = $this->model->get_saldo_awal_buku_besar($tahun,$bulan,'111');
			// penarikan
				$this->db->where('month(tgl_penarikan)',$bulan);
				$this->db->where('year(tgl_penarikan)',$tahun);
				$this->db->select('sum(jml_penarikan) as penarikan');
				$penarikan = $this->db->get('penarikan')->row()->penarikan;
			$ak_op = $saldo_awal_kas+$penjualan-$pbd-$jumlah_beban;
			$ak_it = $total_simpanan+$angsuran-$pinjaman-$penarikan;
			$kat = $ak_op+$ak_it;
			$json = array(
				'penjualan' => format_rp($penjualan),
				'pbd' => format_rp($pbd),
				'penarikan' => format_rp($penarikan),
				'saldo_awal_kas' => format_rp($saldo_awal_kas),
				'beban' => format_rp($jumlah_beban),
				'ak_op' => format_rp($ak_op),
				'kat' => format_rp($kat),
				'ak_it' => format_rp($ak_it),
				'bulan' => get_monthname($bulan),
				'simpanan' => format_rp($total_simpanan),
				'angsuran' => format_rp($angsuran),
				'pinjaman' => format_rp($pinjaman),
				'tahun' => $tahun);
			echo json_encode($json);
		}
		public function filter_phu(){
			$data['tahun'] = $this->db->query("SELECT year(tgl_trans) as tahun FROM `transaksi` WHERE tgl_trans is not null and tgl_trans != 0 group by year(tgl_trans)")->result();
			$this->my_page->set_page('Perhitungan Hasil Usaha');
			$this->template->load('template','laporan/filter_phu',$data);
		}
		public function generate_ajp_pajak($pajak){
			//cek udh ada jurnal belom
			$query = $this->db->query("SELECT * FROM transaksi
										WHERE id_trans like 'PJK%'
										AND month(tgl_trans) = '".date('m')."'
										AND year(tgl_trans) = '".date('Y')."'")->row();
			$jml_data = count($query);
			if ($jml_data < 1) {
				 //get nomor transaksi terakhir
                $query = $this->db->query("SELECT max(substring(id_trans,5)*1) as notrans from transaksi")->row();
                $transaksi = $query->notrans+1;
                $nomor_trans = "PJK-".$transaksi;
                //insert ke tabel transaksi
                $data = array(
					'id_trans' => $nomor_trans,
					'tgl_trans' => date('Y-m-d'),
					'jml_trans' => $pajak
				);
				$this->db->insert('transaksi',$data);
				$data = array(
					'no_akun' => '641',
					'posisi_dr_cr' => 'd',
					'nominal' => $pajak,
					'id_trans' => $nomor_trans,
					'tipe' => 1
				);
				$this->db->insert('jurnal',$data);
				$data = array(
					'no_akun' => '111',
					'posisi_dr_cr' => 'k',
					'nominal' => $pajak,
					'id_trans' => $nomor_trans,
					'tipe' => 1
				);
				$this->db->insert('jurnal',$data);
				redirect('Laporan/jurnal_peny');
			}else{
				redirect('Laporan/jurnal_peny');
			}
		}
		public function generate_ajp_shu(){
			$query = $this->db->query("SELECT * from transaksi where id_trans like 'SHU%' and year('tgl_trans')= ".date('Y')."")->result();
			$jml_data = count($query);
			if ($jml_data < 1) {
				$query = $this->db->query("SELECT max(substring(id_trans,5)*1) as notrans from transaksi")->row();
                $transaksi = $query->notrans+1;
                $nomor_trans = "SHU-".$transaksi;
                $query = $this->db->query("SELECT sum(hasil_pembagian) as total from rencana_pembagian where periode= ".date('Y')."")->row();
                $jml = $query->total;
                //insert ke tabel transaksi
                $data = array(
					'id_trans' => $nomor_trans,
					'tgl_trans' => date('Y-m-d'),
					'jml_trans' => $jml
				);
				$this->db->insert('transaksi',$data);
				//insert ke jurnal yg debet
				$data = array(
					'no_akun' => '316',
					'posisi_dr_cr' => 'd',
					'nominal' => $jml,
					'id_trans' => $nomor_trans,
					'tipe' => 1
				);
				$this->db->insert('jurnal',$data);
				//insert ke jurnal yg kredit
				$this->db->where('periode',date('Y'));
				$rencana_pembagian = $this->db->get('rencana_pembagian')->result();
				$this->model->insert_jurnal('315','k',$nomor_trans,'4');
				$this->model->insert_jurnal('317','k',$nomor_trans,'5');
				$this->model->insert_jurnal('318','k',$nomor_trans,'6');
				$this->model->insert_jurnal('319','k',$nomor_trans,'7');
				$this->model->insert_jurnal('320','k',$nomor_trans,'8');
				$this->model->insert_jurnal('321','k',$nomor_trans,'9');
				$this->model->insert_jurnal('322','k',$nomor_trans,'10');
				$this->model->insert_jurnal('323','k',$nomor_trans,'11');
				$this->model->insert_jurnal('324','k',$nomor_trans,'12');
				$this->model->insert_jurnal('325','k',$nomor_trans,'13');
				$this->model->insert_jurnal('320','k',$nomor_trans,'14');
				$this->model->insert_jurnal('326','k',$nomor_trans,'15');
				$this->model->insert_jurnal('321','k',$nomor_trans,'16');
				$this->model->insert_jurnal('322','k',$nomor_trans,'17');
				$this->model->insert_jurnal('323','k',$nomor_trans,'18');
				redirect('laporan/jurnal_peny');
			}else{
				redirect('laporan/jurnal_peny');
			}
		}
		public function generate_ajp_penerimaan_sp($tahun){
            $this->db->where('status !=','4');
            $anggota = $this->db->Get('anggota')->result();
            $no=0;
            $total_sisa_pinjaman = 0;
            $total_jasa_peminjam = 0;
            $total_sp_sw = 0;
            $total_smh_shr = 0;
            $grand_total = 0;
			$query = $this->db->query("SELECT max(substring(id_trans,5)*1) as notrans from transaksi")->row();
            $transaksi = $query->notrans+1;
            $nomor_trans = "PSP-".$transaksi;
            //insert ke tabel transaksi
            $data = array(
				'id_trans' => $nomor_trans,
				'tgl_trans' => date('Y-m-d'),
				'jml_trans' => 0
			);
			$this->db->insert('transaksi',$data);
            foreach($anggota as $data){
                $detail_usp = $this->model->get_detail_usp($data->no_anggota,$tahun);
                $no++;
                $jumlah = $detail_usp['jasa_smn_shr']+$detail_usp['jasa_sp_sw']+$detail_usp['jasa_peminjam'];
                $total_sisa_pinjaman = $total_sisa_pinjaman +$detail_usp['sisa_pinjaman'] ;
	            $total_jasa_peminjam = $total_jasa_peminjam + $detail_usp['jasa_peminjam'] ;
	            $total_sp_sw = $total_sp_sw + $detail_usp['jasa_sp_sw'] ;
	            $total_smh_shr = $total_smh_shr + $detail_usp['jasa_smn_shr'];
	            $grand_total = $grand_total + $jumlah;
	            // insert jurnal
		            $data = array(
		            	'no_akun' => '317',
		            	'posisi_dr_cr'=> 'd',
		            	'nominal' => $detail_usp['jasa_sp_sw'],
		            	'id_trans'=> $nomor_trans,
		            	'tipe' => 1);
		            $this->db->insert('jurnal',$data);
		            $data = array(
		            	'no_akun' => '318',
		            	'posisi_dr_cr'=> 'd',
		            	'nominal' => $detail_usp['jasa_smn_shr'],
		            	'id_trans'=> $nomor_trans,
		            	'tipe' => 1);
		            $this->db->insert('jurnal',$data);
		            $data = array(
		            	'no_akun' => '319',
		            	'posisi_dr_cr'=> 'd',
		            	'nominal' => $detail_usp['jasa_peminjam'],
		            	'id_trans'=> $nomor_trans,
		            	'tipe' => 1);
		            $this->db->insert('jurnal',$data);
		            $data = array(
		            	'no_akun' => '111',
		            	'posisi_dr_cr'=> 'k',
		            	'nominal' => $jumlah,
		            	'id_trans'=> $nomor_trans,
		            	'tipe' => 1);
		            $this->db->insert('jurnal',$data);   
            }
            echo 'true';
		}
		public function generate_ajp_penerimaan_jt($tahun){
			$query = $this->db->query("SELECT max(substring(id_trans,5)*1) as notrans from transaksi")->row();
            $transaksi = $query->notrans+1;
            $nomor_trans = "PJT-".$transaksi;
            //insert ke tabel transaksi
            $data = array(
				'id_trans' => $nomor_trans,
				'tgl_trans' => date('Y-m-d'),
				'jml_trans' => 0
			);
			$this->db->insert('transaksi',$data);
			$this->db->Where('no_anggota !=','0');
			$anggota = $this->db->get('anggota')->result();
			$grand_total_shu_diterima = 0;
			$i = 1;
			$total_jasa_anggota = 0;
			foreach($anggota as $data){
				// get sisa pinjaman
					$sisa_pinjaman = 0;
					$this->db->where('no_anggota',$data->no_anggota);
					$nota_penjualan = $this->db->Get('nota_penjualan')->result();
					foreach($nota_penjualan as $nota_penjualan){
						$total_transaksi = $nota_penjualan->jml_trans;
						
						$this->db->where('id_penjualan',$nota_penjualan->id_penjualan);
						$this->db->select('sum(jml_trans) as jml_trans');
						$this->db->group_by('id_penjualan');
						$angsuran_penj = $this->db->get('angsuran_penj')->row();
						$telah_dibayar = $angsuran_penj->jml_trans;
						$kurang_pembayaran = $total_transaksi - $telah_dibayar;
						$sisa_pinjaman = $sisa_pinjaman+$kurang_pembayaran;
					}
				// tunai
					$this->db->where('no_anggota',$data->no_anggota);
					$this->db->where('year(tgl_trans)',$tahun);
					$this->db->select('sum(jml_trans) as jumlah_trans');
					$total_tunai_per_anggota = $this->db->get('nota_penjualan')->row()->jumlah_trans;

				// Penjualan Seluruh Anggota 
					$this->db->where('year(tgl_trans)',$tahun);
					$this->db->where('no_anggota !=','0');
					$this->db->select('sum(jml_trans) as total_penjualan');
					$penjualan_seluruh_anggota = $this->db->get('nota_penjualan')->row()->total_penjualan;
				//  rencana pembagian 
					$this->db->where('id','13');
					$this->db->where('periode',$tahun);
					$this->db->select('*,sum(hasil_pembagian) as test');
					$rencana_pembagian = $this->db->get('rencana_pembagian')->row()->hasil_pembagian;
					// $total_tunai = $total_tunai_per_anggota/$penjualan_seluruh_anggota*$rencana_pembagian;
					$total_tunai = $total_tunai_per_anggota/$penjualan_seluruh_anggota*$rencana_pembagian;
					$total_jasa_anggota = $total_jasa_anggota + $total_tunai;
				// penjualan non anggota
					$this->db->where('year(tgl_trans)',$tahun);
					$this->db->where('no_anggota =','0');
					$this->db->select('sum(jml_trans) as total_penjualan');
					$penjualan_non_anggota = $this->db->get('nota_penjualan')->row()->total_penjualan;
				// jumlah anggota
					$jumlah_anggota = $this->db->query("select count(no_anggota) as jumlah_anggota from anggota where no_anggota != '0'")->Row()->jumlah_anggota;
					$pemerataan = $penjualan_non_anggota/$jumlah_anggota;	
					$shu_diterima = ($total_tunai+$pemerataan)/($penjualan_seluruh_anggota+$penjualan_non_anggota)*$rencana_pembagian;
					$grand_total_shu_diterima = $grand_total_shu_diterima + $shu_diterima;
				// insert jurnal
					$data = array(
						'no_akun' => '325',
						'posisi_dr_cr'=> 'd',
						'nominal' => $shu_diterima,
						'id_trans'=> $nomor_trans,
						'tipe' => 1);
					$this->db->insert('jurnal',$data);
					$data = array(
						'no_akun' => '111',
						'posisi_dr_cr'=> 'k',
						'nominal' => $shu_diterima,
						'id_trans'=> $nomor_trans,
						'tipe' => 1);
					$this->db->insert('jurnal',$data);
			}
            echo 'true';
		}
		public function phu(){
			$awal = $this->input->post('bulan_awal');
			$akhir = $this->input->post('bulan_akhir');
			$tahun = $this->input->post('tahun');
			$unit = $this->input->post('unit');
			if (date('d') < '28'){
				$this->my_page->set_page('Perhitungan Hasil Usaha');
				$this->template->load('template','laporan/phu_nongenerate');
			}else{
				$this->my_page->set_page('Perhitungan Hasil Usaha');
				//ambil pendapatan bunga
				$query = $this->db->query("SELECT no_akun,sum(nominal) as total FROM jurnal JOIN transaksi on transaksi.id_trans=jurnal.id_trans WHERE month(tgl_trans) between '".$awal."' and '".$akhir."' and year(tgl_trans) = '".$tahun."' and no_akun = '421'")->row();
				$total = $query->total;
				if ($total == null ) {
					$data['jasa'] = '0';
				}else{
					$data['jasa'] = $total;
				}

				//ambil penjualan barang dagang
				$query = $this->db->query("SELECT no_akun,sum(nominal) as total FROM jurnal JOIN transaksi on transaksi.id_trans=jurnal.id_trans WHERE month(tgl_trans) between '".$awal."' and '".$akhir."' and year(tgl_trans) = '".$tahun."' and no_akun = '411'")->row();
				$total = $query->total;
				if ($total == null ) {
					$data['penjualan'] = '0';
				}else{
					$data['penjualan'] = $total;
				}
				//ambil pembelian
				$q = $this->db->query("SELECT sum(jml_trans) as jml_trans FROM pembelian WHERE month(tgl_trans) between '".$awal."' and '".$akhir."' and year(tgl_trans) = '".$tahun."'")->row();
				$data['pemb'] = $q->jml_trans;
				//ambil beban operasional
				$data['b_op'] = $this->db->query("SELECT nama_akun,nominal FROM jurnal JOIN coa on jurnal.no_akun=coa.no_akun JOIN transaksi ON transaksi.id_trans=jurnal.id_trans WHERE jurnal.no_akun like '61_' AND month(tgl_trans) between '".$awal."' and '".$akhir."' and year(tgl_trans) = '".$tahun."'")->result();

				//ambil beban non operasional
				$data['b_non'] = $this->db->query("SELECT nama_akun,nominal FROM jurnal JOIN coa on jurnal.no_akun=coa.no_akun JOIN transaksi ON transaksi.id_trans=jurnal.id_trans WHERE jurnal.no_akun like '62_' AND month(tgl_trans) between '".$awal."' and '".$akhir."' and year(tgl_trans) = '".$tahun."'")->result();

				//ambil beban operasional toko
				$data['b_toko'] = $this->db->query("SELECT nama_akun,nominal FROM jurnal JOIN coa on jurnal.no_akun=coa.no_akun JOIN transaksi ON transaksi.id_trans=jurnal.id_trans WHERE jurnal.no_akun like '63_' AND month(tgl_trans) between '".$awal."' and '".$akhir."' and year(tgl_trans) = '".$tahun."'")->result();

				$data['tahun'] = date('Y');
				$query = $this->db->query("SELECT no_akun,sum(nominal) as total FROM jurnal JOIN transaksi on transaksi.id_trans=jurnal.id_trans WHERE month(tgl_trans) between '".$awal."' and '".$akhir."' and year(tgl_trans) = '".$tahun."' and no_akun LIKE '61_'")->row();
				$data['jml_operasional'] = $query->total;
				$query = $this->db->query("SELECT no_akun,sum(nominal) as total FROM jurnal JOIN transaksi on transaksi.id_trans=jurnal.id_trans WHERE month(tgl_trans) between '".$awal."' and '".$akhir."' and year(tgl_trans) = '".$tahun."' and no_akun LIKE '62_'")->row();
				$data['jml_non'] = $query->total;
				$query = $this->db->query("SELECT no_akun,sum(nominal) as total FROM jurnal JOIN transaksi on transaksi.id_trans=jurnal.id_trans WHERE month(tgl_trans) between '".$awal."' and '".$akhir."' and year(tgl_trans) = '".$tahun."' and no_akun LIKE '63_'")->row();
				$data['jml_toko'] = $query->total;
				$query = $this->db->query("SELECT no_akun,sum(nominal) as total FROM jurnal JOIN transaksi on transaksi.id_trans=jurnal.id_trans WHERE month(tgl_trans) between '".$awal."' and '".$akhir."' and year(tgl_trans) = '".$tahun."' and no_akun LIKE '6__' and no_akun not like '64_'")->row();
				$data['total_beban'] = $query->total;
				$data['pend_bbn'] = $data['jasa']+$data['penjualan']-$data['pemb']-$data['total_beban'];
				$data['pajak'] = $data['pend_bbn']*1/100;
				$data['shu'] = $data['pend_bbn']-$data['pajak'];
				if ($unit == 1) {
					$this->my_page->set_page('Perhitungan hasil usaha Simpan Pinjam');
					$this->template->load('template','laporan/phu_usp',$data);
				}elseif ($unit==2) {
					$this->my_page->set_page('Perhitungan Hasil Usaha Toko');
					$this->template->load('template','laporan/phu_toko',$data);
				}else{
					$this->template->load('template','laporan/phu',$data);
				}
			}
		}
		public function filter_shu(){
			$this->my_page->set_page('Filter SHU');
			$this->template->load('template','laporan/filter_shu');
		}
		public function pembagian_shu(){
			$unit = $this->input->post('unit');
			if (date('Y-m-d') != date('Y').'-12-31') {
				$this->my_page->set_page("Perhitungan Sisa Hasil Usaha");
				$this->template->load('template','laporan/shu_nongenerate');
			}else{
				$query = $this->db->query("SELECT no_akun,sum(nominal) as total FROM jurnal WHERE no_akun = '421'")->row();
				$jasa = $query->total;
				$query = $this->db->query("SELECT no_akun,sum(nominal) as total FROM jurnal JOIN transaksi on transaksi.id_trans=jurnal.id_trans WHERE year(tgl_trans) = '".date('Y')."' and no_akun = '411'")->row();
				$penjualan = $query->total;
				$query = $this->db->query("SELECT no_akun,sum(nominal) as total FROM jurnal JOIN transaksi on transaksi.id_trans=jurnal.id_trans WHERE year(tgl_trans) = '".date('Y')."' and no_akun LIKE '63_'")->row();
				$jml_toko = $query->total;
				$query = $this->db->query("SELECT no_akun,sum(nominal) as total FROM jurnal JOIN transaksi on transaksi.id_trans=jurnal.id_trans WHERE year(tgl_trans) = '".date('Y')."' and no_akun like '6__' and no_akun not LIKE '63_' and no_akun not like '64_'")->row();
				$jml_usp = $query->total;
				$query = $this->db->query("SELECT sum(nominal) as total FROM jurnal WHERE no_akun LIKE '6__' and no_akun not like '64_' ")->row();
				$tot_beban = $query->total;
				$q = $this->db->query("SELECT sum(jml_trans) as jml_trans FROM pembelian WHERE year(tgl_trans) = '".date('Y')."'")->row();
				$pemb = $q->jml_trans;
				//shu gab
				$tot_pend = $jasa+$penjualan;
				$pend_bbn = $tot_pend-$tot_beban;
				$pajak_gab = $pend_bbn*1/100;
				$data['shu_gab'] = $pend_bbn-$pajak_gab;
				//shu toko
				$pend_toko = $penjualan-$jml_toko-$pemb;
				$pajak_toko = $pend_toko*1/100;
				$data['shu_toko'] = $pend_toko-$pajak_toko;
				$shu_toko = $pend_toko-$pajak_toko;
				//shu usp
				$pend_usp = $jasa-$jml_usp;
				$pajak_usp = $pend_usp*1/100;
				$data['shu_usp'] = $pend_usp-$pajak_usp;
				$shu_usp = $pend_usp-$pajak_usp;
				//pembagian SHU 
				$data['pemb_usp'] = $this->db->query("SELECT * FROM `obyek_alokasi` WHERE id_obyek <=11")->result();
				$data['pemb_toko'] = $this->db->query("SELECT * FROM `obyek_alokasi` WHERE id_obyek >11")->result();
				$data['pemb_gab'] = $this->db->query("SELECT * FROM obyek_alokasi")->result();

				$data['tahun'] = date('Y');

				//input ke tabel pembagian SHU
				$this->db->where('periode',date('Y'));
				$query = $this->db->get('rencana_pembagian')->result();
				$jumlah_data = count($query);
				if ($jumlah_data <1) {
					//insert alokasi usp
					$alokasi_usp = $this->db->query("SELECT * FROM `obyek_alokasi` WHERE id_obyek <=11")->result();
					foreach ($alokasi_usp as $data2) {
						$data3 = array(
							'id' => $data2->id_obyek,
							'periode' => date('Y'),
							'hasil_pembagian' => $data2->prosentase*$shu_usp/100
						);
						$this->db->insert('rencana_pembagian',$data3);
					}
					//insert alokasi toko
					$alokasi_toko = $this->db->query("SELECT * FROM `obyek_alokasi` WHERE id_obyek >11")->result();
					foreach ($alokasi_toko as $data2) {
						$data3 = array(
							'id' => $data2->id_obyek,
							'periode' => date('Y'),
							'hasil_pembagian' => $data2->prosentase*$shu_toko/100
						);
						$this->db->insert('rencana_pembagian',$data3);
					}
					//insert ke jurnal

				}
				if ($unit == 1) {
					$this->my_page->set_page("Perhitungan Sisa Hasil Usaha Unit Simpan Pinjam");
					$this->template->load('template','laporan/shu_usp',$data);
				}elseif ($unit==2) {
					$this->my_page->set_page("Perhitungan Sisa Hasil Usaha Unit Toko");
					$this->template->load('template','laporan/shu_toko',$data);
				}else{
					$this->template->load('template','laporan/shu',$data);
				}
			}
		}
		public function penerimaan_usp(){
            $this->my_page->set_page('Penerimaan Jasa Unit Simpan Pinjam');
            $data['tahun'] = $this->db->query("SELECT year(tgl_trans) as tahun FROM `transaksi` where tgl_trans is not null and tgl_trans > 0 and id_trans like '%PIN%' or id_trans like '%SIM%' group by year(tgl_trans)")->result();
            // $this->template->load('template','laporan/laporan_usp_v',$data);
            $this->load->view('laporan/laporan_usp_v',$data);
        }
        public function get_penerimaan_usp(){
            $tahun = $this->input->post('tahun');
            $this->db->where('status !=','4');
            $anggota = $this->db->Get('anggota')->result();
            $no=0;
            $total_sisa_pinjaman = 0;
            $total_jasa_peminjam = 0;
            $total_sp_sw = 0;
            $total_smh_shr = 0;
            $grand_total = 0;
            foreach($anggota as $data){
                $detail_usp = $this->model->get_detail_usp($data->no_anggota,$tahun);
                $no++;
                $jumlah = $detail_usp['jasa_smn_shr']+$detail_usp['jasa_sp_sw']+$detail_usp['jasa_peminjam'];
                $total_sisa_pinjaman = $total_sisa_pinjaman +$detail_usp['sisa_pinjaman'] ;
	            $total_jasa_peminjam = $total_jasa_peminjam + $detail_usp['jasa_peminjam'] ;
	            $total_sp_sw = $total_sp_sw + $detail_usp['jasa_sp_sw'] ;
	            $total_smh_shr = $total_smh_shr + $detail_usp['jasa_smn_shr'];
	            $grand_total = $grand_total + $jumlah;
                echo '<tr>
                        <td>'.$no.'</td>
                        <td>'.$data->no_anggota.'</td>
                        <td>'.$data->nama.'</td>
                        <td>'.format_rp($detail_usp['sisa_pinjaman']).'</td>
                        <td>'.format_rp($detail_usp['jasa_peminjam']).'</td>
                        <td>'.format_rp($detail_usp['jasa_sp_sw']).'</td>
                        <td>'.format_rp($detail_usp['jasa_smn_shr']).'</td>
                        <td>'.format_rp($jumlah).'</td>
                      </tr>';      
            }
            echo '|<tr style="background-color:#6C7A89;color:white;">
                        <td colspan="3">TOTAL</td>
                        <td>'.format_rp($total_sisa_pinjaman).'</td>
                        <td>'.format_rp($total_jasa_peminjam).'</td>
                        <td>'.format_rp($total_sp_sw).'</td>
                        <td>'.format_rp($total_smh_shr).'</td>
                        <td>'.format_rp($grand_total).'</td>
                      </tr> |'.$grand_total.'|';
            //	Check button
            	$this->db->where('year(tgl_trans)',$tahun);
            	$this->db->where('id_trans like','%PSP%');
            	$q = $this->db->get('transaksi')->result();
            	if(count($q) > 0){
            		echo 'false';
            	}else{
            		echo 'true';
            	}
        }
        public function profit_penjualan(){
        	if(isset($_POST['btnSubmit'])){
        		$periode = $this->input->post('periode');
        	}else{
        		$periode = date('Y');
        	}
        	$data['tahun'] = $this->db->query("SELECT tgl_trans, year(tgl_trans) as tahun FROM `transaksi` WHERE tgl_trans is not null and tgl_trans != 0 group by year(tgl_trans)")->result();
        	$data['keuntungan'] = $this->model->get_keuntungan($periode);
        	$this->my_page->set_page('Laporan Keuntungan Penjualan');
        	$this->template->load('template','laporan/keuntungan',$data);
        }
        public function tunggakan(){
			$this->template->load('template','laporan/tunggakan');
		}

		public function penerimaan_jasa(){
			$this->my_page->set_page("Penerimaan Jasa");
			$this->template->load('template','laporan/penerimaan_jasa_view');
		}
		public function penerimaan_toko(){
			 $data['tahun'] = $this->db->query("SELECT year(tgl_trans) as tahun FROM `transaksi` where tgl_trans is not null and tgl_trans > 0 and id_trans like '%PIN%' or id_trans like '%SIM%' group by year(tgl_trans)")->result();
			$this->load->view('laporan/penerimaan_toko_v',$data);
		}
		public function get_penerimaan_toko(){
			$this->db->Where('no_anggota !=','0');
			$anggota = $this->db->get('anggota')->result();
			$tahun = $this->input->post('tahun');
			$grand_total_shu_diterima = 0;
			$i = 1;
			$total_jasa_anggota = 0;
			foreach($anggota as $data){
				// get sisa pinjaman
					$sisa_pinjaman = 0;
					$this->db->where('no_anggota',$data->no_anggota);
					$nota_penjualan = $this->db->Get('nota_penjualan')->result();
					foreach($nota_penjualan as $nota_penjualan){
						$total_transaksi = $nota_penjualan->jml_trans;
						
						$this->db->where('id_penjualan',$nota_penjualan->id_penjualan);
						$this->db->select('sum(jml_trans) as jml_trans');
						$this->db->group_by('id_penjualan');
						$angsuran_penj = $this->db->get('angsuran_penj')->row();
						$telah_dibayar = $angsuran_penj->jml_trans;
						$kurang_pembayaran = $total_transaksi - $telah_dibayar;
						$sisa_pinjaman = $sisa_pinjaman+$kurang_pembayaran;
					}
				// tunai
					$this->db->where('no_anggota',$data->no_anggota);
					$this->db->where('year(tgl_trans)',$tahun);
					$this->db->select('sum(jml_trans) as jumlah_trans');
					$total_tunai_per_anggota = $this->db->get('nota_penjualan')->row()->jumlah_trans;

				// Penjualan Seluruh Anggota 
					$this->db->where('year(tgl_trans)',$tahun);
					$this->db->where('no_anggota !=','0');
					$this->db->select('sum(jml_trans) as total_penjualan');
					$penjualan_seluruh_anggota = $this->db->get('nota_penjualan')->row()->total_penjualan;
				//  rencana pembagian 
					$this->db->where('id','13');
					$this->db->where('periode',$tahun);
					$this->db->select('*,sum(hasil_pembagian) as test');
					$rencana_pembagian = $this->db->get('rencana_pembagian')->row()->hasil_pembagian;
					// $total_tunai = $total_tunai_per_anggota/$penjualan_seluruh_anggota*$rencana_pembagian;
					$total_tunai = $total_tunai_per_anggota/$penjualan_seluruh_anggota*$rencana_pembagian;
					$total_jasa_anggota = $total_jasa_anggota + $total_tunai;
				// penjualan non anggota
					$this->db->where('year(tgl_trans)',$tahun);
					$this->db->where('no_anggota =','0');
					$this->db->select('sum(jml_trans) as total_penjualan');
					$penjualan_non_anggota = $this->db->get('nota_penjualan')->row()->total_penjualan;
				// jumlah anggota
					$jumlah_anggota = $this->db->query("select count(no_anggota) as jumlah_anggota from anggota where no_anggota != '0'")->Row()->jumlah_anggota;
					$pemerataan = $penjualan_non_anggota/$jumlah_anggota;	
					$shu_diterima = ($total_tunai+$pemerataan)/($penjualan_seluruh_anggota+$penjualan_non_anggota)*$rencana_pembagian;
					$grand_total_shu_diterima = $grand_total_shu_diterima + $shu_diterima;
				echo '<tr>
						<td>'.$i.'</td>
						<td>'.$data->no_anggota.'</td>
						<td>'.$data->nama.'</td>
						<td style="text-align:right;">'.format_rp($sisa_pinjaman).'</td>
						<td style="text-align:right;">'.format_rp($total_tunai).'</td>
						<td style="text-align:right;">'.format_rp($pemerataan).'</td>
						<td style="text-align:right;">'.format_rp($shu_diterima).'</td>
					</tr>';
				$i++;
			}
			echo '<tr style="background-color:#6C7A89;color:white;">
				<td colspan ="2">TOTAL</td>
				<td></td>
				<td></td>
				<td style="text-align:right;">'.format_rp($penjualan_seluruh_anggota).'</td>
				<td style="text-align:right;">'.format_rp($penjualan_non_anggota).'</td>
				<td style="text-align:right;">'.format_rp($grand_total_shu_diterima).'</td>
			</tr>|';
			//	Check button
            	$this->db->where('year(tgl_trans)',$tahun);
            	$this->db->where('id_trans like','%PJT%');
            	$q = $this->db->get('transaksi')->result();
            	if(count($q) > 0){
            		echo 'false';
            	}else{
            		echo 'true';
            	}

		}
		/*public function LihatTunggakan(){
			$list = $this->model->get_data_tunggakan();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $query) {
				$no++;
				$row = array();
				$row[] = $query->no_anggota;
				$row[] = $query->nama;
				//ambil simpanan wajib peranggota
				$this->db->where('no_anggota',$query->no_anggota);
				$this->db->where('id_jenis','2');
				$this->db->where('month(tgl_simpan)',date('m'));
				$this->db->where('year(tgl_simpan)',date('Y'));
				$q = $this->db->get('simpanan')->result();
				$jumlah_data = count($q);
				if($jumlah_data < 1){
					$this->db->where('no_anggota',$query->no_anggota);
					$this->db->where('id_jenis','2');
					$q = $this->db->get('simpanan_anggota')->row();
					$row[] = format_rp($q->tarif);
				}else{
					$row[] = 0;
				}
				//ambil simpanan manasuka
				$this->db->where('no_anggota',$query->no_anggota);
				$this->db->where('id_jenis','3');
				$this->db->where('month(tgl_simpan)',date('m'));
				$this->db->where('year(tgl_simpan)',date('Y'));
				$q = $this->db->get('simpanan')->result();
				$jumlah_data = count($q);
				if($jumlah_data < 1){
					$this->db->where('no_anggota',$query->no_anggota);
					$this->db->where('id_jenis','3');
					$q = $this->db->get('simpanan_anggota')->row();
					$jml_data = count($q);
					if ($jml_data < 1) {
						$row[] = 0;
					}else{
						$row[] = format_rp($q->tarif);
					}
				}else{
					$row[] = 0;
				}
				//ambil simpanan hari raya
				$this->db->where('no_anggota',$query->no_anggota);
				$this->db->where('id_jenis','5');
				$this->db->where('month(tgl_simpan)',date('m'));
				$this->db->where('year(tgl_simpan)',date('Y'));
				$q = $this->db->get('simpanan')->result();
				$jumlah_data = count($q);
				if($jumlah_data < 1){
					$this->db->where('no_anggota',$query->no_anggota);
					$this->db->where('id_jenis','5');
					$q = $this->db->get('simpanan_anggota')->row();
					$jml_data = count($q);
					if ($jml_data < 1) {
						$row[] = 0;
					}else{
						$row[] = format_rp($q->tarif);
					}
				}else{
					$row[] = 0;
				}
				//ambil simpanan pendidikan
				//ambil simpanan hari raya
				$this->db->where('no_anggota',$query->no_anggota);
				$this->db->where('id_jenis','4');
				$this->db->where('month(tgl_simpan)',date('m'));
				$this->db->where('year(tgl_simpan)',date('Y'));
				$q = $this->db->get('simpanan')->result();
				$jumlah_data = count($q);
				if($jumlah_data < 1){
					$this->db->where('no_anggota',$query->no_anggota);
					$this->db->where('id_jenis','4');
					$q = $this->db->get('simpanan_anggota')->row();
					$jml_data = count($q);
					if ($jml_data < 1) {
						$row[] = 0;
					}else{
						$row[] = format_rp($q->tarif);
					}
				}else{
					$row[] = 0;
				}
				//ambil angsuran
				$this->db->where('no_anggota',$query->no_anggota);
				$this->db->where('status','2');
				$q = $this->db->get('pinjaman')->result();
				$jumlah_data = count($q);
				if ($jumlah_data > 0) {
					$this->db->where('no_anggota',$query->no_anggota);

					$q2 = $this->db->get('angsuran_pinj')->row();
					$jml_data = count($q2);
					if ($jml_data < 1) {
						$row[] = $q->tarif_angsur;
					}else{
						$row[] = 0;
					}
				}else{
					$row[] = 0;
				}
				$row[] = 0;
				$row[] = 0;
				$row[] = 0;
				$row[] = 0;
				$row[] = 0;
				$row[] = 0;
				$data[] = $row;
			}
			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => count($list),
							"recordsFiltered" => count($list),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output);
		}*/
}