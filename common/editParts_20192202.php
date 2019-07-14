<?php

    header('Content-Type: text/html; charset=utf-8');
    
    include_once './connection.php';
    
    $v              = $_GET['v'];
    $valor          = explode("|", $v);

    $idrequest      = $valor[0];
    $jobnumber      = $valor[1];
    $appuser        = $valor[2];
    $idrequesttype  = $valor[3];
    $idpriority     = $valor[4];
    $ro             = $valor[5];
    $vin            = $valor[6];
    $trans          = $valor[7];
    $engine         = $valor[8];
    $comments       = $valor[9];
    $inparts        = $_GET['m'];
    $aux='';
    $cont = 0;
    //array de partes a actualizar
    //var_dump($inparts);
        $update_status = explode('||', $inparts);
        $ordParts = array();

        $ordParts= $update_status[1];
        $inparts = $update_status[0];
    //array de partes a actualizar

    //array de partes nuevas
    
    $new_parts= explode('*|||', $_GET['m']); 
    //echo "<br>New Parts<br>";
    //var_dump($new_parts);
    
    
    
    //array de partes nuevas

    $sth = $dbh->prepare("SELECT * FROM request_update(:idrequest,:jobnumber,:appuser,:idrequesttype,:idpriority,:ro,:vin,:trans,:engine,:comments);");
 
    $sth->bindParam(':idrequest',       $idrequest,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);  
    $sth->bindParam(':jobnumber',       $jobnumber,     PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':appuser',         $appuser,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':idrequesttype',   $idrequesttype, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':idpriority',      $idpriority,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':ro',              $ro,            PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':vin',             $vin,           PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':trans',           $trans,         PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':engine',          $engine,        PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':comments',        $comments,      PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);

    $sth->execute();
        
    $dbparts      = array();
    
    $sth = $dbh->prepare("SELECT * FROM request_parts_lookup(:idrequest);"); 
    $sth->bindParam(':idrequest',       $idrequest,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
    $sth->execute();
    
    $dbparts = $sth->fetchAll();
    /*foreach($dbparts as $row) 
    {
        $seg    = $row['seg'];
        $part   = $row['part'];

        $sth = $dbh->prepare("SELECT * FROM request_parts_delete(:idrequest,:seg,:part,:appuser);"); 
        $sth->bindParam(':idrequest',       $idrequest,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':seg',             $seg,           PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':part',            $part,          PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->bindParam(':appuser',         $appuser,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
        $sth->execute();
    }*/
    if (isset($new_parts[1])) {
        $new_parts = $new_parts[1];
        
        $new_parts = explode('||||', $new_parts);
        //var_dump($new_parts);
        //$auxiliar = count($new_parts);
        //echo $auxiliar;
        //var_dump($new_parts);
        $new_parts = $new_parts[0];
        
        $partsDecode = json_decode($new_parts);
       // var_dump($partsDecode);
        if(isset($partsDecode)){
            foreach($partsDecode as $parts)
            { 
                if ($aux != $parts->seg){
                    $seg            = $parts -> seg;
                    $part           = $parts -> part;
                    $description    = $parts -> description;
                    $quantity       = $parts -> quantity;
                    $ord            = $parts -> ord;
                    $date_of_delivery = $parts -> date_of_delivery;
                    $comments_parts = $parts -> comment_parts;
                    $quantity = str_replace('"','',$quantity);
            
                    $sth = $dbh->prepare("select count (*) from parts where idrequest = ".$idrequest." and part = '".$part."' and seg = '".$seg."' and description = '".$description."' and quantity = ".$quantity."");
                              
                    $sth->execute();
                    $retorno = $sth->fetchAll();
                    foreach($retorno as $row){
                        $cont = $row['count'];

                    }
                    if($cont==0){
                        $sth = $dbh->prepare("SELECT * FROM request_parts_insert(:idrequest,:seg,:parts,:description,:qty,:ord,:appuser,:dateofdelivery,:comment_parts);");
                        $sth->bindParam(':idrequest',       $idrequest,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
                        $sth->bindParam(':seg',             $seg,           PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
                        $sth->bindParam(':parts',           $part,          PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
                        $sth->bindParam(':description',     $description,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
                        $sth->bindParam(':qty',             $quantity,      PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
                        $sth->bindParam(':ord',             $ord,           PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
                        $sth->bindParam(':appuser',         $appuser,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
                        $sth->bindParam(':dateofdelivery',  $date_of_delivery,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
                        $sth->bindParam(':comment_parts',   $comments_parts,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
                
                        $sth->execute();

                    }
                    $cont= 0;
                   

            
                   
                   // $aux = $parts->part;
                    
                }           
               
            }

        }

        
    }

    $update_of_delivery= explode('||||', $_GET['m']); 
    if (isset($update_of_delivery[1])) {
                $update_of_delivery = json_decode($update_of_delivery[1]);
                $update_of_delivery = (array)$update_of_delivery;

            

                    //Deadline to request
                            $temp_date = strtotime(date("Y-m-d",time()));
                    //Deadline to request
                foreach ($update_of_delivery as $key => $value) {
                    $temp = str_replace('part-','',$key);
                    $num_rows = 0;
                //echo $key.'/'.$value;
                    $sql="update parts set date_of_delivery = '".$update_of_delivery[$key]."' where part = '".$temp."'";
                
                //echo $sql;
                    $sth= $dbh->prepare($sql);
                    $sth->execute();
                    $sql= "select * from request_order_deadline where  requestid = ".$idrequest."";
                    $sth= $dbh->prepare($sql);
                    $sth->execute();
                    $num_rows = $sth->rowCount();
               
                 
                    //echo $sql."/".$num_rows."<br>";
                    

                if ($temp_date < strtotime($update_of_delivery[$key])){
                    $temp_date = strtotime($update_of_delivery[$key]);
                    $temp_date2 = date("Y-m-d", $temp_date);
                    
                    if ($num_rows == 0){
                        $sql_fecha = "insert into request_order_deadline values ($idrequest,'$update_of_delivery[$key]')";
                        //echo $sql_fecha."<br>";
                        $sth= $dbh->prepare($sql_fecha);
                        $sth->execute();
                    }
                    else{
                        $sql_fecha = "update request_order_deadline set dead_line = '".$temp_date2."' where requestid = ".$idrequest."";
                        //echo $sql_fecha."<br>";
                        $sth= $dbh->prepare($sql_fecha);
                        $sth->execute();
                    }

                    
                    //echo $sql;
                   
                    
                }
       
        
        }
    }

        $comment_canceled = explode('|||||', $_GET['m']);
    if (isset($comment_canceled[1])){
        $comment_canceled= str_replace("c-", '', $comment_canceled[1]);

        $comment_canceled=json_decode($comment_canceled);
        $comment_canceled = (array) $comment_canceled;
        
        foreach ($comment_canceled as $value) {

           $sql = "update parts set comment_parts ='".$value->comment."' where part = '".$value->part."'";
           
           $sth= $dbh->prepare($sql);
           $sth->execute();
           
        }


    }
    

    $return[] = array
    (
        'RESULTADO'                 => "0000", 
        'MENSAJE'                   => "ROW UPDATED"
    );

    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($return) . ");";	
    }
    else
    {
        echo  json_encode($return);
    }

        
        if(isset($ordParts)){
            
            $ord_temp= explode(',', $ordParts);
            //var_dump($ord_temp);
            $limit = count($ord_temp);
            $i=0;
            $j=0;
            while($i<$limit-1){
                
                $j=$i+1;
                $ord_temp[$j] = str_replace("*", "", $ord_temp[$j]);
                //echo $ord_temp[$i]."///". $ord_temp[$j];
            
                $sth = $dbh->prepare("SELECT * FROM update_status_part(:inpart, :instatus);");
                $sth->bindParam(':inpart', $ord_temp[$i], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
                $sth->bindParam(':instatus', $ord_temp[$j], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
                $sth->execute(); 
                
                //Status Canceled - Date of delivery
               /* if($ord_temp[$j] == 'canceled'){
                   $sth = $dbh->prepare("select idrequest, date_of_delivery from parts where part ='".$ord_temp[$i]."'");
                    $sth->execute();
                    $retorno_temp = $sth->fetchAll();
                    foreach ($retorno_temp as $row) {
                        $date_delivery_temp = $row['date_of_delivery'];
                        $idrequest_temp = $row['idrequest'];
                    }


                }*/
                $i++;
            }
            //Verificar piezas ordenadas
            $idrequest=(int) $idrequest;
            $status='ordered';
            
            $sth = $dbh->prepare("select count(*) from parts where status_order='ordered' and idrequest="."$idrequest");
            //$sth->bindParam('inrequest', $idrequest,  PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
            
            //$sth->bindParam('instatus', $status,  PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
            
            $sth->execute();
            $retorno = $sth->fetchAll();
           
            //var_dump($retorno);
            
            foreach ($retorno  as $row) {
                $num_parts_request_order = $row['count'];
                $ordered=$num_parts_request_order;
            }

            $sth = $dbh->prepare("select count(*) from parts where idrequest="."$idrequest");
            //$sth->bindParam('inrequest', $idrequest,  PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
            //$sth->bindParam('instatus', $status,  PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
            $sth->execute();
            $retorno = $sth->fetchAll();
            //var_dump($retorno);

            foreach ($retorno  as $row) {
                $num_parts_request_general_status = $row['count']; 
            }
            
            if ($num_parts_request_order==$num_parts_request_general_status){
                $sth = $dbh->prepare("SELECT * FROM update_request_ordered(:inidrequest)");
                 $sth->bindParam('inidrequest', $idrequest,  PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
                $sth->execute();
            }
                        //Verificar piezas recibidas
                        $status='received';
                        $sth = $dbh->prepare("select count(*) from parts where status_order='received' and idrequest="."$idrequest");
                        $sth->execute();
                        $retorno = $sth->fetchAll();
            
                        foreach ($retorno  as $row) {
                            $num_parts_request_order = $row['count'];
                            $received=$num_parts_request_order;
                        }
            
                        $sth = $dbh->prepare("select count(*) from parts where idrequest="."$idrequest");
                        $sth->execute();
                        $retorno = $sth->fetchAll();
            
                        foreach ($retorno  as $row) {
                            $num_parts_request_general_status = $row['count'];   
                            
                        }
                        if ($num_parts_request_order==$num_parts_request_general_status){
                            $sth = $dbh->prepare("SELECT * FROM update_request_received(:inidrequest)");
                            $sth->bindParam(':inidrequest', $idrequest,  PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
                            $sth->execute();
                        }

                            //Verificar piezas canceladas
                            //$status='canceled';
                            $sth = $dbh->prepare("select count(*) from parts where status_order='canceled' and idrequest="."$idrequest");
                            $sth->execute();
                            $retorno = $sth->fetchAll();
                
                            foreach ($retorno  as $row) {
                                $num_parts_request_order = $row['count'];
                                $canceled=$num_parts_request_order;
                            }
                
                            $sth = $dbh->prepare("select count(*) from parts where idrequest="."$idrequest");
                            $sth->execute();
                            $retorno = $sth->fetchAll();
                
                            foreach ($retorno  as $row) {
                                $num_parts_request_general_status = $row['count'];   
                                
                                
                            }
                            if ($canceled==$num_parts_request_general_status){
                                $sql="UPDATE requests set reqstatus = 'C', idpriority = 'N' where idrequest = '"."$idrequest"."'";
                                $sth = $dbh->prepare($sql);
                                $sth->execute();
                            }
                            if(($ordered+$canceled)==$num_parts_request_general_status && $ordered!=0){
                                $sth = $dbh->prepare("SELECT * FROM update_request_ordered(:inidrequest)");
                                $sth->bindParam('inidrequest', $idrequest,  PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
                                $sth->execute();
                            }
                            if ($ordered == 0 && ($canceled + $received==$num_parts_request_general_status)) {
                                $sql="UPDATE requests set reqstatus = 'C', idpriority = 'N' where idrequest = '"."$idrequest"."'";
                                $sth = $dbh->prepare($sql);
                                $sth->execute();
                            }
                            if ($ordered + $canceled + $received==$num_parts_request_general_status && $ordered !=0 && $canceled !=0 && $received !=0) {
                                $sth = $dbh->prepare("SELECT * FROM update_request_ordered(:inidrequest)");
                                $sth->bindParam(':inidrequest', $idrequest,  PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
                                $sth->execute();
                            }
    

        }
