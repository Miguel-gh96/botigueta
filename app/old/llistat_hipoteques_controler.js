app.controller("HipotecaListController", ['$scope','service', 'hipotecaResource','$routeParams', function($scope,service,hipotecaResource,$routeParams) {
  $scope.hipotecas = service;
}]);
