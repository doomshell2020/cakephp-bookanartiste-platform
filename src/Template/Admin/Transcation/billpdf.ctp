<?php
class xtcpdf extends TCPDF {}


//$subject=$this->Comman->findexamsubjectsresult($students['id'],$students['section']['id'],$students['acedmicyear']);

$this->set('pdf', new TCPDF('1', 'mm', 'A4'));
$pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();
$pdf->setHeaderMargin(0);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetAutoPageBreak(TRUE, 0);
//$pdf->SetMargins(5, 0, 5, true);

//$pdf->SetFont('', '', 6, '', 'true');
//TCPDF_FONTS::addTTFfont('../Devanagari/Devanagari.ttf', 'TrueTypeUnicode', "", 32);

//$studetails=$this->Comman->findstudetails($sid);
//pr($transcation['id']); die;
if ($transcation['description'] == 'PAR') {
  $packtype = "Post a Requirement";
  $unit = "01 Units";
} elseif ($transcation['description'] == 'PP') {
  $packtype = "Profile Package";
  $unit = "01 Units";
} elseif ($transcation['description'] == 'RP') {
  $packtype = "Recruiter Package";
  $unit = "01 Units";
} elseif ($transcation['description'] == 'PG') {
  $packtype = "Ping";
  $unit = "01 Units";
} elseif ($transcation['description'] == 'PQ') {
  $packtype = "Paid Quote Sent";
  $unit = "01 Units";
} elseif ($transcation['description'] == 'AQ') {
  $packtype = "Ask for Quote";
  $unit = "01 Units";
} elseif ($transcation['description'] == 'PA') {
  $packtype = "Profile Advertisement";
  $unit = $transcation['number_of_days'] . "/days";
} elseif ($transcation['description'] == 'JA') {
  $packtype = "Job Advertisement";
  $unit = $transcation['number_of_days'] . "/days";
} elseif ($transcation['description'] == 'BNR') {
  $packtype = "Banner";
  $unit = $transcation['number_of_days'] . "/days";
} elseif ($transcation['description'] == 'FJ') {
  $packtype = "Feature Job";
  $unit = $transcation['number_of_days'] . "/days";
} elseif ($transcation['description'] == 'FP') {
  $packtype = "Feature Profile";
  $unit = $transcation['number_of_days'] . "/days";
} else {
  $packtype = "N/A";
}
//$transcation['id']
$crdate = date("d-M-Y", strtotime($transcation['created']));
if ($billtype == 1) {
  $invnum = "INV-" . $transcation['description'] . "-" . $crdate . "-" . $transcation['id'];
  $billname = "INVOICE";
} elseif ($billtype == 2) {
  $invnum = "REC-" . $transcation['description'] . "-" . $crdate . "-" . $transcation['id'];
  $billname = "RECEIPT";
} else {
  $invnum = "INV-" . $transcation['description'] . "-" . $crdate . "-" . $transcation['id'];
  $billname = "INVOICE";
}

if ($transcation['GST'] > 0) {
  $gst = $transcation['GST'];
} else {
  $gst = 0;
}
if ($transcation['SGST'] > 0) {
  $sgst = $transcation['SGST'];
} else {
  $sgst = 0;
}
if ($transcation['CGST'] > 0) {
  $cgst = $transcation['CGST'];
} else {
  $cgst = 0;
}
if ($transcation['status'] == 'Y') {
  $status = "Paid";
} else {
  $status = "Payment Declined and Not Received";
}
$site_url = SITE_URL;
$html .= '
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';
$html .= '
<body style=" text-align:center; font-family:Arial, Helvetica, sans-serif">
<table cellspacing="0" style="border:solid #b2b2b2 1px; text-align:center" width="auto" align="center">
<tr style=" background-color:#252525;">
<td style="text-align:center; padding:50px 0px 50px 0px;">
<img src="' . $site_url . '/images/book-an-artiste-logo.png" alt="book-an-artiste-logo"/>
</td>
</tr>

<tr >
<td style="text-align:center; padding:15px 10px 15px 0px; border-bottom:solid #b2b2b2 1px">
<h2 style=" padding:0px; margin:0px; font-weight:600">' . $billname . '</h2>
</td>
</tr>


