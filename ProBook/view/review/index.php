<?php
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/login.php");
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/review.php");
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/book-detail.php");
    
    if (!isTokenValid($_COOKIE['accessToken'])){
        exit();
    }

    $activeTab = "history";

    // Get user from database

    $user = getUser($_COOKIE["userId"]);
    $username = $user["username"];

    // Get orders and book details
    
    $orderId = $_GET["order-id"];

    $orderDetail = getOrderDetail($orderId);
    var_dump($orderDetail);
    $bookDetail = getBookDetail($orderDetail["book_id"]);
    echo "\n\n";
    var_dump($bookDetail);

    $bookDetailView = '
    <div class="detail-holder">
        <div class="book-title"><h1>' . $bookDetail["title"] . '</h1></div>
        <div class="book-detail"> </div><h3>' . $bookDetail["authors"] . '</h3>
    </div>
    <div class ="image-holder">
        <img src="' . $bookDetail["imageUrl"] . '" alt="">
    </div>'
?>

<html>
    <head>
        <title>Review</title>
        <link rel="stylesheet" href="/assets/global/global.css">
        <link rel="stylesheet" href="/view/review/style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <?php include ($_SERVER[DOCUMENT_ROOT] . "/assets/header/header.php"); ?>
            <div class="content">
                <div class="flex-container">
                    <?php
                        echo $bookDetailView
                    ?>
                </div>
                <form id="review-form" action="/controller/review.php" method="POST">
                    <input type='hidden' name='order_id' value='<?php echo $orderId;?>'/> 
                    <div id="rating-holder">
                        <h2>Add Rating</h2>
                        <div id="rating-star-holder">
                            <label>
                                <input type="radio" name="rating" value="1">
                                <img class="rating-img" id="star1" src="/assets/images/blank-star-64.png">
                            </label>
                            <label>
                                <input type="radio" name="rating" value="2">
                                <img class="rating-img" id="star2" src="/assets/images/blank-star-64.png">
                            </label>
                            <label>
                                <input type="radio" name="rating" value="3">
                                <img class="rating-img" id="star3" src="/assets/images/blank-star-64.png">
                            </label>
                            <label>
                                <input type="radio" name="rating" value="4">
                                <img class="rating-img" id="star4" src="/assets/images/blank-star-64.png">
                            </label>
                            <label>
                                <input type="radio" name="rating" value="5">
                                <img class="rating-img" id="star5" src="/assets/images/blank-star-64.png">
                            </label>
                        </div>
                        <div class="validation" id="rating-validation"><!-- --></div>
                    </div>
                    <div id="comment-holder">                    
                        <h2>Add Comment</h2>
                        <textarea name="comment" id="comment" rows="5"></textarea>
                        <div class="validation" id="comment-validation"><!-- --></div>
                    </div>
                    <div id="form-button">
                        <input type="button" name="action" id="back" value="Back">
                        <input type="submit" name="action" id="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
        <script src="/view/review/script.js"></script>
    </body>
</html>