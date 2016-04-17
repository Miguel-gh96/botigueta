exports.MainController = function($scope) {
  $scope.urlPie = "views/peu.html";
}

exports.HipotecaListController = function($scope, $http, apiconnect) {
  $scope.hipotecas = [];

  //GET data
  apiconnect.get('crud', 'get_all', '').then(function(results){
    console.log(results);
    if(results.success){
      $scope.hipotecas = results.data;
    }else{
      console.log('error');
      console.log(results);
    }
  });

  $scope.delete = function(index, idHipo) {
    apiconnect.delete('crud','delete',idHipo).then(function(results){
      if(results.success){
        console.log('success');
        console.log(results);
        $scope.hipotecas.splice(index,1);
      }else{
        console.log('error');
        console.log(results);
      }
    });
  }

}

exports.MostrarHip_controller = function($scope, $http, $route, apiconnect, $sce) {
  $scope.hipo = {};
  $scope.hipoteca = {
    nif: "",
    nombre: "",
    ape1: "",
    ape2: "",
    edad: undefined,
    telefono: "",
    email: "",

    dades_economiques: {
      ingresos_mensuales: undefined,
      capital: undefined,
      tipo_interes: "variable",
      euribor: undefined,
      diferencial: undefined,
      interes_fijo: undefined,
      plazo_anyos: undefined,
      producto_segurocasa: false,
      producto_nomina: false,
      producto_segurovida: false
    },

    cuota_mensual: undefined,
    interes_aplicado: undefined,
    total_interesos: undefined
  }

  $scope.error = {
    nif: "",
    nombre: "",
    ape1: "",
    ape2: "",
    edad: "",
    telefono: "",
    email: "",
  };

  apiconnect.get('crud', 'get', $route.current.params.idPersona).then(function(results){
    if(results.success){
      console.log(results);
      $scope.hipo = results.data;
      $scope.hipoteca = {
        nif: $scope.hipo.nif,
        nombre: $scope.hipo.nombre,
        ape1: $scope.hipo.ape1,
        ape2: $scope.hipo.ape2,
        edad: $scope.hipo.edad,
        telefono: $scope.hipo.telefono,
        email: $scope.hipo.email,
        dades_economiques: {
          ingresos_mensuales: $scope.hipo.dades_economiques.ingresos_mensuales,
          capital: $scope.hipo.dades_economiques.capital,
          tipo_interes: $scope.hipo.dades_economiques.tipo_interes,
          euribor: $scope.hipo.dades_economiques.euribor,
          diferencial: $scope.hipo.dades_economiques.diferencial,
          interes_fijo: $scope.hipo.dades_economiques.interes_fijo,
          plazo_anyos: $scope.hipo.dades_economiques.plazo_anyos,
          producto_segurocasa: $scope.hipo.dades_economiques.producto_segurocasa,
          producto_nomina: $scope.hipo.dades_economiques.producto_nomina,
          producto_segurovida: $scope.hipo.dades_economiques.producto_segurovida
        },
        cuota_mensual: undefined,
        interes_aplicado: undefined,
        total_interesos: undefined
      }
    }else{
      console.log('error');
      console.log(results);
    }
  });

  $scope.calcularHipoteca = function() {
      var interes_aplicado_ = parseFloat($scope.hipoteca.dades_economiques.euribor) + parseFloat($scope.hipoteca.dades_economiques.diferencial);

      if ($scope.hipoteca.dades_economiques.tipo_interes === "fixed") {
        interes_aplicado_ = parseFloat($scope.hipoteca.dades_economiques.interes_fijo);
      }
      if ($scope.hipoteca.dades_economiques.producto_segurocasa) interes_aplicado_ -= 0.05;
      if ($scope.hipoteca.dades_economiques.producto_nomina) interes_aplicado_ -= 0.05;
      if ($scope.hipoteca.dades_economiques.producto_segurovida) interes_aplicado_ -= 0.05;

      $scope.hipoteca.interes_aplicado = interes_aplicado_.toLocaleString() + ' %';

      var quota = (($scope.hipoteca.dades_economiques.capital * interes_aplicado_) / 12) / (100 * (1 - Math.pow(1 + ((interes_aplicado_ / 12) / 100), (-1) * $scope.hipoteca.dades_economiques.plazo_anyos * 12)));
      $scope.hipoteca.cuota_mensual = quota.toLocaleString() + ' €';
      $scope.hipoteca.total_interesos = ((quota * 12 * $scope.hipoteca.dades_economiques.plazo_anyos) - $scope.hipoteca.dades_economiques.capital).toLocaleString() + ' €';
    },
    $scope.resetValues = function() {
      $scope.hipoteca.dades_economiques.interes_fijo = undefined;
      $scope.hipoteca.dades_economiques.euribor = undefined;
      $scope.hipoteca.dades_economiques.diferencial = undefined;
    }

  $scope.canvi = function() {
    $scope.hipoteca.nif = Math.random();
  }

  $scope.json_hipoteca = function() {

    if (!$scope.mortgage_form.$valid) {
      angular.forEach($scope.mortgage_form.$error.required, function(field) {
        field.$setDirty();
      });
      return false;
    } else {
      //$scope.json = angular.toJson($scope.hipoteca);
      apiconnect.put('crud', 'set', JSON.stringify({data: $scope.hipoteca})).then(function(results){
        if(results.success){
          console.log(results);
        }else{
          for(name in $scope.error){
            console.log(name);
            if(results.error[name]){
              console.log(results.error[name]);
              $scope.error[name] = $sce.trustAsHtml(results.error[name]);
            }
          }
          console.log(results);
          console.log('error');
        }
      });

      return true;
    }
  }

  $scope.$watchCollection(
    "hipoteca.dades_economiques",
    function(newValue, oldValue) {
      if ($scope.hipoteca.dades_economiques.capital > 0 && $scope.hipoteca.dades_economiques.plazo_anyos > 0 && (($scope.hipoteca.dades_economiques.euribor > 0 && $scope.hipoteca.dades_economiques.diferencial > 0) || $scope.hipoteca.dades_economiques.interes_fijo > 0)) {
        $scope.calcularHipoteca();
      } else {
        $scope.hipoteca.cuota_mensual = undefined;
        $scope.hipoteca.interes_aplicado = undefined;
        $scope.hipoteca.total_interesos = undefined;
      }

    }
  );

}

