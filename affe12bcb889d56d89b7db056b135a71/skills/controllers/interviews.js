var myApp = angular.module ('myApp', []);

myApp.controller ('MyController', ['$scope', '$http',function ($scope, $http){
   
$http.get('controllers/data.json').success(function(data){
 $scope.skills = data;
 $scope.searchorder = 'languages';
});

}]);


myApp.controller ('dateController', function($scope){

$scope.date = new Date();

});

