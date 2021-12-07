// dashboard js

(function () {
    // function to switch to create-new-class form
    var CreateClassButton = document.getElementById('createclassbutton');
        if (CreateClassButton) {
            CreateClassButton.addEventListener('click', function () {
                swapView('dashHome', 'CreateClassForm');
            });
        }

        // function helps to submit class name for new class creation
        var SubmitClassName = document.getElementById('createclass_button');
        if (SubmitClassName) {
            SubmitClassName.addEventListener('click', function () {
                var className = document.getElementById('classname').value;
                if (className !== '') {
                    $.ajax({
                        url: '../controllers/DashBoard.php',
                        method: 'POST',
                        data: {classname: className},
                        complete: function (feed) {
                            if (feed.responseText === 'class_success') {
                                alert("Class Created")
                            }

                            if (feed.responseText === 'class_error') {
                                alert('class not created');
                            }

                            if (feed.responseText == 'empty_class_name') {
                                alert("Provide Class Name!");
                            }
                        }
                    });
                } else {
                    alert("Empty Field! Provide class name!");
                }
            });
        }

})();