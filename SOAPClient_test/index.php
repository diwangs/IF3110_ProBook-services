<?php
    $client = new SoapClient("http://localhost:8888/ws/book?wsdl");
    $params = array("id" => "iQmPNDIAskUC");
    $response = (array) $client->__soapCall("getBookById", $params);
    // $params = array("bookId" => "szF_pLGmJTQC", "userBankId" => 1, "numOfBooks" => 1);
    // Convert stdClass to array using (array)
    // $response = (array) $client->__soapCall("buyBook", $params);
    var_dump((array) $response);
?>