<?php
class xtcpdf extends TCPDF {}

$this->set('pdf', new TCPDF('P', 'mm', 'A4'));



//pr($languageknow); die;
$pdf = new TCPDF("H", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
$birthdate = date("Y-m-d", strtotime($profile->dob));
$from = new DateTime($birthdate);
$to   = new DateTime('today');
date("d M Y", strtotime($profile->dob));
$from->diff($to)->y;
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();

$img_file =  'https://www.bookanartiste.com/images/pdf_backimg.png';


$typ = array('S' => 'Social', 'C' => 'Company', 'P' => 'Personal', 'B' => 'Blog');

if ($profile->profile_image) {
	$profile_img =  'https://www.bookanartiste.com/profileimages/' . $profile->profile_image;
} else {
	$profile_img =  'images/profile_mimg.jpg';
}

$formattedMonthArray = array(
	"1" => "January",
	"2" => "February",
	"3" => "March",
	"4" => "April",
	"5" => "May",
	"6" => "June",
	"7" => "July",
	"8" => "August",
	"9" => "September",
	"10" => "October",
	"11" => "November",
	"12" => "December",
);
//pr($profile_title); 
//pr($formattedMonthArray[$profile_title->performing_month]); die;

$gen = array('P' => 'Professional', 'A' => 'Amateur', 'PT' => 'Part time', 'H' => 'Hobbyist');
$areyoua = $gen[$profile_title->areyoua];

$subgenres = '';
foreach ($subgenre as $subgen) {
	if (in_array($subgen['id'], $subgenrearray)) {
		$subgenres = $subgenres . ' ' . $subgen['name'] . ',';
	}
}


if ($profile->gender == 'm') {
	$gender = 'Male';
} else if ($profile->gender == 'f') {
	$gender = 'Female';
} elseif ($profile->gender == 'o') {
	$gender = 'Other';
} elseif ($profile->gender == 'bmf') {
	$gender = "Male And Female";
}


$pdf->Image($img_file, 0, 0, '220', '70', '', '', '', false, 100, '', false, false, 0);
$pdf->SetFont('', '', 8, '', 'false');


$knownskills = '';

foreach ($skillofcontaint as $skils) {
	if (!empty($knownskills)) {
		$knownskills = $knownskills . ', ' . $skils->skill->name;
	} else {
		$knownskills = $skils->skill->name;
	}
}


/*
$html = '
<img src="profileimages/'.$images.'" height="50px" width="50px">

';
*/


$html = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PDF</title>
</head>

<body style="background-color:#999; font-family:Arial, Helvetica, sans-serif; font-size:9px;">
<div style="width:595px; height:2700px; background-color:#fff; margin:auto;">
<div style="width:100%; height:211px; background:url(images/pdf_backimg.png) no-repeat center top; background-size:cover;"><br>
<br>


<table width="100%">
<tr>
<td width="10%"></td>
<td width="80%" style="text-align:center;">
<h3 style="text-align:center; color:#fff; font-size:25px; font-weight:bold;">' . $profile->name . ' Profile </h3>

<div><br>
<br>

<img src="' . $profile_img . '" alt="" style="width:120px; display:inline-block; text-align:center; border:5px solid #fff;">
<h4 style="color:#078fe8; font-size:20px; text-align:center; font-weight:bold; margin:0px;">' . $profile->name . '</h4>
<p style="color:#000; font-size:10px; text-align:center;">' . $profile->profiletitle . '</p>
<p style="color:#000; font-size:10px; text-align:center;">' . $profile->current_location . '</p>
</div>
</td>
<td width="10%"></td>
</tr>
</table>
<br>

<table width="100%">
<tr>
<td width="5%"></td>
<td width="90%">
<table width="100%">
<tr>
<td width="16%">
<img src="' . $profile_img . '" alt="image" style="max-width:100%;">
</td>
<td width=".8%"></td>
<td width="16%">
<img src="' . $profile_img . '" alt="image" style="max-width:100%;">
</td>
<td width=".8%"></td>
<td width="16%">
<img src="' . $profile_img . '" alt="image" style="max-width:100%;">
</td>
<td width=".8%"></td>
<td width="16%">
<img src="' . $profile_img . '" alt="image" style="max-width:100%;">
</td>
<td width=".8%"></td>
<td width="16%">
<img src="' . $profile_img . '" alt="image" style="max-width:100%;">
</td>
<td width=".8%"></td>
<td width="16%">
<img src="' . $profile_img . '" alt="image" style="max-width:100%;">
</td>

</tr>
</table>
</td>
<td width="5%"></td>
</tr>
</table>

<br>

<table width="100%">
<tr>
<td width="5%"></td>
<td width="90%" style="background-color:#fafafa;">
<table width="100%">
<tr>
<td width="2%"></td>
<td width="96%">
<table width="100%">
<tr><br>

<td width="100%"><h4 style="color:#078fe8; font-size:20px; text-align:center; font-weight:bold; margin:0px;">Personal Datials</h4></td><br>
</tr>
</table>
<br>
<br>

<table width="100%" style="font-size:10px;">

<tr>
<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $areyoua . ' Since</td>';

if ($formattedMonthArray[$profile_title->performing_month]) {
	$html .= '<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >: ' . $formattedMonthArray[$profile_title->performing_month] . ' ' . $profile_title->performing_year . '</td>';
} else {
	$html .= '<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >: N/A</td>';
}

$html .= '<td width="20%" style="text-align:left; color:#000;  height:35px; line-height:35px;">Ethnicity
</td>';
if ($profile->enthicity->title) {
	$html .= '<td width="20%" style="text-align:left; color:#000; height:35px; line-height:35px;">: ' . $profile->enthicity->title . '
</td>';
} else {
	$html .= '<td width="20%" style="text-align:left; color:#000; height:35px; line-height:35px;">: N/A</td>';
}

$html .= '</tr>';

if (!empty($gender) || !empty($profile->city->name)) {
	$html .= '</tr>
<tr>
<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;">Gender</td>';

	if ($gender) {
		$html .= '<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: ' . $gender . '</td>';
	} else {
		$html .= '<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: N/A</td>';
	}

	$html .= '<td width="20%" style="text-align:left; color:#000;  height:35px; line-height:35px;">City
</td>';

	if ($profile->city->name) {
		$html .= '<td width="20%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: ' . $profile->city->name . '</td>';
	} else {
		$html .= '<td width="20%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: N/A
	</td>';
	}
	$html .= '</tr>';
}


if (!empty($profile->dob) || !empty($profile->skypeid)) {
	$html .= '<tr>
<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;">Date of Birth</td>';
	if (date("d M Y", strtotime($profile->dob)) != "01 Jan 1970") {
		$html .= '<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: ' . date("d M Y", strtotime($profile->dob)) . ' (' . $from->diff($to)->y . ' Year)</td>';
	} else {
		$html .= '<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: N/A</td>';
	}

	$html .= '<td width="20%" style="text-align:left; color:#000;  height:35px; line-height:35px;">Skypeid
</td>';
	if ($profile->skypeid) {
		$html .= '<td width="20%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: ' . trim($profile->skypeid) . '</td>';
	} else {
		$html .= '<td width="20%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: N/A
	</td>';
	}
	$html .= '</tr>';
}


if (!empty($profile->phone) || !empty($profile->altnumber)) {
	$html .= '
<tr>
<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;">Phone</td>';
	if ($profile->phone) {
		$html .= '<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: ' . $profile->phone . '</td>';
	} else {
		$html .= '<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: N/A</td>';
	}



	$html .= '<td width="20%" style="text-align:left; color:#000;  height:35px; line-height:35px;">Mobile
</td>';
	if ($profile->altnumber) {
		$html .= '<td width="20%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: ' . $profile->altnumber . '</td>';
	} else {
		$html .= '<td width="20%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: N/A
	</td>';
	}
	$html .= '</tr>';
}

if ($profile->altemail) {
	$html .= '
<tr>
<td width="30%" style="text-align:left; color:#000;  height:35px; line-height:35px;">Email</td>';
	if ($profile->altemail) {
		$html .= '<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: ' . $profile->altemail . '</td>';
	} else {
		$html .= '<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: N/A</td>';
	}

	$html .= '</tr>';
}

$html .= '
</table>
</td>
<td width="2%"></td>
</tr>
</table>
</td>
<td width="5%"></td>
</tr>
</table>

<br>
<br>
<table width="100%">
<tr>
<td width="5%"></td>
<td width="90%" style="background-color:#fafafa;">
<table width="100%">
<tr>
<td width="2%"></td>
<td width="96%">
<table width="100%">
<tr><br>

<td width="100%"><h4 style="color:#078fe8; font-size:20px; text-align:center; font-weight:bold; margin:0px;">Professional Summary</h4></td><br>
</tr>
</table>';




if (count($currentworking) > 0) {
	// 	$html .= '<tr>
	// 	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">No currently working available
	// 	</td>
	// 	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
	// </td>
	// 	</tr>';
	// }	

	$html .= '<br>
<br>
<table width="100%">
<tr>
<td width="100%">
<h6 style="color:#078fe8; font-size:16px; text-align:left; font-weight:bold; margin:0px;">Currently Working At</h6>
</td>
</tr>
</table>';

	$html .= '<table width="100%" style="font-size:10px;">';

	if ($currentworking['role']) {
		$html .= '<tr>
	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $currentworking['role'] . '
	</td>
	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
</td>
	</tr>';
	}

	if ($currentworking['name']) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $currentworking['name'] . '
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
</td>
</tr>';
	}

	if ($currentworking['location']) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $currentworking['location'] . '
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
</td>
</tr>';
	}

	if ($currentworking['date_from']) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . date("d-M-Y", strtotime($currentworking['date_from'])) . '
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
</td>
</tr>';
	}

	if ($currentworking['description']) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $currentworking['description'] . '
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
</td>
</tr>';
	}
}

