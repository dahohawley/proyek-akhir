<?php
header('Access-Control-Allow-Origin: *');
	class Angsuran extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('Angsuran_model','model');
			$this->my_page->set_page('Angsuran');
			$check_session = $this->Account_model->check_session();
			if(!$check_session){
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
				redirect('account');
			}
		}
			public function index(){
				$this->template->load('template','angsuran/angsuran_view');
			}
			public function read_angsuran(){
				$list = $this->model->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $transaksi) {
					$no++;
					$row = array();
					$row[] = $transaksi->id_angsuran;
					$row[] = $transaksi->id_pinjam;
					$row[] = $transaksi->tgl_angsur;
					$row[] = $transaksi->nama;
					$row[] = format_rp($transaksi->jml_angsur);
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
			
			public function cetak_pdf(){
				ini_set('max_execution_time', 300);
				$this->db->select('id_angsuran,jml_angsur,tgl_angsur,sisa_pinjaman,no_anggota,id_pinjam,periode,tahun');
				$this->db->from('angsuran_pinj');
		        $data['list'] = $this->db->get();
		        $sumber = $this->load->view('angsuran/angsuran_pdf', $data, true);
		        $html = $sumber;
		        $pdfFilePath = "DaftarAngsuran---".date('Y-m-d H:i').".pdf";
		        $pdf = $this->m_pdf->load();
		        $pdf->AddPage('P');
		        $pdf->useSubstitutions = false;
		        $pdf->simpleTables = true;
		        //$pdf->WriteHTML($stylesheet, 1);
		        $pdf->WriteHTML($html);
		        
		        $pdf->Output($pdfFilePath, "D");
		        exit();
			}
			public function tambah_angsuran($no_anggota,$id_pinjam){
				$id_angsuran = $this->model->get_id_angsuran();
				$data['id_angsuran'] = $id_angsuran;
				$data['anggota'] = $this->model->get_anggota($no_anggota);
				$data['kode_pinjaman'] = $this->model->get_kode_pinjaman($id_pinjam,$no_anggota);
				$this->template->load('template','angsuran/add_angsuran',$data);
			}
			public function get_periode($id_pinjam,$no_anggota){
				$this->db->where('id_pinjam',$id_pinjam);
				$this->db->where('no_anggota',$no_anggota);
				$query = $this->db->query("SELECT month(awal) as periode, year(awal) as tahun from(
				SELECT adddate(tgl_pencairan, interval 1 month) as awal,adddate(jatuh_tempo, interval 1 month) as jatuh_tempo FROM pinjaman where no_anggota = '".$no_anggota."' and id_pinjam = '".$id_pinjam."') as tabel")->row();
				$bulan = $query->periode;
				$tahun = $query->tahun;
				$query1 = $this->db->query("SELECT periode,tahun as tahun1 FROM angsuran_pinj WHERE periode=(
				SELECT max(periode*1) as periode FROM angsuran_pinj WHERE no_anggota = '".$no_anggota."' AND id_pinjam = '".$id_pinjam."')")->row();
				$jumlah_data = count($query1);
				if($jumlah_data < 1){
					$periode = $bulan;
					$tahun = $tahun;
					echo get_monthname($periode)." ".$tahun;
				}else{
					$periode1 = $query1->periode;
					$tahun = $query1->tahun1;
					$periode = $periode1+1;
					if($periode > 12){
						$periode = 1;
						$tahun = $tahun+1;
					}
					echo get_monthname($periode).' '.$tahun;
				}
			}
			public function get_jml_angsur($no_anggota,$id_pinjam){
				$data = $this->model->get_jml_angsur($no_anggota,$id_pinjam);
				echo format_rp($data->tarif_angsur);
			}
			public function selesai(){
				$id_angsuran = $this->input->post('id_angsuran');
				$no_anggota = $this->input->post('no_anggota');
				$id_pinjam = $this->input->post('id_pinjam');
				$angsur_post = str_replace('Rp.',"",$this->input->post('jml_angsur'));
				$jml_angsur = str_replace('.',"",$angsur_post)*1;
				$tahun = $this->input->post('tahun');
				$periode = explode(' ',$this->input->post('periode'));
				$bulan_post = $periode[0];
				$tahun = $periode[1];
				$bulan = get_month($bulan_post);
				$tanggal = date('Y-m-d');
				$query = $this->db->query('SELECT max(tgl_angsur) as tgl_angsur, min(sisa_pinjaman) as sisa_pinjaman FROM angsuran_pinj WHERE id_pinjam = "'.$id_pinjam.'" and no_anggota = '.$no_anggota.' ')->row();
				$sisa = $query->sisa_pinjaman;
				$this->db->where('id_pinjam',$id_pinjam);
				$this->db->where('no_anggota',$no_anggota);
				$query1 = $this->db->get('pinjaman')->row();
				$jml_pinjam = $query1->jml_pinjam;
				if ($sisa == null) {
					$jml_angsur1 = $jml_angsur*100/101.2;
					$sisa_pinjam = $jml_pinjam-$jml_angsur1;
				}else{
					$jml_angsur1 = $jml_angsur*100/101.2;
					$sisa_pinjam = $sisa - $jml_angsur1;
				}
				$data= array(
					'tgl_trans' => $tanggal,
					'jml_trans' => $jml_angsur
				);
				$this->db->where('id_trans',$id_angsuran);
				$this->db->update('transaksi',$data);
				$data = array(
					'no_anggota' => $no_anggota,
					'id_pinjam' => $id_pinjam,
					'tahun' => $tahun,
					'periode' => $bulan,
					'tgl_angsur' => $tanggal,
					'sisa_pinjaman' => $sisa_pinjam,
					'jml_angsur' => $jml_angsur
				);
				$this->db->where('id_angsuran',$id_angsuran);
				$this->db->update('angsuran_pinj',$data);
				//hitung bunga sama angsuran tanpa bunga
				$angsuran_asli = $jml_angsur*100/101.2;
				$bunga = $jml_angsur-$angsuran_asli;
				//input ke jurnal
				$data = array(
					'no_akun' => 111,
					'posisi_dr_cr' => 'd',
					'nominal' => $jml_angsur,
					'id_trans' => $id_angsuran
				);
				$this->db->insert('jurnal',$data);
				$data = array(
					'no_akun' => 112,
					'posisi_dr_cr' => 'k',
					'nominal' => $angsuran_asli,
					'id_trans' => $id_angsuran
				);
				$this->db->insert('jurnal',$data);
				$data = array(
					'no_akun' => 421,
					'posisi_dr_cr' => 'k',
					'nominal' => $bunga,
					'id_trans' => $id_angsuran
				);
				$this->db->insert('jurnal',$data);
				//ubah status jadi lunas
				$query = $this->db->query('SELECT max(tgl_angsur) as tgl_angsur, min(sisa_pinjaman) as sisa_pinjaman FROM angsuran_pinj WHERE id_pinjam = "'.$id_pinjam.'" and no_anggota = '.$no_anggota.' ')->row();
				$sisa = $query->sisa_pinjaman;
				if ($sisa <= 0) {
					$this->db->where('id_pinjam',$id_pinjam);
					$this->db->where('no_anggota',$no_anggota);
					$this->db->set('status', 3);
					$this->db->update('pinjaman');
					redirect('Angsuran');
				}else{
					$this->template->load('template','angsuran/angsuran_view');
				}
			}
	}