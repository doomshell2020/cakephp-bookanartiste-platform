<?php
// App::import('Vendor', 'TCPDF/tcpdf');
// OR Composer
// require_once ROOT . DS . 'vendor' . DS . 'autoload.php';

use TCPDF;

/* ===============================
   PDF INIT
================================ */
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle($profile->name . ' Profile');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 12);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 9);

/* ===============================
   BASIC DATA (FROM ENTITY)
================================ */
$profileImg = !empty($profile->profile_image)
    ? SITE_URL . '/profileimages/' . $profile->profile_image
    : SITE_URL . '/images/profile_mimg.jpg';

$genderMap = [
    'm' => 'Male',
    'f' => 'Female',
    'o' => 'Other',
    'bmf' => 'Male & Female'
];

$gender = $genderMap[$profile->gender] ?? 'N/A';

$dob = (!empty($profile->dob))
    ? $profile->dob->format('d M Y')
    : 'N/A';

/* ===============================
   PROFILE CARD (UI DESIGN)
================================ */
$html = '
<table width="100%" cellpadding="8">
<tr>

    <!-- LEFT IMAGE -->
    <td width="32%" align="center" valign="top" style="border:1px solid #ddd;">
        <img src="'.$profileImg.'" width="130" height="160"><br><br>
        <b>Contacts</b>
    </td>

    <!-- RIGHT DETAILS -->
    <td width="68%" valign="top">
        <table width="100%" cellpadding="5">

            <tr>
                <td colspan="3">
                    <span style="font-size:18px; color:#1a73e8;">
                        <b>'.$profile->name.'</b>
                    </span>
                </td>
            </tr>

            <tr>
                <td width="45%"><b>Professional Since</b></td>
                <td width="5%">:</td>
                <td width="50%">
                    '.$profile->created->format('M Y').'
                </td>
            </tr>

            <tr>
                <td><b>Skills</b></td>
                <td>:</td>
                <td>'.$profile->profiletitle.'</td>
            </tr>

            <tr>
                <td><b>Date Of Birth</b></td>
                <td>:</td>
                <td>'.$dob.'</td>
            </tr>

            <tr>
                <td><b>Gender</b></td>
                <td>:</td>
                <td>'.$gender.'</td>
            </tr>

            <tr>
                <td><b>Ethnicity</b></td>
                <td>:</td>
                <td>'.($profile->enthicity->title ?? 'N/A').'</td>
            </tr>

            <tr>
                <td><b>Address Location</b></td>
                <td>:</td>
                <td>
                    '.($profile->country->name ?? '').',
                    '.($profile->state->name ?? '').'
                </td>
            </tr>

        </table>
    </td>

</tr>
</table>
<hr>';

$pdf->writeHTML($html);

/* ===============================
   PROFESSIONAL SUMMARY
================================ */
if (!empty($currentworking)) {
    $pdf->writeHTML('<h3 style="color:#1a73e8;">Professional Summary</h3>');

    $pdf->writeHTML('
        <b>'.$currentworking['role'].'</b><br>
        '.$currentworking['name'].'<br>
        '.$currentworking['location'].'<br>
        <i>'.date('M Y', strtotime($currentworking['date_from'])).'</i>
        <br><br>
        '.$currentworking['description']
    );
}

/* ===============================
   OUTPUT
================================ */
ob_end_clean();
$pdf->Output($profile->name.'_Profile.pdf', 'I');
exit;
