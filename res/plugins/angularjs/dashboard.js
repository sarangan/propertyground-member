var app = angular.module('dashboard', []);

app.controller('newJobCtrl', ['$scope' , '$http', function($scope, $http){

		this.job = {};
		var self = this;

		this.save = function(tempJob){

			//console.log(tempJob.address);

			// Simple POST request example (passing data) : 
			// $http.post('index.php/jobs/newJobSimple', {address: tempJob.address}).

			//http://localhost/propertyground/index.php/jobs/index

			$http({
					    method: 'POST',
					    url: 'index.php/jobs/newJobSimple',
					    data: $.param({address: tempJob.address , description: tempJob.description}),
					    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					}).
			  success(function(data) {
			  	if(data.status == 3){
			    	self.job.statustxt =  'Saved sucessfully...';
			    	self.job.address = '';
			    	self.job.description = '';

			  	}
			  	else{
			  		 self.job.statustxt =  'Something went wrong...';
			  	}
			  }).
			  error(function(data) {
			    self.job.statustxt =  'Something went wrong...';
			  });

		}

	}

]);

app.controller('listPackageCtrl', ['$scope', '$http', function($scope, $http){

	this.packeages = [];
	var self = this;

	$http.get('index.php/welcome/getPackages')
    .success(function (response) {
    	self.packeages = response.records;

    }
    );

}
]);

app.controller('projectSummaryCtrl',  ['$scope', '$http', function($scope, $http){

	this.projectsummary = {total : 0, processing: 0, carriedout: 0};
	var self = this;

	$http.get('index.php/welcome/getProjectsSummary')
    .success(function (response) {
    	self.projectsummary.total = response.summary.total;
    	self.projectsummary.processing = response.summary.processing;
    	self.projectsummary.carriedout = response.summary.carriedout;
    }
    );

}
]);
