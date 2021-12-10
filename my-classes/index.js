(function () {
    let swapView = (container0, container1) => {
        document.getElementById(container0).style = "display: none;";
        document.getElementById(container1).style = "display: block;";
    }

    // delete class button
    var ConfirmDeleteClass = document.getElementById('proceedclassremov');
    if (ConfirmDeleteClass) {
        ConfirmDeleteClass.addEventListener('click', function () {
            var classtoremove = document.getElementById('class2delete').value;
            var classname0 = document.getElementById('classname').value;
            $.ajax({
                url: '../models/ClassTransactions.php',
                method: 'POST',
                data: {
                    ClasstoDelete: classtoremove,
                    ClassName: classname0
                },
                complete: function (feed) {
                    if (feed.responseText === 'class_removed') {
                        alert(classname0 + ' removed!');
                    }

                    window.location.href = '../dashboard';
                }
            });
        });
    }

    // cancel class delete button
    var CancelDeleteClass = document.getElementById('cancelclassremove');
    if (CancelDeleteClass) {
        CancelDeleteClass.addEventListener('click', function () {
            window.location.href = "../dashboard";
        });
    }

    // views add-member-to-class form
    var AddClassMembers = document.getElementById('addmember');
    if (AddClassMembers) {
        AddClassMembers.addEventListener('click', function () {
            swapView('ViewClassMembers', 'AddClassMembers');
        })
    }

    // adds member to a class
    var AddMember = document.getElementById('addmemberbutton');
    if (AddMember) {
        AddMember.addEventListener('click', function () {
            var MemberAddClass = document.getElementById('memberaddclass').value;
            var StudentName = document.getElementById('addstudentname').value;
            var StudentId = document.getElementById('addstudentid').value;
            
            if (StudentId != '') {
                if (StudentId.length == 9) {
                    if (StudentName != '') {
                        $.ajax({
                            url: '../models/ClassTransactions.php',
                            method: 'POST',
                            data: {
                                classforadd: MemberAddClass,
                                personforadd: StudentName,
                                personidforadd: StudentId
                            },
                            complete: function (feed) {
                                if (feed.responseText === 'member_added') {
                                    alert(StudentName + ' successfuly added');
                                }
            
                                if (feed.responseText === 'member_exists') {
                                    alert('Member with ID ' + StudentId + ', is already a member');
                                }

                                alert(feed.responseText);
                            }
                        });
                    } else { alert('Provide Student Name!'); }
                } else { alert('Student ID should be 9!'); }
            } else { alert('Provide Student ID!'); }
        });
    }
})();