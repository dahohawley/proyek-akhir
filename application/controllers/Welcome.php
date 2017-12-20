<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index()
	{
		redirect('account');
	}
	public function test(){
		$this->load->library('Escpos');
		try {
		// Enter the device file for your USB printer here
			  $connector = new Escpos\PrintConnectors\FilePrintConnector("/dev/usb/lp0");
				/* Print a "Hello world" receipt" */
				$printer = new Escpos\Printer($connector);
				$printer -> text("Hello World!\n");
				$printer -> cut();

				/* Close printer */
				$printer -> close();
		} catch (Exception $e) {
			echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
		}
	}
}
