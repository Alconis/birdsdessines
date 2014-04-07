'use strict';

angular.module('huntApp')
	.controller('MainCtrl', function ($scope, Hunt) {
	
		$scope.doLogin = function(login, password) {
			Hunt.login(login, password)
				.then(function(data) {
					$scope.currentUser = data;
				}, function(reason) {
					$scope.loginError = reason;
				})
		};

		$scope.doLogout = function() {
			Hunt.logout().then(function() {
				$scope.currentUser = null;
			});
		};

		Hunt.getEggs()
			.then(function(data) {
				$scope.eggs = data;
			});

		Hunt.getPlayers()
			.then(function(data) {
				$scope.players = data;
			});

		Hunt.getCurrentUser()
			.then(function(data) {
				$scope.currentUser = data;
			});

	});
