<div class="modal fade" id="member-advance-search-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">SEARCH SETTINGS</h4>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                <div class="form-group">
                    <label>FILTER BY</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                      <select class="form-control input-sm" ng-model="search.filterBy">
                        <!-- <option value="statuses">STATUS</option>
                        <option value="gender">GENDER</option> -->
                        <option value="type">MEMBERSHIP TYPE</option>
                        <option value="date">DATE</option>

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

              <div ng-show="search.filterBy == 'statuses'">
                <div class="col-md-12">
                   <select class="form-control input-sm uppercase" ng-model="search.status" data-validation-engine="validate[required]">
                      <option value=""></option>
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                      <option value="3">Closed</option>
                  </select>
                </div>              
              </div>  

              <div ng-show="search.filterBy == 'type'">
                <div class="col-md-12">
                   <select class="form-control input-sm uppercase" ng-model="search.status" data-validation-engine="validate[required]" ng-options="opt.id as opt.value for opt in member_types">
                      <option value=""></option>
                  </select>
                </div>              
              </div>  

              <div ng-show="search.filterBy == 'year'">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>YEAR</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control yearpicker input-sm uppercase" ng-model="search.year">
                      </div>
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

            </div>
            <div class="modal-footer">
              <div class="btn-group btn-group-sm pull-right btn-min">
                <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"> CANCEL</button>
                <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="searchFilter(search)"> SEARCH</button>
              </div> 
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->