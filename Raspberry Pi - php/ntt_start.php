<!DOCTYPE HTML>
<html>

<head>
    <link rel="stylesheet" href="style.css" type="text/css">
    <meta charset="UTF-8">
</head>

<body>
    <?php
    include("ID3TagsReader.php");
    include("config.php");
    session_start();

    if (isset($_POST['GO'])) {
        $_SESSION['views'] = 0;
        header("Location: play.php?song_id=0", true, 301);
    }


    //search for all mp3 files recursively in $songs_path   
    $Directory = new RecursiveDirectoryIterator($songs_path);
    $Iterator = new RecursiveIteratorIterator($Directory);
    $Regex = new RegexIterator($Iterator, '/^.+(.mp3)$/i', RecursiveRegexIterator::GET_MATCH);
    $arr = [];
    foreach ($Regex as $name => $Regex) {

        $content = $name;

        //Search for anything that is not 0-9a-zA-Z
        $pattern = "/[_a-z0-9-]/i";
        $new_content = '';

        for ($i = 0; $i < strlen($content); $i++) {
            //add \ before any special character
            if (!preg_match($pattern, $content[$i])) {
                $new_content .= '\\' . $content[$i];
            } else {
                //pass the character if not special
                $new_content .= $content[$i];
            }
        }

        $arr[] = [
            'systempath' => $new_content, // Save linux-friendly path
            'path' => $content, //Save human-friendly path 
            'filename' => basename($content),
        ];
    }

    //set random order once - so you can use "previous" and "next" buttons later
    shuffle($arr);





    echo '<div><p style="font-size:20px" >

    <h2>' . sizeof($arr) . ' songs found</h2></p></div>';

    echo '<div>
        <form method="post">
            <button class="submit" name="GO"><b>START</b></button>
            <br><br><br><br>
        </form>
    </div>';


    $_SESSION['songs'] = $arr;

    ?>

</body>

</html>