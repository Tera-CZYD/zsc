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
  handleAccess('pageIndex', 'cat/index', currentUser);
  handleAccess('pagePrint', 'cat/print', currentUser);

</script>

<div class="row" id="pageIndex">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">EXAMINATIONS</h4>
        <div class="clearfix"></div><hr> 
        <!-- nav tab start -->
          <div class="col-lg-12">

            <div class="col-md-8 col-xs-12">
              <ul class="nav nav-tabs" id="myTab" role="tablist" style="cursor: pointer;">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" data-target ="#for_assessment" role="tab">FOR RATING</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" data-target ="#for_interview" role="tab">FOR MEDICAL INTERVIEW</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" data-target ="#qualified" role="tab">QUALIFIED</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" data-target ="#unqualified" role="tab">UNQUALIFIED</a>
                </li>
              </ul>
            </div>

          <div class="col-md-4 col-xs-12">
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
              <div class="tab-pane fade show active" id="for_assessment">
                <div class="col-md-12">
                  <div class="row mt-3">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                      <button id="pagePrint" ng-click="print()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
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
                          <th class="text-center"> APPLICANT NAME </th>
                          <th class="text-center"> EMAIL </th>
                          <th class="text-center"> ADDRESS </th>
                          <th class="text-center"> CONTACT NO. </th>
                          <th class="text-center"> GENDER </th>
                          <th class="text-center"> APPLICATION DATE </th>

                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datas">
                          <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                          <td class="text-left">{{ data.full_name }}</td>
                          <td class="text-center">{{ data.email }}</td>
                          <td class="text-center">{{ data.address }}</td>
                          <td class="text-center">{{ data.contact_no }}</td>
                          <td class="text-center">{{ data.gender }}</td>
                          <td class="text-center">{{ data.application_date }}</td>

                        </tr>
                        <tr ng-show="datas == null || datas == ''">
                          <td colspan="9">No available data</td>
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
              <div class="tab-pane fade show" id="for_interview">
                <div class="col-md-12">
                  <div class="row mt-3">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                      <button id="pagePrint" ng-click="printInterview()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
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
                          <th class="text-center"> APPLICANT NAME </th>
                          <th class="text-center"> EMAIL </th>
                          <th class="text-center"> ADDRESS </th>
                          <th class="text-center"> CONTACT NO. </th>
                          <th class="text-center"> GENDER </th>
                          <th class="text-center"> APPLICATION DATE </th>
                          <th class="text-center" id="studentRating" ng-click='studentRating()' ng-model="orderRating"><i class="fa fa-sort"></i> RATING </th>
                          <th class="text-center"> STATUS </th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datasInterview">
                          <td class="text-center">{{ (paginatorInterview.page - 1 ) * paginatorInterview.limit + $index + 1 }}</td>
                          <td class="text-left">{{ data.full_name }}</td>
                          <td class="text-center">{{ data.email }}</td>
                          <td class="text-center">{{ data.address }}</td>
                          <td class="text-center">{{ data.contact_no }}</td>
                          <td class="text-center">{{ data.gender }}</td>
                          <td class="text-center">{{ data.application_date }}</td>
                          <td class="text-center">{{ data.rate }}</td>
                          <td class="text-center">{{ data.status }}</td>
                        </tr>
                        <tr ng-show="datasInterview == null || datasInterview == ''">
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
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt,order:orderPaginator  })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginatorInterview.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorInterview.page - 1, search: searchTxt,order:orderPaginator  })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesInterview" class="page-item {{ paginatorInterview.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt,order:orderPaginator  })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorInterviewd.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorInterview.page + 1, search: searchTxt,order:orderPaginator  })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorInterview.pageCount, search: searchTxt,order:orderPaginator  })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorInterview.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorInterview.pageCount > 0 ? paginatorInterview.page : 0 }} out of {{ paginatorInterview.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="qualified">
                <div class="col-md-12">
                  <div class="row mt-3">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                      <button id="pagePrint" ng-click="printAssessed()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
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
                          <th class="text-center"> APPLICANT NAME </th>
                          <th class="text-center"> EMAIL </th>
                          <th class="text-center"> ADDRESS </th>
                          <th class="text-center"> CONTACT NO. </th>
                          <th class="text-center"> GENDER </th>
                          <th class="text-center"> APPLICATION DATE </th>
                          <th class="text-center" id="studentRating" ng-click='studentRating()' ng-model="orderRating"><i class="fa fa-sort"></i> RATING </th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datasAssessed">
                          <td class="text-center">{{ (paginatorAssessed.page - 1 ) * paginatorAssessed.limit + $index + 1 }}</td>
                          <td class="text-left">{{ data.full_name }}</td>
                          <td class="text-center">{{ data.email }}</td>
                          <td class="text-center">{{ data.address }}</td>
                          <td class="text-center">{{ data.contact_no }}</td>
                          <td class="text-center">{{ data.gender }}</td>
                          <td class="text-center">{{ data.application_date }}</td>
                          <td class="text-center">{{ data.rate }}</td>
                        </tr>
                        <tr ng-show="datasAssessed == null || datasAssessed == ''">
                          <td colspan="9">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt,order:orderPaginator  })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginatorAssessed.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorAssessed.page - 1, search: searchTxt,order:orderPaginator  })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesAssessed" class="page-item {{ paginatorAssessed.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt,order:orderPaginator  })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorAssessed.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorAssessed.page + 1, search: searchTxt,order:orderPaginator  })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorAssessed.pageCount, search: searchTxt,order:orderPaginator  })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorAssessed.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorAssessed.pageCount > 0 ? paginatorAssessed.page : 0 }} out of {{ paginatorAssessed.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="unqualified">
                <div class="col-md-12">
                  <div class="row mt-3">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                        <button id="pagePrint" ng-click="printDisapproved()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
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
                          <th class="text-center"> APPLICANT NAME </th>
                          <th class="text-center"> EMAIL </th>
                          <th class="text-center"> ADDRESS </th>
                          <th class="text-center"> CONTACT NO. </th>
                          <th class="text-center"> GENDER </th>
                          <th class="text-center"> APPLICATION DATE </th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datasDisapproved">
                          <td class="text-center">{{ (paginatorDisapproved.page - 1 ) * paginatorDisapproved.limit + $index + 1 }}</td>
                          <td class="text-left">{{ data.full_name }}</td>
                          <td class="text-center">{{ data.email }}</td>
                          <td class="text-center">{{ data.address }}</td>
                          <td class="text-center">{{ data.contact_no }}</td>
                          <td class="text-center">{{ data.gender }}</td>
                          <td class="text-center">{{ data.application_date }}</td>
                        </tr>
                        <tr ng-show="datasDisapproved == null || datasDisapproved == ''">
                          <td colspan="8">No available data</td>
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
                      <li class="page-item prevPage {{ !paginatorDisapproved.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorDisapproved.page - 1, search: searchTxt })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesDisapproved" class="page-item {{ paginatorDisapproved.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorDisapproved.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorDisapproved.page + 1, search: searchTxt })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorDisapproved.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub> </a>
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


<div class="modal fade" id="send-mail-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-paper-plane"></i> SEND EMAIL </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="form-mail">  
          <div class="col-md-12">
            <div class="form-group">
              <label> DATE </label>
              <input type="text" class="form-control datepicker" ng-model="mail.date" data-validation-engine="validate[required]">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> TIME </label>
              <input type="text" class="form-control clockpicker" ng-model="mail.time" data-validation-engine="validate[required]">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> ROOM <i class="required">*</i></label>
              <select id="r" class="form-control" ng-model="mail.room" ng-options="opt.id as opt.value for opt in rooms" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> PLACE </label>
              <textarea type="text" class="form-control" ng-model="mail.place" data-validation-engine="validate[required]"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="sendEmailFinal(mail)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="send-bulk-mail-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-paper-plane"></i> SEND EMAIL </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="form-bulk-mail">  
          <div class="col-md-12">
            <div class="form-group">
              <label> DATE </label>
              <input type="text" class="form-control datepicker" ng-model="mail.date" data-validation-engine="validate[required]">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> TIME </label>
              <input type="text" class="form-control clockpicker" ng-model="mail.time" data-validation-engine="validate[required]">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> ROOM <i class="required">*</i></label>
              <select id="r" class="form-control" ng-model="mail.room" ng-options="opt.id as opt.value for opt in rooms" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> PLACE </label>
              <textarea type="text" class="form-control" ng-model="mail.place" data-validation-engine="validate[required]"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="sendSelected(mail)"><i class="fa fa-save"></i> SEND </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="view-request-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"> MEDICAL INTERVIEW REQUEST </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <p>{{ request.request_purpose }}</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="setSchedule(request)"><i class="ti ti-pencil-alt"></i> SET SCHEDULE </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="send-schedule-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-paper-plane"></i> SEND INTERVIEW SCHEDULE </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="form-schedule">  
          <div class="col-md-12">
            <div class="form-group">
              <label> DATE </label>
              <input type="text" class="form-control datepicker" ng-model="schedule.date" data-validation-engine="validate[required]" autocomplete="off">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> TIME </label>
              <input type="text" class="form-control clockpicker" ng-model="schedule.time" data-validation-engine="validate[required]" autocomplete="off">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> ROOM <i class="required">*</i></label>
              <select selectize ng-model="schedule.room" ng-options="opt.id as opt.value for opt in rooms" data-validation-engine="validate[required]" autocomplete="off">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> PLACE </label>
              <textarea type="text" class="form-control" ng-model="schedule.place" data-validation-engine="validate[required]" autocomplete="off"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="sendSchedule(schedule)"><i class="fa fa-paper-plane"></i> SEND </button>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  #action {
    min-width:100px;
    max-width:100px
  }
  #studentRating{
    cursor: pointer;
  }
  .popover.clockpicker-popover{
    z-index:1151 !important;
  }
</style>