<?php
header('Access-Control-Allow-Origin: *');
	class Penarikan extends CI_CONTROLLER{
		function __construct(){
			parent::__construct();
			$this->load->model('Penarikan_model','model');
			$this->my_page->set_page('Penarikan Simpanan');
			$check_session = $this->Account_model->check_session();
			if(!$check_session){
				$this->session->set_flashdata('notif', '<div class="alert alert-danger">Silahkan Login terlebih dahulu.</div>');
				redirect('account');
			}
		}
		// laporan pembelian
			public function index(){
				$this->template->load('template','penarikan/penarikan_view');
			}
			public function read_penarikan(){
				$list = $this->model->get_datatables();
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $transaksi) {
					$no++;
					$row = array();
					$row[] = $transaksi->id_penarikan;
					$row[] = $transaksi->tgl_penarikan;
					$row[] = $transaksi->no_anggota;
					$row[] = $transaksi->nama;
					$row[] = format_rp($transaksi->jml_penarikan);
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
			public function tambah_penarikan($no_anggota){
				$id_penarikan = $this->model->get_id_penarikan();
				$data['id_penarikan'] = $id_penarikan;
				$this->db->where('no_anggota',$no_anggota);
				$data['anggota'] = $this->db->get('anggota')->row();
				$this->template->load('template','penarikan/add_penarikan',$data);
			}
			public function tampil_simpanan($no_anggota,$tipe){
				$this->db->where('status=',2);
				$this->db->where('no_anggota',$no_anggota);
				$query = $this->db->get('pinjaman')->result();
				$hitung = count($query);
				//ambil tanggal ambil
				$this->db->where('no_anggota',$no_anggota);
				$this->db->where('tgl_ambil !=','0000-00-0');
				$this->db->where('id_jenis','4');
				$this->db->or_where('id_jenis','5');
				$simp_angg = $this->db->get('simpanan_anggota')->row();
				$jml = count($simp_angg);
				if ($jml >0) {
					$tgl_ambil = $simp_angg->tgl_ambil;
				}else{
					$tgl_ambil = 0;
				};
				$skg = date('Y-m-d');
				if ($tipe == 1 and $hitung < 1) {
					$total = 0;
					$query = $this->db->query("SELECT simpanan_anggota.id_jenis, keterangan, jml_simpanan_dimiliki FROM simpanan_anggota JOIN jenis_simpanan on jenis_simpanan.id_jenis = simpanan_anggota.id_jenis WHERE no_anggota = '".$no_anggota."' and jml_simpanan_dimiliki>0")->result();
					foreach ($query as $data){
						$total = $total+$data->jml_simpanan_dimiliki;
						echo "<tr>
							<td>".$data->keterangan."</td>
							<td>".format_rp($data->jml_simpanan_dimiliki)."</td>
						</tr>";
					}
					echo '<tr>
						<td colspan="1">TOTAL</td>
						<td>'.format_rp($total).'</td>
					</tr> | '.$total.'';
				}else if ($tipe==1 and $hitung > 0) {
					echo "<tr style='background-color:red; color: white;'>
					<td>Tidak bisa keluar keanggotaan, karena masih ada pinjaman belum lunas.</td>
					<td></td>
					</tr> | FALSE" ;
				}elseif ($tipe==2 and $tgl_ambil < $skg) {
					$total = 0;
					$query = $this->db->query("SELECT simpanan_anggota.id_jenis,keterangan, jml_simpanan_dimiliki FROM simpanan_anggota JOIN jenis_simpanan on jenis_simpanan.id_jenis = simpanan_anggota.id_jenis WHERE no_anggota = '".$no_anggota."' and simpanan_anggota.id_jenis = '5' and jml_simpanan_dimiliki>0")->result();
					foreach ($query as $data){
						$total = $total+$data->jml_simpanan_dimiliki;
						echo "<tr>
							<td>".$data->keterangan."</td>
							<td>".format_rp($data->jml_simpanan_dimiliki)."</td>
						</tr>";
					}
					echo '<tr>
						<td colspan="1">TOTAL</td>
						<td>'.format_rp($total).'</td>
					</tr> | '.$total.'';
				}else if ($tipe==2 and $tgl_ambil > $skg ){
					echo "<tr style='background-color:red; color: white;'>
					<td>Tidak bisa menarik simpanan ini karena belum pada tanggalnya.</td>
					<td></td>
					</tr> | FALSE" ;
				}elseif ($tipe==3 and $tgl_ambil < $skg) {
					$total = 0;
					$query = $this->db->query("SELECT simpanan_anggota.id_jenis,keterangan, jml_simpanan_dimiliki FROM simpanan_anggota JOIN jenis_simpanan on jenis_simpanan.id_jenis = simpanan_anggota.id_jenis WHERE no_anggota = '".$no_anggota."' and simpanan_anggota.id_jenis = '4' and jml_simpanan_dimiliki>0")->result();
					foreach ($query as $data){
						$total = $total+$data->jml_simpanan_dimiliki;
						echo "<tr>
							<td>".$data->keterangan."</td>
							<td>".format_rp($data->jml_simpanan_dimiliki)."</td>
						</tr>";
					}
					echo '<tr>
						<td colspan="1">TOTAL</td>
						<td>'.format_rp($total).'</td>
					</tr>| '.$total.'';
				}else if ($tipe==3 and $tgl_ambil > $skg){
					echo "<tr style='background-color:red; color: white;'>
					<td>Tidak bisa menarik simpanan ini karena belum pada tanggalnya.</td>
					<td></td>
					</tr> | FALSE" ;	
				}else{
					$total = 0;
					$query = $this->db->query("SELECT simpanan_anggota.id_jenis,keterangan, jml_simpanan_dimiliki FROM simpanan_anggota JOIN jenis_simpanan on jenis_simpanan.id_jenis = simpanan_anggota.id_jenis WHERE no_anggota = '".$no_anggota."' and simpanan_anggota.id_jenis = '3' and jml_simpanan_dimiliki>0")->result();
					foreach ($query as $data){
						$total = $total+$data->jml_simpanan_dimiliki;
						echo "<tr>
							<td>".$data->keterangan."</td>
							<td>".format_rp($data->jml_simpanan_dimiliki)."</td>
						</tr>";
					}
					echo '<tr>
						<td colspan="1">TOTAL</td>
						<td>'.format_rp($total).'</td>
					</tr>| '.$total.'';
				}
			}
			/*public function selesai(){
				
			}*/
			public function tarik_simpanan($no_anggota,$tipe,$id_penarikan){
				//input ke detail penarikan
				if ($tipe == 1) {
					$query = $this->db->query("SELECT simpanan_anggota.id_jenis, keterangan, jml_simpanan_dimiliki FROM simpanan_anggota JOIN jenis_simpanan on jenis_simpanan.id_jenis = simpanan_anggota.id_jenis WHERE no_anggota = '".$no_anggota."' and jml_simpanan_dimiliki>0")->result();
					$tanggal = date('Y-m-d');
					foreach($query as $data){
						$data2 = array(
							'id_penarikan' => $id_penarikan,
							'id_jenis' => $data->id_jenis,
							'subtotal' => $data->jml_simpanan_dimiliki);
						$this->db->insert('detail_penarikan',$data2);
					}
				}elseif ($tipe == 2) {
					$query = $this->db->query("SELECT simpanan_anggota.id_jenis,keterangan, jml_simpanan_dimiliki FROM simpanan_anggota JOIN jenis_simpanan on jenis_simpanan.id_jenis = simpanan_anggota.id_jenis WHERE no_anggota = '".$no_anggota."' and simpanan_anggota.id_jenis = '5' and jml_simpanan_dimiliki>0")->row();
					$id_jenis = $query->id_jenis;
					$subtotal = $this->input->post('nominal');
					$data = array(
						'id_penarikan' => $id_penarikan,
						'id_jenis' => $id_jenis,
						'subtotal' => $subtotal
					);
					$this->db->insert('detail_penarikan',$data);
				}elseif ($tipe == 3) {
					$query = $this->db->query("SELECT simpanan_anggota.id_jenis,keterangan, jml_simpanan_dimiliki FROM simpanan_anggota JOIN jenis_simpanan on jenis_simpanan.id_jenis = simpanan_anggota.id_jenis WHERE no_anggota = '".$no_anggota."' and simpanan_anggota.id_jenis = '4' and jml_simpanan_dimiliki>0")->row();
					$id_jenis = $query->id_jenis;
					$subtotal = $this->input->post('nominal');
					$data = array(
						'id_penarikan' => $id_penarikan,
						'id_jenis' => $id_jenis,
						'subtotal' => $subtotal
					);
					$this->db->insert('detail_penarikan',$data);
				}else{
					$query = $this->db->query("SELECT simpanan_anggota.id_jenis as id_jenis,keterangan, jml_simpanan_dimiliki FROM simpanan_anggota JOIN jenis_simpanan on jenis_simpanan.id_jenis = simpanan_anggota.id_jenis WHERE no_anggota = '".$no_anggota."' and simpanan_anggota.id_jenis = '3' and jml_simpanan_dimiliki>0")->row();
					$id_jenis = $query->id_jenis;
					$subtotal = $this->input->post('nominal');
					$data = array(
						'id_penarikan' => $id_penarikan,
						'id_jenis' => $id_jenis,
						'subtotal' => $subtotal
					);
					$this->db->insert('detail_penarikan',$data);
				}

				//input ke transaksi
				$total = $this->input->post('nominal');
				if ($tipe == 1) {
					$query = $this->db->query("SELECT sum(subtotal) as total FROM detail_penarikan where id_penarikan = '".$id_penarikan."'")->row();
					$total = $query->total;
				}
				$tanggal = date('Y-m-d');
				$data = array(
					'tgl_trans' => $tanggal,
					'jml_trans' => $total
				);
				$this->db->where('id_trans',$id_penarikan);
				$this->db->update('transaksi',$data);

				//input ke tabel penarikan
				$data = array(
					'jml_penarikan' => $total,
					'tgl_penarikan' => $tanggal,
					'no_anggota' => $no_anggota
				);
				$this->db->where('id_penarikan',$id_penarikan);
				$this->db->update('penarikan',$data);
				
				//ngurangin jml simpanan dimiliki di tabel simpanan anggota
				if ($tipe == 1) {
					$this->db->where('id_penarikan',$id_penarikan);
					$query = $this->db->get('detail_penarikan')->result();
					foreach ($query as $data){
						$this->db->where('id_jenis',$data->id_jenis);
						$this->db->where('no_anggota',$no_anggota);
						$this->db->set('jml_simpanan_dimiliki','(jml_simpanan_dimiliki - '.$data->subtotal.')');
						$this->db->update('simpanan_anggota');
					}
					$this->db->where('no_anggota',$no_anggota);
					$this->db->set('status',4);
					$this->db->update('anggota');
				}else{
					$this->db->where('id_penarikan',$id_penarikan);
					$query = $this->db->get('detail_penarikan')->row();
					$this->db->query("UPDATE `simpanan_anggota` SET jml_simpanan_dimiliki = (jml_simpanan_dimiliki - $query->subtotal) WHERE `id_jenis` = '$query->id_jenis' AND `no_anggota` = '$no_anggota'");
				}

				//input ke jurnal
				if ($tipe == 1) {
					$this->db->where('id_penarikan',$id_penarikan);
					$query = $this->db->get('detail_penarikan')->result();
					foreach ($query as $data) {
						if($data->id_jenis == 1){
							$no_akun = '311';
						}else if($data->id_jenis == 2){
							$no_akun = '312';
						}else if($data->id_jenis == 3){
							$no_akun = '212';
						}else if($data->id_jenis == 4){
							$no_akun = '213';
						}else if($data->id_jenis == 5){
							$no_akun = '214';
						}
						//debit jurnal
						$data_jurnal = array(
							'no_akun' =>  $no_akun,
							'posisi_dr_cr' => 'd',
							'nominal' => $data->subtotal,
							'id_trans' => $id_penarikan);
						$this->db->insert('jurnal',$data_jurnal);
						//debit kredit
						$query1 = $this->db->query("SELECT sum(subtotal) as total FROM detail_penarikan where id_penarikan = '".$id_penarikan."'")->row();
						$data_jurnal = array(
							'no_akun' =>  '111',
							'posisi_dr_cr' =>'k',
							'nominal' => $query1->total,
							'id_trans' => $id_penarikan);
						$this->db->insert('jurnal',$data_jurnal);
					}
				}else{
					$this->db->where('id_penarikan',$id_penarikan);
					$query = $this->db->get('detail_penarikan')->row();
					if($query->id_jenis == 1){
						$no_akun = '311';
					}else if($query->id_jenis == 2){
						$no_akun = '312';
					}else if($query->id_jenis == 3){
						$no_akun = '212';
					}else if($query->id_jenis == 4){
						$no_akun = '213';
					}else if($query->id_jenis == 5){
						$no_akun = '214';
					}
					//debit jurnal
					$data_jurnal = array(
						'no_akun' =>  $no_akun,
						'posisi_dr_cr' => 'd',
						'nominal' => $query->subtotal,
						'id_trans' => $id_penarikan);
					$this->db->insert('jurnal',$data_jurnal);
					//debit kredit
					$data_jurnal = array(
						'no_akun' =>  '111',
						'posisi_dr_cr' =>'k',
						'nominal' => $query->subtotal,
						'id_trans' => $id_penarikan);
					$this->db->insert('jurnal',$data_jurnal);
				}
				redirect('Penarikan');
			}
	}