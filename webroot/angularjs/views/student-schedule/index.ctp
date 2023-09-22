<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">SCHEDULE</h4>
        <div class="clearfix"></div><hr>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
              <button ng-click="print()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
              <button type="button" class="btn btn-warning btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
            </div>
            <div class="col-md-4 col-xs-12 pull-right">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search" ng-enter="searchy(searchTxt)" placeholder="SEARCH HERE" ng-model="searchTxt">
              </div>
              <sup style="font-color:gray">Press Enter to search</sup> 
            </div>
          </div>
        </div>
        <div class="clearfix"></div><hr>
        <div class="single-table mb-5">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr class="bg-print">
                  <th >TIME</th>
                  <th style="width: 600px" ng-repeat="day in days">{{day}}</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <tr>
                    <td class="text-center bg-print" rowspan="2">8:00</td>
                    <td class="text-center" ng-repeat="day in days"></td>
                  </tr>
                  <tr>
                    <td class="text-center" ng-repeat="day in days"></td>
                  </tr>
                </tr>

                <tr>
                  <tr>
                    <td class="text-center bg-print" rowspan="2">8:00</td>
                    <td class="text-center" ng-repeat="day in days"></td>
                  </tr>
                  <tr>
                    <td class="text-center" ng-repeat="day in days"></td>
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
