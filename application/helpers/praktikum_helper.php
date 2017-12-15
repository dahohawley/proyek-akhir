<?php

//fungsi untuk format rrupiah

function format_rp($a){
	if(!is_numeric($a)) return NULL;
	$jumlah_desimal ="0";
	$pemisah_desimal = ",";
	$pemisah_ribuan = ".";
	$angka = "Rp.". number_format($a, $jumlah_desimal, $pemisah_desimal, $pemisah_ribuan);
	return $angka;
}
function format_rp_table($a){
	if(!is_numeric($a)) return NULL;
	$jumlah_desimal ="0";
	$pemisah_desimal = ",";
	$pemisah_ribuan = ".";
	$angka = number_format($a, $jumlah_desimal, $pemisah_desimal, $pemisah_ribuan);
	$table = "
	<td>Rp.</td>
	<td style='text-align:right;'>".$angka."</td>";
	return $table;
}
?>