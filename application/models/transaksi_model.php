<?php
	class transaksi_model extends CI_MODEL{
		public $id_penjualan;
		public $no_anggota;
		public $total;
		public $total_bayar;
		var $table = 'nota_penjualan';
		var $column_order = array('id_penjualan','tgl_trans','jml_trans','nama_anggota',null); 
		var $column_search = array('id_penjualan'); 
		var $order = array('id_penjualan' => 'asc'); 

		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		private function _get_datatables_query(){
			$this->db->select('id_penjualan,tgl_trans,jml_trans,anggota.nama');
			$this->db->from($this->table);
			$this->db->join('anggota','anggota.no_anggota = nota_penjualan.no_anggota');
			$i = 0;
			foreach ($this->column_search as $item) // loop column 
			{
				if($_POST['search']['value']) // if datatable send POST for search
				{
					
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, $_POST['search']['value']);
					}
					else
					{
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if(count($this->column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
			
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		function get_datatables(){
			$this->_get_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
		public function count_filtered(){
			$this->_get_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
		public function count_all(){
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}
		public function save($data){
			$this->db->insert('detail_penjualan', $data);
			return $this->db->insert_id();
		}
		public function get_no_penjualan(){
			$this->db->where('status','0');
			$query = $this->db->get('nota_penjualan')->row();
			$jumlah_transaksi = count($query);
			if ($jumlah_transaksi < 1){
				//get nomor transaksi terakhir
					$query = $this->db->query("SELECT max(substring(id_penjualan,5)*1) as notrans from nota_penjualan")->row();
					$transaksi = $query->notrans+1;
					$nomor_trans = "PNJ-".$transaksi;
				//insert nomor transaksi
					$data = array(
						'id_trans' => $nomor_trans,
						'jml_trans'=> 0);
					$this->db->insert('transaksi',$data);
				//insert ke pembelian
					$data = array(
						'id_penjualan' => $nomor_trans,
						'status' => 0);
					$this->db->insert('nota_penjualan',$data);
					return $nomor_trans;
			}else{
					return $query->id_penjualan;
			}
		}
		public function get_detail_penjualan($no_trans){
			return $this->db->query("SELECT id_penjualan,detail_penjualan.id_barang,barang.nama_barang,barang.harga_jual,jumlah,subtotal FROM detail_penjualan
				join barang on
				detail_penjualan.id_barang = barang.id_barang
				where id_penjualan = '$no_trans'");
		}
		public function get_detail_barang($id_barang){
			$this->db->where('id_barang',$id_barang);
			$query=$this->db->get('barang');
			return $query->row();
		}
		public function get_id_angsuran(){
			$query = $this->db->query("SELECT max(substring(id_angsurpenj,5)*1) as id_angsuranpenj from angsuran_penj")->row();
			$angsuran = $query->id_angsuranpenj+1;
			$id_angsuran = "APJ-".$angsuran;
			return $id_angsuran;
		}
		public function simpan_transaksi(){
			$total_transaksi = $this->total*1;
			$jumlah_bayar = $this->total_bayar*1;
			//update table transaksi
				$data = array(
					'tgl_trans' => date('Y-m-d'),
					'jml_trans' => $this->total);
				$this->db->where('id_trans',$this->id_penjualan);
				$this->db->update('transaksi',$data);
			//update nota penjualan
				$data = array(
					'tgl_trans' => date('Y-m-d'),
					'jml_trans' => $this->total,
					'no_anggota' => $this->no_anggota,
					'status' => '1');
				$this->db->where('id_penjualan',$this->id_penjualan);
				$this->db->update('nota_penjualan',$data);
			//insert angsuran id angsuran ke table transaksi
				$id_angsuran = $this->get_id_angsuran();
				$data = array(
					'id_trans' => $id_angsuran,
					'tgl_trans' => date('Y-m-d'),
					'jml_trans' => $this->total_bayar);
				$this->db->insert('transaksi',$data);
			//insert ke table angsuran penj
				$data = array(
					'id_angsurpenj' => $id_angsuran,
					'tgl_trans' => date('Y-m-d'),
					'jml_trans' => $this->total_bayar,
					'id_penjualan' => $this->id_penjualan);
				$this->db->insert('angsuran_penj',$data);
			if($jumlah_bayar < $total_transaksi){
				$data = array(
					'no_akun' => '120',
					'posisi_dr_cr' => 'd',
					'nominal' => $total_transaksi-$this->total_bayar,
					'id_trans' => $this->id_penjualan);
				$this->db->insert('jurnal',$data);
				$data = array(
					'no_akun' => '111',
					'posisi_dr_cr' => 'd',
					'nominal' => $this->total_bayar,
					'id_trans' => $this->id_penjualan);
				$this->db->insert('jurnal',$data);
				$data = array(
					'no_akun' => '401',
					'posisi_dr_cr' => 'k',
					'nominal' => $total_transaksi,
					'id_trans' => $this->id_penjualan);
				$this->db->insert('jurnal',$data);
			}else{
				$data = array(
					'no_akun' => '111',
					'posisi_dr_cr' => 'd',
					'nominal' => $total_transaksi,
					'id_trans' => $this->id_penjualan);
				$this->db->insert('jurnal',$data);
				$data = array(
					'no_akun' => '401',
					'posisi_dr_cr' => 'k',
					'nominal' => $total_transaksi,
					'id_trans' => $this->id_penjualan);
				$this->db->insert('jurnal',$data);
			}
		}
	}