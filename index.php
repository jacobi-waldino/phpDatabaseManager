<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
$env = parse_ini_file('.env');


if (!$env) {
    echo "Error loading environment variables.<br>";
    exit;
}

$servername = $env["DB_HOST"];
$username = $env["DB_USR"];
$password = $env["DB_PW"];
$database = $env["DB_DF"];
$port = $env["DB_PORT"];

$mysql = new mysqli($servername, $username, $password, $database, $port);

if (!$mysql) {
    exit;
}
?>

<?php
function getCurrentUrl() {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $domain = $_SERVER['HTTP_HOST'];
    $requestUri = $_SERVER['REQUEST_URI'];
    $currentUrl = $protocol . '://' . $domain . $requestUri;
    
    return $currentUrl;
}

function appendQueryParam($url, $key, $value) {
    if (strpos($url, '?') !== false) {
        $url .= '&' . urlencode($key) . '=' . urlencode($value);
    } else {
        $url .= '?' . urlencode($key) . '=' . urlencode($value);
    }

    return $url;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <?php
        if (isset($_SESSION['error_message'])) {
            echo "<script> alert('" . addslashes($_SESSION['error_message']) . "'); </script>";
            unset($_SESSION['error_message']);
        }
    ?>

    <?php include_once("./templates/header.php") ?>
    
    <?php 
    if (empty($_GET)) {
        include_once("./templates/landing.php");
    }
    else if (isset($_GET["table"])) {
        include_once("./templates/table.php");
    }
    else {
        include_once("./templates/404.php");
    }
    ?>

    <?php include_once("./templates/footer.php"); ?>
</body>

</html>