'use strict';

angular.module('huntApp')
	.controller('MainCtrl', function ($scope, Hunt) {
	
		$scope.doLogin = function(login, password) {
			Hunt.login(login, password)
				.then(function(data) {
					$scope.currentUser = data;
				}, function(reason) {
					$scope.loginError = reason;
				});
		};

		$scope.doLogout = function() {
			Hunt.logout().then(function() {
				$scope.currentUser = null;
			});
		};

		$scope.setHighlightedUser = function(user) {
			if(null == user) {
				$scope.highlightedUser = (null == $scope.currentUser ? null : $scope.currentUser.login);
				$scope.highlightedEggs = (null == $scope.currentUser ? null : $scope.currentUser.eggs);
			}else{
				$scope.highlightedUser = user.name;
				$scope.highlightedEggs = user.eggs;
			}
		}

		$scope.eggHighlighted = function(eggId) {
			if(!$scope.highlightedEggs || $scope.highlightedEggs.length == 0) return false;

			angular.forEach($scope.highlightedEggs, function(egg) {
				if(egg.id == eggId) {
					return true;
				}
			});

			return false;
		}

		$scope.filterEgg = function(item) {
			return $scope.eggHighlighted(item);
		}

		Hunt.getEggs()
			.then(function(data) {
				$scope.eggs = data;
			});

		Hunt.getPlayers()
			.then(function(data) {
				var nbPlayers = 0;
				angular.forEach(data, function(value, key) {
					nbPlayers++;
				});
				$scope.nbPlayers = nbPlayers;
				$scope.players = data;
			});

		Hunt.getCurrentUser()
			.then(function(data) {
				$scope.currentUser = data;
				$scope.highlightedUser = data.login;
				$scope.highlightedEggs = data.eggs;
			});

	});
