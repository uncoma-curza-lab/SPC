<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Recordatorio - Plazo de entrega de programas de cátedra</title>
	<style type="text/css">
		body {
			font-family: Arial, sans-serif;
			font-size: 14px;
			line-height: 1.5;
			color: #333333;
			margin: 0;
			padding: 0;
		}
		h3, h4 {
			text-align: center;
			margin: 20px 0;
		}
		h3 {
			color: #004990;
			font-size: 28px;
			font-weight: bold;
			margin-bottom: 5px;
		}
		h4 {
			color: #0096d6;
			font-size: 24px;
			font-weight: normal;
			margin-bottom: 20px;
		}
		p {
			margin: 20px 0;
			line-height: 1.5;
		}
		.container {
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
		}
		.btn {
			display: block;
			background-color: #0096d6;
			color: #ffffff;
			font-size: 16px;
			font-weight: bold;
			text-align: center;
			text-decoration: none;
			padding: 10px 20px;
			border-radius: 5px;
			margin-top: 20px;
		}
		.btn:hover {
			background-color: #004990;
		}
        .small-print {
            font-size: 12px;
            color: #666666;
            margin-top: 40px;
            text-align: center;
        }
	</style>
</head>
<body>
	<div class="container">
		<h3>Universidad Nacional del Comahue</h3>
		<h4>Sistema de programas de cátedra</h4>
		<p>Estimados/as docentes,</p>
		<p>Por medio de la presente, nos dirigimos a ustedes con el fin de recordarles que el plazo de entrega de los programas de cátedra correspondientes al año académico en curso finaliza hoy, <?= date_create()->format('d-m-Y') ?>. De acuerdo a la normativa vigente, la presentación de los programas es obligatoria y su cumplimiento es requisito indispensable para el correcto desarrollo de las actividades académicas en la Universidad Nacional del Comahue.</p>
		<p>El Sistema de programas de cátedra de nuestra institución es una herramienta fundamental para la planificación y organización de las actividades docentes, así como para la garantía de la calidad de la enseñanza que ofrecemos a nuestros/as estudiantes. En este sentido, les instamos a que completen y envíen sus programas a la brevedad, a fin de asegurar el cumplimiento de los objetivos académicos previstos.</p>
		<p>Agradecemos su colaboración y compromiso con la educación superior pública, y quedamos a su disposición para cualquier consulta o aclaración al respecto.</p>
		<a href="https://apps.curza.uncoma.edu.ar/" class="btn">Ingresar al sistema</a>
		<p class="small-print">Este es un mensaje autogenerado, por favor no responder.</p>
	</div>
</body>
</html>
