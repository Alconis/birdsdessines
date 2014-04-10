'use strict';

angular.module('huntApp', [
  'ngRoute',
  'ngCookies',
  'ngResource',
  'ngSanitize'
])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/collect/:eggId/:eggCode', {
        templateUrl: 'views/collect.html',
        controller: 'CollectCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
