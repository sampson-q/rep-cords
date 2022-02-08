else {
                                            echo '<h2 style="color: white;">Class members will show here if any!<h2>
                                            <tr align="right">
                                                <td><div class="col-xs-8"></div></td>
                                                <td><div id="addmember" class="btn btn-primary">Add Member</div></td>
                                            </tr>';
                                        }






                                        <?php
                                        $counter = 1; while($result = $query -> fetch()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $counter ?></td>
                                        <td><?php echo $result['studentname'] ?></td>
                                        <td><?php echo $result['studentid'] ?></td>
                                        <td><input type="checkbox" name="attStatus[]" value="<?php echo $result['studentid']; ?>" /></td>
                                    </tr>
                                    <?php
                                        $counter += 1; }
                                    ?>