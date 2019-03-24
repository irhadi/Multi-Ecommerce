<?php
foreach($konfirmasi as $k):
  $id = $k->id_konfirmasi;
  $status = $k->status;
  $gambar = $k->ft_struk_transfer;
  $no_resi = $k->nomor_resi;
  $tgl = $k->tggl;
  $id_penjual = $k->id_penjual;
  $kurir = $k->kurir;
  $layanan = $k->layanan;
  $ongkir = $k->ongkir;
  $unik = $k->kode_unik;
  $total_pesanan = $k->total_pesanan;

  $pisah_datetime = (explode(" ",$tgl));
endforeach;

$icon = '';
if($kurir === 'tiki')
{
    $icon = 'tiki.png';
}
else if($kurir === 'jne')
{
    $icon = 'jne.png';
}               
else if($kurir === 'pos')
{
    $icon = 'pos.png';
}


$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Receipt'.'#'.$id.'/'.$pisah_datetime[0]);

$pdf->SetAuthor('Irhadiirianto.store');

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetSubject('RECEIPT');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'RECEIPT'.' #'.$id.'/'.$pisah_datetime[0],'Irhadiirianto.store', array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// $html = <<<EOD
// <h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
// <i>This is the first example of TCPDF library.</i>
// <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
// EOD;






        $html = '';
        $html .='<table cellspacing="1" cellpadding="2">
                    <tr>
                        <td><h4>PEMBELI</h4></td>
                    </tr>
                    <tr>
                        <td>';
        foreach($pembeli as $a):
                $html .= '<b>Nama : </b>'.$a->nama.'<br><b>Nomor Telepon : </b>'.$a->notelp.'<br><b>Alamat : </b>'.$a->alamat.'
                            ';
        endforeach;

        $html .='       </td>
                    </tr>
                </table>
                <br><br><br>';        

        $html .='<table cellspacing="1" cellpadding="2">
                    <tr>
                        <td><h4>PENJUAL</h4></td>
                    </tr>
                    <tr>
                        <td>';
                  
        foreach($penjual as $dp):
            $html .= '<b>Nama Toko : </b>'.$dp->nama_toko.'<br><b>Nama Penjual : </b>'.$dp->nama_penjual.'<br><b>Nomor Telepon : </b>'.$dp->notelp.'<br><b>Alamat : </b>'.$dp->alamat;
        endforeach;
        $html .='       </td>
                    </tr>
                </table>
                <br><br><br>';


        $html .='<table cellspacing="1" cellpadding="2">
                    <tr>
                        <td><h4>FOTO BUKTI PEMBAYARAN</h4></td>
                        <td><h4>LAYANAN PENGIRIMAN</h4></td>
                    </tr>    
                    <tr>
                        <td><img src="'.base_url().'assets/foto/struk/'.$gambar.'" width="150"></td>
                        <td><b>Kurir : </b><img src="'.base_url('/assets/img/icon/'.$icon).'" height="15"><br><b>Layanan : </b> '.$layanan.'<br><b>Ongkos Kirim : </b> '.$ongkir.'<br><b>Nomor Resi : </b> '.$no_resi.'
                        </td>
                    </tr>
                </table><br>';
        
        $html .='<h4>ORDER</h4>
                <table border="1" cellspacing="1" cellpadding="2">
                    <thead>
                        <tr align="center">
                            <th width="5%">No</th>
                            <th width="50%">Nama Produk</th>
                            <th width="15%">Qty</th>
                            <th width="30%">Harga</th>
                        </tr>
                    </thead>
                    <tbody>';
        $no= 1;
        foreach($order as $o):
        $html .='       <tr>
                            <td width="5%" align="center">'.$no++.'</td>
                            <td width="50%">'.$o->nama_produk.'</td>
                            <td width="15%" align="center">'.$o->jumlah_produk.'</td>
                            <td width="30%" align="right">Rp'.number_format($o->total_harga,0,",",".").'</td>
                        </tr>';
        endforeach;
        $html .='   </tbody>
                </table><br><br>';


        $html.='
                <table>
                    <tr>
                        <td width="50%"></td>
                        <td width="20%">Sub Total Harga</td>
                        <td width="5%" align="center">:</td>
                        <td width="25%" align="right">Rp '.number_format($total_pesanan,2,",",".").'</td>
                    </tr>
                    <tr>
                        <td width="50%"></td>
                        <td width="20%">Kode Transaksi</td>
                        <td width="5%" align="center">:</td>
                        <td width="25%" align="right">'.number_format($unik).'</td>
                    </tr>
                    <tr>
                        <td width="50%"></td>                        
                        <td width="20%">Ongkos Kirim</td>
                        <td width="5%" align="center">:</td>
                        <td width="25%" align="right">Rp '.number_format($ongkir,2,",",".").'</td>
                    </tr>
                    <tr style="font-weight:bold;">
                        <td width="50%"></td>
                        <td width="20%">Total Tagihan</td>
                        <td width="5%" align="center">:</td>
                        <td width="25%" align="right">Rp '.number_format($total_pesanan+$unik+$ongkir,2,",",".").'</td>
                    </tr>                
                </table>
        ';
$txt = <<<EOD
TCPDF Example 003
Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
EOD;

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $pdf->Output('receipt.pdf', 'I');
?>


