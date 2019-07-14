<?php

include_once './connection.php';
$ro=$_POST['ro'];
$id = $_POST['id'];
$flag = false;
		$sth = $dbh->prepare("SELECT * FROM printer"); 
		 $sth->execute();
		 $retorno = $sth->fetchAll();
		 $printer = 0;


		 while($flag==false){
		 	 if (file_exists('C:\Bitnami\wampstack-7.1.18-0\apache2\htdocs\BrandellDiesel_prod\PDF\request_'.$ro.'_'.$id.'.pdf')){
		 		$flag = true;
		 	}
		 	if ($flag==true){
		 		 $client = new SoapClient('http://localhost:8090/printpdf.asmx?wsdl');
				 foreach ($retorno as $key) {
		 			$printer = $key['printer'];
		 			$client->printpdf(array('path'=>'C:\Bitnami\wampstack-7.1.18-0\apache2\htdocs\BrandellDiesel_prod\PDF\request_'.$ro.'_'.$id.'.pdf', 'printer'=> $printer ));
		 		}

			}
		

		}
		

?>