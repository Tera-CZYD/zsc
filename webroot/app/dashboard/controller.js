app.controller('DashboardController', function($scope,Select,StudentApplicationMedicalRequest, Dashboard){

  $scope.base = base;

  Select.get({ code: 'check-user' },function(e){

    $scope.data = e.data;

    if($scope.data.for_medical_interview == 1 && $scope.data.for_schedule == 0){

      $('#medical_interview').validationEngine('attach');

      $("#medicalInterviewModal").modal('show');

    }else if($scope.data.for_schedule == 1){

      $("#notifModal").modal('show');

    }

    if($scope.data.pending_payment_apartelle > 0){

      $("#notifPendingPaymentModal").modal('show');

    }

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Dashboard.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.clearance = e.clearance;

        $scope.student_subjects = e.student_subjects;

        if(e.roleId == 1){

          var chart = anychart.pie3d([

            {x : 'Pending', value : $scope.datas.counseling_apppointment_pending_count},

            {x : 'Approved', value : $scope.datas.counseling_apppointment_approved_count},

            {x : 'Disapproved', value : $scope.datas.counseling_apppointment_disapproved_count},

            {x : 'Cancelled', value : $scope.datas.counseling_apppointment_cancelled_count},

            {x : 'Confirmed', value : $scope.datas.counseling_apppointment_confirmed_count},

          ]);

          chart.title('Counseling Appointment');

          chart.radius('50%');

          chart.sort('desc');

          chart.container('chartdiv');

          chart.draw();

        }

      }

    });

  }

  $scope.load();

  $scope.showImageModal = function(imageSrc){

    $scope.imageSrc = imageSrc;

    $('#view-image-modal').modal('show');

  }
  
  $scope.requestMedicalInterview = function(data){  

    valid = $("#medical_interview").validationEngine('validate');

    if(valid){

      bootbox.confirm('Are you sure you want to submit request?', function(b){

        if(b) {

          StudentApplicationMedicalRequest.save(data, function(e){

            if(e.ok){

              $.gritter.add({

                title: 'Successful!',

                text: e.msg

              });

              $("#medicalInterviewModal").modal('hide');

              $("#notifModal").modal('show');

            }

          });

        }

      });

    }

  }

});