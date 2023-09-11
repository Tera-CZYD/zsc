<?php if (hasAccess('block section/index', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">BLOCK SECTION</h4>
        <div class="clearfix"></div><hr>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
              <?php if (hasAccess('block section/add', $currentUser)): ?>
                <a href="#/block-section/add" class="btn btn-primary btn-sm btn-min"><i class="fa fa-plus"></i> ADD RECORD </a>
              <?php endif ?> 
              <?php if (hasAccess('block section/print', $currentUser)): ?>
                <button ng-click="print()" class="btn btn-danger  btn-min"><i class="fa fa-print"></i> PRINT</button>
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
                  <th class="w10px" style="width: 50px">NO.</th>
                  <th>CODE</th>
                  <th>COLLEGE</th>
                  <th>PROGRAM</th>
                  <th>YEAR TERM</th>
                  <th>SCHOOL YEAR</th>
                  <th>SECTION</th>
                  <th>COURSES</th>
                  <th class="w90px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="data in datas">
                  <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                  <td class="text-center">{{ data.code }}</td>
                  <td class="text-left">{{ data.college }}</td>
                  <td class="text-left">{{ data.program }}</td>
                  <td class="text-center">{{ data.year_term }}</td>
                  <td class="text-center">{{ data.school_year }}</td>
                  <td class="text-center">{{ data.section }}</td>
                  <td class="text-left"> 
                    <div ng-repeat="subs in data.course"><a href="#/block-section/view-schedule/{{ subs.id }}" class="mydata" style="color:black;">{{ subs.course }}</a></div>
                  </td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      <?php if (hasAccess('block section/view', $currentUser)): ?>
                        <a href="#/block-section/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                      <?php endif ?> 
                      <?php if (hasAccess('block section/edit', $currentUser)): ?>
                        <a href="#/block-section/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a>
                      <?php endif ?> 
                      <?php if (hasAccess('block section/delete', $currentUser)): ?>
                      <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                      <?php endif ?> 
                    </div>
                  </td> 
                </tr>
                <tr ng-show="datas == null || datas == ''">
                  <td colspan="9">No available data</td>
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
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt, year_term_id : year_term_id, college_id : college_id, program_id : program_id })"><sub>&laquo;&laquo;</sub></a>
              </li>
              <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page - 1, search: searchTxt, year_term_id : year_term_id, college_id : college_id, program_id : program_id })">&laquo;</a>
              </li>
              <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt, year_term_id : year_term_id, college_id : college_id, program_id : program_id })">{{ page.number }}</a>
              </li>
              <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page + 1, search: searchTxt, year_term_id : year_term_id, college_id : college_id, program_id : program_id })">&raquo;</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.pageCount, search: searchTxt, year_term_id : year_term_id, college_id : college_id, program_id : program_id })"><sub>&raquo;&raquo;</sub> </a>
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

<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>

<style>

  a.mydata {
     --c:linear-gradient(#000 0 0); /* update the color here */
  
    padding-bottom: .15em;
    background: var(--c), var(--c);
    background-size: .3em .1em;
    background-position:50% 100%;
    background-repeat: no-repeat;
    transition: .3s linear, background-size .3s .2s linear;    
  }
  a.mydata:hover {
    background-size: 40% .1em;
    background-position: 10% 100%, 90% 100%;    
  }
 
</style>

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
            <label>YEAR TERM</label>
            <select selectize style="height: 100px" ng-model="search.year_term_id" ng-options="opt.id as opt.value for opt in year_terms" data-validation-engine="validate[required]">
              <option value=""></option>
            </select>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label>COLLEGE</label>
            <select selectize style="height: 100px" ng-model="search.college_id" ng-options="opt.id as opt.value for opt in colleges" data-validation-engine="validate[required]">
              <option value=""></option>
            </select>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label>PROGRAM</label>
            <select selectize style="height: 100px" ng-model="search.program_id" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]">
              <option value=""></option>
            </select>
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
