<?php
    $errorMessage = '';
    if (isset($_GET["loginFailed"]) and $_GET["loginFailed"] === 'true') {
        $errorMessage = '
        <div class="error-message">
            Username/Password is incorrect
        </div>
        ';
    } else if (isset($_GET["expired"]) and $_GET["expired"] === 'true') {
        $errorMessage = '
        <div class="error-message">
            Your session is expired
        </div>
        ';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link type="text/css" rel="stylesheet" href="/view/login/login.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Pathway+Gothic+One" rel="stylesheet">
</head>
<body>
    <div class="login-box">
        <h1>LOGIN</h1>
        <?php echo $errorMessage; ?>
        <form class="login-form" action="/controller/login.php" method="post">
            <table>
                <tr>
                    <td>
                        <label for="username">Username</label>
                    </td>
                    <td>
                        <input type="text" id="username" name="username">
                        <div class="validation hidden" id="username-validation">
                            Username cannot be empty!
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Password</label>
                    </td>
                    <td>
                        <input type="password" id="password" name="password">
                        <div class="validation hidden" id="password-validation">
                            Password cannot be empty!
                        </div>
                    </td>
                </tr>
            </table>
            <div id="register-button">
                <a href="/view/register">Don't have an account?</a>
            </div>
            <div class="login-button">
                <input id="login-button" type="submit" value="LOGIN" disabled>
            </div>
        </form>
    </div>
    <script src="/view/login/script.js"></script>
</body>
</html>