<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficina de Turismo de Santiago del Estero</title>
    <link rel="icon" href="/Oficina-turismo/assets/images/favico/favico.png" type="image/x-icon">

    <!-- Bootstrap solo si lo usás -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <!-- Google Fonts: Montserrat + las que ya usás -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;400&family=Bebas+Neue&family=Bungee&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="/Oficina-turismo/assets/css/styles.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/nav.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/footer.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/front/index-style.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/front/destinos-style.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/front/rutas-style.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/front/detalle_destino-style.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/front/detalle_ruta-style.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/front/planificador-style.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/front/contacto-style.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/front/suscripcion-style.css">

    








    <!-- CSS particular de cada página, ej: index, destinos, etc (solo en la página correspondiente) -->
    <?php
    
    // Detecta página actual y carga el CSS específico
    $current = basename($_SERVER['PHP_SELF'], '.php');
    if (file_exists(__DIR__ . "/../assets/css/front/{$current}-style.css")) {
        echo '<link rel="stylesheet" href="/Oficina-turismo/assets/css/front/' . $current . '-style.css">';
    }
    ?>
</head>
<body>

