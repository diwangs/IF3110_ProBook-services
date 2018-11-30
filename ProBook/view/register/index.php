<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link type="text/css" rel="stylesheet" href="/view/register/style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Pathway+Gothic+One" rel="stylesheet">
</head>
<body>
    <div class="register-box">
    <h1>REGISTER</h1>
    <form class="register-form" action="/controller/register.php" method="post">
        <table class="input-field-container">
            <colgroup>
                <col style="width:40%">
                <col style="width:50%">
                <col style="width:10%">
            </colgroup>
            <tr>
                <td class="form-label"><label for="fullname">Name</label></td>
                <td colspan="2"><input type="text" id="fullname" name="fullname"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="validation-text" id="fullname-validation-text"><!-- --></td>
            </tr>
            <tr>
                <td class="form-label"><label for="username">Username</label></td>
                <td><input type="text" id="username" name="username"></td>
                <td><div class="validation-icon" id="username-validation-icon"><!-- --></div></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="validation-text" id="username-validation-text"><!-- --></td>
            </tr>
            <tr>
                <td class="form-label"><label for="email">Email</label></td>
                <td><input type="text" id="email" name="email"></td>
                <td><div class="validation-icon" id="email-validation-icon"><!--  --></div></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="validation-text" id="email-validation-text"><!-- --></td>
            </tr>
            <tr>
                <td class="form-label"><label for="password">Password</label></td>
                <td colspan="2"><input type="password" id="password" name="password"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="validation-text" id="password-validation-text"><!-- --></td>
            </tr>
            <tr>
                <td class="form-label"><label for="confirmpassword">Confirm Password</label></td>
                <td colspan="2"><input type="password" id="confirmpassword" name="confirmpassword"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="validation-text" id="confirmpassword-validation-text"><!-- --></td>
            </tr>
            <tr>
                <td class="form-label" id="address-label"><label for="address">Address</label></td>
                <td colspan="2"><textarea rows="3" id="address" name="address"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="validation-text" id="address-validation-text"><!-- --></td>
            </tr>
            <tr>
                <td class="form-label"><label for="phonenumber">Phone Number</label></td>
                <td colspan="2"><input type="text" id="phonenumber" name="phonenumber"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="validation-text" id="phonenumber-validation-text"><!-- --></td>
            </tr>
        </table>
        <div id="login-button">
            <a href="/view/login">Already have an account?</a>
        </div>
        <div class="register-button">
            <input id="register-button" type="submit" value="REGISTER">
        </div>
    </form>
    <script type="text/javascript" src="/view/register/script.js"></script>
</body>
</html>