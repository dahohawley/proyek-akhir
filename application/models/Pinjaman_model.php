<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjaman_model extends CI_Model {

	var $table = 'pinjaman';
	var $column_order = array('id_pinjam','jml_pinjam','tgl_pengajuan','banyak_angsuran','tarif_bunga','tarif_angsur','jatuh_tempo','status','no_anggota',null); 
	var $column_search = array('id_pinjam','pinjaman.no_anggota','tgl_pengajuan','nama'); 
	var $order = array('status' => 'asc','id_pinjam' => 'asc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query(){
		$this->db->where('pinjaman.status !=',3);
		$this->db->select('id_pinjam,jml_pinjam,tgl_pengajuan,banyak_angsuran,tarif_bunga,tarif_angsur,jatuh_tempo,pinjaman.status,pinjaman.no_anggota,anggota.nama');
		$this->db->from($this->table);
		$this->db->join('anggota', 'anggota.no_anggota = pinjaman.no_anggota');
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
	private function _get_datatables_query_ketua(){
		$this->db->where('pinjaman.status !=',3);
		$this->db->select('id_pinjam,jml_pinjam,tgl_pengajuan,banyak_angsuran,tarif_bunga,tarif_angsur,jatuh_tempo,pinjaman.status,pinjaman.no_anggota,anggota.nama');
		$this->db->from($this->table);
		$this->db->join('anggota', 'anggota.no_anggota = pinjaman.no_anggota');
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
	private function _get_datatables_query_daftar(){
		$this->db->or_where('pinjaman.status',2);
		$this->db->or_where('pinjaman.status',3);
		$this->db->select('pinjaman.id_pinjam,pinjaman.jml_pinjam,pinjaman.tgl_pengajuan,pinjaman.banyak_angsuran,pinjaman.tarif_bunga,pinjaman.tarif_angsur,pinjaman.jatuh_tempo,pinjaman.status,pinjaman.no_anggota,anggota.nama,tgl_pencairan,sisa_pinjaman');
		$this->db->from($this->table);
		$this->db->join('anggota', 'anggota.no_anggota = pinjaman.no_anggota');
		$this->db->join('angsuran_pinj','angsuran_pinj.id_pinjam=pinjaman.id_pinjam','left');
		$this->db->group_by('pinjaman.id_pinjam');
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
	function get_datatables_daftar(){
		$this->_get_datatables_query_daftar();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	function get_datatables_ketua(){
		$this->_get_datatables_query_ketua();
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
	public function get_id_pinjam(){
		/*$this->db->where('status','0');
		$query = $this->db->get('simpanan')->row();
		$jumlah_transaksi = count($query);
		if ($jumlah_transaksi < 1){*/
			//get nomor transaksi terakhir
				$query = $this->db->query("SELECT max(substring(id_trans,5)*1) as notrans from transaksi")->row();
				$transaksi = $query->notrans+1;
				$nomor_trans = "PIN-".$transaksi;
			//insert nomor transaksi
				$data = array(
					'id_trans' => $nomor_trans,
					'jml_trans'=> 0);
				$this->db->insert('transaksi',$data);
			//insert ke pembelian
				$data = array(
					'id_pinjam' => $nomor_trans
					);
				$this->db->insert('pinjaman',$data);
				return $nomor_trans;
		/*}else{
				return $query->id_pinjam;
		}*/
	}
	public function get_anggota(){
		$this->db->where('status !=',4);
		return $this->db->get('anggota')->result();
	}
	public function save($data){
		$this->db->insert('detail_simpanan', $data);
		return $this->db->insert_id();
	}
	public function get_jatuh_tempo($id_pinjam){
		$query = $this->db->query("SELECT * from pinjaman where id_pinjam = '".$id_pinjam."'")->row();
		$banyak = $query->banyak_angsuran;
		$tanggal = date('Y-m-d'); 
		return $this->db->query('SELECT ADDDATE("'.$tanggal.'",interval '.$banyak.' month) as jatuh_tempo')->row();
	}
	public function get_data_pinjaman($id_pinjam){
		$this->db->where('id_pinjam',$id_pinjam);
		$this->db->select('id_pinjam,jml_pinjam,tgl_pengajuan,banyak_angsuran,tarif_bunga,tarif_angsur,jatuh_tempo,pinjaman.status,pinjaman.no_anggota,anggota.nama');
		$this->db->from($this->table);
		$this->db->join('anggota', 'anggota.no_anggota = pinjaman.no_anggota');
		return $this->db->get()->result();
	}
}
