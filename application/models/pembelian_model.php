<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian_model extends CI_Model {

	var $table = 'pembelian';
	var $column_order = array('id_pembelian','tgl_trans','jml_trans','id_supplier',null); 
	var $column_search = array('id_pembelian'); 
	var $order = array('id_pembelian' => 'asc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query(){
		$this->db->select('id_pembelian,tgl_trans,jml_trans,supplier.nama_supplier as nama_supplier');
		$this->db->from($this->table);
		$this->db->join('supplier', 'pembelian.id_supplier = supplier.id_supplier');
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
	public function get_id_pembelian(){
		$this->db->where('status','0');
		$query = $this->db->get('pembelian')->row();
		$jumlah_transaksi = count($query);
		if ($jumlah_transaksi < 1){
			//get nomor transaksi terakhir
				$query = $this->db->query("SELECT max(substring(id_trans,5)*1) as notrans from transaksi")->row();
				$transaksi = $query->notrans+1;
				$nomor_trans = "PMB-".$transaksi;
			//insert nomor transaksi
				$data = array(
					'id_trans' => $nomor_trans,
					'jml_trans'=> 0);
				$this->db->insert('transaksi',$data);
			//insert ke pembelian
				$data = array(
					'id_pembelian' => $nomor_trans,
					'status' => 0);
				$this->db->insert('pembelian',$data);
				return $nomor_trans;
		}else{
				return $query->id_pembelian;
		}
	}
	public function get_detail_pembelian($id_pembelian){
		$this->db->where('id_pembelian',$id_pembelian);
		$this->db->select('id_pembelian,detail_pembelian.id_barang,barang.nama_barang as nama_barang,jumlah,subtotal');
		$this->db->join('barang','detail_pembelian.id_barang=barang.id_barang');
		$this->db->from('detail_pembelian');
		return $this->db->get()->result();
	}
	public function get_harga_barang($id_barang){
		$this->db->where('id_barang');
		$data = $this->db->get('barang')->row();
		return $data->harga_jual;
	}
	public function save($data){
		$this->db->insert('detail_pembelian', $data);
		return $this->db->insert_id();
	}
	public function get_supplier(){
		return $this->db->get('supplier')->result();
	}
	public function get_id_angsuran(){
		//get nomor transaksi terakhir
			$query = $this->db->query("SELECT max(substring(id_angsuran_pmb,5)*1) as id_angsuran from angsuran_pmb")->row();
			$angsuran = $query->id_angsuran+1;
			$id_angsuran = "ANG-".$angsuran;
			return $id_angsuran;
	}
	public function get_by_id($id_pembelian,$id_barang){
		$this->db->from('detail_pembelian');
		$this->db->where('detail_pembelian.id_barang',$id_barang);
		$this->db->where('id_pembelian',$id_pembelian);
		$this->db->join('barang','barang.id_barang = detail_pembelian.id_barang');
		$query = $this->db->get();
		return $query->row();
	}
}
