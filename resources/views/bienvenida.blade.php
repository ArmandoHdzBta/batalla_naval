<!DOCTYPE HTML>
<!--
	Aerial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>Bienvenido a Batalla Naval</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="/css/carga/main.css" />
    <noscript><link rel="stylesheet" href="/css/carga/noscript.css" /></noscript>
    <style type="text/css">
        .boton_personalizado{
            text-decoration: none;
            padding: 10px;
            font-weight: 600;
            font-size: 20px;
            color: #ffffff;
            background-color: #b70322;
            border-radius: 6px;
            border: 2px solid #f1f1f1;

        }
    </style>
</head>
<body class="is-preload">
<div id="wrapper">
    <div id="bg"></div>
    <div id="overlay"></div>
    <div id="main">

        <!-- Header -->
        <header id="header">
            <h1>Bienvenido a Batalla Naval</h1>
            <p style="margin-bottom: 5%;">Divertido&nbsp;&bull;&nbsp; Programación &nbsp;&bull;&nbsp; Mi primer vista en Laravel</p>
            <a href="{{route('login')}}" class="boton_personalizado" href="#">¡Comenzar!</a>
            <nav style="margin-top: 5%;">
                <ul>
                    <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
                    <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
                    <li><a href="#" class="icon brands fa-dribbble"><span class="label">Dribbble</span></a></li>
                    <li><a href="#" class="icon brands fa-github"><span class="label">Github</span></a></li>
                    <li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
                </ul>
            </nav>
        </header>

        <!-- Footer -->
        <footer id="footer">
            <span class="copyright">&copy; Untitled. Design: <a href="#">Emmanuel Torres Servín</a>.</span>
        </footer>

    </div>
</div>
<script>
    window.onload = function() { document.body.classList.remove('is-preload'); }
    window.ontouchmove = function() { return false; }
    window.onorientationchange = function() { document.body.scrollTop = 0; }
</script>
</body>
</html>
