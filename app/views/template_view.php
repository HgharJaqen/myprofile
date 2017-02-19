<?php
	include "app/views/".Route::$language.'/template_'.Route::$language.'.php';
	
	$authLink;
	$authText;

	// если пользователь не аутентифицирован $data = null
	if($data == null) {
		$authLink = Route::$language.'/main/login';
		$authText = $lng['login'];
	}
	else {
		$authLink = Route::$language.'/main/logout';
		$authText = $lng['logout'];
	}
	
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $lng['my_profile'];?></title>

	<base href="<?php echo Route::$baseUrl;?>">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Bootstrap -->
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/my.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
  	<nav class="navbar navbar-inverse navbar-fixed-top">
  		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="<?php echo Route::$language.'/main/index'?>"><?php echo $lng['my_profile'];?></a>
			</div>
			
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $lng['language'];?>
						<span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href="ru/<?php echo Route::$first.'/'.Route::$second;?>"><?php echo $lng['ru'];?></a></li>
						<li><a href="eng/<?php echo Route::$first.'/'.Route::$second;?>"><?php echo $lng['eng'];?></a></li>
					  </ul>
					</li>
					<li><a href="<?php echo $authLink;?>"><?php echo $authText;?></a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container -->
	 </nav>
	
	<?= $content ?>
  </body>
</html>














