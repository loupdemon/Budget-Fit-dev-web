<?php

session_start();
error_reporting(E_ALL & ~E_NOTICE);

$html = "<table style='border: none; margin-bottom: 30px; width: 100%;'>
			<tr>
				<td style='width: 110px; font-family: sans-serif;'>
					<img src='http://davejudd.com/client/budget/images/logo.png' style='float: left; vertical-align: middle; width: 110px; height: auto;' />
				</td>
				<td style='padding-left: 30px;'>
					<p style='font-size: 40px; font-family: sans-serif;'>Budget Fit</p>
				</td>
			</tr>
			<tr>
				<td style='border-bottom: 1px solid #bbb; height: 15px;' colspan='2'>
				</td>
			</tr>
		</table>";
		
$html .= "<table style='border: none; margin-bottom: 40px; font-family: sans-serif; font-size: 22px;'>
			<tr>
				<td>
					Project:
				</td>
				<td style='padding-left: 20px;'>
					" . stripslashes($_POST['project-name']) . "
				</td>
			</tr>
		</table>";

$html .= "<table cellpadding='8px' style='border-collapse: collapse; font-family: sans-serif;'>
			<tr>
				<td style='font-size: 16px;'>
					Task Name
				</td>
				<td style='font-size: 16px;'>
					Rate
				</td>
				<td style='font-size: 16px;'>
					Hours
				</td>
			</tr>
			<tr>
				<td>";

$counter = 1;
$dollarSign = "";

foreach ($_POST as $key => $value) {
	
	if ($counter === 2) {
		$dollarSign = "$";
	} else {
		$dollarSign = "";
	}
	
	if (substr( $key, 0, 4 ) === "task") {
		$html .= $dollarSign . stripslashes($value);
		if ($counter === 3) {
			$html .= "</td></tr><tr><td>";
			$counter = 1;
		} else {
			$html .= "</td><td>";
			$counter++;
		}
	}
	
}

if ($counter != 3) {
	$html .= "</td></tr>";
}
$html .= "</table>";

$html .= "<p style='margin-left: 40px; font-size: 22px; font-family: sans-serif;'>Total Cost: $" . $_POST['hidden-total'] . "</p>";

$html .= "<p style='margin-top: 40px; font-family: sans-serif; text-align: center;'>Thank you for using Budget Fit! <a href='http://www.budgetfit.net/'>www.budgetfit.net</a></p>";

$html .= "<p style='margin-top: 40px; font-family: sans-serif; font-size: 12px; text-align: center;'>Budget Fit is designed to be a tool for internal estimation of a web development project. The costs calculated are only meant to be a guideline and starting point. The results are not intended to be used for an official proposal. The creator of Budget Fit assumes zero liability for the results generated by this tool.</p>";

//==============================================================
//==============================================================
//==============================================================

include("PDF/mpdf.php");
$mpdf=new mPDF('c'); 

$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

//==============================================================
//==============================================================
//==============================================================


?>