exports.HipotecaControler = function($scope, $http, apiconnect,$sce) {
    $scope.hipoteca = {
      nif: "48608794L",
      nombre: "miguel",
      ape1: "gandia",
      ape2: "huerta",
      edad: 20,
      telefono: "680118945",
      email: "miguel@gmail.com",

      dades_economiques: {
        ingresos_mensuales: 1200,
        capital: 1200000,
        tipo_interes: "variable",
        euribor: 0.7,
        diferencial: 2.9,
        interes_fijo: undefined,
        plazo_anyos: 20,
        producto_segurocasa: false,
        producto_nomina: true,
        producto_segurovida: false
      },

      cuota_mensual: undefined,
      interes_aplicado: undefined,
      total_interesos: undefined
    };

    $scope.error = {
      nif: "",
      nombre: "",
      ape1: "",
      ape2: "",
      edad: "",
      telefono: "",
      email: "",
    };

  $scope.calcularHipoteca = function() {
      var interes_aplicado_ = parseFloat($scope.hipoteca.dades_economiques.euribor) + parseFloat($scope.hipoteca.dades_economiques.diferencial);

      if ($scope.hipoteca.dades_economiques.tipo_interes === "fixed") {
        interes_aplicado_ = parseFloat($scope.hipoteca.dades_economiques.interes_fijo);
      }
      if ($scope.hipoteca.dades_economiques.producto_segurocasa) interes_aplicado_ -= 0.05;
      if ($scope.hipoteca.dades_economiques.producto_nomina) interes_aplicado_ -= 0.05;
      if ($scope.hipoteca.dades_economiques.producto_segurovida) interes_aplicado_ -= 0.05;

      $scope.hipoteca.interes_aplicado = interes_aplicado_.toLocaleString() + ' %';

      var quota = (($scope.hipoteca.dades_economiques.capital * interes_aplicado_) / 12) / (100 * (1 - Math.pow(1 + ((interes_aplicado_ / 12) / 100), (-1) * $scope.hipoteca.dades_economiques.plazo_anyos * 12)));
      $scope.hipoteca.cuota_mensual = quota.toLocaleString() + ' €';
      $scope.hipoteca.total_interesos = ((quota * 12 * $scope.hipoteca.dades_economiques.plazo_anyos) - $scope.hipoteca.dades_economiques.capital).toLocaleString() + ' €';
    },
    $scope.resetValues = function() {
      $scope.hipoteca.dades_economiques.interes_fijo = undefined;
      $scope.hipoteca.dades_economiques.euribor = undefined;
      $scope.hipoteca.dades_economiques.diferencial = undefined;
    }

  $scope.canvi = function() {
    $scope.hipoteca.nif = Math.random();
  }

  $scope.json_hipoteca = function() {

    //clean errors scope
    for(name in $scope.error){
       $scope.error[name] = "";
    }

    if (!$scope.mortgage_form.$valid) {
      angular.forEach($scope.mortgage_form.$error.required, function(field) {
        field.$setDirty();
      });
      return false;
    } else {
      apiconnect.post('crud', 'add', JSON.stringify({data: $scope.hipoteca})).then(function(results){
        if(results.success){
          console.log(results);
        }else{
          for(name in $scope.error){
            console.log(name);
            if(results.error[name]){
              console.log(results.error[name]);
              $scope.error[name] = $sce.trustAsHtml(results.error[name]);
            }
          }
          console.log(results);
          console.log('error');
        }
      });

      return true;
    }
  }

  $scope.$watchCollection(
    "hipoteca.dades_economiques",
    function(newValue, oldValue) {
      if ($scope.hipoteca.dades_economiques.capital > 0 && $scope.hipoteca.dades_economiques.plazo_anyos > 0 && (($scope.hipoteca.dades_economiques.euribor > 0 && $scope.hipoteca.dades_economiques.diferencial > 0) || $scope.hipoteca.dades_economiques.interes_fijo > 0)) {
        $scope.calcularHipoteca();
      } else {
        $scope.hipoteca.cuota_mensual = undefined;
        $scope.hipoteca.interes_aplicado = undefined;
        $scope.hipoteca.total_interesos = undefined;
      }

    }
  );

}
