exports.main = function() {
  return {
    controller: 'MainController',
    templateUrl: './views/main.html'
  }
}

exports.hipotecaList = function() {
  return {
    controller: 'HipotecaListController',
    templateUrl: './views/llistat_hipoteques.html',
  }
}

exports.mostrarHip = function() {
  return {
    controller: 'MostrarHip_controller',
    templateUrl: './views/mortgage_form.html'
  }
}

exports.hipoteca = function() {
  return {
    controller: 'HipotecaControler',
    templateUrl: './views/mortgage_form.html'
  }
}
