app.controller('FacultyLoadAccountController', function($scope,Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $scope.search = {}

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  Select.get({ code: 'academic-term-list' },function(e){

    $scope.academic_terms = e.data;

  });

  Select.get({ code: 'college-list' },function(e){

    $scope.colleges = e.data;

  });

  Select.get({ code: 'employee-designation-category-list' },function(e){

    $scope.designations = e.data;

  });

  $scope.print_faculty_accounts = function(){

    condition = "";
    
    if ($scope.search.term_id !== '' && $scope.search.term_id !== null && $scope.search.term_id !== undefined) {
    
      condition += '&term_id=' + $scope.search.term_id;

    }
    
    if ($scope.search.college_id !== '' && $scope.search.college_id !== null && $scope.search.college_id !== undefined) {
    
      condition += '&college_id=' + $scope.search.college_id;

    }
    
    if ($scope.search.designation_id !== '' && $scope.search.designation_id !== null && $scope.search.designation_id !== undefined) {
    
      condition += '&designation_id=' + $scope.search.designation_id;

    }

    printTable(base + 'print/print_faculty_accounts?print=1' + condition);

  }

});