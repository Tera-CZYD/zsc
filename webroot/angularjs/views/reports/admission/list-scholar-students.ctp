<script type="text/javascript">

  function handleAccess(elementId, permissionCode, currentUser) {
    const element = document.getElementById(elementId);
    const accessGranted = hasAccess(permissionCode, currentUser);
    
    if (accessGranted) {
      element.classList.remove('d-none'); // Remove Bootstrap's "d-none" class to show the element
    } else {
      element.classList.add('d-none'); // Add Bootstrap's "d-none" class to hide the element
    }
  }

  // INCLUDE ALL PAGE PERMISSION
  handleAccess('pageIndex', 'scholarship application/index', currentUser);
  handleAccess('pagePrint', 'scholarship application/print', currentUser);

</script>

<div class="row" id="pageIndex">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">SCHOLARSHIP APPLICATION</h4> 
        <div class="clearfix"></div>
        <hr>
        <!-- nav tab start -->
        <div class="col-md-8">
          <div class="col-md-6">
            <div class="form-group">
              <label> PROGRAM </label>
              <select selectize ng-model="program_id" ng-options="opt.id as opt.value for opt in programs">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label> YEAR TERM </label>
              <select selectize ng-model="year" ng-options="opt.id as opt.value for opt in year_terms">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label> SCHOLARSHIP </label>
              <select selectize ng-model="scholarship" ng-options="opt.id as opt.value for opt in scholarships" ng-change = "getFinal()">
                <option value=""></option>
              </select>
            </div>
          </div>
        </div> 

        <div class="col-md-4" style="margin-top: 28.5px">
          <div class="input-group-prepend">

            <span class="dropleft float-right input-group-text" style="padding : 0;">
              <a class="fa fa-filter" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 15px;"></a>
              <div class="dropdown-menu">
                <div ng-show="!data.CourseActivity.disable_admin_quiz_button">
                  <a class="dropdown-item text-dark" href="javascript:void(0)" ng-click="changeFilter('date')">DATE</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item text-dark" href="javascript:void(0)" ng-click="changeFilter('month')">MONTH</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item text-dark" href="javascript:void(0)" ng-click="changeFilter('customRange')">CUSTOM RANGE</a>
                </div>
              </div>
            </span>
            <input ng-show="selectedFilter == 'date'" type="text" class="form-control datepicker input-sm uppercase" ng-model="search.date" ng-change="searchFilter(search)" placeholder="FILTER BY DATE">
            <input ng-show="selectedFilter == 'month'" type="text" class="form-control monthpicker input-sm uppercase" ng-model="search.month" ng-change="searchFilter(search)" placeholder="FILTER BY MONTH">
            <div class="input-group input-daterange" style="margin-bottom: 0;" ng-show="selectedFilter == 'customRange'">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              </div>
              <input type="text" class="form-control input-sm uppercase" ng-model="search.startDate" ng-change="searchFilter(search)" placeholder="START DATE">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              </div>
              <input type="text" class="form-control input-sm uppercase" ng-model="search.endDate" ng-change="searchFilter(search)" placeholder="END DATE">
            </div>
          </div>
        </div>
        
        <div class="col-lg-12">

          <div class="tab-content mt-3" id="myTabContent">
            <div class="clearfix"></div><hr>

            <div class="tab-pane fade show active" id="confirmed">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                    <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                    <button id="pagePrint" ng-click="printConfirmed()" class="btn btn-print  btn-min"><i class="fa fa-print"></i>PRINT</button>
                    <button type="button" class="btn btn-warning  btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
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
              <div class="clearfix"></div>
              <hr>
              <div class="single-table mb-5">
                <div class="table-responsive">
                  <table class="table table-bordered text-center">
                    <thread>
                      <tr class="bg-info">
                        <th class="text-center w30px">#</th>
                        <th class="text-center"> CONTROL NO. </th>
                        <th class="text-center"> STUDENT NAME </th>
                        <th class="text-center"> DATE APPLIED </th>
                        <th class="text-center"> PROGRAM </th>
                        <th class="text-center"> SCHOLARSHIP NAME </th>
                        <th class="text-center"> AGE </th>
                        <th class="text-center"> SEX </th>
                        <th class="text-center"> STATUS </th>
                        
                      </tr>
                    </thread>
                    <tbody>
                      <tr ng-repeat="data in datasConfirmed">
                        <td class="text-center">{{ (paginatorConfirmed.page - 1 ) * paginatorConfirmed.limit + $index + 1 }}</td>
                        <td class="text-center">{{ data.code }}</td>
                        <td class="text-center">{{ data.student_name }}</td>
                        <td class="text-center">{{ data.date }}</td>
                        <td class="text-center">{{ data.program }}</td>
                        <td class="text-center">{{ data.scholarship_name }}</td>
                        <td class="text-center">{{ data.age }}</td>
                        <td class="text-center">{{ data.sex }}</td>
                        <td class="text-center">CONFIRMED</td>
                      </tr>
                      <tr ng-show="datasConfirmed == null || datasConfirmed == ''">
                        <td colspan="10">No available data</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <ul class="pagination justify-content-center">
                    <li class="page-item">
                      <a class="page-link" href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt })"><sub>&laquo;&laquo;</sub></a>
                    </li>
                    <li class="page-item prevPage {{ !paginatorConfirmed.prevPage? 'disabled':'' }}">
                      <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorConfirmed.page - 1, search: searchTxt })">&laquo;</a>
                    </li>
                    <li ng-repeat="page in pagesConfirmed" class="page-item {{ paginatorConfirmed.page == page.number ? 'active':''}}">
                      <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt })">{{ page.number }}</a>
                    </li>
                    <li class="page-item nextPage {{ !paginatorConfirmed.nextPage? 'disabled':'' }}">
                      <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorConfirmed.page + 1, search: searchTxt })">&raquo;</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorConfirmed.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                  <div class="text-center" ng-show="paginatorConfirmed.pageCount > 0">
                    <sup class="text-primary">Page {{ paginatorConfirmed.pageCount > 0 ? paginatorConfirmed.page : 0 }} out of {{ paginatorConfirmed.pageCount }}</sup>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>




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
                <option value="date">DATE</option>
                <option value="today">TODAY</option>
                <option value="month">MONTH</option>
                <option value="this-month">THIS MONTH</option>
                <option value="custom-range">CUSTOM RANGE</option>
              </select>
            </div>
          </div>
        </div>
        <div ng-show="search.filterBy == 'custom-range'">
          <div class="col-md-12">
            <div class="input-group input-daterange mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              </div>
              <input type="text" class="form-control input-sm uppercase" ng-model="search.startDate">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              </div>
              <input type="text" class="form-control input-sm uppercase" ng-model="search.endDate">
            </div>
          </div>  
        </div>  
        <div ng-show="search.filterBy == 'month'">
          <div class="col-md-12">
            <div class="form-group">
              <label>MONTH</label>
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" class="form-control monthpicker input-sm uppercase" ng-model="search.month">
              </div>
            </div>
          </div>
        </div>
        <div ng-show="search.filterBy == 'date'">
          <div class="col-md-12">
            <div class="form-group">
              <label>DATE</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" class="form-control datepicker input-sm uppercase" ng-model="search.date">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <div class="btn-group btn-group-sm pull-right btn-min"> -->
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"> CANCEL</button>
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="searchFilter(search)"> SEARCH</button>
        <!-- </div>  -->
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div>
