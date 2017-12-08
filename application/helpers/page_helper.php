<?php
	public $page_name;
	function set_page($page){
		$this->page_name = $page;
	}
	function read_page(){
		return $this->page_name;
	}