if (count($profexp) != 0) {
	$html .= '</table><br>
<table width="100%">
<tr>
<td width="100%" style="border-bottom:1px dashed #000;"></td>
</tr>
</table><br><br>

<table width="100%">
<tr>
<td width="100%">
<h6 style="color:#078fe8; font-size:16px; text-align:left; font-weight:bold; margin:0px;">Earlier Experience</h6>
</td>
</tr>
</table>
<table width="100%" style="font-size:10px;">';

	// if(count($profexp)==0){
	// 	$html .= '<tr>
	// 	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">No Previous Experience available
	// 	</td>
	// 	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
	// </td>
	// 	</tr>';
	// }	


	if ($profexp['role']) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $profexp['role'] . '
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
</td>
</tr>';
	}

	if ($profexp['name']) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $profexp['name'] . '
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
</td>
</tr>';
	}

	if ($profexp['location']) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $profexp['location'] . '
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
</td>
</tr>';
	}

	if ($profexp['to_date']) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . date("M, Y", strtotime($profexp['from_date'])) . ' ' . date("M, Y", strtotime($profexp['to_date'])) . '
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
</td>
</tr>';
	}

	if ($profexp['description']) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $profexp['description'] . '
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
</td>
</tr>';
	}
}



if (!empty($typ[$portFolio->web_type])) {
	$html .= '</table>

<br>
<table width="100%">
<tr>
<td width="100%" style="border-bottom:1px dashed #000;"></td>
</tr>
</table><br><br>

<table width="100%">
<tr>
<td width="100%">
<h6 style="color:#078fe8; font-size:16px; text-align:left; font-weight:bold; margin:0px;">Website PortFolio</h6>
</td>
</tr>
</table>
<table width="100%" style="font-size:10px;">';

	// if(empty($typ[$portFolio->web_type])){
	// 	$html .= '<tr>
	// 	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">No Website PortFolio available
	// 	</td>
	// 	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
	// </td>
	// 	</tr>';
	// }	

	if (!empty($typ[$portFolio->web_type])) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $typ[$portFolio->web_type] . '
</td>
<td width="50%" style="text-align:left; color:#078fe8;  height:35px; line-height:35px;" >: ' . $typ[$portFolio->web_type] . '
</td>
</tr>';
	}
}


