<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW COUNSELING APPOINTMENT INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width: 20%"> CONTROL NO. : </th>
                  <td class="italic">{{ data.CounselingAppointment.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TYPE : </th>
                  <td class="uppercase italic">{{ data.CounselingType.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT NAME : </th>
                  <td class="uppercase italic">{{ data.CounselingAppointment.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.CounselingAppointment.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TIME : </th>
                  <td class="italic">{{ data.CounselingAppointment.time }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DESCRIPTION : </th>
                  <td class="italic">{{ data.CounselingAppointment.description }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              
              <!-- <a href="#/guidance/counseling-appointment/edit/{{ data.CounselingAppointment.id }}" disabled="data.CounselingAppointment.approve == 1 || data.CounselingAppointment.approve == 2 || data.CounselingAppointment.approve == 4 || data.CounselingAppointment.approve == 3" id="disable"class="btn btn-primary  btn-min" ><i class="fa fa-edit"></i> EDIT</a> -->
              <button class="btn btn-danger btn-min" ng-click="remove(data.CounselingAppointment)"  ng-disabled="data.CounselingAppointment.approve == 1 || data.CounselingAppointment.approve == 2 || data.CounselingAppointment.approve == 3 || data.CounselingAppointment.approve == 4"><i class="fa fa-trash"></i> DELETE </button>
                
            </div> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  .table-wrapper{ 
    width:100%;
    height:500px;
    overflow-y:auto;
  }
</style>