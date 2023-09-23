<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">SCHEDULE {{classSchedule}}</h4>
        <div class="clearfix"></div><hr>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
              <button ng-click="print()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
            </div>
          </div>
        </div>
        <div class="clearfix"></div><hr>
        <div class="single-table mb-5">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr class="bg-print">
                  <th style="width: 200px;">TIME</th>
                  <th style="width: 500px" ng-repeat="day in days">{{day}}</th>
                </tr>
              </thead>
              <tbody>

                <!-- <tr ng-repeat="timeSlot in timeSlots">
                  <tr>
                    <td class="text-center bg-print" rowspan="2">{{timeSlot}}</td>
                    <td class="text-center" ng-repeat="day in days"></td>
                  </tr>
                  <tr>
                    <td class="text-center" ng-repeat="day in days"></td>
                  </tr>
                </tr> -->

              <tr>
                <tr>
                  <td class="text-center bg-print" rowspan="2">8:00</td>
                  <td class="text-center" ng-repeat="day in days"></td>
                </tr>
                <tr ng-repeat="timeSlot in timeSlots">
                    <td ng-repeat="day in days">
                      <div ng-repeat="classItem in classes">
                          <span ng-if="classItem.timeSlot === timeSlot">
                              {{ classItem.course }}<br>
                              {{ classItem.faculty_name }}<br>
                              Room: {{ classItem.room }}
                          </span>
                      </div>
                  </td>
                </tr>
              </tr>

              </tbody>
            </table>
          </div>
        </div>
        <div class="clearfix"></div>
        
      </div>
    </div>
  </div>
</div>