if (!empty($portFoliotalent['url'])) {
	$html .= '</table>
<br>
<table width="100%">
<tr>
<td width="100%" style="border-bottom:1px dashed #000;"></td>
</tr>
</table><br><br>

<table width="100%">
<tr>
<td width="100%">
<h6 style="color:#078fe8; font-size:16px; text-align:left; font-weight:bold; margin:0px;">Talent PortFolio</h6>
</td>
</tr>
</table>
<table width="100%" style="font-size:10px;">';

	// if(empty($portFoliotalent['url'])){
	// 	$html .= '<tr>
	// 	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">No Talent PortFolio available
	// 	</td>
	// 	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
	// </td>
	// 	</tr>';
	// }	

	if ($portFoliotalent['url']) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $typ[$portFolio->web_type] . '
</td>
<td width="50%" style="text-align:left; color:#078fe8;  height:35px; line-height:35px;" >: ' . $portFoliotalent['url'] . '
</td>
</tr>';
	}
}


if (!empty($perdes->performance_desc)) {
	$html .= '</table>
</td>
<td width="2%"></td>
</tr>
</table>
</td>
<td width="5%"></td>
</tr>
</table><br>
<br>
<table width="100%">
<tr>
<td width="5%"></td>
<td width="90%" style="background-color:#fafafa;">
<table width="100%">
<tr>
<td width="2%"></td>
<td width="96%">
<table width="100%">
<tr><br>

<td width="100%"><h4 style="color:#078fe8; font-size:20px; text-align:center; font-weight:bold; margin:0px;">Work, Charges Description</h4></td><br>
</tr>
</table>

<br>
<br>

<table width="100%">
<tr>
<td width="100%">
<h6 style="color:#078fe8; font-size:16px; text-align:left; font-weight:bold; margin:0px;">Performance,Work Description</h6>
</td>
</tr>
</table>

<table width="100%" style="font-size:10px;">';

	// if(empty($perdes->performance_desc)){
	// 	$html .= '<tr>
	// 	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">No Performance,Work Description available
	// 	</td>
	// 	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >
	// </td>
	// 	</tr>';
	// }	

	if ($perdes->performance_desc) {
		$html .= '<tr>
<td width="100%" style="text-align:left; color:#000; line-height:25px;" >
<p>' . $perdes->performance_desc . '</p>
</td>
</tr>';
	}
}


