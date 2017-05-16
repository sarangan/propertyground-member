(function(){

var app = angular.module('admindashboard', ['chart.js']);

app.controller('sendRem', ['$scope' , '$http', function($scope, $http){

		this.statustxt = '';
		var self = this;


		this.send = function(project_id){

			// Simple POST request example (passing data) : 
			// $http.post('index.php/jobs/newJobSimple', {address: tempJob.address}).

			//http://localhost/propertyground/index.php/jobs/index

			$http({
					    method: 'POST',
					    url: 'index.php/admin/invoice/sendRemMail',
					    data: $.param({project_id: project_id }),
					    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					}).
			  success(function(data) {
			  	if(data.status == 3){
			    	self.statustxt =  'Sent sucessfully...';			    	
			  	}
			  	else{
			  		self.statustxt =  'Something went wrong...';
			  	}
			  }).
			  error(function(data) {
			    	self.statustxt =  'Something went wrong...';
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


app.controller('LineChartCtrl', ['$scope', '$http', function($scope, $http){


 		
	 // $scope.projectsummary.push({y: '2011 Q1', item1: 2666});
  //      $scope.projectsummary.push({y: '2011 Q2', item1: 23424});
  //      $scope.projectsummary.push({y: '2011 Q3', item1: 2233});


	// $scope.chart_options = {
	// 	    data: $scope.projectsummary,
	// 	    xkey: 'y',
	// 	    ykeys: ['item1'],
	// 	    labels: ['Jobs']  
	// };





    //   $scope.$watch('projectsummary', function() {
    //    console.log('hey, myVar has changed!');

    //    console.log(  $scope.projectsummary );

     

   	// });





}]);


  app.controller('LineCtrl', ['$scope', '$timeout', '$http', function ($scope, $timeout, $http) {


	 $scope.lbls = [];
	 $scope.mydata = [];

	 var self = this;


  		$http.get('index.php/admin/dashboard/summaryProjects')
	    .success(function (response) {
	    	self.projectsummary = response.result;

	    	console.log(self.projectsummary);

	    	$.each(self.projectsummary, function(k, v) {
	    		
	    		$scope.lbls.push(v['y']);
	    		$scope.mydata.push(v['item1']);
	    	});
	    	
		 }
	 );


    $scope.labels =  [];
    $scope.series = ['Jobs'];
    $scope.data = [];
    $scope.onClick = function (points, evt) {
      console.log(points, evt);
    };
    $scope.onHover = function (points) {
      if (points.length > 0) {
        console.log('Point', points[0].value);
      } else {
        console.log('No point');
      }
    };

    $timeout(function () {
       $scope.labels =  $scope.lbls;
       $scope.data.push($scope.mydata);
      $scope.series = ['Jobs'];
    }, 3000);
  }]);


})();