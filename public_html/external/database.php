<?php

function getStudentIDs() {
    $employees = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT `NetID`, `BlackboardID` FROM `Student Information`  \n"

        . "ORDER BY `Student Information`.`NetID` ASC";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        //Gets the netid of the current employee
        $NetID = $data[0];

        $employees[$NetID] = $data[1];
    }

    return $employees;
}

function getAllEmployees() {
    $employees = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `Student Information`  \n"

        . "ORDER BY `Student Information`.`First Name` ASC";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        //Gets the netid of the current employee
        $NetID = $data[3];

        $employee = findEmployee($NetID);

        $employees[$NetID] = $employee;
    }

    return $employees;
}

function getAllStudents() {
    $employees = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `Student Information` WHERE `Rank` != 'FTE' "

        . "ORDER BY `Student Information`.`First Name` ASC";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        //Gets the netid of the current employee
        $NetID = $data[3];

        $employee = findEmployee($NetID);

        $employees[$NetID] = $employee;
    }

    return $employees;
}

function getAllTrainees() {
    $employees = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `Student Information` WHERE `Rank` = 'Trainee' "

        . "ORDER BY `Student Information`.`First Name` ASC";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        //Gets the netid of the current employee
        $NetID = $data[3];

        $employee = findEmployee($NetID);

        $employees[$NetID] = $employee;
    }

    return $employees;
}

function getAllSpecialists() {
    $employees = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `Student Information` WHERE (`Rank` = 'Shop Specialist' OR `Rank` = 'Call Center Specialist' OR `Rank` = 'AIT Specialist') "

        . "ORDER BY `Student Information`.`First Name` ASC";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        //Gets the netid of the current employee
        $NetID = $data[3];

        $employee = findEmployee($NetID);

        $employees[$NetID] = $employee;
    }

    return $employees;
}

function getAllAdvanced() {
    $employees = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `Student Information` WHERE (`Rank` = 'Shop Advanced' OR `Rank` = 'Call Center Advanced' OR `Rank` = 'AIT Advanced') "

        . "ORDER BY `Student Information`.`First Name` ASC";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        //Gets the netid of the current employee
        $NetID = $data[3];

        $employee = findEmployee($NetID);

        $employees[$NetID] = $employee;
    }

    return $employees;
}

function getRankNumbers($rank){
    $numbers = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $total_sql = "SELECT COUNT(*) FROM `Student Information`";

    $total_result = @mysqli_query($db, $total_sql);

    $data = @mysqli_fetch_row($total_result);
    $total = $data[0];

    $count_sql = "SELECT COUNT(*) FROM `Student Information` WHERE `Rank`=\"$rank\"";

    $count_result = @mysqli_query($db, $count_sql);

    $data = mysqli_fetch_row($count_result);

    $numbers['Number'] = intval($data[0]);
    $numbers['Percent'] = $data[0]/$total;
    $numbers['Total'] = $total;

    return $numbers;
}

function getTeamNumbers($team){
    $numbers = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $total_sql = "SELECT COUNT(*) FROM `Student Information`";

    $total_result = @mysqli_query($db, $total_sql);

    $data = @mysqli_fetch_row($total_result);
    $total = $data[0];

    $count_sql = "SELECT COUNT(*) FROM `Student Information` WHERE `Team Selection`=\"$team\"";

    $count_result = @mysqli_query($db, $count_sql);

    $data = mysqli_fetch_row($count_result);

    $numbers['Number'] = intval($data[0]);
    $numbers['Percent'] = $data[0]/$total;
    $numbers['Total'] = $total;

    return $numbers;
}

function updateInfo($NetID, $field, $data){
    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "UPDATE `Student Information` SET `$field` = \"$data\" WHERE `NetID`=\"$NetID\"";

    @mysqli_query($db, $sql);

    @mysqli_close($db);
}

function deleteStudent($NetID){
    global $servername, $dbname, $username, $password;

    $db = @mysqli_connect($servername, $username, $password, $dbname);

    $sql = "DELETE FROM `Student Information` WHERE `NetID`=\"$NetID\"";

    @mysqli_query($db, $sql);

    @mysqli_close($db);
}

function findEquipmentRequest($FullName){
    $requests = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `Supplies Requests` WHERE `Name`=\"$FullName\" ORDER BY `ID` DESC";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        array_push($requests, $data);
    }

    @mysqli_close($db);

    return $requests;
}

