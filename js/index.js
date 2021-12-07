/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function () {
    let getFieldValue = (id) => {
        return document.getElementById(id).value;
    };
    
    function getPersonDetails() {
        return {
            firstname: getFieldValue('firstname'),
            middlename: getFieldValue('middlename'),
            lastname: getFieldValue('lastname'),
            studentemail: getFieldValue('studentemail'),
            studentlevel: getFieldValue('studentlevel'),
            programme: getFieldValue('programme'),
            class: getFieldValue('class'),
            studentid: getFieldValue('studentid'),
            password: getFieldValue('password'),
            confirmpassword: getFieldValue('confirmpassword'),
        };
    }

    function getLoginDetails() {
        return {
            username: getFieldValue('username'),
            password: getFieldValue('password'),
        };
    }
    
    var SignUpButton = document.getElementById('signup_button');
    if (SignUpButton) {
        SignUpButton.addEventListener('click', function () {
            var person = getPersonDetails();
            if (person.firstname !== '' && person.lastname !== '' && person.studentemail !== '' && person.studentlevel !== '' && person.programme !== '' && person.class !== '' && person.studentid !== '' && person.password !== '' && person.confirmpassword !== '') {
                if (checkStudentID(person.studentemail, person.studentid)) {
                    if (confirmPassword(person.password, person.confirmpassword)) {
                        if (validatePassword() === true) {
                            $.ajax({
                                url: '../controllers/SignUp.php',
                                method: 'POST',
                                data: {
                                    firstname: person.firstname,
                                    lastname: person.lastname,
                                    class: person.class,
                                    programme: person.programme,
                                    studentlevel: person.studentlevel,
                                    studentemail: person.studentemail,
                                    studentid: person.studentid,
                                    password: person.password,
                                    middlename: person.middlename,
                                    confirmpassword: person.confirmpassword
                                },
                                complete: function (feedback) {

                                    if (feedback.responseText === 'account_created') {
                                        $.ajax({
                                            url: '../controllers/SignUp.php',
                                            method: 'POST',
                                            data: {signup_issue: '<div id="message" class="alert alert-success alert-dismissible"><strong>Success!</strong> Account created. <a href="../log-in">Login here...</a><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                                        });
                                    }

                                    if (feedback.responseText === 'account_error') {
                                        $.ajax({
                                            url: '../controllers/SignUp.php',
                                            method: 'POST',
                                            data: {signup_issue: '<div id="message" class="alert alert-danger alert-dismissible"><strong>Account Error!</strong> Failed to create Account<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                                        });
                                    }

                                    if (feedback.responseText === 'table_not_created') {
                                        $.ajax({
                                            url: '../controllers/SignUp.php',
                                            method: 'POST',
                                            data: {signup_issue: '<div id="message" class="alert alert-danger alert-dismissible"><strong>Class Error!</strong> Class not Created!<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                                        });
                                    }

                                    if (feedback.responseText === 'account_exists') {
                                        $.ajax({
                                            url: '../controllers/SignUp.php',
                                            method: 'POST',
                                            data: {signup_issue: '<div id="message" class="alert alert-danger alert-dismissible"><strong>Account Error!</strong> Account already exists <a href="../log-in">Login here...</a><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                                        });
                                    }

                                    if (feedback.responseText === 'person_error') {
                                        $.ajax({
                                            url: '../controllers/SignUp.php',
                                            method: 'POST',
                                            data: {signup_issue: '<div id="message" class="alert alert-danger alert-dismissible"><strong>Account Error!</strong> Failed to save your details<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                                        });
                                    }

                                    if (feedback.responseText === 'empty_fields') {
                                        $.ajax({
                                            url: '../controllers/SignUp.php',
                                            method: 'POST',
                                            data: {signup_issue: '<div id="message" class="alert alert-danger alert-dismissible"><strong>Empty Fields!</strong> Fill out required fields from SignUp.php<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                                        });
                                    }

                                    window.location.reload();
                                }
                            });
                        } else {
                            $.ajax({
                                url: '../controllers/SignUp.php',
                                method: 'POST',
                                data: {signup_issue: '<div id="message" class="alert alert-danger alert-dismissible">Weak Password. Mustbe 8, have UPPER/lower case and numbers!<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                            });
                        }
                    } else {
                        $.ajax({
                            url: '../controllers/SignUp.php',
                            method: 'POST',
                            data: {signup_issue: '<div id="message" class="alert alert-danger alert-dismissible"><strong>Password Error!</strong> Passwords do not match!<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                        });
                    }
                } else {
                    $.ajax({
                        url: '../controllers/SignUp.php',
                        method: 'POST',
                        data: {signup_issue: '<div id="message" class="alert alert-danger alert-dismissible"><strong>ID Mismatch!</strong> ID Prefix in mail do not match Student ID<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                    });
                }
            } else {
                $.ajax({
                    url: '../controllers/SignUp.php',
                    method: 'POST',
                    data: {signup_issue: '<div id="message" class="alert alert-danger alert-dismissible"><strong>Empty Fields!</strong> Fill out required fields<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                });
            }
        });
    }

    var LogInButton = document.getElementById('login_button');
    if (LogInButton) {
        LogInButton.addEventListener('click', function () {
            var AccountDetails = getLoginDetails();
            if (AccountDetails.username !== '' && AccountDetails.password !== '') {
                $.ajax({
                    url: '../controllers/LogIn.php',
                    method: 'POST',
                    data: {
                        username: AccountDetails.username,
                        password: AccountDetails.password
                    },
                    complete: function (feed) {

                        if (feed.responseText === 'login_success') {
                            window.location.href = "../dashboard";
                        }

                        if (feed.responseText === 'wrong_credentials') {
                            $.ajax({
                                url: '../controllers/LogIn.php',
                                method: 'POST',
                                data: {login_issue: '<div id="message" class="alert alert-danger alert-dismissible">Wrong username or password!<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                            });
                        }

                        if (feed.responseText === '!account') {
                            $.ajax({
                                url: '../controllers/LogIn.php',
                                method: 'POST',
                                data: {login_issue: '<div id="message" class="alert alert-danger alert-dismissible">Account not Found!<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                            });
                        }
                        //window.location.reload();
                    }
                });
            } else {
                $.ajax({
                    url: '../controllers/LogIn.php',
                    method: 'POST',
                    data: {login_issue: '<div id="message" class="alert alert-danger alert-dismissible"><strong>Empty Fields!</strong> All Fields Required<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'}
                });
            }
        });
    }

    setTimeout(() => {
        $.ajax({
            url: '../controllers/SignUp.php',
            method: 'POST',
            data: {signup_issue: ''}
        });

        $.ajax({
            url: '../controllers/LogIn.php',
            method: 'POST',
            data: {login_issue: ''}
        });

        document.getElementById('message').style = 'display: none;';
    }, 5000);

    let checkPassword = (password) => {
        var regularExpression = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        return regularExpression.test(password);
    };

    let confirmPassword = (password, confirmpassword) => {
        if (password === confirmpassword) {
            return true;
        }
        return false;
    };
    
    let checkStudentID = (studentemail, studentid) => {
        var idExtract = studentemail.slice(0, (studentemail.indexOf("@")));
        if (idExtract.toUpperCase() === studentid.toUpperCase()) {
            return true;
        }
        return false;
    };

    let validatePassword = () => {
        var pass = getPersonDetails();
        if (!checkPassword(pass.password)) {
            return false;
        }
        return true;
    };

    let swapView = (container0, container1) => {
        document.getElementById(container0).style = "display: none;";
        document.getElementById(container1).style = "display: block;";
    }

    // button helps to add a new class
    var AddClassButton = document.getElementById('addclass');
    if (AddClassButton) {
        AddClassButton.addEventListener('click', function () {
            
        });
    }
})();