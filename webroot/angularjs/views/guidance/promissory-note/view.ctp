<?php if (hasAccess('promissory note/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW PROMISSORY NOTE/WAIVER INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.PromissoryNote.code }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.PromissoryNote.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.PromissoryNote.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR LEVEL : </th>
                  <td class="italic">{{ data.YearLevelTerm.description }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DESCRIPTION : </th>
                  <td class="italic">{{ data.PromissoryNote.description }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('promissory note/edit', $currentUser)): ?>
                <a href="#/guidance/promissory-note/edit/{{ data.PromissoryNote.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('promissory note/print promissory note/waiver form', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.PromissoryNote.id )"><i class="fa fa-print"></i> PRINT PROMISSORY NOTE/WAIVER </button>
              <?php endif ?>
              <?php if (hasAccess('promissory note/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.PromissoryNote)"><i class="fa fa-trash"></i> DELETE </button>
              <?php endif ?>
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
