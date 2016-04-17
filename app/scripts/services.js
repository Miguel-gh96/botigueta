exports.apiconnect = function ($http, $q) {

  var serviceBase = 'http://localhost/hipoteca/api/v1/index.php?module=';
  var obj = {};

  //get data
  obj.get = function (module, functi, data) {

    var defered = $q.defer();
    var promise = defered.promise;

    $http({
      method:'GET',
      url: serviceBase + module +'&function=' + functi + '&id=' + data,
    }).success(function (data, status, headers, config){
      defered.resolve(data);
    }).error(function(data,status, headers, config){
      defered.reject(data);
    });

    return promise;

  }

  //delete data
  obj.delete = function (module, functi, data) {

    var defered = $q.defer();
    var promise = defered.promise;

    $http({
      method:'DELETE',
      url: serviceBase + module +'&function=' + functi + '&id=' + data,
    }).success(function (data, status, headers, config){
      defered.resolve(data);
    }).error(function(data,status, headers, config){
      defered.reject(data);
    });

    return promise;

  }

  //new data
  obj.post = function (module, functi, data) {

    var defered = $q.defer();
    var promise = defered.promise;

    $http({
      method:'POST',
      url: serviceBase + module +'&function=' + functi,
      data: data
    }).success(function (data, status, headers, config){
      defered.resolve(data);
    }).error(function(data,status, headers, config){
      defered.reject(data);
    });

    return promise;

  }

  //update data
  obj.put = function (module, functi, data) {

    var defered = $q.defer();
    var promise = defered.promise;

    $http({
      method:'PUT',
      url: serviceBase + module +'&function=' + functi,
      data: data
    }).success(function (data, status, headers, config){
      defered.resolve(data);
    }).error(function(data,status, headers, config){
      defered.reject(data);
    });

    return promise;

  }

  return obj

};
