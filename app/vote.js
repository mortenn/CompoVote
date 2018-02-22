angular.module('vote').component(
	'vote',
	{
		controller: ['$stateParams',Vote],
		templateUrl: 'view/votes.html'
	}
);

function Vote($stateParams)
{
	console.log($stateParams.key);
	this.compos = [];
}