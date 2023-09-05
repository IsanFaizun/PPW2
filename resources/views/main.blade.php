<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Blade Laravel</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<header>
		<h2>Praktikum Pemrograman Web 2</h2>
		<a href="/home">Home</a> |
		<a href="/menu1">Menu 1</a>
	</header>
	<hr>
	<br>
	<br>
 
	<!-- bagian judul -->
	<h3> @yield('title') </h3>
 
	<!-- bagian konten -->
	@yield('content')
 
	<br>
	<br>
	<hr>
	<footer>
        <p>This is footer</p>
	</footer>
</body>
</html>