<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">APARTELLE STUDENT CLEARANCE APPLICATION</h4>
        <div class="clearfix"></div><hr>
        <!-- nav tab start -->
          <div class="col-lg-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="cursor: pointer;">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" data-target ="#pending" role="tab">PENDING</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-target ="#approved" role="tab">APPROVED</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-target ="#disapproved" role="tab">DISAPPROVED</a>
              </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">

              <div class="tab-pane fade show active" id="pending">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">

                      <a href="#/corporate-affairs/apartelle-student-clearance/add" class="btn btn-primary  btn-min"><i class="fa fa-plus"></i> ADD</a>

                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->

                        <button ng-click="print()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>

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
                      <thread>
                        <tr class="bg-info">
                            <th class="text-center w30px">#</th>
                            <th class="text-center"> CONTROL NO. </th>
                            <th class="text-center"> STUDENT NAME </th>
                            <th class="text-center"> PROGRAM </th>
                            <th class="text-center"> YEAR LEVEL </th>
                            <th class="text-center"> STATUS </th>
                            <th class="w90px"></th>
                          </tr>
                        </thread>
                        <tbody>
                          <tr ng-repeat="data in datas">
                            <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                            <td class="text-center">{{ data.code }}</td>
                            <td class="text-center">{{ data.student_name }}</td>
                            <td class="text-center">{{ data.course }}</td>
                            <td class="text-center">{{ data.year_level }}</td>
                            <td class="w90px text-center">
                              <span ng-if="data.status == 2" class="label label-danger"> DISAPPROVED </span>
                              <span ng-if="data.status == 1" class="label label-primary"> APPROVED </span>
                              <span ng-if="data.status == 0" class="label label-warning"> PENDING </span>
                            </td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <a href="#/corporate-affairs/apartelle-student-clearance/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                              <a href="#/corporate-affairs/apartelle-student-clearance/edit/{{ data.id }}" class="btn btn-primary" ng-disabled = "data.status != 0" title="EDIT"><i class="fa fa-edit"></i></a> 
                              <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" ng-disabled = "data.status != 0" title="DELETE"><i class="fa fa-trash"></i></a>
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

              <div class="tab-pane fade show" id="approved">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">

                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->

                        <button ng-click="printApproved()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>

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
                      <thread>
                        <tr class="bg-info">
                          <th class="text-center w30px">#</th>
                          <th class="text-center"> CONTROL NO. </th>
                          <th class="text-center"> NICK NAME </th>
                          <th class="text-center"> DATE OF BIRTH </th>
                          <th class="text-center"> ADDRESS </th>
                          <th class="text-center"> COURSE </th>
                          <th class="text-center"> YEAR LEVEL </th>
                          <th class="text-center"> STATUS </th>
                          <th class="w90px"></th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datasApproved">
                          <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                          <td class="text-center">{{ data.code }}</td>
                          <td class="text-center">{{ data.nick_name }}</td>
                          <td class="text-center">{{ data.date_of_birth }}</td>
                          <td class="text-center">{{ data.address }}</td>
                          <td class="text-center">{{ data.course }}</td>
                          <td class="text-center">{{ data.year_level }}</td>
                          <td class="w90px text-center">
                            <span ng-if="data.status == 2" class="label label-danger"> DISAPPROVED </span>
                            <span ng-if="data.status == 1" class="label label-primary"> APPROVED </span>
                            <span ng-if="data.status == 0" class="label label-warning"> PENDING </span>
                          </td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <a href="#/corporate-affairs/apartelle-registration/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                              <a href="#/corporate-affairs/apartelle-registration/edit/{{ data.id }}" class="btn btn-primary" ng-disabled = "data.status != 0" title="EDIT"><i class="fa fa-edit"></i></a> 
                              <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" ng-disabled = "data.status != 0" title="DELETE"><i class="fa fa-trash"></i></a>
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="datasApproved == null || datasApproved == ''">
                          <td colspan="12">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="approved({ page: 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginatorApproved.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="approved({ page: paginatorApproved.page - 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesApproved" class="page-item {{ paginatorApproved.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="approved({ page: page.number, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorApproved.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="approved({ page: paginatorApproved.page + 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="approved({ page: paginatorApproved.pageCount, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorApproved.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorApproved.pageCount > 0 ? paginatorApproved.page : 0 }} out of {{ paginatorApproved.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade show" id="disapproved">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">

                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->

                        <button ng-click="printDisapproved()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>

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
                      <thread>
                        <tr class="bg-info">
                          <th class="text-center w30px">#</th>
                          <th class="text-center"> CONTROL NO. </th>
                          <th class="text-center"> NICK NAME </th>
                          <th class="text-center"> DATE OF BIRTH </th>
                          <th class="text-center"> ADDRESS </th>
                          <th class="text-center"> COURSE </th>
                          <th class="text-center"> YEAR LEVEL </th>
                          <th class="text-center"> STATUS </th>
                          <th class="w90px"></th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datasDisapproved">
                          <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                          <td class="text-center">{{ data.code }}</td>
                          <td class="text-center">{{ data.nick_name }}</td>
                          <td class="text-center">{{ data.date_of_birth }}</td>
                          <td class="text-center">{{ data.address }}</td>
                          <td class="text-center">{{ data.course }}</td>
                          <td class="text-center">{{ data.year_level }}</td>
                          <td class="w90px text-center">
                            <span ng-if="data.status == 2" class="label label-danger"> DISAPPROVED </span>
                            <span ng-if="data.status == 1" class="label label-primary"> APPROVED </span>
                            <span ng-if="data.status == 0" class="label label-warning"> PENDING </span>
                          </td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <a href="#/corporate-affairs/apartelle-registration/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                              <a href="#/corporate-affairs/apartelle-registration/edit/{{ data.id }}" class="btn btn-primary" ng-disabled = "data.status != 0" title="EDIT"><i class="fa fa-edit"></i></a> 
                              <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" ng-disabled = "data.status != 0" title="DELETE"><i class="fa fa-trash"></i></a>
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="datasDisapproved == null || datasDisapproved == ''">
                          <td colspan="12">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-12">
                  <ul class="pagination justify-content-center">
                    <li class="page-item">
                      <a class="page-link" href="javascript:void(0)" ng-click="disapproved({ page: 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate })"><sub>&laquo;&laquo;</sub></a>
                    </li>
                    <li class="page-item prevPage {{ !paginatorDisapproved.prevPage? 'disabled':'' }}">
                      <a class="page-link" href="javascript:void(0)" ng-click="disapproved({ page: paginatorDisapproved.page - 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate })">&laquo;</a>
                    </li>
                    <li ng-repeat="page in pagesDisapproved" class="page-item {{ paginatorDisapproved.page == page.number ? 'active':''}}" >
                      <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="disapproved({ page: page.number, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate })">{{ page.number }}</a>
                    </li>
                    <li class="page-item nextPage {{ !paginatorDisapproved.nextPage? 'disabled':'' }}">
                      <a class="page-link" href="javascript:void(0)" ng-click="disapproved({ page: paginatorDisapproved.page + 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate })">&raquo;</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="javascript:void(0)" ng-click="disapproved({ page: paginatorDisapproved.pageCount, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate })"><sub>&raquo;&raquo;</sub> </a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                  <div class="text-center" ng-show="paginatorDisapproved.pageCount > 0">
                    <sup class="text-primary">Page {{ paginatorDisapproved.pageCount > 0 ? paginatorDisapproved.page : 0 }} out of {{ paginatorDisapproved.pageCount }}</sup>
                  </div>
                </div>
              </div>

            </div>
          </div>
      </div>
    </div>
  </div>
</div>