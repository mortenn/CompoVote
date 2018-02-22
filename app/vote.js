angular.module('vote').component(
	'vote',
	{
		controller: ['$scope',Vote],
		templateUrl: 'view/vote.html'
	}
);

function Vote($scope)
{
}