var controllers = require('./controllers');
var directives = require('./directives')
var _ = require('underscore');

var components = angular.module("app.components", ['ng']);

_.each(controllers, function(controller, name){
  components.controller(name, controller);
});

_.each(directives, function(directive, name){
  components.directive(name, directive);
})


var app_ = angular.module("app", ['app.components','ngRoute']);

app_.config(function($routeProvider) {
  $routeProvider.when('/',{
    templateUrl:"views/main.html"
  });

  $routeProvider.when('/hipoteca/llistat', {
    template:"<hipoteca-list></hipoteca-list>",
  });

  $routeProvider.when('/hipoteca/nova',{
    template:"<hipoteca></hipoteca>",
  });

  $routeProvider.when('/hipoteca/mostrar/:idPersona',{
    template:"<mostrar-hip></mostrar-hip>",
  });

  $routeProvider.otherwise({
    redirectTo: '/'
  });

})
