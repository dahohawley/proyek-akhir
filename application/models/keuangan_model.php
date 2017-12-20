<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan_model extends CI_Model {

	var $table = 'angsuran_pmb';
	var $column_order = array('tanggal,jumlah_angsuran as telah_dibayar, jml_trans,angsuran_pmb.id_pembelian',null); 
	var $column_search = array('id_pembelian'); 
	var $order = array('id_pembelian' => 'asc'); 

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	private function _get_datatables_query(){
		$this->db->select('angsuran_pmb.id_pembelian,tanggal,jml_trans,sum(jumlah_angsuran) as jumlah_angsuran,pembelian.id_supplier,supplier.nama_supplier');
		$this->db->join('pembelian','pembelian.id_pembelian = angsuran_pmb.id_pembelian');
		$this->db->join('supplier','pembelian.id_supplier = supplier.id_supplier');
		$this->db->having('jumlah_angsuran < jml_trans');
		$this->db->group_by('angsuran_pmb.id_pembelian');
		$this->db->from($this->table);
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
	public function get_detail($id_pembelian){
		$this->db->select('sum(jumlah_angsuran) as jumlah_angsuran,jml_trans');
		$this->db->where('angsuran_pmb.id_pembelian',$id_pembelian);
		$this->db->join('pembelian','pembelian.id_pembelian = angsuran_pmb.id_pembelian');
		return $this->db->get('angsuran_pmb')->row();
	}
	public function get_id_angsuran(){
		$query = $this->db->query("SELECT max(substring(id_trans,5)*1) as notrans from transaksi")->row();
		$transaksi = $query->notrans+1;
		return $nomor_trans = "ANG-".$transaksi;
	}
	public function insert_jurnal($no_akun,$posisi,$nominal,$id_trans){
		$data = array(
			'no_akun' => $no_akun,
			'posisi_dr_cr' => $posisi,
			'nominal' => $nominal,
			'id_trans' => $id_trans);
		$this->db->insert('jurnal',$data);
	}
	
}
