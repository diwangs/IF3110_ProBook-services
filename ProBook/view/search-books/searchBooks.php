<?php
    $client = new SoapClient("http://localhost:8888/ws/book?wsdl");
    $params = array("title" => $_GET['q']);
    // Convert stdClass to array using (array)
    $response = $client->__soapCall("getBooksByTitle", $params);
    echo json_encode($response);
?>