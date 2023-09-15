<?php
	/**
	* Routes configuration.
	*
	* In this file, you set up routes to your controllers and their actions.
	* Routes are very important mechanism that allows you to freely connect
	* different URLs to chosen controllers and their actions (functions).
	*
	* It's loaded within the context of `Application::routes()` method which
	* receives a `RouteBuilder` instance `$routes` as method argument.
	*
	* CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
	* Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
	*
	* Licensed under The MIT License
	* For full copyright and license information, please see the LICENSE.txt
	* Redistributions of files must retain the above copyright notice.
	*
	* @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
	* @link          https://cakephp.org CakePHP(tm) Project
	* @license       https://opensource.org/licenses/mit-license.php MIT License
	*/

	use Cake\Routing\Route\DashedRoute;
	use Cake\Routing\RouteBuilder;
	use Cake\Routing\Router;

	return static function (RouteBuilder $routes) {

	  $routes->setRouteClass(DashedRoute::class);

	  $routes->scope('/', function (RouteBuilder $builder) {
	   
	    $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'login']);

	    $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

	    $builder->connect('/logout', ['controller' => 'Main', 'action' => 'logout']);

      $builder->connect('/admission-portal', ['controller' => 'Main', 'action' => 'admission_portal']);

      $builder->connect('/application', ['controller' => 'Main', 'action' => 'application']);

      $builder->connect('/incoming-freshmen-login', ['controller' => 'Main', 'action' => 'incoming_freshmen_login']);

      $builder->connect('/continuing-student-login', ['controller' => 'Main', 'action' => 'continuing_student_login']);

      $builder->connect('/change-program/:id', ['controller' => 'Main', 'action' => 'change_program']);

	    $builder->fallbacks();

	  });

	  $routes->prefix('api', function (RouteBuilder $routes) {
	     
      $routes->connect('/select', ['controller' => 'Select']);

      //sir raymond
      $routes->resources('Buildings');

      $routes->resources('Dashboards');

      $routes->resources('Permissions');

      $routes->resources('Roles');

      $routes->resources('LearningResourceMembers');

      $routes->resources('VisitorsAlumnis');

      $routes->resources('MaterialTypes');

      $routes->resources('CollectionTypes');

      $routes->resources('Bibliographies');

      $routes->resources('InventoryBibliographies');

      $routes->connect('/inventory_bibliographies/manual', ['controller' => 'InventoryBibliographies', 'action' => 'api_manual']);

      $routes->connect('/inventory_bibliographies/manual/:id', ['controller' => 'InventoryBibliographies', 'action' => 'api_manual']);

      $routes->connect('/inventory_bibliographies/manual_delete/:id', ['controller' => 'InventoryBibliographies', 'action' => 'api_manual_delete']);

      $routes->resources('CheckOuts');

      $routes->resources('CheckIns');

      $routes->resources('IllnessRecommendations');

      $routes->resources('PropertyLogs');

      $routes->connect('/property_logs/manual', ['controller' => 'PropertyLogs', 'action' => 'api_manual']);

      $routes->connect('/property_logs/manual/:id', ['controller' => 'PropertyLogs', 'action' => 'api_manual']);

      $routes->connect('/property_logs/manual_delete/:id', ['controller' => 'PropertyLogs', 'action' => 'api_manual_delete']);

      $routes->resources('Consultations');

      $routes->resources('StudentApplications');

      $routes->resources('StudentApplicationImages');

      $routes->resources('Transferees');

      $routes->connect('/transferees/:id', ['controller' => 'Transferees', 'action' => 'edit']);

      $routes->connect('/transferees/deleteImage/:id', ['controller' => 'Transferees', 'action' => 'delete_image']);

      $routes->resources('TransfereeImages');

      $routes->resources('Application');

      $routes->resources('ProgramAdvisers');

      $routes->resources('Grades');

      $routes->resources('ClassSchedules');

      $routes->resources('StudentLedgers');
      
      $routes->connect('/reports/medical_daily_treatments', ['controller' => 'Reports', 'action' => 'medical_daily_treatments']);

      $routes->connect('/reports/medical_property_equipment', ['controller' => 'Reports', 'action' => 'medical_property_equipment']);

      $routes->connect('/reports/subject_masterlists', ['controller' => 'Reports', 'action' => 'subject_masterlists']);

      $routes->connect('/reports/promoted_student', ['controller' => 'Reports', 'action' => 'promoted_student']);

      $routes->connect('/reports/transcript_of_records', ['controller' => 'Reports', 'action' => 'transcript_of_records']);


      //sir raff

      $routes->resources('Accounts');

      $routes->resources('OfficeReferences');

      $routes->resources('NurseProfiles');

      $routes->resources('Settings');

      $routes->resources('Apartelles');

      $routes->resources('GoodMorals');

      $routes->resources('Prescriptions');

      $routes->resources('UserLogs');

      $routes->resources('MedicalEmployeeProfiles');

      $routes->resources('ReferralRecommendations');

      $routes->resources('ItemIssuances');

      $routes->resources('MedicalCertificates');

      $routes->resources('StudentLogs');

      $routes->resources('ApartelleRegistrations');

      $routes->resources('Prospectuses');

      $routes->resources('MedicalStudentProfiles');

      $routes->resources('StudentAttendances');

      $routes->resources('ApartelleStudentClearances');

      $routes->resources('BlockSections');




      //sir leo

      $routes->resources('AddingDroppingSubjects');

      $routes->resources('ScholarshipNames', ['path' => 'scholarship_names']);

	 		$routes->resources('Schools');

	 		$routes->resources('Employees');

	 		$routes->resources('FacultyClearances');

	 		$routes->resources('StudentClearances');

	 		$routes->resources('CounselingTypes');

	 		$routes->resources('Affidavits');

	 		$routes->resources('PromissoryNotes');

	 		$routes->resources('ReferralSlips');

	 		$routes->resources('AppointmentSlips');

	 		$routes->resources('CalendarActivities');

	 		$routes->resources('CounselingIntakes');

	 		$routes->resources('ParticipantEvaluationActivities');

	 		$routes->resources('StudentExits');

	 		$routes->resources('GcoEvaluations');

	 		$routes->resources('Sections');

	    $routes->resources('Colleges');

	    $routes->resources('CollegePrograms');

	    $routes->connect('/college_programs/course', ['controller' => 'CollegePrograms', 'action' => 'course']);

	    $routes->connect('/college_programs/course_view/:id', ['controller' => 'CollegePrograms', 'action' => 'course_view']);

	    $routes->connect('/college_programs/course_update/:id', ['controller' => 'CollegePrograms', 'action' => 'course_update']);

	    $routes->connect('/college_programs/course_delete', ['controller' => 'CollegePrograms', 'action' => 'course_delete']);

	    $routes->resources('Courses'); 

      $routes->resources('Payments');

      $routes->resources('Assessments');

      $routes->connect('/reports/apartelle-monhtly-payments', ['controller' => 'Reports', 'action' => 'apartelle_monhtly_payments']);

      $routes->resources('StudentAttendanceFiles');


      //REPORTS MEDICAL SERVICES

      $routes->connect('/reports/medical_monthly_accomplishment', ['controller' => 'Reports', 'action' => 'medical_monthly_accomplishment']); 

      $routes->connect('/reports/medical_property_equipment', ['controller' => 'Reports', 'action' => 'medical_property_equipment']);

      $routes->connect('/reports/medical_monthly_consumption', ['controller' => 'Reports', 'action' => 'medical_monthly_consumption']);

      $routes->connect('/reports/consultation_report', ['controller' => 'Reports', 'action' => 'consultation_report']);

      $routes->connect('/reports/consultation_employee_report', ['controller' => 'Reports', 'action' => 'consultation_employee_report']);

      $routes->connect('/reports/employee_frequency_report', ['controller' => 'Reports', 'action' => 'employee_frequency_report']);

      //REPORTS GUIDANCE

      $routes->connect('/reports/list_requested_form', ['controller' => 'Reports', 'action' => 'list_requested_form']);

      $routes->connect('/reports/gco_evaluation_list', ['controller' => 'Reports', 'action' => 'gco_evaluation_list']);

      //REPORTS ADMISSION

      $routes->connect('/reports/list_students', ['controller' => 'Reports', 'action' => 'list_students']);


      //REPORTS LEARNING RESOURCE

      $routes->connect('/reports/list_bibliographies', ['controller' => 'Reports', 'action' => 'list_inventory_bibliographies']);



	    //czyd

      $routes->resources('Users');

      $routes->connect('/users/:id', ['controller' => 'Users', 'action' => 'edit']);

      $routes->resources('RequestForms');

     	$routes->resources('Majors');

      $routes->resources('Rooms');

      $routes->resources('UserPermissions');

      $routes->resources('Admins');

      $routes->resources('AttendanceCounselings');

      $routes->resources('CounselingAppointments');

      $routes->resources('ScholarshipApplications');

      $routes->resources('ScholarshipNames');

      $routes->resources('StudentBehaviors');

      $routes->resources('AwardManagements');

      $routes->resources('AwardeeManagements');

      $routes->resources('Completions');

      $routes->resources('Students');

      $routes->resources('Dentals');

      $routes->resources('Backups');

      $routes->resources('Specializations');

      $routes->connect('/reports/faculty_masterlists', ['controller' => 'Reports', 'action' => 'faculty_masterlists']);

      $routes->connect('/reports/enrollment_profiles', ['controller' => 'Reports', 'action' => 'enrollment_profiles']);

      $routes->connect('/reports/enrollment_list', ['controller' => 'Reports', 'action' => 'enrollment_list']);

      $routes->connect('/reports/academic_failures_list', ['controller' => 'Reports', 'action' => 'academic_failures_list']);

      $routes->connect('/reports/student_behavior', ['controller' => 'Reports', 'action' => 'student_behavior']);

      $routes->connect('/reports/list-scholar-students', ['controller' => 'Reports', 'action' => 'list_scholars']);

      $routes->connect('/reports/list_checkouts', ['controller' => 'Reports', 'action' => 'list_checkouts']);

      $routes->connect('/reports/list-applicants', ['controller' => 'Reports', 'action' => 'list_applicants']);

      $routes->resources('ChangePrograms');

      $routes->resources('StudentProfiles');

      $routes->resources('StudentGrades');

      $routes->resources('AcademicRanks');

      $routes->resources('FacultyStudentAttendances');


      // sir Gerald

      $routes->resources('Clubs');

      $routes->resources('InterviewRequests');

      $routes->resources('StudentClubs');

      $routes->resources('RegisteredStudents');

      $routes->connect('/reports/student_club_list', ['controller' => 'Reports', 'action' => 'student_club_list']);

      $routes->connect('/reports/student_ranking', ['controller' => 'Reports', 'action' => 'student_ranking']);

      $routes->connect('/reports/list_academic_awardees', ['controller' => 'Reports', 'action' => 'list_academic_awardees']);



      // Other routes
      $routes->fallbacks();

	  });

	  Router::extensions(['json', 'pdf']);

	};
