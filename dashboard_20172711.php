<?php
	include_once("config.php");
	include_once("includes/functions.php");
	//session_start();
	if(isset($_SESSION['google_data'])) {
		$techName   = $_SESSION['google_data']['given_name'];
		$techId     = $_SESSION['google_data']['email'];		
		$resultArray = getValidateUser($techId, '', 'G', 'A');
		$_SESSION['getValidateUser']=$resultArray;
		$_SESSION["expire"]=time();
		if (isset($_SESSION['getValidateUser']['rol'])) {
			$profile	= $_SESSION['getValidateUser']['rol'];
		}else {
			header("Location:index_managerg.php?user=invalid");
			//$profile	= 'TV';
		}
	} else {
		$techName   = $_SESSION['getValidateUser']['fullNameUser'];
		$techId     = $_SESSION['getValidateUser']['idUser'];
		$profile	= $_SESSION['getValidateUser']['rol'];

	if(!isset($_SESSION['getValidateUser']) || empty($_SESSION['getValidateUser'])) {
		header("Location: http://reqparts.bdicalgary.com/BrandellDieselID/index_tech.php");
		die();
		}
	}
	
		
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BDI - Parts request</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">       
        <link rel="shortcut icon" type="image/ico" href="img/favicon.ico"/>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap-table.css" rel="stylesheet" type="text/css"/>
        <link href="css/font-awesome.css" rel="stylesheet" />
        <link href="css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css"/>	
        <style>
            .cell-corner{
                position: relative;
            }
            .cell-corner:after {
                content:'';
                position: absolute;
                top: 0;
                right: 0;
                width: 0;
                height: 0;
                border-style: solid;
                border-width: 0 8px 8px 0;
                border-color: transparent red transparent transparent;
            }
			.fixed-table-body 
			{
				overflow-x: hidden !important;
			}
			.type-options
			{
				font-weight: bold !important;
			}			
        </style>
		<script src="js/readyRederizSoft.js"></script>
		<script src="vendor/Print.js-1.0.18/print.min.js"></script>
    </head>
    <body>
        <header>
            <div class="container">
                <!--img class="img-responsive" alt="" style="padding-top:10px;" src="../../img/logo.png" /-->
            </div>
        </header>
        <div class="container">
		
		<?php 
		if ($profile!='TV') {								
		?>
            <div class="row">
                <nav class="navbar navbar-inverse navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
							<a class="navbar-brand" href="#" style="color: #ffffff;"><i class="fa fa-clone animated infinite flash"></i> <font color='#ffffff'>Brandell Diesel Inc.</font></a>
						</div>
						<div id="navbar" class="navbar-collapse collapse">
							<ul class="nav navbar-nav navbar-right">
							<?php 
							if ($profile=='ADMIN') {								
							?>
								<li><a id="adminUsers" href="#"><span class="fa fa-cogs" aria-hidden="true"></span> Admin Users</a></li>
								<li><a id="adminGroups" href="#"><span class="fa fa-cogs" aria-hidden="true"></span> Admin Groups</a></li>
							<?php 
							}								
							?>
								<li><a id="linkToMyModalSendMessage" href="#"><i class="fa fa-phone" aria-hidden="true"></i> Send Message</a></li>
								<li><a id="linkToMyModalPartsRequesition" href="#"><span class="fa fa-user-plus" aria-hidden="true"></span> New Parts Request</a></li>
								<li><a href="logout.php?logout=logout<?php echo $_SESSION['perfil']; ?>"><i class="fa fa-sign-in"></i> Logout</a></li>
							</ul>
						</div>
                    </div>
                </nav>
            </div>
		<?php 
		}								
		?>
            <div class="row">
                <div class="panel panel-default" id="print-dashboard">
                    <div class="panel-heading" style="text-align:center;padding-bottom: 30px;background:#191919;">
					<font color='#fff'>
						<div class="col-xs-12 text-center" id="one">
							<div class="col-xs-3 text-left" id="date">
								Invalid Date
							</div>
							<div class="col-xs-6 text-center" id="two">
								<font color='#fff'>
									<span class="fa fa-circle" style="color:yellow;"></span><span id="yellow"></span>
									<span class="fa fa-circle" style="color:green;"></span><span id="green"></span>
									<span class="fa fa-circle" style="color:red;"></span><span id="red"></span>
								</font>
							</div>
							<div class="col-xs-3 text-right leftspan" id="three">
								<?php 
								if ($profile=='TV') {
									echo '<a href="logout.php?logout=logout'.$_SESSION['perfil'].'"><font color="#fff"><i class="fa fa-sign-in"></i> Logout</font></a>';
								} else {
									echo $techName;
								}		
								?>
							</div>
						</div>
					</font>
                    </div>
                    <div class="panel-body">
					<?php
						if($profile!='TV') {
					?>
						<div id="custom-toolbar">
                            <button id="filter" class="btn btn-default" style="margin-left:4px;"><span class="fa fa-search" aria-hidden="true"></span></button>
							<button id="buttonApplyFilter" class="btn btn-default" style="margin-left:4px;" onClick='clearObj("input.form-control","filter");'><span class="fa fa-times" aria-hidden="true"></span></button>
                            <button id="print" class="btn btn-default" style="margin-left:4px;" onclick="printDiv('print-dashboard')"><span class="fa fa-print" aria-hidden="true"></span></button>
						<?php
							if($profile=='PARTSP') {
						?>
							<button id="audio1" class="btn btn-default" style="margin-left:4px;"><span class="fa fa-volume-up" aria-hidden="true"></span></button>
						<?php
							}
						?>
                        </div>
					<?php
						}
					?>
                        <table id="table-dashboard" data-sort-name="idrequest" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="<?php if($profile!='TV'){echo 'true';}else{echo 'false';}?>" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="#custom-toolbar" data-toolbar-align="right"></table>
                    </div>
                </div>				        	
            </div>
        </div>  
            
        <!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
		<input type="hidden" id="partsRequesition"/>
        <div class="modal" id="myModalPartsRequesition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> New Parts Request</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <form class="form-horizontal" style="text-align: left;" data-toggle="validator">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="techName">TECH NAME</label>
                                                        <div class="col-md-4  inputGroupContainer" style="padding-right: 0;">
                                                            <div class="input-group">
                                                                <input type="text" id="techName" name="techName" class="form-control" value="<?php echo $techName ?>" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5  inputGroupContainer" style="padding-left: 0; width:auto; ">
                                                            <div class="input-group">
                                                                <input type="text" id="techId"   name="techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="requestType"><font color='#009207'>*</font> TYPE </label>
                                                        <div class="col-md-9  inputGroupContainer"">
															<label class="btn type-options" ><input type="radio" name="requestType" value="O" checked> Order </label>														
															<label class="btn type-options" ><input type="radio" name="requestType" value="Q"> Quote </label>
															<label class="btn type-options" ><input type="radio" name="requestType" value="9"> 911 </label>
                                                        </div>
                                                    </div>													
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="ro"><font color='#009207'>*</font> RO#</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="ro" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="vin">VIN#</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="vin" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="trans">TRANS#</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="trans" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="engine">ENGINE#</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="engine" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="comments">COMMENTS:</label>
                                                        <div class="col-md-9">
                                                            <textarea id="comments" class="form-control" rows="3" placeholder=""></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <table id="table-parts" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right"></table>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;display:none;">
                                                            <input type="text" class="form-control" id="parts" placeholder="* PARTS:">
                                                        </div>
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;">
                                                            <input name="seg" class="form-control" id="seg" placeholder="* SEG:" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return Onlynumbers(event)" type = "number" maxlength = "10"/>
                                                        </div>
                                                        <div class="col-lg-7" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="description" placeholder="* DESCRIPTION:">
                                                        </div>
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <input name="qty" step="0.01" class="form-control" id="qty" placeholder="* QTY:" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return Onlynumbers(event)" type = "number" maxlength = "10"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" style="text-align: right;">
                                                        <button id="buttonAddParts" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Add parts</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">		
							<div class="col-xs-12 col-centered" id="cargar_data_requesition">
								<img src="loader.gif"/>Please wait, sending mail...
							</div>
						</div>
						<font size="2">All fields marked with <font color='#009207' size="3">*</font> are required.</font>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button type="button" id="buttonSavePartsRequesition" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Save</button> 
                    </div>                        
                </div>
            </div>
        </div>
        <!-- Fin Modal -->
        <!-- Fin Button trigger modal -->

       <!-- Inicio cambios view - print HERE -->
   
        <!-- Inicio Button trigger modal -->
        <!-- Inicio Modal VIEW-->
        <div class="modal" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> View Parts Requesition</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <form class="form-horizontal" style="text-align: left;">
													<div class="form-group" style="display:none">
                                                        <label class="col-md-3 control-label" for="idrequest">Request ID</label>
                                                        <div class="col-md-9">
															<div id="idRequest" class="form-control"></div>	
                                                        </div>							
                                                    </div>												
													<div class="form-group required" id="pruebaImpresion">
                                                        <label class="col-md-3 control-label" for="requestdate">Request date</label>
                                                        <div class="col-md-9">
															<div id="date-view" class="form-control"></div>	
                                                        </div>							
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="techName">Tech name</label>
                                                        <div class="col-md-9  inputGroupContainer">
                                                            <div id="view-techname" class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="requestType"><font color='#009207'>*</font> TYPE </label>
                                                        <div class="col-md-9  inputGroupContainer ">
															<label class="btn type-options" ><input type="radio" name="requestType" value="O"> Order </label>														
															<label class="btn type-options" ><input type="radio" name="requestType" value="Q"> Quote </label>
															<label class="btn type-options" ><input type="radio" name="requestType" value="9"> 911 </label>
                                                        </div>
                                                    </div>													
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="ro"><font color='#009207'>*</font> RO#</label>
                                                        <div class="col-md-9">
                                                            <div id="view-ro" class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="vin">VIN#</label>
                                                        <div class="col-md-9">
                                                            <div id="view-vin" class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="trans">TRANS#</label>
                                                        <div class="col-md-9">
                                                            <div id="view-trans" class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="engine">ENGINE#</label>
                                                        <div class="col-md-9">
                                                            <div id="view-engine" class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="comments">COMMENTS:</label>
                                                        <div class="col-md-9">
                                                            <div id="view-comments" class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <table id="table-parts" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right"></table>
                                                    </div>
                                                </form>
                                            </div>
                                        </center>                                                                                                            
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">		
							<div class="col-xs-12 col-centered" id="cargar_data_edit">
								<img src="loader.gif"/>Please wait, sending mail...
							</div>
						</div>
                    </div>        
                    <div class="modal-footer">					
						<button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;" id="btnSendPDF" onclick="sendPDF()">Send PDF</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;" id="print" onclick="printpdf()">Print</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                    </div>                  
                </div>
            </div>
		</div>
        <!-- Fin Modal -->                                                                                                                                                                                                                                                   
        <!-- Fin Button trigger modal -->
		
		<!-- Inicio Button trigger modal -->
        <!-- Inicio Modal SEND MESSAGE-->
        <div class="modal" id="myModalSendMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Send Message</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <form class="form-horizontal" style="text-align: left;" data-toggle="validator">
													<div class="form-group">
														<div class="col-md-12">
																<label class="btn btn-default" ><input type="radio" name="optradio" value="Group"> Group</label>
																<label class="btn btn-default" ><input type="radio" name="optradio" value="User"> User</label>
														</div>
													</div>

                                                    <div class="form-group" id ="selectGroup">
                                                        <label class="col-md-3 control-label" for="techName" style="padding-top:0px !important"><font color='#009207'>*</font>To:</label>
                                                        <div class="col-md-9">
									<select name="selectName" id="selectName">    
										<option value="">-- Select group --</option>
										<?php
											getGroups('A');
										?>
									</select>

                                                        </div>
						    </div>
                                                    <div class="form-group" id ="selectSingle">
							<label class="col-md-3 control-label" for="techName" style="padding-top:0px !important"><font color='#009207'>*</font>To:</label>
                                                        <div class="col-md-9">
									<select name="selectNameU" id="selectNameU">    
										<option value="" selected="selected">-- Select user name --</option>
										<?php
											getlistUser('', '', 'A', '');
										?>
									</select>
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="comments"><font color='#009207'>*</font> Comments:</label>
                                                        <div class="col-md-9">
                                                            <textarea id="comments" class="form-control" rows="3" placeholder=""></textarea>
															<input type="hidden" id="labelMessage" name="labelMessage" class="form-control" value="" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </center>                                                                                                           
                                    </div>
                                </div>
                            </div>
                        </div>
						<font size="2">All fields marked with <font color='#009207' size="3">*</font> are required.</font>
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button type="button" id="buttonSendMessage" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Send</button> 
                    </div>                        
                </div>
            </div>
        </div>
        <!-- Fin Modal -->
        <!-- Fin Button trigger modal -->
         
 
            
        <!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
        <div class="modal" id="modal-assign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Assign Parts Request</h4>
						</font>
					</div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" style="min-height:150px">
                                                <input type="hidden" id="techName" 		name="techName" 	value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="techId" 		name="techId" 		value="<?php echo $techId ?>" 	disabled="disabled"/>
                                                <input type="hidden" id="idRequest" 	name="idRequest" 	value="" 						disabled="disabled"/>
												<input type="hidden" id="jobnumber"   	name="jobnumber"    value=""                 		disabled="disabled"/>
                                                <div class="form-group">
                                                    <div class="dropdown">
                                                        <button class="btn btn-default dropdown-toggle col-md-12" type="button" data-toggle="dropdown">
                                                            SPECIALIST:
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" id="specialist"></ul>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
                                                <h4 id="titulo"></h4>
                                            </div>
                                        </center>                                                                                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button id="buttonAssignPartsRequesition" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Assign</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->  

        <!-- Inicio Modal PARTSP Assign -->
        <div class="modal" id="modal-assignsp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Assign Parts Request</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body">
                                                <input type="hidden" id="techName" name="techName" value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="techId"   name="techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
												<input type="hidden" id="idRequest" name="idRequest" value="" disabled="disabled"/>
												<input type="hidden" id="jobnumber" name="jobnumber" value="" disabled="disabled"/>
                                                <h4 id="title"></h4>
                                            </div>
                                        </center>                                                                                                                                                                                                                                                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button id="buttonAssignPartsRequesitionSp" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Assign</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal PARTSP Assign--> 

        <!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
        <div class="modal" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Delete Parts Request</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body">
                                                <input type="hidden" id="techName" name="techName" value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="techId"   name="techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
                                                <h4 id="titulo"></h4>
                                            </div>
                                        </center>                                                                                                                                                                                                                                                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button id="buttonDeletePartsRequesition" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Delete</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->
		
        <!-- Fin Button trigger modal -->
            
        <!-- Inicio Button trigger modal -->
        <!-- Inicio Modal EDIT -->
        <div class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Edit Parts Requesition</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <form class="form-horizontal" style="text-align: left;">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="techName">TECH NAME</label>
                                                        <div class="col-md-4  inputGroupContainer" style="padding-right: 0;">
                                                            <div class="input-group">
                                                                <input type="text" id="techName" name="techName" class="form-control" value="<?php echo $techName ?>" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5  inputGroupContainer" style="padding-left: 0; width:auto; ">
                                                            <div class="input-group">
                                                                <input type="text" id="techId"   name="techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
                                                                <input type="hidden" id="idRequest"   name="idRequest"    value=""                        disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="requestType"><font color='#009207'>*</font> TYPE </label>
                                                        <div class="col-md-9  inputGroupContainer">
															<label class="btn type-options" ><input type="radio" name="requestType" value="O"> Order </label>														
															<label class="btn type-options" ><input type="radio" name="requestType" value="Q"> Quote </label>
															<label class="btn type-options" ><input type="radio" name="requestType" value="9"> 911 </label>
                                                        </div>
                                                    </div>													
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="ro"><font color='#009207'>*</font> RO#</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="ro" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="vin">VIN#</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="vin" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="trans">TRANS#</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="trans" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="engine">ENGINE#</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="engine" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="comments">COMMENTS:</label>
                                                        <div class="col-md-9">
                                                            <textarea id="comments" class="form-control" rows="3" placeholder=""></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <table id="table-parts" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right"></table>
                                                    </div>
                                                    <div class="form-group">                                                        
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;display:none;">
                                                            <input type="text" class="form-control" id="parts" placeholder="* PARTS:">
                                                        </div>
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;">
                                                            <input name="seg" class="form-control" id="seg" placeholder="* SEG:" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return Onlynumbers(event)" type = "number" maxlength = "10"/>
                                                        </div>
                                                        <div class="col-lg-7" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="description" placeholder="* DESCRIPTION:">
                                                        </div>
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <input name="qty" step="0.01"  class="form-control" id="qty" placeholder="* QTY:" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return Onlynumbers(event)" type = "number" maxlength = "10"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group pull-right">
														<button id="buttonAddParts" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Add parts
														</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </center>                                                                                                            
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">		
							<div class="col-xs-12 col-centered" id="cargar_data_edit" style="display:none;">
								<img src="loader.gif"/>Please wait, sending mail...
							</div>
						</div>
						<font size="2">All fields marked with <font color='#009207' size="3">*</font> are required.</font>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button id="buttonSave" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Save</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->

		<!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
        <div class="modal" id="modal-close" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Close Parts Requesition</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body">
                                                <input type="hidden" id="techName" name="techName" value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="techId"   name="techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
                                                <h4 id="titulo"></h4>
                                            </div>
                                        </center>                                                                                                                                                                                                                                                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Cancel</button>
                        <button id="buttonCLosePartsRequesition" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Close Request</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->
                                                                    
        <!-- Fin Button trigger modal -->
		
		<!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
        <div class="modal" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Search Request</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <form class="form-horizontal" style="text-align: left; height: 200px" data-toggle="validator">
                                                    <div class="form-group"  style="display:none;">
                                                        <label class="col-md-3 control-label" for="techName">Tech name</label>
                                                        <div class="col-md-4  inputGroupContainer" style="padding-right: 0;">
                                                            <div class="input-group">
																<input type="text" id="techId" name="techId" class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="startdate">Start Date</label>
                                                        <div class="col-md-9">
                                                            <div class='input-group date' id='datetimepickerStartDate'>
                                                                <input type='text' id="startdate" class="form-control" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="enddate">End Date</label>
                                                        <div class="col-md-9">
                                                            <div class='input-group date' id='datetimepickerEndDate'>
                                                                <input type='text' id="enddate" class="form-control" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" style="display:none;">
                                                        <label class="col-md-3 control-label" for="jobnumber">Job Number</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="jobnumber" placeholder="">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label class="col-md-3 control-label" for="keyword">Key Word</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="keyword" placeholder="">
															(specialist name, status, ro, vin, enggine)
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </center>                                                                                                           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button type="button" id="buttonApplyFilter" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Filter</button>
                    </div>                       
                </div>
            </div>
        </div>
		
        <!-- Fin Modal -->
		
	<!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
        <div class="modal" id="modal-adminUsers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Admin User</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <form class="form-horizontal" style="text-align: left;">
                                                    <input type="hidden" id="techName" name="techName" class="form-control" value="<?php echo $techName ?>" disabled="disabled"/>
                                                    <input type="hidden" id="techId"   name="techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
                                                    <div class="form-group">
                                                        <table id="table-userDashboard" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right"></table>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-4" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="idUser" placeholder="* Id User:">
                                                        </div>
                                                        <div class="col-lg-4" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="surName" placeholder="* Name:">
                                                        </div>
                                                        <div class="col-lg-4" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="lastName" placeholder="* lastName:">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <input type="password" class="form-control" id="password" placeholder="* Password:">
                                                        </div>
														<div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="phonenum" placeholder="Phone:">
                                                        </div>
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <select class="form-control" id="idUserType" change="alert('pruebas');"></select>
                                                        </div>
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <select class="form-control" id="idRol"></select>
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <select multiple class="form-control" id="idGroup"></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group pull-right">
                                                        <button id="buttonAddUser" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Add user</button>
														<div class="col-lg-7" style="padding-left: 0;padding-right: 0;">
                                                        <button id="buttonEditUser" type="button" class="btn btn-primary" style="display:none;background:#2C3E50;border-color:#2C3E50;">Save user</button>
														</div>
														<div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                        <button id="buttonCancelEdit" type="button" class="btn btn-primary" style="display:none;background:#2C3E50;border-color:#2C3E50;">Cancel</button>
														</div>
                                                    </div>


													<div class="modal" id="modal-deluser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header" style="background:#009207;">
																	<font color='#fff'>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																	<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Delete User</h4>
																	</font>
																</div>
																<div class="modal-body">
																	<div class="col-sm-16">
																		<div class="widget-box">
																			<div class="widget-body">
																				<div class="modal-body datagrid table-responsive" >
																					<center>
																						<div class="panel-body">
																							<input type="hidden" id="iduser" name="techName" value="" disabled="disabled"/>
																							<input type="hidden" id="techId"   name="techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
																							<h4 id="titulo"></h4>
																						</div>
																					</center>                                                                                                                                                                                                                                                                  
																				</div>
																			</div>
																		</div>
																	</div>
																</div>        
																<div class="modal-footer">
																	<button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
																	<button id="buttonDeleteUser" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Delete</button>
																</div>                  
															</div>
														</div>
													</div>

                                                </form>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->                                                
        <!-- Fin Button trigger modal -->

	
	<!-- Inicio Button trigger modal groups-->
        <!-- Inicio Modal GROUPS -->


        <div class="modal" id="modal-adminGroups" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Admin Groups</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="grouplist">
                                                <form class="form-horizontal" style="text-align: left;">
                                                    <input type="hidden" id="techName" name="techName" class="form-control" value="<?php echo $techName ?>" disabled="disabled"/>
                                                    <input type="hidden" id="techId"   name="techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
                                                    <div class="form-group">
                                                        <table id="table-GroupsDashboard" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right"></table>
                                                    </div>
                                                    <div class="form-group">

                                                        <div class="col-lg-4" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="name" placeholder="* Name:">
                                                        </div>
                                                    </div>													
                                                    <div class="form-group pull-right">
                                                        <button id="buttonAddGroup" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Add group</button>
							<div class="col-lg-7" style="padding-left: 0;padding-right: 0;">
                                                        <button id="buttonEditGroup" type="button" class="btn btn-primary" style="display:none;background:#2C3E50;border-color:#2C3E50;">Save group</button>
							</div>
							<div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                        <button id="buttonCancelGroup" type="button" class="btn btn-primary" style="display:none;background:#2C3E50;border-color:#2C3E50;">Cancel</button>
							</div>
                                                    </div>
													<div class="modal" id="modal-delgroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header" style="background:#009207;">
																	<font color='#fff'>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																	<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Delete Group</h4>
																	</font>
																</div>
																<div class="modal-body">
																	<div class="col-sm-16">
																		<div class="widget-box">
																			<div class="widget-body">
																				<div class="modal-body datagrid table-responsive" >
																					<center>
																						<div class="panel-body">
																							<input type="hidden" id="idgroup" name="idgroup" value="" disabled="disabled"/>
																							<input type="hidden" id="techId"   name="techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
																							<h4 id="titulo"></h4>
																						</div>
																					</center>                                                                                                                                                                                                                                                                  
																				</div>
																			</div>
																		</div>
																	</div>
																</div>        
																<div class="modal-footer">
																	<button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
																	<button id="buttonDeleteGroup" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Delete</button>
																</div>                  
															</div>
														</div>
													</div>

                                                </form>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->                                                
        <!-- Fin Button trigger modal groups -->



	<script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/collapse.js" type="text/javascript"></script>
        <script src="js/transition.js" type="text/javascript"></script>
        <script src="js/moment-with-locales.js" type="text/javascript"></script>
        <script src="js/bootstrap-table.js" type="text/javascript"></script>
        <script src="locale/bootstrap-table-en-US.js" type="text/javascript"></script>
        <script src="js/jquery.blink.js" type="text/javascript"></script>
        <script src="js/bootstrapvalidator.min.js" type="text/javascript"></script>
        <script src="js/ion.sound.min.js" type="text/javascript"></script>
        <script src="js/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="js/ajax.js" type="text/javascript"></script>
        <script src="js/jspdf.debug.js" type="text/javascript"></script>
        <script>
            var idrequest           = null;
            var jobnumber           = null;
            var appuser             = null;
			var idspecialist        = null;
            var idrequesttype       = null;
            var idpriority          = null;
            var vidrequesttype       = null;
            var vidpriority          = null;
            var techName            = null;
            var techId              = null;
            var ro                  = null;
            var vin                 = null;
            var trans               = null;
            var engine              = null;
            var comments            = null;
			var iduser              = null;
            var startdate           = null;
            var enddate             = null;
            var vrequestdate        = null;                       
            
            var parts               = [];
            var deletedParts        = [];
            var editedParts         = [];
            var newParts            = [];
            
            var part                = [];
            var deletedPart         = [];
            var editedPart          = [];
            var newPart             = [];

            var JSONparts           = [];
            var JSONdeletedParts    = [];
            var JSONeditedtedParts  = [];
            var JSONnewParts        = [];
            
            var green               = null;
            var yellow              = null;
            var red                 = null;
			
			var dashboard_data      = null;
            var filter              = 0;
			var audio               = 0;
                        
            var ROW             	= null;
						           
            $(document).ready(function()
            {						
		iduser          = '<?php echo $techId; ?>'; //$("#modal-filter #techId").val();
                URL 			= "common/ws.php";
		DATA            = null;
		VALOR           = '';
		if (iduser == '')
		{	console.log('WARNING! Empty user');
			window.location="/BrandellDiesel/index_tech.php";}

		<?php 
		if ($profile=='TECH') {
		?>
				VALOR           = iduser;
		<?php
		}
		?>
		call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                {
		    DATA = data;
		    dashboard_data = data;
                    //console.log(dashboard_data);
                    $('#table-dashboard').bootstrapTable
                    ({
                        //data: DATA,
						data: dashboard_data,
                        striped: true,
                        columns: 
                        [
                            [
                                {
                                    field: 'jobnumber',
                                    title: 'Job Number',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }, 
                                {
                                    field: 'techname',
                                    title: 'Tech Name',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                },
                                {
                                    field: 'status',
                                    title: 'Status',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }, 
                                {
                                    field: 'deadline',
                                    title: 'Dead Line',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
									formatter : function(value) 
                                    {
                                        if(!value)
                                        {
											return value;
                                        }
                                        else
                                        {
                                            var localDate = moment(value).local();
											var deadlineDate = moment(value).format("MMM DD YYYY, hh:mm:ss a");
											//console.log('localdate');
											//console.log(localDate.format("MMM DD YYYY, h:mm:ss a")); // 2015-30-01 02:00:00

											return deadlineDate;
                                        }
                                    }
                                }, 
								{
                                    field: 'idrequesttype',
                                    title: 'Type',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
									formatter : function(value, row) 
                                    {
                                        var vPriority = value;
										if (row.idpriority === "H") { 
											vPriority  = '<div style="color:red;">! '+ value + '</div>'; 											
										} 
                                        return vPriority; 											
                                    } 
                                },
                                {
                                    field: 'assignedto',
                                    title: 'Assigned To',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    formatter : function(value) 
                                    {
                                        if(!value)
                                        {
											return "Unassigned";
                                        }
                                        else
                                        {
                                            return value;
                                        }
                                    }
                                },
                                {
                                    field: 'colorflag',
                                    title: 'Status',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value) 
                                    {
                                        if (value === "Y")
                                        {
                                            return '<a class="blink"><span class="fa fa-circle" aria-hidden="true" style="color:yellow;"></span></a>';   
                                        }
                                        else if (value === "R")
                                        {
                                            return '<a class="blink"><span class="fa fa-circle" aria-hidden="true" style="color:red;"></span></a>';   
                                        }
                                        else if (value === "G")
                                        {
                                            return '<a class=""><span class="fa fa-circle" aria-hidden="true" style="color:green;"></span></a>';   
                                        }
                                    } 
                                }
		<?php 
		if ($profile!='TV') {
		?>
								,
                                {
                                    title: 'Actions',
                                    colspan: <?php if($profile=='TECH'){echo '1';}else{echo '5';}?>,
                                    align: 'center'
                                }
		<?php 
		}
		?>
                            ],
                            [
		<?php 
		if ($profile!='TV') {
							if ($profile!='TECH') {	
		?>
                                {
                                    field: 'assign',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value, row) 
                                    {
                                        var vAssign = '<a class=""><span class="fa fa-user" aria-hidden="true"></span></a>';
										if (row.status === "Closed") { 
											vAssign = '<a class=""><span class="fa fa-user" aria-hidden="true" style="color: #999999;"></span></a>';
										} 
                                        return vAssign; 											
                                    } 
                                },
		<?php 
							}
		?>
                                {
                                    field: 'view',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value) 
                                    {
										var arr = value.split('|');
                                        var comment = arr[1];
                                        return '<a class="eye" title="Comment: '+comment+'"><span class="fa fa-eye"></span></a></abbr>'   
                                    },
                                    cellStyle : function(value, row, index, field) 
                                    {
                                        var arr = value.split('|');
                                        var comment = arr[1];
                                        //alert('pruebas:'+comment);
                                        //if(comment.length != 0)
										if(comment != null && comment != undefined && comment.length != 0)
                                        {
                                            return {
                                                classes: 'cell-corner'
                                            };   
                                        }
                                        else
                                        {
                                            return {
                                                classes: ''
                                            }; 
                                            
                                        }
                                    }
                                }
		<?php 
							if ($profile!='TECH') {
		?>
                                ,{
                                    field: 'edit',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value, row) 
                                    {
										var vEdit = '<a class=""><span class="fa fa-pencil" aria-hidden="true"></span></a>';
										if (row.status === "Closed") { 
											vEdit = '<a class=""><span class="fa fa-pencil" aria-hidden="true" style="color: #999999;"></span></a>'; 											
										} 
                                        return vEdit; 										
                                    }
                                },
                                {
                                    field: 'close',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value, row) 
                                    {
										var vClose = '<a class=""><span class="fa fa- fa-check-square" aria-hidden="true"></span></a>';
										if (row.status === "Closed") { 
											vClose = '<a class=""><span class="fa fa- fa-check-square" aria-hidden="true" style="color: #999999;"></span></a>'; 											
										} 
                                        return vClose;   
                                    }
                                },
                                {
                                    field: 'delete',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value, row) 
                                    {
										var vDelete = '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
										if (row.status === "Closed") { 
											vDelete = '<a class=""><span class="fa fa-trash" aria-hidden="true" style="color: #999999;"></span></a>'; 											
										} 
                                        return vDelete;   
                                    }
                                }
		<?php 
							}
		}
		?>
                            ]
                        ],
                        onPageChange: function (number, size) 
                        {
                            $('.blink').blink();
                        },
                        onClickCell: function (field, value, row) 
                        {
                            if (field === "assign" && row.status != "Closed")
                            {
								if ('<?php echo $profile;?>'!=='PARTSP') { // ($profile!='PARTSP')  Validate user type manager or specialist
									$("#specialist").empty();
									idusertype      = '';
									rol             = 'PARTSP';
									status          = 'A';
									phoneNum        = '%';
									
									URL = "common/users_list.php";
									VALOR = idusertype + "|" + rol + "|" + status + "|" + phoneNum;
									call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
									{
										users = data;
										$.each(users, function(index)
										{    
											$("#specialist").append('<li><a href="" data-fullname="'+ users[index].fullname +'" data-iduser="'+ users[index].iduser +'" data-rol="'+ users[index].rol +'" data-rolname="'+ users[index].rolname +'"  >' + users[index].fullname + '</a></li>');
										});
									});
									idrequest = row.idrequest;
									jobnumber = row.jobnumber;
									$('#modal-assign #idRequest').val(idrequest);
									$('#modal-assign #jobnumber').val(row.jobnumber);
									$('#modal-assign').modal('show');
									$('#modal-assign #buttonAssignPartsRequesition').prop('disabled', true);
								}
								else
								{
									if (field === "assign" && row.status == "Open")
									{
										alert('The request you are trying to take is assigned');
									}
									else
									{
										idrequest = row.idrequest;
										jobnumber = row.jobnumber;
										$('#modal-assignsp #idRequest').val(idrequest);
										$('#modal-assignsp #jobnumber').val(jobnumber);
										$('#modal-assignsp #title').text("Do you want to take request " + jobnumber +"?");
										$('#modal-assignsp').modal('show');
									}
								}
                            }
                            else if(field === "view") // VIEW PRINT HERE
                            { 
								//console.log('Modal view showing')
								// Copy from edit							
	
                                DATA    = null;
                                parts   = [];
                                
                                $('#modal-view').modal('show');
								rederizsoftHideLoad( '#partsRequesition', '#cargar_data_edit' );
                                ROW = row;
                                $("#modal-view #idRequest").val(row.idrequest);
								//console.log(row.requestdate);
                                idrequest = row.idrequest;
                                URL             = "common/lookupParts.php";
                                METODO          = "";
                                VALOR           = idrequest;
                                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                                {
                                    DATA    = data;
                                    parts   = DATA.PARTS;
                                    //console.log(parts);
									vOType = DATA.REQUESTS[0].idrequesttype;
									
                                    if(DATA.REQUESTS[0].idpriority === "H"){
										vOType='9';
										} 
										
									var $radios = $('#modal-view input:radio[name=requestType]');	
									$radios.filter('[value='+vOType+']').prop('checked', true);									
									$radios.prop('disabled',true);	
										
                                    
									$(".modal-body #date-view").text(moment(DATA.REQUESTS[0].requestdate).format("MMM DD YYYY, hh:mm:ss a"));
									$(".modal-body #view-techname").text(DATA.REQUESTS[0].techname);
									//console.log(DATA.REQUESTS[0].techname);
									
                                    $("#modal-view #view-ro").text(DATA.REQUESTS[0].ro);
                                    $("#modal-view #view-vin").text(DATA.REQUESTS[0].vin);
                                    $("#modal-view #view-trans").text(DATA.REQUESTS[0].trans);
                                    $("#modal-view #view-engine").text(DATA.REQUESTS[0].engine);
                                    $("#modal-view #view-comments").text(DATA.REQUESTS[0].reqcomment);
                                    
                                    $('#modal-view #table-parts').bootstrapTable('destroy');
                                    $('#modal-view #table-parts').bootstrapTable
                                    ({
                                        data: parts,
                                        striped: true,
                                        columns: 
                                        [
                                            [
                                                {
                                                    field: 'seg',
                                                    title: '<font color="#009207">*</font> SEG:',
                                                    align: 'center',
                                                    valign: 'middle',
                                                    width: 1
                                                }, 
                                                {
                                                    field: 'part',
                                                    title: '<font color="#009207">*</font> PART:',
                                                    align: 'center',
                                                    valign: 'middle',
													visible: false,	
                                                    width: 1
                                                }, 
                                                {
                                                    field: 'description',
                                                    title: '<font color="#009207">*</font> DESCRIPTION:',
                                                    align: 'center',
                                                    valign: 'middle',
                                                    width: 1
                                                }, 
                                                {
                                                    field: 'quantity',
                                                    title: '<font color="#009207">*</font> QTY:',
                                                    align: 'center',
                                                    valign: 'middle',
                                                    width: 1
                                                }, 

                                            ]
                                        ]
                                    });	
														
									// End copy from edit							
							
									iduser 	= $(".modal-view #view-techname").text();//$("#techId").val();
								
									//**************FILTER DASHBOARD*******************
									if (filter === 0) {
										appuser		= $(".modal-body #techId").val();
										VALOR   	= '';
										<?php 
										if ($profile=='TECH') {
										?>
											VALOR 	= appuser;
										<?php
										}
										?>
										reloadDashboard(VALOR, 'common/ws.php');
									} else {
										iduser		= $("#modal-filter #techId").val();
										startdate	= $("#modal-filter #startdate").val();
										enddate		= $("#modal-filter #enddate").val();
										jobnumber	= $("#modal-filter #jobnumber").val();
										keyword		= $("#modal-filter #keyword").val();										
										URL			= "common/dashboard_search.php";
										DATA		= null;
										VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
										reloadDashboard(VALOR, 'common/dashboard_search.php');
									}

                                });   
                            }
                            else if(field === "edit" && row.status != "Closed")
                            { 
                                DATA    = null;
                                parts   = [];
								var vOType = "";
                                
                                $('#modal-edit').modal('show');
								rederizsoftHideLoad( '#partsRequesition', '#cargar_data_edit' );
                                ROW = row;
                                $("#modal-edit #idRequest").val(row.idrequest);
                                idrequest = row.idrequest;
                                URL             = "common/lookupParts.php";
                                METODO          = "";
                                VALOR           = idrequest;
                                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                                {
                                    DATA    = data;
                                    parts   = DATA.PARTS;
                                    //console.log(parts);
									vOType = DATA.REQUESTS[0].idrequesttype;

                                    if(DATA.REQUESTS[0].idpriority === "H"){
										vOType='9';
										}
										
									var $radios = $('#modal-edit input:radio[name=requestType]');	
									$radios.filter('[value='+vOType+']').prop('checked', true);		
									
									//$('#modal-edit input:radio[name="requestType"]').val(vOType);
                                    
									/*if(DATA.REQUESTS[0].idrequesttype === "Q"){ // ISKAR
										
                                        $("#modal-edit #requestType").prop('checked', true);} 
                                    else {
                                        $("#modal-edit #requestType").prop('checked', false);}*/
                                    

                                    $("#modal-edit #ro").val(DATA.REQUESTS[0].ro);
                                    $("#modal-edit #vin").val(DATA.REQUESTS[0].vin);
                                    $("#modal-edit #trans").val(DATA.REQUESTS[0].trans);
                                    $("#modal-edit #engine").val(DATA.REQUESTS[0].engine);
                                    $("#modal-edit #comments").val(DATA.REQUESTS[0].reqcomment);
                                    
                                    $('#modal-edit #table-parts').bootstrapTable('destroy');
                                    $('#modal-edit #table-parts').bootstrapTable
                                    ({
                                        data: parts,
                                        striped: true,
                                        columns: 
                                        [
                                            [
                                                {
                                                    field: 'seg',
                                                    title: '<font color="#009207">*</font> SEG:',
                                                    align: 'center',
                                                    valign: 'middle',
                                                    width: 1
                                                }, 
                                                {
                                                    field: 'part',
                                                    title: '<font color="#009207">*</font> PART:',
                                                    align: 'center',
                                                    valign: 'middle',
													visible: false,	
                                                    width: 1
                                                }, 
                                                {
                                                    field: 'description',
                                                    title: '<font color="#009207">*</font> DESCRIPTION:',
                                                    align: 'center',
                                                    valign: 'middle',
                                                    width: 1
                                                }, 
                                                {
                                                    field: 'quantity',
                                                    title: '<font color="#009207">*</font> QTY:',
                                                    align: 'center',
                                                    valign: 'middle',
                                                    width: 1
                                                }, 
                                                /*{
                                                    field: 'ord',
                                                    title: '<font color="#009207">*</font> ORD:',
                                                    align: 'center',
                                                    valign: 'middle',
                                                    width: 1
                                                },*/
                                                {
                                                    field: 'delete',
                                                    title: '',
                                                    align: 'center',
                                                    valign: 'middle',
                                                    width: 1,
                                                    clickToSelect: false,
                                                    formatter : function() 
                                                    {
                                                        return '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
                                                    } 
                                                }
                                            ]
                                        ],
                                        onClickCell: function (field, value) 
                                        {
                                            if(field === "delete")
                                            {
                                                newParts = parts.filter(function(el)
                                                {
                                                    deletedParts.push(value);
                                                    return el.delete !== value;
                                                });

                                                $('.modal-body #table-parts').bootstrapTable('load', newParts);

                                                parts = newParts;
                                                //console.log(JSON.stringify(newParts, null, ' '));
                                            }
                                        } 
                                    });
									//**************FILTER DASHBOARD*******************
									if (filter === 0) {
										appuser		= $(".modal-body #techId").val();
										VALOR   	= '';
										<?php 
										if ($profile=='TECH') {
										?>
											VALOR 	= appuser;
										<?php
										}
										?>
										reloadDashboard(VALOR, 'common/ws.php');
									} else {
										iduser		= $("#modal-filter #techId").val();
										startdate	= $("#modal-filter #startdate").val();
										enddate		= $("#modal-filter #enddate").val();
										jobnumber	= $("#modal-filter #jobnumber").val();
										keyword		= $("#modal-filter #keyword").val();
										URL			= "common/dashboard_search.php";
										DATA		= null;
										VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
										reloadDashboard(VALOR, 'common/dashboard_search.php');
									}
                                });   
                            }
                            else if(field === "delete" && row.status != "Closed")
                            { 
                                //$(".modal-body #titulo").text("Are you sure to delete the record # " + row.idrequest);
								$("#modal-delete #titulo").text("Do you want to delete request " + row.jobnumber + "?");
                                idrequest = row.idrequest;
								if (row.status.toLowerCase()!='closed') {
									$('#modal-delete').modal('show');
								} else {
									alert('You are trying to delete an request that it is closed.');
								}
                            }
                            else if( field === "close" && ( row.status === "Open" || row.status === "Unassigned" ) )
                            { 
                                $("#modal-close #titulo").text("Do you want to close request " + row.jobnumber + "?");
                                idrequest = row.idrequest;
								if (row.assignedto) {
									$('#modal-close').modal('show');
								} else {
									alert('You are trying to close a request that it is not assigned.');
								}
                            }
                        }
                    });
                    $('.blink').blink();
									
                });
                
                //var DATE = new Date();
				var DATE = new Date();
				//console.log('Dashboard time');
				//console.log(DATE);
				var options = {
					weekday: "long", year: "numeric", month: "short",
					day: "numeric", hour: "2-digit", minute: "2-digit"
				};
				$("#date").text(DATE.toLocaleTimeString("en-us", options));
				
				ion.sound(
                {
                    sounds: 
                    [
                        {
                            name: "beep",
                            loop: 30
                        }
                    ],
                    path: "sounds/",
                    preload: true,
                    volume: 1.0
                });

				playRadio = function() {
					ion.sound.play("beep");
					ion.sound.playing = true;
					audio = 0;
				}

				stopRadio = function() {
					ion.sound.stop("beep");
					ion.sound.playing = false;
					audio = 1;
				}
				
				$(".fa-volume-up").click(function () {
					if (audio === 0) {
						stopRadio();
					} else {
						playRadio();
					}
				});
				
                setInterval
                (
                    function()
                    {
						if (filter === 0)
                        {
							DATA = null;
							URL = "common/ws.php";
							call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
							{
								DATA = data;
								$('#table-dashboard').bootstrapTable('load', DATA);
								$('.blink').blink();
							});
						}
							var DATE = new Date();
							var options = {
								weekday: "long", year: "numeric", month: "short",
								day: "numeric", hour: "2-digit", minute: "2-digit"
							};
							$("#date").text(DATE.toLocaleTimeString("en-us", options));
							
						//}
                    }, 
                    10000
                );
				
				setInterval
                (
                    function()
                    {         

						iduser 	= $("#techId").val();					
                        URL     = "common/dashboard_totals.php";
						VALOR   = '';
						<?php 
						if ($profile=='TECH') {
						?>
							VALOR           = iduser;
						<?php
						}
						?>
                        //VALOR   = $("#techId").val();
                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                        {
                            COLORS = data;
                            $.each(COLORS, function(index)
                            {                        
                                //if (COLORS[index].colorflag === "R" && '<?php echo $profile;?>'!=='TECH' && '<?php echo $profile;?>'!=='TV')
								if (COLORS[index].colorflag === "R" && '<?php echo $profile;?>'==='PARTSP')
                                {
                                    if (COLORS[index].quantity !== 0 && audio === 0)
                                    {
                                        ion.sound.play("beep");
                                    }
                                }
                            
								//Totales del header
								if (COLORS[index].colorflag === "Y")
								{
									$("#yellow").text(" " + COLORS[index].quantity);
								}
								else if (COLORS[index].colorflag === "R")
								{
									$("#red").text(" " + COLORS[index].quantity);
								}
								else if (COLORS[index].colorflag === "G")
								{
									$("#green").text(" " + COLORS[index].quantity);
								}
						    });
                        }); 
                    }, 
                    10000
                );
				
			<?php 
			if ($profile=='TV') {
			?>
				setInterval
                (
                    function()
                    {
                        if (filter === 0)
                        {
                            URL = "common/ws.php";
                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                            {
                                dashboard_data = data;
                                $('#table-dashboard').bootstrapTable('load', dashboard_data);
                                $('.blink').blink();
                            });
                            
                            $("a:contains('›')").trigger("click")
                        }
                        
                    }, 
                    10000
                );
			<?php
			}
			?>
                
                iduser 	= $("#techId").val();					
				URL     = "common/dashboard_totals.php";
				VALOR   = '';
				<?php 
				if ($profile=='TECH') {
				?>
					VALOR           = iduser;
				<?php
				}
				?>
				//VALOR   = $("#techId").val();
                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                {
                    COLORS = data;
                    //console.log(COLORS);
                    
                    $.each(COLORS, function(index)
                    {                        
                        if (COLORS[index].colorflag === "Y")
                        {
                            $("#yellow").text(" " + COLORS[index].quantity);
                        }
                        else if (COLORS[index].colorflag === "R")
                        {
                            $("#red").text(" " + COLORS[index].quantity);
                        }
                        else if (COLORS[index].colorflag === "G")
                        {
                            $("#green").text(" " + COLORS[index].quantity);
                        }
                    });
                });
				
		$(function () 
                {
                    $('#datetimepickerStartDate').datetimepicker(
                    {
                        format: 'YYYY-MM-DD'
                    });
                    $('#datetimepickerEndDate').datetimepicker(
                    {
                        useCurrent: false,
                        format: 'YYYY-MM-DD'
                    });
                    
                    $("#datetimepickerStartDate").on("dp.change", function (e) 
                    {
                        $('#datetimepickerEndDate').data("DateTimePicker").minDate(e.date);
                    });
                    $("#datetimepickerEndDate").on("dp.change", function (e) 
                    {
                        $('#datetimepickerStartDate').data("DateTimePicker").maxDate(e.date);
                    });
                });
				
		//************************
		//*********** Ini Send Message
                $( "#linkToMyModalSendMessage" ).click(function() 
                {
                    $(".modal-body #selectName").val("");
                    $(".modal-body #comments").val("");
		   
		   var $radiomsg = $('input:radio[name="optradio"]');	

    		   if($radiomsg.is('checked') == false) {
        		$radiomsg.filter('[value=User]').prop('checked', true);
			$("#selectGroup").attr("style", "display: none"); 
    		   }

 		    //$("#myModalSendMessage #selectName").val("");
                    //$("#myModalSendMessage #comments").val("");
                    parts = [];
                    $('.modal-body #table-parts').bootstrapTable("destroy");
                    
                    $('.modal-body #table-parts').bootstrapTable
                    ({
                        data: parts,
                        striped: true,
                        columns: 
                        [
                            [
                                {
                                    field: 'seg',
                                    title: 'SEQ:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }, 
                                {
                                    field: 'parts',
                                    title: 'PARTS:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }, 
                                {
                                    field: 'description',
                                    title: 'DESCRIPTION:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }, 
                                {
                                    field: 'qty',
                                    title: 'QTY:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }, 
                                {
                                    field: 'ord',
                                    title: 'ORD:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                },
                                {
                                    field: 'delete',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value) 
                                    {
                                        return '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
                                    } 
                                }
                            ]
                        ],
                        onClickCell: function (field, value) 
                        {
                            if(field === "delete")
                            {
                                newParts = parts.filter(function(el)
                                {
                                    deletedParts.push(value);
                                    return el.delete !== value;
                                });
                                $('.modal-body #table-parts').bootstrapTable('load', newParts);
                                parts = newParts;
                            }
                        } 
                    });
                    
                    $('#myModalSendMessage').modal('show');
                });
			
		// Group or user send message option
		$('input:radio[name="optradio"]').change(function(){
			if ($(this).val() == "Group") {
				$("#selectSingle").attr("style", "display: none"); 
				$("#selectGroup").attr("style", "display: initial"); 
				
			}
			else
			{
				$("#selectGroup").attr("style", "display: none"); 
				$("#selectSingle").attr("style", "display: initial"); 
			}  
		});	
		

		$("#myModalSendMessage #buttonSendMessage").click(function()
                {                
				
					$('#myModalSendMessage #selectName').change(function(){
						$('#labelMessage').val('');
					});
					
					$('#myModalSendMessage #comments').change(function(){
						$('#labelMessage').val('');
					});
					
                    			if ($('#labelMessage').val() === null || $('#labelMessage').val() === '') {
						$('#labelMessage').val('');
					}
					
					
					// if option is group
					var msgto = null;
					if ($('input:radio[name="optradio"]:checked').val() == "Group") 
						{
						selectName 	= $("#myModalSendMessage #selectName").val();
						msgto = "Group";
						}
					else
						{
						selectName 	= $("#myModalSendMessage #selectNameU").val();
						msgto = "Single";
						}

					//console.log('Destinatarios '+ selectName);
					techName 	= '<?php echo $techName; ?>';
                    			comments    = $("#myModalSendMessage #comments").val();

					if ( (selectName === '' || selectName === null) || (comments === '' || comments === null)) {
						alert('Please complete the mandatory fields to continue...!\nAll fields marked with * are required.');
					} else {

						var recipient = []; //getSelectValues(el);
						if (msgto == "Group") {
							//console.log("Es un envío de grupo");
							var el = document.getElementsByTagName('select')[0];
		
							DATA 		= null;
							URL             = "common/getUsersGroup.php";
							VALOR           = selectName;
							//console.log('GROUP '+selectName);
	
							call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
							{
								//AQUI QUEDE
								DATA = data['USERS'];
								//console.log(DATA);
								//console.log(DATA[0]['fullname']);
								//selectName = DATA[0]['fullname'];
							});	
							recipient = DATA;
							//console.log('USUARIOS');
							//console.log(recipient);	
						} 
						else 
						{
							var destiny = new Object();
							destiny.fullname = selectName;
							//console.log("Es un envío sencillo");

							//cookie_value_add.push(recipient);
							recipient.push(destiny);
							//console.log(recipient);
						}
						
						// MULTIPLE MESSAGGES
						for (var j = 0; j < recipient.length; j++) {
							selectName = recipient[j]['fullname'];
							//console.log(selectName );
						DATA 		= null;
						URL             = "common/sendmessages.php";
						VALOR           = selectName + "|" + comments + "|" + techName;
						//console.log('VALOR '+ VALOR);

						call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
						{
							//$('#myModalSendMessage').modal('hide');
							DATA = data[0]['MENSAJE'];						
							$('#labelMessage').val(DATA);
							//alert(DATA);							

						});
						
						} //MULTIPLE MESSAGGES END

						//console.log(DATA);

						if ($('#labelMessage').val() === null || $('#labelMessage').val() === '') {
							//$('#labelMessage').val('Error sending message');
							alert('Error sending message. Please try again or contact the system administrator.');
						} else {
							alert('The message was sent successfully');
							$("#myModalSendMessage #selectName").val('');
							$("#myModalSendMessage #comments").val('');	
						}
						//**************FILTER DASHBOARD*******************
						if (filter === 0) {
							appuser		= $(".modal-body #techId").val();
							VALOR   	= '';
							<?php 
							if ($profile=='TECH') {
							?>
								VALOR 	= appuser;
							<?php
							}
							?>
							reloadDashboard(VALOR, 'common/ws.php');
						} else {
							iduser		= $("#modal-filter #techId").val();
							startdate	= $("#modal-filter #startdate").val();
							enddate		= $("#modal-filter #enddate").val();
							jobnumber	= $("#modal-filter #jobnumber").val();
							keyword		= $("#modal-filter #keyword").val();
							URL			= "common/dashboard_search.php";
							//DATA		= null;
							VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
							reloadDashboard(VALOR, 'common/dashboard_search.php');
						}
					}
                });
				//*********** Fin Send Message
				//************************

				//*********** priority requestType
                $( "#linkToMyModalPartsRequesition" ).click(function() 
                {
				if ( $(".modal-body #techid").val("")  === null || $(".modal-body #techid").val("") === "") {
				console.log('Your session expire');
				window.location.replace("http://reqparts.bdicalgary.com/BrandellDiesel/index.php");
				}

						$(".modal-body #requestType").removeAttr('checked');
						$(".modal-body #ro").val("");
						$(".modal-body #vin").val("");
						$(".modal-body #trans").val("");
						$(".modal-body #engine").val("");
						$(".modal-body #comments").val("");
						parts = [];
						$('.modal-body #table-parts').bootstrapTable("destroy");
						
						$('.modal-body #table-parts').bootstrapTable
						({
							data: parts,
							striped: true,
							columns: 
							[
								[
									{
										field: 'seg',
										title: '<font color="#009207">*</font> SEQ:',
										align: 'center',
										valign: 'middle',
										width: 1
									},
									{
										field: 'parts',
										title: '<font color="#009207">*</font> PARTS:',
										align: 'center',
										valign: 'middle',
										visible: false,
										width: 1
									}, 
									{
										field: 'description',
										title: '<font color="#009207">*</font> DESCRIPTION:',
										align: 'center',
										valign: 'middle',
										width: 1
									}, 
									{
										field: 'qty',
										title: '<font color="#009207">*</font> QTY:',
										align: 'center',
										valign: 'middle',
										width: 1
									}, 
									/*{
										field: 'ord',
										title: '<font color="#009207">*</font> ORD:',
										align: 'center',
										valign: 'middle',
										visible: false,
										width: 1
									},*/
									{
										field: 'delete',
										title: '',
										align: 'center',
										valign: 'middle',
										width: 1,
										clickToSelect: false,
										formatter : function(value) 
										{
											return '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
										} 
									}
								]
							],
							onClickCell: function (field, value) 
							{
								if(field === "delete")
								{
									newParts = parts.filter(function(el)
									{
										deletedParts.push(value);
										return el.delete !== value;
									});
									$('.modal-body #table-parts').bootstrapTable('load', newParts);
									parts = newParts;
								}
							} 
						});
						
						$('#myModalPartsRequesition').modal('show');
						rederizsoftHideLoad( '#partsRequesition', '#cargar_data_requesition' );
					});

					
					$("#myModalPartsRequesition #buttonSavePartsRequesition").click(function()
					{
						techName        = '<?php echo $techName; ?>';
						jobnumber       = $(".modal-body #ro").val();
						appuser         = $(".modal-body #techId").val();
									
						var $radiotype = $('.modal-body input:radio[name="requestType"]:checked');	
						idrequesttype = $radiotype.val();		
						

						idpriority   = "N";
						vPriority   = "Normal";							
						//console.log('idrequesttype'+idrequesttype);
						if(idrequesttype == "Q"){							
							vType   = "Quote";														
						} else {
							if(idrequesttype == "O"){
								idrequesttype = "O";
								vType   = "Order";
							}
							else
							{	
								idrequesttype = "O";
								vType   = "Order";
								idpriority   = "H";
								vPriority   = "911";							
							}
						}						
												
						ro              = $(".modal-body #ro").val();
						vin             = $(".modal-body #vin").val();
						trans           = $(".modal-body #trans").val();
						engine          = $(".modal-body #engine").val();
						comments        = $(".modal-body #comments").val();
						partsJSON   	= JSON.stringify(parts);
				// Required fields validations                   
				if (ro=='' || parts.length == 0  )
					{ 
						alert('Please complete the mandatory fields to continue...!\nAll fields marked with * are required.'); 
					}
					else						
					{ 
						
						DATA = null;
						URL             = "common/createParts.php";
						METODO          = "request_insert";
						VALOR           = jobnumber + "|" + appuser + "|" + idrequesttype + "|" + idpriority + "|" + ro + "|" + vin + "|" + trans + "|" + engine + "|" + comments;
						call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
							{
								DATA = data;
								if(DATA)
								{	
									idrequest   = DATA;
									rederizsoftReady('A','#partsRequesition', 'common/sendMail.php?vRo='+encodeURIComponent(ro)+'&vtechName='+encodeURIComponent(techName)+'&vPriority='+encodeURIComponent(vPriority)+'&vType='+encodeURIComponent(vType)+'&vVin='+encodeURIComponent(vin)+'&vComments='+encodeURIComponent(comments)+'&vpartsJSON='+encodeURIComponent(partsJSON)+'&vDate='+encodeURIComponent(moment(DATE).format("MMM DD YYYY, hh:mm:ss a"))+'&vEngine='+encodeURIComponent(engine)+'&vID='+encodeURIComponent(idrequest)+'&vStatus=', '#cargar_data_requesition', 'consultar');
									
									if(parts.length !== 0)
									{
										DATA        = null;
										METODO      = "request_parts_insert";
										partsJSON   = JSON.stringify(parts);
										VALOR       = idrequest + "|" + partsJSON + "|" + appuser;
										call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
										{
											DATA = data;
											if(DATA)
											{
												parts = [];
												$('.modal-body #table-parts').bootstrapTable('load', parts);
												$('#myModalPartsRequesition').modal('hide');
												//**************FILTER DASHBOARD*******************
												if (filter === 0) {
													appuser		= $(".modal-body #techId").val();
													VALOR   	= '';
													<?php 
													if ($profile=='TECH') {
													?>
														VALOR 	= appuser;
													<?php
													}
													?>
													reloadDashboard(VALOR, 'common/ws.php');
												} else {
													iduser		= $("#modal-filter #techId").val();
													startdate	= $("#modal-filter #startdate").val();
													enddate		= $("#modal-filter #enddate").val();
													jobnumber	= $("#modal-filter #jobnumber").val();
													keyword		= $("#modal-filter #keyword").val();
													URL			= "common/dashboard_search.php";
													DATA		= null;
													VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
													reloadDashboard(VALOR, 'common/dashboard_search.php');
												}
											}
										});  
									}
									else
									{
										$('#myModalPartsRequesition').modal('hide');
									}
								}
								else
								{
								}
							});
							
						//generatePDFreq(jobnumber, ro , appuser ,moment(DATE).format("MMM DD YYYY, hh:mm:ss a") ,comments,vidpriority, vidrequesttype, vin, parts);

						} // if required validation end					
					}); 
                
                $("#myModalPartsRequesition #buttonAddParts").click(function()
                {
				//UNIQUE
					var N = 8, uniquepart = (Math.random().toString(36)+'00000000000000000').slice(2, N+2);
					//console.log(uniquepart);
					$("#myModalPartsRequesition #parts").val(uniquepart);

					if ($("#myModalPartsRequesition #parts").val()=='' || $("#myModalPartsRequesition #seg").val()=='' || $("#myModalPartsRequesition #description").val()=='' || $("#myModalPartsRequesition #qty").val()=='') { 
						alert('Please complete the fields to continue...!\nAll fields marked with * are required.'); 
					} else {
						part = {seg:$("#myModalPartsRequesition #seg").val(), parts:uniquepart, description:$("#myModalPartsRequesition #description").val(), qty:$("#myModalPartsRequesition #qty").val(), ord:'0', delete:$("#myModalPartsRequesition #parts").val()};
						parts.push(part);
						$("#myModalPartsRequesition #table-parts").bootstrapTable('load', parts);
						$("#myModalPartsRequesition #parts").val("");
						$("#myModalPartsRequesition #seg").val("");
						$("#myModalPartsRequesition #description").val("");
						$("#myModalPartsRequesition #qty").val("");
					}
                }); 
                
                $("#modal-edit #buttonAddParts").click(function()
                {
				//UNIQUE
					var N = 8, uniquepart = (Math.random().toString(36)+'00000000000000000').slice(2, N+2);
					//console.log(uniquepart);
					$("#modal-edit #parts").val(uniquepart);

					if ($("#modal-edit #parts").val()=='' || $("#modal-edit #description").val()=='' || $("#modal-edit #qty").val()=='') { 
						alert('Please complete the fields to continue...!\nAll fields marked with * are required.'); 
					} else {
						newPart = {idrequest: uniquepart, seg:$("#modal-edit #seg").val(), part:$("#modal-edit #parts").val(), description:$("#modal-edit #description").val(), quantity:$("#modal-edit #qty").val(), ord:'0', edit:$("#modal-edit #idRequest").val() + "|" + $("#modal-edit #parts").val(), delete:$("#modal-edit #idRequest").val() + "|" + $("#modal-edit #parts").val()};
						parts.push(newPart);
						$('#modal-edit #table-parts').bootstrapTable('load', parts);
						$("#modal-edit #seg").val("");
						$("#modal-edit #parts").val("");
						$("#modal-edit #description").val("");
						$("#modal-edit #qty").val("");
						$("#modal-edit #ord").val("");
					}
                }); 
                
                $("#buttonDeletePartsRequesition").click(function()
                {
                    appuser         = $(".modal-body #techId").val();
                    URL             = "common/deleteParts.php";
                    DATA            = null;
                    METODO          = "request_delete";
                    VALOR           = idrequest + "|" + appuser;
                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                    {
                        $('#modal-delete').modal('hide');
						//**************FILTER DASHBOARD*******************
						if (filter === 0) {
							appuser		= $(".modal-body #techId").val();
							VALOR   	= '';
							<?php 
							if ($profile=='TECH') {
							?>
								VALOR 	= appuser;
							<?php
							}
							?>
							reloadDashboard(VALOR, 'common/ws.php');
						} else {
							iduser		= $("#modal-filter #techId").val();
							startdate	= $("#modal-filter #startdate").val();
							enddate		= $("#modal-filter #enddate").val();
							jobnumber	= $("#modal-filter #jobnumber").val();
							keyword		= $("#modal-filter #keyword").val();
							URL			= "common/dashboard_search.php";
							DATA		= null;
							VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
							reloadDashboard(VALOR, 'common/dashboard_search.php');
						}
						
						URL     = "common/dashboard_totals.php";
				        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
						{
							COLORS = data;
							$.each(COLORS, function(index)
							{                        
								if (COLORS[index].colorflag === "Y")
								{
									$("#yellow").text(" " + COLORS[index].quantity);
								}
								else if (COLORS[index].colorflag === "R")
								{
									$("#red").text(" " + COLORS[index].quantity);
								}
								else if (COLORS[index].colorflag === "G")
								{
									$("#green").text(" " + COLORS[index].quantity);
								}
						    });
						});
                    });   
                }); 
				
				$("#buttonCancelEdit").click(function()
                {
                    $("#modal-edit #buttonSavePart").css("display", "none");
                    $("#modal-edit #buttonCancelEdit").css("display", "none");
                    $("#modal-edit #buttonAddParts").css("display", "block");
                });
				
				
				// Modal EDIT Button SAVE
				$("#modal-edit #buttonSave").click(function()
                {
                    techName       	= $("#modal-edit #techName").val();
					idrequest       = $("#modal-edit #idRequest").val();
                    jobnumber       = $("#modal-edit #ro").val();
                    appuser         = $("#modal-edit #techId").val();

					var $radiotype = $('#modal-edit input:radio[name="requestType"]:checked');	
					idrequesttype = $radiotype.val();		
					console.log('idrequesttype '+idrequesttype);	
					idpriority   = "N";
					vPriority   = "Normal";						
				
					
					if(idrequesttype == "Q"){							
						vType   = "Quote";														
					} else {
						if(idrequesttype == "O"){
							idrequesttype = "O";
							vType   = "Order";
						}
						else
						{	
							idrequesttype = "O";
							vType   = "Order";
							idpriority   = "H";
							vPriority   = "911";							
						}
					}
					                    
                    ro              = $("#modal-edit #ro").val();
                    vin             = $("#modal-edit #vin").val();
                    trans           = $("#modal-edit #trans").val();
                    engine          = $("#modal-edit #engine").val();
                    comments        = $("#modal-edit #comments").val();
                    
                    DATA            = null;
                    
                    URL             = "common/editParts.php";
                    partsJSON   = JSON.stringify(parts);
					//console.log('idrequesttype '+idrequesttype);
					//console.log('vType '+ vType);
					//console.log('common/sendMail.php?vRo='+encodeURIComponent(ro)+'&vtechName='+encodeURIComponent(techName)+'&vPriority='+encodeURIComponent(vPriority)+'&vType='+encodeURIComponent(vType)+'&vVin='+encodeURIComponent(vin)+'&vComments='+encodeURIComponent(comments)+'&vpartsJSON='+encodeURIComponent(partsJSON)+'&vDate='+encodeURIComponent(moment(DATE).format("MMM DD YYYY, hh:mm:ss a"))+'&vEngine='+encodeURIComponent(engine)+'&vID='+encodeURIComponent(idrequest)+'&vStatus=');
					rederizsoftReady('A','#partsRequesition', 'common/sendMail.php?vRo='+encodeURIComponent(ro)+'&vtechName='+encodeURIComponent(techName)+'&vPriority='+encodeURIComponent(vPriority)+'&vType='+encodeURIComponent(vType)+'&vVin='+encodeURIComponent(vin)+'&vComments='+encodeURIComponent(comments)+'&vpartsJSON='+encodeURIComponent(partsJSON)+'&vDate='+encodeURIComponent(moment(DATE).format("MMM DD YYYY, hh:mm:ss a"))+'&vEngine='+encodeURIComponent(engine)+'&vID='+encodeURIComponent(idrequest)+'&vStatus=', '#cargar_data_edit', 'consultar');
					//generatePDFreq(idrequest,ro, appuser, moment(DATE).format("MMM DD YYYY hh:mm:ss a") ,comments, vPriority, vType, vin, parts);
                    METODO          = partsJSON;
                    VALOR           = idrequest + "|" + jobnumber + "|" + appuser + "|" + idrequesttype + "|" + idpriority + "|" + ro + "|" + vin + "|" + trans + "|" + engine + "|" + comments;
                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                    {
                        DATA = data;
                        //console.log(parts);
                        $('#modal-edit').modal('hide');
						//**************FILTER DASHBOARD*******************
						if (filter === 0) {
							appuser		= $(".modal-body #techId").val();
							VALOR   	= '';
							<?php 
							if ($profile=='TECH') {
							?>
								VALOR 	= appuser;
							<?php
							}
							?>
							reloadDashboard(VALOR, 'common/ws.php');
						} else {
							iduser		= $("#modal-filter #techId").val();
							startdate	= $("#modal-filter #startdate").val();
							enddate		= $("#modal-filter #enddate").val();
							jobnumber	= $("#modal-filter #jobnumber").val();
							keyword		= $("#modal-filter #keyword").val();
							URL		= "common/dashboard_search.php";
							DATA		= null;
							VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
							reloadDashboard(VALOR, 'common/dashboard_search.php');
						}
                    });   
                }); 
				
                $("#buttonCLosePartsRequesition").click(function()
                {
					appuser         = $("#modal-close #techId").val();
                    URL             = "common/closeRequest.php";
                    DATA            = null;
                    VALOR           = idrequest + "|" + appuser;
                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                    {
                        $('#modal-close').modal('hide');
						//**************FILTER DASHBOARD*******************
						if (filter === 0) {
							appuser		= $(".modal-body #techId").val();
							VALOR   	= '';
							<?php 
							if ($profile=='TECH') {
							?>
								VALOR 	= appuser;
							<?php
							}
							?>
							reloadDashboard(VALOR, 'common/ws.php');
						} else {
							iduser		= $("#modal-filter #techId").val();
							startdate	= $("#modal-filter #startdate").val();
							enddate		= $("#modal-filter #enddate").val();
							jobnumber	= $("#modal-filter #jobnumber").val();
							keyword		= $("#modal-filter #keyword").val();
							URL			= "common/dashboard_search.php";
							DATA		= null;
							VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
							reloadDashboard(VALOR, 'common/dashboard_search.php');
						}
						/*
                        filter = 0;
						URL = "common/ws.php";
						VALOR   = '';
						<?php 
						if ($profile=='TECH') {
						?>
							VALOR 	= appuser;
						<?php
						}
						?>
                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                        {
                            DATA = data;
                            $('#table-dashboard').bootstrapTable('load', DATA);
                        });
						*/
                    });   
                }); 
                
                $("#buttonAssignPartsRequesition").click(function()
                {
                    appuser         = $("#modal-assign #techId").val();
                    //idspecialist    = $("#modal-assign #techId").val();
                    URL             = "common/assignRequest.php";
                    DATA            = null;
                    VALOR           = idrequest + "|" + idspecialist + "|" + appuser;
                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                    {
                        $('#modal-assign').modal('hide');
						//**************FILTER DASHBOARD*******************
						if (filter === 0) {
							appuser		= $(".modal-body #techId").val();
							VALOR   	= '';
							<?php 
							if ($profile=='TECH') {
							?>
								VALOR 	= appuser;
							<?php
							}
							?>
							reloadDashboard(VALOR, 'common/ws.php');
						} else {
							iduser		= $("#modal-filter #techId").val();
							startdate	= $("#modal-filter #startdate").val();
							enddate		= $("#modal-filter #enddate").val();
							jobnumber	= $("#modal-filter #jobnumber").val();
							keyword		= $("#modal-filter #keyword").val();
							URL			= "common/dashboard_search.php";
							DATA		= null;
							VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
							reloadDashboard(VALOR, 'common/dashboard_search.php');
						}
						/*
						appuser         = $("#modal-assign #techId").val();
						VALOR   = '';
						<?php 
						if ($profile=='TECH') {
						?>
							VALOR 	= appuser;
						<?php
						}
						?>
                        URL = "common/ws.php";
                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                        {
                            DATA = data;
                            $('#table-dashboard').bootstrapTable('load', DATA);
                        });
						*/
                    });   
                }); 
				$("#filter").click(function()
                {
                    $('#modal-filter').modal('show');
                });

                $("#buttonAssignPartsRequesitionSp").click(function()
                {
				//Assign PARTSP begin
				//alert('PARTSP begin');
				appuser         = '<?php echo $techId; ?>';
				idspecialist    = '<?php echo $techId; ?>';
				idrequest = $("#modal-assignsp #idRequest").val();
				URL             = "common/assignRequest.php";
				DATA            = null;
				VALOR           = idrequest + "|" + idspecialist + "|" + appuser;
				$('#modal-assignsp').modal('hide');

				call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
						{
						VALOR   = '';
						<?php 
						if ($profile=='TECH') {
						?>
						VALOR 	= appuser;
						<?php
						}
						?>						
						URL = "common/ws.php";
						call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
							{
								DATA = data;
								$('#table-dashboard').bootstrapTable('load', DATA);
							});
						});

				// Assign PARTSP end

                    
                });
                
                $("#modal-filter #buttonApplyFilter").click(function()
                {
                    iduser          = $("#modal-filter #techId").val();
					//nameuser        = '$("#modal-filter #techName").val();';
                    startdate       = $("#modal-filter #startdate").val();
                    enddate         = $("#modal-filter #enddate").val();
                    jobnumber       = $("#modal-filter #jobnumber").val();
					keyword       	= $("#modal-filter #keyword").val();
                    URL             = "common/dashboard_search.php";
                    DATA            = null;
                    VALOR           = iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                    {
                        filter = 1;
                        dashboard_data = data;
                        $('#table-dashboard').bootstrapTable('load', dashboard_data);
                        $('#modal-filter').modal('hide');
                        $('.blink').blink();
                    }); 				
                });
				
				$("#custom-toolbar #buttonApplyFilter").click(function()
                {
					VALOR   		= '';
					<?php 
					if ($profile=='TECH') {
					?>
						VALOR 		= '<?php echo $techId; ?>';
					<?php
					}
					?>
                    iduser          = VALOR;
					//nameuser      = '';
                    startdate       = '';
                    enddate         = '';
                    jobnumber       = '';
					keyword       	= '';
                    //URL             = "common/dashboard_search.php";
					URL             = "common/ws.php";
                    DATA            = null;
                    //VALOR           = iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
					VALOR           = iduser;
                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                    {
                        filter = 0;	
                        dashboard_data = data;
                        $('#table-dashboard').bootstrapTable('load', dashboard_data);
                        $('#modal-filter').modal('hide');
                        $('.blink').blink();
                    });	
					//$("#modal-filter #techName").val('<?php echo $techName ?>');
					$("#modal-filter #techId").val('<?php echo $techName ?>');
                    $("#modal-filter #startdate").val('');
                    $("#modal-filter #enddate").val('');
                    $("#modal-filter #jobnumber").val('');
					$("#modal-filter #keyword").val('');					
                });

		// Admin Groups
		$( "#adminGroups" ).click(function() 
                	{
			DATA 		= null;
			URL             = "common/getGroups.php";
			VALOR           = null;

			call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
				{
				groups = data['GROUPS']
				});	

			$('#modal-adminGroups #table-GroupsDashboard').bootstrapTable  
                        ({
                            data: groups,
                            striped: true,
                            columns: 
                            [
                                [
                                    {
                                        field: 'idgroup',
                                        title: '<font color="#009207">*</font> Id Group:',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1
                                    },
                                    {
                                        field: 'name',
                                        title: 'Name:',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1
                                    },
                                    /*{
                                        field: 'edit',
                                        title: '',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1,
                                        clickToSelect: false,
                                        formatter : function(value) 
                                        {
                                            return '<a class=""><span class="fa fa-pencil" aria-hidden="true"></span></a>';
                                        } 
                                    },*/
                                    {
                                        field: 'delete',
                                        title: '',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1,
                                        clickToSelect: false,
                                        formatter : function(value) 
                                        {
                                            return '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
                                        } 
                                    }
                                ]
                            ],
                            onClickCell: function (field, value, row) 
                            {
				if(field === "delete")
                                {   
					$('#modal-delgroup').modal('show');
					$("#modal-delgroup #titulo").text("Do you want to delete group " + row.name + "?");
					$("#modal-delgroup #techId").val('<?php echo $techId; ?>');
					$("#modal-delgroup #idgroup").val(row.idgroup);

					$("#modal-delgroup #buttonDeleteGroup").click(function()
							{
								idgroup      = $("#modal-delgroup #idgroup").val();
								appuser     = $("#modal-delgroup #techId").val();
								URL         = "common/group_delete.php";
								VALOR       = idgroup + "|" + appuser;
								//console.log(VALOR);

								call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
									{
										URL         = "common/getGroups.php";
										VALOR       = null;

										call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
											{
											groups = data['GROUPS'];
											$('#modal-adminGroups #table-GroupsDashboard').bootstrapTable('load', groups);
											}); 

									});
								  $('#modal-delgroup').modal('hide');	

					} ); /* Delete group end */

				}
			    }

			});


			$('#modal-adminGroups').modal('show');

			}

		);


                $("#modal-adminGroups #buttonAddGroup").click(function()
                {
                    idgroup      = $("#modal-adminGroups #name").val();
                    name     	= $("#modal-adminGroups #name").val();
                    appuser     = $("#modal-adminGroups #techId").val();

                    URL         = "common/group_insert.php";
                    METODO      = "";
                    VALOR       = idgroup + "|" + name + "|" + appuser;

                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                    {  
                        DATA = data;
                        if (DATA[0].RESULTADO === "0000")
                        {	
				DATA 		= null;
				URL         = "common/getGroups.php";
				VALOR       = null;

                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                            {
                               	groups = data['GROUPS']
				//console.log (groups);
                                $('#modal-adminGroups #table-GroupsDashboard').bootstrapTable('load', groups);
                                $("#modal-adminGroups #idGroup").val("");
                                $("#modal-adminGroups #name").val("");
				alert ('The group was successfully created');


                            });  
                        }
                        else
                        {
                            alert("Error trying to save the group. Please check the group information and try againg.");
                                $('#modal-adminGroups #table-groupsDashboard').bootstrapTable('load', groups);
                                $("#modal-adminGroups #idGroup").val("");
                                $("#modal-adminGroups #name").val("");
                        }
						//**************FILTER DASHBOARD*******************
						if (filter === 0) {
							appuser		= $(".modal-body #techId").val();
							VALOR   	= '';
							<?php 
							if ($profile=='TECH') {
							?>
								VALOR 	= appuser;
							<?php
							}
							?>
							reloadDashboard(VALOR, 'common/ws.php');
						} else {
							iduser		= $("#modal-filter #techId").val();
							startdate	= $("#modal-filter #startdate").val();
							enddate		= $("#modal-filter #enddate").val();
							jobnumber	= $("#modal-filter #jobnumber").val();
							keyword		= $("#modal-filter #keyword").val();
							URL			= "common/dashboard_search.php";
							DATA		= null;
							VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
							reloadDashboard(VALOR, 'common/dashboard_search.php');
						}
						
                    });  
                });





		// Admin Users
		$( "#adminUsers" ).click(function() 
                {
                    $('#modal-adminUsers #table-userDashboard').bootstrapTable("destroy");
                    
                    idusertype  = "";
                    rol         = "";
                    status      = "A";
					phoneNum 	= "%";
                    URL         = "common/users_list.php";
                    VALOR       = idusertype + "|" + rol + "|" + status + "|" + phoneNum;
                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                    {
                        users = data;
						//console.log(users);
                        
                        $('#modal-adminUsers #table-userDashboard').bootstrapTable
                        ({
                            data: users,
                            striped: true,
                            columns: 
                            [
                                [
                                    {
                                        field: 'iduser',
                                        title: '<font color="#009207">*</font> Id User:',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1
                                    },
                                    {
                                        field: 'surname',
                                        title: 'Name:',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1
                                    },
                                    {
                                        field: 'lastname',
                                        title: 'Last Name:',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1
                                    }/*, 
                                    {
                                        field: 'password',
                                        title: 'Password:',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1
                                    }*/, 
                                    {
                                        field: 'idusertype',
                                        title: 'Type:',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1
                                    }, 
                                    {
                                        field: 'status',
                                        title: 'Status:',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1
                                    },
                                    {
                                        field: 'rol',
                                        title: 'Rol:',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1
                                    },
                                    {
                                        field: 'rolname',
                                        title: 'Rol Name:',
                                        align: 'center',
                                        valign: 'middle',
										visible: false,
                                        width: 1
                                    },
                                    /*{
                                        field: 'idgroup',
                                        title: 'Msg group:',
                                        align: 'center',
                                        valign: 'middle',
										visible: false,
                                        width: 1
                                    },
                                    {
                                        field: 'groupname',
                                        title: 'Msg group:',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1
                                    },*/
									{
										field: 'groups',
                                        title: 'Groups:',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1,
										formatter: function(data2)
										{
											var obj = JSON.parse(data2)
											var lgroups = "";
											if (obj == null)
												obj = "";
											for (i in obj)
												{
												  lgroups = lgroups + obj[i].name + "<br />";
												}
											return lgroups;											
										}
									},
                                    {
                                        field: 'edit',
                                        title: '',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1,
                                        clickToSelect: false,
                                        formatter : function(value) 
                                        {
                                            return '<a class=""><span class="fa fa-pencil" aria-hidden="true"></span></a>';
                                        } 
                                    },
                                    {
                                        field: 'delete',
                                        title: '',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1,
                                        clickToSelect: false,
                                        formatter : function(value) 
                                        {
                                            return '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
                                        } 
                                    }
                                ]
                            ],
                            onClickCell: function (field, value, row) 
                            {
                                if(field === "edit")
                                {
									$("#modal-adminUsers #idUser").attr('disabled',true);
									URL         = "common/lookupUsertype.php";
                                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                                    {
                                        userTypes = data;
                                        $("#modal-adminUsers #idUserType").empty();
                                        var optionsUserTypes = $("#modal-adminUsers #idUserType");
                                        $.each(userTypes, function() 
                                        {
                                            optionsUserTypes.append($("<option />").val(this.idusertype).text(this.typename));											
                                        });
                                        
                                        URL         = "common/lookupUserrol.php";
                                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                                        {
                                            userRoles = data;
                                            $("#modal-adminUsers #idRol").empty();
                                            var optionsUserTypes = $("#modal-adminUsers #idRol");
                                            $.each(userRoles, function() 
                                            {
                                                optionsUserTypes.append($("<option />").val(this.idrol).text(this.name));
                                            });
                                            
                                            $("#modal-adminUsers #idUserType").val(row.idusertype);
                                            $("#modal-adminUsers #idRol").val(row.rol);

                                        });

										// Loading group list

										URL             = "common/getGroups.php";
										VALOR           = null;
										call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
										{
											groups = data['GROUPS'];
											$("#modal-adminUsers #idGroup").empty();
											var optionsGroups = $("#modal-adminUsers #idGroup");
											optionsGroups.append($("<option />").val("").text("-- None selected --"));
											$.each(groups, function() 
											{
												optionsGroups.append($("<option />").val(this.idgroup).text(this.name));	
											
											});

											// ID: Get current group
											var obje = JSON.parse(row.groups);
											var egroups = "";
											if (obje == null)
												obje = "";
											var egroups = new Array();
											for (i in obje)
											{
												egroups.push(obje[i].idgroup);
											}
												optionsGroups.val(egroups);		
											// ID: END
										}); 
                                    });
									
                                    $("#modal-adminUsers #idUser").val(row.iduser);
                                    $("#modal-adminUsers #surName").val(row.surname);
                                    $("#modal-adminUsers #lastName").val(row.lastname);
                                    $("#modal-adminUsers #password").val(row.password);
                                    $("#modal-adminUsers #idUserType").val(row.idusertype);
                                    $("#modal-adminUsers #idRol").val(row.rol);
									$("#modal-adminUsers #phonenum").val(row.phonenum);
									//$("#modal-adminUsers #idGroup").val(row.idgroup);
                                    //appuser     = $("#modal-adminUsers #techId").val();
									
                                    $("#modal-adminUsers #buttonAddUser").css("display", "none");
                                    $("#modal-adminUsers #buttonEditUser").css("display", "block");
                                    $("#modal-adminUsers #buttonCancelEdit").css("display", "block");

                                }
                                else if(field === "delete")
                                {
   
									$('#modal-deluser').modal('show');
									$("#modal-deluser #titulo").text("Do you want to delete user " + row.iduser + "?");
									$("#modal-deluser #techId").val(row.iduser);
									$("#modal-deluser #iduser").val(row.iduser);
												
									
									$("#modal-deluser #buttonDeleteUser").click(function()
									{
											iduser      = $("#modal-deluser #iduser").val();
											appuser     = $("#modal-deluser #techId").val();
											URL         = "common/users_delete.php";
											VALOR       = iduser + "|" + appuser;

											call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
											{
												idusertype  = "";
												rol         = "";
												status      = "A";
												phoneNum 	= "%";
												URL         = "common/users_list.php";
												VALOR       = idusertype + "|" + rol + "|" + status + "|" + phoneNum;

												call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
												{
													users = data;
													$('#modal-adminUsers #table-userDashboard').bootstrapTable('load', users);
												}); 

											});
									  $('#modal-deluser').modal('hide');	

									} ); /* Delete user end */
                                }
                            } 
                        });
                    });
					
					URL         = "common/lookupUsertype.php";
					call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
					{
						userTypes = data;
						//console.log(userTypes);
						$("#modal-adminUsers #idUserType").empty();
						var optionsUserTypes = $("#modal-adminUsers #idUserType");
						$.each(userTypes, function() 
						{
							optionsUserTypes.append($("<option />").val(this.idusertype).text(this.typename));
						});
						
						
						URL         = "common/lookupUserrol.php";
						call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
						{
							userRoles = data;
							//console.log(userRoles);
							$("#modal-adminUsers #idRol").empty();
							var optionsUserTypes = $("#modal-adminUsers #idRol");
							$.each(userRoles, function() 
							{
								optionsUserTypes.append($("<option />").val(this.idrol).text(this.name));
							});
						});

					// Loading group list

						DATA 		= null;
						URL             = "common/getGroups.php";
						VALOR           = null;
						call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
							{
							groups = data['GROUPS'];
							//console.log(groups);
							$("#modal-adminUsers #idGroup").empty();
							var optionsGroups = $("#modal-adminUsers #idGroup");
							optionsGroups.append($("<option />").val("").text("-- None selected --"));
							$.each(groups, function() 
							{
								optionsGroups.append($("<option />").val(this.idgroup).text(this.name));
							});
							optionsGroups.val("");
						}); 
					}); 

                    $('#modal-adminUsers').modal('show');
					//**************FILTER DASHBOARD*******************
					if (filter === 0) {
						appuser		= $(".modal-body #techId").val();
						VALOR   	= '';
						<?php 
						if ($profile=='TECH') {
						?>
							VALOR 	= appuser;
						<?php
						}
						?>
						reloadDashboard(VALOR, 'common/ws.php');
					} else {
						iduser		= $("#modal-filter #techId").val();
						startdate	= $("#modal-filter #startdate").val();
						enddate		= $("#modal-filter #enddate").val();
						jobnumber	= $("#modal-filter #jobnumber").val();
						keyword		= $("#modal-filter #keyword").val();
						URL			= "common/dashboard_search.php";
						DATA		= null;
						VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
						reloadDashboard(VALOR, 'common/dashboard_search.php');
					}

                });
                
                $("#modal-adminUsers #buttonAddUser").click(function()
                {
                    iduser      = $("#modal-adminUsers #idUser").val();
                    surname     = $("#modal-adminUsers #surName").val();
                    lastname    = $("#modal-adminUsers #lastName").val();
                    password    = $("#modal-adminUsers #password").val();
                    idusertype  = $("#modal-adminUsers #idUserType").val();
                    appuser     = $("#modal-adminUsers #techId").val();
                    idrol       = $("#modal-adminUsers #idRol").val();
					phonenum    = $("#modal-adminUsers #phonenum").val();

					// ID 2017-09-05 Multiple Groups ADD
					var groups = $('select#idGroup').val(); 

					if (phonenum == "" && groups != "" && groups != undefined) {
						alert('To be a part of a group, you must have phone number.');
					}
					else
					{	
						URL         = "common/users_insert.php";
						METODO      = "";
						VALOR       = iduser + "|" + surname + "|" + lastname + "|" + password + "|" + idusertype + "|" + appuser + "|" + idrol  + "|" + phonenum + "|" + groups;
						call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
						{  
							DATA = data;
							if (DATA[0].RESULTADO === "0000")
							{
								idusertype  = "";
								rol         = "";
								status      = "A";
								phoneNum 	= "%";
								URL         = "common/users_list.php";
								VALOR       = idusertype + "|" + rol + "|" + status + "|" + phoneNum;

								call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
								{
									users = data;
									$('#modal-adminUsers #table-userDashboard').bootstrapTable('load', users);
									$("#modal-adminUsers #idUser").val("");
									$("#modal-adminUsers #surName").val("");
									$("#modal-adminUsers #lastName").val("");
									$("#modal-adminUsers #password").val("");
									$("#modal-adminUsers #idUserType").val("");
									//$("#modal-adminUsers #techId").val("");
									$("#modal-adminUsers #idRol").val("");
									$("#modal-adminUsers #phonenum").val("");
									$("#modal-adminUsers #idGroup").val("");
								});  
								
								alert("The user was successfully created.");
							}
							else
							{
								alert("Error trying to save the user. Please check the user information and try againg.");
								
								$("#modal-adminUsers #idUser").val("");
								$("#modal-adminUsers #surName").val("");
								$("#modal-adminUsers #lastName").val("");
								$("#modal-adminUsers #password").val("");
								$("#modal-adminUsers #idUserType").val("");
								//$("#modal-adminUsers #techId").val("");
								$("#modal-adminUsers #idRol").val("");
								$("#modal-adminUsers #phonenum").val("");
								$("#modal-adminUsers #idGroup").val("");
							}
							//**************FILTER DASHBOARD*******************
							if (filter === 0) {
								appuser		= $(".modal-body #techId").val();
								VALOR   	= '';
								<?php 
								if ($profile=='TECH') {
								?>
									VALOR 	= appuser;
								<?php
								}
								?>
								reloadDashboard(VALOR, 'common/ws.php');
							} else {
								iduser		= $("#modal-filter #techId").val();
								startdate	= $("#modal-filter #startdate").val();
								enddate		= $("#modal-filter #enddate").val();
								jobnumber	= $("#modal-filter #jobnumber").val();
								keyword		= $("#modal-filter #keyword").val();
								URL			= "common/dashboard_search.php";
								DATA		= null;
								VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
								reloadDashboard(VALOR, 'common/dashboard_search.php');
							}
				
						});  
					}
                });
                
                $("#modal-adminUsers #buttonCancelEdit").click(function()
                {
                    $("#modal-adminUsers #buttonAddUser").css("display", "block");
                    $("#modal-adminUsers #buttonEditUser").css("display", "none");
                    $("#modal-adminUsers #buttonCancelEdit").css("display", "none");
					$("#modal-adminUsers #idUser").attr('disabled',false);
                    
                    $("#modal-adminUsers #idUser").val("");
                    $("#modal-adminUsers #surName").val("");
                    $("#modal-adminUsers #lastName").val("");
                    $("#modal-adminUsers #password").val("");
                    $("#modal-adminUsers #idUserType").val("");
                    //$("#modal-adminUsers #techId").val("");
                    $("#modal-adminUsers #idRol").val("");
					$("#modal-adminUsers #phonenum").val("");
					$("#modal-adminUsers #idGroup").val("");
                });
                
                $("#modal-adminUsers #buttonEditUser").click(function()
                {
                    iduser      = $("#modal-adminUsers #idUser").val();
                    surname     = $("#modal-adminUsers #surName").val();
                    lastname    = $("#modal-adminUsers #lastName").val();
                    password    = $("#modal-adminUsers #password").val();
                    idusertype  = $("#modal-adminUsers #idUserType").val();
                    appuser     = $("#modal-adminUsers #techId").val();
                    idrol       = $("#modal-adminUsers #idRol").val();
					phonenum    = $("#modal-adminUsers #phonenum").val();
					idgroup		= $("#modal-adminUsers #idGroup").val();
					
					// ID 2017-09-05 Multiple Groups ADD
					var groups = $('select#idGroup').val(); 
                    URL         = "common/users_update.php";
                    METODO      = "";
                    VALOR       = iduser + "|" + surname + "|" + lastname + "|" + password + "|" + idusertype + "|" + appuser + "|" + idrol + "|" + phonenum + "|" + idgroup;

					if (phonenum == "" && groups != "" && groups != undefined) {
						alert('To be a part of a group, you must have phone number.');
					}
					else
					{
					call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                    {  
                        DATA = data;
                        if (DATA[0].RESULTADO === "0000")
                        {
                            idusertype  = "";
							rol         = "";
							status      = "A";
							phoneNum 	= "%";
							URL         = "common/users_list.php";
							VALOR       = idusertype + "|" + rol + "|" + status + "|" + phoneNum;

                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                            {
                                users = data;
                                $('#modal-adminUsers #table-userDashboard').bootstrapTable('load', users);
                                $("#modal-adminUsers #idUser").val("");
                                $("#modal-adminUsers #surName").val("");
                                $("#modal-adminUsers #lastName").val("");
                                $("#modal-adminUsers #password").val("");
                                $("#modal-adminUsers #idUserType").val("");
                                //$("#modal-adminUsers #techId").val("");
                                $("#modal-adminUsers #idRol").val("");
								$("#modal-adminUsers #phonenum").val("");
								$("#modal-adminUsers #idGroup").val("");
                                
                                $("#modal-adminUsers #buttonAddUser").css("display", "block");
                                $("#modal-adminUsers #buttonEditUser").css("display", "none");
                                $("#modal-adminUsers #buttonCancelEdit").css("display", "none");
                            });  
                        }
                        else
                        {
                            alert("Error trying to save the user. Please check the user information and try againg.");
			}

						//**************FILTER DASHBOARD*******************
						if (filter === 0) {
							appuser		= $(".modal-body #techId").val();
							VALOR   	= '';
							<?php 
							if ($profile=='TECH') {
							?>
								VALOR 	= appuser;
							<?php
							}
							?>
							reloadDashboard(VALOR, 'common/ws.php');
						} else {
							iduser		= $("#modal-filter #techId").val();
							startdate	= $("#modal-filter #startdate").val();
							enddate		= $("#modal-filter #enddate").val();
							jobnumber	= $("#modal-filter #jobnumber").val();
							keyword		= $("#modal-filter #keyword").val();
							URL			= "common/dashboard_search.php";
							DATA		= null;
							VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
							reloadDashboard(VALOR, 'common/dashboard_search.php');
						}
						$("#modal-adminUsers #idUser").attr('disabled',false);
						
	                    });  
			}
                });
				
				$(document).on('click', '#specialist li a', function (e) 
				{
					idspecialist = $(this).attr('data-iduser');
					$("#modal-assign #titulo").text("Do you want to assign the request to " + $(this).attr('data-fullname') + "? ");
					$("#modal-assign #buttonAssignPartsRequesition").prop('disabled', false);
					e.preventDefault();
				});  
				
            });			
			
			function reloadDashboard(paramVALOR, paramUrl) {
				URL 	= paramUrl;
				DATA 	= null;
				VALOR 	= paramVALOR;
				iduser =  '<?php echo $techId; ?>';

				if ( iduser  === null||iduser === "") {
					//console.log('Your session expire');
					window.location.replace("http://reqparts.bdicalgary.com/BrandellDiesel/index.php");
				}
				else
				{ 
					//console.log ('Reload iduser:'|| iduser );
					call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
					{
					dashboard_data = data;
					$('#table-dashboard').bootstrapTable('load', dashboard_data);
					});
				}
			}
			
			function sleep(milliseconds) {
			  var start = new Date().getTime();
			  for (var i = 0; i < 1e7; i++) {
				if ((new Date().getTime() - start) > milliseconds){
				  break;
				}
			  }
			}

			function sendPDF () 
			       {
                    techName       	= $("#modal-view #view-techname").text();
					idrequest       = $("#modal-view #idRequest").val();
                    jobnumber       = $("#modal-view #view-ro").text();
                    appuser         = $("#modal-view #techId").val();
					//console.log('idreuqest: '+idrequest)
                   
					if($("#modal-view #requestType").is(':checked')){
                        idrequesttype   = "Q";
						vType = "Quote";
                    } else {
                        idrequesttype   = "O";
						vType = "Order";
                    }
                    
                    if($("#modal-view #priority").is(':checked')){
                        idpriority   = "H";
						vPriority = "911";
                     } else {
                        idpriority   = "N";
						vPriority = "Normal";
                    }
                    
                    ro              = $("#modal-view #view-ro").text();
                    vin             = $("#modal-view #view-vin").text();
                    trans           = $("#modal-view #view-trans").text();
                    engine          = $("#modal-view #view-engine").text();
                    comments        = $("#modal-view #view-comments").text();
					requestdate 	= moment($("#modal-view #date-view").text()).format("MMM DD YYYY hh:mm:ss a");
                    
                    DATA            = null;
                    
                    URL             = "common/editParts.php";
                    partsJSON   = JSON.stringify(parts);
					//console.log(partsJSON);
					//console.log('VALORES: RO '+ ro + ' VIN ' + vin + ' ENGINE '+ engine + ' RO ' + idrequest + ' techname ' + techName + ' Priority '+ vPriority+ ' Type ' + vType+ ' Comments ' + comments );
					
					rederizsoftReady('A','#partsRequesition', 'common/sendMail.php?vRo='+encodeURIComponent(ro)+'&vtechName='+encodeURIComponent(techName)+'&vPriority='+encodeURIComponent(vPriority)+'&vType='+encodeURIComponent(vType)+'&vVin='+encodeURIComponent(vin)+'&vComments='+encodeURIComponent(comments)+'&vpartsJSON='+encodeURIComponent(partsJSON)+'&vDate='+encodeURIComponent(requestdate)+'&vEngine='+encodeURIComponent(engine)+'&vID='+encodeURIComponent(idrequest)+'&vStatus=', '#cargar_data_edit', 'consultar');
                    /*METODO          = partsJSON;
                    VALOR           = idrequest + "|" + jobnumber + "|" + appuser + "|" + idrequesttype + "|" + idpriority + "|" + ro + "|" + vin + "|" + trans + "|" + engine + "|" + comments;
                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                    {
                        DATA = data;*/
                        //console.log(parts);
                        $('#modal-view').modal('hide');
						//**************FILTER DASHBOARD*******************
						if (filter === 0) {
							appuser		= $(".modal-body #techId").val();
							VALOR   	= '';
							<?php 
							if ($profile=='TECH') {
							?>
								VALOR 	= appuser;
							<?php
							}
							?>
							reloadDashboard(VALOR, 'common/ws.php');
						} else {
							iduser		= $("#modal-filter #techId").val();
							startdate	= $("#modal-filter #startdate").val();
							enddate		= $("#modal-filter #enddate").val();
							jobnumber	= $("#modal-filter #jobnumber").val();
							keyword		= $("#modal-filter #keyword").val();
							URL		= "common/dashboard_search.php";
							DATA		= null;
							VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
							reloadDashboard(VALOR, 'common/dashboard_search.php');
						}
						//alert('Your PDF has been sent');
                    //});   
                }
			
			// TO PRINT REQUEST in size half letter
			function printDivReq(div) {

					var mywindow = window.open('', 'PRINT', 'height=400,width=600');
					//console.log('printDivReq');

					mywindow.document.write('<html><head><title>BDI - Preview</title>');
					mywindow.document.write('</head><body>');
					mywindow.document.write(document.getElementById(div).innerHTML);
					//console.log(document.getElementById(div).innerHTML);
					mywindow.document.write('</body></html>');
					var vstyle = '<style> div.modal-footer {display:none;}'
					vstyle = vstyle + 'body {background: white; font-family: Helvetica, Arial, sans-serif; font-size: 13pt; width: 450px; margin-left: auto !important; margin-right: auto  !important;} button.close {display:none;} div.fixed-table-loading{display:none;} div.fixed-table-body { vertical-align: inherit; border-color: inherit;  } .table {width: 100%; padding: 8px;border-color: rgb(204, 204, 204); line-height: 1.42857143; border: 1px solid #dddddd;} .fixed-table-body thead th .th-inner {  box-sizing: border-box;}.table th, .table td {  vertical-align: middle;  box-sizing: border-box; } .td {display: table-cell; } .form-control {width: 100%; line-height: 1.42857143;border: 1px solid; border-color: rgb(204, 204, 204);font-size: 12pt;} .form-group {margin-bottom: 10px;}</style>'
					mywindow.document.write(vstyle);
					mywindow.document.close(); // necessary for IE >= 10
					mywindow.focus(); // necessary for IE >= 10*/
					
					mywindow.print();
					mywindow.close();

					return true;

			}
	
			function printDiv(div) {    
				
				// Create and insert new print section
				var elem = document.getElementById(div);
				var domClone = elem.cloneNode(true);
				var $printSection = document.createElement("div");
				$printSection.id = "printSection";
				$printSection.appendChild(domClone);
				document.body.insertBefore($printSection, document.body.firstChild);

				window.print(); 

				// Clean up print section for future use
				var oldElem = document.getElementById("printSection");
				if (oldElem != null) { oldElem.parentNode.removeChild(oldElem); } 
				return true;
			}
			
			function clearObj(vObj,vEntity) {    
				// Clean up object section for future use
				if (vObj != null && vObj != '') { 
					//alert($( "input.form-control" ).val());
					//$( "input.class" ).val('');	
				} else {
					//alert('');
				}
				return true;
			}
			
			function Onlynumbers(e)
			{
				var tecla=new Number();
				if(window.event) {
					tecla = e.keyCode;
				}
				else if(e.which) {
					tecla = e.which;
				}
				else {
					return true;
				}
				if((tecla >= "67") && (tecla <= "622")){
					return false;
				}
			}

		function printpdf() 
		{
			idrequest       = $("#modal-view #idRequest").val();
            		jobnumber       = $("#modal-view #view-ro").text();
			//alert('PDF/request_'+ jobnumber +'_'+ idrequest +'.pdf');
			printJS('PDF/request_'+ jobnumber +'_'+ idrequest +'.pdf');
		}			
					
					
		function generatePDFreq(vIdRequest, pJobnumber, pTechName,pDate,vComments, pPriority, pType, pVin, parts) {
			var pdfname = '99913128006'
			var doc = new jsPDF('p', 'mm', 'A6')		
				, sizes = [12, 12, 12]		
				, fonts = [['Arial','Roman']]		
				, font, size, lines		
				, margin = 55 // inches on a 8.5 x 11 inch sheet.		
				, verticalOffset = margin;
			//	, parts = DATA.PARTS;

			size = 10;
			doc.setFontSize(size);	
			doc.text(10, 10, 'RO # ' + pJobnumber);	
			doc.text(55, 10, pDate)
			doc.setFontType("bold");
			size = 12;
			doc.setFontSize(size);
			doc.text(35, 20, 'BDI - PART REQUEST');
			doc.setFontType("normal");
			size = 10;	
			doc.setFontSize(size);
			doc.text(10, 30, 'Tech name: ' + pTechName);	
			doc.text(10, 38, 'Type: Quote 	Priority: 911');	
			doc.text(10, 46, 'Vin #: ' + pVin);	
			doc.text(10, 54, 'Comments:');

			// Margins:	
			
			doc.setDrawColor(0, 255, 0)		
				.setLineWidth(1/15)
				.line(margin, margin, margin, 110 - margin)		
				.line(85 - margin, margin, 85-margin, 110-margin)
			
			// multiple lines of text
			size = 10;
			
			verticalOffset = verticalOffset + (size * 0.5)
			for (var i in fonts){
				
				if (fonts.hasOwnProperty(i)) {
					
					font = fonts[i]
					lines = doc.setFont('Arial')
							.setFontSize(size)
							.splitTextToSize(vComments, 85)

					//console.log(lines);
					// Don't want to preset font, size to calculate the lines?		
					// .splitTextToSize(text, maxsize, options)
					// allows you to pass an object with any of the following:
					// {			
					// 	'fontSize': 12
					// 	, 'fontStyle': 'Italic'
					// 	, 'fontName': 'Times'
					// }
					// 	Without these, .splitTextToSize will use current / default
					// font Family, Style, Size.

					doc.text(10, verticalOffset, lines)

					//verticalOffset += (lines.length + 1) * size
					verticalOffset = verticalOffset + (lines.length * size * 0.5)			
				}

			}
			size = 12;
			doc.text(10, verticalOffset, 'PARTS:');
			//doc.text(10, 75, vComments);

			verticalOffset = verticalOffset + (size * 0,5)	
			var verticalOffsetComm = verticalOffset
			
			size = 8
			
			doc.setFontSize(size);
			doc.setFontType("bold");

			doc.setLineWidth(0.2);
			doc.setDrawColor(0,0,0);
			var lineY = verticalOffset - (size * 0.3)
			doc.line(10, lineY ,98, lineY );
			doc.text(10, verticalOffset, 'SEG');
			//doc.text(25, verticalOffset, 'PART');
			doc.text(25, verticalOffset, 'DESCRIPTION');
			doc.text(90, verticalOffset, 'QTY');
			//doc.text(90, verticalOffset, 'ORD');

			lineY = verticalOffset + (size * 0.1)
			doc.line(10, lineY ,98, lineY );
			
			doc.setFontType("normal");
			for (var j in parts){
				//console.log(parts[j]);
				verticalOffset = verticalOffset + (size * 0,5);
				//doc.text(10, verticalOffset, parts[j]['seg'].toString());
				//doc.text(25, verticalOffset, parts[j]['parts']);	
				if (fonts.hasOwnProperty(i)) {
					
					font = fonts[i]
					lines = doc.setFont('Arial')			
						.setFontSize(size)						
						.splitTextToSize(parts[j]['description'], 30)
					// Don't want to preset font, size to calculate the lines?			
					// .splitTextToSize(text, maxsize, options)			
					// allows you to pass an object with any of the following:			
					// {			
					// 	'fontSize': 12			
					// 	, 'fontStyle': 'Italic'			
					// 	, 'fontName': 'Times'			
					// }			
					// Without these, .splitTextToSize will use current / default			
					// font Family, Style, Size.			
					doc.text(10, verticalOffset, lines);
					//verticalOffset += (lines.length + 1) * size 
					//doc.text(75, verticalOffset, parts[j]['qty'].toString());
					//doc.text(90, verticalOffset, parts[j]['ord']);
					verticalOffset = verticalOffset + (lines.length * size * 0.35)
					
					//console.log('j' + j + 'length' + parts.length);	
					if (verticalOffset > 130 && j < (parts.length - 1 )) {
					
						doc.addPage();
					
						verticalOffset = 15;
					
						doc.setFontType("bold");
						
						doc.text(10, verticalOffset, 'SEQ');
						
						//doc.text(25, verticalOffset, 'PART');

						doc.text(25, verticalOffset, 'DESCRIPTION');

						doc.text(90, verticalOffset, 'QTY');

						//doc.text(90, verticalOffset, 'ORD');

						doc.setFontType("normal");
					}
				}
			}
			doc.text(40, 140, 'Brandell Diesel Inc.')
			// Save the PDF

			//var pdf->doc.output();
			//doc.save('test.pdf');
			
		}

		// Return an array of the selected option values
		// select is an HTML select element
		function getSelectValues(select) {
		  var result = [];
		  var options = select && select.options;
		  var opt;

		  for (var i=0, iLen=options.length; i<iLen; i++) {
			opt = options[i];

			if (opt.selected) {
			  result.push(opt.value || opt.text);
			}
		  }
		  return result;
		}

        </script>
		
		<style type="text/css">
		   @media screen {
				#printSection {
				   display: none;
				}
		   }

		   @media print {
				body > *:not(#printSection) {
				   display: none;
				}
				#printSection, #printSection * {
					visibility: visible;
				}
				#printSection {
					position:absolute;
					left:0;
					top:0;
				}
		   }
		</style>
    </body>
</html>
