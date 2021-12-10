<div style="display: none;" class="container-fluid col-xs-6" id="ViewClassMembers">
            <?php
                $classtoshow = filter_input(INPUT_POST, 'ClassToShow');
                $db = new DatabaseConnection('localhost', 'root', '');
                $connection = $db -> ConnectDB();
                $query = $connection -> prepare("SELECT studentname, studentid FROM :classtoshow");
                $query -> execute([
                    'classtoshow' => $classtoshow
                ]);

                if ($query -> rowCount() > 0) { ?>
                    <table class="table table-responsive" style="color: white;">
                        <caption style="text-align: center; color: white;"><h2><?php echo $classtoshow ?></h2></caption>
                        <tr align="center">
                            <td><strong>S/N</strong></td>
                            <td><strong>Student Name</strong></td>
                            <td><strong>Student ID</strong></td>
                            <td colspan="2"><strong>Options</strong></td>
                        </tr>
                        <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                            <tr align="center">
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $result['studentname']; ?></td>
                                <td><?php echo $result['studentid']; ?></td>
                                <td><input id="updatemember" type="submit" class="btn btn-success" value="Update Member" /></td>
                                <td><input id="removemember" type="submit" class="btn btn-danger" value="Remove Member" /></td>
                            </tr>
                        <?php $counter += 1; } ?>
                    </table>
                <?php } else { echo '<h2 style="color: white;">Your classes will show here if you have any!<h2>'; }
            ?>
        </div>