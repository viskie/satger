<?
		require_once('dompdf/dompdf_config.inc.php');
		$dompdf = new DOMPDF();
		
		//$html=$_REQUEST['html'];
		$dompdf->load_html_file($html);
		
		$dompdf->set_paper("a4", "portrait");
		$dompdf->render();

		//$file_name=$_REQUEST['file_name'];
		$dompdf->stream($file_name, array("Attachment" => false));

?>