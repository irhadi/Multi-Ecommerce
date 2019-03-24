<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Cetak extends CI_Controller {
    function __construct()
    {   
        parent::__construct();
        $this->load->library('pdf');
    }
    function receipt($id_konfirmasi)
    {
            $data['konfirmasi'] = $this->M_konfirmasi->get_konfirmasi($id_konfirmasi)->result();
            $data['order']      = $this->M_order->get_order($id_konfirmasi)->result();
            foreach ($data['konfirmasi'] as $k) {
                $data['penjual'] = $this->M_penjual->get_penjual($k->id_penjual)->result();
                $data['pembeli']    = $this->M_pembeli->get_pembeli($k->id_pembeli)->result();
            }
            $this->load->view('pdf', $data);			
    }
}