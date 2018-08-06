<?php
header('Access-Control-Allow-Origin: *');
	class Simpanan extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('Simpanan_model','model');
			$this->my_page->set_page('Simpanan');
			$check_session = $this->Account_model->check_session();
			if(!$check_session){
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
				redirect('account');
			}
		}
		// laporan pembelian
			public function index(){
				$this->template->load('template','simpanan/simpanan_view');
			}
			public function read_simpanan(){
				$list = $this->model->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $transaksi) {
					$no++;
					$row = array();
					$row[] = $transaksi->id_simpanan;
					$row[] = $transaksi->no_anggota;
					$row[] = $transaksi->nama;
					$row[] = $transaksi->keterangan;
					$row[] = $transaksi->tgl_simpan;
					$row[] = format_rp($transaksi->jml_simpanan);
					$row[] = get_monthname($transaksi->periode)." ".$transaksi->tahun;
					$data[] = $row;
				}

				$output = array(
								"draw" => $_POST['draw'],
								"recordsTotal" => $this->model->count_all(),
								"recordsFiltered" => $this->model->count_filtered(),
								"data" => $data,
						);
				//output to json format
				echo json_encode($output);
			}
			public function tambah_simpanan(){
				$id_simpanan = $this->model->get_id_simpanan();
				$data['id_simpanan'] = $id_simpanan;
				$data['anggota'] = $this->model->get_anggota();
				$this->template->load('template','simpanan/add_simpanan',$data);
			}
			public function get_simpanan_angg($no_anggota){
				$data = $this->model->get_simpanan_angg($no_anggota);
				foreach($data as $data){
					echo "<option value='".$data->id_jenis."'>".$data->keterangan."</option>";					
				}
			}
			public function get_tarif($no_anggota,$id_jenis){
				$data = $this->model->get_tarif($no_anggota,$id_jenis);
				echo format_rp($data->tarif);
			}
			public function selesai(){
				$id_simpanan = $this->input->post('id_simpanan');
				$periode_awal = $this->input->post('periode');
				$periode = get_month($periode_awal);
				$no_anggota = $this->input->post('no_anggota');
				$id_jenis = $this->input->post('id_jenis');
				$tahun = $this->input->post('tahun');
				$total_post = $this->input->post('tarif');
				$remove_rp = str_replace("Rp.","",$total_post);
				$total = str_replace(".","",$remove_rp);
				$tanggal = date('Y-m-d');
				//update table transaksi
					$data = array(
						'tgl_trans' => $tanggal,
						'jml_trans' => $total);
					$this->db->where('id_trans',$id_simpanan);
					$this->db->update('transaksi',$data);
				//update table simpanan
					$data = array(
						'tgl_simpan' => $tanggal,
						'jml_simpanan' => $total,
						'periode' => $periode,
						'tahun' => $tahun,
						'no_anggota' => $no_anggota,
						'id_jenis' => $id_jenis
						);
				$this->db->where('id_simpanan',$id_simpanan);
				$this->db->update('simpanan',$data);
				//nambahin jml simpanan yang dimiliki
				$query = $this->db->query("SELECT * FROM simpanan_anggota WHERE no_anggota = '".$no_anggota."' AND id_jenis = '".$id_jenis."'")->row();
				$jml_simpanan_before = $query->jml_simpanan_dimiliki;
				$jml_simpanan_after = $jml_simpanan_before+$total;
				$this->db->where('no_anggota',$no_anggota);
				$this->db->where('id_jenis',$id_jenis);
				$this->db->set('jml_simpanan_dimiliki',$jml_simpanan_after);
				$this->db->update('simpanan_anggota');
				//update status anggota simpanan pokok
				$this->db->where('id_simpanan',$id_simpanan);
				//input ke jurnal
				if ($id_jenis == 1) {
					$data = array(
						'no_akun' => 111,
						'posisi_dr_cr' => 'd',
						'nominal' => $total,
						'id_trans' => $id_simpanan
					);
					$this->db->insert('jurnal',$data);
					$data = array(
						'no_akun' => 311,
						'posisi_dr_cr' => 'k',
						'nominal' => $total,
						'id_trans' => $id_simpanan
					);
					$this->db->insert('jurnal',$data);
				}elseif ($id_jenis == 2) {
					$data = array(
						'no_akun' => 111,
						'posisi_dr_cr' => 'd',
						'nominal' => $total,
						'id_trans' => $id_simpanan
					);
					$this->db->insert('jurnal',$data);
					$data = array(
						'no_akun' => 312,
						'posisi_dr_cr' => 'k',
						'nominal' => $total,
						'id_trans' => $id_simpanan,
					);
					$this->db->insert('jurnal',$data);
				}elseif ($id_jenis == 3) {
					$data = array(
						'no_akun' => 111,
						'posisi_dr_cr' => 'd',
						'nominal' => $total,
						'id_trans' => $id_simpanan
					);
					$this->db->insert('jurnal',$data);
					$data = array(
						'no_akun' => 212,
						'posisi_dr_cr' => 'k',
						'nominal' => $total,
						'id_trans' => $id_simpanan
					);
					$this->db->insert('jurnal',$data);
				}elseif ($id_jenis == 4) {
					$data = array(
						'no_akun' => 111,
						'posisi_dr_cr' => 'd',
						'nominal' => $total,
						'id_trans' => $id_simpanan
					);
					$this->db->insert('jurnal',$data);
					$data = array(
						'no_akun' => 213,
						'posisi_dr_cr' => 'k',
						'nominal' => $total,
						'id_trans' => $id_simpanan
					);
					$this->db->insert('jurnal',$data);
				}else{
					$data = array(
						'no_akun' => 111,
						'posisi_dr_cr' => 'd',
						'nominal' => $total,
						'id_trans' => $id_simpanan
					);
					$this->db->insert('jurnal',$data);
					$data = array(
						'no_akun' => 214,
						'posisi_dr_cr' => 'k',
						'nominal' => $total,
						'id_trans' => $id_simpanan
					);
					$this->db->insert('jurnal',$data);
				}
				$this->db->where('no_anggota',$no_anggota);
				$query = $this->db->get('simpanan')->row();
				$id_jen = $query->id_jenis;
				if ($id_jen == 1) {
					$this->db->where('no_anggota',$no_anggota);
					$this->db->set('keterangan',1);
					$this->db->update('anggota');
					redirect('Simpanan');
				}else{
					redirect('Simpanan');
				}	
			}
			public function get_periode($id_jenis,$no_anggota,$tahun){
				$query = $this->db->query("SELECT no_anggota,id_jenis,tahun,max(periode*1) as periode FROM simpanan
						WHERE no_anggota = '".$no_anggota."' and id_jenis = '".$id_jenis."' and tahun = '".$tahun."'")->row();
				$periode = $query->periode;
				$query = $this->db->query("SELECT no_anggota,tahun_masuk,bln_masuk FROM anggota
						WHERE no_anggota = '".$no_anggota."'")->row();
				$tahun_masuk = $query->tahun_masuk;
				$bln_masuk = $query->bln_masuk;
				if ($periode == null && $tahun_masuk == date('y') && $bln_masuk == date('m')) {
					$periode = date('m');
					echo get_monthname($periode);
				}elseif ($periode == null && $tahun_masuk == date('y')) {
					$periode = $bln_masuk;
					echo get_monthname($periode);
				}elseif ($periode == null) {
					$periode = 1;
					echo get_monthname($periode);
				}else{
					$periode = $periode+1;
					echo get_monthname($periode);
				}
			}
			public function cetak_pdf(){
				ini_set('max_execution_time', 300);
				$this->db->select('id_simpanan, jml_simpanan, tgl_simpan, no_anggota,keterangan,periode,tahun');
				$this->db->from('simpanan');
				$this->db->join('jenis_simpanan','simpanan.id_jenis = jenis_simpanan.id_jenis');
		        $data['list'] = $this->db->get();
		        $sumber = $this->load->view('simpanan/trans_simpanan_pdf', $data, true);
		        $html = $sumber;
		        $pdfFilePath = "DaftarTransaksiSimpanan---".date('Y-m-d H:i').".pdf";
		        $pdf = $this->m_pdf->load();
		        $pdf->AddPage('P');
		        $pdf->useSubstitutions = false;
		        $pdf->simpleTables = true;
		        //$pdf->WriteHTML($stylesheet, 1);
		        $pdf->WriteHTML($html);
		        
		        $pdf->Output($pdfFilePath, "D");
		        exit();
			}
	}