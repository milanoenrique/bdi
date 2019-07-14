<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $this->getPageTitle(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">       
        <link rel="shortcut icon" type="image/ico" href="img/favicon.ico"/>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap-table.css" rel="stylesheet" type="text/css"/>
        <link href="css/font-awesome.css" rel="stylesheet" />
        <link href="css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css"/>	
        <link href="css/theme.css" rel="stylesheet" type="text/css"/>
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">

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
            <div class="row">
                <nav class="navbar navbar-inverse navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
							<a class="navbar-brand" href="#" style="color: #ffffff;"><i class="fa fa-clone animated infinite flash"></i> <font color='#ffffff'><?php echo $this->getPageIcon(); ?></font></a>
						</div>
						<div id="navbar" class="navbar-collapse collapse">
							<ul class="nav navbar-nav navbar-right">

								<?php

									$items=$this->getPageMenuItems();

									foreach ($items as $menukey => $menuvalue):

										echo $this->buildMenu($menuvalue,$menukey);

									endforeach;

								?>

							</ul>
						</div>
                    </div>
                </nav>
            </div>

