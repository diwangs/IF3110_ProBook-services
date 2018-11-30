<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");

function getBookDetail($bookId) {
    $client = new SoapClient("http://localhost:8888/ws/book?wsdl");
    $params = array("id" => $bookId);
    // Convert stdClass to array using (array)
    $response = (array) $client->__soapCall("getBookById", $params);
    return $response;
}

function getRandomBookByCategories($categories) {
    $client = new SoapClient("http://localhost:8888/ws/book?wsdl");
    $params = array("categories" => urlencode($categories));
    // Convert stdClass to array using (array)
    $response = (array) $client->__soapCall("getRandomBookByCategories", $params);
    return $response;
}

function createTransaction($bookId, $userBankId, $numOfBooks) {
    $client = new SoapClient("http://localhost:8888/ws/book?wsdl");
    $params = array("bookId" => $bookId, "userBankId" => $userBankId, "numOfBooks" => $numOfBooks);
    $response = (array) $client->__soapCall("buyBook", $params);
    return $response;
}

function getBookReview($bookId) {
    global $mysqli;

    $query="
        SELECT review.rating, review.content, user.username, user.prof_pic
        FROM review INNER JOIN orders USING (order_id) INNER JOIN user ON (user.user_id = orders.user_id)
        WHERE book_id = '" . $bookId . "' ORDER BY order_date DESC;
    ";
    
    $result = $mysqli->query($query);

    if ($result->num_rows <= 0) {
        return null;
    }
    return $result;
}

function getRating($bookId) {
    global $mysqli;

    $query="
        SELECT AVG(review.rating) as average, COUNT(review.rating) as count
        FROM review INNER JOIN orders USING (order_id)
        WHERE book_id = '" . $bookId . "' GROUP BY orders.book_id;
    ";
    

    $result = $mysqli->query($query);
    // var_dump($result->fetch_assoc());
    // var_dump($result->fetch_assoc()["average_rating"]);
    return $result->fetch_assoc();
}

function createOrder($userId, $bookId, $userBankId, $numBook) {
    global $mysqli;

    $transaction = createTransaction($bookId, $userBankId, $numBook);
    if ($transaction[0] == false) {
        return null;
    } else {
        $date = date("Y-m-d");

        $query="
            INSERT INTO orders (user_id, book_id, num_book, order_date)
            VALUES (" . $userId . ", '" . $bookId . "', " . $numBook . ", '" . $date . "');
            ";
        $result = $mysqli->query($query);
        $query="
            SELECT LAST_INSERT_ID();
        ";
        $result = $mysqli->query($query);
        return $result->fetch_assoc()["LAST_INSERT_ID()"];
    }    
}

?>