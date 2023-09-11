<?php if (hasAccess('program adviser/index', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">PROGRAM ADVISER MANAGEMENT</h4>
        <div class="clearfix"></div><hr>
        <div class="col-md-4">
          <div class="form-group">
            <label> YEAR LEVEL AND TERM </label>
            <select class="form-control" ng-model="year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change = "getData(year_term_id)">
              <option value=""></option>
            </select>
          </div>
        </div> 
        <div class="clearfix"></div><hr>
        <!-- nav tab start -->
          <div class="col-lg-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="cursor: pointer;">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" data-target ="#forEnlistment" role="tab">FOR ENLISMENT</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-target ="#enlisted" role="tab">ENLISTED</a>
              </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">

              <div class="tab-pane fade show active" id="forEnlistment">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                    
                      <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a>
                      <?php if (hasAccess('program adviser/print', $currentUser)): ?>
                        <button ng-click="printForEnlistment()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
                      <?php endif ?>
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
                        <tr class="bg-info">
                          <th class="w10px" style="width: 50px">#</th>
                          <th>STUDENT NO.</th>
                          <th>STUDENT NAME</th>
                          <th>PROGRAM</th>
                          <th>RATE</th>
                          <th>SECTIONS</th>
                          <th class="w90px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in datas">
                          <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                          <td class="text-center">{{ data.student_no }}</td>
                          <td class="text-left">{{ data.student_name }}</td>
                          <td class="text-left">{{ data.program}}</td>
                          <td class="text-left">{{ data.rate}}</td>
                          <td class="text-left">
                            <select class="form-control" ng-model="data.selected_block_section_id" ng-change="getSection($index,data.block_sections,data.selected_block_section_id)" ng-options="opt.id as opt.section for opt in data.block_sections">
                              <option value=""></option>
                            </select>
                          </td>
                          <td>
                            <?php if (hasAccess('program adviser/enlist student', $currentUser)): ?>
                            <a href="javascript:void(0)" ng-click="enlist(data)" class="btn btn-info" title="ENLIST STUDENT"><i class="fa fa-pencil"></i></a>
                            <?php endif ?>
                          </td>
                        </tr>
                        <tr ng-show="datas == null || datas == ''">
                          <td colspan="7">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt, year_term_id : year_term_id })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page - 1, search: searchTxt, year_term_id : year_term_id })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt, year_term_id : year_term_id })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page + 1, search: searchTxt, year_term_id : year_term_id })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.pageCount, search: searchTxt, year_term_id : year_term_id })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginator.pageCount > 0">
                      <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade show" id="enlisted">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a>
                      <?php if (hasAccess('program adviser/print', $currentUser)): ?>
                        <button ng-click="printEnlisted()" class="btn btn-print  btn-min" ><i class="fa fa-print"></i> PRINT</button>
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
                          <th>STUDENT NO.</th>
                          <th>STUDENT NAME</th>
                          <th>PROGRAM</th>
                          <th>RATE</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in datasEnlisted">
                          <td class="text-center">{{ (paginatorEnlisted.page - 1 ) * paginatorEnlisted.limit + $index + 1 }}</td>
                          <td class="text-center">{{ data.student_no }}</td>
                          <td class="text-left">{{ data.student_name }}</td>
                          <td class="text-left">{{ data.program}}</td>
                          <td class="text-left">{{ data.rate}}</td>
                        </tr>
                        <tr ng-show="datasEnlisted == null || datasEnlisted == ''">
                          <td colspan="5">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="enlisted({ page: 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginatorEnlisted.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="enlisted({ page: paginatorEnlisted.page - 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesEnlisted" class="page-item {{ paginatorEnlisted.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="enlisted({ page: page.number, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorEnlisted.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="enlisted({ page: paginatorEnlisted.page + 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="enlisted({ page: paginatorEnlisted.pageCount, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorEnlisted.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorEnlisted.pageCount > 0 ? paginatorEnlisted.page : 0 }} out of {{ paginatorEnlisted.pageCount }}</sup>
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
              <label> SECTION <i class="required">*</i></label>
              <select selectize ng-options="opt.id as opt.value for opt in section" ng-model="mail.section" data-validation-engine="validate[required]">
              <option value=""></option></select>
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
        <form id="form-mail">  
          <div class="col-md-12">
            <div class="form-group">
              <label> DATE </label>
              <input type="text" class="form-control datepicker" ng-model="mail.date" data-validation-engine="validate[required]">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> SECTION <i class="required">*</i></label>
              <select selectize ng-options="opt.id as opt.value for opt in section" ng-model="mail.section" data-validation-engine="validate[required]">
              <option value=""></option></select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="sendSelected(mail)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>

