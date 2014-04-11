'use strict'

angular.module('huntApp')
	.factory('Hunt', function($http, $q) {
		var HuntService = function () {
			this.baseURL = '/hunt/server/';

			this.getEggs = function() {
				var deferred = $q.defer();

				this.eggs = $http({
						method: 'get',
						url: this.baseURL + 'egg.php'
					})
					.success(function(data, status, headers, config) {
						deferred.resolve(data);
					}).
					error(function(data, status, headers, config) {
						deferred.reject(data);
					});

				return deferred.promise;
			};

			this.login = function(login, password) {
				var deferred = $q.defer();

				var shaPass = new jsSHA(password, 'TEXT');
				var hashedPass = shaPass.getHash('SHA-1', 'B64');

				$http({
						method: 'get',
						url: this.baseURL + 'user.php' + '?do=login',
						params : {
							user: login,
							pass: hashedPass
						}
					})
					.success(function(data, status, headers, config) {
						deferred.resolve(data);
					}).
					error(function(data, status, headers, config) {
						if(status == 401 || status == 404) {
							deferred.reject('Identifiant ou mot de passe invalide.');
						}
						deferred.reject(data);
					});

				return deferred.promise;
			};

			this.logout = function() {
				return $http({
						method: 'get',
						url: this.baseURL + 'user.php' + '?do=logout'
					});
			};

			this.subscribe = function(login, password) {
				var deferred = $q.defer();

				var shaPass = new jsSHA(password, 'TEXT');
				var hashedPass = shaPass.getHash('SHA-1', 'B64');
				
				$http({
						method: 'get',
						url: this.baseURL + 'user.php' + '?do=add',
						params : {
							user: login,
							pass: hashedPass
						}
					})
					.success(function(data, status, headers, config) {
						deferred.resolve(data);
					}).
					error(function(data, status, headers, config) {
						deferred.reject(data);
					});

				return deferred.promise;
			};

			this.getCurrentUser = function() {
				var deferred = $q.defer();

				$http({
						method: 'get',
						url: this.baseURL + 'user.php' + '?do=card'
					})
					.success(function(data, status, headers, config) {
						deferred.resolve(data);
					}).
					error(function(data, status, headers, config) {
						deferred.reject(null);
					});

				return deferred.promise;
			};

			this.collect = function(eggId, eggCode) {
				var deferred = $q.defer();

				$http({
						method: 'get',
						url: this.baseURL + 'user.php' + '?do=collect',
						params : {
							egg: eggId,
							code: eggCode
						}
					})
					.success(function(data, status, headers, config) {
						deferred.resolve(data);
					}).
					error(function(data, status, headers, config) {
						if(status == 409) {
							deferred.reject('alreadyCollected');
						}
						deferred.reject(data);
					});

				return deferred.promise;
			};

			this.getPlayers = function() {
				var deferred = $q.defer();

				$http({
						method: 'get',
						url: this.baseURL + 'user.php' + '?do=list'
					})
					.success(function(data, status, headers, config) {
						// process into players = [ player = {id,name,score,eggs=[id,time]}]

						var players = {};
						var player;
						angular.forEach(data, function(value, index) {
							player = players[value.id];
							if(!player) {
								player = {
									id : value.id,
									name : value.user,
									eggs : []
								};
								players[value.id] = player;
							}
							if(null != value.egg) {
								player.eggs.push({
									id: value.egg,
									time: value.time
								});
							}
						});

						var finalPlayers = [];
						angular.forEach(players, function(value, key) {
							value.score = value.eggs.length;
							finalPlayers.push(value);
						});

						deferred.resolve(finalPlayers);
					}).
					error(function(data, status, headers, config) {
						deferred.reject(data);
					});

				return deferred.promise;
			};
		};

		return new HuntService();
	});