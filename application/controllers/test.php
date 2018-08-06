<?php
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
	use Mike42\Escpos\Printer;
	class Test extends CI_CONTROLLER{
		public function index(){
			require APPPATH . 'vendor\autoload.php';
			$connector = new WindowsPrintConnector("Receipt Printer");
			$printer = new Printer($connector);
			$printer -> text("Hello World!\n");
			$printer -> cut();
			$printer -> close();
		}
	}