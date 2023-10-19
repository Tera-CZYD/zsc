app.controller('StudentScheduleController', function($scope, $window, StudentSchedule) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.scrollToTop = function() {

    $window.scrollTo(0, 0);

  };

  $scope.scrollToTop();

  $scope.timeSlots = [];

  var startTime = new Date(0, 0, 0, 7, 0); // 7:00 AM

  var endTime = new Date(0, 0, 0, 17, 0);  // 5:00 PM


  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    StudentSchedule.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.paginator = e.paginator;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.pages = paginator($scope.paginator, 5);

        $scope.days = e.days;

        $scope.timeSlots = [];

        // Define the start and end times for the time slots
        var startTime = new Date(0, 0, 0, 7, 0); // 7:00 AM
        var endTime = new Date(0, 0, 0, 17, 0);  // 6:00 PM

        // Generate the time slots in 15-minute intervals
        while (startTime <= endTime) {

          var formattedTime = startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

          $scope.timeSlots.push(formattedTime);

          startTime.setMinutes(startTime.getMinutes() + 30); // Increment by 15 minutes

        }

        //CODE FOR THE SCHEDULE CHART

          setTimeout(function(){

            jQuery(document).ready(function($){

              function formatTimestampToStandardTime(timestamp) {

                // Create a new Date object using the Unix timestamp
                const date = new Date(timestamp * 1000); // Multiply by 1000 to convert seconds to milliseconds

                // Get the components of the date (hours, minutes, AM/PM)
                const hours = date.getHours() % 12 || 12; // Get hours in 12-hour format

                const minutes = String(date.getMinutes()).padStart(2, '0'); // Ensure minutes have leading zeros

                const amPm = date.getHours() >= 12 ? 'PM' : 'AM';

                // Create a string in the desired format
                const formattedTime = `${hours}:${minutes} ${amPm}`;

                return formattedTime;

              }

              var transitionEnd = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';

              var transitionsSupported = ( $('.csstransitions').length > 0 );

              //if browser does not support transitions - use a different event to trigger them

              if( !transitionsSupported ) transitionEnd = 'noTransition';
              
              //should add a loding while the events are organized 

              function SchedulePlan( element ) {
         
                this.element = element;
         
                this.timeline = this.element.find('.timeline');
         
                this.timelineItems = this.timeline.find('li');
         
                this.timelineItemsNumber = this.timelineItems.length;
         
                this.timelineStart = getScheduleTimestamp(this.timelineItems.eq(0).text());
         
                //need to store delta (in our case half hour) timestamp
         
                this.timelineUnitDuration = getScheduleTimestamp(this.timelineItems.eq(1).text()) - getScheduleTimestamp(this.timelineItems.eq(0).text());

                this.eventsWrapper = this.element.find('.events');

                this.eventsGroup = this.eventsWrapper.find('.events-group');

                this.singleEvents = this.eventsGroup.find('.single-event');

                this.eventSlotHeight = this.eventsGroup.eq(0).children('.top-info').outerHeight();

                this.animating = false;

                this.initSchedule();

              }

              SchedulePlan.prototype.initSchedule = function() {
           
                this.scheduleReset();
           
                this.initEvents();
           
              };

              SchedulePlan.prototype.scheduleReset = function() {
          
                var mq = this.mq();
          
                if( mq == 'desktop' && !this.element.hasClass('js-full') ) {
          
                  //in this case you are on a desktop version (first load or resize from mobile)
          
                  this.eventSlotHeight = this.eventsGroup.eq(0).children('.top-info').outerHeight();
          
                  this.element.addClass('js-full');
          
                  this.placeEvents();
          
                  this.element.hasClass('modal-is-open') && this.checkEventModal();
          
                } else if(  mq == 'mobile' && this.element.hasClass('js-full') ) {
          
                  //in this case you are on a mobile version (first load or resize from desktop)
          
                  this.element.removeClass('js-full loading');
          
                  this.eventsGroup.children('ul').add(this.singleEvents).removeAttr('style');
          
                  this.eventsWrapper.children('.grid-line').remove();
          
                  this.element.hasClass('modal-is-open') && this.checkEventModal();
          
                } else if( mq == 'desktop' && this.element.hasClass('modal-is-open')){
          
                  //on a mobile version with modal open - need to resize/move modal window
          
                  this.checkEventModal('desktop');
          
                  this.element.removeClass('loading');
          
                } else {
          
                  this.element.removeClass('loading');
          
                }
          
              };

              SchedulePlan.prototype.initEvents = function() {
         
                var self = this;

                this.singleEvents.each(function(){

                  var start = $(this).data('start'); // Assuming this is '13:45'

                  var timeArray = start.split(':');
          
                  var hours = parseInt(timeArray[0], 10);
          
                  var minutes = timeArray[1];

                  var period = hours >= 12 ? 'PM' : 'AM';

                  if (hours > 12) {

                    hours -= 12;

                  }

                  start = hours + ':' + minutes;

                  var end = $(this).data('end');

                  timeArray = end.split(':');

                  hours = parseInt(timeArray[0], 10);

                  minutes = timeArray[1];

                  period = hours >= 12 ? 'PM' : 'AM';

                  if (hours > 12) {
                      hours -= 12;
                  }

                  end = hours + ':' + minutes;

                  var durationLabel = '<span class="event-date">'+start+' - '+end+'</span>';

                });

              };

              SchedulePlan.prototype.placeEvents = function() {
         
                var self = this;
         
                this.singleEvents.each(function(){
         
                  //place each event in the grid -> need to set top position and height
         
                  var start = getScheduleTimestamp($(this).attr('data-start')),duration = getScheduleTimestamp($(this).attr('data-end')) - start;

                  var eventTop = self.eventSlotHeight*(start - self.timelineStart)/self.timelineUnitDuration,eventHeight = self.eventSlotHeight*duration/self.timelineUnitDuration;

                  $(this).css({

                    top: (eventTop -1) +'px',

                    height: (eventHeight+1)+'px'

                  });

                });

                this.element.removeClass('loading');

              };

              SchedulePlan.prototype.mq = function(){

                //get MQ value ('desktop' or 'mobile') 

                var self = this;

                return window.getComputedStyle(this.element.get(0), '::before').getPropertyValue('content').replace(/["']/g, '');

              };

              var schedules = $('.cd-schedule');

              var objSchedulesPlan = [],windowResize = false;
              
              if( schedules.length > 0 ) {

                schedules.each(function(){

                  //create SchedulePlan objects

                  objSchedulesPlan.push(new SchedulePlan($(this)));

                });

              }

              $(window).on('resize', function(){
             
                if( !windowResize ) {
             
                  windowResize = true;
             
                  (!window.requestAnimationFrame) ? setTimeout(checkResize) : window.requestAnimationFrame(checkResize);
             
                }
             
              });

              $(window).keyup(function(event) {
       
                if (event.keyCode == 27) {
       
                  objSchedulesPlan.forEach(function(element){
       
                    element.closeModal(element.eventsGroup.find('.selected-event'));
       
                  });
       
                }
       
              });

              function checkResize(){
          
                objSchedulesPlan.forEach(function(element){
          
                  element.scheduleReset();
          
                });
          
                windowResize = false;
          
              }

              function getScheduleTimestamp(time) {

                //accepts hh:mm format - convert hh:mm to timestamp
          
                time = time.replace(/ /g,'');
          
                var timeArray = time.split(':');
          
                var timeStamp = parseInt(timeArray[0])*60 + parseInt(timeArray[1]);

                return timeStamp;

              }

              function transformElement(element, value) {
         
                element.css({
         
                  '-moz-transform': value,
         
                  '-webkit-transform': value,
         
                  '-ms-transform': value,
         
                  '-o-transform': value,
         
                  'transform': value
         
                });
         
              }
         
            });

          },350);

        //END 

      }

    });

  }

  $scope.load();

  $scope.print = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/student_schedule?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_schedule?print=1');

    }

  }

});

app.controller('StudentScheduleAddController', function($scope, StudentSchedule) {

 $('#form').validationEngine('attach');

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

 $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $scope.data = {

    StudentSchedule : {}

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      StudentSchedule.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/StudentSchedules';

        } else {

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

      });

    }  

  }

});

app.controller('StudentScheduleEditController', function($scope, $routeParams, StudentSchedule) {
  
  $scope.id = $routeParams.id;

  $('#form').validationEngine('attach');

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

 $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $scope.data = {

    StudentSchedule : {}

  }

  // load 

  $scope.load = function() {

    StudentSchedule.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      StudentSchedule.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/StudentSchedules';

        } else {

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,
            
          });

        }
        
      }); 

    }

  }

});