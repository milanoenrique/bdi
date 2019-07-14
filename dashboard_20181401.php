<?php
	include_once("config.php");
	include_once("includes/functions.php");
    include_once("templates/classHeader.php");

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

    $header=new classHeader();     

    $header->setDefaultMenuItems($_SESSION['perfil'],$profile);
    $header->getHeader();
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

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tabdashboard" aria-controls="home" role="tab" data-toggle="tab">Dashboard</a></li>
                            <?php  if ($profile=='ADMIN' || $profile=='MANAGERAD' || $profile=='ASSIST'): ?>
                                <li role="presentation"><a href="#tabwriteups" aria-controls="tabwriteups" role="tab" data-toggle="tab">Write Ups</a></li>
                            <?php endif; ?>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="tabdashboard">                   

                                <?php if($profile!='TV'): ?>

                                    <div id="custom-toolbar">
                                        <button class="btn btn-default filter" data-tabletarget="#table-dashboard" data-filename="dashboard_search" style="margin-left:4px;"><span class="fa fa-search" aria-hidden="true"></span></button>
                                        <button id="buttonApplyFilter" class="btn btn-default" style="margin-left:4px;" onClick='clearObj("input.form-control","filter");'><span class="fa fa-times" aria-hidden="true"></span></button>
                                        <button id="print" class="btn btn-default" style="margin-left:4px;" onclick="dashboardPDF('print')"><span class="fa fa-print" aria-hidden="true"></span></button>
                                        <button id="exportcsv" class="btn btn-default" style="margin-left:4px;" onclick="dashboardCSV()"><span class="fa fa-file-excel-o" aria-hidden="true"></span></button>
                                        <button id="exportpdf" class="btn btn-default" style="margin-left:4px;" onclick="dashboardPDF('view')"><span class="fa fa-file-pdf-o" aria-hidden="true"></span></button>
                                        <?php if($profile=='PARTSP'): ?>
                                          <button id="audio1" class="btn btn-default" style="margin-left:4px;"><span class="fa fa-volume-up" aria-hidden="true"></span></button>
                                        <?php endif; ?>
                                    </div>
                                    
                                <?php endif; ?>

                                <table id="table-dashboard" data-sort-name="idrequest" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="<?php if($profile!='TV'){echo 'true';}else{echo 'false';}?>" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="#custom-toolbar" data-toolbar-align="right"></table>

                            </div>

                            <?php  if ($profile=='ADMIN' || $profile=='MANAGERAD' || $profile=='ASSIST'): ?>
                                <div role="tabpanel" class="tab-pane" id="tabwriteups">

                                    <?php if($profile!='TV'): ?>

                                        <div id="custom-toolbarwriteups">
                                            <button class="btn btn-default filter" data-tabletarget="#table-writeups" data-filename="wps-search" style="margin-left:4px;"><span class="fa fa-search" aria-hidden="true"></span></button>
                                            <button id="buttonApplyFilterwriteups" class="btn btn-default" style="margin-left:4px;" onClick='clearObj("input.form-control","filter");'><span class="fa fa-times" aria-hidden="true"></span></button>
                                            <button id="exportcsvwriteups" class="btn btn-default" style="margin-left:4px;" onclick="writeUpsCSV()"><span class="fa fa-file-excel-o" aria-hidden="true"></span></button>
                                            <?php if($profile=='PARTSP'): ?>
                                              <button id="audio1" class="btn btn-default" style="margin-left:4px;"><span class="fa fa-volume-up" aria-hidden="true"></span></button>
                                            <?php endif; ?>
                                        </div>
                                        
                                    <?php endif; ?>

                                    <table id="table-writeups" data-sort-name="writeupidwriteup" data-sort-order="desc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="<?php if($profile!='TV'){echo 'true';}else{echo 'false';}?>" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="#custom-toolbarwriteups" data-toolbar-align="right"></table>


                                </div>
                            <?php endif; ?>

                        </div>



                    </div>
                </div>				        	
            </div>



        </div>

        <?php  if ($profile=='ADMIN' || $profile=='MANAGERAD' || $profile=='ASSIST'): ?>

            <!-- Inicio Modal -->
            <input type="hidden" id="writeUp"/>
            <div class="modal" id="myModalWriteUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background:#009207;">
                            <font color='#fff'>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> New Write up</h4>
                            </font>
                        </div>
                        <div class="modal-body">
                            <div class="col-sm-16">
                                <div class="widget-box">
                                    <div class="widget-body">
                                        <div class="modal-body datagrid table-responsive" >
                                            <center>
                                                <div class="panel-body" id="writeuppartsRequesition">
                                                    <form class="form-horizontal" style="text-align: left;" data-toggle="validator">
                                                        <div class="form-group" id ="selectEmployee">
                                                            <label class="col-md-3 control-label" for="writeupstartdate"><font color='#009207'>* </font>Write up date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='datetimepickerWriteUpDate'>
                                                                    <input type='text' id="writeupdate" class="form-control" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>                                                  
                                                            <label class="col-md-3 control-label" for="writeupemployee" ><font color='#009207'>* </font>Employee:</label>
                                                            <div class="col-md-3">
                                                                <select name="writeupemployee" id="writeupemployee" class="form-control">    
                                                                    <option value="">-- Select writeupemployee --</option>
                                                                    <?php
                                                                        getEmployeeList('', '', 'A', '');
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>                                          
                                                        <div class="form-group" id ="selectSupervisor">
                                                            <label class="col-md-3 control-label" for="department">Department</label>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control" id="department" placeholder="">
                                                            </div>                                                  
                                                            <label class="col-md-3 control-label" for="writeupsupervisor"><font color='#009207'>* </font>Supervisor:</label>
                                                            <div class="col-md-3">
                                                                <select name="writeupsupervisor" id="writeupsupervisor" class="form-control">    
                                                                    <option value="">-- Select writeupsupervisor --</option>
                                                                    <?php
                                                                        getEmployeelist('', '', 'A', '');
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>                                                  
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="senioritydate"><font color='#009207'>* </font>Employee seniority date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='datetimepickerSeniorityDate'>
                                                                    <input type='text' id="senioritydate" class="form-control" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <label class="col-md-3 control-label" for="writeuptradelevel">Trade level</label>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control" id="writeuptradelevel" placeholder="">
                                                            </div>
                                                        </div>                                                          
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="disaction"><font color='#009207'>* </font> Disciplinary action</label>
                                                            <div class="col-md-9  inputGroupContainer">
                                                                <label class="btn type-options" ><input type="radio" name="disaction" value="Y" checked> Yes </label>                                                       
                                                                <label class="btn type-options" ><input type="radio" name="disaction" value="N"> No </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id ="selectViolationType">
                                                            <label class="col-md-3 control-label" for="writeupviolationtype"><font color='#009207'>* </font>Type of violation:</label>
                                                            <div class="col-md-9">
                                                                    <?php
                                                                        getTypeOfViolation();
                                                                    ?>
                                                                    <div class="width:50%;">
                                                                    <input type='text' id="txtothers" class="form-control" />
                                                                    </div>
                                                            </div>
                                                        </div>      
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="writeuplastwarn">Last warning date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='datetimepickerLastWarnDate'>
                                                                    <input type='text' id="writeuplastwarn" class="form-control" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <label class="col-md-3 control-label" for="writeuppreviouswarn">Previous warning date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='datetimepickerPreviousWarnDate'>
                                                                    <input type='text' id="writeuppreviouswarn" class="form-control" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="writeupwarnings"><font color='#009207'>* </font>Warnings</label>
                                                            <div class="col-md-9  inputGroupContainer">
                                                                <label class="btn type-options" ><input type="radio" name="writeupwarnings" value="1" checked> 1st </label>                                                     
                                                                <label class="btn type-options" ><input type="radio" name="writeupwarnings" value="2"> 2nd </label>
                                                                <label class="btn type-options" ><input type="radio" name="writeupwarnings" value="2"> 3rd </label>
                                                            </div>
                                                        </div>                                                      
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="writeupwpstatement">Employer statement:</label>
                                                            <div class="col-md-9">
                                                                <textarea id="writeupwpstatement" class="form-control" rows="3" placeholder=""></textarea>
                                                            </div>
                                                        </div>                                                  
                                                        <div class="form-group" style="display:none">
                                                            <div class="col-md-5  inputGroupContainer" style="padding-left: 0; width:auto; ">
                                                                <div class="input-group">
                                                                    <input type="hidden" id="writeupnew-techId"   name="new-techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
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
                            <div class="row">       
                                <div class="col-xs-12 col-centered" id="cargar_data_requesition">
                                    <img src="loader.gif"/>Please wait, sending mail...
                                </div>
                            </div>
                            <font size="2">All fields marked with <font color='#009207' size="3">*</font> are required.</font>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                            <button type="button" id="buttonSaveWriteUp" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Save</button> 
                        </div>                        
                    </div>
                </div>
            </div>
            <!-- Fin Modal -->
            <!-- Fin Button trigger modal -->

        <?php endif; ?>


            
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
                                                                <input type="text" id="new-techName" name="new-techName" class="form-control" value="<?php echo $techName ?>" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5  inputGroupContainer" style="padding-left: 0; width:auto; ">
                                                            <div class="input-group">
                                                                <input type="text" id="new-techId"   name="new-techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
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
                                                            <textarea id="msg-comments" class="form-control" rows="3" placeholder=""></textarea>
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
                                                <input type="hidden" id="assign-techName" 		name="assign-techName" 	value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="assign-techId" 		name="assign-techId" 		value="<?php echo $techId ?>" 	disabled="disabled"/>
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
                                                <input type="hidden" id="assignsp-techName" name="assignsp-techName" value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="assignsp-techId"   name="assignsp-techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
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
                                                <input type="hidden" id="del-techName" name="del-techName" value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="del-techId"   name="del-techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
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
                                                        <div class="col-md-6  inputGroupContainer" style="padding-right: 0;">
                                                            <div class="input-group">
                                                                <input type="text" id="edit-techName" name="edit-techName" class="form-control" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3  inputGroupContainer" style="padding-left: 0; width:auto; ">
                                                            <div class="input-group">
                                                                <input type="hidden" id="edit-techId"   name="edit-techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
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
                                                            <input type="text" class="form-control" id="edit-ro" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="vin">VIN#</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="edit-vin" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="trans">TRANS#</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="edit-trans" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="engine">ENGINE#</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="edit-engine" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="comments">COMMENTS:</label>
                                                        <div class="col-md-9">
                                                            <textarea id="edit-comments" class="form-control" rows="3" placeholder=""></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <table id="table-parts" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right"></table>
                                                    </div>
                                                    <div class="form-group">                                                        
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;display:none;">
                                                            <input type="text" class="form-control" id="edit-parts" placeholder="* PARTS:">
                                                        </div>
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;">
                                                            <input name="edit-seg" class="form-control" id="edit-seg" placeholder="* SEG:" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return Onlynumbers(event)" type = "number" maxlength = "10"/>
                                                        </div>
                                                        <div class="col-lg-7" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="edit-description" placeholder="* DESCRIPTION:">
                                                        </div>
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <input name="edit-qty" step="0.01"  class="form-control" id="edit-qty" placeholder="* QTY:" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return Onlynumbers(event)" type = "number" maxlength = "10"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group pull-right">
														<button id="buttonAddPartsE" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Add parts</button>
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
                                                <input type="hidden" id="close-techName" name="close-techName" value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="close-techId"   name="close-techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
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
                        <button id="buttonClosePartsRequesition" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Close Request</button>
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
                        <button type="button" id="buttonApplyFilter" data-tabletarget="" data-filename="" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Filter</button>
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
                                                    <input type="hidden" id="adminu-techName" name="adminu-techName" class="form-control" value="<?php echo $techName ?>" disabled="disabled"/>
                                                    <input type="hidden" id="adminu-techId"   name="adminu-techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
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
																							<input type="hidden" id="iduser" name="idUser" value="" disabled="disabled"/>
																							<input type="hidden" id="deluser-techId"   name="deluser-techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
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
                                                    <input type="hidden" id="admgr-techName" name="admgr-techName" class="form-control" value="<?php echo $techName ?>" disabled="disabled"/>
                                                    <input type="hidden" id="admgr-techId"   name="admgr-techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
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
																							<input type="hidden" id="delgroup-techId"   name="delgroup-techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
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
        
        <?php

            require_once('templates/views/viewScriptsDashboard.php');
            if ($profile=='ADMIN' || $profile=='MANAGERAD' || $profile=='ASSIST') {
                require_once('templates/views/viewScriptsWriteUps.php');
            }

        ?>

		
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
