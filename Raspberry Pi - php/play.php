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

    $song_id = $_GET["song_id"];

    if ($song_id < 0) $song_id = 0;

    if (isset($_SESSION['views'])) {
        $_SESSION['views'] = $_SESSION['views'] + 1;
    } else {
        $_SESSION['views'] = 1;
    }

    $arr = $_SESSION['songs'];
    if ($song_id < sizeof($arr)) {
        $oReader = new ID3TagsReader();
        $Tags = $oReader->getTagsInfo($arr[$song_id]['path']);

        echo '<div>
                    <br><h2>'
            . ($song_id + 1)
            . '/'
            . sizeof($arr) .
            '<br></h2>
                    <table class="blueTable">
                        <thead>
                        <tr>
                        <th>File</th>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Album</th>
                        </tr>
                        </thead>
                <tbody>


            <tr><td>'
            . $arr[$song_id]['filename']
            . '</td><td>'
            . $Tags['Title']
            . '</td><td>'
            . $Tags['Author']
            . '</td><td>'
            . $Tags['Album']
            . '</td>
            </tr>
            </tbody></table>
            </div><br><br>';
    } else {
        echo '<div>
                <br><font color=red><h2>
                    No more songs
            <br></font></h2>';
    }

    if ($_SESSION['views'] <= 1) {
        shell_exec("sudo killall python");
        shell_exec("sudo nohup python ". $python_player . " " . $arr[$song_id]['systempath'] . " > /dev/null 2>&1 &");
    }


    if (isset($_POST['RESTART'])) {
        $_SESSION['views'] = 0;
        header("Location: play.php?song_id=" . $song_id, true, 301);
    }

    if (isset($_POST['NEXT'])) {
        $_SESSION['views'] = 0;
        header("Location: play.php?song_id=" . ($song_id + 1), true, 301);
    }

    if (isset($_POST['PREV'])) {
        $_SESSION['views'] = 0;
        header("Location: play.php?song_id=" . ($song_id - 1), true, 301);
    }

    if (isset($_POST['PAUSE'])) {
        touch($pause_file_path);
    }

    if (isset($_POST['EXIT'])) {
        shell_exec("sudo python ".$python_clear_buttons);
        shell_exec("sudo killall python");
        header("Location: index.php", true, 301);
        exit();
    }




    ?>

    <div>

        <form method="post">
            <button class="submit" name="PAUSE"><b>PLAY/PAUSE</b></button>
            <br><br><br><br><br><br><br><br>
            <button class="submit" name="RESTART"><b>RESTART</b></button>
            <br><br>
            <button class="submit" name="NEXT"><b>NEXT</b></button>
            <br><br>
            <button class="submit" name="PREV"><b>PREVIOUS</b></button>
            <br><br><br><br>
            <button class="submit" name="EXIT"><b>EXIT</b></button>
        </form>

        </p>
    </div>

</body>

</html>