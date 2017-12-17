<?php
	class Laporan extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('model_laporan','model');
			$this->load->library('pagination');
		}
		public function index(){
			$this->jurnal();
		}
		public function jurnal(){
			if(isset($_POST['btnsubmit'])){
				$this->model->tanggal_awal = $this->input->post('tanggal_awal');
				$this->model->tanggal_akhir = $this->input->post('$tanggal_akhir');
			}else{
				$this->model->tanggal_awal = '0000-00-00';
				$this->model->tanggal_akhir = '9999-12-12';
			}
			$this->my_page->set_page('Jurnal Umum');
			$jumlah_data = $this->model->jumlah_data();
			$config['base_url'] = base_url().'index.php/laporan/jurnal/';
			$config['total_rows'] = $jumlah_data;
			$config['per_page'] = 10;
			$config['full_tag_open'] = '<ul class="pagination pull-right">';
		    $config['full_tag_close'] = '</ul>';
		    $config['first_link'] = false;
		    $config['last_link'] = false;
		    $config['first_tag_open'] = '<li class="page-link">';
		    $config['first_tag_close'] = '</li class="page-link">';
		    $config['prev_link'] = 'Previous';
		    $config['prev_tag_open'] = '<li class="page-link">';
		    $config['prev_tag_close'] = '</li>';
		    $config['next_link'] = 'Next';
		    $config['next_tag_open'] = '<li class="page-link">';
		    $config['next_tag_close'] = '</li>';
		    $config['last_tag_open'] = '<li class="page-link">';
		    $config['last_tag_close'] = '</li>';
		    $config['cur_tag_open'] = '<li class="paginate_button page-item previous disabled" id="table_previous"><a href="#" class="page-link">';
		    $config['cur_tag_close'] = '</a></li>';
		    $config['num_tag_open'] = '<li class="page-link">';
		    $config['num_tag_close'] = '</li>';
			$from = $this->uri->segment(3);
			$this->pagination->initialize($config);		
			$data['jurnal'] = $this->model->data($config['per_page'],$from);
			$this->template->load('template','laporan/jurnal',$data);
		}
		public function buku_besar(){
			$this->my_page->set_page('Buku Besar');
			$data['tahun'] = $this->db->query("SELECT year(tgl_trans) as tahun FROM `transaksi` group by year(tgl_trans)")->result();
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
				<td></td>';
				if($saldo_awal <= 0){
					echo '<td></td>
					<td>'.format_rp($saldo_awal).'</td></tr>';
				}else{
					echo '<td>'.format_rp($saldo_awal).'</td>
					<td></td></tr>';	
				}
			
			foreach($buku_besar as $data){
				echo'<tr>
					<td>'.$data->no_akun.'</td>
					<td>'.$data->nama_akun.'</td>';
				if($data->posisi_dr_cr =='d'){
					$saldo_awal = $saldo_awal + $data->nominal;
					echo '
						<td>'.format_rp($data->nominal).'</td>
						<td></td>
					';
				}else{
					$saldo_awal = $saldo_awal - $data->nominal;
					echo '
						<td></td>
						<td>'.format_rp($data->nominal).'</td>
					';
				}
				if($saldo_awal > 0){
				echo '<td>'.format_rp($saldo_awal).'</td>
						<td></td>';
				}else{
				echo '<td></td>
						<td>'.format_rp(str_replace("-",'',$saldo_awal)).'</td>';
				}
			}

		}
		public function neraca_saldo(){
			$this->my_page->set_page('Neraca Saldo');
			$data['tahun'] = $this->db->query("SELECT year(tgl_trans) as tahun FROM `transaksi` group by year(tgl_trans)")->result();
			$this->template->load('template','laporan/neraca_saldo',$data);
		}
		public function get_neraca_saldo($bulan = '',$tahun = ''){
			$coa = $this->db->get('coa')->result();
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
					echo '
					<td>-</td>
					<td>'.format_rp(abs($saldo)).'</td>';
				}elseif($saldo == 0){
					echo'<td>-</td>
					<td>-</td>';
				}
				else{
					echo '
					<td>'.format_rp($saldo).'</td>
					<td>-</td>';
				}
			}
		}
		public function arus_kas(){
			$this->my_page->set_page('Arus Kas');
			$data['tahun'] = $this->db->query("SELECT year(tgl_trans) as tahun FROM `transaksi` group by year(tgl_trans)")->result();
			$this->template->load('template','laporan/arus_kas',$data);
		}
		public function get_arus_kas($tahun,$bulan){
			header('Content-type: application/json');
			//get penjualan
				$saldo_penjualan = $this->model->get_saldo_awal_buku_besar($tahun,$bulan,'501');
				$this->db->where('no_akun','501');
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
				$this->db->where('no_akun','102');
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
			$json = array(
				'penjualan' => format_rp($penjualan),
				'pbd' => format_rp($pbd),
				'ak_op' => format_rp($penjualan-$pbd));
			echo json_encode($json);
		}

	}