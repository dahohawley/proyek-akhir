<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?php echo $this->my_page->read_page()?></title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url()?>assets/paperDash/assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="<?php echo base_url()?>assets/paperDash/assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="<?php echo base_url()?>assets/paperDash/assets/css/paper-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url()?>assets/paperDash/assets/css/demo.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url()?>assets/paperDash/assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="<?php echo base_url('index.php/home')?>" class="simple-text">
                    KPRI Rukun Makmur
                </a>
            </div>

            <ul class="nav">
                <?php
                    if ($this->my_page->read_page() == 'Home'){
                        echo '<li class="active">';        
                    }else{
                        echo '<li>';
                    }
                ?>
                    <a href="<?php echo base_url('index.php/home')?>">
                        <i class="ti-panel"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <?php
                    if ($this->my_page->read_page() == 'Gudang'){
                        echo '<li class="active">';        
                    }else{
                        echo '<li>';
                    }
                ?>
                    <a href="<?php echo base_url('index.php/gudang')?>">
                        <i class="ti-package"></i>
                        <p>Gudang</p>
                    </a>
                </li>
               <?php
                    if ($this->my_page->read_page() == 'Transaksi'){
                        echo '<li class="active">';        
                    }else{
                        echo '<li>';
                    }
                ?>
                    <a href="<?php echo base_url('index.php/Transaksi')?>">
                        <i class="ti-view-list-alt"></i>
                        <p>Transaksi Penjualan</p>
                    </a>
                </li>
                 <?php
                    if ($this->my_page->read_page() == 'Supplier'){
                        echo '<li class="active">';        
                    }else{
                        echo '<li>';
                    }
                ?>
                    <a href="<?php echo base_url('index.php/Supplier')?>">
                        <i class="ti-user"></i>
                        <p>Supplier</p>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="icons.html">
                        <i class="ti-pencil-alt2"></i>
                        <p>Icons</p>
                    </a>
                </li>
                <li>
                    <a href="maps.html">
                        <i class="ti-map"></i>
                        <p>Maps</p>
                    </a>
                </li>
                <li>
                    <a href="notifications.html">
                        <i class="ti-bell"></i>
                        <p>Notifications</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#"><?php echo $this->my_page->read_page()?></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
						<li>
                            <a href="#">
								<i class="ti-power-off"></i>
								<p>Logout</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">