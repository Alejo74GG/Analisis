<?php
require_once('db.php'); // Asegúrate de que db.php contiene la conexión a la base de datos

// Primera consulta
$query = "SELECT identificador, texto FROM textos";
$result = mysqli_query($conexion, $query); // Pasa la conexión como primer argumento

if ($result) {
	while ($row = mysqli_fetch_assoc($result)) { // Cambiar mysql_fetch_assoc() por mysqli_fetch_assoc()
		$identificador = $row['identificador'];
		$texto = $row['texto'];
		// Almacena la variable dinámica
		$$identificador = mb_convert_encoding($texto, 'UTF-8', 'auto');
	}
} else {
	echo "Error en la consulta de textos: " . mysqli_error($conexion);
}

// Segunda consulta
$query = "SELECT identificador, src FROM imagenes";
$result = mysqli_query($conexion, $query); // Pasa la conexión como primer argumento

$imagenes = array();
if ($result) {
	while ($row = mysqli_fetch_assoc($result)) { // Cambiar mysql_fetch_assoc() por mysqli_fetch_assoc()
		$identificador = $row['identificador'];
		$src = $row['src'];
		// Almacena las imágenes en el array asociativo
		$imagenes[$identificador] = $src;
	}
} else {
	echo "Error en la consulta de imágenes: " . mysqli_error($conexion);
}

// No olvides cerrar la conexión después de que termines
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html>

<head>
	<title>ZIPCOM</title>
	<!-- META TAGS -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/icono.png">
	<meta name="author" content="Amine Akhouad">
	<meta name="description" content="AKAD is a creative and modern template for digital agencies">

	<!-- STYLES -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/ionicons.min.css">
	<link rel="stylesheet" href="assets/css/flexslider.css">
	<link rel="stylesheet" href="assets/css/animsition.min.css">
	<link rel="stylesheet" href="assets/css/animate.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<style>

         /* Botón de inicio de sesión en la parte superior */
         #login-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
		/* Estilos para el modal */
		.modal {
			display: none;
			position: fixed;
			z-index: 1;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgba(0, 0, 0, 0.4);
			padding-top: 60px;
		}

		.modal-content {
			background-color: #fefefe;
			margin: 5% auto;
			padding: 20px;
			border: 1px solid #888;
			width: 80%;
		}

		.close {
			color: #aaa;
			float: right;
			font-size: 28px;
			font-weight: bold;
		}

		.close:hover,
		.close:focus {
			color: black;
			text-decoration: none;
			cursor: pointer;
		}

		/* Estilos del botón flotante */
		#openChat {
			position: fixed;
			bottom: 20px;
			right: 20px;
			background-color: #008CBA;
			/* Color del botón */
			color: white;
			border: none;
			padding: 15px;
			border-radius: 50%;
			cursor: pointer;
			font-size: 20px;
			z-index: 10;
		}

		#openChat:hover {
			background-color: #005f73;
			/* Color del botón al pasar el cursor */
		}

		/* Estilos del chat */
		#chat-container {
			border: 1px solid #ccc;
			padding: 10px;
			background-color: #fff;
		}

		#chat-log {
			height: 200px;
			overflow-y: scroll;
			border: 1px solid #ccc;
			padding: 10px;
			margin-bottom: 10px;
		}

		#user-input {
			width: calc(100% - 60px);
		}

		#send-button {
			width: 50px;
		}
	</style>
</head>

