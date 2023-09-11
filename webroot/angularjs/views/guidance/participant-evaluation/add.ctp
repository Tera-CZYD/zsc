<?php if (hasAccess('counseling intake management/add', $currentUser)) : ?>
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">ADD NEW PARTICIPANT EVALUATION ACTIVITY </div>

          <div class="clearfix"></div><hr>

            <div class="col-md-12">
              <div class="form-group">
                <label> ACTIVITY <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ParticipantEvaluationActivity.activity" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.ParticipantEvaluationActivity.date" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> VENUE <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.ParticipantEvaluationActivity.venue" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> PROGRAM <i class="required">*</i></label>
                <select selectize ng-options="opt.id as opt.value for opt in college_program" ng-model="data.ParticipantEvaluationActivity.course_id" data-validation-engine="validate[required]">
                <option value=""></option></select>
              </div>
            </div>

            <div class="col-md-6 pull-right">
              <div class="form-group">
                <label> YEAR <i class="required">*</i></label>
                <select selectize ng-model="data.ParticipantEvaluationActivity.year" data-validation-engine="validate[required]">
                  <option></option>
                  <option>First Year</option>
                  <option>Second Year</option>
                  <option>Third Year</option>
                  <option>Fourth Year</option>
                </select>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> Please answer the following questions: <br> Rate the activity on a scale of 1 to 5, where: 1 being the lowest and 5 being the highest.</label>
              </div>
            </div>       

          <div class="clearfix"></div><hr>

          <div class="single-table mb-5">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr class="bg-info">
                    <th class="w10px" style="width: 50px">NO.</th>
                    <th>ACTIVITY CONTENT</th>
                    <th>5</th>
                    <th>4</th> 
                    <th>3</th>
                    <th>2</th>
                    <th>1</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="radio-inline mx-2">
                    <td class="text-center">1</td>
                    <td class="text-left"> I was well imformed about the objectives of this activity. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.a" class="myRadio" name="a" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.a" class="myRadio" name="a" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.a" class="myRadio" name="a" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.a" class="myRadio" name="a" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.a" class="myRadio" name="a" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr class="radio-inline mx-2">
                    <td class="text-center">2</td>
                    <td class="text-left"> This activity lived up to my expectations. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.b" class="myRadio" name="b" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.b" class="myRadio" name="b" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.b" class="myRadio" name="b" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.b" class="myRadio" name="b" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.b" class="myRadio" name="b" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">3</td>
                    <td class="text-left"> The content is relevant to my life. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.c" class="myRadio" name="c" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.c" class="myRadio" name="c" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.c" class="myRadio" name="c" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.c" class="myRadio" name="c" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.c" class="myRadio" name="c" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">4</td>
                    <td class="text-left"> The materials provide is relevant to my life. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.d" class="myRadio" name="d" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.d" class="myRadio" name="d" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.d" class="myRadio" name="d" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.d" class="myRadio" name="d" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.d" class="myRadio" name="d" autocomplete="false" value="1"></td> 
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="single-table mb-5">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr class="bg-info">
                    <th class="w10px" style="width: 50px">NO.</th>
                    <th>ACTIVITY DESIGN</th>
                    <th>5</th>
                    <th>4</th>
                    <th>3</th>
                    <th>2</th>
                    <th>1</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">1</td>
                    <td class="text-left"> The activities conducted have stimulated my learnings. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.e" class="myRadio" name="e" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.e" class="myRadio" name="e" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.e" class="myRadio" name="e" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.e" class="myRadio" name="e" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.e" class="myRadio" name="e" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">2</td>
                    <td class="text-left"> The activities conducted gave me sufficient practice and feedback. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.f" class="myRadio" name="f" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.f" class="myRadio" name="f" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.f" class="myRadio" name="f" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.f" class="myRadio" name="f" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.f" class="myRadio" name="f" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">3</td>
                    <td class="text-left"> The activities are of practical use in my life as a student. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.g" class="myRadio" name="g" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.g" class="myRadio" name="g" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.g" class="myRadio" name="g" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.g" class="myRadio" name="g" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.g" class="myRadio" name="g" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">4</td>
                    <td class="text-left"> The difficulty level of this activity is appropriate. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.h" class="myRadio" name="h" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.h" class="myRadio" name="h" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.h" class="myRadio" name="h" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.h" class="myRadio" name="h" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.h" class="myRadio" name="h" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">5</td>
                    <td class="text-left"> The pace of this workshop is appropriate. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.i" class="myRadio" name="i" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.i" class="myRadio" name="i" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.i" class="myRadio" name="i" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.i" class="myRadio" name="i" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.i" class="myRadio" name="i" autocomplete="false" value="1"></td> 
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="single-table mb-5">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr class="bg-info">
                    <th class="w10px" style="width: 50px">NO.</th>
                    <th>ACTIVITY SPEAKER</th>
                    <th>5</th>
                    <th>4</th>
                    <th>3</th>
                    <th>2</th>
                    <th>1</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">1</td>
                    <td class="text-left"> The speaker really showed that he/she was well prepared. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.j" class="myRadio" name="j" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.j" class="myRadio" name="j" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.j" class="myRadio" name="j" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.j" class="myRadio" name="j" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.j" class="myRadio" name="j" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">2</td>
                    <td class="text-left"> The speaker showed a mastery of the topic. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.k" class="myRadio" name="k" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.k" class="myRadio" name="k" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.k" class="myRadio" name="k" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.k" class="myRadio" name="k" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.k" class="myRadio" name="k" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">3</td>
                    <td class="text-left"> The speaker was able to  establish rapport with the participants. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.l" class="myRadio" name="l" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.l" class="myRadio" name="l" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.l" class="myRadio" name="l" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.l" class="myRadio" name="l" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.l" class="myRadio" name="l" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">4</td>
                    <td class="text-left"> The speaker presented the topic in a clear and understandable manner. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.m" class="myRadio" name="m" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.m" class="myRadio" name="m" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.m" class="myRadio" name="m" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.m" class="myRadio" name="m" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.m" class="myRadio" name="m" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">5</td>
                    <td class="text-left"> The speaker made the topic interesting. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.n" class="myRadio" name="n" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.n" class="myRadio" name="n" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.n" class="myRadio" name="n" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.n" class="myRadio" name="n" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.n" class="myRadio" name="n" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">6</td>
                    <td class="text-left"> The speaker answered the questions adequately. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.o" class="myRadio" name="o" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.o" class="myRadio" name="o" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.o" class="myRadio" name="o" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.o" class="myRadio" name="o" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.o" class="myRadio" name="o" autocomplete="false" value="1"></td> 
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="single-table mb-5">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr class="bg-info">
                    <th class="w10px" style="width: 50px">NO.</th>
                    <th>THE FACILITIES</th>
                    <th>5</th>
                    <th>4</th>
                    <th>3</th>
                    <th>2</th>
                    <th>1</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">1</td>
                    <td class="text-left"> The venue was conductive to the facilitation of the activities given. </td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.p" class="myRadio" name="p" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.p" class="myRadio" name="p" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.p" class="myRadio" name="p" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.p" class="myRadio" name="p" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" ng-model="data.ParticipantEvaluationActivity.p" class="myRadio" name="p" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">2</td>
                    <td class="text-left"> The sound system was adequate. </td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.q" name="q" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.q" name="q" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.q" name="q" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.q" name="q" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.q" name="q" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">3</td>
                    <td class="text-left"> The video system was adequate. </td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.r" name="r" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.r" name="r" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.r" name="r" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.r" name="r" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.r" name="r" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">4</td>
                    <td class="text-left"> The lighting was adequate. </td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.s" name="s" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.s" name="s" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.s" name="s" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.s" name="s" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.s" name="s" autocomplete="false" value="1"></td> 
                  </tr>
                  <tr>
                    <td class="text-center">5</td>
                    <td class="text-left"> The ventilation was adequate. </td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.t" name="t" autocomplete="false" value="5"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.t" name="t" autocomplete="false" value="4"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.t" name="t" autocomplete="false" value="3"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.t" name="t" autocomplete="false" value="2"></td>
                    <td class="text-center"><input type="radio" class="myRadio" ng-model="data.ParticipantEvaluationActivity.t" name="tParticipantEvaluation" autocomplete="false" value="1"></td> 
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label> Please answer the following questions: <br> 1. What were some of the things you learned in this activity? </label>
              <textarea class="form-control" ng-model="data.ParticipantEvaluationActivity.question_1" placeholder="Type your answer here...."></textarea>
            </div>
            <div class="form-group">
              <label> 2. What recommendations can you make for the improvement of the activity? </label>
              <textarea class="form-control" ng-model="data.ParticipantEvaluationActivity.question_2" placeholder="Type your answer here...."></textarea>
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