<?PHP
include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");
include($_SERVER["DOCUMENT_ROOT"] . "/model/book-detail.php");

if (isset($_POST["userid"]) and isset($_POST["bookid"]) and isset($_POST["userbankid"]) and isset($_POST["totalorder"])) {
    // echo ('' . (int)$_POST["userid"] . ' ' . (int)$_POST["bookid"] . ' ' . (int)$_POST["totalorder"]);
    $order_id = createOrder((int)$_POST["userid"], $_POST["bookid"],(int) $_POST["userbankid"], (int)$_POST["totalorder"]);
    header('Content-Type: text/plain');
    echo $order_id;
}
?>