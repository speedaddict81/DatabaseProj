
    <!DOCTYPE html>
    <head>
        <link rel="stylesheet" type="text/css" href="../style.css">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h2>Attachment Upload</h2>        
        <form action="add_file.php" method="post" enctype="multipart/form-data">
            <input type="file" name="uploaded_file"><br>
            <input type="submit" value="Upload file">
        </form>
        <p>
            <a href="list_files.php">See all files</a>
        </p>
    </body>
    </html>

