<?php
header('Access-Control-Allow-Origin: *');
	class Pinjaman extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('Pinjaman_model','model');
			$this->my_page->set_page('Pinjaman');
			$check_session = $this->Account_model->check_session();
			if(!$check_session){
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
				redirect('account');
			}
		}
		// laporan pembelian
			public function index(){
				$this->template->load('template','pinjaman/pinjaman_view');
			}
			public function index_ketua(){
				$this->template->load('template','pinjaman/pinjaman_view_ketua');
			}
			public function index_daftar(){
				$this->template->load('template','pinjaman/daftar_pinjaman_v');
			}
			public function read_pinjaman(){
				$list = $this->model->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $transaksi) {
					$no++;
					$row = array();
					$row[] = $transaksi->id_pinjam;
					$row[] = $transaksi->tgl_pengajuan;
					$row[] = $transaksi->nama;
					$row[] = format_rp($transaksi->jml_pinjam);
					$row[] = format_rp($transaksi->tarif_angsur);
					/*$row[] = $transaksi->jatuh_tempo;*/
					if ($transaksi->status == 0) {
						$status = 'Tunggu Konfirmasi';
						$row[] = $status;
						$row[] = '';
					}elseif ($transaksi->status == 1){
						$status = 'Disetujui';
						$row[] = $status;
						$row[] = '<a class="btn btn-sm btn-primary" href="'.base_url("index.php/Pinjaman/cairkan_dana/").$transaksi->id_pinjam.'">Cairkan Dana</a>';;
					}elseif ($transaksi->status == 2){
						$status = 'Dana Cair';
						$row[] = $status;
						$row[] = '';	
					}elseif ($transaksi->status == 4){
						$status = 'Ditolak';
						$row[] = $status;
						$row[] = '';
					};
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
			public function read_pinjaman_ketua(){
				$list = $this->model->get_datatables_ketua();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $transaksi) {
					$no++;
					$row = array();
					$row[] = $transaksi->id_pinjam;
					$row[] = $transaksi->tgl_pengajuan;
					$row[] = $transaksi->nama;
					$row[] = format_rp($transaksi->jml_pinjam);
					$row[] = format_rp($transaksi->tarif_angsur);
					if ($transaksi->status == 0) {
						$status = 'Tunggu Konfirmasi';
						$row[] = $status;
						$row[] =  '<a class="btn btn-sm btn-primary" href="'.base_url("index.php/Pinjaman/terima_pinjaman/").$transaksi->id_pinjam.'">Terima</a>
							<a class="btn btn-sm btn-danger" href="'.base_url("index.php/Pinjaman/tolak_pinjaman/").$transaksi->id_pinjam.'">Tolak</a>';
					}elseif ($transaksi->status == 1 or $transaksi->status == 2){
						$status = 'Disetujui';
						$row[] = $status;
						$row[] = '';
					}elseif ($transaksi->status==4){
						$status = 'Ditolak';
						$row[] = $status;
						$row[] = '';
					};
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
			public function read_pinjaman_daftar(){
				$list = $this->model->get_datatables_daftar();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $transaksi) {
					$no++;
					$row = array();
					$row[] = $transaksi->id_pinjam;
					$row[] = $transaksi->tgl_pencairan;
					$row[] = $transaksi->nama;
					$row[] = format_rp($transaksi->jml_pinjam);
					$row[] = format_rp($transaksi->tarif_angsur);
					$row[] = $transaksi->jatuh_tempo;
					
					$jml_pinjam = $transaksi->jml_pinjam;
					$this->db->where('id_pinjam',$transaksi->id_pinjam);
					$this->db->select('sum(jml_angsur)*100/101.2 as jml_bayar');
					$jml_bayar = $this->db->get('angsuran_pinj')->row()->jml_bayar;
					$sisa_pinjaman = $jml_pinjam - $jml_bayar;
					if($jml_bayar < $jml_pinjam){
						$status = "Belum Lunas";
					}else{
						$status = "Lunas";
					}

					$row[] = $status;
					$row[] = format_rp($sisa_pinjaman);
					$row[] =  '<a class="btn btn-sm btn-primary" title = "Bayar Angsuran" href="'.base_url("index.php/Angsuran/tambah_angsuran/").$transaksi->no_anggota."/".$transaksi->id_pinjam.'"><i class="fa fa-credit-card-alt"></i></a>';
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
			public function get_jatuh_tempo($banyak){
				$data = $this->model->get_jatuh_tempo($banyak);
				echo $data->jatuh_tempo;
			}
			public function terima_pinjaman($id_pinjam){
				$this->db->where('id_pinjam',$id_pinjam);
				$this->db->set('status',1);
				$this->db->update('pinjaman');
				redirect('Pinjaman/index_ketua');
			}
			public function tolak_pinjaman($id_pinjam){
				$this->db->where('id_pinjam',$id_pinjam);
				$this->db->set('status',4);
				$this->db->update('pinjaman');
				redirect('Pinjaman/index_ketua');
			}
			public function cairkan_dana($id_pinjam){
				$data['pinjaman'] = $this->db->get('pinjaman')->row();
				$data['jatuh_tempo'] = $this->model->get_jatuh_tempo($id_pinjam);
				$data['pinjaman'] = $this->db->query("SELECT id_pinjam,tgl_pengajuan,jml_pinjam,banyak_angsuran,tarif_angsur,jatuh_tempo,pinjaman.no_anggota,anggota.nama from pinjaman join anggota on anggota.no_anggota=pinjaman.no_anggota where id_pinjam = '".$id_pinjam."'")->row();
				$this->template->load('template','pinjaman/cairkan_dana_v',$data);
			}
			public function cetak_pdf(){
				ini_set('max_execution_time', 300);
				$this->db->select('id_pinjam,tgl_pencairan,jml_pinjam,no_anggota,tarif_angsur,jatuh_tempo,status');
				$this->db->from('pinjaman');
				$this->db->where('status=2 or status = 3');
		        $data['list'] = $this->db->get();
		        $sumber = $this->load->view('pinjaman/pinjaman_pdf', $data, true);
		        $html = $sumber;
		        $pdfFilePath = "DaftarPinjaman---".date('Y-m-d H:i').".pdf";
		        $pdf = $this->m_pdf->load();
		        $pdf->AddPage('P');
		        $pdf->useSubstitutions = false;
		        $pdf->simpleTables = true;
		        //$pdf->WriteHTML($stylesheet, 1);
		        $pdf->WriteHTML($html);
		        
		        $pdf->Output($pdfFilePath, "D");
		        exit();
			}
			public function tambah_pinjaman($no_anggota){
				//hitung udh berapa kali pinjaman
				$this->db->where('no_anggota',$no_anggota);
				$this->db->where('status','2');
				$query = $this->db->get('pinjaman')->result();
				$jml_data = count($query);
				echo $jml_data;
				if ($jml_data >= 3) {
					$this->db->where('no_anggota',$no_anggota);
					$data['anggota'] = $this->db->get('anggota')->row();
					$this->template->load('template','pinjaman/add_pinjaman',$data);
					echo "<script>
						alert('Melebihi batas pinjam. Silahkan lunasi pinjaman terlebih dahulu.');
						document.location.href='".site_url('anggota/')."';
					</script>";
				}else{
					$id_pinjam = $this->model->get_id_pinjam();
					$data['id_pinjam'] = $id_pinjam;
					$this->db->where('no_anggota',$no_anggota);
					$data['anggota'] = $this->db->get('anggota')->row();
					$this->template->load('template','pinjaman/add_pinjaman',$data);
				}
			}
			public function selesai(){
				$id_pinjam = $this->input->post('id_pinjam');
				$no_anggota = $this->input->post('no_anggota');	
				$jml_pinjam = $this->input->post('jml_pinjam');
				$banyak = $this->input->post('banyak');
				$bunga = $this->input->post('bunga');
				$angsur = $this->input->post('angsur');
				$tanggal = date('Y-m-d');
				$data = array(
					'jml_trans' => 0,
					'tgl_trans' => 0
				);
				$this->db->where('id_trans',$id_pinjam);
				$this->db->update('transaksi',$data);
				$data = array(
					'jml_pinjam' => $jml_pinjam,
					'tgl_pengajuan' => $tanggal,
					'banyak_angsuran' => $banyak,
					'tarif_bunga' => $bunga,
					'tarif_angsur' => $angsur,
					'jatuh_tempo' => 0,
					'status' => 0,
					'no_anggota' => $no_anggota
				);
				$this->db->where('id_pinjam',$id_pinjam);
				$this->db->update('pinjaman',$data);
				$this->template->load('template','pinjaman/pinjaman_view');
			}
			public function selesai_cairkan(){
				$id_pinjam = $this->input->post('id_pinjam');
				$total_post = $this->input->post('jml_pinjam');
				$remove_rp = str_replace("Rp.","",$total_post);
				$jml_pinjam = str_replace(".","",$remove_rp);
				$tanggal = date('Y-m-d');
				$jatuh_tempo = $this->input->post('jatuh_tempo');
				$data = array(
					'jml_trans' => $jml_pinjam,
					'tgl_trans' => $tanggal
				);
				$this->db->where('id_trans',$id_pinjam);
				$this->db->update('transaksi',$data);
				$data = array(
					'status' => 2,
					'tgl_pencairan' => $tanggal,
					'jatuh_tempo' => $jatuh_tempo
				);
				$this->db->where('id_pinjam',$id_pinjam);
				$this->db->update('pinjaman',$data);
				//input ke jurnal
				$data = array(
					'no_akun' => 112,
					'posisi_dr_cr' => 'd',
					'nominal' => $jml_pinjam,
					'id_trans' => $id_pinjam
				);
				$this->db->insert('jurnal',$data);
				$data = array(
					'no_akun' => 111,
					'posisi_dr_cr' => 'k',
					'nominal' => $jml_pinjam,
					'id_trans' => $id_pinjam
				);
				$this->db->insert('jurnal',$data);
				redirect('Pinjaman');
			}
			public function test(){
				$list = $this->model->get_datatables();
				echo '<pre>';
				print_r($list);
				echo '</pre>';
			}
	}