angular.module('vote').component(
	'vote',
	{
		controller: ['$scope',Vote],
		templateUrl: 'view/votes.html'
	}
);

function Vote($scope)
{
	this.compos = [];
}