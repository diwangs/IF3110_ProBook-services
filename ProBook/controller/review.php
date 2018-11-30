<?php
include($_SERVER["DOCUMENT_ROOT"] . "/model/review.php");
if (isset($_POST["order_id"]) and isset($_POST["rating"]) and isset($_POST["comment"])) {
    insertReview((int)$_POST["order_id"], (int)$_POST["rating"], $_POST["comment"]);
    header("Location: /view/history");
    exit();
}
?>