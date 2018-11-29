var bookNgApp = angular.module('book', [])

var searchDelay = null
var dummyData = ["Harry Potter dan Batu Pinggir Jalan", "Harry Potter dan Jalan Menuju Hikmah", "Bumbu Indomie"]

bookNgApp.controller("bookCtrl", ($scope, $http) => {
    // delayed search: it will wait 1 second for inactivity before querying
    $scope.delayedSearch = function(searchTerms) {
        $scope.hasSearched = false
        clearTimeout(searchDelay)
        // Do the actual search
        searchDelay = setTimeout(() => {
            var buffer = []
            // If not empty, query search
            if (searchTerms) {
                // Bagian ini diganti query ke BookService
                // buffer = array of book object
                dummyData.forEach(element => {if (element.includes(searchTerms)) buffer.push(element)});
            }
            // Send it to the document
            $scope.searchResults = buffer
            $scope.hasSearched = true
            $scope.$apply();
        }, 1000)
    }
})