<?php 
App::import('Vendor','tcpdf');
//debug($orders);
$tcpdf = new TCPDF();
$textfont = 'helvetica';
 
$tcpdf->SetAuthor("Julia Holland");
$tcpdf->SetAutoPageBreak(true);
 
$tcpdf->setPrintHeader(false);
$tcpdf->setPrintFooter(false);
 
$tcpdf->SetTextColor(0, 0, 0);
$tcpdf->SetFont($textfont,'',9);
 
$tcpdf->AddPage();

// create some HTML content
$table = "
<table>
<tr>
	<th>id</th>
	<th>recipient</th>
	<th>date</th>
</tr>
<tr>
	<td>TEST CELL</td><td>TEST CELL1</td><td>TEST CELL2</td>
</tr>
<tr>
	<td>TEST CELL</td><td>TEST CELL1</td><td>TEST CELL2</td>
</tr>

</table>";
$tcpdf->writeHTML($table);
/*
foreach ($orders as $order){
    $tcpdf->writeHTML("<tr>".$order['Order']['id'], true, 0, true, 0);
    $tcpdf->writeHTML("<td>Order: ".$order['Order']['id']."</td>", true, 0, true, 0);
    $tcpdf->writeHTML("</tr>", true, 0, true, 0);
}
*/

 
// output the HTML content

$tcpdf->Output('filename.pdf', 'I');
?>


