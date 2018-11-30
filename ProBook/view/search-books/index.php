<?php
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/profile.php");
    include ($_SERVER["DOCUMENT_ROOT"] . "/model/login.php");

    if (!isTokenValid($_COOKIE['accessToken'])){
        exit();
    }
    $activeTab = "browse";

    //Get User From Database

    $user = getUser($_COOKIE["userId"]);
    $username = $user["username"];

?>

<html lang="en" ng-app="book">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
        <script src="/view/search-books/controller.js"></script>
     
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Books</title>
        <link rel="stylesheet" href="/assets/global/global.css">
        <link rel="stylesheet" href="/view/search-books/style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>

    <body ng-controller="bookCtrl">
        <div class="container">
            <?php include ($_SERVER['DOCUMENT_ROOT'] . "/assets/header/header.php"); ?>
            <div class="content">
                <h1>Search Book</h1>
                <form>
                    <input type="text" id="search-bar" placeholder="Input search terms..." name="search-txt" ng-change="delayedSearch(searchTerms)" ng-model="searchTerms">
                    <h5 ng-show="isSearching">Searching...</h5>
                    <h5 ng-show="!isSearching && searchTerms && !searchResults.length">Not Found</h5>
                    <ul>
                        <br>
                        <li ng-repeat="searchResult in searchResults">
                            <div class="list-content flex-container">
                                <div class="image-holder"><img src="{{ searchResult.imageUrl }}"></div>
                                <div class="left-text-holder">
                                        <h2>{{ searchResult.title }}</h2>
                                        <div class="left-order-details"> <b>Author</b></div>
                                        <div class="left-order-details">{{ searchResult.description }}</div>
                                </div>
                                <div class="right-text-holder">
                                        <div class="detail-button"><a href="/view/book-detail?book-id={{ searchResult.id }}">Detail</a></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </body>
</html>