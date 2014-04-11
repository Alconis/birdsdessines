'use strict';

angular.module('huntApp')
	.controller('CollectCtrl', function($scope, $routeParams, Hunt) {
		$scope.theForm = null;
		$scope.theEgg = null;
		$scope.eggId = $routeParams['eggId'];
		$scope.eggCode = $routeParams['eggCode'];
		$scope.collected = false;
		$scope.alreadyCollected = false;

		$scope.setForm = function(f) {
			$scope.formError = null;
			$scope.theForm = f;
		};

		$scope.doSubscribe = function(login, password, password2) {
			$scope.formError = null;

			if(!login || login.length < 4) {
				$scope.formError = "Identifiant invalide. (4 caractères minimum)"
				return;
			}

			if(!password || password.length < 4) {
				$scope.formError = "Mot de passe invalide. (4 caractères minimum)"
				return;
			}

			if(password != password2) {
				$scope.formError = "Les deux mots de passe doivent être identiques."
				return;
			}

			Hunt.subscribe(login, password)
				.then(function(data) {
					$scope.currentUser = data;
					$scope.collect();
				}, function(reason) {
					$scope.formError = reason;
				});
		};

		$scope.doLogin = function(login, password) {
			$scope.formError = null;

			Hunt.login(login, password)
				.then(function(data) {
					$scope.currentUser = data;
					$scope.collect();
				}, function(reason) {
					$scope.formError = reason;
				});
		};

		$scope.collect = function() {
			Hunt.collect($scope.eggId, $scope.eggCode)
				.then(function(data) {
					$scope.collected = true;
				}, function(reason) {
					if(reason == 'alreadyCollected') {
						$scope.alreadyCollected = true;
					}
				});
		}

		Hunt.getEggs()
			.then(function(data) {
				angular.forEach(data, function(value) {
					if(value.id == $scope.eggId){
						$scope.theEgg = value;
						return;
					}
				});
			});

		Hunt.getCurrentUser()
			.then(function(data) {
				$scope.currentUser = data;

				if($scope.eggId && $scope.eggCode) {
					$scope.collect();
				}
			});
	});