<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class datasimpanan_model extends CI_Model {

	var $table = 'simpanan_anggota';
	var $column_order = array('no_anggota','id_jenis','tarif','jml_simpanan_dimiliki',null); 
	var $column_search = array('simpanan_anggota.no_anggota','nama','jenis_simpanan.keterangan'); 
	var $order = array('no_anggota' => 'asc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query(){
		$this->db->select('simpanan_anggota.id_jenis,simpanan_anggota.no_anggota,anggota.nama,jenis_simpanan.keterangan,simpanan_anggota.tarif,jml_simpanan_dimiliki,tgl_ambil');
		$this->db->from($this->table);
		$this->db->join('anggota', 'simpanan_anggota.no_anggota=anggota.no_anggota');
		$this->db->join('jenis_simpanan','jenis_simpanan.id_jenis=simpanan_anggota.id_jenis');
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
	function count_filtered(){
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function count_all(){
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($no_anggota,$id_jenis){
		$this->db->from($this->table);
		$this->db->where('no_anggota',$no_anggota);
		$this->db->where('id_jenis',$id_jenis);
		$query = $this->db->get();
		return $query->row();
	}

	public function save($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data){
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($no_anggota,$id_jenis){
		$this->db->where('no_anggota', $no_anggota);
		$this->db->where('id_jenis', $id_jenis);
		$this->db->delete($this->table);
	}

	public function get_anggota(){
		$this->db->where('status !=',4);
		return $this->db->get('anggota')->result();
	}

	public function get_jenis(){
		$this->db->where('kategori','2');
		$this->db->select('id_jenis, keterangan, kategori, tarif');
		$this->db->from('jenis_simpanan');
		return $this->db->get()->result();
	}

	public function get_simpanan_angg($no_anggota){
		//check udah bayar pokok atau belum
		return $this->db->query("SELECT *
FROM jenis_simpanan
WHERE id_jenis NOT IN
    (SELECT id_jenis 
     FROM simpanan_anggota WHERE no_anggota = '$no_anggota')
     ")->result();
	}
}
