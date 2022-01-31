?><input type="hidden" name="attendname" id="attendname" value="<?php echo $attendanceFile; ?>" /> <?php
                $qr = $connection -> prepare('SELECT * FROM person WHERE id = :userid');
                $qr -> execute([
                    'userid' => $_SESSION['student_id']
                ]);

                $repName = '';
                
                
                if ($qr -> rowCount() > 0) {
                    while ($res = $qr -> fetch()) {
                        $repName = $res['firstname'] . ' ' . $res['middlename'];
                        $programme = strtoupper($res['program_type']);
                    }
                }
                
                if (!empty($_POST['attStatus'])) {
                    if (file_exists("../attends/$attendanceFile")) {
                        // tells the user that attendance file already exists.
                        echo "<script>alert('Attendance Error! Attendance for $course_code on $course_date already exist.');</script>";
                    } else { // else
                        $pdf = new FPDF();

                        // call on $pdf to create a portrait page of a size of A4
                        $pdf -> AddPage('P', 'A4');
    
                        $pdf -> SetFont('Arial', 'I', 8);
                        $pdf -> Text(8, 292, "$course_code @ $course_date");
                        $pdf -> Text(180, 292, "zeroth-exodus");
                        
                        // set the font face to Arial, underline and bolden the font, and a size to 10
                        $pdf -> SetFont('Arial', 'UB', 10);
                        $pdf -> Cell(0, 10, "$programme", 0, 10, 'C'); // creates the "COMPUTER SCIENCE 1A" heading
                        $pdf -> Cell(0, 0, "ATTENDANCE SHEET", 0, 10, 'C'); // creates the "ATTENDANCE SHEET" sub heading
                        
                        // re-set the font. this time, no underline
                        $pdf -> SetFont('Arial', 'B', 10);
                        $pdf -> Text(17, 28, 'Lecturer: '); // creates the Lecturer label
                        $pdf -> Text(140, 28, 'Lecture Date: '); // Lecture Date label
                        $pdf -> Text(17, 34, 'Date Generated: ');
                        $pdf -> Text(140, 34, 'Taken By: ');
                        $pdf -> Text(17, 40, 'Course Name: ');
                        $pdf -> Text(140, 40, 'Course Code: ');
    
                        // re-sets the font. this time, no bold
                        $pdf -> SetFont('Arial', '', 10);
                        $pdf -> Text(35, 28, $lecName); // add the Name of the Lecturer
                        $pdf -> Text(164, 28, $course_date); // adds the lecture date
                        $pdf -> Text(46, 34, $genDate . ' @ ' . $genTime); // adds the date@time at which the attendance was taken
                        $pdf -> Text(159, 34, $repName); // adds who took the attendance
                        $pdf -> Text(42, 40, $course_name); // adds the course name
                        $pdf -> Text(164, 40, $course_code); // adds the course code
    
                        // creates the head of the table
                        $pdf -> Text(17, 48, '------------------------------------------------------------------------------------------------------------------------------------------------');
                        $pdf -> Text(17, 51, '| S/N |                                      NAME OF STUDENT                                                    |        STUDENT ID       |');
                        $pdf -> Text(17, 54, '------------------------------------------------------------------------------------------------------------------------------------------------');
    
                        $y = 54; // initializing the line number
                        $sn = 1; // initializing the stockiometric number o s3 d3in d3in o
                        $page = 1;
                        $pager = 1;
    
                        $pdf -> Text(103, 292, $page);
    
                        while ($result = $query -> fetch()) {
                            foreach ($_POST['attStatus'] as $presentStudents) {
                                if ($result['studentid'] == $presentStudents) {
                                    if ($page == 1) {
                                        // this is to help create another page if a page gets full.
                                        if ($sn % 39 == 0) {
                                            $y = 10; // value of line number is initialized to 10
                                            // fill the page with the neccessary values; like the name, id and $sn of a selected student
                                            $pdf -> AddPage('P', 'A4');
                                            $page += 1;
                                            $pdf -> Text(17, 11, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            if ($sn <= 9) {
                                                $pdf -> Text(17, $y + 4, '|   ' . $sn . '   |');
                                            } elseif ($sn <= 99) {
                                                $pdf -> Text(17, $y + 4, '|  ' . $sn . '  |');
                                            } elseif ($sn >= 100) {
                                                $pdf -> Text(17, $y + 4, '| ' . $sn . ' |');
                                            }
    
                                            $pdf -> Text(30, $y + 4, '  ' . $result['studentname']);
                                            $pdf -> Text(100, $y + 4, '                                                  |         ' . $presentStudents . '        |');
                                            $pdf -> Text(17, $y + 7, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            $pdf -> SetFont('Arial', 'I', 8);
                                            $pdf -> Text(8, 292, "$course_code @ $course_date");
                                            $pdf -> Text(180, 292, "zeroth-exodus");
                                            $pdf -> SetFont('Arial', '', 10);
                                            $pdf -> Text(103, 292, $page);
    
                                            
                                            $y += 6; // this code is familiar
                                            $sn += 1; // this code is familiar
    
                                        } else {
                                            if ($sn <= 9) {
                                                $pdf -> Text(17, $y + 4, '|   ' . $sn . '   |');
                                            } elseif ($sn <= 99) {
                                                $pdf -> Text(17, $y + 4, '|  ' . $sn . '  |');
                                            } elseif ($sn >= 100) {
                                                $pdf -> Text(17, $y + 4, '| ' . $sn . ' |');
                                            }
    
                                            $pdf -> Text(30, $y + 4, '  ' . $result['studentname']);
                                            $pdf -> Text(100, $y + 4, '                                                  |         ' . $presentStudents . '        |');
                                            $pdf -> Text(17, $y + 7, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            $y += 6; // this code is familiar
                                            $sn += 1; // this code is familiar
                                        }
                                    } else {
                                        // this is to help create another page if a page gets full.
                                        if ($pager % 45 == 0) {
                                            $y = 10; // value of line number is initialized to 10
                                            // fill the page with the neccessary values; like the name, id and $sn of a selected student
                                            $pdf -> AddPage('P', 'A4');
                                            $page += 1;
                                            $pdf -> Text(17, 11, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            if ($sn <= 9) {
                                                $pdf -> Text(17, $y + 4, '|   ' . $sn . '   |');
                                            } elseif ($sn <= 99) {
                                                $pdf -> Text(17, $y + 4, '|  ' . $sn . '  |');
                                            } elseif ($sn >= 100) {
                                                $pdf -> Text(17, $y + 4, '| ' . $sn . ' |');
                                            }
    
                                            $pdf -> Text(30, $y + 4, '  ' . $result['studentname']);
                                            $pdf -> Text(100, $y + 4, '                                                  |         ' . $presentStudents . '        |');
                                            $pdf -> Text(17, $y + 7, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            $pdf -> SetFont('Arial', 'I', 8);
                                            $pdf -> Text(8, 292, "$course_code @ $course_date");
                                            $pdf -> Text(180, 292, "zeroth-exodus");
                                            $pdf -> SetFont('Arial', '', 10);
                                            $pdf -> Text(103, 292, $page);
                                            
                                            $y += 6; // this code is familiar
                                            $sn += 1; // this code is familiar
                                            $pager += 1;
    
                                        } else {
                                            if ($sn <= 9) {
                                                $pdf -> Text(17, $y + 4, '|   ' . $sn . '   |');
                                            } elseif ($sn <= 99) {
                                                $pdf -> Text(17, $y + 4, '|  ' . $sn . '  |');
                                            } elseif ($sn >= 100) {
                                                $pdf -> Text(17, $y + 4, '| ' . $sn . ' |');
                                            }
    
                                            $pdf -> Text(30, $y + 4, '  ' . $result['studentname']);
                                            $pdf -> Text(100, $y + 4, '                                                  |         ' . $presentStudents . '        |');
                                            $pdf -> Text(17, $y + 7, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            $y += 6; // this code is familiar
                                            $sn += 1; // this code is familiar
                                            $pager += 1;
                                        }
                                    }
                                }
                            }
                        }
                        
                        $pdf -> Output('F', $attendanceFile);
                        // here, we move the file from this location to the attendance-sheets folder
                        rename("$attendanceFile", "../attends/$attendanceFile");

                        // alert the user of a successful attendance generation
                        echo '<script>alert("Attendance Taken!");</script>';
                    }
                } else {echo '<script>alert("Attendance Error! No student selected!");</script>';}
                echo $attendanceFile;
            }
        ?>