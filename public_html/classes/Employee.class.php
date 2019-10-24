<?php
require ($_SERVER['DOCUMENT_ROOT'] . '/classes/Constants.class.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/external/database.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/external/blackboard.php');

function findEmployee($netid){
    //creates a dictionary to hold all information
    $person = new Employee();

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `Student Information` WHERE `NetID`=\"$netid\"";

    $result = @mysqli_query($db, $sql);

    $data = mysqli_fetch_array($result);

    if ($result->num_rows > 0) {
        $person->First = $data['First Name'];
        $person->Last = $data['Last Name'];
        $person->Full = $data['Full Name'];
        $person->NetID = $netid;
        $person->blackboardID = $data['BlackboardID'];
        $person->Email = $data['Email'];
        $person->StudentEmail = $data['Student Email'];
        $person->Team = $data['Team Selection'];

        if ($netid == "ams14036") {
//            $person->Role = 'FTE';
            $person->Role = 'Shop Lead';
//            $person->Role = 'Call Center Lead';
//            $person->Role = 'AIT Center Lead';
//            $person->Role = 'Shop Advanced';
//            $person->Role = 'Call Center Advanced';
//            $person->Role = 'AIT Specialist';
//            $person->Role = 'Shop Specialist';
//            $person->Role = 'Call Center Specialist';
//            $person->Role = 'Trainee';
        } else {
            $person->Role = $data['Rank'];
        }

        $person->Graduation = $data['Graduation Date'];
        $person->ACD = $data['ACD'];
        $person->Notes = $data['Notes'];

        @mysqli_close($db);

        return $person;
    } else{
        @mysqli_close($db);

        return false;
    }
}

class Employee {
    public $blackboardID;
    public $First;
    public $Last;
    public $Full;
    public $NetID;
    public $Email;
    public $StudentEmail;
    public $Role;
    public $Team;
    public $Graduation;
    public $ACD;
    public $Notes;
    public $AllTests;
    public $courseID = '_58416_1';

    function updateMyInfo($field, $data) {
        updateInfo($this->NetID, $field, $data);
    }

    function deleteMyself() {
        deleteStudent($this->NetID);
    }

    function myEquipmentRequest() {
        return findEquipmentRequest($this->Full);
    }

    function allUSBS() {
        return AllUSBCounts();
    }

    function setBlackboardID() {
        $blackboardID = getUser($this->NetID)->id;
        $this->updateMyInfo('BlackboardID', $blackboardID);
    }

    function getTraining($level, $dept){
        return getContent($level, $dept);
    }

    function getEmployees(){
        return getAllEmployees();
    }

    function getStudents(){
        return getAllStudents();
    }

    function getAdvanced(){
        return getAllAdvanced();
    }

    function getSpecialists(){
        return getAllSpecialists();
    }

    function getTrainees(){
        return getAllTrainees();
    }

    function teamNumbers($team){
        return getTeamNumbers($team);
    }

    function rankNumbers($rank){
        return getRankNumbers($rank);
    }

    function equipmentSubmissions(){
        return AllEquipmentSubmissions();
    }

    function equipmentRequest(){
        return findEquipmentRequest($this->Full);
    }

    function allFeedbacks(){
        return AllFeedbackSubmissions();
    }

    function allTeams(){
        return AllTeamSubmissions();
    }

    function USBSubmissions() {
        return AllUSBSubmissions();
    }

    function getBasicModules($dept){
        return getContent('Basic Training', $dept);
    }

    function getSpecializedModules($dept){
        return getContent('Specialized Training', $dept);
    }

    function getTests() {
        $results['Trainee'] = ['Call Center' => getCCTraineeTests(), 'Shop' => getShopTraineeTests(), 'Academic IT' => getAITTraineeTests()];
        $results['Specialist'] = ['Call Center' => getCCSpecialistTests(), 'Shop' => getShopSpecialistTests(), 'Academic IT' => getAITSpecialistTests()];

        return $results;
    }

    function getGrades(){
        $grades = UserGrades($this->NetID);
        $results = [];

        foreach ($grades as $grade){
            $test = getTest($grade->columnId);

            $attempt = new userAttempt();

            $attempt->testName = $test->name;
            $attempt->testID = $test->id;
            $attempt->score = $grade->displayGrade->score;
            $attempt->status = $grade->status;

            array_push($results, $attempt);
        }

        return $results;
    }

    function getNeedsGrades($tests){
        $grades = $this->getGrades();
        $results = [];

        foreach ($tests as $test) {
            foreach ($grades as $grade) {
                if ($test->name == $grade->testName && $grade->status == 'NeedsGrading') {
                    array_push($results, $grade);
                }
            }
        }

        return $results;
    }

    function getGraded($tests){
        $grades = $this->getGrades();
        $results = [];
        $totalScore = 0;

        foreach ($tests as $test) {
            foreach ($grades as $grade) {
                if ($test->name == $grade->testName && $grade->status == 'Graded') {
                    array_push($results, $grade);
                    $totalScore += $grade->score;
                }
            }
        }

        $results['totalScore'] = $totalScore;

        return $results;
    }

    function getProgress(){
        $results = 0;

        switch ($this->Role) {
            case ('Trainee'):
                $score = 0;
                $total = 0;
                $allTests = $this->getTests()['Trainee'];

                foreach ($allTests as $test){
                    $graded = $this->getGraded($test);
                    $score += $graded['totalScore'];
                    $total += $test['totalPts'];
                }

                $results = ($score / $total) * 100;
                break;

            case ('Call Center Specialist'):
                $allTests = $this->getTests()['Specialist']['Call Center'];
                $graded = $this->getGraded($allTests);

                $total = $allTests['totalPts'];
                $score = $graded['totalScore'];

                $results = ($score / $total) * 100;
                break;

            case ('Shop Specialist'):
                $allTests = $this->getTests()['Specialist']['Shop'];
                $graded = $this->getGraded($allTests);

                $total = $allTests['totalPts'];
                $score = $graded['totalScore'];

                $results = ($score / $total) * 100;
                break;

            case ('AIT Specialist'):
                $allTests = $this->getTests()['Specialist']['Academic IT'];
                $graded = $this->getGraded($allTests);

                $total = $allTests['totalPts'];
                $score = $graded['totalScore'];

                $results = ($score / $total) * 100;
                break;
        }

        return $results;
    }

}
