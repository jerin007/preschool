var app = angular.module("mainApp", []);
app.controller("mainCtrl", function ($scope, $http) {
	$scope.test = "Preschool";
	$scope.lang_code = "en";
	$scope.parent_tree = 2;
    $scope.child = 1;
	$scope.multi_lang = {};
    $scope.getLangJSON = function (lang) {
        $http.get('./assets/localization/' + lang + '.json').then(function (response) {
            $scope.multi_lang = response.data;
			$scope.sidebar = $scope.multi_lang.sidebar;
			$scope.gotolink($scope.sidebar[1].href, 1, 1, 0);
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
