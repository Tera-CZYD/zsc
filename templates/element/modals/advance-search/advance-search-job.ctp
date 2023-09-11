
<div class="modal fade" id="advance-search-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ADVANCE SEARCH</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>FILTER BY</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-list-ul"></i></span>
              </div>
              <select class="form-control input-sm" ng-model="search.filterBy">
                <option value="today">TODAY</option>
                <option value="date">DATE</option>
                <option value="month">MONTH</option>
                <option value="this-month">THIS MONTH</option>
                <option value="custom-range">CUSTOM RANGE</option>>
              </select>
            </div>
          </div>
        </div>
        <div ng-show="search.filterBy == 'date'">
          <div class="col-md-12">
            <div class="form-group">
              <label>DATE</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control datepicker input-sm uppercase" ng-model="search.date">
              </div>
            </div>
          </div>
        </div>
        <div ng-show="search.filterBy == 'custom-range'">
          <div class="col-md-12">
            <div class="input-group input-daterange">
              <input type="text" class="form-control input-sm uppercase" ng-model="search.startDate">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input type="text" class="form-control input-sm uppercase" ng-model="search.endDate">
            </div>
          </div>  
        </div>  
        <div ng-show="search.filterBy == 'month'">
          <div class="col-md-12">
            <div class="form-group">
              <label>MONTH</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control monthpicker input-sm uppercase" ng-model="search.month">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>POSITION</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>
                <select class="form-control input-sm uppercase" ng-model="search.position_id" ng-options="opt.id as opt.value for opt in positions" data-validation-engine="validate[required]">
              </select>
              </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label> TYPE </label>
            <select class="form-control" ng-model="search.type">
              <option value=""></option>
              <option value="OFFICE">OFFICE</option>
              <option value="SERVICE">SERVICE</option>
              <option value="DIVISION">DIVISION</option>
              <option value="SECTION">SECTION</option>
              <option value="UNIT">UNIT</option>
            </select>
          </div>
        </div>
        <div class="col-md-12" ng-show = "search.type == 'OFFICE'">
          <div class="form-group">
            <label>OFFICE</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
              </div>
              <select class="form-control input-sm uppercase" ng-model="search.office_id" ng-options="opt.id as opt.value for opt in offices" data-validation-engine="validate[required]">
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12" ng-show = "search.type == 'SERVICE'">
          <div class="form-group">
            <label>SERVICE</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
              </div>
              <select class="form-control input-sm uppercase" ng-model="search.service_id" ng-options="opt.id as opt.value for opt in services" data-validation-engine="validate[required]">
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12" ng-show = "search.type == 'DIVISION'">
          <div class="form-group">
            <label>DIVISION</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
              </div>
              <select class="form-control input-sm uppercase" ng-model="search.division_id" ng-options="opt.id as opt.value for opt in divisions" data-validation-engine="validate[required]">
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12" ng-show = "search.type == 'SECTION'">
          <div class="form-group">
            <label>SECTION</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
              </div>
              <select class="form-control input-sm uppercase" ng-model="search.section_id" ng-options="opt.id as opt.value for opt in sections" data-validation-engine="validate[required]">
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12" ng-show = "search.type == 'UNIT'">
          <div class="form-group">
            <label>UNIT</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
              </div>
              <select class="form-control input-sm uppercase" ng-model="search.unit_id" ng-options="opt.id as opt.value for opt in units" data-validation-engine="validate[required]">
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="btn-group btn-group-sm pull-right btn-min">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"> CANCEL</button>
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="searchFilter(search)"> SEARCH</button>
        </div> 
      </div>
    </div>
  </div>
</div>