function AllEquipmentSubmissions() {
    $submissions = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `Supplies Requests` ORDER BY `ID` DESC";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        array_push($submissions, $data);
    }

    @mysqli_close($db);

    return $submissions;
}

function AllFeedbackSubmissions(){
    $submissions = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `Student Feedback` ORDER BY `ID` DESC";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        array_push($submissions, $data);
    }

    @mysqli_close($db);

    return $submissions;
}

function AllTeamSubmissions(){
    $submissions = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `Team Selections` ORDER BY `Name` DESC";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        array_push($submissions, $data);
    }

    @mysqli_close($db);

    return $submissions;
}

function USBTypeCount($type){
    $count = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `USB Inventory` WHERE `OS` = '$type' ORDER BY `ID`";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        array_push($count, $data);
    }

    return $count;
}

function AllUSBCounts(){
    $USBs = ['Windows' => '', 'Mojave' => '','High Sierra' => '','Sierra' => '','Linux' => '','Bootcamp' => '','Fileserver' => ''];

    foreach($USBs as $Type => $Count){
        $USBs[$Type] = USBTypeCount($Type);
    }

    return $USBs;
}

function AllUSBSubmissions() {
    $submissions = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT * FROM `USB Inventory Submission` ORDER BY `Timestamp` DESC";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        array_push($submissions, $data);
    }

    @mysqli_close($db);

    return $submissions;
}

function newStudent($netid){
    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "INSERT INTO `Student Information` (`NetID`) VALUES (\"$netid\")";

    @mysqli_query($db, $sql);

    $newStudent = new Employee();

    $newStudent->NetID = $netid;

    @mysqli_close($db);

    return $newStudent;
}

function newSupply($name, $rank ,$supply, $comments){
    $id = uniqid();

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "INSERT INTO `Supplies Requests` (`ID`, `Name`, `Rank`, `Supplies Requested`, `Comments`, `Status`, `Feedback`)
            VALUES (\"$id\", \"$name\",\"$rank\",\"$supply\",\"$comments\",\"Pending\",\"\")";

    @mysqli_query($db, $sql);

    @mysqli_close($db);
}

function newFeedback($name, $rank ,$tech, $type, $comments){
    $id = uniqid();

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "INSERT INTO `Student Feedback` (`ID`,`Name`, `Rank`, `Tech Name`, `Type`, `Comments`)
            VALUES (\"$id\",\"$name\",\"$rank\",\"$tech\",\"$type\",\"$comments\")";

    @mysqli_query($db, $sql);

    @mysqli_close($db);
}

function newTeam($name, $rank ,$team, $meeting, $comments){
    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "INSERT INTO `Team Selections` (`Name`, `Rank`, `Team Selection`, `Meeting`, `Comments`)
            VALUES (\"$name\",\"$rank\",\"$team\",\"$meeting\",\"$comments\")";

    @mysqli_query($db, $sql);

    @mysqli_close($db);
}

function newUSB($ID, $OS ,$inventory, $working) {
    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "INSERT INTO `USB Inventory` (`ID`,`OS`, `Inventory Status`, `Working Status`)
            VALUES (\"$ID\",\"$OS\",\"$inventory\",\"$working\")";

    @mysqli_query($db, $sql);

    @mysqli_close($db);
}

function newUSBSub($time, $netid, $ID, $OS, $inventory, $working){
    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "INSERT INTO `USB Inventory Submission` (`Timestamp`,`NetID`,`ID`,`OS`, `Inventory Status`, `Working Status`)
            VALUES (\"$time\",\"$netid\",\"$ID\",\"$OS\",\"$inventory\",\"$working\")";

    @mysqli_query($db, $sql);

    @mysqli_close($db);
}

function updateEntry($table, $ID, $field, $data){
    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "UPDATE `$table` SET `$field` = \"$data\" WHERE `ID`=\"$ID\"";

    @mysqli_query($db, $sql);

    @mysqli_close($db);
}

function deleteEntry($table, $ID){
    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "DELETE FROM `$table` WHERE `ID`=\"$ID\"";

    @mysqli_query($db, $sql);

    @mysqli_close($db);
}

function findEntry($table, $ID){
    $submissions = [];

    $contants = new Constants();

    $db = @mysqli_connect($contants->servername, $contants->username, $contants->password, $contants->dbname);

    $sql = "SELECT *  FROM `$table` WHERE `ID` = \"$ID\"";

    $result = @mysqli_query($db, $sql);

    while ($data = mysqli_fetch_row($result)) {
        array_push($submissions, $data);
    }

    @mysqli_close($db);

    return $submissions;
}

