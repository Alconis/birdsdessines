'use strict';

angular.module('huntApp')
	.filter('mailSafe', function() {

		return function(input) {
			var atIdx = input.indexOf('@');
			if(-1 == atIdx) return input;
			return input.substring(0,atIdx);
		};

	});