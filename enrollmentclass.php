<?php

    ini_set('mysql.connect_timeout',300);
    ini_set('default_socket_timeout',300);
    Class olenrollment
    {
        private $server = "mysql:host=localhost;dbname=enrollment_db";
        private $user = "root";
        private $pass = "";
        private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE =>
        PDO::FETCH_ASSOC);
        protected $con;
        
        public function openConnection()
        {
            try
            {
                $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
                return $this->con;
            }
            catch(PDOException $e)
            {
                echo "There is some problem in the connection :". $e->getMessage();
            }
        }

        public function check_enroll_exist($studentid, $sycode)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM enrollment WHERE studentid=?  AND sycode = ?");
            $stmt->execute([$studentid, $sycode]);
            $check_enroll = $stmt->rowCount();

            return $check_enroll;
        }

        public function check_enroll_details($sycode)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM enrollment WHERE sycode = ?");
            $stmt->execute([$sycode]);
            $checkaccesses1 = $stmt->rowCount();

            return $checkaccesses1;
        }

        public function check_access($studentid,$sycode)
        {
            $connection = $this->openConnection();
            $verify = $this->check_enroll_exist($studentid, $sycode);
            $studentid = $verify['studentid'];
            $sycode = $verify['sycode'];
            $stmt = $connection->prepare("SELECT * FROM enrollment WHERE studentid = ?  AND sycode = ? AND status = 'Access'");
            $stmt->execute([$studentid,$sycode]);
            $checkaccess = $stmt->rowCount();

            return $checkaccess;
        }

        public function login()
        {
            if(isset($_POST['login']))
            {
                $connection = $this->openConnection();
                $username = $_POST['username'];
                $password = $_POST['password'];
                $sycode = $_POST['sycode'];
            
                $stmt = $connection->prepare("SELECT * FROM departments WHERE username = ?  AND password = ?");
                $stmt->execute([$username, $password]);
                $user = $stmt->fetch(); 
                $total = $stmt->rowCount();

                $stmts = $connection->prepare("SELECT * FROM students WHERE username = ?  AND password = ?");
                $stmts->execute([$username, $password]);
                $users = $stmts->fetch(); 
                $student = $stmts->rowCount();

                $stmt = $connection->prepare("SELECT * FROM enrollment WHERE studentid = ?  AND sycode = ?");
                $stmt->execute([$username, $sycode]);
                $check = $stmt->fetch(); 
                $checks = $stmt->rowCount();

                if($total > 0) {
                    if($user['position'] == "Administrator")
                    {
                        $deptname = $user['deptname'];
                        echo "<script type='text/javascript'>alert('Welcome to Online Enrollment System $deptname')</script>";
                        echo "<script>window.location.href ='admin';</script>";
                        $this->set_userdata($user);
                    } 

                    if($user['position'] == "Registrar")
                    {
                        $deptname = $user['deptname'];
                        echo "<script type='text/javascript'>alert('Welcome to Online Enrollment System $deptname')</script>";
                        echo "<script>window.location.href ='registrar';</script>";
                        $this->set_userdata($user);
                    }
                } else if($student > 0) {
                    if($users['position'] == "Student")
                    {
                        if($this->check_enroll_exist($username,$sycode)>0)
                        {
                            if($check['status']=="Enrolled"){
                                header("Location: student/index.php");
                                $this->set_userdata($users);
                            } else {
                                header("Location: student/select-payment.php");
                                $this->set_userdata($users);
                            }
                        } else {
                            header("location:login.php?invalid=Your account is deactivate");
                        }
                    }
                }  else {
                    header("location:login.php?invalid=Your username or password are incorrect|Please Try Again");
                }
            }
        }

        

        public function set_userdata($array)
        {
            if(!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['userdata'] = array(
                "deptname" => $array['first_name']." ".$array['middle_name']." ".$array['last_name'],
                "position" => $array['position'],
                "studentname" => $array['studentname'],
                "student_id" => $array['student_id']
               
            );
            return $_SESSION['userdata'];
        }

        public function get_userdata()
        {
            if(!isset($_SESSION['userdata']) && !isset($_SESSION['position'])) {
                session_start();
            }
            
            if(isset($_SESSION['userdata']) && !isset($_SESSION['position'])) {
                return $_SESSION['userdata'];
                return $_SESSION['position'];
                
            } else {
                return null;
            }
        }

        // public function verified()
        // {
        //     if(!isset($_SESSION) || empty($_SESSION['userdata'])) {
        //         /* Set Default Invalid */
        //         $_SESSION['userdata'] = null;
        //     }
        //     if($_SESSION['access'] == 'administrator') {
        //         header("Location: admin/index.php");
        //     }
        
        // }

        public function logout()
        {
            if(!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['userdata'] = null;
            unset($_SESSION['userdata']);
        }

        // public function getUsers()
        // {
        //     $connection = $this->openConnection();
        //     $stmt = $connection->prepare("SELECT * FROM accounts");
        //     $stmt->execute();
        //     $users = $stmt->fetchAll();
        //     $userCount = $stmt->rowCount();

        //     if($userCount > 0) {
        //         return $users;
        //     } else {
        //         return 0;
        //     }
        // }

        public function getAccess()
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM tbl_access");
            $stmt->execute();
            $access = $stmt->fetchAll();
            $accessCount = $stmt->rowCount();

            if($accessCount > 0) {
                return $access;
            } else {
                return 0;
            }
        }


        
        public function addDepartment()
        {
            if(isset($_POST['save'])) {
                $dept_id = $_POST['dept_id'];
                $last_name = $_POST['last_name'];
                $first_name = $_POST['first_name'];
                $middle_name = $_POST['middle_name'];
                $deptname = $_POST['first_name']. " " .$_POST['middle_name']. " " .$_POST['last_name'];
                $dept_course = $_POST['dept_course'];
                $email = $_POST['email'];
                $under_graduate = $_POST['under_graduate'];
                $graduate = $_POST['graduate'];
                $username = $_POST['dept_id'];
                $password = $_POST['password'];
                $position = $_POST['position'];

                    $connection = $this->openConnection();
                    $stmt = $connection->prepare("INSERT INTO departments(`dept_id`,`last_name`,`first_name`,`middle_name`,`deptname`,`dept_course`,`email`,`under_graduate`,`graduate`,`username`,`password`,`position`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->execute([$dept_id, $last_name, $first_name, $middle_name,$deptname, $dept_course, $email, $under_graduate, $graduate, $username, $password,  $position]);
                    header("Location: teams.php?position=$position");           
            }
        }

        public function updateDept()
        {
            if(isset($_POST['update'])) {
                $dept_id = $_POST['dept_id'];
                $last_name = $_POST['last_name'];
                $first_name = $_POST['first_name'];
                $middle_name = $_POST['middle_name'];
                $deptname = $_POST['first_name']. " " .$_POST['middle_name']. " " .$_POST['last_name'];
                $dept_course = $_POST['dept_course'];
                $email = $_POST['email'];
                $under_graduate = $_POST['under_graduate'];
                $graduate = $_POST['graduate'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $position = $_POST['position'];
        
                $connection = $this->openConnection();
                $stmt = $connection->prepare("UPDATE departments SET last_name = ?, first_name = ?, middle_name = ?, deptname=?, dept_course = ?, email = ?, under_graduate = ?, graduate = ?, username = ?, password = ?, position = ? WHERE dept_id = ?");
                $stmt->execute([$last_name, $first_name, $middle_name, $deptname, $dept_course, $email, $under_graduate, $graduate, $username, $password, $position, $dept_id]);
        
                header("Location: teams.php?position=$position");
            }
        }

        public function deleteDept()
        {
            if(isset($_POST['Yes'])) {
                $dept_id = $_POST['dept_id'];
                $position = $_POST['position'];
                
                
                $connection = $this->openConnection();
                $stmt = $connection->prepare("DELETE FROM departments WHERE dept_id=?");
                $stmt->execute([$dept_id]);

                

                

                header("Location: teams.php?position=$position");
                
            }
        }

        public function getSchoolYear()
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM school_year");
            $stmt->execute();
            $users = $stmt->fetchAll();
            $userCount = $stmt->rowCount();

            if($userCount > 0) {
                return $users;
            } else {
                return 0;
            }
        }

        public function openSY() {
            if(isset($_POST['colOpen'])) {
                $sycode = $_POST['openAY'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("UPDATE school_year SET status = 'OPEN' WHERE sycode = ?");
                $stmt->execute([$sycode]);

                header("Location: school_year.php");
            }
        }

        // public function closeStatus2() {
        //     if(isset($_POST['colOpen'])) {
        //         $connection = $this->openConnection();
        //         $stmt = $connection->prepare("UPDATE school_year SET status = 'CLOSE'");
        //         $stmt->execute();  
        //     }
        // }

        public function closeSY() {
            if(isset($_POST['colClose'])) {
                $sycode = $_POST['closeAY'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("UPDATE school_year SET status = 'CLOSE' WHERE sycode = ?");
                $stmt->execute([$sycode]);

                header("Location: school_year.php");
            }
        }

        public function addSY() {
            if(isset($_POST['btnSave'])) {
                $sycode = $_POST["year1"]."-".$_POST["year2"]." ".$_POST["term"];
                $year1 = $_POST["year1"];
                $year2 = $_POST["year2"];
                $term = $_POST["term"];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("INSERT INTO school_year(`sycode`, `year1`, `year2`, `term`,`status`)VALUES(?,?,?,?,'OPEN')");
                $stmt->execute([$sycode,$year1,$year2,$term]);

                $connection = $this->openConnection();
                $stmt = $connection->prepare("UPDATE school_year SET status = 'CLOSE' WHERE sycode != ?");
                $stmt->execute([$sycode]);

                header("Location: school_year.php");
            }
        }

        
        public function closeStatus() {
            if(isset($_POST['colOpen'])) {
                $connection = $this->openConnection();
                $stmt = $connection->prepare("UPDATE school_year SET status = 'CLOSE'");
                $stmt->execute();  
            }
        }

        public function getOpenSY() {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM school_year where status = 'OPEN'");
            $stmt->execute();
            $sy = $stmt->fetch();
            $syCount = $stmt->rowCount();

            if($syCount > 0) {
                return $sy;
            } else {
                return $this->show_404();
            }
        }

        public function show_404()
        {
            http_response_code(404);
            echo "Page not found";
            die;
        }

        public function get_position($position) {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM departments WHERE position = ?");
            $stmt->execute([$position]);
            $user = $stmt->fetchall();
            $total = $stmt->rowCount();

            if($total > 0)
            {
                return $user;
            } else {
                return false;
            }
        }

        public function add_course() {
            if(isset($_POST['addcourse'])) {
                $coursecode=$_POST['course_code'];
                $coursedesc=$_POST['course_desc'];

                $connection = $this->openConnection();
                $stmt=$connection->prepare("INSERT INTO course(`course_code`, `course_description`)VALUES(?,?)");
                $stmt->execute([$coursecode,$coursedesc]);

                header("Location: course.php");
            }
        }

        public function updateCourse() {
            if(isset($_POST['updateCourse'])) {
                $updateCourseCode = $_POST['updateCourseCode'];
                $updateCourseDesc = $_POST['updateCourseDesc'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("UPDATE course SET course_description=? where course_code=?");
                $stmt->execute([$updateCourseDesc,$updateCourseCode]);

                header("Location: course.php");
            }
        }

        public function deleteCourse() {
            if(isset($_POST['Yes'])) {
                $delCourseCode = $_POST['delCourseCode'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("DELETE FROM course WHERE course_code=?");
                $stmt->execute([$delCourseCode]);

                header("Location: course.php");
            } elseif(isset($_POST['No'])) {
                header("Location: course.php");
            }
        }

        public function getCourse()
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM course");
            $stmt->execute();
            $courses = $stmt->fetchAll();
            $courseCount = $stmt->rowCount();

            if($courseCount > 0) {
                return $courses;
            } else {
                return 0;
            }
        }

        public function getCourseDesc($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM course where course_code=?");
            $stmt->execute([$course_code]);
            $section = $stmt->fetchAll();
            $sectionCount = $stmt->rowCount();

            if($sectionCount > 0) {
                return $section;
            } else {
                return $this->show_404();
            }
        }

        public function getSections($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections where course_code=?");
            $stmt->execute([$course_code]);
            $section = $stmt->fetchAll();
            $sectionCount = $stmt->rowCount();

            if($sectionCount > 0) {
                return $section;
            } else {
                return $this->show_404();
            }
        }

        public function addSubject()
        {
            if(isset($_POST['addsubject'])) {
                $yearlevel = $_POST['yearlevel'];
                $term = $_POST['term'];
                $yearlevelterm = $_POST["yearlevel"]."/".$_POST["term"];
                $subject_code = $_POST['subject_code'];
                $subject_title = $_POST['subject_title'];
                $units = $_POST['units'];
                $price = $_POST['price'];
                $course_code = $_POST['course_code'];
                $amount = $units * $price;

                $connection = $this->openConnection();
                $stmt=$connection->prepare("INSERT INTO subjects(`yearlevel`,`term`,`yearlevelterm`,`subject_code`,`subject_title`,`units`,`course_code`)VALUES(?,?,?,?,?,?,?)");
                $stmt->execute([$yearlevel,$term,$yearlevelterm,$subject_code,$subject_title,$units,$course_code]);

                header("Location: subjects.php?course=$course_code");
            }
        }

        public function get1stYear1stTermSubject($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM subjects WHERE yearlevel = '1st Year' and term = '1st Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $subject = $stmt->fetchall();
            $subjectCount = $stmt->rowCount();

            if($subject > 0)
            {
                return $subject;
            } else {
                return false;
            }   
        }

        public function get1stYear2ndTermSubject($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM subjects WHERE yearlevel = '1st Year' and term = '2nd Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $subject = $stmt->fetchall();
            $subjectCount = $stmt->rowCount();

            if($subject > 0)
            {
                return $subject;
            } else {
                return false;
            }   
        }

        public function get2ndYear1stTermSubject($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM subjects WHERE yearlevel = '2nd Year' and term = '1st Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $subject = $stmt->fetchall();
            $subjectCount = $stmt->rowCount();

            if($subject > 0)
            {
                return $subject;
            } else {
                return false;
            }   
        }

        public function get2ndYear2ndTermSubject($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM subjects WHERE yearlevel = '2nd Year' and term = '2nd Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $subject = $stmt->fetchall();
            $subjectCount = $stmt->rowCount();

            if($subject > 0)
            {
                return $subject;
            } else {
                return false;
            }   
        }

        public function get3rdYear1stTermSubject($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM subjects WHERE yearlevel = '3rd Year' and term = '1st Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $subject = $stmt->fetchall();
            $subjectCount = $stmt->rowCount();

            if($subject > 0)
            {
                return $subject;
            } else {
                return false;
            }   
        }

        public function get3rdYear2ndTermSubject($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM subjects WHERE yearlevel = '3rd Year' and term = '2nd Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $subject = $stmt->fetchall();
            $subjectCount = $stmt->rowCount();

            if($subject > 0)
            {
                return $subject;
            } else {
                return false;
            }   
        }

        public function get4thYear1stTermSubject($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM subjects WHERE yearlevel = '4th Year' and term = '1st Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $subject = $stmt->fetchall();
            $subjectCount = $stmt->rowCount();

            if($subject > 0)
            {
                return $subject;
            } else {
                return false;
            }   
        }

        public function get4thYear2ndTermSubject($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM subjects WHERE yearlevel = '4th Year' and term = '2nd Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $subject = $stmt->fetchall();
            $subjectCount = $stmt->rowCount();

            if($subject > 0)
            {
                return $subject;
            } else {
                return false;
            }   
        }

        public function updateSubject() 
        {
            if(isset($_POST['update'])) {
                $id = $_POST['id'];
                $subjectcode = $_POST['subjectcode'];
                $subjecttitle = $_POST['subjecttitle'];
                $yearlevelterm = $_POST["yearlevel"]."/".$_POST["term"];
                $units = $_POST['units'];
                $price = $_POST['price'];
                $coursecode = $_POST['coursecode'];
                $amount = $units * $price;

                $connection = $this->openConnection();
                $stmt = $connection->prepare("UPDATE subjects SET yearlevelterm=?, subject_code=?, subject_title=?, units=?, price=?, amount=? where id=?");
                $stmt->execute([$yearlevelterm,$subjectcode,$subjecttitle,$units,$price,$amount,$id]);

                header("Location: subjects.php?course=$coursecode");
            }
        }

        public function deleteSubject()
        {
            if(isset($_POST['Delete'])) {
                $id = $_POST['id'];
                $coursecode = $_POST['coursecode'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("DELETE FROM subjects WHERE id=?");
                $stmt->execute([$id]);

                header("Location: subjects.php?course=$coursecode");
            } elseif(isset($_POST['No'])) {
                header("Location: subjects.php");
            }
        }

        public function addSection()
        {
            if(isset($_POST['add_section'])) {
                $section_id = $_POST['section_id'];
                $section_name = $_POST['section_name'];
                $yearlevel = $_POST['yearlevel'];
                $term = $_POST['term'];
                $yearlevelterm = $_POST["yearlevel"]."/".$_POST["term"];
                $course_code = $_POST['course_code'];

                $connection = $this->openConnection();
                $stmt=$connection->prepare("INSERT INTO sections(`section_id`,`section_name`,`yearlevel`,`term`,`yearlevelterm`,`course_code`)VALUES(?,?,?,?,?,?)");
                $stmt->execute([$section_id,$section_name,$yearlevel,$term,$yearlevelterm,$course_code]);
                header("Location: sections.php?course=$course_code");
            }            
        }

        public function getSection()
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections");
            $stmt->execute();
            $sections = $stmt->fetchAll();
            $sectionCount = $stmt->rowCount();

            if($sectionCount > 0)
            {
                return $sections;
            } else {
                return false;
            }
        }

        public function get1stSec1st($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections WHERE yearlevel = '1st Year' and term = '1st Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $sections = $stmt->fetchAll();
            $sectionCount = $stmt->rowCount();

            if($sectionCount > 0)
            {
                return $sections;
            } else {
                return false;
            }
        }

        public function get1stSec2nd($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections WHERE yearlevel = '1st Year' and term = '2nd Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $sections = $stmt->fetchAll();
            $sectionCount = $stmt->rowCount();

            if($sectionCount > 0)
            {
                return $sections;
            } else {
                return false;
            }
        }

        public function get2ndSec1st($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections WHERE yearlevel = '2nd Year' and term = '1st Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $sections = $stmt->fetchAll();
            $sectionCount = $stmt->rowCount();

            if($sectionCount > 0)
            {
                return $sections;
            } else {
                return false;
            }
        }

        public function get2ndSec2nd($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections WHERE yearlevel = '2nd Year' and term = '2nd Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $sections = $stmt->fetchAll();
            $sectionCount = $stmt->rowCount();

            if($sectionCount > 0)
            {
                return $sections;
            } else {
                return false;
            }
        }

        public function get3rdSec1st($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections WHERE yearlevel = '3rd Year' and term = '1st Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $sections = $stmt->fetchAll();
            $sectionCount = $stmt->rowCount();

            if($sectionCount > 0)
            {
                return $sections;
            } else {
                return false;
            }
        }

        public function get3rdSec2nd($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections WHERE yearlevel = '3rd Year' and term = '2nd Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $sections = $stmt->fetchAll();
            $sectionCount = $stmt->rowCount();

            if($sectionCount > 0)
            {
                return $sections;
            } else {
                return false;
            }
        }

        public function get4thSec1st($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections WHERE yearlevel = '4th Year' and term = '1st Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $sections = $stmt->fetchAll();
            $sectionCount = $stmt->rowCount();

            if($sectionCount > 0)
            {
                return $sections;
            } else {
                return false;
            }
        }

        public function get4thSec2nd($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections WHERE yearlevel = '4th Year' and term = '2nd Term' and course_code = ?");
            $stmt->execute([$course_code]);
            $sections = $stmt->fetchAll();
            $sectionCount = $stmt->rowCount();

            if($sectionCount > 0)
            {
                return $sections;
            } else {
                return false;
            }
        }

        public function updateSection() 
        {
            if(isset($_POST['update'])) {
                $sectionid = $_POST['sectionid'];
                $sectionname = $_POST['sectionname'];
                $yearlevelterm = $_POST["yearlevel"]."/".$_POST["term"];
                $coursecode = $_POST['coursecode'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("UPDATE sections SET section_name=?, yearlevelterm = ? where section_id=?");
                $stmt->execute([$sectionname,$yearlevelterm,$sectionid]);

                header("Location: sections.php?course=$coursecode");
            }
        }

        public function deleteSection() 
        {
            if(isset($_POST['Delete'])) {
                $sectionid = $_POST['sectionid'];
                $coursecode = $_POST['coursecode'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("DELETE FROM sections WHERE section_id=?");
                $stmt->execute([$sectionid]);

                header("Location: sections.php?course=$coursecode");
            } elseif(isset($_POST['No'])) {
                header("Location: sections.php?course=$coursecode");
            }
        }

        public function getCourse_Code()
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM course");
            $stmt->execute();
            $course = $stmt->fetchAll();
            $courseCount = $stmt->rowCount();

            if($courseCount > 0) {
                return $course;
            } else {
                return 0;
            }
        }

        function checkKeys($randStr)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM students");
            $uniqueid = $stmt->fetchAll();
            $uniqueidCount = $stmt->rowCount();

            foreach($uniqueid as $row)
            {
                if($row['student_id'] == $randStr)
                {
                    $keyExists = true;
                    break;
                } else {
                    $keyExists = false;
                }
                return $keyExists;   
            }  
        }

        function generateKey()
        {   
            $connection = $this->openConnection();
            $year = "STI"."".date("Y");
            $keyLength = 6;
            $str = "1234567890";
            $randStr = $year."".(substr(str_shuffle($str), 0, $keyLength));


            $checkKey = $this->checkKeys($randStr);

            while($checkKey == true)
            {
                $randStr = $year."".(substr(str_shuffle($str), 0, $keyLength));
                $checkKey = $this->checkKeys($randStr);
            }
            return $randStr;
        }

        public function addStudent()
        {
            if(isset($_POST['submit'])) {
                $student_id = $_POST['student_id'];
                $last_name=$_POST['lname'];
                $first_name=$_POST['fname'];
                $middle_name=$_POST['mname'];
                $suffix_name=$_POST['sfxname'];
                $studentname = $_POST['lname']. " " .$_POST['fname']. " " .$_POST['mname']. " " .$_POST['sfxname'];
                $address=$_POST['address'];
                $birthdate =$_POST['birthdate'];
                $age=$_POST['age'];
                $gender=$_POST['gender'];
                $weight=$_POST['weight'];
                $height=$_POST['height'];
                $email=$_POST['email'];
                $marital=$_POST['marital'];
                $citizenship=$_POST['citizenship'];
                $mobile_no=$_POST['mobile_no'];
                $guardian=$_POST['guardian'];
                $gdnmobile=$_POST['gdnmobile'];
                $image = addslashes($_FILES['image']['tmp_name']);
                $image = file_get_contents($image);
                $image = base64_encode($image);
                $msg="";

                $connection = $this->openConnection();
                $stmt=$connection->prepare("INSERT INTO students(`student_id`,`last_name`,`first_name`,`middle_name`,`suffix_name`,`studentname`,`address`,`birthdate`,`age`,`gender`,`weight`,`height`,`email`,`marital`,`citizenship`,`mobile_no`,`guardian`,`gdn_mobile_no`,`image`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute([$student_id,$last_name,$first_name,$middle_name,$suffix_name,$studentname,$address,$birthdate,$age,$gender,$weight,$height,$email,$marital,$citizenship,$mobile_no,$guardian,$gdnmobile,$image]);

                if(move_uploaded_file($_FILES['image']['tmp_name'],$target))
                {
                	$msg= "nice";
                
                }
                else
                {
                	$msg= "failed";
                
                }
                header("Location: studentresult.php?student_id=$student_id"); 
            }
        }

        public function shownewStudent($student_id)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM students where student_id=?");
            $stmt->execute([$student_id]);
            $id = $stmt->fetch();
            $idCount = $stmt->rowCount();

            if($idCount > 0) {
                return $id;
            } else {
            }
        }

        public function editStudent() 
        {
            if(isset($_POST['Update'])) {
                $image = addslashes($_FILES['image']['tmp_name']);
                $image = file_get_contents($image);
                $image = base64_encode($image);
                $last_name=$_POST['lname'];
                $first_name=$_POST['fname'];
                $middle_name=$_POST['mname'];
                $suffix_name=$_POST['sfxname'];
                $studentname = $_POST['lname']. " " .$_POST['fname']. " " .$_POST['mname']. " " .$_POST['sfxname'];
                $address=$_POST['address'];
                $birthdate =$_POST['birthdate'];
                $age=$_POST['age'];
                $gender=$_POST['gender'];
                $weight=$_POST['weight'];
                $height=$_POST['height'];
                $email=$_POST['email'];
                $marital=$_POST['marital'];
                $citizenship=$_POST['citizenship'];
                $mobile_no=$_POST['mobile_no'];
                $guardian=$_POST['guardian'];
                $gdnmobile=$_POST['gdnmobile'];
                $msg="";
                $student_id = $_POST['student_id'];

                $connection = $this->openConnection();
                $stmt=$connection->prepare("UPDATE students SET last_name = ?, first_name = ?, middle_name = ?, suffix_name = ?, studentname = ?, address = ?, birthdate = ?, age = ?, gender = ?, weight = ?, height = ?, email = ?, marital = ?, citizenship = ?, mobile_no = ?, guardian = ?, gdn_mobile_no = ?, image = ? WHERE student_id = ?");
                $stmt->execute([$last_name,$first_name,$middle_name,$suffix_name,$studentname, $address,$birthdate,$age,$gender,$weight,$height,$email,$marital,$citizenship,$mobile_no,$guardian,$gdnmobile,$image,$student_id]);

                if(move_uploaded_file($_FILES['image']['tmp_name'],$target))
                {
                	$msg= "nice";
                
                }
                else
                {
                	$msg= "failed";
                
                }
                $message = "wrong answer";
                echo "<script type='text/javascript'>alert('Updated');</script>";
                echo "<script>window.location.href ='list_students.php';</script>";
            }
        }

        public function deleteStudent()
        {
            if(isset($_POST['Yes'])) {
                $student_id = $_POST['student_id'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("DELETE FROM students WHERE student_id=?");
                $stmt->execute([$student_id]);

                header("Location: list_students.php");
            } elseif(isset($_POST['No'])) {
                header("Location: list_students.php");
            }
        }

        public function getStudents()
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM students where status='Active'");
            $stmt->execute();
            $students = $stmt->fetchAll();
            $studentCount = $stmt->rowCount();

            if($studentCount > 0) {
                return $students;
            } else {
                return 0;
            }
        }

        public function getInactiveStudents()
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM students where status='Inactive'");
            $stmt->execute();
            $students = $stmt->fetchAll();
            $studentCount = $stmt->rowCount();

            if($studentCount > 0) {
                return $students;
            } else {
                return 0;
            }
        }

        public function archiveStudent()
        {
            if(isset($_POST['Archive']))
            {
                $student_id = $_POST['student_id'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("UPDATE students set status='Inactive' WHERE student_id=?");
                $stmt->execute([$student_id]);

                header("Location: list_students.php");
            }
        }

        public function restoreStudent()
        {
            if(isset($_POST['Restore'])) 
            {
                $student_id = $_POST['student_id'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("UPDATE students set status='Active' WHERE student_id=?");
                $stmt->execute([$student_id]);

                header("Location: archiveStudent.php");
            }
        }

        public function getSectionName($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections where course_code=?");
            $stmt->execute([$course_code]);
            $id = $stmt->fetchAll();
            $idCount = $stmt->rowCount();

            if($idCount > 0) {
                return $id;
            } else {
            }
        }

        public function getSectionNameYT($yearlevel, $term, $course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections where yearlevel=? and term=? and course_code=?");
            $stmt->execute([$yearlevel,$term,$course_code]);
            $id = $stmt->fetchAll();
            $idCount = $stmt->rowCount();

            if($idCount > 0) {
                return $id;
            } else {
            }
        }

        public function getSectionId($section_name)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections where section_name=?");
            $stmt->execute([$section_name]);
            $id = $stmt->fetchAll();
            $idCount = $stmt->rowCount();

            if($idCount > 0) {
                return $id;
            } else {
            }
        }

        public function getSectionIdonly($name)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections where section_name=?");
            $stmt->execute([$name]);
            $id = $stmt->fetch();
            $idCount = $stmt->rowCount();

            if($idCount > 0) {
                return $id;
            } else {
            }
        }

        public function getSectionNameonly($secid)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections where section_id=?");
            $stmt->execute([$secid]);
            $id = $stmt->fetch();
            $idCount = $stmt->rowCount();

            if($idCount > 0) {
                return $id;
            } else {
            }
        }

        public function getSubjectCode($yearlevel,$term,$course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM subjects where yearlevel=? and term=? and course_code=? ORDER BY subject_code ASC");
            $stmt->execute([$yearlevel,$term,$course_code]);
            $subject = $stmt->fetchAll();
            $subjectCount = $stmt->rowCount();

            if($subjectCount > 0)
            {
                return $subject;
            } else {
                return false;
            }   
        }

        public function getSubjectName($subject_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM subjects where subject_code=?");
            $stmt->execute([$subject_code]);
            $title = $stmt->fetchAll();
            $titleCount = $stmt->rowCount();

            if($titleCount > 0)
            {
                return $title;
            } else {
                return false;
            }   
        }

        public function getTeachersName()
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM departments");
            $stmt->execute();
            $title = $stmt->fetchAll();
            $titleCount = $stmt->rowCount();

            if($titleCount > 0)
            {
                return $title;
            } else {
                return false;
            }   
        }

        public function getTeacherId($deptname)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM departments where deptname=?");
            $stmt->execute([$deptname]);
            $id = $stmt->fetchAll();
            $idCount = $stmt->rowCount();

            if($idCount > 0)
            {
                return $id;
            } else {
                return false;
            }   
        }

        public function addSchedule()
        {
            if(isset($_POST['Save']))
            {
                $course_code = $_POST['course_code'];
                $yearlevel = $_POST['year'];
                $term = $_POST['term'];
                $sectionid = $_POST['sectionid'];
                $subjectid = $_POST['subjectid'];
                $days = $_POST['day'];
                $daysCount = implode(",",$days);
                $timefrom = $_POST['timefrom'];
                $timeto = $_POST['timeto'];
                $teacherid = $_POST['teacherid'];

                $connection = $this->openConnection();
                $stmt=$connection->prepare("INSERT INTO schedules(`course_code`,`yearlevel`,`term`,`sectionid`,`subjectid`,`days`,`timefrom`,`timeto`,`teacherid`)VALUES(?,?,?,?,?,?,?,?,?)");
                $stmt->execute([$course_code,$yearlevel,$term,$sectionid,$subjectid,$daysCount,$timefrom,$timeto,$teacherid]);
                header("Location: scheduling.php?course=$course_code&year=$yearlevel&term=$term&secid=$sectionid");   
            }
        }

        public function updateSchedule()
        {
            if(isset($_POST['Update']))
            {
                $id = $_POST['id'];
                $course_code = $_POST['course_code'];
                $yearlevel = $_POST['yearlevel'];
                $term = $_POST['term'];
                $sectionid = $_POST['sectionid'];
                $days = $_POST['day'];
                $daysCount = implode(",",$days);
                $timefrom = $_POST['timefrom'];
                $timeto = $_POST['timeto'];
                $teacherid = $_POST['teachersid'];

                $connection = $this->openConnection();
                $stmt=$connection->prepare("UPDATE schedules SET days=?, timefrom=?, timeto=?, teacherid=? where id=?");
                $stmt->execute([$daysCount,$timefrom,$timeto,$teacherid,$id]);
                header("Location: scheduling.php?course=$course_code&year=$yearlevel&term=$term&secid=$sectionid");   
            }
        }

        public function getSchedule($course_code, $yearlevel, $term, $section_id)
         {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT s.subject_code, s.subject_title, s.units, h.*, e.section_name, d.deptname from schedules as h inner join subjects as s on h.subjectid = s.id INNER join sections as e on e.section_id = h.sectionid INNER join departments as d on d.dept_id = h.teacherid where h.course_code = ? AND h.yearlevel = ? AND h.term = ? AND e.section_id = ?");
            $stmt->execute([$course_code, $yearlevel, $term, $section_id]);
            $schedule = $stmt->fetchAll();
            $scheduleCount = $stmt->rowCount();

            if($scheduleCount > 0)
            {
                return $schedule;
            } else {
                return false;
            }
         }

         public function deleteSchedule()
         {
             if(isset($_POST['Delete']))
             {
                $id = $_POST['id'];
                $course_code = $_POST['course'];
                $yearlevel = $_POST['yearlevel'];
                $term = $_POST['term'];
                $sectionid = $_POST['sectionid'];

                 $connection = $this->openConnection();
                 $stmt = $connection->prepare("DELETE FROM schedules WHERE id=?");
                $stmt->execute([$id]);
                header("Location: scheduling.php?course=$course_code&year=$yearlevel&term=$term&secid=$sectionid");
             }
         }

        

         public function searchStudent($studentid)
         {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM students where studentname=?");
            $stmt->execute([$studentid]);
            $id = $stmt->fetch();
            $idCount = $stmt->rowCount();

            if($idCount > 0)
            {
                return $id;
            } else {
            }   
        }

        public function getStudentName()
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM students where status='Active'");
            $stmt->execute();
            $students = $stmt->fetch();
            $studentCount = $stmt->rowCount();

            if($studentCount > 0) {
                return $students;
            } else {
                return 0;
            }
        }

        public function getSectionNameforEnroll($course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM sections where course_code=?");
            $stmt->execute([$course_code]);
            $id = $stmt->fetchAll();
            $idCount = $stmt->rowCount();

            if($idCount > 0) {
                return $id;
            } else {
            }
        }

        public function getScheduleEnroll($course_code, $yearlevel, $term, $section_id)
         {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT s.*, h.*, e.*, d.* from schedules as h inner join subjects as s on h.subjectid = s.id INNER join sections as e on e.section_id = h.sectionid INNER join departments as d on d.dept_id = h.teacherid where h.course_code = ? AND h.yearlevel = ? AND h.term = ? AND e.section_id = ?");
            $stmt->execute([$course_code, $yearlevel, $term, $section_id]);
            $schedule = $stmt->fetchAll();
            $scheduleCount = $stmt->rowCount();

            if($scheduleCount > 0)
            {
                return $schedule;
            } else {
                return false;
            }
         }
         
         public function EnrollStudent() {
            if(isset($_POST['save']))
            {
                    $yearlevel = $_POST['yearlevel'];
                    $term = $_POST['term'];
                    $studentid = $_POST['studentid'];
                    $sycode = $_POST['sycode'];
                    $coursecode = $_POST['coursecode'];
                    $sectionid = $_POST['sectionid'];
                    $feetype = $_POST['feetype'];
                    $uponenrollment = $_POST['uponenrollment'];
                    $prelim = $_POST['prelim'];
                    $midterm = $_POST['midterm'];
                    $prefinal = $_POST['prefinal'];
                    $final = $_POST['final'];
                
                $connection = $this->openConnection();
                $stmt=$connection->prepare("INSERT INTO enrollment(`yearlevel`,`term`,`studentid`,`sycode`,`coursecode`,`sectionid`,`feetype`,`uponenrollment`,`prelim`,`midterm`,`prefinal`,`final`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute([$yearlevel,$term,$studentid,$sycode,$coursecode,$sectionid,$feetype,$uponenrollment,$prelim,$midterm,$prefinal,$final]);
                echo "<script type='text/javascript'>alert('This student is enroll')</script>";
                echo "<script>window.location.href ='enrollment.php';</script>";
            }      
         }

         public function check_user_exist($username,$password)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM students WHERE username = ? AND password = ?");
            $stmt->execute([$username, $password]); 
            $total = $stmt->rowCount();

            return $total;
        }

        public function addAccount()
        {
            if(isset($_POST['save']))
            {
                $username = $_POST['studentid'];
                $password = $_POST['password'];
                $studentid = $_POST['studentid'];

                if($this->check_user_exist($username,$password) == 0)
                {
                    $connection = $this->openConnection();
                    $stmt = $connection->prepare("UPDATE students SET username = ?, password = ? WHERE student_id = ?");
                    $stmt->execute([$username, $password, $studentid]);
                }
            }
        }

         public function viewEnrollStudents($sycode,$coursecode)
         {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT s.*, e.sycode, e.coursecode, e.yearlevel, e.term, c.*, e.date_added, e.status FROM enrollment as e inner join students as s on e.studentid=s.student_id inner join sections as c on e.sectionid=c.section_id where sycode=? and coursecode LIKE ?");
            $stmt->execute([$sycode,$coursecode]);
            $enroll = $stmt->fetchAll();
            $enrollCount = $stmt->rowCount();

            if($enrollCount > 0) {
                return $enroll;
            } else {
            }
         }

        public function printStudent($section_id, $student_id)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT s.*, e.sycode, e.coursecode, e.yearlevel, e.term, c.section_name, h.*, u.*, d.* FROM enrollment as e inner join students as s on e.studentid=s.student_id inner join sections as c on e.sectionid=c.section_id inner join schedules as h on e.sectionid = h.sectionid inner join subjects as u on h.subjectid = u.id inner join departments as d on h.teacherid = d.dept_id where c.section_id = ? and s.student_id = ?");
            $stmt->execute([$section_id, $student_id]);
            $print = $stmt->fetchAll();
            $printCount = $stmt->rowCount();

            if($printCount > 0) {
                return $print;
            } else {
            }
        }

        public function viewEnrollStudent($student_id,$sycode)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT s.*, e.sycode, e.coursecode, e.yearlevel, e.term, e. feetype, e.uponenrollment, e.prelim, e.midterm, e.prefinal, e.final, c.*, e.date_added, e.status FROM enrollment as e inner join students as s on e.studentid=s.student_id inner join sections as c on e.sectionid=c.section_id where student_id=? and e.sycode=?");
            $stmt->execute([$student_id,$sycode]);
            $student = $stmt->fetch();
            $studentCount = $stmt->rowCount();

            if($studentCount > 0) {
                return $student;
            } else {
            }
        }

        public function addFee()
        {
            if(isset($_POST['Save']))
            {
                $yearlevel = $_POST['yearlevel'];
                $term = $_POST['term'];
                $description = $_POST['description'];
                $amount = $_POST['amount'];
                $course_code = $_POST['course'];
                
                $connection = $this->openConnection();
                $stmt=$connection->prepare("INSERT INTO fees(`yearlevel`,`term`,`description`,`amount`,`course_code`)VALUES(?,?,?,?,?)");
                $stmt->execute([$yearlevel,$term,$description,$amount,$course_code]);
                header("Location: fees.php?course=$course_code&yearlevel=$yearlevel&term=$term"); 
            }
        }

        
        public function viewFee($yearlevel,$term,$course_code)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM fees WHERE yearlevel=? and term=? and course_code=?");
            $stmt->execute([$yearlevel,$term,$course_code]);
            $fee = $stmt->fetchAll();
            $feeCount = $stmt->rowCount();

            if($feeCount > 0) {
                return $fee;
            } else {
            }
        }

        public function studentSubjects($sycode, $section_id, $student_id)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT s.*, e.sycode, e.coursecode, e.yearlevel, e.term, c.section_name, h.*, u.*, d.* FROM enrollment as e inner join students as s on e.studentid=s.student_id inner join sections as c on e.sectionid=c.section_id inner join schedules as h on e.sectionid = h.sectionid inner join subjects as u on h.subjectid = u.id inner join departments as d on h.teacherid = d.dept_id where e.sycode = ? and c.section_id = ? and s.student_id = ?");
            $stmt->execute([$sycode, $section_id, $student_id]);
            $print = $stmt->fetchAll();
            $printCount = $stmt->rowCount();

            if($printCount > 0) {
                return $print;
            } else {
            }
        }
        
        public function showEnrollStudent($sycode, $student_id)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT s.*, e.enrollmentid, e.sycode, e.coursecode, e.yearlevel, e.term, e. feetype, e.uponenrollment, e.prelim, e.midterm, e.prefinal, e.final, c.*, e.date_added, e.status, e.percentpayment FROM enrollment as e inner join students as s on e.studentid=s.student_id inner join sections as c on e.sectionid=c.section_id where e.sycode=? and student_id=?");
            $stmt->execute([$sycode, $student_id]);
            $student = $stmt->fetch();
            $studentCount = $stmt->rowCount();

            if($studentCount > 0) {
                return $student;
            } else {
            }
        }

        public function updateFees()
        {
            if(isset($_POST['update']))
            {
                $id = $_POST['id'];
                $coursecode = $_POST['coursecode'];
                $yearlevel = $_POST['yearlevel'];
                $term = $_POST['term'];
                $description = $_POST['description'];
                $amount = $_POST['amount'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("UPDATE fees SET description=?, amount=? where fid=?");
                $stmt->execute([$description,$amount,$id]);

                header("Location: fees.php?course=$coursecode&yearlevel=$yearlevel&term=$term");  
            }
        }

        public function deleteFees()
        {
            if(isset($_POST['delete']))
            {
                $id = $_POST['id'];
                $coursecode = $_POST['coursecode'];
                $yearlevel = $_POST['yearlevel'];
                $term = $_POST['term'];

                $connection = $this->openConnection();
                $stmt = $connection->prepare("DELETE FROM fees WHERE fid=?");
                $stmt->execute([$id]);

                header("Location: fees.php?course=$coursecode&yearlevel=$yearlevel&term=$term");
            }
        }

        public function viewPayments($sycode, $sycode1)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT p.*, s.studentname, e.*, c.* from payments as p left join students as s on p.studentid=s.student_id left join enrollment as e on s.student_id=e.studentid left join sections as c on c.section_id=e.sectionid where e.sycode = ? and p.sycode = ? order by created desc");
            $stmt->execute([$sycode, $sycode1]);
            $payment = $stmt->fetchAll();
            $paymentCount = $stmt->rowCount();

            if($paymentCount > 0) {
                return $payment;
            } else {
            }
        }

        public function updatePercent($percent, $eid)
        {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("UPDATE enrollment SET percentpayment=percentpayment+? where enrollmentid=?");
            $stmt->execute([$percent,$eid]);
        }

        public function sumPayment($sycode, $studentid)
        {
            $connection = $this->openConnection();  
            $stmt = $connection->prepare("SELECT SUM(payment_gross)totalpayment from payments where sycode = ? and studentid = ?");
            $stmt->execute([$sycode,$studentid]);
            $sum = $stmt->fetch();
            $sumCount = $stmt->rowCount();

            if($sumCount > 0) {
                return $sum;
            } else {

            }
        }
        
        public function viewPaymentStudent($sycode,$studentid)
        {
            $connection = $this->openConnection();  
            $stmt = $connection->prepare("SELECT * from payments where sycode = ? and studentid = ? order by created desc");
            $stmt->execute([$sycode,$studentid]);
            $pay = $stmt->fetchAll();
            $payCount = $stmt->rowCount();

            if($payCount > 0) {
                return $pay;
            } else {

            }
        }

        public function viewEnrollAccount($sycode)
        {
            $connection = $this->openConnection();  
            $stmt = $connection->prepare("SELECT s.*, e.sycode, e.studentid, e.coursecode, e.yearlevel, e.term, c.*, e.date_added, e.status FROM enrollment as e inner join students as s on e.studentid=s.student_id inner join sections as c on e.sectionid=c.section_id where sycode=?");
            $stmt->execute([$sycode]);
            $pay = $stmt->fetchAll();
            $payCount = $stmt->rowCount();

            if($payCount > 0) {
                return $pay;
            } else {

            }
        }

        public function viewUnEnrollAccount($sycode)
        {
            $connection = $this->openConnection();  
            $sycode3 = $this->openSY();
            $viewenrollaccounts = $this->viewEnrollAccount($sycode);
            $studentid = array();
            if(is_array($viewenrollaccounts) || is_object($viewenrollaccounts))  {
            foreach($viewenrollaccounts as $rows) {
                $studentid[] = $rows['studentid'];
                $studentname = $rows['studentname'];
                $yearlevel = $rows['yearlevel'];
                $array = array($rows['studentid']);
            }
            } else {
                echo "No data";
            }
            $studentCount = "'".implode("','" ,$studentid)."'";
            $stmt = $connection->prepare("SELECT DISTINCT e.studentid, s.studentname FROM enrollment as e inner join students as s on e.studentid=s.student_id where sycode!='2019-2020 1st Term' and e.studentid NOT IN($studentCount)");
            $stmt->execute([$sycode]);
            $pay = $stmt->fetchAll();
            $payCount = $stmt->rowCount();

            if($payCount > 0) {
                return $pay;
            } else {

            }
        }

        public function updateStudentFees()
        {
            if(isset($_POST['update']))
            {
                $studentid = $_POST['studentid'];
                $sycode = $_POST['sycode'];
                $feetype = $_POST['feetype'];
                $uponenrollment = $_POST['uponenrollment'];
                $prelim = $_POST['prelim'];
                $midterm = $_POST['midterm'];
                $prefinal = $_POST['prefinal'];
                $final = $_POST['final'];

                $connection = $this->openConnection();  
                $stmt = $connection->prepare("UPDATE enrollment SET feetype = ?, uponenrollment = ?, prelim = ?, midterm=?, prefinal = ?, final = ?, status = 'Enrolled' WHERE studentid = ? and sycode= ?");
                $stmt->execute([$feetype, $uponenrollment, $prelim, $midterm, $prefinal, $final, $studentid, $sycode]);
        
                header("Location: index.php");
            }
        }

        public function viewStudentsAccount()
        {
            $connection = $this->openConnection(); 
            $stmt = $connection->prepare("SELECT * FROM students where username IS NOT NULL AND password IS NOT NULL");
            $stmt->execute();
            $account = $stmt->fetchAll();
            $accountCount = $stmt->rowCount();

            if($accountCount > 0) {
                return $account;
            } else {

            }
        }

        public function showEnrolledYear($sycode)
        {
            $connection = $this->openConnection(); 
            $stmt = $connection->prepare("SELECT e.*, s.student_id, s.studentname, c.* FROM enrollment e inner join students s on e.studentid=student_id inner join sections c on e.sectionid=c.section_id where sycode = ?");
            $stmt->execute([$sycode]);
            $account = $stmt->fetchAll();
            $accountCount = $stmt->rowCount();

            if($accountCount > 0) {
                return $account;
            } else {

            }
        }

        public function onlineRegister()
        {
            if(isset($_POST['Save'])) {
                $student_id = $_POST['student_id'];
                $last_name=$_POST['lname'];
                $first_name=$_POST['fname'];
                $middle_name=$_POST['mname'];
                $suffix_name=$_POST['sfxname'];
                $studentname = $_POST['lname']. " " .$_POST['fname']. " " .$_POST['mname']. " " .$_POST['sfxname'];
                $address=$_POST['address'];
                $birthdate =$_POST['birthdate'];
                $age=$_POST['age'];
                $gender=$_POST['gender'];
                $weight=$_POST['weight'];
                $height=$_POST['height'];
                $email=$_POST['email'];
                $marital=$_POST['marital'];
                $citizenship=$_POST['citizenship'];
                $mobile_no=$_POST['mobile_no'];
                $guardian=$_POST['guardian'];
                $gdnmobile=$_POST['gdnmobile'];
                $status="Inactive";
                $image = addslashes($_FILES['image']['tmp_name']);
                $image = file_get_contents($image);
                $image = base64_encode($image);
                $msg="";

                $connection = $this->openConnection();
                $stmt=$connection->prepare("INSERT INTO students(`student_id`,`last_name`,`first_name`,`middle_name`,`suffix_name`,`studentname`,`address`,`birthdate`,`age`,`gender`,`weight`,`height`,`email`,`marital`,`citizenship`,`mobile_no`,`guardian`,`gdn_mobile_no`,`image`,`status`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute([$student_id,$last_name,$first_name,$middle_name,$suffix_name,$studentname,$address,$birthdate,$age,$gender,$weight,$height,$email,$marital,$citizenship,$mobile_no,$guardian,$gdnmobile,$image,$status]);

                if(move_uploaded_file($_FILES['image']['tmp_name'],$target))
                {
                	$msg= "nice";
                
                }
                else
                {
                	$msg= "failed";
                
                }
                header("Location: onlineregister.php");
            }
        }
    }

    $olenrollment = new olenrollment();
?>

