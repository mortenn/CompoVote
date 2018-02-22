angular.module('vote', ['ui.router','ngResource'])
	.run([
		'$rootScope', '$stateParams', '$state',
		function($rootScope, $stateParams, $state)
		{
			$rootScope.$state = $state;
			$rootScope.$stateParams = $stateParams;
		}
	])
	.config([
		'$compileProvider', '$stateProvider', '$urlServiceProvider',
		function($compile, $state, $urlService, localStorageService)
		{
			$compile.debugInfoEnabled(false);
			$state.state('vote', {url:'/', component:'vote'});
			$urlService.rules.otherwise('/');
		}
	])
;