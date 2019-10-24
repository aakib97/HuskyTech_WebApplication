<?php
//Import the phpCAS Library
require('./classes/Employee.class.php');

$studentNetID = $_POST['netid'];
$form = $_POST['form'];

switch ($form){
    case 'profile':
        $updatePhoto = $_POST['profilePic'];
        $updateFirst = preg_replace('/\s+/', '', $_POST['first']);
        $updateLast = preg_replace('/\s+/', '', $_POST['last']);
        $updateFull = $updateFirst . " " . $updateLast;
        $updateEmail = preg_replace('/\s+/', '', strtolower($_POST['email']));
        $updateStudentEmail = preg_replace('/\s+/', '', $_POST['StudentEmail']);
        $updateRole = $_POST['rank'];
        $updateGrad = $_POST['grad'];
        $updateACD = $_POST['acd'];
        $updateNotes = $_POST['notes'];

        $employee = findEmployee($studentNetID);

        if ($employee->First != $updateFirst){
            $employee->updateMyInfo('First Name', $updateFirst);
        }

        if ($employee->Last != $updateLast){
            $employee->updateMyInfo('Last Name', $updateLast);
        }

        if ($employee->Full != $updateFull){
            $employee->updateMyInfo('Full Name', $updateFull);
        }

        if ($employee->Email != $updateEmail){
            $employee->updateMyInfo('Email', $updateEmail);
        }

        if ($employee->Grad != $updateGrad){
            $employee->updateMyInfo('Graduation Date', $updateGrad);
        }

        header("Location: profile.php");

        break;

    case 'student':
        $updateFirst = preg_replace('/\s+/', '', $_POST['first']);
        $updateLast = preg_replace('/\s+/', '', $_POST['last']);
        $updateFull = $updateFirst . " " . $updateLast;
        $updateEmail = preg_replace('/\s+/', '', strtolower($_POST['email']));
        $updateStudentEmail = preg_replace('/\s+/', '', $_POST['StudentEmail']);
        $updateRole = $_POST['rank'];
        $updateID = $_POST['blackboardID'];
        $updateTeam = $_POST['team'];
        $updateGrad = $_POST['grad'];
        $updateACD = $_POST['acd'];
        $updateNotes = $_POST['notes'];

        $employee = findEmployee($studentNetID);


        if ($employee->First != $updateFirst){
            $employee->updateMyInfo('First Name', $updateFirst);
        }

        if ($employee->Last != $updateLast){
            $employee->updateMyInfo('Last Name', $updateLast);
        }

        if ($employee->Full != $updateFull){
            $employee->updateMyInfo('Full Name', $updateFull);
        }

        if ($employee->Role != $updateRole){
            $employee->updateMyInfo('Rank', $updateRole);
        }

        if ($employee->blackboardID != $updateID){
            $employee->updateMyInfo('BlackboardID', $updateID);
        }

        if ($employee->Team != $updateTeam){
            $employee->updateMyInfo('Team Selection', $updateTeam);
        }

        if ($employee->Email != $updateEmail){
            $employee->updateMyInfo('Email', $updateEmail);
        }

        if ($employee->StudentEmail != $updateStudentEmail){
            $employee->updateMyInfo('Student Email', $updateStudentEmail);
        }

        if ($employee->Grad != $updateGrad){
            $employee->updateMyInfo('Graduation Date', $updateGrad);
        }

        if ($employee->ACD != $updateACD){
            $employee->updateMyInfo('ACD', $updateACD);
        }

        if ($employee->Notes != $updateNotes){
            $employee->updateMyInfo('Notes', $updateNotes);
        }

        header("Location: manageStudents.php?mesg=updated");

        break;


    case 'addStudent':
        $updateFirst = preg_replace('/\s+/', '', $_POST['first']);
        $updateLast = preg_replace('/\s+/', '', $_POST['last']);
        $updateFull = $updateFirst . " " . $updateLast;
        $updateEmail = preg_replace('/\s+/', '', strtolower($_POST['email']));
        $updateStudentEmail = preg_replace('/\s+/', '', $_POST['StudentEmail']);
        $updateRole = $_POST['rank'];
        $updateGrad = $_POST['grad'];
        $updateACD = $_POST['acd'];
        $updateNotes = $_POST['notes'];

        $employee = newStudent($studentNetID);

        $employee->updateMyInfo('First Name', $updateFirst);
        $employee->updateMyInfo('Last Name', $updateLast);
        $employee->updateMyInfo('Full Name', $updateFull);
        $employee->updateMyInfo('Rank', $updateRole);
        $employee->updateMyInfo('Email', $updateEmail);
        $employee->updateMyInfo('Student Email', $updateStudentEmail);
        $employee->updateMyInfo('Graduation Date', $updateGrad);
        $employee->updateMyInfo('ACD', $updateACD);
        $employee->updateMyInfo('Notes', $updateNotes);

        header("Location: manageStudents.php?added");

        break;

    case 'deleteStudent':
        $temp1  = explode(',',$studentNetID);
        $NetIDArray  = array_slice($temp1, 0, 3);

        for ($i = 0; $i < count($NetIDArray);$i++) {
            $employee = findEmployee($NetIDArray[$i]);

            $employee->deleteMyself();
        }

        header("Location: manageStudents.php?deleted");

        break;

    case 'feedback':
        $name = $_POST['feedbackName'];
        $rank = $_POST['feedbackRank'];
        $tech = $_POST['techName'];
        $type = $_POST['feedbackType'];
        $comments = $_POST['feedbackComments'];

        newFeedback($name,$rank,$tech,$type,$comments);

        header("Location: feedbackForm.php");

        break;

    case 'equipment':
        $name = $_POST['equipmentName'];
        $rank = $_POST['equipmentRank'];
        $supplies = $_POST['equipmentSupplies'];
        $comments = $_POST['equipmentComments'];

        newSupply($name,$rank,$supplies,$comments);

        header("Location: equipmentForm.php");

        break;

    case 'team':
        $name = $_POST['teamName'];
        $rank = $_POST['teamRank'];
        $team = $_POST['team'];
        $meeting = $_POST['teamMeeting'];
        $comments = $_POST['teamComments'];

        newTeam($name,$rank,$team,$meeting,$comments);

        $employee = findEmployee($studentNetID);

        if ($employee->Team != $team){
            $employee->updateMyInfo('Team Selection', $team);
        }

        header("Location: teamSelection.php");

        break;

    case 'equipSub':
        $ID = $_POST['equipmentID'];

        $updateName = $_POST['equipmentName'];
        $updateRank = $_POST['equipmentRank'];
        $updateSupplies = $_POST['equipmentSupplies'];
        $updateComments = $_POST['equipmentComments'];
        $updateStatus = $_POST['equipmentStatus'];
        $updateFeedback = $_POST['equipmentFeedback'];

        $submission = findEntry('Supplies Requested', $ID);

        if ($submission[1] != $updateName){
            updateEntry('Supplies Requests', $ID, 'Name', $updateName);
        }

        if ($submission[3] != $updateSupplies){
            updateEntry('Supplies Requests', $ID, 'Supplies Requested', $updateSupplies);
        }

        if ($submission[4] != $updateComments){
            updateEntry('Supplies Requests', $ID, 'Comments', $updateComments);
        }

        if ($submission[5] != $updateStatus){
            updateEntry('Supplies Requests', $ID, 'Status', $updateStatus);
        }

        if ($submission[6] != $updateFeedback) {
            updateEntry('Supplies Requests', $ID, 'Feedback', $updateFeedback);
        }

        header("Location: equipmentSubmissions.php?updated");

        break;

    case 'deleteSub':
        $ID = $_POST['ID'];

        deleteEntry('Supplies Requests', $ID);

        header("Location: equipmentSubmissions.php?deleted");

        break;

    case 'modalSub':
        $ID = $_POST['modalID'];

        $updateName = $_POST['modalName'];
        $updateRank = $_POST['modalRank'];
        $updateSupplies = $_POST['modalSupplies'];
        $updateComments = $_POST['modalComments'];

        $submission = findEntry('Supplies Requested', $ID);

        if ($submission[1] != $updateName){
            updateEntry('Supplies Requests', $ID, 'Name', $updateName);
        }

        if ($submission[3] != $updateSupplies){
            updateEntry('Supplies Requests', $ID, 'Supplies Requested', $updateSupplies);
        }

        if ($submission[4] != $updateComments){
            updateEntry('Supplies Requests', $ID, 'Comments', $updateComments);
        }

        header("Location: equipmentForm.php?updated");

        break;

    case 'deleteMySub':
        $ID = $_POST['ID'];

        deleteEntry('Supplies Requests', $ID);

        header("Location: equipmentForm.php?deleted");

        break;

    case 'FeedSub':
        $ID = $_POST['feedSubID'];

        $updateName = $_POST['feedSubName'];
        $updateRank = $_POST['feedSubRank'];
        $updateTech = $_POST['feedSubTech'];
        $updateType = $_POST['feedSubType'];
        $updateComments = $_POST['feedSubComments'];

        $submission = findEntry('Student Feedback', $ID);

        if ($submission[1] != $updateName){
            updateEntry('Student Feedback', $ID, 'Name', $updateName);
        }

        if ($submission[3] != $updateTech){
            updateEntry('Student Feedback', $ID, 'Tech Name', $updateTech);
        }

        if ($submission[4] != $updateType){
            updateEntry('Student Feedback', $ID, 'Type', $updateType);
        }

        if ($submission[4] != $updateComments){
            updateEntry('Student Feedback', $ID, 'Comments', $updateComments);
        }

        header("Location: feedbackSubmission.php?updated");

        break;

    case 'deleteFeed':
        $ID = $_POST['ID'];

        deleteEntry('Student Feedback', $ID);

        header("Location:feedbackSubmission.php?deleted");

        break;

    case 'usb':
        $name = $_POST['usbName'];
        $rank = $_POST['usbRank'];
        $ID = $_POST['usbID'];
        $OS = $_POST['usbOS'];
        $comments = $_POST['usbOS'];

        newUSB($ID,$OS,'Available','Working');

        header("Location: USBform.php");

        break;

    case 'windowsUSB':
        $netid = $_POST['netid'];

        $user = findEmployee($netid);

        $USBs = $user->allUSBs();
        $windows = $USBs['Windows'];
        $timestamp = date("Y/m/d h:i:sa");

        foreach($windows as $win){
            $ID = $win[0];
            $OS = $win[1];
            $inventoryStatus = $_POST[$ID . '_ava'];
            $workingStatus = $_POST[$ID . '_work'];

            updateEntry('USB Inventory', $ID, 'Inventory Status', $inventoryStatus);
            updateEntry('USB Inventory', $ID, 'Working Status', $workingStatus);

            newUSBSub($timestamp, $netid, $ID, $OS, $inventoryStatus, $workingStatus);
        }

        header("Location: USBInventoryform.php");

        break;

    case 'macUSB':
        $netid = $_POST['netid'];

        $user = findEmployee($netid);

        $USBs = $user->allUSBs();
        $mojave = $USBs['Mojave'];
        $highsierra = $USBs['High Sierra'];
        $sierra = $USBs['Sierra'];
        $timestamp = date("Y/m/d h:i:sa");

        foreach($mojave as $moj){
            $ID = $moj[0];
            $OS = $moj[1];
            $inventoryStatus = $_POST[$ID . '_ava'];
            $workingStatus = $_POST[$ID . '_work'];

            updateEntry('USB Inventory', $ID, 'Inventory Status', $inventoryStatus);
            updateEntry('USB Inventory', $ID, 'Working Status', $workingStatus);

            newUSBSub($timestamp, $netid, $ID, $OS, $inventoryStatus, $workingStatus);
        }

        foreach($highsierra as $hs){
            $ID = $hs[0];
            $OS = $hs[1];
            $inventoryStatus = $_POST[$ID . '_ava'];
            $workingStatus = $_POST[$ID . '_work'];

            updateEntry('USB Inventory', $ID, 'Inventory Status', $inventoryStatus);
            updateEntry('USB Inventory', $ID, 'Working Status', $workingStatus);

            newUSBSub($timestamp,$netid, $ID, $OS, $inventoryStatus, $workingStatus);
        }

        foreach($sierra as $sie){
            $ID = $sie[0];
            $OS = $sie[1];
            $inventoryStatus = $_POST[$ID . '_ava'];
            $workingStatus = $_POST[$ID . '_work'];

            updateEntry('USB Inventory', $ID, 'Inventory Status', $inventoryStatus);
            updateEntry('USB Inventory', $ID, 'Working Status', $workingStatus);

            newUSBSub($timestamp, $netid, $ID, $OS, $inventoryStatus, $workingStatus);
        }

        header("Location: USBInventoryform.php");

        break;

    case 'linuxUSB':
        $netid = $_POST['netid'];

        $user = findEmployee($netid);

        $USBs = $user->allUSBs();
        $linux = $USBs['Linux'];
        $timestamp = date("Y/m/d h:i:sa");

        foreach($linux as $lin){
            $ID = $lin[0];
            $OS = $lin[1];
            $inventoryStatus = $_POST[$ID . '_ava'];
            $workingStatus = $_POST[$ID . '_work'];

            updateEntry('USB Inventory', $ID, 'Inventory Status', $inventoryStatus);
            updateEntry('USB Inventory', $ID, 'Working Status', $workingStatus);

            newUSBSub($timestamp, $netid, $ID, $OS, $inventoryStatus, $workingStatus);
        }

        header("Location: USBInventoryform.php");

        break;

    case 'fileUSB':
        $netid = $_POST['netid'];

        $user = findEmployee($netid);

        $USBs = $user->allUSBs();
        $fileserver = $USBs['Fileserver'];
        $timestamp = date("Y/m/d h:i:sa");

        foreach($fileserver as $file){
            $ID = $file[0];
            $OS = $file[1];
            $inventoryStatus = $_POST[$ID . '_ava'];
            $workingStatus = $_POST[$ID . '_work'];

            updateEntry('USB Inventory', $ID, 'Inventory Status', $inventoryStatus);
            updateEntry('USB Inventory', $ID, 'Working Status', $workingStatus);

            newUSBSub($timestamp, $netid, $ID, $OS, $inventoryStatus, $workingStatus);
        }

        header("Location: USBInventoryform.php");

        break;

    case 'bootUSB':
        $netid = $_POST['netid'];

        $user = findEmployee($netid);

        $USBs = $user->allUSBs();
        $Bootcamp = $USBs['Bootcamp'];
        $timestamp = date("Y/m/d h:i:sa");

        foreach($Bootcamp as $bc){
            $ID = $bc[0];
            $OS = $bc[1];
            $inventoryStatus = $_POST[$ID . '_ava'];
            $workingStatus = $_POST[$ID . '_work'];

            updateEntry('USB Inventory', $ID, 'Inventory Status', $inventoryStatus);
            updateEntry('USB Inventory', $ID, 'Working Status', $workingStatus);

            newUSBSub($timestamp, $netid, $ID, $OS, $inventoryStatus, $workingStatus);
        }

        header("Location: USBInventoryform.php");

        break;

    default:

        header("Location: dashboard.php");

        break;
}