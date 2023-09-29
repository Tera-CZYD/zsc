<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;



class ReportsTable extends Table
{


    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('employees'); // Adjust the table name if needed
    }

  //CORPORATE AFFAIRS

    public function getAllMonthlyPaymentPrint($conditions){

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $sql = "

        SELECT 

          Payment.*,

          CollegeProgram.name as program

        FROM 

          payments as Payment LEFT JOIN

          college_programs as CollegeProgram ON CollegeProgram.id = Payment.program_id

        WHERE 

          Payment.visible = true $date AND 

          (

            Payment.or_no LIKE '%$search%' OR 

            Payment.student_no LIKE '%$search%' OR 

            Payment.student_name LIKE '%$search%'

          )

        ORDER BY 

          Payment.student_no DESC

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllMonthlyPayment($conditions, $limit, $page){

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $offset = ($page - 1) * $limit;

      $sql = "

        SELECT 

          Payment.*,

          CollegeProgram.name as program

        FROM 

          payments as Payment LEFT JOIN

          college_programs as CollegeProgram ON CollegeProgram.id = Payment.program_id

        WHERE 

          Payment.visible = true $date AND 

          (

            Payment.or_no LIKE '%$search%' OR 

            Payment.student_no LIKE '%$search%' OR 

            Payment.student_name LIKE '%$search%'

          )

        ORDER BY 

          Payment.student_no DESC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function countAllMonthlyPayment($conditions = []): string{

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $sql = "

        SELECT 

          count(*) as count

        FROM 

          payments as Payment LEFT JOIN

          college_programs as CollegeProgram ON CollegeProgram.id = Payment.program_id

        WHERE 

          Payment.visible = true $date AND 

          (

            Payment.or_no LIKE '%$search%' OR 

            Payment.student_no LIKE '%$search%' OR 

            Payment.student_name LIKE '%$search%'

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }

  // END CORPORATE AFFAIRS


  // learning resource

    public function getAllCheckout($conditions, $limit, $page)
    {

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $borrower_id = @$conditions['borrower_id'];

      $offset = ($page - 1) * $limit;

      $sql = "

        SELECT 

          CheckOut.*,

          LearningResourceMember.code

        FROM 

          check_outs as CheckOut LEFT JOIN

          learning_resource_members as LearningResourceMember ON CheckOut.learning_resource_member_id = LearningResourceMember.id

        WHERE 

          CheckOut.visible = true $date AND 

          (

            CheckOut.library_id_number LIKE '%$search%' OR 

            CheckOut.member_name LIKE '%$search%' OR 

            CheckOut.email LIKE '%$search%'      

          )

        ORDER BY 

          CheckOut.id DESC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function getAllCheckoutPrint($conditions)
    {

       $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $borrower_id = @$conditions['borrower_id'];

      $sql = "

        SELECT 

          CheckOut.*,

          LearningResourceMember.code

        FROM 

          check_outs as CheckOut LEFT JOIN

          learning_resource_members as LearningResourceMember ON CheckOut.learning_resource_member_id = LearningResourceMember.id

        WHERE 

          CheckOut.visible = true $date AND 

          (

            CheckOut.library_id_number LIKE '%$search%' OR 

            CheckOut.member_name LIKE '%$search%' OR 

            CheckOut.email LIKE '%$search%'      

          )

        ORDER BY 

          CheckOut.id DESC

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
    }

    public function countAllCheckout($conditions = []): string
    {

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $borrower_id = @$conditions['borrower_id'];

      $sql = "

        SELECT 

          count(*) as count

        FROM 

          check_outs as CheckOut 

        WHERE 

          CheckOut.visible = true $date AND 

          (

            CheckOut.library_id_number LIKE '%$search%' OR 

            CheckOut.member_name LIKE '%$search%' OR 

            CheckOut.email LIKE '%$search%'      

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }


    public function getAllCheckin($conditions, $limit, $page)
    {

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $borrower_id = @$conditions['borrower_id'];

      $offset = ($page - 1) * $limit;

      $sql = "

        SELECT 

          CheckIn.*,

          LearningResourceMember.code

        FROM 

          check_ins as CheckIn LEFT JOIN

          learning_resource_members as LearningResourceMember ON CheckIn.learning_resource_member_id = LearningResourceMember.id

        WHERE 

          CheckIn.visible = true $date AND 

          (

            CheckIn.library_id_number LIKE '%$search%' OR 

            CheckIn.member_name LIKE '%$search%' OR 

            CheckIn.email LIKE '%$search%'      

          )

        ORDER BY 

          CheckIn.id DESC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function getAllCheckinPrint($conditions)
    {

       $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $borrower_id = @$conditions['borrower_id'];

      $sql = "

        SELECT 

          CheckIn.*,

          LearningResourceMember.code

        FROM 

          check_ins as CheckIn LEFT JOIN

          learning_resource_members as LearningResourceMember ON CheckIn.learning_resource_member_id = LearningResourceMember.id

        WHERE 

          CheckIn.visible = true $date AND 

          (

            CheckIn.library_id_number LIKE '%$search%' OR 

            CheckIn.member_name LIKE '%$search%' OR 

            CheckIn.email LIKE '%$search%'      

          )

        ORDER BY 

          CheckIn.id DESC

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
    }

    public function countAllCheckin($conditions = []): string
    {

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $borrower_id = @$conditions['borrower_id'];

      $sql = "

        SELECT 

          count(*) as count

        FROM 

          check_ins as CheckIn LEFT JOIN

          learning_resource_members as LearningResourceMember ON CheckIn.learning_resource_member_id = LearningResourceMember.id

        WHERE 

          CheckIn.visible = true $date AND 

          (

            CheckIn.library_id_number LIKE '%$search%' OR 

            CheckIn.member_name LIKE '%$search%' OR 

            CheckIn.email LIKE '%$search%'      

          )

        ORDER BY 

          CheckIn.id DESC

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }


    // Registrar

      public function getAllSubjectMasterListPrint($conditions){

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $college_id = @$conditions['college_id'];

        $college_program_id = @$conditions['college_program_id'];

        $sql =  "

          SELECT 

            CollegeProgramCourse.*

          FROM 

            college_program_courses as CollegeProgramCourse LEFT JOIN

            college_programs as CollegeProgram ON CollegeProgram.id = CollegeProgramCourse.college_program_id LEFT JOIN

            courses as Course ON Course.id = CollegeProgramCourse.course_id


          WHERE 

            CollegeProgramCourse.visible = true $college_program_id AND

            CollegeProgramCourse.visible = true AND 

            ( 

              CollegeProgramCourse.course LIKE '%$search%'

            )

          ORDER BY 

            CollegeProgramCourse.id ASC

        ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
        
      }

      public function getAllSubjectMasterList($conditions, $limit, $page){

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $college_id = @$conditions['college_id'];

        $college_program_id = @$conditions['college_program_id'];

        $offset = ($page - 1) * $limit;

        $sql =  "

          SELECT 

            CollegeProgramCourse.*

          FROM 

            college_program_courses as CollegeProgramCourse LEFT JOIN

            college_programs as CollegeProgram ON CollegeProgram.id = CollegeProgramCourse.college_program_id LEFT JOIN

            courses as Course ON Course.id = CollegeProgramCourse.course_id


          WHERE 

            CollegeProgramCourse.visible = true $college_program_id AND

            CollegeProgramCourse.visible = true AND 

            ( 

              CollegeProgramCourse.course LIKE '%$search%'

            )

          ORDER BY 

            CollegeProgramCourse.id ASC

          LIMIT

            $limit OFFSET $offset

        ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
        
      }

      public function countAllSubjectMasterList($conditions = []): string{

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $college_id = @$conditions['college_id'];

        $college_program_id = @$conditions['college_program_id'];
        
        $sql = "

          SELECT

            count(*) as count

          FROM 

            college_program_courses as CollegeProgramCourse LEFT JOIN

            college_programs as CollegeProgram ON CollegeProgram.id = CollegeProgramCourse.college_program_id LEFT JOIN

            courses as Course ON Course.id = CollegeProgramCourse.course_id

          WHERE 

            CollegeProgramCourse.visible = true $date $college_program_id AND

            CollegeProgramCourse.visible = true AND 

            ( 

              CollegeProgramCourse.course LIKE '%$search%'

            )

        ";

        $query = $this->getConnection()->execute($sql)->fetch('assoc');

        return $query['count'];

      }

      public function getAllStudentRankingPrint($conditions) {

        $search = @$conditions['search'];
        $year_term_id = @$conditions['year_term_id'];
        $year = @$conditions['year'];
        $program_id = @$conditions['program_id'];
        $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

        $sql =  " SELECT *  FROM (

            SELECT

            Student.*,

            CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,
            ROUND(AVG(StudentEnrolledCourse.final_grade),2) as ave,

            College.name as college,

            CollegeProgram.name as program

          FROM

            students as Student  LEFT JOIN

            student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN

            colleges as College ON College.id = Student.college_id LEFT JOIN 

            college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

   
          WHERE

            Student.visible = true  $year_term_id $program_id AND
            StudentEnrolledCourse.student_id = Student.id  $year AND

            (

              Student.last_name LIKE '%$search%' OR 

              Student.first_name LIKE '%$search%' OR 

              Student.middle_name LIKE '%$search%' OR 

              Student.student_no LIKE '%$search%' OR  

              College.name LIKE '%$search%' OR 

              CollegeProgram.name LIKE '%$search%'

            )

          GROUP BY

            Student.id

          ORDER BY

            ave ASC

          ) as Report ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function getAllStudentRanking($conditions, $limit, $page) {

        $search = @$conditions['search'];
        $year_term_id = @$conditions['year_term_id'];
        $year = @$conditions['year'];
        $program_id = @$conditions['program_id'];
        $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

        $offset = ($page - 1) * $limit;

        $sql =  " SELECT *  FROM (

            SELECT

            Student.*,

            CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,
            ROUND(AVG(StudentEnrolledCourse.final_grade),2) as ave,

            College.name as college,

            CollegeProgram.name as program

          FROM

            students as Student  LEFT JOIN

            student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN

            colleges as College ON College.id = Student.college_id LEFT JOIN 

            college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

   
          WHERE

            Student.visible = true  $year_term_id $program_id AND
            StudentEnrolledCourse.student_id = Student.id  $year AND

            (

              Student.last_name LIKE '%$search%' OR 

              Student.first_name LIKE '%$search%' OR 

              Student.middle_name LIKE '%$search%' OR 

              Student.student_no LIKE '%$search%' OR  

              College.name LIKE '%$search%' OR 

              CollegeProgram.name LIKE '%$search%'

            )

          GROUP BY

            Student.id

          ORDER BY

            ave ASC

            LIMIT 

            $limit OFFSET $offset

          ) as Report ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function countAllStudentRanking($conditions = array()) {

        $search = @$conditions['search'];

        $year_term_id = @$conditions['year_term_id'];
        $program_id = @$conditions['program_id'];
        $year = @$conditions['year'];

        $sql =  "SELECT count(*) as count FROM(

            SELECT

            Student.id

          FROM

            students as Student  LEFT JOIN
            student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN
            colleges as College ON College.id = Student.college_id LEFT JOIN 


            college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id 

          WHERE

            Student.visible = true $year_term_id $program_id $year AND


            (

              Student.last_name LIKE '%$search%' OR 

              Student.first_name LIKE '%$search%' OR 

              Student.middle_name LIKE '%$search%' OR 

              Student.student_no LIKE '%$search%' OR  

              College.name LIKE '%$search%' OR 

              CollegeProgram.name LIKE '%$search%'

            )

        ) as Report ";

          $query = $this->getConnection()->execute($sql)->fetch('assoc');

          return $query['count'];

      }

      public function getAllListAcademicAwardee($conditions, $limit, $page) {

        $search = @$conditions['search'];

        $date = @$conditions['date'];

        $college_id = @$conditions['college_id'];

        $year_term_id = @$conditions['year_term_id'];

        $year = @$conditions['year'];

        $program_id = @$conditions['program_id'];

        $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

        $award = @$conditions['award'];

        $offset = ($page - 1) * $limit;

        $sql =  " SELECT *  FROM (

          SELECT

          Student.*,

          CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

          ROUND(AVG(StudentEnrolledCourse.final_grade),2) as ave,

          -- RANK() OVER(ORDER BY ave) as top,

          CASE
          WHEN ROUND(AVG(StudentEnrolledCourse.final_grade), 2) BETWEEN 1.00 AND 1.30 THEN '1'
          WHEN ROUND(AVG(StudentEnrolledCourse.final_grade), 2) BETWEEN 1.40 AND 1.50 THEN '2'
          ELSE ''
            END AS award,

          College.name as college,

          CollegeProgram.name as program

        FROM

          students as Student  LEFT JOIN

          student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id


        WHERE

          Student.visible = true  $year_term_id $college_id $program_id AND

          StudentEnrolledCourse.student_id = Student.id  $year $award AND

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

        GROUP BY

          Student.id

        ORDER BY

          ave ASC

          LIMIT 

          $limit OFFSET $offset

        ) as Report ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;

      }

      public function getAllListAcademicAwardeePrint($conditions) {

        $search = @$conditions['search'];

        $date = @$conditions['date'];

        $college_id = @$conditions['college_id'];

        $year_term_id = @$conditions['year_term_id'];

        $year = @$conditions['year'];

        $program_id = @$conditions['program_id'];

        $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

        $award = @$conditions['award'];

        $sql =  " SELECT *  FROM (

          SELECT

          Student.*,

          CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

          ROUND(AVG(StudentEnrolledCourse.final_grade),2) as ave,

          -- RANK() OVER(ORDER BY ave) as top,

          CASE
          WHEN ROUND(AVG(StudentEnrolledCourse.final_grade), 2) BETWEEN 1.00 AND 1.30 THEN '1'
          WHEN ROUND(AVG(StudentEnrolledCourse.final_grade), 2) BETWEEN 1.40 AND 1.50 THEN '2'
          ELSE ''
            END AS award,

          College.name as college,

          CollegeProgram.name as program

        FROM

          students as Student  LEFT JOIN

          student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id


        WHERE

          Student.visible = true  $year_term_id $college_id $program_id AND

          StudentEnrolledCourse.student_id = Student.id  $year $award AND

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

        GROUP BY

          Student.id

        ORDER BY

          ave ASC

        ) as Report ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;

      }

      public function countAllListAcademicAwardee($conditions = array()) {

        $search = @$conditions['search'];

        $date = @$conditions['date'];

        $college_id = @$conditions['college_id'];

        $year_term_id = @$conditions['year_term_id'];

        $program_id = @$conditions['program_id'];

        $year = @$conditions['year'];

        $award = @$conditions['award'];

        $sql =  "SELECT count(*) as count FROM(

            SELECT

            Student.*,

          CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

          ROUND(AVG(StudentEnrolledCourse.final_grade),2) as ave,

          -- RANK() OVER(ORDER BY ave) as top,

          CASE
          WHEN ROUND(AVG(StudentEnrolledCourse.final_grade), 2) BETWEEN 1.00 AND 1.30 THEN '1'
          WHEN ROUND(AVG(StudentEnrolledCourse.final_grade), 2) BETWEEN 1.40 AND 1.50 THEN '2'
          ELSE ''
            END AS award,

          College.name as college,

          CollegeProgram.name as program

          FROM

          students as Student  LEFT JOIN

          student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id


          WHERE

          Student.visible = true  $year_term_id $college_id $program_id AND

          StudentEnrolledCourse.student_id = Student.id  $year $award AND

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

          GROUP BY

          Student.id

          ORDER BY

          ave ASC

          ) as Report ";

          $query = $this->getConnection()->execute($sql)->fetch('assoc');

          return $query['count'];
      }


      public function getAllStudentClubList($conditions, $limit, $page){

        $search = @$conditions['search'];

        $date = @$conditions['date'];

        $club_id = @$conditions['club_id'];

        $offset = ($page - 1) * $limit;

        $sql =  " SELECT *  FROM 

          (

            SELECT 

              StudentClub.*,

              YearLevelTerm.year,

              College.name,

              Club.title,

              CollegeProgram.name AS program_name,

              IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name

            FROM 

              students as Student LEFT JOIN

             student_clubs as StudentClub ON StudentClub.student_id = Student.id LEFT JOIN 

             colleges as College ON College.id = Student.college_id LEFT JOIN 

             college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

             year_level_terms as YearLevelTerm ON Student.year_term_id = YearLevelTerm.id LEFT join

             clubs as Club ON Club.id = StudentClub.club_id

            WHERE 

             Student.visible = true $date $club_id AND

             StudentClub.visible = true AND 

             StudentClub.approve = 1 AND

             
             (
     
               Student.first_name LIKE  '%$search%' OR

               Student.middle_name LIKE  '%$search%' OR

               Student.last_name LIKE  '%$search%' OR

               Student.student_no LIKE  '%$search%' OR

               Club.title LIKE  '%$search%' 

             )

           ORDER BY 

             full_name ASC

             LIMIT 

             $limit OFFSET $offset

          ) as Report ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function getAllStudentClubListPrint($conditions){

        $search = @$conditions['search'];

        $date = @$conditions['date'];

        $club_id = @$conditions['club_id'];

        $sql =  " SELECT *  FROM 

          (

            SELECT 

              StudentClub.*,

              YearLevelTerm.year,

              College.name,

              Club.title,

              CollegeProgram.name AS program_name,

              IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name

            FROM 

              students as Student LEFT JOIN

             student_clubs as StudentClub ON StudentClub.student_id = Student.id LEFT JOIN 

             colleges as College ON College.id = Student.college_id LEFT JOIN 

             college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

             year_level_terms as YearLevelTerm ON Student.year_term_id = YearLevelTerm.id LEFT join

             clubs as Club ON Club.id = StudentClub.club_id

            WHERE 

             Student.visible = true $date $club_id AND

             StudentClub.visible = true AND 

             StudentClub.approve = 1 AND

             
             (
     
               Student.first_name LIKE  '%$search%' OR

               Student.middle_name LIKE  '%$search%' OR

               Student.last_name LIKE  '%$search%' OR

               Student.student_no LIKE  '%$search%' OR

               Club.title LIKE  '%$search%' 

             )

           ORDER BY 

             full_name ASC

          ) as Report ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function countAllStudentClubList($conditions = array()) {

        $search = @$conditions['search'];

        $date = @$conditions['date'];

        $club_id = @$conditions['club_id'];

        $sql =  "SELECT count(*) as count FROM(

            SELECT 

              StudentClub.*,

              YearLevelTerm.year,

              College.name,

              Club.title,

              CollegeProgram.name AS program_name,

              IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name

            FROM 

              students as Student LEFT JOIN

             student_clubs as StudentClub ON StudentClub.student_id = Student.id LEFT JOIN 

             colleges as College ON College.id = Student.college_id LEFT JOIN 

             college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

             year_level_terms as YearLevelTerm ON Student.year_term_id = YearLevelTerm.id LEFT join

             clubs as Club ON Club.id = StudentClub.club_id

            WHERE 

             Student.visible = true $date $club_id AND

             StudentClub.visible = true AND 

             StudentClub.approve = 1 AND

             
             (
     
               Student.first_name LIKE  '%$search%' OR

               Student.middle_name LIKE  '%$search%' OR

               Student.last_name LIKE  '%$search%' OR

               Student.student_no LIKE  '%$search%' OR

               Club.title LIKE  '%$search%' 

             )

           ORDER BY 

             full_name ASC

          ) as Report ";

          $query = $this->getConnection()->execute($sql)->fetch('assoc');

          return $query['count'];
      }
      public function getAllEnrollmentProfile($conditions, $limit, $page)
      {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $college_id = @$conditions['college_id'];

        $program_id = @$conditions['program_id'];

        $year_term_id = @$conditions['year_term_id'];

        $section_id = @$conditions['section_id'];

          $offset = ($page - 1) * $limit;

          // Your SQL query here, make sure to adjust table names and columns
          $sql =  "

          SELECT 

            Student.*,

            CONCAT(Student.first_name, ', ', IFNULL(Student.last_name,''),'', IFNULL(CONCAT(' ',Student.middle_name), '')) as full_name,

            StudentEnrolledCourse.course,StudentEnrolledCourse.section, 

            CollegeProgram.name

          FROM 

            students as Student LEFT JOIN

            student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN

            college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id 

          WHERE 

            Student.visible = true $program_id  $section_id $year_term_id $college_id   AND

            Student.active = true AND

          ( 

            Student.last_name              LIKE  '%$search%' OR

            Student.first_name             LIKE  '%$search%' OR

            Student.middle_name            LIKE  '%$search%' OR

            StudentEnrolledCourse.course   LIKE  '%search%' 
          )

          GROUP BY

            Student.id

          ORDER BY 

            full_name ASC

        LIMIT

        $limit OFFSET $offset ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function getAllEnrollmentProfilePrint($conditions)
      {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $college_id = @$conditions['college_id'];

        $program_id = @$conditions['program_id'];

        $year_term_id = @$conditions['year_term_id'];

        $section_id = @$conditions['section_id'];

          // Your SQL query here, make sure to adjust table names and columns
          $sql =  "

          SELECT 

            Student.*,

            CONCAT(Student.first_name, ', ', IFNULL(Student.last_name,''),'', IFNULL(CONCAT(' ',Student.middle_name), '')) as full_name,

            StudentEnrolledCourse.course,StudentEnrolledCourse.section, 

            CollegeProgram.name

          FROM 

            students as Student LEFT JOIN

            student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN

            college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id 

          WHERE 

            Student.visible = true $program_id  $section_id $year_term_id $college_id   AND

            Student.active = true AND

          ( 

            Student.last_name              LIKE  '%$search%' OR

            Student.first_name             LIKE  '%$search%' OR

            Student.middle_name            LIKE  '%$search%' OR

            StudentEnrolledCourse.course   LIKE  '%search%' 
          )

          GROUP BY

            Student.id

          ORDER BY 

            full_name ASC ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function countAllEnrollmentProfile($conditions = []): string
      {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $term_id = @$conditions['term_id'];

        $program_id = @$conditions['program_id'];

        $college_id = @$conditions['college_id'];

        $section_id = @$conditions['section_id'];

        $year_term_id = @$conditions['year_term_id'];

          
          $sql = "SELECT count(*) as count FROM (

              SELECT 

            Student.*,

            CONCAT(Student.first_name, ', ', IFNULL(Student.last_name,''),'', IFNULL(CONCAT(' ',Student.middle_name), '')) as full_name,

            StudentEnrolledCourse.course,

            CollegeProgram.name


          FROM 

            students as Student LEFT JOIN

            student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN

            college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

          WHERE 

            Student.visible = true $program_id  $section_id  $year_term_id  $college_id AND

            Student.active = true AND

          ( 

            Student.last_name              LIKE  '%$search%' OR

            Student.first_name             LIKE  '%$search%' OR

            Student.middle_name            LIKE  '%$search%' OR

            StudentEnrolledCourse.course   LIKE  '%search%' 

          )

          GROUP BY

            Student.id

          ORDER BY 

           full_name ASC

         ) as Report

          ";

          $query = $this->getConnection()->execute($sql)->fetch('assoc');

          return $query['count'];

      }

      public function getAllEnrollmentList($conditions, $limit, $page)
      {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $year_term_id = @$conditions['year_term_id'];

        $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

          $offset = ($page - 1) * $limit;

          // Your SQL query here, make sure to adjust table names and columns
          $sql =  "

          SELECT

            Student.*,

            CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

            StudentEnrollment.date,

            College.name as college,

            CollegeProgram.name as program

          FROM

            students as Student  LEFT JOIN

            colleges as College ON College.id = Student.college_id LEFT JOIN 

            college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN 

            (

              SELECT 

                StudentEnrollment.*

              FROM

                student_enrollments as StudentEnrollment

              WHERE 

                StudentEnrollment.visible = true $year_term_id_enrollment

            ) as StudentEnrollment ON StudentEnrollment.student_id = Student.id
   
          WHERE

            Student.visible = true $date $year_term_id AND

            StudentEnrollment.visible = true AND 

            (

              Student.last_name LIKE '%$search%' OR 

              Student.first_name LIKE '%$search%' OR 

              Student.middle_name LIKE '%$search%' OR 

              Student.student_no LIKE '%$search%' OR  

              College.name LIKE '%$search%' OR 

              CollegeProgram.name LIKE '%$search%'

            )

          GROUP BY

            Student.id

          ORDER BY

            full_name ASC
        LIMIT

        $limit OFFSET $offset ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function getAllEnrollmentListPrint($conditions)
      {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $year_term_id = @$conditions['year_term_id'];

        $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

          // Your SQL query here, make sure to adjust table names and columns
          $sql =  "

          SELECT

            Student.*,

            CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

            StudentEnrollment.date,

            College.name as college,

            CollegeProgram.name as program

          FROM

            students as Student  LEFT JOIN

            colleges as College ON College.id = Student.college_id LEFT JOIN 

            college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN 

            (

              SELECT 

                StudentEnrollment.*

              FROM

                student_enrollments as StudentEnrollment

              WHERE 

                StudentEnrollment.visible = true $year_term_id_enrollment

            ) as StudentEnrollment ON StudentEnrollment.student_id = Student.id
   
          WHERE

            Student.visible = true $date $year_term_id AND

            StudentEnrollment.visible = true AND 

            (

              Student.last_name LIKE '%$search%' OR 

              Student.first_name LIKE '%$search%' OR 

              Student.middle_name LIKE '%$search%' OR 

              Student.student_no LIKE '%$search%' OR  

              College.name LIKE '%$search%' OR 

              CollegeProgram.name LIKE '%$search%'

            )

          GROUP BY

            Student.id

          ORDER BY

            full_name ASC ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function countAllEnrollmentList($conditions = []): string
      {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $year_term_id = @$conditions['year_term_id'];

        $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

          
          $sql = "SELECT count(*) as count FROM (

          SELECT

            Student.id

          FROM

            students as Student  LEFT JOIN

            colleges as College ON College.id = Student.college_id LEFT JOIN 

            college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN 

            (

              SELECT 

                StudentEnrollment.*

              FROM

                student_enrollments as StudentEnrollment

              WHERE 

                StudentEnrollment.visible = true $year_term_id_enrollment

            ) as StudentEnrollment ON StudentEnrollment.student_id = Student.id

          WHERE

            Student.visible = true $date $year_term_id AND

            StudentEnrollment.visible = true AND 

            (

              Student.last_name LIKE '%$search%' OR 

              Student.first_name LIKE '%$search%' OR 

              Student.middle_name LIKE '%$search%' OR 

              Student.student_no LIKE '%$search%' OR  

              College.name LIKE '%$search%' OR 

              CollegeProgram.name LIKE '%$search%'

            )

        ) as Report ";

          $query = $this->getConnection()->execute($sql)->fetch('assoc');

          return $query['count'];

      }

      public function getAllFailedStudent($conditions, $limit, $page)
      {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $college_id = @$conditions['college_id'];

        $college_program_id = @$conditions['college_program_id'];

        $program_course_id = @$conditions['program_course_id'];

        $term = @$conditions['term'];

          $offset = ($page - 1) * $limit;

          // Your SQL query here, make sure to adjust table names and columns
          $sql =  "

          SELECT 

              Student.student_no,

              StudentEnrolledCourse.*,

              Course.code,

              Course.title,

              YearLevelTerm.year,

              YearLevelTerm.semester,

              IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name

            FROM 

              students as Student LEFT JOIN

             student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN 

             colleges as College ON College.id = Student.college_id LEFT JOIN 

             college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

             year_level_terms as YearLevelTerm ON StudentEnrolledCourse.year_term_id = YearLevelTerm.id LEFT join

             courses as Course ON StudentEnrolledCourse.course_id = Course.id 

            WHERE 

             Student.visible = true $date $college_id $college_program_id $program_course_id $term AND

             StudentEnrolledCourse.visible = true AND 

             
             (
     
               Student.first_name LIKE  '%$search%' OR

               Student.middle_name LIKE  '%$search%' OR

               Student.last_name LIKE  '%$search%' OR

               Student.student_no LIKE  '%$search%' 

             )

           ORDER BY 

             full_name ASC
        LIMIT

        $limit OFFSET $offset ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function getAllFailedStudentPrint($conditions)
      {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $college_id = @$conditions['college_id'];

        $college_program_id = @$conditions['college_program_id'];

        $program_course_id = @$conditions['program_course_id'];

        $term = @$conditions['term'];

          // Your SQL query here, make sure to adjust table names and columns
          $sql =  "

           SELECT 

              Student.student_no,

              StudentEnrolledCourse.*,

              Course.code,

              Course.title,

              YearLevelTerm.year,

              YearLevelTerm.semester,

              IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name

            FROM 

              students as Student LEFT JOIN

             student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN 

             colleges as College ON College.id = Student.college_id LEFT JOIN 

             college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

             year_level_terms as YearLevelTerm ON StudentEnrolledCourse.year_term_id = YearLevelTerm.id LEFT join

             courses as Course ON StudentEnrolledCourse.course_id = Course.id 

            WHERE 

             Student.visible = true $date $college_id $college_program_id $program_course_id $term AND

             StudentEnrolledCourse.visible = true AND 

             
             (
     
               Student.first_name LIKE  '%$search%' OR

               Student.middle_name LIKE  '%$search%' OR

               Student.last_name LIKE  '%$search%' OR

               Student.student_no LIKE  '%$search%' 

             )

           ORDER BY 

             full_name ASC ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function countAllFailedStudent($conditions = []): string
      {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $college_id = @$conditions['college_id'];

        $college_program_id = @$conditions['college_program_id'];

        $program_course_id = @$conditions['program_course_id'];

        $term = @$conditions['term'];

          
          $sql = "SELECT count(*) as count FROM (

           SELECT 

              Student.student_no,

              StudentEnrolledCourse.*,

              YearLevelTerm.year,

              YearLevelTerm.semester,

              IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name

            FROM 

             students as Student LEFT JOIN

             student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN 

             colleges as College ON College.id = Student.college_id LEFT JOIN 

             college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

             year_level_terms as YearLevelTerm ON StudentEnrolledCourse.year_term_id = YearLevelTerm.id 

            WHERE 

             Student.visible = true $date $college_id $college_program_id $program_course_id $term AND

             StudentEnrolledCourse.visible = true
       

           ORDER BY 

             full_name ASC

          ) as Report ";

          $query = $this->getConnection()->execute($sql)->fetch('assoc');

          return $query['count'];

      }

      public function getAllStudentBehavior($conditions, $limit, $page)
      {

        $search = strtolower(@$conditions['search']);

        $year = @$conditions['year'];

        $program_id = @$conditions['program_id'];

        $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

          $offset = ($page - 1) * $limit;

          // Your SQL query here, make sure to adjust table names and columns
          $sql =  "

          SELECT

            StudentBehavior.*,

            CollegeProgram.name as program

          FROM

            student_behaviors as StudentBehavior LEFT JOIN

            college_programs as CollegeProgram ON StudentBehavior.course_id = CollegeProgram.id 

   
          WHERE

            StudentBehavior.visible = true $program_id $year AND

            (

              StudentBehavior.student_name LIKE '%$search%' OR 


              CollegeProgram.name LIKE '%$search%'

            )
        LIMIT

        $limit OFFSET $offset ";

          $query = $this->getConnection()->prepare($sql);

          // var_dump($query);

          $query->execute();

          return $query;
      }

      public function getAllStudentBehaviorPrint($conditions)
      {

        $search = strtolower(@$conditions['search']);

        $year = @$conditions['year'];

        $program_id = @$conditions['program_id'];

        $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

          // Your SQL query here, make sure to adjust table names and columns
          $sql =  "

          SELECT

            StudentBehavior.*,

            CollegeProgram.name as program

          FROM

            student_behaviors as StudentBehavior LEFT JOIN

            college_programs as CollegeProgram ON StudentBehavior.course_id = CollegeProgram.id 

   
          WHERE

            StudentBehavior.visible = true $program_id $year AND

            (

              StudentBehavior.student_name LIKE '%$search%' OR 


              CollegeProgram.name LIKE '%$search%'

            )
           ";

          $query = $this->getConnection()->prepare($sql);

          // var_dump($query);

          $query->execute();

          return $query;
      }

      public function countAllStudentBehavior($conditions = []): string
      {

        $search = strtolower(@$conditions['search']);


        $year = @$conditions['year'];
        $program_id = @$conditions['program_id'];

        $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

          
          $sql = "SELECT count(*) as count FROM (

          
          SELECT

            StudentBehavior.*,

            CollegeProgram.name as program

          FROM

            student_behaviors as StudentBehavior LEFT JOIN

            college_programs as CollegeProgram ON StudentBehavior.course_id = CollegeProgram.id 

   
          WHERE

            StudentBehavior.visible = true $program_id $year AND

            (

              StudentBehavior.student_name LIKE '%$search%' OR 


              CollegeProgram.name LIKE '%$search%'

            )


        ) as Report ";

          $query = $this->getConnection()->execute($sql)->fetch('assoc');

          return $query['count'];

      }

      public function getAllFacultyMasterlistPrint($conditions)
      {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $term_id = @$conditions['term_id'];

        $college_id = @$conditions['college_id'];

        $department_id = @$conditions['department_id'];

        $program_id = @$conditions['program_id'];

          // Your SQL query here, make sure to adjust table names and columns
          $sql =  " 

            SELECT 

            Employee.*,

            AcademicRank.rank,

           CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name,

           CONCAT(College.code,' - ',College.name) as college

          FROM 

            employees as Employee LEFT JOIN

            colleges as College ON College.id = Employee.college_id LEFT JOIN 

            academic_ranks as AcademicRank ON Employee.academic_rank_id = AcademicRank.id


          WHERE 

            Employee.visible = true $college_id AND

            Employee.active = true AND

            College.visible = true AND

          ( 

            Employee.code     LIKE  '%$search%' OR

            Employee.family_name     LIKE  '%$search%' OR

            Employee.given_name     LIKE  '%$search%' OR

            Employee.middle_name     LIKE  '%$search%' OR

            College.code     LIKE  '%$search%' OR

            College.name     LIKE  '%$search%'

          )

        GROUP BY

          Employee.id

        ORDER BY 

          full_name ASC

         ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function getAllFacultyMasterlist($conditions, $limit, $page)
      {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $term_id = @$conditions['term_id'];

        $college_id = @$conditions['college_id'];

        $department_id = @$conditions['department_id'];

        $program_id = @$conditions['program_id'];

        $offset = ($page - 1) * $limit;

          // Your SQL query here, make sure to adjust table names and columns
          $sql =  " 

            SELECT 

            Employee.*,

            AcademicRank.rank,

           CONCAT(Employee.family_name, ', ', IFNULL(Employee.given_name,''),'', IFNULL(CONCAT(' ',Employee.middle_name), '')) as full_name,

           CONCAT(College.code,' - ',College.name) as college

          FROM 

            employees as Employee LEFT JOIN

            colleges as College ON College.id = Employee.college_id LEFT JOIN 

            academic_ranks as AcademicRank ON Employee.academic_rank_id = AcademicRank.id


          WHERE 

            Employee.visible = true $college_id AND

            Employee.active = true AND

            College.visible = true AND

          ( 

            Employee.code     LIKE  '%$search%' OR

            Employee.family_name     LIKE  '%$search%' OR

            Employee.given_name     LIKE  '%$search%' OR

            Employee.middle_name     LIKE  '%$search%' OR

            College.code     LIKE  '%$search%' OR

            College.name     LIKE  '%$search%'

          )

        GROUP BY

          Employee.id

        ORDER BY 

          full_name ASC



        LIMIT

        $limit OFFSET $offset ";

          $query = $this->getConnection()->prepare($sql);

          $query->execute();

          return $query;
      }

      public function countAllFacultyMasterlist($conditions)
      {

          $search = strtolower(@$conditions['search']);

          $date = @$conditions['date'];

          $college_id = @$conditions['college_id'];

          
          $sql = "SELECT count(*) as count FROM (
              
            SELECT 

            Employee.id

          FROM 

            employees as Employee LEFT JOIN

            colleges as College ON College.id = Employee.college_id

          WHERE 

           Employee.visible = true $college_id AND

            Employee.active = true AND

            College.visible = true AND

           ( 

            Employee.code     LIKE  '%$search%' OR

            Employee.family_name     LIKE  '%$search%' OR

            Employee.given_name     LIKE  '%$search%' OR

            Employee.middle_name     LIKE  '%$search%' OR

            College.code     LIKE  '%$search%' OR

            College.name     LIKE  '%$search%'

          )

          ) as Report

          ";

          $query = $this->getConnection()->execute($sql)->fetch('assoc');

          return $query['count'];

      }

    // end registrar


  //admission

    public function getAllListScholar($conditions, $limit, $page)
    {

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $year = @$conditions['year'];

      $program_id = @$conditions['program_id'];

      $scholarship = @$conditions['scholarship'];

      $offset = ($page - 1) * $limit;

      $sql = "SELECT 

          ScholarshipApplication.*,

          CollegeProgram.name,

          ScholarshipName.scholarship_name

        FROM

          scholarship_applications as ScholarshipApplication LEFT JOIN

          scholarship_names as ScholarshipName ON ScholarshipName.id = ScholarshipApplication.scholarship_name_id LEFT JOIN

          students as Student ON ScholarshipApplication.student_id = Student.id LEFT JOIN

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

        WHERE

          ScholarshipApplication.visible = true $date $status $year $program_id $scholarship $studentId AND

          (
   
            ScholarshipApplication.code LIKE  '%$search%' OR

            ScholarshipApplication.student_no LIKE  '%$search%' OR

            ScholarshipApplication.student_name LIKE  '%$search%' OR

            ScholarshipApplication.year_term_id LIKE  '%$search%' OR

            ScholarshipApplication.reason LIKE  '%$search%' OR 

            CollegeProgram.name LIKE  '%$search%'

          )

        ORDER BY 

        ScholarshipApplication.student_name ASC
          
      LIMIT

        $limit OFFSET $offset ";

        $query = $this->getConnection()->prepare($sql);

        // var_dump($query);

        $query->execute();

        return $query;
    }

    public function getAllListScholarPrint($conditions)
    {

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];

      $sql = "SELECT 

          ScholarshipApplication.*,

          CollegeProgram.name,

          ScholarshipName.scholarship_name

        FROM

          scholarship_applications as ScholarshipApplication LEFT JOIN

          scholarship_names as ScholarshipName ON ScholarshipName.id = ScholarshipApplication.scholarship_name_id LEFT JOIN

          students as Student ON ScholarshipApplication.student_id = Student.id LEFT JOIN

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

        WHERE

          ScholarshipApplication.visible = true $date $status $studentId AND

          (
   
            ScholarshipApplication.code LIKE  '%$search%' OR

            ScholarshipApplication.student_no LIKE  '%$search%' OR

            ScholarshipApplication.student_name LIKE  '%$search%' OR

            ScholarshipApplication.year_term_id LIKE  '%$search%' OR

            ScholarshipApplication.reason LIKE  '%$search%' OR 

            CollegeProgram.name LIKE  '%$search%'

          )

        ORDER BY 

        ScholarshipApplication.student_name ASC ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
    }

    public function countAllListScholar($conditions = []): string
    {

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $studentId = @$conditions['studentId'];
        
        $sql = "SELECT

          count(*) as count

       FROM

        scholarship_applications as ScholarshipApplication LEFT JOIN

        students as Student ON ScholarshipApplication.student_id = Student.id LEFT JOIN

        college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

      WHERE

        ScholarshipApplication.visible = true $date $status $studentId AND

        (
 
          ScholarshipApplication.code LIKE  '%$search%' OR

          ScholarshipApplication.student_no LIKE  '%$search%' OR

          ScholarshipApplication.student_name LIKE  '%$search%' OR

          ScholarshipApplication.year_term_id LIKE  '%$search%' OR

          ScholarshipApplication.reason LIKE  '%$search%' OR 

          CollegeProgram.name LIKE  '%$search%'

        ) ";

        $query = $this->getConnection()->execute($sql)->fetch('assoc');

        return $query['count'];

    }

    public function getAllListApplicant($conditions, $limit, $page)
    {

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $rate = @$conditions['rate'];

      $order = '';

      if(@$conditions['order'] == 'studentRateAsc'){

        $order = "ORDER BY CAST(StudentApplication.rate AS DECIMAL(10, 2)) ASC";

      }elseif(@$conditions['order'] == 'studentRateDesc'){

        $order = "ORDER BY CAST(StudentApplication.rate AS DECIMAL(10, 2)) DESC";

      }else{

        $order = "ORDER BY full_name ASC";

      }

      $offset = ($page - 1) * $limit;

      $sql = "

        SELECT

          StudentApplication.*,

          CollegeProgram.name,

          IFNULL(CONCAT(StudentApplication.last_name,', ',StudentApplication.first_name,' ',IFNULL(StudentApplication.middle_name,' ')),' ') AS full_name

        FROM

          student_applications as StudentApplication LEFT JOIN 

          college_programs as CollegeProgram ON StudentApplication.preferred_program_id = CollegeProgram.id

        WHERE

          StudentApplication.visible = true $date $status $rate AND

          CollegeProgram.visible = true AND

          (
   
            StudentApplication.first_name LIKE  '%$search%' OR

            StudentApplication.middle_name LIKE  '%$search%' OR

            StudentApplication.last_name LIKE  '%$search%' OR

            StudentApplication.email LIKE  '%$search%' OR

            StudentApplication.contact_no LIKE  '%$search%' OR

            StudentApplication.address LIKE  '%$search%'

          )

        $order

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllListApplicantPrint($conditions)
    {

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $rate = @$conditions['rate'];

      $order = '';

      if(@$conditions['order'] == 'studentRateAsc'){

        $order = "ORDER BY CAST(StudentApplication.rate AS DECIMAL(10, 2)) ASC";

      }elseif(@$conditions['order'] == 'studentRateDesc'){

        $order = "ORDER BY CAST(StudentApplication.rate AS DECIMAL(10, 2)) DESC";

      }else{

        $order = "ORDER BY full_name ASC";

      }

      $sql = "

        SELECT

          StudentApplication.*,

          CollegeProgram.name,

          IFNULL(CONCAT(StudentApplication.last_name,', ',StudentApplication.first_name,' ',IFNULL(StudentApplication.middle_name,' ')),' ') AS full_name

        FROM

          student_applications as StudentApplication LEFT JOIN 

          college_programs as CollegeProgram ON StudentApplication.preferred_program_id = CollegeProgram.id

        WHERE

          StudentApplication.visible = true $date $status $rate AND

          CollegeProgram.visible = true AND

          (
   
            StudentApplication.first_name LIKE  '%$search%' OR

            StudentApplication.middle_name LIKE  '%$search%' OR

            StudentApplication.last_name LIKE  '%$search%' OR

            StudentApplication.email LIKE  '%$search%' OR

            StudentApplication.contact_no LIKE  '%$search%' OR

            StudentApplication.address LIKE  '%$search%'

          )

        $order

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function countAllListApplicant($conditions = []): string
    {

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $status = @$conditions['status'];

      $rate = @$conditions['rate'];
        
        $sql = "SELECT

        count(*) as count

      FROM

        student_applications as StudentApplication LEFT JOIN 

        college_programs as CollegeProgram ON StudentApplication.preferred_program_id = CollegeProgram.id

      WHERE

        StudentApplication.visible = true $date $status $rate AND

        CollegeProgram.visible = true AND

        (
 
          StudentApplication.first_name LIKE  '%$search%' OR

          StudentApplication.middle_name LIKE  '%$search%' OR

          StudentApplication.last_name LIKE  '%$search%' OR

          StudentApplication.email LIKE  '%$search%' OR

          StudentApplication.contact_no LIKE  '%$search%' OR

          StudentApplication.address LIKE  '%$search%'

        )

      ";

        $query = $this->getConnection()->execute($sql)->fetch('assoc');

        return $query['count'];

    }

    //end admission


  //Medical Services Reports

    public function getAllMedicalMonthlyAccomplishment($conditions, $limit, $page)
    {

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

        $offset = ($page - 1) * $limit;

        // Your SQL query here, make sure to adjust table names and columns
        $sql =  " SELECT * FROM (

        SELECT

          IllnessRecommendation.ailment,

          IFNULL(StudentTreated.count,0) as studentTreated,

          IFNULL(EmployeeTreated.count,0) as employeeTreated,

          IFNULL(StudentTreated.count,0) + IFNULL(EmployeeTreated.count,0) as totalTreated,

          IFNULL(StudentRerred.count,0) as studentReferred,

          IFNULL(EmployeeRerred.count,0) as employeeReferred,

          IFNULL(StudentRerred.count,0) + IFNULL(EmployeeRerred.count,0) as totalReferred,

          IFNULL(StudentTreated.count,0) + IFNULL(EmployeeTreated.count,0) + IFNULL(StudentRerred.count,0) + IFNULL(EmployeeRerred.count,0) as remarks

        FROM 

          illness_recommendations as IllnessRecommendation LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 1 AND

              Consultation.student_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS StudentTreated ON StudentTreated.chief_complaint_id = IllnessRecommendation.id LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 1 AND

              Consultation.employee_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS EmployeeTreated ON EmployeeTreated.chief_complaint_id = IllnessRecommendation.id LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 2 AND

              Consultation.student_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS StudentRerred ON StudentRerred.chief_complaint_id = IllnessRecommendation.id LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 2 AND

              Consultation.employee_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS EmployeeRerred ON EmployeeRerred.chief_complaint_id = IllnessRecommendation.id

        WHERE

          IllnessRecommendation.visible = true AND 

          (

            IllnessRecommendation.ailment LIKE '%$search%'

          )

        GROUP BY

          IllnessRecommendation.id

        LIMIT

        $limit OFFSET $offset

      ) as Report ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
    }

    public function getAllMedicalMonthlyAccomplishmentPrint($conditions)
    {

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

        // Your SQL query here, make sure to adjust table names and columns
        $sql =  " SELECT * FROM (

        SELECT

          IllnessRecommendation.ailment,

          IFNULL(StudentTreated.count,0) as studentTreated,

          IFNULL(EmployeeTreated.count,0) as employeeTreated,

          IFNULL(StudentTreated.count,0) + IFNULL(EmployeeTreated.count,0) as totalTreated,

          IFNULL(StudentRerred.count,0) as studentReferred,

          IFNULL(EmployeeRerred.count,0) as employeeReferred,

          IFNULL(StudentRerred.count,0) + IFNULL(EmployeeRerred.count,0) as totalReferred,

          IFNULL(StudentTreated.count,0) + IFNULL(EmployeeTreated.count,0) + IFNULL(StudentRerred.count,0) + IFNULL(EmployeeRerred.count,0) as remarks

        FROM 

          illness_recommendations as IllnessRecommendation LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 1 AND

              Consultation.student_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS StudentTreated ON StudentTreated.chief_complaint_id = IllnessRecommendation.id LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 1 AND

              Consultation.employee_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS EmployeeTreated ON EmployeeTreated.chief_complaint_id = IllnessRecommendation.id LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 2 AND

              Consultation.student_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS StudentRerred ON StudentRerred.chief_complaint_id = IllnessRecommendation.id LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 2 AND

              Consultation.employee_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS EmployeeRerred ON EmployeeRerred.chief_complaint_id = IllnessRecommendation.id

        WHERE

          IllnessRecommendation.visible = true AND 

          (

            IllnessRecommendation.ailment LIKE '%$search%'

          )

        GROUP BY

          IllnessRecommendation.id

      ) as Report ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
    }

    public function countAllMedicalMonthlyAccomplishment($conditions = []): string
    {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        
        $sql = "SELECT count(*) as total FROM (

        SELECT

          IllnessRecommendation.id

        FROM 

          illness_recommendations as IllnessRecommendation LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 1 AND

              Consultation.student_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS StudentTreated ON StudentTreated.chief_complaint_id = IllnessRecommendation.id LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 1 AND

              Consultation.employee_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS EmployeeTreated ON EmployeeTreated.chief_complaint_id = IllnessRecommendation.id LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 2 AND

              Consultation.student_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS StudentRerred ON StudentRerred.chief_complaint_id = IllnessRecommendation.id LEFT JOIN

          (

            SELECT 

              ConsultationSub.chief_complaint_id,

              COUNT(*) as count

            FROM 

              consultation_subs as ConsultationSub LEFT JOIN 

              consultations as Consultation ON ConsultationSub.consultation_id = Consultation.id

            WHERE 

              Consultation.visible = true $date AND

              Consultation.status = 2 AND

              Consultation.employee_id IS NOT NULL AND 

              ConsultationSub.visible = true 

          ) AS EmployeeRerred ON EmployeeRerred.chief_complaint_id = IllnessRecommendation.id

        WHERE

          IllnessRecommendation.visible = true AND 

          (

            IllnessRecommendation.ailment LIKE '%$search%'

          )

      ) as Report ";

        $query = $this->getConnection()->execute($sql)->fetch('assoc');

        return $query['total'];

    }

    public function getAllMedicalPropertyEquipment($conditions, $limit, $page)
    {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $offset = ($page - 1) * $limit;

        // Your SQL query here, make sure to adjust table names and columns
        $sql =  " SELECT * FROM (

        SELECT

          PropertyLog.*

        FROM

          property_logs as PropertyLog

        WHERE

          PropertyLog.visible = true $date AND

          (

            PropertyLog.property_name LIKE '%$search%' OR 

            PropertyLog.type LIKE '%$search%' 

          )

        GROUP BY

          PropertyLog.id

        ORDER BY

          PropertyLog.property_name ASC

      ) as Report ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
    }

    public function getAllMedicalPropertyEquipmentPrint($conditions)
    {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        // Your SQL query here, make sure to adjust table names and columns
        $sql =  "

        SELECT

          PropertyLog.*

        FROM

          property_logs as PropertyLog

        WHERE

          PropertyLog.visible = true $date AND

          (

            PropertyLog.property_name LIKE '%$search%' OR 

            PropertyLog.type LIKE '%$search%' 

          )

        GROUP BY

          PropertyLog.id

        ORDER BY

          PropertyLog.property_name ASC

       ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
    }

    public function countAllMedicalPropertyEquipment($conditions = []): string
    {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];
        
        $sql = "SELECT count(*) as count FROM (

        SELECT

          PropertyLog.id

        FROM

          property_logs as PropertyLog

        WHERE

          PropertyLog.visible = true $date AND

          (

            PropertyLog.property_name LIKE '%$search%' OR 

            PropertyLog.type LIKE '%$search%' 

        )

      ) as Report ";

        $query = $this->getConnection()->execute($sql)->fetch('assoc');

        return $query['count'];

    }

    public function getAllMedicalMonthlyConsumption($conditions, $limit, $page)
    {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        $offset = ($page - 1) * $limit;

        // Your SQL query here, make sure to adjust table names and columns
        $sql =  "

        SELECT

          PropertyLog.*

        FROM 

          property_logs as PropertyLog 

        WHERE

          PropertyLog.visible = true $date AND 

          (

            PropertyLog.property_name LIKE '%$search%'

          )

        GROUP BY

          PropertyLog.id

        ORDER BY 

          PropertyLog.property_name

          LIMIT

          $limit OFFSET $offset


       ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
    }

    public function getAllMedicalMonthlyConsumptionPrint($conditions)
    {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];

        // Your SQL query here, make sure to adjust table names and columns
        $sql =  "

        SELECT

          PropertyLog.*

        FROM 

          property_logs as PropertyLog 

        WHERE

          PropertyLog.visible = true $date AND 

          (

            PropertyLog.property_name LIKE '%$search%'

          )

        GROUP BY

          PropertyLog.id

        ORDER BY 

          PropertyLog.property_name


       ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
    }

    public function countAllMedicalMonthlyConsumption($conditions = []): string
    {

        $search = strtolower(@$conditions['search']);

        $date = @$conditions['date'];
        
        $sql = " SELECT

          count(*) as count

        FROM 

          property_logs as PropertyLog 

        WHERE

          PropertyLog.visible = true $date AND 

          (

            PropertyLog.property_name LIKE '%$search%'

          )

         ";

        $query = $this->getConnection()->execute($sql)->fetch('assoc');

        return $query['count'];

    }

    public function getAllConsultationPrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $sql = "

      SELECT 

        Consultation.*

      FROM 

        consultations as Consultation

      WHERE 

        Consultation.visible = true $date AND 

        Consultation.student_id IS NOT NULL AND

        (

          Consultation.student_name LIKE '%$search%' OR 

          Consultation.date LIKE '%$search%' OR 

          Consultation.employee_name LIKE '%$search%'

        )

      ORDER BY 

        Consultation.student_no DESC

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllConsultation($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $offset = ($page - 1) * $limit;

      $sql = "

        SELECT 

          Consultation.*

        FROM 

          consultations as Consultation 

        WHERE 

          Consultation.visible = true $date AND 

          Consultation.student_id IS NOT NULL AND

          (

            Consultation.student_name LIKE '%$search%' OR 

            Consultation.date LIKE '%$search%' OR 

            Consultation.employee_name LIKE '%$search%'

          )

        ORDER BY 

          Consultation.student_no DESC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function getAllMedicalDailyTreatmentPrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $sql = "

        SELECT

          Consultation.*

        FROM

          consultations as Consultation  LEFT JOIN

          consultation_subs as ConsultationSub ON ConsultationSub.consultation_id = Consultation.id 

        WHERE

          Consultation.visible = true $date AND

          Consultation.status = 1 AND 

          ConsultationSub.visible = true AND 

          (

            Consultation.student_name LIKE '%$search%' OR 

            Consultation.employee_name LIKE '%$search%'

          )

        GROUP BY

          Consultation.id

        ORDER BY

          Consultation.id ASC

     ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllMedicalDailyTreatment($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $offset = ($page - 1) * $limit;

      $sql = "

        SELECT

          Consultation.*

        FROM

          consultations as Consultation  LEFT JOIN

          consultation_subs as ConsultationSub ON ConsultationSub.consultation_id = Consultation.id 

        WHERE

          Consultation.visible = true $date AND

          Consultation.status = 1 AND 

          ConsultationSub.visible = true AND 

          (

            Consultation.student_name LIKE '%$search%' OR 

            Consultation.employee_name LIKE '%$search%'

          )

        GROUP BY

          Consultation.id

        ORDER BY

          Consultation.id ASC

        LIMIT

          $limit OFFSET $offset

     ";

      $query = $this->getConnection()->prepare($sql);

      // var_dump($query);

      $query->execute();

      return $query;

    }

    public function countAllMedicalDailyTreatment($conditions = []): string{

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $sql = "

        SELECT

          count(*) as count

        FROM

          consultations as Consultation  LEFT JOIN

          consultation_subs as ConsultationSub ON ConsultationSub.consultation_id = Consultation.id 

        WHERE

          Consultation.visible = true $date AND

          Consultation.status = 1 AND 

          ConsultationSub.visible = true AND 

          (

            Consultation.student_name LIKE '%$search%' OR 

            Consultation.employee_name LIKE '%$search%'

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }

    public function countAllConsultation($conditions = []): string{

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $sql = "

        SELECT 

          count(*) as count

        FROM 

          consultations as Consultation 

        WHERE 

          Consultation.visible = true $date AND

          Consultation.student_id IS NOT NULL AND 

           (

            Consultation.student_name LIKE '%$search%' OR 

            Consultation.date LIKE '%$search%' OR 

            Consultation.employee_name LIKE '%$search%'

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }

    public function getAllConsultationEmployeePrint($conditions){

        $search = @$conditions['search'];

        $date = @$conditions['date'];

        $sql = "

        SELECT 

          Consultation.*

        FROM 

          consultations as Consultation 

        WHERE 

          Consultation.visible = true $date AND 

          Consultation.employee_id IS NOT NULL AND

          (

            Consultation.employee_name LIKE '%$search%'

          )

        ORDER BY 

          Consultation.employee_name ASC

        ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;

    }

    public function getAllConsultationEmployee($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $offset = ($page - 1) * $limit;

      $sql = "

        SELECT 

          Consultation.*

        FROM 

          consultations as Consultation 

        WHERE 

          Consultation.visible = true $date AND 

          Consultation.employee_id IS NOT NULL AND

          (

            Consultation.employee_name LIKE '%$search%'

          )

        ORDER BY 

          Consultation.employee_name ASC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      // var_dump($query);

      $query->execute();

      return $query;
      
    }

    public function countAllConsultationEmployee($conditions = []): string{

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $sql = "

        SELECT 

          count(*) as count

        FROM 

          consultations as Consultation 

        WHERE 

          Consultation.visible = true $date AND

          Consultation.employee_id IS NOT NULL AND 

           (

            Consultation.date LIKE '%$search%' OR 

            Consultation.employee_name LIKE '%$search%'

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }  


    public function getAllEmployeeFrequencyPrint($conditions){

        $search = @$conditions['search'];

        $date = @$conditions['date'];

        $sql = "

          SELECT 

          Employee.*,

          count(Consultation.id) as frequency,

          CONCAT(Employee.given_name, ' ', Employee.middle_name, ' ', Employee.family_name) as employee_name

        FROM 

          employees as Employee LEFT JOIN

          consultations as Consultation ON Employee.id = Consultation.employee_id

        WHERE 

          Employee.visible = true $date AND Consultation.visible = true AND Consultation.employee_id IS NOT NULL AND 

          (

            Consultation.date LIKE '%$search%' OR 

            Consultation.employee_name LIKE '%$search%'

          )

        GROUP BY

          Employee.id, Employee.code

        ORDER BY 

          frequency DESC

        ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;

    }

    public function getAllEmployeeFrequency($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $offset = ($page - 1) * $limit;

      $sql = "

        SELECT 

          Employee.*,

          count(Consultation.id) as frequency,

          CONCAT(Employee.given_name, ' ', Employee.middle_name, ' ', Employee.family_name) as employee_name

        FROM 

          employees as Employee LEFT JOIN

          consultations as Consultation ON Employee.id = Consultation.employee_id

        WHERE 

          Employee.visible = true $date AND Consultation.visible = true AND Consultation.employee_id IS NOT NULL AND 

          (

            Consultation.date LIKE '%$search%' OR 

            Consultation.employee_name LIKE '%$search%'

          )

        GROUP BY

          Employee.id, Employee.code

        ORDER BY 

          frequency DESC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      // var_dump($query);

      $query->execute();

      return $query;
      
    }

    public function getAllListStudent($conditions, $limit, $page)
    {

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $year_term_id = @$conditions['year_term_id'];

      $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

      $offset = ($page - 1) * $limit;

      $sql =  "

        SELECT

          Student.*,

          CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

          StudentEnrollment.date,

          College.name as college,

          CollegeProgram.name as program

        FROM

          students as Student  LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN 

          (

            SELECT 

              StudentEnrollment.*

            FROM

              student_enrollments as StudentEnrollment

            WHERE 

              StudentEnrollment.visible = true $year_term_id_enrollment

          ) as StudentEnrollment ON StudentEnrollment.student_id = Student.id

        WHERE

          Student.visible = true $date $year_term_id AND

          StudentEnrollment.visible = true AND 

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

        GROUP BY

          Student.id

        ORDER BY

          full_name ASC

        LIMIT

        $limit OFFSET $offset

             ";


        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
    }

    public function getAllListStudentPrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $year_term_id = @$conditions['year_term_id'];

      $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];

      $sql =  "

        SELECT

          Student.*,

          CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

          StudentEnrollment.date,

          College.name as college,

          CollegeProgram.name as program

        FROM

          students as Student  LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN 

          (

            SELECT 

              StudentEnrollment.*

            FROM

              student_enrollments as StudentEnrollment

            WHERE 

              StudentEnrollment.visible = true $year_term_id_enrollment

          ) as StudentEnrollment ON StudentEnrollment.student_id = Student.id

        WHERE

          Student.visible = true $date $year_term_id AND

          StudentEnrollment.visible = true AND 

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

        GROUP BY

          Student.id

        ORDER BY

          full_name ASC
           ";


        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
    }

    public function countAllListStudent($conditions = []): string{

        $search = @$conditions['search'];

        $date = @$conditions['date'];

        $year_term_id = @$conditions['year_term_id'];

        $year_term_id_enrollment = @$conditions['year_term_id_enrollment'];
          
        $sql = "SELECT count(*) as count FROM (

        SELECT

          Student.*,

          CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

          StudentEnrollment.date,

          College.name as college,

          CollegeProgram.name as program

        FROM

          students as Student  LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN 

          (

            SELECT 

              StudentEnrollment.*

            FROM

              student_enrollments as StudentEnrollment

            WHERE 

              StudentEnrollment.visible = true $year_term_id_enrollment

          ) as StudentEnrollment ON StudentEnrollment.student_id = Student.id

        WHERE

          Student.visible = true $date $year_term_id AND

          StudentEnrollment.visible = true AND 

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

        GROUP BY

          Student.id

        ORDER BY

          full_name ASC

      ) as Report ";

        $query = $this->getConnection()->execute($sql)->fetch('assoc');

        return $query['count'];

    }

    public function countAllEmployeeFrequency($conditions = []): string{

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $sql = "

        SELECT 

          count(*) as count

        FROM 

          employees as Employee LEFT JOIN

          consultations as Consultation ON Employee.id = Consultation.employee_id

        WHERE 

          Employee.visible = true $date AND Consultation.visible = true AND Consultation.employee_id IS NOT NULL AND  

          (

            Consultation.date LIKE '%$search%' OR 

            Consultation.employee_name LIKE '%$search%'

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    } 


  //GUIDANCE

    public function getAllRequestedFormPrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];


      $sql = "

      SELECT 

        Student.*,

        RequestForm.*

      FROM 

        students as Student LEFT JOIN

        year_level_terms as YearLevelTerm ON Student.year_term_id = YearLevelTerm.id LEFT JOIN

        request_forms as RequestForm ON Student.id = RequestForm.student_id 

      WHERE 

        RequestForm.visible = true $date AND 

        (

          RequestForm.date LIKE '%$search%' OR 

          RequestForm.code LIKE '%$search%'

        )

      ORDER BY 

        Student.student_no ASC

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;

    }

    public function getAllRequestedForm($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $offset = ($page - 1) * $limit;

      $sql = "

        SELECT 

          Student.*,

          RequestForm.*

        FROM 

          students as Student LEFT JOIN

          year_level_terms as YearLevelTerm ON Student.year_term_id = YearLevelTerm.id LEFT JOIN

          request_forms as RequestForm ON Student.id = RequestForm.student_id 

        WHERE 

          RequestForm.visible = true $date AND 

          (

            RequestForm.date LIKE '%$search%' OR 

            RequestForm.code LIKE '%$search%'

          )

        ORDER BY 

          Student.student_no ASC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function countAllRequestedForm($conditions = []): string{

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $sql = "

        SELECT 

          count(*) as count

        FROM 

          students as Student LEFT JOIN

          year_level_terms as YearLevelTerm ON Student.year_term_id = YearLevelTerm.id LEFT JOIN

          request_forms as RequestForm ON Student.id = RequestForm.student_id 

        WHERE 

          RequestForm.visible = true $date AND 

          (

            RequestForm.date LIKE '%$search%' OR 

            RequestForm.code LIKE '%$search%'

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }

    public function getAllGcoEvaluationPrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $employee = @$conditions['employee_id'];

      $program = @$conditions['program_id'];

      $college = @$conditions['college_id'];

      $year_term = @$conditions['year_term_id'];

      $sql = "

        SELECT 

          GcoEvaluation.*,

          Student.id as student_id

        FROM 

          students as Student LEFT JOIN

          gco_evaluations as GcoEvaluation ON Student.id = GcoEvaluation.student_id LEFT JOIN

          year_level_terms as YearLevelTerm ON Student.year_term_id = YearLevelTerm.id LEFT JOIN

          counseling_appointments as CounselingAppointment ON CounselingAppointment.student_id = Student.id LEFT JOIN

          attendance_counselings as AttendanceCounseling ON CounselingAppointment.id = AttendanceCounseling.counseling_appointment_id LEFT JOIN

          employees as Employee ON CounselingAppointment.counselor_id = Employee.id 




        WHERE 

          Student.visible = true $date $employee $program $college $year_term AND 

          (

            GcoEvaluation.date LIKE '%$search%' OR 

            GcoEvaluation.code LIKE '%$search%'

          )

        GROUP BY
        
          Student.id  

        ORDER BY 

          GcoEvaluation.student_no ASC

        ";

        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;

    }

    public function getAllGcoEvaluation($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $employee = @$conditions['employee_id'];

      $program = @$conditions['program_id'];

      $college = @$conditions['college_id'];

      $year_term = @$conditions['year_term_id'];

      $offset = ($page - 1) * $limit;

      $sql = "

        SELECT 

          GcoEvaluation.*,

          Student.id as student_id

        FROM 

          students as Student LEFT JOIN

          gco_evaluations as GcoEvaluation ON Student.id = GcoEvaluation.student_id LEFT JOIN

          year_level_terms as YearLevelTerm ON Student.year_term_id = YearLevelTerm.id LEFT JOIN

          counseling_appointments as CounselingAppointment ON CounselingAppointment.student_id = Student.id LEFT JOIN

          attendance_counselings as AttendanceCounseling ON CounselingAppointment.id = AttendanceCounseling.counseling_appointment_id LEFT JOIN

          employees as Employee ON CounselingAppointment.counselor_id = Employee.id 




        WHERE 

          Student.visible = true $date $employee $program $college $year_term AND 

          (

            GcoEvaluation.date LIKE '%$search%' OR 

            GcoEvaluation.code LIKE '%$search%'

          )

        GROUP BY
        
          Student.id  

        ORDER BY 

          GcoEvaluation.student_no ASC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function countAllGcoEvaluation($conditions = []): string{

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $employee = @$conditions['employee_id'];

      $program = @$conditions['program_id'];

      $college = @$conditions['college_id'];

      $year_term = @$conditions['year_term_id'];

      $sql = "

        SELECT 

          count(*) as count

        FROM 

          students as Student LEFT JOIN

          gco_evaluations as GcoEvaluation ON Student.id = GcoEvaluation.student_id LEFT JOIN

          year_level_terms as YearLevelTerm ON Student.year_term_id = YearLevelTerm.id LEFT JOIN

          counseling_appointments as CounselingAppointment ON CounselingAppointment.student_id = Student.id LEFT JOIN

          attendance_counselings as AttendanceCounseling ON CounselingAppointment.id = AttendanceCounseling.counseling_appointment_id LEFT JOIN

          employees as Employee ON CounselingAppointment.counselor_id = Employee.id 

        WHERE 

          Student.visible = true $date $employee $program $college $year_term AND 

          (

            GcoEvaluation.date LIKE '%$search%' OR 

            GcoEvaluation.code LIKE '%$search%'

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }   

  
  //REGISTRAR

    public function getAllPromotedStudentPrint($conditions){

      $search = @$conditions['search'];

      $year = @$conditions['year'];

      $program_id = @$conditions['program_id'];

      $sql =  "

        SELECT

          Student.*,

          CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

          ROUND(AVG(StudentEnrolledCourse.final_grade),2) as ave,

          -- RANK() OVER(ORDER BY ave) as top,

          College.name as college,

          CollegeProgram.name as program

        FROM

          students as Student  LEFT JOIN

          student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

 
        WHERE

          Student.visible = true $program_id AND

          StudentEnrolledCourse.student_id = Student.id  $year AND

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

        GROUP BY

          Student.id

        ORDER BY

          ave ASC

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function getAllPromotedStudent($conditions, $limit, $page){

      $search = @$conditions['search'];

      $year = @$conditions['year'];

      $program_id = @$conditions['program_id'];

      $offset = ($page - 1) * $limit;

      $sql =  "

          SELECT

         Student.*,

          CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

          ROUND(AVG(StudentEnrolledCourse.final_grade),2) as ave,

          -- RANK() OVER(ORDER BY ave) as top,

          College.name as college,

          CollegeProgram.name as program

        FROM

          students as Student  LEFT JOIN

          student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

 
        WHERE

          Student.visible = true $program_id $year AND

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

        GROUP BY

          Student.id

        ORDER BY

          ave ASC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      // var_dump($query);

      $query->execute();

      return $query;
      
    }

    public function countAllPromotedStudent($conditions = []): string{

      $search = @$conditions['search'];

      $year = @$conditions['year'];

      $program_id = @$conditions['program_id'];
      
      $sql = "

        SELECT

          count(*) as count

        FROM

          students as Student  LEFT JOIN

          student_enrolled_courses as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

 
        WHERE

          Student.visible = true $program_id $year AND

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

        GROUP BY

          Student.id


      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }

    public function getAllTranscriptOfRecordPrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $year_term_id = @$conditions['year_term_id'];

      $sql =  "

        SELECT

          Student.id,

          StudentEnrollment.*,

          IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name,

          College.name as college,

          CollegeProgram.name as program 

        FROM

          students as Student LEFT JOIN

          student_enrollments as StudentEnrollment ON StudentEnrollment.student_id = Student.id LEFT JOIN 

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

        WHERE

          Student.visible = true $date $college_id $program_id $year_term_id AND

          StudentEnrollment.visible = true AND 

          (
   
            Student.first_name LIKE  '%$search%' OR

            Student.middle_name LIKE  '%$search%' OR

            Student.last_name LIKE  '%$search%' OR

            Student.email LIKE  '%$search%' OR

            StudentEnrollment.student_no LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%' OR 

            College.name LIKE '%$search%'

          )

        ORDER BY 

          full_name ASC

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function getAllTranscriptOfRecord($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $year_term_id = @$conditions['year_term_id'];

      $offset = ($page - 1) * $limit;

      $sql =  "

        SELECT

          Student.id,

          StudentEnrollment.*,

          IFNULL(CONCAT(Student.last_name,', ',Student.first_name,' ',IFNULL(Student.middle_name,' ')),' ') AS full_name,

          College.name as college,

          CollegeProgram.name as program 

        FROM

          students as Student LEFT JOIN

          student_enrollments as StudentEnrollment ON StudentEnrollment.student_id = Student.id LEFT JOIN 

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

        WHERE

          Student.visible = true $date $college_id $program_id $year_term_id AND

          StudentEnrollment.visible = true AND 

          (
   
            Student.first_name LIKE  '%$search%' OR

            Student.middle_name LIKE  '%$search%' OR

            Student.last_name LIKE  '%$search%' OR

            Student.email LIKE  '%$search%' OR

            StudentEnrollment.student_no LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%' OR 

            College.name LIKE '%$search%'

          )

        ORDER BY 

          full_name ASC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function countAllTranscriptOfRecord($conditions = []): string{

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $year_term_id = @$conditions['year_term_id'];
      
      $sql = "

        SELECT

          count(*) as count

        FROM

          students as Student LEFT JOIN

          student_enrollments as StudentEnrollment ON StudentEnrollment.student_id = Student.id LEFT JOIN 

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id

        WHERE

          Student.visible = true $date $college_id $program_id $year_term_id AND

          StudentEnrollment.visible = true AND 

          (
   
            Student.first_name LIKE  '%$search%' OR

            Student.middle_name LIKE  '%$search%' OR

            Student.last_name LIKE  '%$search%' OR

            Student.email LIKE  '%$search%' OR

            StudentEnrollment.student_no LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%' OR 

            College.name LIKE '%$search%'

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }

    public function getAllAcademicListPrint($conditions){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $year = @$conditions['year'];

      $section_id = @$conditions['section_id'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $semester = @$conditions['semester'];

      $sql =  "

        SELECT 

            AwardeeManagement.*

          FROM 

            awardee_managements as AwardeeManagement LEFT JOIN

            sections as Section ON Section.id = AwardeeManagement.section_id 

          WHERE 

          AwardeeManagement.visible = true $date $section_id $year $college_id $program_id $semester AND

          Section.visible = true AND 

          ( 

            AwardeeManagement.student_name LIKE '%$search%' OR
            AwardeeManagement.student_no LIKE '%$search%' 
          )

        ORDER BY 

        AwardeeManagement.id ASC

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function getAllAcademicList($conditions, $limit, $page){

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $year = @$conditions['year'];

      $section_id = @$conditions['section_id'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $semester = @$conditions['semester'];

      $offset = ($page - 1) * $limit;

      $sql =  "

        SELECT 

            AwardeeManagement.*

          FROM 

            awardee_managements as AwardeeManagement LEFT JOIN

            sections as Section ON Section.id = AwardeeManagement.section_id 

          WHERE 

          AwardeeManagement.visible = true $date $section_id $year $college_id $program_id $semester AND

          Section.visible = true AND 

          ( 

            AwardeeManagement.student_name LIKE '%$search%' OR
            AwardeeManagement.student_no LIKE '%$search%' 
          )

        ORDER BY 

        AwardeeManagement.id ASC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function countAllAcademicList($conditions = []): string{

      $search = @$conditions['search'];

      $date = @$conditions['date'];

      $year = @$conditions['year'];

      $section_id = @$conditions['section_id'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $semester = @$conditions['semester'];
      
      $sql = "

        SELECT 

            count(*) as count

          FROM 

            awardee_managements as AwardeeManagement LEFT JOIN

            sections as Section ON Section.id = AwardeeManagement.section_id 

          WHERE 

          AwardeeManagement.visible = true $date $section_id $year $college_id $program_id $semester AND

          Section.visible = true AND 

          ( 

            AwardeeManagement.student_name LIKE '%$search%' OR
            
            AwardeeManagement.student_no LIKE '%$search%' 
          )

        ORDER BY 

        AwardeeManagement.id ASC ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }

    public function getAllGwaPrint($conditions){

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $section_id = @$conditions['section_id'];

      $sql =  "

        SELECT

          Student.*,

          CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

          IFNULL(StudentEnrolledCourse.ave,'') as ave,

          College.name as college,

          CollegeProgram.name as program

        FROM

          students as Student  LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

          (

            SELECT 

              StudentEnrolledCourse.student_id,

              StudentEnrolledCourse.year_term_id,

              ROUND(AVG(StudentEnrolledCourse.final_grade),2) as ave

            FROM 

              student_enrolled_courses as StudentEnrolledCourse

            WHERE 

              StudentEnrolledCourse.visible = true $section_id

          ) as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id AND StudentEnrolledCourse.year_term_id = Student.year_term_id

        WHERE

          Student.visible = true $college_id $program_id AND

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

        ORDER BY

          ave ASC

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function getAllGwa($conditions, $limit, $page){

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $section_id = @$conditions['section_id'];

      $offset = ($page - 1) * $limit;

      $sql =  "

        SELECT

          Student.*,

          CONCAT(IFNULL(Student.last_name,''),', ',IFNULL(Student.first_name,''),' ',IFNULL(Student.middle_name,'')) as full_name,

          IFNULL(StudentEnrolledCourse.ave,'') as ave,

          College.name as college,

          CollegeProgram.name as program

        FROM

          students as Student  LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

          (

            SELECT 

              StudentEnrolledCourse.student_id,

              StudentEnrolledCourse.year_term_id,

              ROUND(AVG(StudentEnrolledCourse.final_grade),2) as ave

            FROM 

              student_enrolled_courses as StudentEnrolledCourse

            WHERE 

              StudentEnrolledCourse.visible = true $section_id

          ) as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id AND StudentEnrolledCourse.year_term_id = Student.year_term_id

        WHERE

          Student.visible = true $college_id $program_id AND

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

        ORDER BY

          ave ASC

        LIMIT

          $limit OFFSET $offset

      ";

      $query = $this->getConnection()->prepare($sql);

      $query->execute();

      return $query;
      
    }

    public function countAllGwa($conditions = []): string{

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $college_id = @$conditions['college_id'];

      $program_id = @$conditions['program_id'];

      $section_id = @$conditions['section_id'];
      
      $sql = "

        SELECT

          count(*) as count

        FROM

          students as Student  LEFT JOIN

          colleges as College ON College.id = Student.college_id LEFT JOIN 

          college_programs as CollegeProgram ON CollegeProgram.id = Student.program_id LEFT JOIN

          (

            SELECT 

              StudentEnrolledCourse.student_id,

              StudentEnrolledCourse.year_term_id,

              ROUND(AVG(StudentEnrolledCourse.final_grade),2) as ave

            FROM 

              student_enrolled_courses as StudentEnrolledCourse

            WHERE 

              StudentEnrolledCourse.visible = true $section_id

          ) as StudentEnrolledCourse ON StudentEnrolledCourse.student_id = Student.id AND StudentEnrolledCourse.year_term_id = Student.year_term_id

        WHERE

          Student.visible = true $college_id $program_id AND

          (

            Student.last_name LIKE '%$search%' OR 

            Student.first_name LIKE '%$search%' OR 

            Student.middle_name LIKE '%$search%' OR 

            Student.student_no LIKE '%$search%' OR  

            College.name LIKE '%$search%' OR 

            CollegeProgram.name LIKE '%$search%'

          )

      ";

      $query = $this->getConnection()->execute($sql)->fetch('assoc');

      return $query['count'];

    }

  
    public function getAllListInventoryBibliography($conditions, $limit, $page){

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];


      $offset = ($page - 1) * $limit;

      $sql =  "

        SELECT 

          InventoryBibliography.*,

          Bibliography.title,

          Bibliography.author,

          Bibliography.code,

          Bibliography.call_number1,

          Bibliography.call_number2,

          Bibliography.call_number3,

          MaterialType.name as material_type,

          CollectionType.name as collection_type,

          Bibliography.date_of_publication

        FROM 

          inventory_bibliographies as InventoryBibliography LEFT JOIN 

          bibliographies as Bibliography ON Bibliography.id = InventoryBibliography.bibliography_id LEFT JOIN 

          material_types as MaterialType ON MaterialType.id = Bibliography.material_type_id LEFT JOIN

          collection_types as CollectionType ON CollectionType.id = Bibliography.collection_type_id

        WHERE 

          InventoryBibliography.visible = true $date AND 

          Bibliography.visible = true AND 

          (

            Bibliography.title LIKE '%$search%' OR 

            Bibliography.code LIKE '%$search%' OR

            Bibliography.author LIKE '%$search%'

          )

        LIMIT

          $limit OFFSET $offset

           ";


        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
    }

    public function getAllListInventoryBibliographyPrint($conditions){

      $search = strtolower(@$conditions['search']);

      $date = @$conditions['date'];

      $sql =  "

        SELECT 

          InventoryBibliography.*,

          Bibliography.title,

          Bibliography.author,

          Bibliography.code,

          Bibliography.call_number1,

          Bibliography.call_number2,

          Bibliography.call_number3,

          MaterialType.name as material_type,

          CollectionType.name as collection_type,

          Bibliography.date_of_publication

        FROM 

          inventory_bibliographies as InventoryBibliography LEFT JOIN 

          bibliographies as Bibliography ON Bibliography.id = InventoryBibliography.bibliography_id LEFT JOIN 

          material_types as MaterialType ON MaterialType.id = Bibliography.material_type_id LEFT JOIN

          collection_types as CollectionType ON CollectionType.id = Bibliography.collection_type_id

        WHERE 

          InventoryBibliography.visible = true $date AND 

          Bibliography.visible = true AND 

          (

            Bibliography.title LIKE '%$search%' OR 

            Bibliography.code LIKE '%$search%' OR

            Bibliography.author LIKE '%$search%'

          )

           ";


        $query = $this->getConnection()->prepare($sql);

        $query->execute();

        return $query;
    }

    public function countAllListInventoryBibliography($conditions = []): string{

        $search = @$conditions['search'];

        $date = @$conditions['date'];
          
        $sql = "SELECT count(*) as count FROM (

        SELECT 

          InventoryBibliography.*,

          Bibliography.title,

          Bibliography.author,

          Bibliography.code,

          Bibliography.call_number1,

          Bibliography.call_number2,

          Bibliography.call_number3,

          MaterialType.name as material_type,

          CollectionType.name as collection_type,

          Bibliography.date_of_publication

        FROM 

          inventory_bibliographies as InventoryBibliography LEFT JOIN 

          bibliographies as Bibliography ON Bibliography.id = InventoryBibliography.bibliography_id LEFT JOIN 

          material_types as MaterialType ON MaterialType.id = Bibliography.material_type_id LEFT JOIN

          collection_types as CollectionType ON CollectionType.id = Bibliography.collection_type_id

        WHERE 

          InventoryBibliography.visible = true $date AND 

          Bibliography.visible = true AND 

          (

            Bibliography.title LIKE '%$search%' OR 

            Bibliography.code LIKE '%$search%' OR

            Bibliography.author LIKE '%$search%'

          )

      ) as Report ";

        $query = $this->getConnection()->execute($sql)->fetch('assoc');

        return $query['count'];

    } 

  public function paginate($query, array $options = []){

    $extra = isset($options['extra']) ? $options['extra'] : [];

    $conditions = isset($extra['conditions']) ? $extra['conditions'] : [];

    $page = $options['page'];

    $limit = $options['limit'];


    if($extra['type'] == 'faculty-masterlist'){

      $result = $this->getAllFacultyMasterlist($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllFacultyMasterlist($conditions);

    }else if($extra['type'] == 'medical-monthly-accomplishment'){

      $result = $this->getAllMedicalMonthlyAccomplishment($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllMedicalMonthlyAccomplishment($conditions);

    }else if($extra['type'] == 'medical-property-equipment'){

      $result = $this->getAllMedicalPropertyEquipment($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllMedicalPropertyEquipment($conditions);

    }else if($extra['type'] == 'medical-monthly-consumption'){

      $result = $this->getAllMedicalMonthlyConsumption($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllMedicalMonthlyConsumption($conditions);

    }else if($extra['type'] == 'enrollment-profile'){

      $result = $this->getAllEnrollmentProfile($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllEnrollmentProfile($conditions);

    }else if($extra['type'] == 'enrollment-list'){

      $result = $this->getAllEnrollmentList($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllEnrollmentList($conditions);

    }else if($extra['type'] == 'academic-failures-list'){

      $result = $this->getAllFailedStudent($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllFailedStudent($conditions);

    }else if($extra['type'] == 'student-behavior'){

      $result = $this->getAllStudentBehavior($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllStudentBehavior($conditions);

    }else if($extra['type'] == 'list-scholar'){

      $result = $this->getAllListScholar($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllListScholar($conditions);

    }else if($extra['type'] == 'check-out'){

      $result = $this->getAllCheckout($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllCheckout($conditions);

    }else if($extra['type'] == 'check-in'){

      $result = $this->getAllCheckin($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllCheckin($conditions);

    } else if($extra['type'] == 'student-ranking'){

      $result = $this->getAllStudentRanking($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllStudentRanking($conditions);

    } else if($extra['type'] == 'student-club-list'){

      $result = $this->getAllStudentClubList($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllStudentClubList($conditions);

    }else if($extra['type'] == 'list-academic-awardees'){

      $result = $this->getAllListAcademicAwardee($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllListAcademicAwardee($conditions);

    }else if($extra['type'] == 'list-applicant'){

      $result = $this->getAllListApplicant($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllListApplicant($conditions);

    }else if($extra['type'] == 'monthly-payment'){

      $result = $this->getAllMonthlyPayment($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllMonthlyPayment($conditions);

    }else if($extra['type'] == 'requested-form'){

      $result = $this->getAllRequestedForm($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllRequestedForm($conditions);

    }else if($extra['type'] == 'gco-evaluation'){

      $result = $this->getAllGcoEvaluation($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllGcoEvaluation($conditions);

    }else if($extra['type'] == 'consultation'){

      $result = $this->getAllConsultation($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllConsultation($conditions);

    }else if($extra['type'] == 'consultation-employee'){

      $result = $this->getAllConsultationEmployee($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllConsultationEmployee($conditions);

    }else if($extra['type'] == 'employee-frequency'){

      $result = $this->getAllEmployeeFrequency($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllEmployeeFrequency($conditions);

    }else if($extra['type'] == 'medical-daily-treatment'){

      $result = $this->getAllMedicalDailyTreatment($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllMedicalDailyTreatment($conditions);

    }else if($extra['type'] == 'list-student'){

      $result = $this->getAllListStudent($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllListStudent($conditions);

    }else if($extra['type'] == 'promoted-student'){

      $result = $this->getAllPromotedStudent($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllPromotedStudent($conditions);

    }else if($extra['type'] == 'transcript-of-records'){

      $result = $this->getAllTranscriptOfRecord($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllTranscriptOfRecord($conditions);

    }else if($extra['type'] == 'academic-list'){

      $result = $this->getAllAcademicList($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllAcademicList($conditions);

    }else if($extra['type'] == 'gwa'){

      $result = $this->getAllGwa($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllGwa($conditions);

    }else if($extra['type'] == 'inventory-bibliographies'){

      $result = $this->getAllListInventoryBibliography($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllListInventoryBibliography($conditions);

    }else if($extra['type'] == 'subject-masterlist'){

      $result = $this->getAllSubjectMasterList($conditions, $limit, $page)->fetchAll('assoc');

      $paginateCount = $this->countAllSubjectMasterList($conditions);

    }



    $paginator = [

      'page' => $page,

      'limit' => $limit,

      'count' => $paginateCount,

      'perPage' => $limit,

      'pageCount' => ceil($paginateCount / $limit),

    ];

    return [

      'data' => $result,

      'pagination' => $paginator,

    ];

  }



}
