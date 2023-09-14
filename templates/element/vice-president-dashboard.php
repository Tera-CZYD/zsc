<meta charset='utf-8' />

<link href='<?php echo $this->base ?>/assets/plugins/fullcalendar-2.6.0/fullcalendar.css' rel='stylesheet' />

<link href='<?php echo $this->base ?>/assets/plugins/fullcalendar-2.6.0/fullcalendar.print.css' rel='stylesheet' media='print' />

<script src='<?php echo $this->base ?>/assets/plugins/fullcalendar-2.6.0/lib/moment.min.js'></script>

<script src='<?php echo $this->base ?>/assets/plugins/fullcalendar-2.6.0/fullcalendar.min.js'></script>

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
    events: api + "select?code=calendar-activities",
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
  <div class="chartdiv"></div>
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="col-md-12 mt-3">
      <div class="single-table">
        <div class="table-responsive">
          <table class="table table-bordered text-center">
            <thead>
              <tr class="bg-info">
                <th class="w10px" style="width: 50px">NO.</th>
                <th>ACADEMIC YEAR</th>
                <th>SEMESTER</th>
                <th># OF ENROLLED STUDENTS</th>
                <th>CLEARED STUDENTS</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center">1</td>
                <td class="text-center">2022-2023</td>
                <td class="text-left uppercase">1st Year 2nd Semester Summer</td>
                <td class="text-left">5,000</td>
                <td class="text-left">2,500</td>
              </tr>
              <tr>
                <td class="text-center">2</td>
                <td class="text-center">2023-2024</td>
                <td class="text-left uppercase">1st Year 2nd Semester Summer</td>
                <td class="text-left"></td>
                <td class="text-left"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>

    <div class="row">
    <div class="col-6 col-lg-3 col-md-6">
       <a href="#/faculty/grades">
        <div class="card">
            <div class="card-body px-0">
                <div class="col-4 float-left h3">
                  <i class="fa fa-book text-white align-middle bg-info rounded-circle p-3"></i>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-success font-weight-bold"> Student Clearance </h6>
                    <h3 class="font-extrabold mb-0">{{ StudentClearance }}</h3>
                  </div>
                </div> 
            </div>
            <div class="card-footer text-center">
              <a href="#/faculty/grades">
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-info font-semibold">Click Here  <i class="fa fa-arrow-right"></i></h6>
                </div>
              </a>
            </div>
        </div>
      </a>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
      <a href="#/faculty/grades">
        <div class="card">
            <div class="card-body px-0">
                <div class="col-4 float-left h3">
                  <i class="fa fa-medkit text-white align-middle bg-info rounded-circle p-3"></i>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-success font-weight-bold"> Grades </h6>
                    <h3 class="font-extrabold mb-0">{{ Employee }}</h3>
                  </div>
                </div> 
            </div>
            <div class="card-footer text-center">
              <a href="#/faculty/grades">
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-info font-semibold">Click Here  <i class="fa fa-arrow-right"></i></h6>
                </div>
              </a>
            </div>
        </div>
      </a>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
      <a href="#/faculty/faculty-clearance">
        <div class="card">
            <div class="card-body px-0">
                <div class="col-4 float-left h3">
                  <i class="fa fa-medkit text-white align-middle bg-info rounded-circle p-3"></i>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-success font-weight-bold"> Faculty Clearance </h6>
                    <h3 class="font-extrabold mb-0">{{ FacultyClearance }}</h3>
                  </div>
                </div> 
            </div>
            <div class="card-footer text-center">
              <a href="#/faculty/faculty-clearance">
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-info font-semibold">Click Here  <i class="fa fa-arrow-right"></i></h6>
                </div>
              </a>
            </div>
        </div>
      </a>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
      <a href="#/faculty/faculty-management">
        <div class="card">
            <div class="card-body px-0">
                <div class="col-4 float-left h3">
                  <i class="fa fa-medkit text-white align-middle bg-info rounded-circle p-3"></i>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-success font-weight-bold"> Faculty Management </h6>
                    <h3 class="font-extrabold mb-0">{{ Employee }}</h3>
                  </div>
                </div> 
            </div>
            <div class="card-footer text-center">
              <a href="#/faculty/faculty-management">
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-info font-semibold">Click Here  <i class="fa fa-arrow-right"></i></h6>
                </div>
              </a>
            </div>
        </div>
      </a>
    </div>
    </div>
    
    <!-- <div class="clearfix"></div><hr> -->
    <div class="card">
      <div class="card-body">
        <h4 class="header-title"> CALENDAR OF ACTIVITIES </h4>
        <div class="row">
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <!-- nav tab start -->
          <div class="col-lg-12">
            <div class="col-md-12">
              <div id="calendar">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
