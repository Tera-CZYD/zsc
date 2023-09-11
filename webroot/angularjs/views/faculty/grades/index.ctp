<?php if (hasAccess('grades/index', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">GRADES MANAGEMENT</h4>
        <div class="clearfix"></div><hr>
        <div class="col-md-4">
          <div class="form-group">
            <label> SELECT COLLEGE </label>
            <select class="form-control" ng-model="college_id" ng-options="opt.id as opt.value for opt in colleges" ng-change = "getCollege(college_id)">
              <option value=""></option>
            </select>
          </div>
        </div> 
        <div class="col-md-4 col-xs-12 pull-right">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-search"></i></span>
            <input type="text" class="form-control search" ng-enter="searchy(searchTxt)" placeholder="SEARCH HERE" ng-model="searchTxt">
          </div>
          <sup style="font-color:gray">Press Enter to search</sup> 
        </div>
        <div class="clearfix"></div><hr>
        <div class="single-table mb-5">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr class="bg-info">
                  <th class="w10px" style="width: 50px">#</th>
                  <th style="width: 150px">FACULTY NO.</th>
                  <th>FAMILY NAME</th>
                  <th>GIVEN NAME</th>
                  <th>MIDDLE NAME</th>
                  <th>GENDER</th>
                  <th>ACADEMIC RANK</th>
                  <th>COLLEGE</th>
                  <th class="w90px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="data in datas">
                  <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                  <td class="text-center">{{ data.code }}</td>
                  <td class="text-left">{{ data.family_name }}</td>
                  <td class="text-left">{{ data.given_name }}</td>
                  <td class="text-left">{{ data.middle_name }}</td>
                  <td class="text-center">{{ data.gender }}</td>
                  <td class="text-left">{{ data.academic_rank }}</td>
                  <td class="text-left">{{ data.college }}</td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      <?php if (hasAccess('grades/view', $currentUser)): ?>
                      	<a href="#/faculty/grades/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
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
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt, term_id: term_id, college_id: college_id })"><sub>&laquo;&laquo;</sub></a>
              </li>
              <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page - 1, search: searchTxt, term_id: term_id, college_id: college_id })">&laquo;</a>
              </li>
              <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt, term_id: term_id, college_id: college_id })">{{ page.number }}</a>
              </li>
              <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page + 1, search: searchTxt, term_id: term_id, college_id: college_id })">&raquo;</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.pageCount, search: searchTxt, term_id: term_id, college_id: college_id })"><sub>&raquo;&raquo;</sub> </a>
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

