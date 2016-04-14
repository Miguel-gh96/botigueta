app.controller("HipotecaControler", ['$scope', 'service', 'hipotecaResource', '$routeParams',
  function($scope, service, hipotecaResource, $routeParams) {
    
    if (!service) {
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
    } else {
      $scope.hipo = service;
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
    }


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
        $scope.json = angular.toJson($scope.hipoteca);
        alert($scope.json);
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
]);
