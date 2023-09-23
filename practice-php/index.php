<?php 
	session_start();
	$_SESSION['shoppingcart'] = "shoppingcart";
	if(isset($_GET['email']) && !empty($_GET['email'])){
		$_SESSION['login'] = $_GET['email'];
	}

	if(isset($_GET['auth']) && $_GET['auth'] == "1"){
		setcookie("auth", $_SESSION['login'], time() + 3600);
		setcookie("shoppingcart", $_SESSION['shoppingcart'], time() + 3600);
	}
	print_r($_COOKIE);
	require_once("lib/functions.php");
	require_once("config.php");
	require_once("lib/db.php");

	if(isset($_GET['auth']) && $_GET['auth'] == "0"){
		setcookie("auth", "", time() - 3600);
		session_destroy();
		header("location: index.php");
		die();
	}

	if(isset($_COOKIE['auth']) && !empty($_COOKIE['auth'])){
		$link = connect();
		$user = searchUserEmail($link, $_COOKIE['auth']);
		if($user != false){
			$_SESSION['login'] = $_COOKIE['auth'];
		}
	}

	

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<style type="text/css">
		label{
			display: block;
		}
		form > div{
			margin: 10px 0;
		}
	</style>
</head>
<body>

	<div class="container text-center">
		<div class="row">
			<div class="col">


				<?php 
		
					if(!isset($_SESSION['login'])){
						include_once("login/form.php");
					}
					else{

						$link = connect();
						$user = searchUserEmail($link, $_SESSION['login']);
						if(!is_null($user)){
							echo '<p>Вы вошли как: '.$user['login'].' <a href="index.php?auth=0">выход</a></p>';
						}
					}	

				
					if(isset($_GET['status'])){

						$status = jsonConvertArray($_GET['status']);

						$class = status_request($status['code']);
						
						echo    '<div class="alert '.$class.' alert-dismissible fade show" role="alert">
								  '.$status['msg'].'
								  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>';
					}
				?>
				<p></p>
			</div>
		</div>
	</div>
	
	


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>