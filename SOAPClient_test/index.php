<?php
    $client = new SoapClient("http://localhost:8888/ws/book?wsdl");
    $params = array("title" => "Harry Potter");
    // Convert stdClass to array using (array)
    $response = (array) $client->__soapCall("getBooksByTitle", $params);
    var_dump((array) $response);
?>