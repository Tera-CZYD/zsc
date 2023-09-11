<?php if (hasAccess('counseling intake management/add', $currentUser)) : ?>
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">VIEW STUDENT EXIT </div>
          <div class="clearfix"></div><hr>

            <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.StudentExit.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONTACT NO : </th>
                  <td class="italic">{{ data.StudentExit.contact_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.StudentExit.date | date: 'MM/dd/yyyy' }}</td>
                </tr>
                <tr>
                  <th class="text-right"> EMAIL/FACEBOOK : </th>
                  <td class="italic">{{ data.StudentExit.email }}</td>
                </tr>                
              </table>
            </div>
          </div>

            
          <div class="clearfix"></div><hr>

            <div class="col-md-12">
              <div class="form-group">
                <label> Answer the following questions briefly: <br> What were the best parts of your learning experience in ZSCMST? Why? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_1" placeholder="Type your answer here...." disabled=""></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> What were the worst parts of your learning experience in ZSCMST? Why? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_2" placeholder="Type your answer here...." disabled=""></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> Of all the subjects you took, which were your favorite and why? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_3" placeholder="Type your answer here...." disabled=""></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> Of all the subjects you took, which were your least favorite and why? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_4" placeholder="Type your answer here...." disabled=""></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> How do you feel about the guidance and learning you received from ZSCMST? </label>
                <div class="table-responsive px-5">
                  <table class="table">
                    <tr>
                      <th> <input type="radio" ng-model="data.StudentExit.a" class="myRadio" name="a" autocomplete="false" value="1" disabled=""> </th>
                      <th> Very Good </th></br>
                      <th> <input type="radio" ng-model="data.StudentExit.a" class="myRadio" name="a" autocomplete="false" value="2" disabled=""> </th>
                      <th> Good </th>
                      <th> <input type="radio" ng-model="data.StudentExit.a" class="myRadio" name="a" autocomplete="false" value="3" disabled=""> </th>
                      <th> Fair </th>
                      <th> <input type="radio" ng-model="data.StudentExit.a" class="myRadio" name="a" autocomplete="false" value="4" disabled=""> </th>
                      <th> Poor </th>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> What changes would you suggest that would improve the teaching in ZSCMST? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_5" placeholder="Type your answer here...." disabled=""></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> What particular area of the school that needs improvement? </label>
                <textarea class="form-control" ng-model="data.StudentExit.question_6" placeholder="Type your answer here...." disabled=""></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> What is your immediate plan? </label>
                <div class="table-responsive px-5">
                  <table class="table">
                    <tr>
                      <th> <input type="radio" ng-model="data.StudentExit.b" class="myRadio" name="b" autocomplete="false" value="3" disabled=""> </th>
                      <th> Employment </th></br>
                      <th> <input type="radio" ng-model="data.StudentExit.b" class="myRadio" name="b" autocomplete="false" value="2" disabled=""> </th>
                      <th> Continue Education </th>
                      <th> <input type="radio" ng-model="data.StudentExit.b" class="myRadio" name="b" autocomplete="false" value="1" disabled=""> </th>
                      <th> Others:  </th>
                    </tr>
                  </table>
                </div>
                <div class="col-md-9 pt-5"></div>
                  <div class="col-md-3" ng-show="data.StudentExit.b == true">
                    <input type="text" class="form-control" placeholder="Please specify" autocomplete="false" ng-model="data.StudentExit.otherImmediate" disabled="">
                  </div>
              </div>
            </div>

          <div class="clearfix"></div><hr>
            <div class="col-md-12">
              <div class="pull-right">
                <?php if (hasAccess('participant evaluation management/edit', $currentUser)): ?>
                  <a href="#/guidance/student-exit/edit/{{ data.StudentExit.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                  <?php endif ?>
                  <?php if (hasAccess('participant evaluation activity/print', $currentUser)): ?>
                  <button type="button" class="btn btn-info  btn-min" ng-click="print(data.id )"><i class="fa fa-print"></i> PRINT STUDENT EXIT FORM</button>
                  <?php endif ?>
                  <?php if (hasAccess('participant evaluation management/delete', $currentUser)): ?> 
                  <button class="btn btn-danger btn-min" ng-click="remove(data.StudentExit)"><i class="fa fa-trash"></i> DELETE </button>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif ?>
<?php echo $this->element('modals/search/searched-student-modal') ?>
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