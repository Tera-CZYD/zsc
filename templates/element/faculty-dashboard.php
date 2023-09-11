<meta charset='utf-8' />

<link href='<?php echo $base ?>/assets/plugins/fullcalendar-2.6.0/fullcalendar.css' rel='stylesheet' />

<link href='<?php echo $base ?>/assets/plugins/fullcalendar-2.6.0/fullcalendar.print.css' rel='stylesheet' media='print' />

<script src='<?php echo $base ?>/assets/plugins/fullcalendar-2.6.0/lib/moment.min.js'></script>

<script src='<?php echo $base ?>/assets/plugins/fullcalendar-2.6.0/fullcalendar.min.js'></script>

<script>

var today = new Date();

var dd = today.getDate();

var mm = today.getMonth() + 1; //January is 0!

var yyyy = today.getFullYear();

if(dd<10) {

  dd = '0' + dd;

} 

if(mm < 10) {

  mm = '0' + mm

} 

today = yyyy+'/'+mm+'/'+dd;
    
$(document).ready(function() {

  $('#calendar').fullCalendar({

    header: {

    left: 'prev,next today',

    center: 'title',

    right: 'month,basicWeek,basicDay',

  },
  
  eventMouseover: function(calEvent, jsEvent) {

    var tooltip = '<div class="tooltipevent" style="width:100px;background:#ccc;position:absolute;z-index:10001;">' 

    + calEvent.title + '</div>';

      $("body").append(tooltip);

      $(this).mouseover(function(e) {

        $(this).css('z-index', 10000);

        $('.tooltipevent').fadeIn('500');

        $('.tooltipevent').fadeTo('10', 1.9);

      }).mousemove(function(e) {

        $('.tooltipevent').css('top', e.pageY + 10);

        $('.tooltipevent').css('left', e.pageX + 20);

      }); 

    },

    eventMouseout: function(calEvent, jsEvent) {

      $(this).css('z-index', 8);

      $('.tooltipevent').remove();

    },
    defaultDate: today,
    editable: true,
    eventLimit: true, 
    // events: api + "",
    eventClick: function(event) {
      if (event.url) {
          window.open(event.url, "_blank");
          return false;
      }
    }

  });

});

</script>
<style>

  #calendar {
    max-width: 80%;
    margin: 0 auto;
    margin-top: 20px !important;

  }
  .btn.btn-default.red {
      background-color: red;
  }
  .btn.btn-default.green {
      background-color: green;
  }
  .btn.btn-default.orange {
      background-color: #3A87AD;
  }
  .btn.btn-default.blue {
      background-color: blue;
  }

</style>

<div class="row">


  <div class="col-md-7 col-sm-7 ">

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="x_panel tile" style="background: rgb(220,219,238); background: linear-gradient(90deg, rgba(220,219,238,1) 0%, rgba(230,239,244,1) 0%, rgba(0,142,255,1) 61%);">
          <div class="x_title">
            <h1 style="font-family: Cambria,Georgia,serif; color: "><strong>WELCOME BACK! <?php echo $employee_name; ?></strong></h1>
            <div class="clearfix"></div>
          </div>
          <p>COLLEGE : <?php echo $college; ?></p>
        </div>
      </div>
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel tile">
          <div class="x_title">
            <h2>Class Schedules</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            
            <div class="widget_summary">

              <div class="table-responsive">
                <div style="overflow-y: auto;">
                  <table class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr class="bg-info">
                        <th style="width: 15px;">#</th>
                        <th class="text-center" style="width: 30%;"> COURSE </th>
                        <th class="text-center"> DAY </th>
                        <th class="text-center"> ROOM </th>
                        <th class="text-center"> TIME START </th>
                        <th class="text-center"> TIME END </th>
                        <th class="text-center"> SECTION </th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      <?php 

                        if(!empty($faculty_data['ClassScheduleSub'])){

                          foreach ($faculty_data['ClassScheduleSub'] as $key => $value) { ?>

                            <tr>
                              <td style="width: 15px;"> <?php echo $key + 1; ?> </td>
                              <td style="width: 15px;"> <?php echo $value['course']; ?> </td>
                              <td class="text-center">
                                <?php

                                if(!empty($value['ClassScheduleDay'])){

                                  foreach ($value['ClassScheduleDay'] as $keys => $values) { 
                                    
                                    echo $values['day']."<br>";

                                  }

                                } ?>
                              </td>
                              <td class="text-center">
                                <?php

                                if(!empty($value['ClassScheduleDay'])){

                                  foreach ($value['ClassScheduleDay'] as $keys => $values) { 
                                    
                                    echo $values['room']."<br>";

                                  }

                                } ?>
                              </td>
                              <td class="text-center">
                                <?php

                                if(!empty($value['ClassScheduleDay'])){

                                  foreach ($value['ClassScheduleDay'] as $keys => $values) { 
                                    
                                    echo $values['time_start']."<br>";

                                  }

                                } ?>
                              </td>
                              <td class="text-center">
                                <?php

                                if(!empty($value['ClassScheduleDay'])){

                                  foreach ($value['ClassScheduleDay'] as $keys => $values) { 
                                    
                                    echo $values['time_end']."<br>";

                                  }

                                } ?>
                              </td>
                              <td class="text-center">
                                <?php

                                if(!empty($value['ClassScheduleDay'])){

                                  foreach ($value['ClassScheduleDay'] as $keys => $values) { 
                                    
                                    echo $values['section']."<br>";

                                  }

                                } ?>
                              </td>
                             
                            </tr>

                          <?php }

                        }else{ ?>

                          <td class="text-center" colspan="7">No available data.</td>

                        <?php }

                      ?>

                    </tbody>
                  </table>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="col-md-5 col-sm-5 ">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="x_panel tile">
          <div class="x_title">
            <h2>Calendar</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div id="calendar">
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-12">
      <div class="x_panel tile">
        <div class="x_title">
          <h4><i class="fa fa-birthday-cake"></i>&nbsp;Birthday Celebrants <?php echo $thisMonth?></h4>
          <div class="clearfix"></div>
        </div>

        <?php if(!empty($birthday_celebrant)){ ?>
          <?php foreach($birthday_celebrant as $key => $data){ ?>
            <div class="s-member">
              <div class="media align-items-center">
                <div class="media-body">
                  <p style="padding-top: 15px;"><?php echo $data['Employee']['family_name'].', '.$data['Employee']['given_name']; ?></p><span><?php echo fdate($data['Employee']['birthdate'],'m/d/Y'); ?></span>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>

      </div>
    </div>
    
  </div>

</div>

<!-- <div id="calendar"></div> -->