<tr>
<td style="border-bottom:solid #b2b2b2 1px">
<table>
<tr style="width:100%;">
<td style=" text-align:left; padding:20px 0px 20px 20px; width:300px;">
<h4 style=" margin:0px; padding-bottom:8px;">To ' . $transcation['user']['user_name'] . '</h4>
<a>www.bookanartiste.com</a>
<h4 style=" margin:0px; padding:8px 0px;">Address:</h4>
<p style="margin:0px; color: #666;">
' . $transcation['user']['profile']['location'] . '
 </p>
</td>

<td style=" text-align:left; padding:20px 0px 20px 0px; margin:0px; width:300px; vertical-align:top;">
<p style=" font-weight:600; margin:0px;">Invoice number: ' . $invnum . '</p>
<p style="  font-weight:600;">Payment Status: ' . $status . '</p>
<p style="  font-weight:600;">Transaction Id: ' . $transcation['transcation_id'] . '</p>
<p style=" font-weight:600;">Date: ' . $crdate . '</p>
</td>
</tr>
</table>
</td>
</tr>

<tr style="">
<td style="margin:0px; padding:0px; ">
<table style=" border-spacing:0px; width:100%;">
<tr style="border-bottom:1px solid #b2b2b2 ;">

<td style="border-right:1px solid #b2b2b2; width:8%; padding:4px 4px 0px 10px; border-bottom:1px solid #b2b2b2; text-align:center;">No.</td>
<td style="border-right:1px solid #b2b2b2; width:37%; padding:8px 0px 8px 8px ; border-bottom:1px solid #b2b2b2; text-align:left;">Product Type</td>
<td style="border-right:1px solid #b2b2b2; width:20%; padding:8px 0px; border-bottom:1px solid #b2b2b2;">Per Unit Amount</td>
<td style="border-right:1px solid #b2b2b2; width:15%; padding:8px 0px; border-bottom:1px solid #b2b2b2;">Quantity </td>
<td style="border-right:0px solid #b2b2b2; width:20%; padding:8px 0px; border-bottom:1px solid #b2b2b2;" >Total Amount</td>

</tr>
<tr style="border-bottom:1px solid #b2b2b2; height:60px">

<td style="border-right:1px solid #b2b2b2; width:8%; padding:4px 4px 0px 10px; border-bottom:1px solid #b2b2b2; text-align:center;">1</td>
<td style="border-right:1px solid #b2b2b2; width:37%; padding:8px 0px 8px 8px ; border-bottom:1px solid #b2b2b2; text-align:left;">' . $packtype . '</td>
<td style="border-right:1px solid #b2b2b2; width:20%; padding:8px 0px; border-bottom:1px solid #b2b2b2;">' . $transcation['before_tax_amt'] . '</td>
<td style="border-right:1px solid #b2b2b2; width:15%; padding:8px 0px; border-bottom:1px solid #b2b2b2;">' . $unit . ' </td>
<td style="border-right:0px solid #b2b2b2; width:20%; padding:8px 0px; border-bottom:1px solid #b2b2b2;" >$' . $transcation['before_tax_amt'] . '</td>

</tr>



</table>
</td>
</tr>


<tr>
<td>
<table style="width:100%; text-align:right">
<tr style="text-align:right; width:100%;">
<td style=" font-weight:600; padding:20px 160px 15px 0px ;">Tax: ' . $gst . '% </td>
</tr>
<tr style="text-align:right; width:100%;">
<td style=" font-weight:600; padding:0px 160px 15px 0px ;">SGST: ' . $sgst . '%</td>
</tr>
<tr style="text-align:right; width:100%;">
<td style=" font-weight:600; padding:0px 160px 0px 0px ;">CGST: ' . $cgst . '%</td>
</tr>
<tr style="text-align:right; width:100%; ">
<td style=" font-weight:600; padding:15px 10px 0px 0px ; "><span style=" padding:10px 15px;">Total Bill Amount: $' . $transcation['amount'] . '</span></td>
</tr>
<tr style="text-align:right; width:100%; ">
<td style=" font-weight:600; padding:20px 0px; "></td>
</tr>

 

</table>
</td>
</tr>






</table>
</body>';

//$pdf->writeHTMLCell(0, 0, '', '', utf8_encode($html), 0, 1, 0, true, '', true);
$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output($invnum . '.pdf');
exit;
?>



<!-- PDF $transcation invoice -->
<!-- <td style="border-right:1px solid #b2b2b2; width:20%; padding:8px 0px; border-bottom:1px solid #b2b2b2;">'.$transcation['before_tax_amt']/$transcation['number_of_days'].'</td> -->