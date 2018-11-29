<?php
    $client = new SoapClient("http://localhost:8888/ws/book?wsdl");
    $params = array("bookId" => "szF_pLGmJTQC", "userBankId" => 1, numOfBooks => 1);
    // Convert stdClass to array using (array)
    $response = (array) $client->__soapCall("getBooksByTitle", $params);
    var_dump((array) $response);
?>