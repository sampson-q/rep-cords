// dashboard js

(function () {

    let swapView = (container0, container1) => {
        document.getElementById(container0).style = "display: none;";
        document.getElementById(container1).style = "display: block;";
    }


    // view home of dashboard
    var HomeButton = document.getElementById('home');
    if (HomeButton) {
        HomeButton.addEventListener('click', function () {
            document.getElementById('ViewClassPage').style = "display: none";
            document.getElementById('AddClassForm').style = "display: none";
        });
    }

    // function to switch to add-new-class form
    var AddClassPage = document.getElementById('addclass');
    if (AddClassPage) {
        AddClassPage.addEventListener('click', function () {
            swapView('DashHome', 'AddClassForm')
        });
    }


    // function to views all classes for the user
    var ViewClassPage = document.getElementById('viewclass');
    if (ViewClassPage) {
        ViewClassPage.addEventListener('click', function () {
            swapView('DashHome', 'ViewClassPage');
            $.ajax({
                url: 'index.php',
                method: 'POST', 
                data: {DisplayClasses: 'DisplayClass'}
            });
        });
    }

    // function adds a class
    var AddClassButton = document.getElementById('addclassbutton');
    if (AddClassButton) {
        AddClassButton.addEventListener('click', function () {
            var ClassName = document.getElementById('addclassname').value;
            
            if (ClassName != '') {
                $.ajax({
                    url: '../controllers/DashBoard.php',
                    method: 'POST',
                    data: {classname: ClassName},
                    complete: function (feedback) {
                        if (feedback.responseText === 'class_added') {
                            alert('Class Added!');
                        }

                        if (feedback.responseText === 'add_class_error') {
                            alert('Class Error! Class may already exist.');
                        }

                        if (feedback.responseText === 'class_exists') {
                            alert('Class Already Exist!');
                        }

                        //alert(feedback.responseText);
                    }
                });
            } else {
                alert('Provide Class Name!');
            }
        });
    }

    var ClassAdd = document.getElementById('classadd');
    if (ClassAdd) {
        ClassAdd.addEventListener('click', function () {
            swapView('ViewClassPage', 'AddClassForm')
        });
    }
})();