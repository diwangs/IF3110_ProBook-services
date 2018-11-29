var bookNgApp = angular.module('book', [])

var searchDelay = null

bookNgApp.controller("bookCtrl", ($scope, $http) => {
    // delayed search: it will wait 1 second for inactivity before querying
    $scope.delayedSearch = function(searchTerms) {
        $scope.isSearching = true
        clearTimeout(searchDelay)
        // search after 1000 ms
        searchDelay = setTimeout(() => {
            if (searchTerms) {
                // If not empty, AJAX to searchBooks.php
                var req = new XMLHttpRequest()
                req.onload = () => {
                    $scope.isSearching = false
                    $scope.searchResults = JSON.parse(req.responseText).item
                    $scope.$apply();
                }
                // Change the php file address if necessary
                req.open("GET", "http://localhost:3000/searchBooks.php?q=" + encodeURIComponent(searchTerms), true)
                req.send()
            } else {
                // else, do nothing
                $scope.isSearching = false
                $scope.$apply();
            }
        }, 1000)
    }
})