<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    
    $config = array(
	    'charset' 	=> 'utf-8',
	    'useragent' => 'MultiEcommerce',
	    'protocol'	=> "smtp",
	    'mailtype'	=> "html",
	    'smtp_host'	=> "ssl://smtp.gmail.com",//pengaturan smtp
	    'smtp_port'	=> "465",
	    'smtp_timeout'=> "10",
	    'smtp_user'	=> "ipmmaut@gmail.com", // isi dengan email kamu
	    'smtp_pass'	=> "MultiEcommerce183", // isi dengan password kamu
	    'crlf'		=>"\r\n", 
	    'newline'	=>"\r\n",
	    'wordwrap'	=> TRUE	
    );