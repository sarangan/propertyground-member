var app = angular.module('user', []);

app.controller('usersCtrl',  ['$scope', '$http', function($scope, $http){

	this.users = [];
	this.client_id = 0;
	var self = this;

	this.getUsers = function(client_id){

		$http({
					    method: 'GET',
					    url: 'index.php/admin/users/getUsersByClient?client_id=' + client_id,
					})
    .success(function (response) {
    	
    	self.users = response.users;

    	//console.log(self.users);
    	jQuery('#link_user_id').find('option').remove();

    	


    }
    );

	}

	

}
]);