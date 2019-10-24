<?php

class Basic{
    public $parentFolder;
    public $deptFolder;
    public $modules;
    public $moduleMaterials;

}

class Module{
    public $title;
    public $quizzes;
    public $materials;
}

class Test{
    public $ID;
    public $name;
    public $totalPts;
    public $graded;
    public $needsGrading;
    public $rank;
    public $rankID;
}

class userAttempt{
    public $testName;
    public $testID;
    public $score;
    public $status;
}