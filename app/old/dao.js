function HipotecaResourceProvider() {
  var _baseUrl;
  this.setBaseUrl = function(baseUrl) {
    _baseUrl = baseUrl;
  };
  this.$get = ['$http', '$q', function($http, $q) {
    return new HipotecaResource($http, $q, _baseUrl);
  }];
}

function HipotecaResource($http, $q, baseUrl) {

  this.service = function(url_) {
    var defered = $q.defer();
    var promise = defered.promise;
    $http({
      method: 'GET',
      url: url_
    }).success(function(data, status, headers, config) {
      defered.resolve(data);
    }).error(function(data, status, headers, config) {
      if (status === 400) {
        defered.reject(data);
      } else {
        throw new Error("Fallo obtener los datos:" + status + "\n" + data);
      }
    });
    return promise;
  };

}

app.provider("hipotecaResource", HipotecaResourceProvider);
