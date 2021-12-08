<?php
                            $db = new DatabaseConnection('localhost', 'root', '');
                            $connection = $db->ConnectDB();
                            $query = $connection->prepare("SELECT DISTINCT recorded_year, recorded_month FROM payment WHERE userId = :userId ORDER BY recorded_datetime ASC");
                            $query->execute([
                                'userId' => $_SESSION['user_id']
                            ]);

                            if ($query->rowCount() > 0) {
                                ?>
                                <table class="table table-responsive table-bordered">
                                    <caption style="text-align: center;">All Recorded Expenses</caption>

                                    <?php
                                    $counter = 1;
                                    while ($result = $query->fetch()) {
                                        ?>
                                    <form class="form-horizontal" role = "form" method="POST" action="views/monthly_expenses.php" target="_blank">
                                            <input type="hidden" value="<?php echo $result['recorded_month']; ?>" name="month"/>
                                            <input type="hidden" value="<?php echo $result['recorded_year']; ?>" name="year"/>
                                            <tr>
                                                <td><?php echo $counter; ?></td>
                                                <td><?php echo $result['recorded_year']; ?></td>
                                                <td><?php echo $result['recorded_month']; ?></td>
                                                <td>
                                                    <input type="submit" class="form-control btn btn-success" value="View" />
                                                </td>
                                            </tr>

                                        </form>
                                        <?php
                                        $counter += 1;
                                    }
                                    ?>
                                </table>
                                <?php
                            } else {
                                echo 'No petty cash expenses recorded yet';
                            }
                            ?>