if (!empty($perdes->setup_requirement) || !empty($languageknow[0]['language']['name']) || !empty($perdes->infulences) || !empty($gen[0]->Genre->name) || !empty($subgenres)) {
	$html .= '</table><br>
<table width="100%">
<tr>
<td width="100%" style="border-bottom:1px dashed #000;"></td>
</tr>
</table><br><br>

<table width="100%">
<tr>
<td width="100%">
<h6 style="color:#078fe8; font-size:16px; text-align:left; font-weight:bold; margin:0px;">Special Requirements</h6>
</td>
</tr>
</table>
<table width="100%" style="font-size:10px;">';


	// if(empty($perdes->setup_requirement) && empty($languageknow[0]['language']['name']) && empty($perdes->infulences) && empty($gen[0]->Genre->name) && empty($subgenres)){
	// 	$html .= '<tr>
	// 	<td width="100%" colspan="2" style="text-align:left; color:#000; line-height:25px;" >
	// 	<p>No Special requirements available</p>
	// 	</td>
	// 	</tr>';
	// 	}


	if ($perdes->setup_requirement) {
		$html .= '<tr>
<td width="100%" colspan="2" style="text-align:left; color:#000; line-height:25px;" >
<p>' . $perdes->setup_requirement . '</p>
</td>
</tr>';
	}

	if ($languageknow[0]['language']['name']) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">Performance Language(s)
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >: ' . $languageknow[0]['language']['name'] . '
</td>
</tr>';
	}

	if ($perdes->infulences) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">Influenced by
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >: ' . $perdes->infulences . '
</td>
</tr>';
	}

	if ($gen[0]->Genre->name) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">Genre
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >: ' . $gen[0]->Genre->name . '
</td>
</tr>';
	}

	if ($subgenres) {
		$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">SubGenre
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;" >: ' . $subgenres . '
</td>
</tr>';
	}
}


if (count($payfrequency) > 0) {
	$html .= '</table>
<br>
<table width="100%">
<tr>
<td width="100%" style="border-bottom:1px dashed #000;"></td>
</tr>
</table><br><br>

<table width="100%">
<tr>
<td width="100%">
<h6 style="color:#078fe8; font-size:16px; text-align:left; font-weight:bold; margin:0px;">Charges</h6>
</td>
</tr>
</table><br>

<table width="100%" style="font-size:10px;" cellspacing="0">


<tr>
<td width="30%" style="text-align:left; color:#fff; background-color:#078fe8;  height:35px; line-height:35px;">
&nbsp; Charges Type
</td>
<td width="50%" style="text-align:center; color:#fff; background-color:#078fe8;  height:35px; line-height:35px;">
Currency
</td>
<td width="20%" style="text-align:center; color:#fff; background-color:#078fe8;  height:35px; line-height:35px;">
Charges
</td>
</tr>';


	$opentravel = array('Y' => 'Yes', 'N' => 'No');

	if (count($payfrequency) > 0) {
		foreach ($payfrequency as $frequency) { //pr($frequency['paymentfequency']['name']); die;
			$html .= '<tr>
		<td width="30%" style="text-align:left; color:#000; background-color:#f3fafb;  height:35px; line-height:35px; border-left:1px solid #078fe8; border-bottom:1px solid #078fe8;">
		&nbsp; ' . $frequency['paymentfequency']['name'] . '
		</td>
		
		<td width="50%" style="text-align:center; color:#000; background-color:#f3fafb;  height:35px; line-height:35px; border-left:1px solid #078fe8; border-bottom:1px solid #078fe8;">
		' . $frequency['currency']['name'] . '
		</td>
		
		<td width="20%" style="text-align:center; color:#000; background-color:#f3fafb;  height:35px; line-height:35px; border-left:1px solid #078fe8; border-bottom:1px solid #078fe8; border-right:1px solid #078fe8;">
		' . $frequency->amount . '
		</td>
		</tr>';
		}
	} else {
		$html .= '<tr>
	<td width="30%" style="text-align:left; color:#000; background-color:#f3fafb;  height:35px; line-height:35px; border-left:1px solid #078fe8; border-bottom:1px solid #078fe8;">
	&nbsp; No charges available
	</td>
	</tr>';
	}
}



