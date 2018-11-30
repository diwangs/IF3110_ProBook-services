<?php
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/login.php");
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/history.php");

    if (!isTokenValid($_COOKIE['accessToken'])){
        exit();
    }

    $activeTab = "history";

    // Get user from database

    $user = getUser($_COOKIE["userId"]);
    $username = $user["username"];

    // Get orders and review
    $historyList = getHistory($user["user_id"]);
    $historyView = '';
    while ($row = $historyList->fetch_assoc()) {
        $historyView = $historyView . '
              <li>
                    <div class="list-content flex-container">
                        <div class="image-holder"><a href="/view/book-detail?book-id=' . $row["book_id"] . '"><img src="' . $row["image_link"] . '"></a></div>
                        <div class="left-text-holder">
                            <a href="/view/book-detail?book-id=' . $row["book_id"] . '"><h2>' . $row["title"] . '</h2></a>
                            <div class="left-order-details">Jumlah ' . $row["num_book"] . '</div>
                            <div class="left-order-details">' . ((isset($row["rating"])) ? "Anda sudah memberikan review" : 'Belum direview') . '</div>
                        </div>
                        <div class="right-text-holder">
                            <div class="right-order-details">' . date_format(date_create($row["order_date"]), "j F Y") . '</div>
                            <div class="right-order-details">Nomor Order : #' . $row["order_id"] . '</div>
                            ' . ((!isset($row["rating"]))? '<div class="review-button"><a href="/view/review?order-id=' . $row["order_id"] . '">Review</a></div>' : "") . '
                        </div>
                    </div>
                </li>
        ';
    }
?>

<html>
    <head>
        <title>History</title>
        <link rel="stylesheet" href="/assets/global/global.css">
        <link rel="stylesheet" href="/view/history/history.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <?php include ($_SERVER[DOCUMENT_ROOT] . "/assets/header/header.php"); ?>
            <div class="content">
                <h1>History</h1>
                <ul>
                    <?php
                        echo $historyView;
                    ?>
                </ul>
            </div>
        </div>
    </body>
</html>