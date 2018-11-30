<?php
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/profile.php");
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/login.php");

    if (!isTokenValid($_COOKIE['accessToken'])){
        exit();
    }

    $activeTab = "profile";

    //Get User From Database

    $user = getUser($_COOKIE["userId"]);
    $username = $user["username"];

?>

<html>
    <head>
        <title>Profile</title>
        <link rel = "stylesheet" href="/assets/global/global.css">
        <link rel = "stylesheet" href="/view/profile/style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>

    <body>
        <?php
            echo $userDat;
        ?>
        <div class="container">
            <?php include ($_SERVER[DOCUMENT_ROOT] . "/assets/header/header.php"); ?>

            <div class="pic-cont">
                <div id="edit-button">
                    <a href="/view/edit-profile" ><img id="img-but1" class="inverted" src="/assets/images/edit.png" /></a>
                </div>
                <img id="avatar-img" src="<?php echo $user["prof_pic"] ?>"/>
                <h2 id="fullname"><?php echo $user["fullname"] ?></h2>
            </div>

            <div class="content">
                <h2>My Profile</h2>
                <table>
                    <tr>
                        <td>
                            <img class="icon" src="/assets/images/username.png"/>
                            Username
                        </td>
                        <td>
                            <?php echo $user["username"] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="icon" src="/assets/images/mail.png"/>
                            Email
                        </td>
                        <td>
                            <?php echo $user["email"] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="icon" src="/assets/images/address.png"/>
                            Address
                        </td>
                        <td>
                            <?php echo $user["addrs"] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="icon" src="/assets/images/phone.png"/>
                            Phone Number

                        </td>
                        <td>
                            <?php echo $user["phone_num"] ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
    