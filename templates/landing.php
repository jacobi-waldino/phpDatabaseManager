
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
            $code = $_POST['code'];
            $sql = "select code from table_masterlist";
            $result = $mysql->query($sql);

            $codes = [];

            if ($result -> num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $codes[] = $row['code'];
                }
            }

            if(in_array($_POST['code'], $codes)) {
                $url = appendQueryParam(getCurrentUrl(), "table", $code);

                header("Location: " . $url);

            }
            else
            {
                $_SESSION['error_message'] = "$code is not a valid code.";
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            }
        }
        else
        {
            
        }
    } else if (isset($_POST['new-table-submit'])) {
        if(isset($_POST['new-table'])) {
            $tablename = $_POST['new-table'];
            $code = generateRandomString();

            $sql = "insert into table_masterlist values (NULL, ?, ?)";
            $stmt = $mysql->prepare($sql);
            $stmt->bind_param("ss", $code, $tablename);

            if ($stmt->execute()) {
                
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();

            $url = appendQueryParam(getCurrentUrl(), "table", $code);

            header("Location: " . $url);
        }
        else
        {
            $_SESSION['error_message'] = "New ables need names.";
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
        }
    }
}
?>

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