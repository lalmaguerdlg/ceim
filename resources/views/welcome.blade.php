<!DOCTYPE HTML>
<html>
	<head>
		<title>CEIM</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link href="{{ asset('helios/assets/css/main.css') }}" rel="stylesheet">
		<link href="{{ asset('css/custom-helios.css') }}" rel="stylesheet">
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body class="homepage">
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header">

					<!-- Inner -->
						<div class="inner">
							<header>
                                <h1><a href="#" id="logo">Centro de Estudios</a></h1>
                                <h1><a href="#" id="logo">Intensivos de Monterrey</a></h1>
								{{-- <h1><a href="#" id="logo">CEIM</a></h1> --}}
								<hr />
								<p>Continua superandote.</p>
							</header>
							<footer>
								<a href="#" class="button circled scrolly" style="background: #dc7474">Iniciar</a>
							</footer>
						</div>

					<!-- Nav -->
						<nav id="nav">
							<ul>
								<li><a href="/alumnos">Iniciar Sesión</a></li>
								<li><a href="/register">Registrarse</a></li>
							</ul>
						</nav>

				</div>


                {{-- <div class="section sub-section">

					<!-- Inner -->
						<div class="inner">
							<header >
								<h1><a href="#" id="logo">CEIM</a></h1>
								<hr />
								<p>Comparte tu pasión</p>
							</header>
							<footer>
								<a href="#" class="button circled scrolly" style="background: #dc7474">Start</a>
							</footer>
						</div>

					<!-- Nav -->
						<nav id="nav">
							<ul>
								<li><a href="/alumnos">Iniciar Sesión</a></li>
								<li><a href="/register">Registrarse</a></li>
							</ul>
						</nav>

				</div> --}}

		</div>

		<!-- Scripts -->
			<script src="{{ asset('helios/assets/js/jquery.min.js') }}"></script>
			<script src="{{ asset('helios/assets/js/jquery.dropotron.min.js') }}"></script>
			<script src="{{ asset('helios/assets/js/jquery.scrolly.min.js') }}"></script>
			<script src="{{ asset('helios/assets/js/jquery.onvisible.min.js') }}"></script>
			<script src="{{ asset('helios/assets/js/skel.min.js') }}"></script>
			<script src="{{ asset('helios/assets/js/util.js') }}"></script>
			<!--[if lte IE 8]><script src="{{ asset('helios/assets/js/ie/respond.min.js') }}"></script><![endif]-->
			<script src="{{ asset('helios/assets/js/main.js') }}"></script>

	</body>
</html>