(function($) {
    "use strict"; // Start of use strict

    $(document).ready(function () {
        // language=JQuery-CSS
        $('#navbar').load('navbar.php');
        $('#sidebar').load('sidebar.php');
        $('#scrollUp').load('pageUp.html');
    });

    $(document).ready(function () {
        // language=JQuery-CSS
        var pageHeight = $('#body').height();
        $('#sidebar').height(pageHeight);

    });

    $(document).ready(function () {
        let callOuts = parseInt($('#calloutNum').text(), 10);
        let pickUps = parseInt($('#pickupNum').text(), 10);

        if (callOuts > 5) {
            $('#calloutIco').css('color', 'red');
        }
        if (pickUps > 5) {
            $('#pickupIco').css('color', 'green');
        }
    });

    $(document).ready(function () {
        $('#links').on('shown.bs.collapse',  function(){
            setTimeout(
                function () {
                    $('#links').collapse('hide')
                }, 120000
            );
        });

        $('#adv').on('shown.bs.collapse',  function(){
            setTimeout(
                function () {
                    $('#adv').collapse('hide')
                }, 120000
            );
        });

        $('#refs').on('shown.bs.collapse',  function(){
            setTimeout(
                function () {
                    $('#refs').collapse('hide')
                }, 120000
            );
        });

        $('#boot').on('shown.bs.collapse',  function(){
            setTimeout(
                function () {
                    $('#boot').collapse('hide')
                }, 120000
            );
        });
    });

    $(document).ready(function () {
        // language=JQuery-CSS
        var page = $(document)[0].title;
        if (page == "Call Center Training"){
            let Q1 = $('#Q1Ico');
            let Q2 = $('#Q2Ico');
            let Q3 = $('#Q3Ico');
            let Q4 = $('#Q4Ico');
            let Quizzes = [Q1, Q2, Q3, Q4];
            let completed = 0;

            for (let i = 0; i < 4; i++) {
                if (Quizzes[i].attr('class') === "far fa-check-square") {
                    $(Quizzes[i]).css('color','green');
                    completed++;
                }
            }

            let progressNum = (completed / Quizzes.length) * 100;
            let progressStr = progressNum.toString(10).concat("%");

            $('#progBar').width(progressStr);
        } else {
            let Q1 = $('#Q1Ico');
            let Q2 = $('#Q2Ico');
            let Q3 = $('#Q3Ico');
            let Q4 = $('#Q4Ico');
            let Q5 = $('#Q5Ico');
            let Q6 = $('#Q6Ico');
            let Q7 = $('#Q7Ico');
            let Q8 = $('#Q8Ico');
            let Quizzes = [Q1, Q2, Q3, Q4, Q5, Q6, Q7, Q8];
            let completed = 0;

            for (let i = 0; i < Quizzes.length; i++) {
                if (Quizzes[i].attr('class') === "far fa-check-square") {
                    $(Quizzes[i]).css('color','green');
                    completed++;
                }
            }

            let progressNum = (completed / Quizzes.length) * 100;
            let progressStr = progressNum.toString(10).concat("%");

            $('#progBar').width(progressStr);
        }
    });

    $(document).ready(function () {
        $('#students').change(function () {
            if ($("#students option:selected").val() === "") {
                $("#load").prop('disabled', true);
            } else {
                $("#load").prop('disabled', false);
            }
        });

        $(document).ready(function () {
            if ($("#students option:selected").val() === "") {
                $("#load").prop('disabled', true);
            } else {
                $("#load").prop('disabled', false);
            }
        });
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
})(jQuery); // End of use strict

function supplyModal(button) {
    var ID = $(button).attr('id');

    $('#equipmentID').attr('value', '');
    $('#equipmentName').attr('value', '');
    $('#equipmentRank').attr('value', '');
    $('#equipmentSupplies').attr('value', '');
    $('#equipmentComments').attr('value', '');
    $('#equipmentStatus').attr('value', '');
    $('#equipmentFeedback').attr('value', '');

    $.ajax({
        url: "loadInformation.php",
        type: "post",
        method: "post",
        data: {'form': 'modalSupply', 'argument': ID},
        success: function (data) {
            var dataArray = JSON.parse(data)
            $('#equipmentID').attr('value', dataArray.ID);
            $('#equipmentName').attr('value', dataArray.name);
            $('#equipmentRank').attr('value', dataArray.rank);
            $('#equipmentSupplies').attr('value', dataArray.supplies);
            $('#equipmentComments').val(dataArray.comments)
            $('#equipmentStatus').val(dataArray.status);
            $('#equipmentFeedback').val(dataArray.feedback)
        }
    });
}

function feedbackModal(button) {
    var ID = $(button).attr('id');
    $('#feedSubID').attr('value', '');
    $('#feedSubName').attr('value', '');
    $('#feedSubRank').attr('value', '');
    $('#feedSubTech').attr('value', '');
    $('#feedSubType').val('');
    $('#feedSubComments').val('');

    $.ajax({
        url: "loadInformation.php",
        type: "post",
        method: "post",
        data: {'form': 'feedSub', 'argument': ID},
        success: function (data) {
            var dataArray = JSON.parse(data)
            $('#feedSubID').attr('value', dataArray.ID);
            $('#feedSubName').attr('value', dataArray.name);
            $('#feedSubRank').attr('value', dataArray.rank);
            $('#feedSubTech').attr('value', dataArray.tech);
            $('#feedSubType').val( dataArray.type);
            $('#feedSubComments').val(dataArray.comments);
        }
    });
}

function mysupplyModal(button) {
    var ID = $(button).attr('id');
    $('#modalID').attr('value', '');
    $('#modalName').attr('value', '');
    $('#modalRank').attr('value', '');
    $('#modalSupplies').attr('value', '');
    $('#modalComments').attr('value', '');
    $('#modalStatus').attr('value', '');
    $('#modalFeedback').attr('value', '');

    $.ajax({
        url: "loadInformation.php",
        type: "post",
        method: "post",
        data: {'form': 'mymodalSupply', 'argument': ID},
        success: function (data) {
            var dataArray = JSON.parse(data)
            $('#modalID').attr('value', dataArray.ID);
            $('#modalName').attr('value', dataArray.name);
            $('#modalRank').attr('value', dataArray.rank);
            $('#modalSupplies').attr('value', dataArray.supplies);
            $('#modalComments').val(dataArray.comments)
            $('#modalStatus').val(dataArray.status);
            $('#modalFeedback').val(dataArray.feedback)
        }
    });
}

function infoModal(button) {
    var employeeNetID = $(button).attr('id');

    $('#first').attr('value', '');
    $('#last').attr('value', '');
    $('#full').attr('value', '');
    $('#NetID').attr('value', '');
    $('#blackboardID').attr('value', '');
    $('#role').val('');
    $('#team').val('');
    $('#email').attr('value', '');
    $('#StudentEmail').attr('value','');
    $('#Grad').attr('value', '');
    $('#ACD').attr('value', '');
    $('#notes').val('');

    $.ajax({
        url: "loadInformation.php",
        type: "post",
        method: "post",
        data: {'form': 'modalStudent', 'argument': employeeNetID},
        success: function (data) {
            var dataArray = JSON.parse(data)
            $('#first').attr('value', dataArray.first);
            $('#last').attr('value', dataArray.last);
            $('#full').attr('value', dataArray.full);
            $('#NetID').attr('value', employeeNetID);
            $('#blackboardID').attr('value', dataArray.ID);
            $('#role').val(dataArray.rank);
            $('#team').val(dataArray.team);
            $('#email').attr('value', dataArray.email);
            $('#StudentEmail').attr('value', dataArray.StudentEmail);
            $('#Grad').attr('value', dataArray.grad);
            $('#ACD').attr('value', dataArray.acd);
            $('#notes').val(dataArray.notes);
        }
    });
}

function syncUsers(button){
    $('#syncEmployeeModal').modal({
        backdrop: "static",
        keyboard: false
    });

    $.ajax({
        url: "loadInformation.php",
        type: "post",
        method: "post",
        data: {'form': 'sync'},
        success: function (data) {
            location.reload()
        }
    });
}

function deleteWorker(button) {
    var employeeNetID = $(button).attr('id');

    $('#deleteID').attr('value', employeeNetID);
}

function workerCheck(){
    var checkboxs = $('table tbody input[type="checkbox"]');
    var netids = new Array();

    checkboxs.each( function () {
        if (this.checked == true){
            var employeeNetID = $(this).attr('id');
            netids.push(employeeNetID);
        }
    })

    $('#deleteID').attr('value', netids);
}

function selectAll(checkAll) {
    var checkboxs = $('table tbody input[type="checkbox"]');
    var netids = new Array();

    table = document.getElementById("workerTable");
    tr = table.getElementsByTagName("tr");

    if (checkAll.checked == true) {
        for (var i = 1; i < tr.length; i++) {
            if ($(tr)[i].style.display === "") {
                var j = i-1;

                var employeeNetID = checkboxs[j].getAttribute('id');
                netids.push(employeeNetID);

                checkboxs[j].checked = true;
            }
        }
    } else {
        checkboxs.each(function () {
            this.checked = false;
        })
    }

    $('#deleteID').attr('value', netids);
}

function autoGenerate(){
    let fn = $('#fname').val();
    let ln = $('#lname').val();
    let rank = $('#stuRole').val();

    if (fn || ln) {
        $('#fullname').attr('value', fn + ' ' + ln);
        $('#EMail').attr('value', fn + '.' + ln + '@uconn.edu');
    } else {
        $('#fullname').attr('value', '');
        $('#EMail').attr('value', '');
    }

    if (rank === 'FTE') {
        $('#stuEmail').attr('value', 'N/A');
        $('#acd').attr('value', 'X');
        $('#graduation').attr('value', 'X');
    } else {
        $('#stuEmail').attr('value', '');
        $('#acd').attr('value', '');
        $('#graduation').attr('value', '');
    }
}