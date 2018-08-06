<?php
	class Keuangan extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('keuangan_model','model');
			$this->load->model('piutang_model','piutang');
			$this->my_page->set_page('Keuangan');
			$check_session = $this->Account_model->check_session();
			if(!$check_session){
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
				redirect('account');
			}
		}
		//piutang
			public function piutang(){
				$this->template->load('template','keuangan/piutang_v');
			}
			public function get_piutang(){
				$list = $this->piutang->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $angsuran) {
					$no++;
					$row = array();
					$row[] = $angsuran->id_penjualan;
					$row[] = $angsuran->tgl_trans;
					$row[] = format_rp($angsuran->jumlah_angsuran);
					$row[] = format_rp($angsuran->jml_trans);
					$row[] = $angsuran->nama;
					$row[] = '<a class="btn btn-sm btn-primary" href="'.base_url('index.php/keuangan/bayarkan_piutang/').$angsuran->id_penjualan.'" title="Edit"> Bayarkan</a>';
					$row[] = '<button class="btn btn-primary btn-sm" onclick="showModal('."'$angsuran->id_penjualan'".')">Lihat detail</button>';
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
			public function bayarkan_piutang($id_penjualan){
				if(isset($_POST['jumlah_bayar'])){
					$id_penjualan = $this->input->post('id_penjualan');
					$sisa_piutang = $this->input->post('sisa_piutang');
					$jumlah_bayar = $this->input->post('jumlah_bayar');
					$id_angsuran_penj = $this->piutang->get_id_angsuran();
					$data= array(
						'id_trans' => $id_angsuran_penj,
						'tgl_trans' => date('Y-m-d'),
						'jml_trans' => $jumlah_bayar);
					$this->db->insert('transaksi',$data);
					$data = array(
						'id_angsurpenj' => $id_angsuran_penj,
						'tgl_trans' => date('Y-m-d'),
						'jml_trans' => $jumlah_bayar,
						'id_penjualan' => $id_penjualan);
					$this->db->insert('angsuran_penj',$data);
					$this->keuangan_model->insert_jurnal('111','d',$jumlah_bayar,$id_angsuran_penj);
					$this->keuangan_model->insert_jurnal('113','k',$jumlah_bayar,$id_angsuran_penj);
					redirect('keuangan/piutang');
				}else{
					$data['id_penjualan'] = $id_penjualan;
					$data['detail'] = $this->piutang->get_detail($id_penjualan);
					$this->template->load('template','keuangan/bayar_piutang',$data);
				}
			}
			public function cetak_pdf_piutang(){
				ini_set('max_execution_time', 300);
		        $data['piutang'] = $this->db->query("SELECT `id_angsurpenj`, `a`.`tgl_trans`, `a`.`id_penjualan`, sum(a.jml_trans) as jumlah_angsuran, `b`.`jml_trans`, `c`.`nama` FROM `angsuran_penj` `a` JOIN `nota_penjualan` `b` ON `a`.`id_penjualan` = `b`.`id_penjualan` JOIN `anggota` `c` ON `b`.`no_anggota` = `c`.`no_anggota` GROUP BY `a`.`id_penjualan` HAVING `jumlah_angsuran` < `jml_trans` ORDER BY `id_angsurpenj`")->result();
		        $sumber = $this->load->view('keuangan/piutang_pdf', $data, true);
		        $html = $sumber;
		        $pdfFilePath = "TagihanPiutang".date('Y-m-d H:i').".pdf";
		        $pdf = $this->m_pdf->load();
		        $pdf->AddPage('P');
		        $pdf->useSubstitutions = false;
		        $pdf->simpleTables = true;
		        //$pdf->WriteHTML($stylesheet, 1);
		        $pdf->WriteHTML($html);
		        
		        $pdf->Output($pdfFilePath, "D");
		        exit();
			}
		//utang
			public function utang(){
				$this->template->load('template','keuangan/utang_v');
			}
			public function get_utang(){
				$list = $this->model->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $angsuran) {
					$no++;
					$row = array();
					$row[] = $angsuran->id_pembelian;
					$row[] = $angsuran->tanggal;
					$row[] = format_rp($angsuran->jumlah_angsuran);
					$row[] = format_rp($angsuran->jml_trans);
					$row[] = $angsuran->nama_supplier;
					$row[] = '<a class="btn btn-sm btn-primary" href="'.base_url('index.php/keuangan/bayarkan_utang/').$angsuran->id_pembelian.'" title="Edit"> Bayarkan</a>';
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
			public function bayarkan_utang($id_pembelian){
				if(isset($_POST['jumlah_bayar'])){
					$id_pembelian = $this->input->post('id_pembelian');
					$sisa_piutang = $this->input->post('sisa_piutang');
					$jumlah_bayar = $this->input->post('jumlah_bayar');
					$id_angsuran_pmb = $this->model->get_id_angsuran();
					$data= array(
						'id_trans' => $id_angsuran_pmb,
						'tgl_trans' => date('Y-m-d'),
						'jml_trans' => $jumlah_bayar);
					$this->db->insert('transaksi',$data);
					$data = array(
						'id_angsuran_pmb' => $id_angsuran_pmb,
						'tanggal' => date('Y-m-d'),
						'jumlah_angsuran' => $jumlah_bayar,
						'id_pembelian' => $id_pembelian);
					$this->db->insert('angsuran_pmb',$data);
					$this->keuangan_model->insert_jurnal('211','d',$jumlah_bayar,$id_angsuran_pmb);
					$this->keuangan_model->insert_jurnal('111','k',$jumlah_bayar,$id_angsuran_pmb);
					redirect('keuangan/utang');
				}else{
					$data['id_pembelian'] = $id_pembelian;
					$data['detail'] = $this->model->get_detail($id_pembelian);
					$this->template->load('template','keuangan/bayar_angsuran',$data);
				}
			}
			public function cetak_pdf_utang(){
				ini_set('max_execution_time', 300);
		        $data['utang'] = $this->db->query("SELECT `angsuran_pmb`.`id_pembelian`, `tanggal`, `jml_trans`, sum(jumlah_angsuran) as jumlah_angsuran, `pembelian`.`id_supplier`, `supplier`.`nama_supplier` FROM `angsuran_pmb` JOIN `pembelian` ON `pembelian`.`id_pembelian` = `angsuran_pmb`.`id_pembelian` JOIN `supplier` ON `pembelian`.`id_supplier` = `supplier`.`id_supplier` GROUP BY `angsuran_pmb`.`id_pembelian` HAVING `jumlah_angsuran` < `jml_trans` ORDER BY `id_pembelian` ASC ")->result();
		        $sumber = $this->load->view('keuangan/utang_pdf', $data, true);
		        $html = $sumber;
		        $pdfFilePath = "TagihanPiutang".date('Y-m-d H:i').".pdf";
		        $pdf = $this->m_pdf->load();
		        $pdf->AddPage('P');
		        $pdf->useSubstitutions = false;
		        $pdf->simpleTables = true;
		        //$pdf->WriteHTML($stylesheet, 1);
		        $pdf->WriteHTML($html);
		        
		        $pdf->Output($pdfFilePath, "D");
		        exit();
			}
		//misc
			public function detail_piutang($id_penjualan){
				$this->db->where('id_penjualan',$id_penjualan);
				$data = $this->db->get('angsuran_penj')->result();
				foreach($data as $data){
					echo "<tr>
							<td>".$data->id_angsurpenj."</td>
							<td>".$data->tgl_trans."</td>
							<td>".format_rp($data->jml_trans)."</td>
						</tr>";
				}
			}
		//jurnal

	}