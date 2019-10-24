<?php
require_once ('HTTP/Request2.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/classes/Blackboard.classes.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/classes/Materials.class.php');

function authorize(){
    $constants = new Constants();
    $token = [];

    $request = new HTTP_Request2($constants->HOSTNAME . $constants->AUTH_PATH, HTTP_Request2::METHOD_POST);
    $request->setAuth($constants->KEY, $constants->SECRET, HTTP_Request2::AUTH_BASIC);
    $request->setBody('grant_type=client_credentials');
    $request->setHeader('Content-Type', 'application/x-www-form-urlencoded');
    $request->setConfig($constants->Config);

    try {
        $response = $request->send();
        if (200 == $response->getStatus()) {
            $token = json_decode($response->getBody());
        } else {
            print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                $response->getReasonPhrase();
            $BbRestException = json_decode($response->getBody());
            var_dump($BbRestException);
        }
    } catch (HTTP_Request2_Exception $e) {
        print 'Error: ' . $e->getMessage();
    }

    return $token;
}

function getUser($userID) {
    $constants = new Constants();
    $user = [];

    $token = authorize()->access_token;

    $url = $constants->HOSTNAME . $constants->USER_PATH . '/userName:' . $userID;

    $request = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);
    $request->setHeader('Authorization', 'Bearer ' . $token);
    $request->setConfig($constants->Config);

    try {
        $response = $request->send();
        if (200 == $response->getStatus()) {
            $user = json_decode($response->getBody());
        } //else {
//            print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
//                $response->getReasonPhrase();
//            $BbRestException = json_decode($response->getBody());
//            var_dump($BbRestException);
//        }
    } catch (HTTP_Request2_Exception $e) {
        print 'Error: ' . $e->getMessage();
    }

    return $user;
}

function getCourseContent($training) {
    $constants = new Constants();
    $content = [];

    $token = authorize()->access_token;
    $url = $constants->HOSTNAME . $constants->ASSESSMENT_PATH . '/' . $constants->courseID . '/contents';

    $request = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);
    $request->setHeader('Authorization', 'Bearer ' . $token);
    $request->setConfig($constants->Config);

    try {
        $response = $request->send();
        if (200 == $response->getStatus()) {
            $results = json_decode($response->getBody());

            foreach($results->results as $result){
                if ($result->title == $training){
                    $content = $result;
                }
            }

        } else {
            print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                $response->getReasonPhrase();
            $BbRestException = json_decode($response->getBody());
            var_dump($BbRestException);
        }
    } catch (HTTP_Request2_Exception $e) {
        print 'Error: ' . $e->getMessage();
    }

    return $content;
}

function getSubContent($contentID) {
    $constants = new Constants();
    $content = [];

    $token = authorize()->access_token;
    $url = $constants->HOSTNAME . $constants->ASSESSMENT_PATH . '/' . $constants->courseID . '/contents/' . $contentID . '/children' ;

    $request = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);
    $request->setHeader('Authorization', 'Bearer ' . $token);
    $request->setConfig($constants->Config);

    try {
        $response = $request->send();
        if (200 == $response->getStatus()) {
            $content = json_decode($response->getBody());
        } else {
            print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                $response->getReasonPhrase();
            $BbRestException = json_decode($response->getBody());
            var_dump($BbRestException);
        }
    } catch (HTTP_Request2_Exception $e) {
        print 'Error: ' . $e->getMessage();
    }

    return $content->results;
}

function getColumns() {
    $constants = new Constants();
    $content = [];

    $token = authorize()->access_token;
    $url = $constants->HOSTNAME . $constants->COURSE_PATH . '/' . $constants->courseID . '/gradebook/columns';

    $request = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);
    $request->setHeader('Authorization', 'Bearer ' . $token);
    $request->setConfig($constants->Config);

    try {
        $response = $request->send();
        if (200 == $response->getStatus()) {
            $content = json_decode($response->getBody());
        } else {
            print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                $response->getReasonPhrase();
            $BbRestException = json_decode($response->getBody());
            var_dump($BbRestException);
        }
    } catch (HTTP_Request2_Exception $e) {
        print 'Error: ' . $e->getMessage();
    }

    return $content->results;
}

function getTest($testID) {
    $constants = new Constants();
    $content = [];

    $token = authorize()->access_token;
    $url = $constants->HOSTNAME . $constants->COURSE_PATH . '/' . $constants->courseID . '/gradebook/columns/' . $testID;

    $request = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);
    $request->setHeader('Authorization', 'Bearer ' . $token);
    $request->setConfig($constants->Config);

    try {
        $response = $request->send();
        if (200 == $response->getStatus()) {
            $content = json_decode($response->getBody());

//            $test = new Test();
//
//            $test->ID = $results->id;
//            $test->name = $results->name;
//            $test->totalPts = $results->score->possible;
//
//            array_push($content, $test);
        } else {
            print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                $response->getReasonPhrase();
            $BbRestException = json_decode($response->getBody());
            var_dump($BbRestException);
        }
    } catch (HTTP_Request2_Exception $e) {
        print 'Error: ' . $e->getMessage();
    }

    return $content;
}

