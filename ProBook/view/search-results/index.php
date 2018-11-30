<?php
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/login.php");
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/search.php");

    if (!isset($_COOKIE["userId"])){
        header("Location: /view/login?auth=false");
        exit();
    }
    $activeTab = "browse";

    //Get User From Database

    $user = getUser($_COOKIE["userId"]);
    $username = $user["username"];

    //Get results from database
    $resultlist = getSearchResult($_GET['search-txt']);
    $resultView = '';
    while ($row = $resultlist->fetch_assoc()){
        $resultView = $resultView. '
            <li>
                <div class="list-content flex-container">
                    <div class="image-holder"><a href="/view/book-detail?book-id=' . $row["book_id"] . '"><img src="' . $row["image_link"] . '"></a></div>
                    <div class="left-text-holder">
                            <a href="/view/book-detail?book-id=' . $row["book_id"] . '"><h2>' . $row["title"] . '</h2></a>
                            <div class="left-order-details"> <b>' . $row["author"] . ' - ' . number_format($row["rate_avg"],1) . '/5.0 ('. $row["rate_count"].' votes)</b></div>
                            <div class="left-order-details">' . $row["description"] . '</div>
                    </div>
                    <div class="right-text-holder">
                            <div class="detail-button"><a href="/view/book-detail?book-id=' . $row["book_id"] . '">Detail</a></div>
                    </div>
                </div>
            </li>
        ';
    }


?>
<html>
    <head>
        <title><?php echo $_GET["search-txt"] ?> | Search Results</title>
        <link rel = "stylesheet" href="/assets/global/global.css">
        <link rel = "stylesheet" href="/view/search-results/style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php include ($_SERVER['DOCUMENT_ROOT'] . "/assets/header/header.php"); ?>
            <div class="content">
                <h1 class="head-txt">Search Result</h1>
                <ul>
                    <?php
                        echo (strlen($resultView)) ? $resultView : ("Books with title '" . $_GET["search-txt"] . "' is not found");
                    ?>
                </ul>
            </div>
        </div>
    </body>
</html>