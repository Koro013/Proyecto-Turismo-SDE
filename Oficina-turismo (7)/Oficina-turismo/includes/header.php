<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficina de Turismo de Santiago del Estero</title>
    <link href="/Oficina-turismo/assets/images/favico/favico.png" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;400&family=Bebas+Neue&family=Bungee&display=swap" rel="stylesheet">

    <!-- CSS globales -->
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/theme.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/nav.css">
    <link rel="stylesheet" href="/Oficina-turismo/assets/css/footer.css">

    <!-- CSS específico por página -->
    <?php
    $current = basename($_SERVER['PHP_SELF'], '.php');
    if (file_exists(__DIR__ . "/../assets/css/{$current}-style.css")) {
        echo '<link rel="stylesheet" href="/Oficina-turismo/assets/css/' . $current . '-style.css">';
    }
    ?>
</head>
<body>
