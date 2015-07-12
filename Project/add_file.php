

    <?php
    //http://bytes.com/topic/php/insights/740327-uploading-files-into-mysql-database-using-php/4
    // Check if a file has been uploaded
    if(isset($_FILES['uploaded_file'])) {
        // Make sure the file was sent without errors
        if($_FILES['uploaded_file']['error'] == 0) {
            // Connect to the database
            include "sql.php";
     
            // Gather all required data
            $name = $dbConn->real_escape_string($_FILES['uploaded_file']['name']);
            $mime = $dbConn->real_escape_string($_FILES['uploaded_file']['type']);
            $data = $dbConn->real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
            $size = intval($_FILES['uploaded_file']['size']);
     
            // Create the SQL query
            $query = "
                INSERT INTO `file` (
                    `name`, `mime`, `size`, `data`, `created`
                )
                VALUES (
                    '{$name}', '{$mime}', {$size}, '{$data}', NOW()
                )";
     
            // Execute the query
            $result = $dbConn->query($query);
            
            // Check if it was successfull
            if($result) {
                session_start();
                $id = $dbConn->insert_id;
                echo 'Success! Your file was successfully added!';
                //now add to Attachments table
                $attQ = "INSERT INTO ATTACHMENTS (Tag_Num, Rev_Num, Att_Num) VALUES ('".$_POST['TagNo']."', '".$_POST['revision']."', '".$id."')";
                if ($dbConn->Query($attQ)) echo "And inserted to Attacgments table";
                else echo "But not inserted into Attachments";
            }
            else {
                echo 'Error! Failed to insert the file'
                   . "<pre>{$dbConn->error}</pre>";
            }
        }
        else {
            echo 'An error accured while the file was being uploaded. '
               . 'Error code: '. intval($_FILES['uploaded_file']['error']);
        }
     
        // Close the mysql connection
        $dbConn->close();
    }
    else {
        echo 'Error! A file was not sent!';
    }
     
    // Echo a link back to the main page
    echo '<p>Click <a href="ViewOne.php?Tagno='.$_POST['TagNo'].'&revision='.$_POST['revision'].'">here</a> to go back</p>';
    ?>
     
     


