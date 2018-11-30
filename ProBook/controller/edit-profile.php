<?php

include_once ($_SERVER["DOCUMENT_ROOT"] . "/model/edit-profile.php");

// Upload Profile Picture
function uploadPicture() {
    $target_dir = $_SERVER["DOCUMENT_ROOT"] . "/assets/profile-pictures/";
    $target_file = $target_dir . $_POST["userId"] . ".jpg";
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_FILES["profilePicture"])) {
        echo "process file";
        $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
        } else {
            echo "File is not an image.";
            header("Location: /view/edit-profile?picture-error=type");
            exit();
        }
    }
    // Check file size
    if ($_FILES["profilePicture"]["size"] > 1000000) {
        echo "Sorry, your file is too large.";
        header("Location: /view/edit-profile?picture-error=size");
        exit();
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: /view/edit-profile?picture-error=type");
        exit();
    }

    if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["profilePicture"]["name"]). " has been uploaded.";
    } else {
        header("Location: /view/edit-profile?picture-error=unknown");
        exit();
    }
}

// Update Profile
try {
    if ($_FILES["profilePicture"]["error"] === 0) {
        uploadPicture();
    }
    updateProfile($_POST["userId"], "/assets/profile-pictures/" . $_POST["userId"] . ".jpg" , $_POST["name"], $_POST["address"], $_POST["phoneNumber"]);
    header("Location: /view/profile");
    exit();
} catch (Exception $e) {
    $e->getMessage();
}
