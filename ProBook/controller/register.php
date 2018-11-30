<?PHP
include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");
include($_SERVER["DOCUMENT_ROOT"] . "/model/register.php");
include($_SERVER["DOCUMENT_ROOT"] . "/model/login.php");

function isUsernameExist($username) {
    $query = "SELECT * FROM user WHERE username='" . $username . "'";
    global $mysqli;

    $result = $mysqli->query($query);
    error_log($result, 0);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function isEmailExist($email) {
    $query = "SELECT * FROM user WHERE email='" . $email . "'";
    global $mysqli;

    $result = $mysqli->query($query);
    error_log($result, 0);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}



if (isset($_GET['username'])) {
    header('Content-Type: text/plain');
    if (isUsernameExist($_GET['username'])) {
        echo 'taken';
    } else {
        echo 'available';
    }
}

if (isset($_GET['email'])) {
    header('Content-Type: text/plain');
    if (isEmailExist($_GET['email'])) {
        echo 'taken';
    } else {
        echo 'available';
    }
}

if (isset($_POST["fullname"]) and  isset($_POST["username"]) and  isset($_POST["email"]) and isset($_POST["password"]) and isset($_POST["address"]) and isset($_POST["phonenumber"])) {
    createUser($_POST["fullname"], $_POST["username"], $_POST["email"], $_POST["password"], $_POST["address"], $_POST["phonenumber"]);
    $user = findUsernamePassword($_POST["username"], $_POST["password"]);
    $redirectLink = "/view/profile";
    setcookie("userId", $user["user_id"], 0, "/");
    header("Location: " . $redirectLink);
    exit();
}

?>