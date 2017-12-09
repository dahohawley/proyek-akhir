<?php
	class Model_home extends CI_MODEL{
		public function get_chart_penjualan(){
			$tahun = date('Y');
			$data = array();
			for($i=1;$i<=12;$i++){
				$query = $this->db->query('SELECT sum(jml_trans) as jml_trans from nota_penjualan where month(tgl_trans) ='.$i.' and year(tgl_trans) = "'.$tahun.'"')->row();
				if($query->jml_trans == null){
					$data[$i] = 0;
				}else{
					$data[$i] = $query->jml_trans;
				}
			}
			return $data;
		}
		public function get_chart_pembelian(){
			$tahun = date('Y');
			$data = array();
			for($i=1;$i<=12;$i++){
				$query = $this->db->query('SELECT sum(jml_trans) as jml_trans from pembelian where month(tgl_trans) ='.$i.' and year(tgl_trans) = "'.$tahun.'"')->row();
				if($query->jml_trans == null){
					$data[$i] = 0;
				}else{
					$data[$i] = $query->jml_trans;
				}
			}
			return $data;
		}
		public function barang_habis(){
			$this->db->where('stok < ','10');
			$this->db->limit('7');
			return $this->db->get('barang')->result();
		}
	}