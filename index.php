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
// taken from https://stackoverflow.com/a/4356295
function generateRandomString($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}
?>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['code-submit'])) {
        if(isset($_POST['code'])) {
            $penis = htmlspecialchars($_POST['code']);
            echo $penis;
        }
    } else if (isset($_POST['new-table-submit'])) {
    
    }
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
    <?php include_once("./templates/header.php") ?>

    <div class="container d-flex flex-column justify-content-center" style="height: 80vh;">
        <div class="container d-flex flex-column justify-content-between">
            <div class="container d-flex justify-content-center align-items-center text-center">
                <form method="POST">
                    <div class="mb-3">
                        <label for="code" class="form-label">Enter Code:</label>
                        <input type="text" class="form-control text-center" id="code" name="code" placeholder="#########">
                    </div>
                    <button type="submit" name="code-submit" class="btn btn-primary">Enter</button>
                </form>
            </div>

            <p class="text-center" style="overflow: hidden;">_______________________________________________</p>

            <div class="container d-flex justify-content-center align-items-center text-center">
                <form method="POST">
                    <div class="mb-3">
                        <label for="new-table" class="form-label">Create New Table:</label>
                        <input type="text" class="form-control text-center" id="new-table" name="new-table" placeholder="Table Name">
                    </div>
                    <button type="submit" name="new-table-submit" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>

    <?php include_once("./templates/footer.php"); ?>
</body>

</html>