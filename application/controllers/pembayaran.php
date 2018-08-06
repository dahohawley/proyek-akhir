<?php
	class Pembayaran extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('pembayaran_model','model');
			$this->my_page->set_page('Pembayaran Beban');
			$check_session = $this->Account_model->check_session();
			if(!$check_session){
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
				redirect('account');
			}
		}
		// laporan pembelian
			public function index(){
				//$data['bayar'] = $this->model->get_id_bayar();
				$this->template->load('template','pembayaran/pembayaran_view');
			}
			public function read_pembayaran(){
				$list = $this->model->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $transaksi) {
					$no++;
					$row = array();
					$row[] = $transaksi->id_bayar;
					$row[] = $transaksi->no_bukti;
					$row[] = $transaksi->tgl_bayar;
					$row[] = $transaksi->nama_akun;
					$row[] = format_rp($transaksi->jml_bayar);
					$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Ubah" onclick="edit_person('."'".$transaksi->id_bayar."'".')"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$transaksi->id_bayar."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';
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
				$this->db->select('id_bayar,no_bukti,tgl_bayar,jml_bayar,nama_akun');
				$this->db->from('pembayaran');
				$this->db->join('coa','pembayaran.no_akun=coa.no_akun');
		        $data['list'] = $this->db->get();
		        $sumber = $this->load->view('pembayaran/pemb_beban_pdf', $data, true);
		        $html = $sumber;
		        $pdfFilePath = "DaftarPembBeban---".date('Y-m-d H:i').".pdf";
		        $pdf = $this->m_pdf->load();
		        $pdf->AddPage('P');
		        $pdf->useSubstitutions = false;
		        $pdf->simpleTables = true;
		        //$pdf->WriteHTML($stylesheet, 1);
		        $pdf->WriteHTML($html);
		        
		        $pdf->Output($pdfFilePath, "D");
		        exit();
			}
		//Tambah pembelian
			public function TambahBayar(){
				$id_bayar = $this->model->get_id_bayar();
				$data['id_bayar'] = $id_bayar;
				$data['akun'] = $this->model->get_coa();
				$this->template->load('template','pembayaran/add_pembayaran_v',$data);
			}
			public function selesai(){
				$id_bayar = $this->input->post('id_bayar');
				$no_akun = $this->input->post('no_akun');
				$tgl_bayar = $this->input->post('tgl_bayar');
				$no_bukti = $this->input->post('no_bukti');
				$total_post = $this->input->post('total');
				$remove_rp = str_replace('Rp.','',$total_post);
				$total_bayar = str_replace('.', '', $remove_rp);
				$tanggal = date('Y-m-d');
				//update table transaksi
					$data = array(
						'tgl_trans' => $tgl_bayar,
						'jml_trans' => $total_bayar);
					$this->db->where('id_trans',$id_bayar);
					$this->db->update('transaksi',$data);
				//update table pembelian
					$data = array(
						'no_akun' => $no_akun,
						'tgl_bayar' => $tgl_bayar,
						'jml_bayar' => $total_bayar,
						'no_bukti' => $no_bukti);
					$this->db->where('id_bayar',$id_bayar);
					$this->db->update('pembayaran',$data);
				//input ke jurnal
				$this->db->where('no_akun',$no_akun);
				$query = $this->db->get('coa')->row();
				$nomor_akun = $query->no_akun;
				//debet
				$data = array(
					'no_akun' => $nomor_akun,
					'posisi_dr_cr' => 'd',
					'nominal' => $total_bayar,
					'id_trans' => $id_bayar
				);
				$this->db->insert('jurnal',$data);
				//kredit
				$data = array(
					'no_akun' => '111',
					'posisi_dr_cr' => 'k',
					'nominal' => $total_bayar,
					'id_trans' => $id_bayar
				);
				$this->db->insert('jurnal',$data);
				redirect('pembayaran');
			}
	}