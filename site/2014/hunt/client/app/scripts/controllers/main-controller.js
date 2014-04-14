'use strict';

angular.module('huntApp')
	.controller('MainCtrl', function ($scope, Hunt) {

		$scope.theForm = null;
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
					$scope.getPlayers();
				}, function(reason) {
					$scope.formError = reason;
				});
		};

		$scope.doLogin = function(login, password) {
			Hunt.login(login, password)
				.then(function(data) {
					$scope.currentUser = data;
				}, function(reason) {
					$scope.formError = reason;
				});
		};

		$scope.doLogout = function() {
			Hunt.logout()
				.then(function() {
					$scope.currentUser = null;
					$scope.setForm(null);
				});
		};

		$scope.doRename = function(newName) {
			Hunt.rename(newName)
				.then(function(data) {
					Hunt.getCurrentUser()
						.then(function(data) {
							$scope.currentUser = data;
							$scope.setForm(null);
						});
				}, function(reason) {
					$scope.formError = reason;
				});
		};

		$scope.getPlayers = function() {
			Hunt.getPlayers()
			.then(function(data) {
				var nbPlayers = 0;
				angular.forEach(data, function(value, key) {
					nbPlayers++;
				});
				$scope.nbPlayers = nbPlayers;
				$scope.players = data;
			});
		};

		Hunt.getEggs()
			.then(function(data) {
				var nbAvailableEggs = 0;
				angular.forEach(data, function(value) {
					if(value.status != 'off') {
						nbAvailableEggs++;
					}
				});

				$scope.nbAvailableEggs = nbAvailableEggs;
				$scope.eggs = data;
			});

		$scope.getPlayers();

		Hunt.getCurrentUser()
			.then(function(data) {
				$scope.currentUser = data;
			});

	});
