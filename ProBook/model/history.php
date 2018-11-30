<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");

function getHistory($userId) {
    global $mysqli;
    $query = "
      SELECT 
        orders.order_id,
        orders.num_book,
        orders.order_date,
        review.rating,
        orders.book_id
      FROM
        orders LEFT OUTER JOIN review ON orders.order_id = review.order_id
      WHERE user_id=" . $userId . "
      ORDER BY orders.order_id DESC;
    ";

    $result = $mysqli->query($query);

    return $result;
}