if ($videoprofilepersoneeldet['name']) {
	$html .= '</table>

<br>
<table width="100%">
<tr>
<td width="100%" style="border-bottom:1px dashed #000;"></td>
</tr>
</table><br><br>

<table width="100%">
<tr>
<td width="100%">
<h6 style="color:#078fe8; font-size:16px; text-align:left; font-weight:bold; margin:0px;">Personnel Details</h6>
</td>
</tr>
</table>
<table width="100%" style="font-size:10px;">';

	if ($videoprofilepersoneeldet['name']) {
		$html .= '<tr>
<td width="100%" style="text-align:left; color:#000;   line-height:25px;"><p>' . $videoprofilepersoneeldet['name'] . '</p>
</td>
</tr>';
	} else {
		$html .= '<tr>
	<td width="100%" style="text-align:left; color:#000;   line-height:25px;"><p>No personnel details available</p>
	</td>
	</tr>';
	}
}

$html .= '</table>
<table width="100%">
<tr>
<td width="100%" style="border-bottom:1px dashed #000;"></td>
</tr>
</table><br><br>

<table width="100%">
<tr>
<td width="100%">
<h6 style="color:#078fe8; font-size:16px; text-align:left; font-weight:bold; margin:0px;">Open To Travel</h6>
</td>
</tr>
</table><br>

<table width="100%" style="font-size:10px;" >';


$html .= '<tr>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">Open To Travel
</td>
<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: ' . $opentravel[$perdes->opentotravel] . '
</td>
</tr>';

if (count($uservitals) > 0) {
	$html .= '</table>
</td>
<td width="2%"></td>
</tr>
</table>
</td>
<td width="5%"></td>
</tr>
</table>

<br>
<br>

<table width="100%">
<tr>
<td width="5%"></td>
<td width="90%" style="background-color:#fafafa;"><br>
<br>
<table width="100%">
<tbody><tr>

<td width="100%"><h4 style="color:#078fe8; font-size:20px; text-align:center; font-weight:bold; margin:0px;">Vital Statistics Parameter</h4></td>


</tr>


</tbody></table><br>
<br>

<table width="100%">
<tr>
<td width="2%"></td>
<td width="96%">
<table width="100%">
<tbody><tr>
<td width="100%">
<h6 style="color:#078fe8; font-size:16px; text-align:left; font-weight:bold; margin:0px;">Vital Statistics</h6>
</td>
</tr>
</tbody></table><br>

<table width="100%" style="font-size:10px;" >';


	if (count($uservitals) > 0) {
		foreach ($uservitals as $vitalss) { //pr($vitalss); die;
			if (!empty($vitalss['voption']['value']) || !empty($vitalss['value'])) {
				$html .= '<tr>
	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">' . $vitalss['vque']['question'] . '
	</td>
	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">: ' . $vitalss['voption']['value'] . '
	</td>
	</tr>';
			}
		}
	} else {
		$html .= '<tr>
	<td width="50%" style="text-align:left; color:#000;  height:35px; line-height:35px;">No details available
	</td>
	</tr>';
	}
}



$html .= '</table>
</td>
<td width="2%"></td>
</tr>
</table>
</td>
<td width="5%"></td>
</tr>
</table>
</div>
</div>
</body>
</html>';





//echo $html; die; 
$pdf->WriteHTML($html, '', 0, 'L', true, 0, false, false, 0);

ob_end_clean();
echo $pdf->Output('Result');
//exit;