function getTestGrades($testID) {
    $constants = new Constants();
    $content = [];

    $token = authorize()->access_token;
    $url = $constants->HOSTNAME . $constants->COURSE_PATH . '/' . $constants->courseID . '/gradebook/columns/'. $testID . '/users';

    $request = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);
    $request->setHeader('Authorization', 'Bearer ' . $token);
    $request->setConfig($constants->Config);

    try {
        $response = $request->send();
        if (200 == $response->getStatus()) {
            $content = json_decode($response->getBody());
        } // else {
////            print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
////                $response->getReasonPhrase();
////            $BbRestException = json_decode($response->getBody());
////            var_dump($BbRestException);
//        }
    } catch (HTTP_Request2_Exception $e) {
        print 'Error: ' . $e->getMessage();
    }

    return $content->results;
}

function UserTest($testID, $userID) {
    $constants = new Constants();
    $content = [];

    $token = authorize()->access_token;
    $url = $constants->HOSTNAME . $constants->COURSE_PATH . '/' . $constants->courseID . '/gradebook/columns/'.
        $testID . '/users/userName:' . $userID;

    $request = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);
    $request->setHeader('Authorization', 'Bearer ' . $token);
    $request->setConfig($constants->Config);

    try {
        $response = $request->send();
        if (200 == $response->getStatus()) {
            $content = json_decode($response->getBody());
        } else {
            print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                $response->getReasonPhrase();
            $BbRestException = json_decode($response->getBody());
            var_dump($BbRestException);
        }
    } catch (HTTP_Request2_Exception $e) {
        print 'Error: ' . $e->getMessage();
    }

    return $content;
}

function UserGrades($userID) {
    $constants = new Constants();
    $content = [];

    $token = authorize()->access_token;
    $url = $constants->HOSTNAME . $constants->COURSE_PATH . '/' . $constants->courseID . '/gradebook/users/userName:' . $userID;

    $request = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);
    $request->setHeader('Authorization', 'Bearer ' . $token);
    $request->setConfig($constants->Config);

    try {
        $response = $request->send();
        if (200 == $response->getStatus()) {
            $content = json_decode($response->getBody());
        }
    } catch (HTTP_Request2_Exception $e) {
        print 'Error: ' . $e->getMessage();
    }

    return $content->results;
}

function userAttempts($testID, $userID) {
    $constants = new Constants();
    $content = [];

    $token = authorize()->access_token;
    $url = $constants->HOSTNAME . $constants->COURSE_PATH . '/' . $constants->courseID . '/gradebook/columns/' . $testID .
        '/users/userName:' . $userID;

    $request = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);
    $request->setHeader('Authorization', 'Bearer ' . $token);
    $request->setConfig($constants->Config);

    try {
        $response = $request->send();
        if (200 == $response->getStatus()) {
            $content = json_decode($response->getBody());
        } else {
            print 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                $response->getReasonPhrase();
            $BbRestException = json_decode($response->getBody());
            var_dump($BbRestException);
        }

    } catch (HTTP_Request2_Exception $e) {
        print 'Error: ' . $e->getMessage();
    }

    return $content;
}

function getMaterials($levels){
    $results = [];

    foreach ($levels as $id => $level){
        $results[$id] = getSubContent($level[1]->id);
    }

    return $results;
}

function getQuizzes($levels){
    $results = [];

    foreach ($levels as $id => $level){
        $results[$id] = getSubContent($level[0]->id);
    }

    return $results;
}

function getMod($modules){
    $results = [];

    foreach ($modules as $module){
        $results[$module->title] = getSubContent($module->id);
    }

    return $results;
}

function getContent($level, $dept){
    $content = new Basic();

    $content->parentFolder = getCourseContent($level);
    $content->deptFolders = getSubContent($content->parentFolder->id);
    $content->modules = getModules($content->deptFolders, $dept);
    $content->modulesFolders = getMod($content->modules);
    $content->materials = getMaterials($content->modulesFolders);
    $content->quizzes = getQuizzes($content->modulesFolders);

    return $content;
}

function getModules($depts, $area){
    $results = [];

    foreach ($depts as $dept){
        if ($dept->title == $area) {
            $results = getSubContent($dept->id);
        }
    }

    return $results;
}

function NeedsGrades($test){
    $attempts = getTestGrades($test->ID);
    $results = [];
    
    foreach($attempts as $attempt){
        if ($attempt->status == 'NeedsGrading'){
           array_push($results, $attempt);
        }
    }

    return $results;
}

