
var app = angular.module("mainApp", ['ngRoute','datatables']);
app.config(function($routeProvider) {
	$routeProvider
		.when('/', {
			templateUrl : 'pages/dashboard.html',
			controller  : 'mainCtrl'
		})
		.when('/teacher', {
			templateUrl : 'pages/teachers-list.html',
			controller  : 'teachListCtrl'
		})
		.when('/student', {
			templateUrl : 'pages/add-student.html',
			controller  : 'studentController'
		});
});
app.controller("mainCtrl", function ($scope, $http) {
	$scope.test = "Preschool";
	$scope.lang_code = "en";
	$scope.parent_tree = 1;
    $scope.child = 0;
	$scope.multi_lang = {};
    $scope.getLangJSON = function (lang) {
        $http.get('./assets/localization/' + lang + '.json').then(function (response) {
            $scope.multi_lang = response.data;
			$scope.sidebar = $scope.multi_lang.sidebar;
			// $scope.gotolink($scope.sidebar[1].href, 1, 1, 0);
        });
	}
	$scope.getLangJSON($scope.lang_code);
	$scope.showchild = function(isshow,index){
		$scope.sidebar[index].isshow = !isshow;
		if($scope.sidebar[index].isshow){
			for(let i=0;i< $scope.sidebar.length; i++){
				if(i !== index){
					$scope.sidebar[i].isshow = false;
				}
			}
		}
	}
	$scope.gotolink = function (href, type, id, parent_id) {
        if (type == 1) {
            $scope.parent_tree = id;
            $scope.child = 0;
        } else {
            $scope.parent_tree = parent_id;
            $scope.child = id;
        }
        href = href + "?lang=" + $scope.lang_code;
        document.getElementById("div_main").innerHTML = "<object type=\"text/html\" data=\"" + href + "\" style=\"width:100%;height: calc(100vh - 67px);\"></object>";
    }
})
app.controller('teachListCtrl', function($scope, $http) {
	$scope.teachers = [];
    $scope.deleted_teacher_info = {};
    $scope.id = 0;
    var url = "php/teacher_data_service.php?service=";
    $scope.teach_data = {
        id:0,
        firstname: 'firstname',
        lastname: 'lastname',
        email: 'email',
        password: 'password',
        subject: 'subject',
        mobile: '1234',
        gender: 1,
        subject_id: '1',
        class: '1',
        section: '1',
        parmanent_address: 'ssfb',
        dateofbirth: '01/01/2020',
        joining_date: '01/01/2020',
        teacher_id: '',
    };
    $scope.read_teacher_data = function(){
        $http.get(url+"get_teacher_data&take=all&skip=0&col_name=all").success(function(data, status, headers, config){
            $scope.teachers = data.records;
        });
    }
    $scope.read_teacher_data();
    $scope.add_teacher = function(){
    	$scope.teach_data = {
	        id:0,
	        firstname: 'firstname',
	        lastname: 'lastname',
	        email: 'email',
	        password: 'password',
	        subject: 'subject',
	        mobile: '1234',
	        gender: 1,
	        subject_id: '1',
	        class: '1',
	        section: '1',
	        parmanent_address: 'ssfb',
	        dateofbirth: '01/01/2020',
	        joining_date: '01/01/2020',
	        teacher_id: '',
	    };
        $('#modal-fullscreen').modal('show');
    }
    $scope.edit_teacher = function(t){
    	$scope.teach_data = t;
        $('#modal-fullscreen').modal('show');
    }
    $scope.delete_teacher = function(t){
        $scope.deleted_teacher_info = t;
        $('#delete_employee').modal('show');
    }
    $scope.confirm_delete = function(){
        $.ajax({
            url: url + "delete_teacher_data",
            type: "GET",
            dataType: "json",
            data: "id=" + JSON.stringify($scope.deleted_teacher_info.id) + "",
            success: function(response) {
                $scope.deleted_id = 0;
                if (response == 'success') {
                    show_success_msg("Teacher data has been deleted successfully.");
                } else {
                    show_err_msg("Teacher data deletion was unsuccessful.");
                }
                $scope.close_delete_modal();
                $scope.read_teacher_data();
            }
        });
    }
    $scope.close_delete_modal = function(){
        $scope.deleted_teacher_info = {};
        $('#delete_employee').modal('hide');
    }

    /** Add & Edit Functionality**/
    $scope.gender = [ 
        { name: 'Male', id: 1 },  
        { name: 'Female', id: 2 },  
        { name: 'Others', id: 3 } 
    ]; 
    $scope.class = [ 
        { name: 'Play', id: 1 },  
        { name: 'KG-ONE', id: 2 },  
        { name: 'KG-TWO', id: 3 } 
    ];
    $scope.subject = [ 
        { name: 'Bangla', id: 1 },  
        { name: 'English', id: 2 },  
        { name: 'Math', id: 3 } 
    ];
    $scope.section = [ 
        { name: 'A', id: 1 },  
        { name: 'B', id: 2 },  
        { name: 'C', id: 3 } 
    ];
    // if($scope.id > 0){
    //     $http.get(url+"get_teacher_details&id="+$scope.id).success(function(data){
    //         $scope.teach_data = data;
    //     });
    // }
    $scope.save_data = function () {
        $.ajax({
            url: url + "save_teacher_data",
            type: "POST",
            dataType: "json",
            data: "data=[" + JSON.stringify($scope.teach_data) + "]",
            success: function (response) {
                if (response == null) {
                    if($scope.teach_data.id == 0){
                        show_err_msg("Teacher information save was unsuccessful.");
                    }else{
                        show_err_msg("Teacher information update was unsuccessful.");
                    }
                } else {
                    if($scope.teach_data.id == 0){
                        show_success_msg("Teacher information has been succefully saved.");
                    }else{
                        show_success_msg("Teacher information has been succefully updated.");
                    }
                }
            }
        });
    }
});
app.controller('studentController', function($scope) {
	$scope.message = 'Contact us! JK. This is just a demo.';
});
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "preventDuplicates": false,
    "positionClass": "toast-bottom-right",
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": 5000,
    "extendedTimeOut": 0,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut",
    "tapToDismiss": false
};
function show_success_msg(msg) {
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.progressBar = true;
    toastr.options.timeOut = 3000;
    toastr.success(msg);
}
function show_err_msg(msg) {
    toastr.options.positionClass = "toast-bottom-right";
    toastr.options.timeOut = 3000;
    toastr.error(msg);
}
function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [, ""])[1].replace(/\+/g, '%20')) || null
}