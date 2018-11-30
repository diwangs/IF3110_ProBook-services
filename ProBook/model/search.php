<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/model/database.php");

function getSearchResult($searchQ) {
    global $mysqli;
    $query1 = "
      CREATE VIEW rtemp AS 
      SELECT 
        book_id, 
        IFNULL(AVG(rating),0) AS rate_avg, 
        COUNT(rating) AS rate_count 
      FROM
        orders NATURAL JOIN review
      GROUP BY
        book_id;";

    $query2 = "
    SELECT 
        book.book_id,
        book.title,
        book.author,
        book.description,
        book.image_link,
        IFNULL(rtemp.rate_avg,0) as rate_avg,
        IFNULL(rtemp.rate_count,0) as rate_count
      FROM
        book LEFT OUTER JOIN  rtemp ON book.book_id = rtemp.book_id
      WHERE title LIKE '%" . $searchQ . "%'
         OR description LIKE '%" . $searchQ . "%';";
      
    $query3 = "DROP VIEW rtemp;";

    $mysqli->query($query1);
    $result = $mysqli->query($query2);
    $mysqli->query($query3);

    return $result;
}