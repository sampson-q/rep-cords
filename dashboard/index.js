// dashboard js

(function () {

    let swapView = (container0, container1) => {
        document.getElementById(container0).style = "display: none;";
        document.getElementById(container1).style = "display: block;";
    }

    let NavMessage = (navMessage) => {
        document.getElementById('navar').innerHTML = "<span class='h6'>" + navMessage + "</span>";
    }

    // view home of dashboard
    var HomeButton = document.getElementById('home');
    if (HomeButton) {
        HomeButton.addEventListener('click', function () {
            document.getElementById('ViewClassPage').style = "display: none";
            document.getElementById('AddClassForm').style = "display: none";
        });
    }

    // view attendance
    /*var Attendance = document.getElementById('attendance');
    if (Attendance) {
        Attendance.addEventListener('click', function () {
            var ClassAttendance = document.getElementById('attendance-class').value;
            var ClassType = document.getElementById('classType').value;
            var ClassBin;

            alert(ClassType);
            if (ClassType == 'sharedClassType') { ClassBin = 1 }
            else if (ClassType == 'ownedClassType') {ClassBin = 0 }
            else {alert('There is an error: ' + ClassBin)}
            
            $.ajax({
                url: 'index.php',
                method: 'POST',
                data: {
                   classtype: ClassBin,
                   classnameattendance: ClassAttendance
                },
                complete: function (feed) {
                    alert(feed.responseText);
                }
            });
        });

        swapView('DashHome', 'ViewAttendance')
    }*/
    
    // function to switch to add-new-class form
    var AddClassPage = document.getElementById('addclass');
    if (AddClassPage) {
        AddClassPage.addEventListener('click', function () {
            swapView('DashHome', 'AddClassForm');
            NavMessage('Add A Class');
        });
    }


    // function to views all classes for the user
    var ViewClassPage = document.getElementById('viewclass');
    if (ViewClassPage) {
        ViewClassPage.addEventListener('click', function () {
            swapView('DashHome', 'ViewClassPage');
            NavMessage('My Classes');
        });
    }

    // function adds a class
    var AddClassButton = document.getElementById('addclassbutton');
    if (AddClassButton) {
        AddClassButton.addEventListener('click', function () {
            var ClassName = document.getElementById('addclassname').value;
            if (ClassName.indexOf('_') < 0) {
                if (ClassName != '') {
                    $.ajax({
                        url: '../controllers/ClassTransactions.php',
                        method: 'POST',
                        data: {
                            WhatToDo: 'add_class',
                            classname: ClassName
                        },
                        complete: function (feedback) {
                            if (feedback.responseText === 'class_halfname_empty') {
                                alert('Provide Class Name!');
                            }

                            if (feedback.responseText === 'class_created') {
                                alert('Class Created');
                            }

                            if (feedback.responseText === 'class_details !added') {
                                alert('Class Error!');
                            }

                            if (feedback.responseText === 'class !created') {
                                alert('Class Error!');
                            }

                            if (feedback.responseText === 'class_exist') {
                                alert('Class Already Exist!');
                            }

                            //alert(feedback.responseText);
                        }
                    });
                } else {
                    alert('Provide Class Name!');
                }
            } else {
                alert('Hyphens are not allowed');
            }
        });
    }

    // switches to add-class-form
    var ClassAdd = document.getElementById('classadd');
    if (ClassAdd) {
        ClassAdd.addEventListener('click', function () {
            swapView('ViewClassPage', 'AddClassForm');
            NavMessage('Add A Class');
        });
    }

    // delete class button
    var ConfirmDeleteClass = document.getElementById('proceedclassremov');
    if (ConfirmDeleteClass) {
        ConfirmDeleteClass.addEventListener('click', function () {
            var classname0 = document.getElementById('class2rem').value;
            $.ajax({
                url: '../controllers/ClassTransactions.php',
                method: 'POST',
                data: {
                    WhatToDo: 'remove_class',
                    classname: classname0
                },
                complete: function (feed) {
                    if (feed.responseText === 'class_removed') {
                        alert(classname0 + ' removed!');
                    }

                    //alert(feed.responseText);
                    window.location.href = '../dashboard';
                }
            });
        });
    }

    // delete an attendance
    var ConfirmRemoveAttendance = document.getElementById('proceedattrem');
    if (ConfirmRemoveAttendance) {
        ConfirmRemoveAttendance.addEventListener('click', function () {
            var AttendanceToRemove = document.getElementById('att2rem').value;
            var AttendanceToMove = document.getElementById('att2move').value;
            $.ajax({
                url : '../controllers/ClassTransactions.php',
                method: 'POST',
                data: {
                    att2rem: AttendanceToRemove,
                    att2move: AttendanceToMove
                },
                complete: function (feed) {
                    if (feed.responseText == 'attend_removed') {
                        alert("Attendance Removed!");
                    }
                    window.location.href = "../dashboard";

                    //alert(feed.responseText);
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
                            url: '../controllers/ClassTransactions.php',
                            method: 'POST',
                            data: {
                                WhatToDo: 'add_member',
                                classname: MemberAddClass,
                                membername: StudentName,
                                memberid: StudentId
                            },
                            complete: function (feed) {
                                if (feed.responseText === 'member_added') {
                                    alert(StudentName + ' successfuly added');
                                }
            
                                if (feed.responseText === 'member_exist') {
                                    alert('Member with ID \"' + StudentId + '\", is already a member');
                                }
                                //(feed.responseText);
                                window.location.reload() = true;
                            }
                        });
                    } else { alert('Provide Student Name!'); }
                } else { alert('Student ID should be 9!'); }
            } else { alert('Provide Student ID!'); }
        });
    }

    // update class member information
    var UpdateMember = document.getElementById('update');
    if (UpdateMember) {
        UpdateMember.addEventListener('click', function () {
            var MemberUpdateClass = document.getElementById('memberupdateclass').value;
            var UpdateName = document.getElementById('updatestudentname').value;
            var UpdateID = document.getElementById('updatestudentid').value;
            var BackupName = document.getElementById('backupname').value;
            var BackupID = document.getElementById('backupid').value;
            var sn = document.getElementById('sntoupdate').value;
            
            if (UpdateID != '') {
                if (UpdateID.length == 9) {
                    if (UpdateName != '') {
                        if (BackupID == UpdateID && BackupName == UpdateName) {
                            alert('No Changes detected!');
                        } else {
                            $.ajax({
                                url: '../controllers/ClassTransactions.php',
                                method: 'POST',
                                data: {
                                    WhatToDo: 'update_member',
                                    classname: MemberUpdateClass,
                                    membername: UpdateName,
                                    memberid: UpdateID,
                                    recordtoupdate: sn
                                },
                                complete: function (feed) {
                                    if (feed.responseText === 'member_updated') {
                                        alert('Member successfuly updated');
                                    }

                                    if (feed.responseText === 'member_exist') {
                                        alert("\"" + UpdateID + "\"" + " is already belongs to another student");
                                    }
    
                                    //alert(feed.responseText);
                                }
                            });
                        }
                    } else { alert('Provide Student Name!'); }
                } else { alert('Student ID should be 9!'); }
            } else { alert('Provide Student ID!'); }
        });
    }
    
    // update course details
    var CourseUpdate = document.getElementById('courseupdate');
    if (CourseUpdate) {
        CourseUpdate.addEventListener('click', function () {
            var UpdateCourseCode = document.getElementById('updatecoursecode').value;
            var UpdateCourseName = document.getElementById('updatecoursename').value;
            var UpdateLectName = document.getElementById('updatelectname').value;
            var RecordForUpdate = document.getElementById('recforup').value;
            $.ajax({
                url: '../controllers/CourseTransactions.php',
                method: 'POST',
                data: {
                    coursecode: UpdateCourseCode,
                    coursename: UpdateCourseName,
                    courselect: UpdateLectName,
                    courseid: RecordForUpdate,
                    WhatToDo: 'update_course'
                },
                complete: function (feed) {
                    if (feed.responseText == 'course_updated') {
                        alert('Course Update Successfull!');
                    }
                    
                    //alert(feed.responseText);
                }
            });
        });
    }

    // remove member from class
    var RemoveMember = document.getElementById('proceedmemremov');
    if (RemoveMember) {
        RemoveMember.addEventListener('click', function () {
            var RecordToRemove = document.getElementById('recordtoremove').value;
            var ClassForRecord = document.getElementById('class2delete').value;
            $.ajax({
                url: '../controllers/ClassTransactions.php',
                method: 'POST',
                data: {
                    WhatToDo: 'remove_member',
                    recordtoupdate: RecordToRemove,
                    classname: ClassForRecord,
                },
                complete: function (feed) {
                    if (feed.responseText == 'member_removed') {
                        alert('Member Removed');
                    }

                    window.location.href = '../dashboard';
                    //alert(feed.responseText);
                }
            });
        });
    }

    // views user's shared classes
    var SharedClass = document.getElementById('shared-class');
    if (SharedClass) {
        SharedClass.addEventListener('click', function () {
            swapView('DashHome', 'SharedClasses');
            NavMessage('My Shared Classes');
        });
    }

    // view share-a-class div
    var ShareAClass = document.getElementById('shareaclass');
    if (ShareAClass) {
        ShareAClass.addEventListener('click', function () {
            swapView('SharedClasses', 'ShareAClass');
            NavMessage('Share A Class');
        });
    }

    // proceed with unsharing of class
    var UnshareClass = document.getElementById('proceedunshare');
    if (UnshareClass) {
        UnshareClass.addEventListener('click', function () {
            var Class2Unshare = document.getElementById('classtounshare').value;
            //alert("This is the class id: " + Class2Unshare);
            $.ajax ({
                url: '../controllers/ClassTransactions.php',
                method: 'POST',
                data: {
                    WhatToDo: 'unshare_class',
                    classid: Class2Unshare
                },
                complete: function (feed) {
                    if (feed.responseText == 'class_unshared') {
                        alert('Detach Successful');
                        window.location.href = '../dashboard';
                    }

                    //alert(feed.responseText);
                }
            });
        });
    }

    // unregister course
    var UnregisterCourse = document.getElementById('proceedcourserem');
    if (UnregisterCourse) {
        UnregisterCourse.addEventListener('click', function () {
            var CourseToRemove = document.getElementById('recordtoremove').value;
            $.ajax({
                url: '../controllers/CourseTransactions.php',
                method: 'POST',
                data: {
                    WhatToDo: 'unregister_course',
                    courseid: CourseToRemove
                },
                complete: function (feed) {
                    if (feed.responseText == 'course_unregistered') {
                        alert('Course Unregistered!');
                    }

                    window.location.href = '../dashboard';
                    //alert(feed.responseText);
                }
            });
        });
    }

    // proceed to sharing of class
    var ProceedShare = document.getElementById('proceedshareclass');
    if (ProceedShare) {
        ProceedShare.addEventListener('click', function () {
            var ShareTo = document.getElementById('shareclass1').value;
            var ToShare = document.getElementById('classshare').value;
            var ShareBy = document.getElementById('shareby').value;

            if (ShareTo == ShareBy) {
                alert('You can\'t share this class to yourself');
            } else {
                $.ajax ({
                    url: '../controllers/ClassTransactions.php',
                    method: 'POST',
                    data: {
                        WhatToDo: 'share_class',
                        repid: ShareTo,
                        classname: ToShare
                    },
                    complete: function (feed) {
                        if (feed.responseText == 'class_already_shared') {
                            alert("\"" + ToShare + '"  has already been shared to  "' + ShareTo + "\"");
                        }

                        if (feed.responseText == 'class_shared') {
                            alert("\"" + ToShare + '"  is now shared with "' + ShareTo + "\"");
                        }

                        if (feed.responseText == 'member_not_exist') {
                            alert('User with ID  "' + ShareTo + '"  does not exist');
                        }

                        if (feed.responseText == 'class_unsharedd') {
                            alert('Class Sharing Error. Try again');
                        }

                        window.location.href = '../dashboard';
                        alert(feed.responseText);
                    }
                });
            }
        })
    }

    // view classes shared to user
    var ImportedClass = document.getElementById('inheritted-class');
    if (ImportedClass) {
        ImportedClass.addEventListener('click', function () {
            swapView('DashHome', 'import-classes');
            NavMessage('My Received Classes');
        });
    }

    // take attendance
    var TakeAttendance = document.getElementById('takeattendance');
    if (TakeAttendance) {
        TakeAttendance.addEventListener('click', function () {
            swapView('DashHome', 'TakeAttendance');
            swapView('ViewAttendance', 'TakeAttendance');
        });
    }


    // courses
    var Courses = document.getElementById('courses');
    if (Courses) {
        Courses.addEventListener('click', function () {
            swapView('DashHome', 'Courses');
            NavMessage('My Courses');
        });
    }

    //show attendance
    var ShowAttendance = document.getElementById('showatt');
    if (ShowAttendance) {
        ShowAttendance.addEventListener('click', function () {
            swapView('DashHome', 'ShowAttendance');
            NavMessage('View Attendances');
        });
    }
    
    // registers courses
    var RRegisterCourses = document.getElementById('registercoursebutton');
    if (RRegisterCourses) {
        RRegisterCourses.addEventListener('click', function () {
            var CourseName = document.getElementById('coursename').value;
            var CourseCode = document.getElementById('courseCode').value;
            var LecturerNa = document.getElementById('lEctName').value;

            if (CourseCode != '' && CourseName != '' && LecturerNa != '') {
                $.ajax({
                    url: '../controllers/CourseTransactions.php',
                    method: 'POST',
                    data: {
                        WhatToDo: 'register_course',
                        coursename: CourseName,
                        coursecode: CourseCode,
                        courselect: LecturerNa
                    },
                    complete: function (feed) {
                        if (feed.responseText == 'course_registered') {
                            alert('Course Registered');
                        }
                        
                        window.location.href = '../dashboard';
                        //alert(feed.responseText);
                    }
                });
            } else {
                alert('Fill all fields');
            }
        });
    }

})();