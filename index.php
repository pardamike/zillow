
<!DOCTYPE html>
<html lang="en-us">
	<head>		
		<meta charset="utf-8">
		<meta name="description" content="Tampa Pizza Company" />
		<meta name="keywords" content="zillow api">
    	<meta name="author" content="Mike Parda" />
   		<meta name="robots" content="index" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1" >
		<title>Mike Parda - Zillow API</title>
                <!-- Bootstrap CSS with Flatly theme by Bootswatch -->
		<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
                <!-- Clearly we need Font Awesome -->
                <link href="font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet">
                <!-- Custom styles -->
		<link href="css/styles.css" rel="stylesheet">
		<link rel="icon" href="img/zillow.png" />
		<!--[if lt IE 9]>
			<script src="html5shiv.js"></script>
			<script src="respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		
		<?php include_once 'header.php' ;?>
                
                <?php
                    if(isset($_GET['page'])) {
                        $page = $_GET['page'];
                        include($page);
                    }
                    else {
                        include_once 'home.php';
                    }	
		?>
		
				
		<?php include_once 'footer.php'; ?>
                <?php include_once 'AjaxFunctions.php' ;?>
		
                <!-- jQuery -->
		<script src="jquery/dist/jquery.min.js" type="text/javascript"></script>
                
                <!-- Bootstraps JS -->
		<script src="bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
                
                <!-- Custom jQuery functions -->
		<script src="js/jquery.globalControls.js" type="text/javascript"></script>
                
                
                <script>
                var globalControls = $.fn.globalControls({
                    _checkItBtnID: "checkIt",
                    _inputClasses: "addressField",
                    _chartBtnClass: "chartBtn"
                });
                globalControls.init();  
                </script>
        </body>
	
</html>