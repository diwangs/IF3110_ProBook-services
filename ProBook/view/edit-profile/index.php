<?php
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/login.php");
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/history.php");

    if (!isTokenValid($_COOKIE['accessToken'])){
        exit();
    }

    $activeTab = "profile";

    $profilePictureErrorMessage = '';
    // Get user from database
    if (isset($_GET["picture-error"])) {
        if ($_GET["picture-error"] === 'size') {
            $profilePictureErrorMessage = 'Picture size should be less than 1MB';
        } else if ($_GET["picture-error"] === 'type') {
            $profilePictureErrorMessage = 'Picture should be an image type';
        } else if ($_GET["picture-error"] === 'unknown') {
            $profilePictureErrorMessage = 'Unknown error occurred while uploading';
        }
    }

    $user = getUser($_COOKIE["userId"]);
    $username = $user["username"];

?>

<html>
    <head>
        <title>Edit Profile</title>
        <link rel="stylesheet" href="/assets/global/global.css">
        <link rel="stylesheet" href="/view/edit-profile/style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <?php include ($_SERVER[DOCUMENT_ROOT] . "/assets/header/header.php"); ?>
            <div class="content">
                <h1>Edit Profile</h1>
                <form method="post" action="/controller/edit-profile.php" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>
                                <div>
                                    <img src="<?php echo $user["prof_pic"] ?>">
                                </div>
                            </td>
                            <td>
                                <div class="validation profile-picture"><?php echo  $profilePictureErrorMessage ?></div>
                                <label for="profile-picture">Update profile picture</label>
                                <input type="file" id="profile-picture" name="profilePicture" accept="image/*">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="name">Name</label>
                            </td>
                            <td>
                                <input type="text" id="name" name="name" value="<?php echo $user["fullname"] ?>">
                                <div class="validation name hidden">Name cannot be empty</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="address">Address</label>
                            </td>
                            <td>
                                <textarea id="address" name="address"><?php echo $user["addrs"] ?></textarea>
                                <div class="validation address hidden">Address cannot be empty</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="phone-number">Phone Number</label>
                            </td>
                            <td>
                                <input type="tel" id="phone-number" name="phoneNumber" value="<?php echo $user["phone_num"] ?>">
                                <div class="validation phone-number hidden">Phone Number should be between 9 to 12</div>
                            </td>
                        </tr>

                    </table>
                    <a id="back-button" href="/view/profile">Back</a>
                    <input type="hidden" name="userId" value="<?php echo $user["user_id"] ?>">

                    <input id="save-button" type="submit" value="Save">
                </form>
            </div>
        </div>

        <script src="/view/edit-profile/script.js"></script>
    </body>
</html>