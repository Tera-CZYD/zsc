<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="dashboard_graph">

      <div class="row x_title">
        <div class="col-md-6">
          <h3>Apartelles/Dormitory</small></h3>
        </div>
      </div>

      <div class="col-md-12 col-sm-12  bg-white">
        <div class="img-list">
          <div  id="img-container">
            <div ng-repeat="data in datas">
              <img src="{{ data.imageSrc }}" style="border-radius : 2px; margin-bottom : 10px; z-index: : 1;" ng-click="showImageModal(data.imageSrc)">
            </div>
          </div>
        </div>
        
      </div>

      <div class="clearfix"></div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6 mt-3"ng-show="student_subjects != null && student_subjects != '' ">
    <div class="card">
      <div class="card-body">
        <p class="card-title" style="font-size:20px;">FAILED SUBJECTS</p>
        <span class="card-text text-danger">*This is to inform you that you have failed on the following subjects.</span>
        <div class="single-table">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr class="bg-info">
                  <th class="text-center text-light"> SUBJECT </th>
                  <th class="text-center text-light"> FACULTY NAME </th>
                  <th class="text-center text-light"> FINAL GRADE </th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="data in student_subjects">
                  <td class="text-center">{{ data.course }}</td>
                  <td class="text-center">{{ data.faculty_name }}</td>
                  <td class="text-center text-danger font-weight-bold">{{ data.final_grade }}</td>
                </tr>
                <tr ng-show="datas == null || datas == ''">
                  <td colspan="9">No available data</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 mt-3" ng-show="clearance != null && clearance != '' ">
    <div class="card">
      <div class="card-body">
        <p class="card-title" style="font-size:20px;">INCOMPLETE CLEARANCE REQUIREMENTS</p>
        <span class="card-text text-danger">*This is to inform you that you have incomplete requirements on the following Faculty.</span>
        <div class="single-table">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr class="bg-info">
                  <th class="text-center text-light"> FACULTY NAME </th>
                  <th class="text-center text-light"> SUBJECT / POSITION </th>
                  <th class="text-center text-light"> REMARKS </th>
                  <th class="text-center text-light"> STATUS </th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat=" data in clearance">
                  <td class="text-center">{{ data.faculty_name }}</td>
                  <td class="text-center">{{ data.course_code }}</td>
                  <td class="text-center">{{ data.clearance_remarks }}</td>
                  <td class="text-center text-danger font-weight-bold"> {{ data.clearance_status == 1 ? 'CLEARED' : ( data.clearance_status == 2 ? 'INC' : 'PENDING') }}  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  .img-list {
    margin-bottom: 20px;
    height: 250px;
    width: 100%;
    overflow-x: auto;
  }
  #img-container {
    height: 100%;
    position: relative;
    white-space:nowrap;
  }

  #img-container img {
    height: 100%;
    display: inline-block;
    vertical-align:top; /*to remove unwanted whitespace */
    position: relative;
  }
</style>

<div class="modal fade" id="view-image-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <img src="{{ imageSrc }}" width="100%" height="100%" style="border-radius : 2px; margin-bottom : 10px">
        </div>
      </div>
      <div class="modal-footer">
        <div class="btn-group btn-group-sm pull-right btn-min">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"> CANCEL</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="medicalInterviewModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"> Request Medical Interview </h5>
      </div>
      <div class="modal-body">
        <form id="medical_interview">  
          
          <div class="col-md-12">
            <div class="form-group">
              <label> PURPOSE <i class="required">*</i></label>
              <textarea class="form-control" autocomplete="off" ng-model="tmpData.purpose" data-validation-engine="validate[required]"></textarea>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="requestMedicalInterview(tmpData)"><i class="fa fa-save"></i> SUBMIT </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="notifModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"> For Interview Schedule </h5>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <img src="{{ base }}/assets/img/come_back_later.png" width="100%">
        </div>
        <div class="col-md-12">
          <p>You have requested a medical interview. Wait for a interview schedule to be sent by Admission Office.</p>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="notifPendingPaymentModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"> You have a pending payment in apartelle/dormitory </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <img src="{{ base }}/assets/img/come_back_later.png" width="100%">
        </div>
      </div>
      <div class="modal-footer">
        <div class="btn-group btn-group-sm pull-right btn-min">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"> CANCEL</button>
        </div>
      </div>
    </div>
  </div>
</div>