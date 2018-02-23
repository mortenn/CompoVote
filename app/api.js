angular.module('vote')
	.factory('API',[
		'$resource',
		function($resource)
		{
			return $resource(
				'api.php/:action',
				{},
				{
					'GetContests': { method: 'GET', params: { action: 'contests' }, isArray: true },
					'GetEntries': { method: 'GET', url: 'api.php/entries/:contest', isArray: true },
					'GetVote': { method: 'GET', url: 'api.php/vote/:contest' },
					'SetVote': { method: 'PUT', url: 'api.php/vote/:contest/:entry', params: {'contest':null, entry:null} }
				}
			);
		}
	]);