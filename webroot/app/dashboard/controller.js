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
 console.log(e.roleId);

      if (e.ok) {

        $scope.datas = e.data;

        $scope.clearance = e.clearance;

        $scope.student_subjects = e.student_subjects;

        $scope.total_sub = e.total_sub;

        $scope.passed = e.passed;

        $scope.failed = e.failed;

        $scope.credited = e.credited;

        $scope.incomplete = e.incomplete;

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



          // Themes begin
          am4core.useTheme(am4themes_animated);
          // Themes end

          // Create chart instance
          var tmp = [];

          var chart2 = am4core.create("chartdiv2", am4charts.XYChart3D);

          Select.get({ code: 'students-per-campus' },function(e){

            if(e.data.length > 0){

              $.each(e.data, function(i,val){

                // Add data
                tmp.push({

                  "college": val.college,

                  "students": val.student_count

                });

              });

              chart2.data = tmp;


              // Create axes

              let categoryAxis = chart2.xAxes.push(new am4charts.CategoryAxis());
              
              categoryAxis.dataFields.category = "college";
              
              categoryAxis.renderer.labels.template.rotation = 270;
              
              categoryAxis.renderer.labels.template.hideOversized = false;
              
              categoryAxis.renderer.minGridDistance = 20;
              
              categoryAxis.renderer.labels.template.horizontalCenter = "right";
              
              categoryAxis.renderer.labels.template.verticalCenter = "middle";
              
              categoryAxis.tooltip.label.rotation = 270;
              
              categoryAxis.tooltip.label.horizontalCenter = "right";
              
              categoryAxis.tooltip.label.verticalCenter = "middle";

              let valueAxis = chart2.yAxes.push(new am4charts.ValueAxis());
             
              valueAxis.title.text = "Students per college";
              
              valueAxis.title.fontWeight = "bold";

              // Create series
              var series = chart2.series.push(new am4charts.ColumnSeries3D());
             
              series.dataFields.valueY = "students";
             
              series.dataFields.categoryX = "college";
             
              series.name = "Visits";
             
              series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
             
              series.columns.template.fillOpacity = .8;

              var columnTemplate = series.columns.template;
             
              columnTemplate.strokeWidth = 2;
             
              columnTemplate.strokeOpacity = 1;
             
              columnTemplate.stroke = am4core.color("#FFFFFF");

              columnTemplate.adapter.add("fill", function(fill, target) {
             
                return chart2.colors.getIndex(target.dataItem.index);
             
              })

              columnTemplate.adapter.add("stroke", function(stroke, target) {
              
                return chart2.colors.getIndex(target.dataItem.index);
              
              })

              chart2.cursor = new am4charts.XYCursor();
             
              chart2.cursor.lineX.strokeOpacity = 0;
             
              chart2.cursor.lineY.strokeOpacity = 0;

            }

          });

        }else if(e.roleId == 13){

          $scope.scheds = e.scheds;

          anychart.onDocumentReady(function () {
            
            // create pie chart with passed data
            
            var chart = anychart.pie([
              
              ['Passed', $scope.passed],
              
              ['Failed', $scope.failed],
              
              ['Credited', $scope.credited],
              
              ['Incomplete', $scope.incomplete]
              
            ]);

            // create range color palette with color ranged between light blue and dark blue
            
            var palette = anychart.palettes.rangeColors();
            
            palette.items([{ color: '#64b5f6' }, { color: '#455a64' }]);
            

            // set chart title text settings
            chart
            
              // set chart radius
              .innerRadius('40%')
              
              // set palette to the chart
              .palette(palette);

            // set container id for the chart
            chart.container('container');
            
            // initiate chart drawing
            chart.draw();
          });
        }else if(e.roleId == 12){

          $scope.scheds = e.scheds;
          console.log(e.scheds);

          anychart.onDocumentReady(function () {
            
            // create pie chart with passed data
            
            var chart = anychart.pie([
              
              ['Passed', $scope.passed],
              
              ['Failed', $scope.failed],
              
              ['Credited', $scope.credited],
              
              ['Incomplete', $scope.incomplete]
              
            ]);

            // create range color palette with color ranged between light blue and dark blue
            
            var palette = anychart.palettes.rangeColors();
            
            palette.items([{ color: '#64b5f6' }, { color: '#455a64' }]);
            

            // set chart title text settings
            chart
            
              // set chart radius
              .innerRadius('40%')
              
              // set palette to the chart
              .palette(palette);

            // set container id for the chart
            chart.container('container');
            
            // initiate chart drawing
            chart.draw();
          });
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