<body class="animsition">

	<!-- HEADER  -->
	<header class="main-header">
             <!-- Botón de inicio de sesión -->
             <button id="login-btn" onclick="window.location.href='login.php'">Iniciar Sesión</button>


		<div class="container">
			<div class="logo">
				<a href="index.html"><img src="assets/img/<?php echo $imagenes['logo_principal'] ?>" alt="logo" style="width: 10em;"></a>
			</div>

			<div class="menu">
				<!-- desktop navbar -->
				<nav class="desktop-nav">
					<ul class="first-level">
						<li><?php echo $linea_direccion1 ?></li>
						<li> <?php echo $linea_direccion2 ?></li>
						<!-- <li><a href="services.html" class="animsition-link"></a></li>
						<li><a href="">portfolio</a>
							<ul class="second-level">
								<li><a href="portfolio-1.html" class="animsition-link">portfolio list</a></li>
								<li><a href="single-project.html" class="animsition-link">single project 1</a></li>
								<li><a href="single-project-2.html" class="animsition-link">single project 2</a></li>
							</ul>
						</li>
						<li><a href="">blog</a>
							<ul class="second-level">
								<li><a href="blog-1.html" class="animsition-link">posts list</a></li>
								<li><a href="single-post.html" class="animsition-link">single post</a></li>
							</ul>
						</li>
						<li><a href="contact.html" class="animsition-link"></a></li>-->
					</ul>
				</nav>
				<!-- mobile navbar -->
				<nav class="mobile-nav"></nav>
				<div class="menu-icon">
					<div class="line"></div>
					<div class="line"></div>
					<div class="line"></div>
				</div>
			</div>
		</div>
	</header>

	<!-- HERO SECTION  -->
	<div class="site-hero">
		<ul class="slides">
			<li>
				<div><span class="small-title uppercase montserrat-text"><?php echo $primer_titulo1 ?></span></div>
				<div class="big-title uppercase montserrat-text"><img src="assets/img/<?php echo $imagenes['logo_transicion'] ?>" alt="logo" style="width: 5em; margin-top: -0.5em; margin-bottom: -0.5em;"></div>
				<p>Integración de servicios de ingeniería e infraestructura en telecomunicaciones, <br>
					electricidad, construcción y tecnologias de información.</p>
			</li>
			<li>
				<div><span class="small-title uppercase montserrat-text"><?php echo $primer_titulo2 ?></span></div>
				<div class="big-title uppercase montserrat-text">Redes</div>
				<p>Mas de 900 redes instaladas en toda guatemala. Datos, Voz, video y fibra optica. <br>
					En areas de Gobierno, banca, industria, telcomunicaciones y servicios. <br>
					Certificados por Siemon Company.. </p>
			</li>
		</ul>
	</div>

	<!-- HISTORY OF AGENCY -->
	<div class="container">
		<div class="agency">
			<div class="col-md-5 col-sm-12">
				<div class="row">
					<img src="assets/img/<?php echo $imagenes['historia'] ?>" alt="image">
				</div>
			</div>
			<div class="col-md-offset-1 col-md-6 col-sm-12">
				<div class="row">
					<div class="section-title">
						<span><?php echo $titulo_seccion1 ?></span>
					</div>
					<p style="text-align: justify;">
						<?php echo $texto_seccion2 ?>
					</p>
					<a href="#" class="btn green" style="float:right;margin-top:30px; cursor: inherit;"><span><?php echo $texto_transicion1 ?></span></a>
				</div>
			</div>
		</div>
	</div>


	<!-- WHY CHOOSE US -->
	<section class="services">
		<div class="container">
			<div class="row">
				<div class="section-title">
					<span><?php echo $titulo_seccion2 ?></span>
					<p><?php echo $subtitulo_seccion2 ?></p>
				</div>
			</div>

			<div class="col-md-7 col-sm-12 services-left wow fadeInUp">
				<div class="row" style="margin-bottom:50px">
					<div class="col-md-6 col-sm-12">
						<div class="row">
							<i class="icon ion-ios-infinite-outline"></i>
							<span class="montserrat-text uppercase service-title"><?php echo $titulo_lista1 ?></span>
							<ul>
								<?php
								$opciones = explode(',', $opciones_lista1);
								foreach ($opciones as $value) {
									echo "<li>$value</li>";
								}
								?>
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div class="row">
							<i class="icon ion-ios-shuffle"></i>
							<span class="montserrat-text uppercase service-title"><?php echo $titulo_lista2 ?></span>
							<ul>
								<?php
								$opciones = explode(',', $opciones_lista2);
								foreach ($opciones as $value) {
									echo "<li>$value</li>";
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="row">
							<i class="icon ion-ios-cart-outline"></i>
							<span class="montserrat-text uppercase service-title"><?php echo $titulo_lista3 ?></span>
							<ul>
								<?php
								$opciones = explode(',', $opciones_lista3);
								foreach ($opciones as $value) {
									echo "<li>$value</li>";
								}
								?>
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div class="row">
							<i class="icon ion-ios-settings"></i>
							<span class="montserrat-text uppercase service-title"><?php echo $titulo_lista4 ?></span>
							<ul>
								<?php
								$opciones = explode(',', $opciones_lista4);
								foreach ($opciones as $value) {
									echo "<li>$value</li>";
								}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-5 col-sm-12 services-right wow fadeInUp" data-wow-delay=".1s">
				<div class="row">
					<img src="assets/img/<?php echo $imagenes['listados'] ?>" alt="image">
				</div>
			</div>

		</div>
	</section>


	<!-- PORTFOLIO -->
	<section class="portfolio">
		<div class="container">
			<div class="row">
				<div class="section-title">
					<span><?php echo $titulo_seccion3 ?></span>
					<p><?php echo $subtitulo_seccion3 ?></p>
				</div>
			</div>


			<!-- categories  -->
			<div class="col-md-3">
				<div class="row categories-grid wow fadeInLeft">
					<span class="montserrat-text uppercase">Categoria</span>

					<nav class="categories">
						<ul class="portfolio_filter">
							<li><a href="" class="active" data-filter="*">Todos</a></li>
							<li><a href="" data-filter=".cableado">Cableado estructurado</a></li>
							<li><a href="" data-filter=".electrica">Redes electricas</a></li>
							<li><a href="" data-filter=".construccion">Construccion</a></li>
							<li><a href="" data-filter=".fibra">Fibra optica</a></li>
							<li><a href="" data-filter=".soporte">Soporte técnico</a></li>
							<!--<li><a href="" data-filter=".fashion">fashion</a></li>-->
						</ul>
					</nav>
				</div>
			</div>

			<!-- all works -->
			<div class="col-md-9">
				<div class="row portfolio_container">
					<!-- single work -->
					<div class="col-md-4 cableado">
						<a class="portfolio_item work-grid wow fadeInUp">
							<img src="assets/img/<?php echo $imagenes['cableado1'] ?>" alt="image">
							<div class="portfolio_item_hover">
								<div class="item_info">
									<span>Cableado estructurado</span>
									<em>Excelencia</em>
								</div>
							</div>
						</a>
					</div>
					<!-- end single work -->

					<!-- single work -->
					<div class="col-md-4 electrica ">
						<a class="portfolio_item work-grid wow fadeInUp" data-wow-delay=".2s">
							<img src="assets/img/<?php echo $imagenes['electrica1'] ?>" alt="image">
							<div class="portfolio_item_hover">
								<div class="item_info">
									<span>Instalación electrica</span>
									<em>Honestidad</em>
								</div>
							</div>
						</a>
					</div>
					<!-- end single work -->

					<!-- single work -->
					<div class="col-md-4 ads cableado">
						<a class="portfolio_item work-grid wow fadeInUp" data-wow-delay=".3s">
							<img src="assets/img/<?php echo $imagenes['cableado2'] ?>" alt="image">
							<div class="portfolio_item_hover">
								<div class="item_info">
									<span>Cableado estructurado</span>
									<em>Veracidad</em>
								</div>
							</div>
						</a>
					</div>
					<!-- end single work -->

					<!-- single work -->
					<div class="col-md-4 electrica ">
						<a class="portfolio_item work-grid wow fadeInUp" data-wow-delay=".4s">
							<img src="assets/img/<?php echo $imagenes['electrica2'] ?>" alt="image">
							<div class="portfolio_item_hover">
								<div class="item_info">
									<span>Instalación electrica</span>
									<em>Responsabilidad</em>
								</div>
							</div>
						</a>
					</div>
					<!-- end single work -->

					<!-- single work -->
					<div class="col-md-4 construccion">
						<a class="portfolio_item work-grid wow fadeInUp" data-wow-delay=".5s">
							<img src="assets/img/<?php echo $imagenes['construccion1'] ?>" alt="image">
							<div class="portfolio_item_hover">
								<div class="item_info">
									<span>Construcción</span>
									<em>Respeto</em>
								</div>
							</div>
						</a>
					</div>
					<!-- end single work -->

					<!-- single work -->
					<div class="col-md-4 construccion">
						<a class="portfolio_item work-grid wow fadeInUp" data-wow-delay=".6s">
							<img src="assets/img/<?php echo $imagenes['construccion2'] ?>" alt="image">
							<div class="portfolio_item_hover">
								<div class="item_info">
									<span>Construcción</span>
									<em>Innovación</em>
								</div>
							</div>
						</a>
					</div>
					<!-- end single work -->

					<!-- single work -->
					<div class="col-md-4 fibra cableado">
						<a class="portfolio_item work-grid wow fadeInUp" data-wow-delay=".7s">
							<img src="assets/img/<?php echo $imagenes['fibra1'] ?>" alt="image">
							<div class="portfolio_item_hover">
								<div class="item_info">
									<span>Fibra optica</span>
									<em>Integridad</em>
								</div>
							</div>
						</a>
					</div>
					<!-- end single work -->

					<!-- single work -->
					<div class="col-md-4 fibra cableado">
						<a class="portfolio_item work-grid wow fadeInUp" data-wow-delay=".8s">
							<img src="assets/img/<?php echo $imagenes['fibra2'] ?>" alt="image">
							<div class="portfolio_item_hover">
								<div class="item_info">
									<span>Fibra Optica</span>
									<em>Orden</em>
								</div>
							</div>
						</a>
					</div>
					<!-- end single work -->

					<!-- single work -->
					<div class="col-md-4 soporte">
						<a class="portfolio_item work-grid wow fadeInUp" data-wow-delay=".9s">
							<img src="assets/img/<?php echo $imagenes['soporte1'] ?>" alt="image">
							<div class="portfolio_item_hover">
								<div class="item_info">
									<span>Soporte técnico</span>
									<em>Dinamismo</em>
								</div>
							</div>
						</a>
					</div>
					<!-- end single work -->

					<!-- single work -->
					<div class="col-md-4 soporte">
						<a class="portfolio_item work-grid wow fadeInUp" data-wow-delay=".10s">
							<img src="assets/img/<?php echo $imagenes['soporte2'] ?>" alt="image">
							<div class="portfolio_item_hover">
								<div class="item_info">
									<span>Soporte técnico</span>
									<em>Proactividad</em>
								</div>
							</div>
						</a>
					</div>
					<!-- end single work -->
				</div>
				<!-- end row -->
			</div>
			<!-- all works end -->
		</div>
		<!-- end container -->
	</section>
	<!-- portfolio -->

	<!-- newsletter -->
	<section class="green-section wow fadeInUp" style="padding:50px 0">
		<div class="container">
			<div class="col-md-6 col-sm-12">
				<div class="row">
					<span class="white-text montserrat-text uppercase" style="font-size:25px;display:block;margin-right: 10px;margin-bottom: 15px;">
						<?php echo $texto_ofrecimiento ?>
					</span>
					<!-- <a href="#" class="btn white" style="margin-top:30px"><span>get in touch</span></a> -->
				</div>
			</div>

			<div class="col-md-6 col-sm-12">
				<div class="row">
					<div class="white-section" style="padding:20px">
						<span class="montserrat-text uppercase" style="font-size:24px"><?php echo $titulo_contacto ?></span>
						<p>
							<?php echo $texto_motivo_contacto ?>
						</p>
						<form action="#" method="post">
							<div class="input_1">
								<input type="text" name="email">
								<span>Direccion de correo</span>
							</div>
							<button type="submit" class="btn green" style="margin-top:20px"><span>Enviar</span></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- FOOTER -->
	<footer class="main-footer wow fadeInUp">
		<div class="container">
			<div class="col-md-8 col-sm-12">
				<div class="row">
					<nav class="footer-nav">
						<ul>
							<!--<li><a href="index.html" class="animsition-link link">Home</a></li>
							<li><a href="about.html" class="animsition-link link">about us</a></li>
							<li><a href="services.html" class="animsition-link link">services</a></li>
							<li><a href="portfolio-1.html" class="animsition-link link">portfolio</a></li>
							<li><a href="blog-1.html" class="animsition-link link">blog</a></li>
							<li><a href="contact.html" class="animsition-link link">contact us</a></li> -->
						</ul>
					</nav>
				</div>
			</div>

			<div class="col-md-4 col-sm-12" style="text-align:right">
				<div class="row">
					<div class="uppercase gray-text">
						zipcom&copy;2018. all rights reserved.
					</div>
					<ul class="social-icons" style="margin-top:30px;float:right">
						<!--<li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
						<li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
						<li><a href="#"><i class="icon ion-social-youtube"></i></a></li>
						<li><a href="#"><i class="icon ion-social-linkedin"></i></a></li>
						<li><a href="#"><i class="icon ion-social-pinterest"></i></a></li>
						<li><a href="#"><i class="icon ion-social-instagram"></i></a></li>-->
					</ul>
				</div>
			</div>
		</div>
	</footer>

	<!-- Botón flotante para abrir el modal -->
	<button id="openChat">💬</button>

	<!-- Modal del ChatBot -->
	<div id="chatModal" class="modal">
		<div class="modal-content">
			<span class="close">&times;</span>
			<h2>ChatBot</h2>
			<div id="chat-container">
				<div id="chat-log"></div>
				<input type="text" id="user-input" placeholder="Escribe algo...">
				<button id="send-button" onclick="sendMessage()">Enviar</button>
			</div>
		</div>
	</div>

	<script>
		// Obtener el modal y el botón para abrirlo
		var modal = document.getElementById("chatModal");
		var btn = document.getElementById("openChat");
		var span = document.getElementsByClassName("close")[0];

		// Abrir el modal
		btn.onclick = function() {
			modal.style.display = "block";
		}

		// Cerrar el modal
		span.onclick = function() {
			modal.style.display = "none";
		}

		// Cerrar el modal si se hace clic fuera del contenido
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}

		function sendMessage() {
			var userInput = document.getElementById("user-input").value;
			document.getElementById("user-input").value = ''; // Limpiar el campo de texto

			fetch('botman.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify({
						driver: 'web',
						message: userInput // Enviar bajo la clave "message"
					})
				})
				.then(response => {
					if (!response.ok) {
						throw new Error("Error en la respuesta del servidor");
					}
					return response.json(); // Asegurarse de que la respuesta es JSON
				})
				.then(data => {
					// Mostrar el mensaje enviado por el usuario
					document.getElementById("chat-log").innerHTML += '<p><b>Tú:</b> ' + userInput + '</p>';

					// Verificar si el bot responde con un mensaje
					if (data && data.messages && data.messages.length > 0) {
						let botResponse = data.messages[0].text;
						document.getElementById("chat-log").innerHTML += '<p><b>Chatbot:</b> ' + botResponse + '</p>';
					} else if (data.message) {
						document.getElementById("chat-log").innerHTML += '<p><b>Error:</b> ' + data.message + '</p>';
					}
				})
				.catch(error => {
					console.error('Error:', error);
				});
		}
	</script>


	<!-- SCRIPTS -->
	<script type="text/javascript" src="assets/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="assets/js/isotope.pkgd.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.flexslider.js"></script>
	<script type="text/javascript" src="assets/js/smoothScroll.js"></script>
	<script type="text/javascript" src="assets/js/jquery.animsition.min.js"></script>
	<script type="text/javascript" src="assets/js/wow.min.js"></script>
	<script type="text/javascript" src="assets/js/main.js"></script>

	<script type="text/javascript" charset="utf-8">
		$(window).load(function() {
			new WOW().init();

			// initialise flexslider
			$('.site-hero').flexslider({
				animation: "fade",
				directionNav: false,
				controlNav: false,
				keyboardNav: true,
				slideToStart: 0,
				animationLoop: true,
				pauseOnHover: false,
				slideshowSpeed: 4000,
			});


			// initialize isotope
			var $container = $('.portfolio_container');
			$container.isotope({
				filter: '*',
			});

			$('.portfolio_filter a').click(function() {
				$('.portfolio_filter .active').removeClass('active');
				$(this).addClass('active');

				var selector = $(this).attr('data-filter');
				$container.isotope({
					filter: selector,
					animationOptions: {
						duration: 500,
						animationEngine: "jquery"
					}
				});
				return false;
			});
		});
	</script>
</body>

</html>