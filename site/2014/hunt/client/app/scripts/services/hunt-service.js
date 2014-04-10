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

				$http({
						method: 'get',
						url: this.baseURL + 'user.php' + '?do=login',
						params : {
							user: login,
							pass: password
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

			this.logout = function() {
				return $http({
						method: 'get',
						url: this.baseURL + 'user.php' + '?do=logout'
					});
			};

			this.subscribe = function(login, password) {
				var deferred = $q.defer();

				$http({
						method: 'get',
						url: this.baseURL + 'user.php' + '?do=add',
						params : {
							user: login,
							pass: password
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

						angular.forEach(players, function(value, key) {
							value.score = value.eggs.length;
						});

						deferred.resolve(players);
					}).
					error(function(data, status, headers, config) {
						deferred.reject(data);
					});

				return deferred.promise;
			};
		};

		return new HuntService();
	});