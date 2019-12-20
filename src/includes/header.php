<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Wideworldimporters || <?php echo $query; ?></title>
	<meta name="theme-color" content="#4DBFF2">
	<link rel="icon" type="image/png" sizes="16x16" href="public/img/wwi/favicon/favicon-16x16.png">
	<link rel="icon" type="image/png" sizes="32x32" href="public/img/wwi/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="193x193" href="public/img/wwi/favicon/mstile-150x150.png">
	<link rel="icon" type="image/png" sizes="72x72" href="public/img/wwi/favicon/android-chrome-72x72.png">
	<link rel="icon" type="image/png" sizes="193x193" href="public/img/wwi/favicon/mstile-150x150.png">
	<link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="public/fonts/fontawesome-all.min.css">
	<link rel="stylesheet" href="public/css/wwi_footer.css">
	<link rel="stylesheet" href="public/css/wwi_global_items.css">
	<link rel="stylesheet" href="public/css/wwi_global.css">
	<link rel="stylesheet" href="public/css/wwi_home.css">
	<link rel="stylesheet" href="public/css/wwi_product.css">
	<link rel="stylesheet" href="public/css/styles.css">
	<script src="public/js/jquery.min.js"></script>
	<script src="public/js/bootstrap-better-nav.min.js"></script>
	<!-- <script src="public/js/promise-po8lyfill.js"></script> -->
	<script src="public/js/sweetalert.min.js"></script>
	<script src="public/js/functions.js"></script>
	<script src="public/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
	<section id="html-body" class="container-fluid ">
		<section id="hidden" class="">
			<?php
                require('../src/includes/login.php');
                if (isset($_SESSION['shoppingCart'])) {
                    $shoppingcart = [];
                    for ($i=0; $i < count($_SESSION['shoppingCart']); $i++) {
                        if ($_SESSION['shoppingCart'][$i] !== 'nAn') {
                            array_push($shoppingcart, $_SESSION['shoppingCart'][$i]);
                        }
                    }
                    $_SESSION['shoppingCart'] = $shoppingcart;
                }
                require('../src/includes/cart.php');
            ?>
		</section>
		<section id="header" class="">
			<nav class="navbar navbar-light navbar-expand-md sticky-top bg-light">
				<div class="container-fluid"><a href="/home"><img class="navbar-brand wwi_nav_img" src="public/img/wwi/logo.png"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
						<span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
					<div class="collapse navbar-collapse" id="navcol-1">
						<div class="ml-auto">
							<form action="/search">
								<div class="input-group wwi_25width wwi_mat_3">
									<input class="form-control wwi_mainborder" name="Searchquery" type="text"
										placeholder="e.g Blue Chair, Sofa or Post Modern">
										<input type="hidden" name="page" value="1">
									<div class="input-group-append"><button
											class="btn wwi_mainbgcolor wwi_text_lighthover wwi_text_light wwi_text_lighthover"
											type="submit"><i class="fas fa-search"></i></button></div>
								</div>
							</form>
						</div>
						<ul class="nav navbar-nav ml-auto wwi_right">
						<li class="nav-item" role="presentation">
								
								<?php
                                // <a class="nav-link" href="#" data-toggle="modal" data-target="#login"><i class="fas fa-user"></i><strong>&nbsp;Account</strong><br></a>
                                    if (isset($_SESSION['isloggedIn'])) {
                                        ?>
								<div class="dropdown show">
									<a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-user"></i>&nbsp;Account
									</a>

									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="/orderhistory">Order history</a>
										<a class="dropdown-item" href="/logout">Logout</a>
									</div>
                                </div>
									<?php
                                    } else {
                                        echo('<a class="nav-link" href="#" data-toggle="modal" data-target="#login"><i class="fas fa-user"></i><strong>&nbsp;Account</strong><br></a>');
                                        // logout
                                    } ?>
							</li>
							
							<li class="nav-item" role="presentation">
								
								<a class="nav-link" href="#" data-toggle="modal" data-target="#cart">
								<i class="fas fa-shopping-cart"></i>
								<?php

                                if (isset($_SESSION['shoppingCart'])) {
                                    if (!empty($_SESSION['shoppingCart'])) {
                                        echo '<span class="badge badge-info">'.count($_SESSION['shoppingCart']).'</span><strong>&nbsp;Cart</strong>';
                                    } else {
                                        echo '<strong>&nbsp;Cart</strong>';
                                    }
                                }
                                ?>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		
			<nav class="navbar navbar-light navbar-expand-md">
        		<div class="container-fluid">
            		<div class="row">
						<?php
                            $database = new database();
                            $getstockgroups = $database->DBQuery("SELECT * FROM stockgroups", []);
                            $getStockgroupCategories = $database->DBQuery("SELECT * FROM stockgroupscategories", []);
                            
                            $database->closeConnection();
                            for ($i=0; $i < count($getStockgroupCategories); $i++) {
                                echo '<div class="col"><div class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">'.$getStockgroupCategories[$i]['sgCategoriesName'].'&nbsp;</a><div class="dropdown-menu" role="menu">';
                                for ($i2=0; $i2 < count($getstockgroups); $i2++) {
                                    if ($getStockgroupCategories[$i]['sgCategoriesID'] == $getstockgroups[$i2]['StockGroupParent']) {
                                        echo '<a class="dropdown-item" role="presentation" href="/categories?catid='.$getstockgroups[$i2]['StockGroupID'].'&page=1">'.$getstockgroups[$i2]['StockGroupName'].'</a>';
                                    }
                                }
                                echo '</div></div></div>';
                            }
                        ?>
					</div>
        		</div>
    		</nav>
	</section>
	<?php
    if (!$_SESSION['limit']) {
        $_SESSION['limit'] = 25;
    } else {
        if (empty($_SESSION['limit'])) {
            $_SESSION['limit'] = 25;
        }
    }
    // print_r($_SESSION);
