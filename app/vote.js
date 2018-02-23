angular.module('vote').component(
	'vote',
	{
		controller: ['$stateParams','API',Vote],
		templateUrl: 'view/votes.html'
	}
);

function Vote($stateParams, API)
{
	console.log($stateParams.key);
	this.contests = API.GetContests();
	this.entries = {};
	this.votes = {};
	this.ExpandContest = function(contest)
	{
		this.entries[contest.name] = API.GetEntries({contest:contest.name});
		this.votes[contest.name] = API.GetVote({contest:contest.name});
	};
	this.Vote = function(contest, entry)
	{
		this.votes[contest.name] = API.SetVote({contest:contest.name,entry:entry.name});
	};
}