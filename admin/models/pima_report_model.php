<?php 

class pima_report_model extends MY_Model{

	function pima_report($year,$duration_from,$duration_to) //function to put sql data in table
	{
		$pdf_data=array();
		$i=1;

		$pdf_data['table']="<table border='0' align='center' width='880' class='data-table'>";
		$pdf_data['table'].="<tr>";
		$pdf_data['table'].="<th>#</th>";
		$pdf_data['table'].="<th style='width:50%;'><center>PIMA Device</center></th>";
		$pdf_data['table'].="<th style='width:50%;'><center>Facility</center></th>";
		$pdf_data['table'].="</tr>";

		$pdf_results=$this->pima_summary_report($year,$duration_from,$duration_to);

		if(!$pdf_results=="")
		{
			foreach($pdf_results as $value)
			{
				$pdf_data['table'].='<tr>';
				$pdf_data['table'].='<td>'.$i.'</td>';
				$pdf_data['table'].='<td style="width:50%;"><center>'.$value['serial_num'].'</center></td>';
				$pdf_data['table'].='<td style="width:50%;"><center>'.$value['facility'].'</center></td>';
				$pdf_data['table'].="</tr>";

				$i++;
			}
			
		}else
		{
			$pdf_data['table'].='<tr>';
			$pdf_data['table'].='<td>---</td>';
			$pdf_data['table'].='<td><center>---</center></td>';
			$pdf_data['table'].='<td><center>---</center></td>';
			$pdf_data['table'].="</tr>";
		}

		$pdf_data['table'].="</table>";

		return $pdf_data;
	}
	function pima_summary_report($year,$duration_from,$duration_to)//sql function to get data
	{
		$sql="SELECT DISTINCT(serial_num),facility FROM v_pima_tests_only
					WHERE date_test BETWEEN '".$duration_from."' AND '".$duration_to."' ORDER BY facility ASC ";

		$pima_summary=R::getAll($sql);

		return $pima_summary;
	}

}
?>