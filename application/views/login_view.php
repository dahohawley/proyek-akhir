<!DOCTYPE html>
<html >
<head>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <meta charset="UTF-8">
  <title>KPRI Rukun Makmur</title>
  <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
  
  
      <style>
      /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
      @import url(http://fonts.googleapis.com/css?family=Exo:100,200,400);
	@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);

	body{
		margin: 0;
		padding: 0;
		background: #fff;

		color: #fff;
		font-family: Arial;
		font-size: 12px;
	}

	.body{
		position: absolute;
		top: -20px;
		left: -20px;
		right: -40px;
		bottom: -40px;
		width: auto;
		height: auto;
		background-image: url(<?php echo base_url()?>assets/gambar/login-bg.jpg);
		background-size: cover;
		-webkit-filter: blur(5px);
		z-index: 0;
	}

	.grad{
		position: absolute;
		top: -20px;
		left: -20px;
		right: -40px;
		bottom: -40px;
		width: auto;
		height: auto;
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.65))); /* Chrome,Safari4+ */
		z-index: 1;
		opacity: 0.7;
	}

	.header{
		position: absolute;
		top: calc(50% - 35px);
		left: calc(40% - 255px);
		z-index: 2;
	}

	.header div{
		float: left;
		color: #fff;
		font-family: 'Exo', sans-serif;
		font-size: 35px;
		font-weight: 300;
	}

	.header div span{
		color: #F7CA18 !important;
	}

	.login{
		position: absolute;
		top: calc(50% - 75px);
		left: calc(50% - 50px);
		height: 150px;
		width: 350px;
		padding: 10px;
		z-index: 2;
		color: red;
	}
	.notification{
		position: absolute;
		top: calc(50% - 220px);
		left: calc(50% - 50px);
		height: 150px;
		width: 270px;
		padding: 10px;
		z-index: 2;
	}

	.login input[type=text]{
		width: 250px;
		height: 40px;
		background: transparent;
		border: 1px solid rgba(255,255,255,0.6);
		border-radius: 2px;
		color: #fff;
		font-family: 'Exo', sans-serif;
		font-size: 16px;
		font-weight: 400;
		padding: 4px;
	}

	.login input[type=password]{
		width: 250px;
		height: 40px;
		background: transparent;
		border: 1px solid rgba(255,255,255,0.6);
		border-radius: 2px;
		color: #fff;
		font-family: 'Exo', sans-serif;
		font-size: 16px;
		font-weight: 400;
		padding: 4px;
		margin-top: 10px;
	}

	.login input[type=submit]{
		width: 250px;
		height: 35px;
		background: #fff;
		border: 1px solid #fff;
		cursor: pointer;
		border-radius: 2px;
		color: #a18d6c;
		font-family: 'Exo', sans-serif;
		font-size: 16px;
		font-weight: 400;
		padding: 6px;
		margin-top: 10px;
	}

	.login input[type=submit]:hover{
		opacity: 0.8;
	}

	.login input[type=submit]:active{
		opacity: 0.6;
	}

	.login input[type=text]:focus{
		outline: none;
		border: 1px solid rgba(255,255,255,0.9);
	}

	.login input[type=password]:focus{
		outline: none;
		border: 1px solid rgba(255,255,255,0.9);
	}

	.login input[type=submit]:focus{
		outline: none;
	}

	::-webkit-input-placeholder{
	   color: rgba(255,255,255,0.6);
	}

	::-moz-input-placeholder{
	   color: rgba(255,255,255,0.6);
	}
	    </style>

	  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>
<body>
  <div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<div>KPRI <span>Rukun Makmur</span></div>
		</div>
		<br>
		<div class="notification">
			<?php echo validation_errors();?>
			<?php echo $this->session->flashdata('notif');?>
			<?php echo $notification?>
		</div>
		<form action="<?php echo base_url()?>index.php/account/login" method="POST">
		<div class="login">
				<input type="text" placeholder="username" name="username"><br>
				<input type="password" placeholder="password" name="password"><br>
				<input type="submit" value="Login">
		</div>
		</form>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  
</body>
</html>
