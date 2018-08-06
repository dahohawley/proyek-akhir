<span class="heading">Main</span>
<ul class="list-unstyled">
    <li>
        <a href="<?php echo base_url('index.php/home')?>"><i class="fa fa-home"></i>Beranda</a>
    </li>
    <li><a href="#transaksi" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-exchange"></i></i>Transaksi</a>
        <ul id="transaksi" class="collapse list-unstyled">
            <li><a href="<?php echo base_url('index.php/Pembelian/')?>">Pembelian</a></li>
            <li><a href="<?php echo base_url('index.php/Transaksi')?>">Penjualan</a></li>
        </ul>
    </li>
    <li><a href="#keuangan" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-money"></i></i>Keuangan</a>
        <ul id="keuangan" class="collapse list-unstyled">
            <li><a href="<?php echo base_url('index.php/keuangan/piutang')?>">Piutang</a></li>
            <li><a href="<?php echo base_url('index.php/keuangan/utang')?>">Utang</a></li>
        </ul>
    </li>
    <li><a href="#laporan" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-list"></i></i>Laporan</a>
        <ul id="laporan" class="collapse list-unstyled">
            <li><a href="<?php echo base_url('index.php/laporan')?>">Jurnal Umum</a></li>
            <li><a href="<?php echo base_url('index.php/laporan/buku_besar/')?>">Buku Besar</a></li>
            <li><a href="<?php echo base_url('index.php/laporan/neraca_saldo/')?>">Neraca Saldo</a></li>
            <li><a href="<?php echo base_url('index.php/laporan/arus_kas/')?>">Arus Kas</a></li>
            <li><a href="<?php echo base_url('index.php/laporan/profit_penjualan/')?>">Keuntungan Penjualan</a></li>
        </ul>
    </li>
</ul><span class="heading">Data</span>
<ul>
    <li><a href="#masterdata" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-database"></i></i>Master data</a>
        <ul id="masterdata" class="collapse list-unstyled">
            <li><a href="<?php echo base_url('index.php/supplier/')?>">Pemasok</a></li>
            <li><a href="<?php echo base_url('index.php/gudang/')?>">Barang</a></li>
        </ul>
    </li>
</ul>