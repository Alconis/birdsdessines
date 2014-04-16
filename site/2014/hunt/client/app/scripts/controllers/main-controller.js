'use strict';

angular.module('huntApp')
	.controller('MainCtrl', function ($scope, Hunt) {
		$scope.initialized = false;

		$scope.setFilterScore = function(f) {
			$scope.filterScore = f;
		};

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
				var scoreFilters = {};
				var scoreFiltersKeys = [];
				var maxScore = 0;
				var nbPlayers = 0;
				angular.forEach(data, function(value, key) {
					if(undefined == scoreFilters[value.score]) {
						scoreFilters[value.score] = {
							count : 0
						};
						scoreFiltersKeys.push(value.score);
						maxScore = Math.max(maxScore, value.score);
					}
					scoreFilters[value.score].count = scoreFilters[value.score].count + 1;
					nbPlayers++;
				});
				scoreFiltersKeys.sort(function(a,b){return a-b});
				scoreFiltersKeys.reverse();

				var i;
				var sum = 0;
				for(i = 0; i < scoreFiltersKeys.length; i++) {
					var score = scoreFiltersKeys[i];
					scoreFilters[score].startRank = sum;
					sum += scoreFilters[score].count;
				}

				$scope.scoreFiltersKeys = scoreFiltersKeys;
				$scope.scoreFilters = scoreFilters;
				$scope.filterScore = maxScore;
				$scope.nbPlayers = nbPlayers;
				$scope.players = data;
				$scope.initialized = true;
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
