<div class="modal fade" id="sale-search-modal">
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
                        <option value="today">TODAY</option>
                        <option value="month">MONTH</option>
                        <option value="year">YEAR</option>
                        <option value="thisMonth">THIS MONTH</option>
                        <option value="custom">CUSTOM RANGE</option>
                      </select>
                    </div>
                  </div>
              </div>

              <div ng-show="search.filterBy == 'custom'">
                <div class="col-md-12">
                  <div class="input-group input-daterange">
                      <input type="text" class="form-control input-sm uppercase" ng-model="search.startDate">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      <input type="text" class="form-control input-sm uppercase" ng-model="search.endDate">
                  </div>
                </div>  

               <!--  <div class="col-md-6">
                  <div class="form-group">
                    <label>START DATE</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control rangepicker input-sm uppercase" ng-model="search.startDate">
                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>END DATE</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      <input type="text" class="form-control rangepicker input-sm uppercase" ng-model="search.endDate">
                    </div>
                  </div>
                </div> -->
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
                <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="search_By(search)"> SEARCH</button>
              </div> 
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->