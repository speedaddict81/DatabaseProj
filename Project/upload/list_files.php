

    <?php
    // Connect to the database
    //include "../sql.php";
    $dbLink = $dbConn;
    // Query for a list of all existing files
    $sql = "SELECT `id`, `name`, `mime`, `size`, `created` FROM `file` JOIN ATTACHMENTS ON id=Att_Num where Tag_Num=".$tagRow['Tag_No']." and Rev_Num=".$tagRow['Rev_No'];
    $result = $dbLink->query($sql);
     
    // Check if it was successfull
    if($result) {
        // Make sure there are some files in there
        if($result->num_rows == 0) {
            echo '<p>There are no files in the database</p>';
        }
        else {
            // Print the top of a table
            echo '<table width="100%">
                    <tr>
                        <td><b>Name</b></td>
                        <td><b>Mime</b></td>
                        <td><b>Size (bytes)</b></td>
                        <td><b>Created</b></td>
                        <td><b>&nbsp;</b></td>
                    </tr>';
     
            // Print each file
            while($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                        <td>{$row['name']}</td>
                        <td>{$row['mime']}</td>
                        <td>{$row['size']}</td>
                        <td>{$row['created']}</td>
                        <td><a href='./upload/get_file.php?id={$row['id']}'>Download</a></td>
                    </tr>";
            }
     
            // Close table
            echo '</table>';
        }
     
        // Free the result
        $result->free();
    }
    else
    {
        echo 'Error! SQL query failed:';
        echo "<pre>{$dbLink->error}</pre>";
    }
     
    // Close the mysql connection
    $dbLink->close();
    ?>


