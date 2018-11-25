<?php
    $client = new SoapClient("http://localhost:8888/ws/book?wsdl");
    $params = array("id" => "ukulele");
    /* Invoke webservice method with your parameters, in this case: Function1 */
    $response = $client->__soapCall("deleteBook", array($params));

    /* Print webservice response */
    var_dump($response);
?>