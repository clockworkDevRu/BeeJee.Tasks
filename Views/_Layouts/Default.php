<!DOCTYPE html>
<html>
	
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="Content-Language" content="ru">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<title>BeeJee Задачи - Тестовое задание</title>
		<meta name="description" content="">
        <meta name="keywords" content="">
		
		<link href="<?=SITE_URL ?>Themes/fonts.css" rel="stylesheet" type="text/css" />
		<link href="<?=SITE_URL ?>Themes/html5reset-1.6.1.css" rel="stylesheet" type="text/css" />
		<link href="<?=SITE_URL ?>Themes/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?=SITE_URL ?>Themes/default.css" rel="stylesheet" type="text/css" />
		
		<script type="text/javascript" src="<?=SITE_URL ?>Scripts/vendor/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="<?=SITE_URL ?>Scripts/vendor/popper.js"></script>
		<script type="text/javascript" src="<?=SITE_URL ?>Scripts/vendor/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=SITE_URL ?>Scripts/vendor/jquery.pjax.js"></script>
		<script type="text/javascript" src="<?=SITE_URL ?>Scripts/vendor/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?=SITE_URL ?>Scripts/vendor/jquery.validate.ru.min.js"></script>
		
		<script type="text/javascript">
			var SITE_URL = '<?=SITE_URL ?>';
		</script>
		<script type="text/javascript" src="<?=SITE_URL ?>Scripts/main.js"></script>
	</head>
	
	<body>
		<div id="background"></div>
		
		<div class="header">
			<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark container">
				<a class="navbar-brand" href="<?=SITE_URL ?>">BeeJee</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?=isset($user) ? $user->name : 'Войти' ?>
							</a>
							<? if (isset($user)) { ?>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
									<a class="dropdown-item" href="<?=SITE_URL ?>Login/logout">Выйти</a>
								</div>
							<? } else { ?>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
									<form class="px-4 py-3" id="login-form" action="<?=SITE_URL ?>Login" method="post">			
										<div class="form-group field-login-form-login required">
											<input type="text" id="login-form-login" class="form-control" name="login-form[login]" autofocus="autofocus" tabindex="1" aria-required="true" placeholder="Логин">
										<div class="help-block"></div>
										</div>			
										<div class="form-group field-login-form-password required">
											<input type="password" id="login-form-password" class="form-control" name="login-form[password]" tabindex="2" aria-required="true" placeholder="Пароль">
											<div class="help-block"></div>
										</div>
										<button type="submit" class="btn btn-primary btn-block" tabindex="4">Войти</button>
									</form>
								</div>
							<? } ?>
						</li>
					</ul>
				</div>
			</nav>
		</div>

		<div class="content container">
			<? include $contentPage; ?>
		</div>
		
	</body>
	
</html>