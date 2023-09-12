<?php if (hasAccess('referral slip/index', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">REFERRAL/APPOINTMENT SLIP MANAGEMENT</h4>
        <div class="clearfix"></div><hr>
          <div class="col-lg-12">
            <div class="col-md-8 col-xs-12">
              <ul class="nav nav-tabs" id="myTab" role="tablist" style="cursor: pointer;">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" data-target ="#referral" role="tab">REFERRAL</a>
                </li>
                <?php if (hasAccess('appointment slip/index', $currentUser)): ?>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" data-target ="#appointment" role="tab">APPOINTMENT</a>
                </li>
                <?php endif ?> 
              </ul>
            </div>
            <div class="col-md-4 col-xs-12 pull-right">
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
            <div class="tab-content mt-3" id="myTabContent">
              <div class="clearfix"></div><hr>
              <div class="tab-pane fade show active" id="referral">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <?php if (hasAccess('referral slip/add', $currentUser)): ?>
                        <a href="#/guidance/referral-slip/add" class="btn btn-primary btn-sm btn-min"><i class="fa fa-plus"></i> ADD </a>
                      <?php endif ?> 
                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                      <?php if (hasAccess('referral slip/print', $currentUser)): ?>
                        <button ng-click="printReferral()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
                      <?php endif ?>
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
                <div class="clearfix"></div><hr>
                <div class="single-table mb-5">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center">
                      <thead>
                        <tr class="bg-info">
                          <th class="w10px" style="width: 50px">#</th>
                          <th>CONTROL NO.</th>
                          <th>STUDENT NAME</th>
                          <th>COLLEGE PROGRAM</th>
                          <th>YEAR</th>
                          <th>REASON</th>
                          <th class="w90px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in datas">
                          <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                          <td class="text-center">{{ data.code }}</td>
                          <td class="text-left">{{ data.full_name }}</td>
                          <td class="text-center">{{ data.course }}</td>
                          <td class="text-center">{{ data.year }}</td>
                          <td class="text-center">{{ data.reason }}</td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <?php if (hasAccess('referral slip/view', $currentUser)): ?>
                                <a href="#/guidance/referral-slip/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                              <?php endif ?> 
                              <?php if (hasAccess('referral slip/edit', $currentUser)): ?>
                                <a href="#/guidance/referral-slip/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a>
                              <?php endif ?> 
                              <?php if (hasAccess('referral slip/delete', $currentUser)): ?>
                              <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                              <?php endif ?> 
                            </div>
                          </td> 
                        </tr>
                        <tr ng-show="datas == null || datas == ''">
                          <td colspan="12">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page - 1, search: searchTxt })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page + 1, search: searchTxt })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginator.pageCount > 0">
                      <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="appointment">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <?php if (hasAccess('appointment slip/add', $currentUser)): ?>
                        <a href="#/guidance/appointment-slip/add" class="btn btn-primary btn-sm btn-min"><i class="fa fa-plus"></i> ADD </a>
                      <?php endif ?> 
                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                      <?php if (hasAccess('appointment slip/print', $currentUser)): ?>
                        <button ng-click="printAppointment()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
                      <?php endif ?>
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
                <div class="clearfix"></div><hr>
                <div class="single-table mb-5">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center">
                      <thead>
                        <tr class="bg-info">
                          <th class="w10px" style="width: 50px">#</th>
                          <th>CONTROL NO.</th>
                          <th>STUDENT NAME</th>
                          <th>DATE</th>
                          <th>TIME</th>
                          <th>LOCATION</th>
                          <th class="w90px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in appointments">
                          <td class="text-center">{{ (paginatorAppointment.page - 1 ) * paginatorAppointment.limit + $index + 1 }}</td>
                          <td class="text-center">{{ data.code }}</td>
                          <td class="text-left">{{ data.student_name }}</td>
                          <td class="text-center">{{ data.date }}</td>
                          <td class="text-center">{{ data.time }}</td>
                          <td class="text-left">{{ data.location }}</td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <?php if (hasAccess('appointment slip/view', $currentUser)): ?>
                                <a href="#/guidance/appointment-slip/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                              <?php endif ?> 
                              <?php if (hasAccess('appointment slip/edit', $currentUser)): ?>
                                <a href="#/guidance/appointment-slip/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a>
                              <?php endif ?> 
                              <?php if (hasAccess('appointment slip/delete', $currentUser)): ?>
                              <a href="javascript:void(0)" ng-click="removeAppointment(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                              <?php endif ?> 
                            </div>
                          </td> 
                        </tr>
                        <tr ng-show="appointments == null || appointments == ''">
                          <td colspan="6">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="appointment({ page: 1, search: searchTxt })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginatorAppointment.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="appointment({ page: paginatorAppointment.page - 1, search: searchTxt })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesAppointment" class="page-item {{ paginatorAppointment.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="appointment({ page: page.number, search: searchTxt })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorAppointment.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="appointment({ page: paginatorAppointment.page + 1, search: searchTxt })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="appointment({ page: paginatorAppointment.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorAppointment.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorAppointment.pageCount > 0 ? paginatorAppointment.page : 0 }} out of {{ paginatorAppointment.pageCount }}</sup>
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
</div>
<?php endif ?>


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
