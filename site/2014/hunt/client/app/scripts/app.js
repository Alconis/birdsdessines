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
      .when('/info', {
        templateUrl: 'views/info.html'
      })
      .when('/beta', {
        templateUrl: 'views/beta.html'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
