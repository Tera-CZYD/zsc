<?php if (hasAccess('counseling intake management/add', $currentUser)) : ?>
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">ADD NEW STUDENT EXIT </div>
          <div class="clearfix"></div><hr>

            <div class="col-md-6">
              <div class="form-group">
                <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchStudent({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> STUDENT <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.StudentExit.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.StudentExit.student_name }}</td>
                    <td style="{{ data.StudentExit.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.StudentExit.student_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.StudentExit.student_name = null; data.StudentExit.student_id = null;" ng-init="data.StudentExit.student_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> PROGRAM <i class="required">*</i></label>
                <select selectize ng-options="opt.id as opt.value for opt in college_program" ng-model="data.StudentExit.course_id" data-validation-engine="validate[required]">
                <option value=""></option></select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.StudentExit.date" data-validation-engine="validate[required]">
              </div>
            </div>

            
            <div class="col-md-3">
              <div class="form-group">
                <label> CONTACT NO. <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.StudentExit.contact_no" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> EMAIL/FACEBOOK <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.StudentExit.email" data-validation-engine="validate[required]">
              </div>
            </div>

            
          <div class="clearfix"></div><hr>

            <div class="col-md-12">
              <div class="form-group">
                <label> Answer the following questions briefly: <br> What were the best parts of your learning experience in ZSCMST? Why? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_1" placeholder="Type your answer here...."></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> What were the worst parts of your learning experience in ZSCMST? Why? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_2" placeholder="Type your answer here...."></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> Of all the subjects you took, which were your favorite and why? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_3" placeholder="Type your answer here...."></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> Of all the subjects you took, which were your least favorite and why? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_4" placeholder="Type your answer here...."></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> How do you feel about the guidance and learning you received from ZSCMST? </label>
                <div class="table-responsive px-5">
                  <table class="table">
                    <tr>
                      <th> <input type="radio" ng-model="data.StudentExit.a" class="myRadio" name="a" autocomplete="false" value="1"> </th>
                      <th> Very Good </th></br>
                      <th> <input type="radio" ng-model="data.StudentExit.a" class="myRadio" name="a" autocomplete="false" value="2"> </th>
                      <th> Good </th>
                      <th> <input type="radio" ng-model="data.StudentExit.a" class="myRadio" name="a" autocomplete="false" value="3"> </th>
                      <th> Fair </th>
                      <th> <input type="radio" ng-model="data.StudentExit.a" class="myRadio" name="a" autocomplete="false" value="4"> </th>
                      <th> Poor </th>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> What changes would you suggest that would improve the teaching in ZSCMST? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_5" placeholder="Type your answer here...."></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> What particular area of the school that needs improvement? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_6" placeholder="Type your answer here...."></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> What is your immediate plan? </label>
                <div class="table-responsive px-5">
                  <table class="table">
                    <tr>
                      <th> <input type="radio" ng-model="data.StudentExit.b" class="myRadio" name="b" autocomplete="false" value="3"> </th>
                      <th> Employment </th></br>
                      <th> <input type="radio" ng-model="data.StudentExit.b" class="myRadio" name="b" autocomplete="false" value="2"> </th>
                      <th> Continue Education </th>
                      <th> <input type="radio" ng-model="data.StudentExit.b" class="myRadio" name="b" autocomplete="false" value="1"> </th>
                      <th> Others:  </th>
                    </tr>
                  </table>
                </div>
                <div class="col-md-9 pt-5"></div>
                  <div class="col-md-3" ng-show="data.StudentExit.b == true">
                    <input type="text" class="form-control" placeholder="Please specify" autocomplete="false" ng-model="data.StudentExit.otherImmediate">
                  </div>
              </div>
            </div>

          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="pull-right">
                <button class="btn btn-primary btn-min" id="save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="modal fade" id="searched-student-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ADVANCE SEARCH</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered vcenter table-striped table-condensed">
              <thead>
                <tr>
                  <th class="w30px">#</th>
                  <th class="text-center">STUDENT NUMBER</th>
                  <th class="text-center">NAME</th>
                  <th class="w30px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="student in students">
                  <td>{{ (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
                  <td class="uppercase text-center">{{ student.code }}</td>
                  <td class="uppercase text-center">{{ student.name }}</td>
                  <td>
                    <input icheck type="radio" ng-init="student.selected = false" ng-model="student.selected" name="iCheck" ng-selected="student.selected = true" ng-change="selectedStudent(student)">
                  </td>
                </tr>
              </tbody>
              <tfoot ng-show="paginator.pageCount > 0">
                <tr>
                  <td colspan="4" class="text-center">
                    <div class="clearfix"></div>
                    <div class="row">
                      <div class="col-md-12">
                        <ul class="pagination justify-content-center">
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&laquo;&laquo;</sub></a>
                          </li>
                          <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&laquo;</a>
                          </li>
                          <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                            <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">{{ page.number }}</a>
                          </li>
                          <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&raquo;</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&raquo;&raquo;</sub> </a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="text-center" ng-show="paginator.pageCount > 0">
                          <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>  
      </div> 

      <div class="modal-footer">
        <div class="pull-right">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="studentData(employee.id)" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
        </div> 
        
      </div>
    </div>  
  </div><!-- /.modal-content -->
</div>

<style type="text/css">
  th {
    white-space: nowrap;
  }

  td {
    white-space: nowrap;
  }

  .myRadio{
    height:20px; 
    width:20px;
  }
</style>