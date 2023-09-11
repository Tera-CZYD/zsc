<?php if (hasAccess('student behavior/index', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">STUDENT BEHAVIOR</h4>
        <div class="clearfix"></div><hr>

        <div class="col-md-4">
          <div class="form-group">
            <label> PROGRAM </label>
            <select selectize ng-model="program_id" ng-options="opt.id as opt.value for opt in programs">
              <option value=""></option>
            </select>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label> YEAR TERM </label>
            <select selectize ng-model="year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change = "getData()">
              <option value=""></option>
            </select>
          </div>
        </div>

        <div class="clearfix"></div><hr> 

        <div class="col-md-12">
          <div class="row">
            <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
               <a href="#/registrar/student-behavior/add" class="btn btn-primary  btn-min"><i class="fa fa-plus"></i> ADD</a>
              <a href="javascript:void(0)" class="btn btn-success btn-sm btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a>
              <?php if (hasAccess('student behavior/index', $currentUser)): ?>
              <button type="button" class="btn btn-danger btn-sm btn-min" ng-click="print()"><i class="fa fa-print"></i> PRINT </button>
              <?php endif ?>
              <button type="button" class="btn btn-warning btn-sm btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
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
                  <th class="w30px"> No. </th>
                  <th class="text-center"> STUDENT NO. </th>
                  <th class="text-center"> STUDENT NAME </th>
                  <th class="text-center"> PROGRAM </th>
                  <th class="text-center">  </th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="data in datas">
                  <td class="text-left uppercase">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                  <td class="text-center uppercase">{{ data.student_no }}</td>
                  <td class="text-left uppercase">{{ data.student_name }}</td>
                  <td class="text-center uppercase">{{ data.program }}</td>
                  <!-- <td class="text-center uppercase">{{ data.ave }}</td> -->
                  <td>
                    <div class="btn-group btn-group-xs">
                      <?php if (hasAccess('student behavior/view', $currentUser)): ?>
                      <a href="#/registrar/student-behavior/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                      <?php endif ?>
                      <?php if (hasAccess('student behavior/edit', $currentUser)): ?>
                      <a href="#/registrar/student-behavior/edit/{{ data.id }}" class="btn btn-primary" ng-disabled = "data.status != 0" title="EDIT"><i class="fa fa-edit"></i></a> 
                      <?php endif ?>
                      <?php if (hasAccess('student behavior/delete', $currentUser)): ?>
                      <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                      <?php endif ?>
                    </div>
                  </td>
                </tr>
                <tr ng-show="datas == ''">
                  <td colspan="6" class="text-center">No available data</td>
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
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, year_term_id : year_term_id})"><sub>&laquo;&laquo;</sub></a>
              </li>
              <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page - 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, year_term_id : year_term_id })">&laquo;</a>
              </li>
              <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, year_term_id : year_term_id })">{{ page.number }}</a>
              </li>
              <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page + 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, year_term_id : year_term_id })">&raquo;</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.pageCount, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, year_term_id : year_term_id })"><sub>&raquo;&raquo;</sub> </a>
              </li>
            </ul>
            <div class="clearfix"></div>
            <div class="text-center" ng-show="paginator.pageCount > 0">
              <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
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