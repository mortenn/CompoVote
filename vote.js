angular.module('poll',[])
	.controller('vote-controller', [
		'$scope',
		function($scope)
		{
			$scope.contests = [];
			$scope.entry = null;
			$scope.entries = [];
			$scope.vote = function(compo,entry)
			{
				$.post('/vote.php/vote', {contest:compo,entry:entry},
					function(r)
					{
						$scope.$apply(function(){
							if(r == entry)
							{
								$scope.contest = null;
								$scope.entries = [];
								$scope.entry = null;
								$scope.msg = 'Takk for at du stemte på "'+entry+'" i '+compo;
							}
							else
								console.log(r+' <> '+entry);
						});
					}
				);
			};
			$scope.setCompo = function(compo)
			{
				$scope.msg = '';
				$.getJSON('/vote.php/entries?contest='+compo,
					function(r) { $scope.$apply(function(){ $scope.entries = r; }); }
				);
				$.get('/vote.php/vote?contest='+compo,
					function(r)
					{
						console.log(r);
						$scope.$apply(function(){
							if(r)
								$scope.msg = 'Du har allerede stemt på "'+r+'"';
							$scope.entry = r;
						});
					}
				);
			};
			$.getJSON('/vote.php/contests',
				function(r) { $scope.$apply(function(){ $scope.contests = r; }); }
			);
		}
	]);