function comparator($test1, $test2){
    return $test1->name > $test2->name;
}

function getCCTraineeTests(){
    $constants = new Constants();
    $allTests = getColumns();
    $catID = $constants->CCtraineeCat;
    $results = [];
    $total = 0;


    foreach ($allTests as $test){
        if ($test->gradebookCategoryId == $catID){
            $quiz = new Test();

            $quiz->ID = $test->id;
            $quiz->name = $test->name;
            $quiz->totalPts = $test->score->possible;
            $quiz->rank = 'Trainee';
            $quiz->rankID = $catID;
            $quiz->contentID = $test->contentId;
            $quiz->needsGrading = NeedsGrades($quiz);
            $total += $quiz->totalPts;

            array_push($results, $quiz);
        }
    }

    usort($results, 'comparator');
    $results['totalPts'] = $total;

    return $results;
}

function getShopTraineeTests(){
    $constants = new Constants();
    $allTests = getColumns();
    $catID = $constants->ShoptraineeCat;
    $results = [];
    $total = 0;

    foreach ($allTests as $test){
        if ($test->gradebookCategoryId == $catID){
            $quiz = new Test();

            $quiz->ID = $test->id;
            $quiz->name = $test->name;
            $quiz->totalPts = $test->score->possible;
            $quiz->rank = 'Trainee';
            $quiz->rankID = $catID;
            $quiz->contentID = $test->contentId;
            $quiz->needsGrading = NeedsGrades($quiz);
            $total += $quiz->totalPts;

            array_push($results, $quiz);
        }
    }

    usort($results, 'comparator');
    $results['totalPts'] = $total;

    return $results;
}

function getAITTraineeTests(){
    $constants = new Constants();
    $allTests = getColumns();
    $catID = $constants->AITtraineeCat;
    $results = [];
    $total = 0;

    foreach ($allTests as $test){
        if ($test->gradebookCategoryId == $catID){
            $quiz = new Test();

            $quiz->ID = $test->id;
            $quiz->name = $test->name;
            $quiz->totalPts = $test->score->possible;
            $quiz->rank = 'Trainee';
            $quiz->rankID = $catID;
            $quiz->contentID = $test->contentId;
            $quiz->needsGrading = NeedsGrades($quiz);
            $total += $quiz->totalPts;

            array_push($results, $quiz);
        }
    }

    usort($results, 'comparator');
    $results['totalPts'] = $total;

    return $results;
}

function getCCSpecialistTests(){
    $constants = new Constants();
    $allTests = getColumns();
    $catID = $constants->CCSpeCat;
    $results = [];
    $total = 0;

    foreach ($allTests as $test){
        if ($test->gradebookCategoryId == $catID){
            $quiz = new Test();

            $quiz->ID = $test->id;
            $quiz->name = $test->name;
            $quiz->totalPts = $test->score->possible;
            $quiz->rank = 'Specialist';
            $quiz->rankID = $catID;
            $quiz->contentID = $test->contentId;
            $quiz->needsGrading = NeedsGrades($quiz);
            $total += $quiz->totalPts;

            array_push($results, $quiz);
        }
    }

    usort($results, 'comparator');
    $results['totalPts'] = $total;

    return $results;
}

function getShopSpecialistTests(){
    $constants = new Constants();
    $allTests = getColumns();
    $catID = $constants->ShopSpeCat;
    $results = [];
    $total = 0;

    foreach ($allTests as $test){
        if ($test->gradebookCategoryId == $catID){
            $quiz = new Test();

            $quiz->ID = $test->id;
            $quiz->name = $test->name;
            $quiz->totalPts = $test->score->possible;
            $quiz->rank = 'Specialist';
            $quiz->rankID = $catID;
            $quiz->contentID = $test->contentId;
            $quiz->needsGrading = NeedsGrades($quiz);
            $total += $quiz->totalPts;

            array_push($results, $quiz);
        }
    }

    usort($results, 'comparator');
    $results['totalPts'] = $total;

    return $results;
}

function getAITSpecialistTests(){
    $constants = new Constants();
    $allTests = getColumns();
    $catID = $constants->AITSpeCat;
    $results = [];
    $total = 0;

    foreach ($allTests as $test){
        if ($test->gradebookCategoryId == $catID){
            $quiz = new Test();

            $quiz->ID = $test->id;
            $quiz->name = $test->name;
            $quiz->totalPts = $test->score->possible;
            $quiz->rank = 'Specialist';
            $quiz->rankID = $catID;
            $quiz->contentID = $test->contentId;
            $quiz->needsGrading =  NeedsGrades($quiz);
            $total += $quiz->totalPts;

            array_push($results, $quiz);
        }
    }

    usort($results, 'comparator');
    $results['totalPts'] = $total;

    return $results;
}