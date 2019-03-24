<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$autoload['packages'] = array();


$autoload['libraries'] = array('database','session','upload','cart','form_validation');


$autoload['drivers'] = array();


$autoload['helper'] = array('form','url');


$autoload['config'] = array();


$autoload['language'] = array();


$autoload['model'] = array(
		'M_transaksi',
		'M_pembeli',
		'M_penjual',
		'M_order',
		'M_laporkan',
		'M_produk',
		'M_admin',		
		'M_rekening'		
	);
