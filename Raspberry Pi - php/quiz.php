<!DOCTYPE HTML>
<html>

<head>
	<link rel="stylesheet" href="style.css" type="text/css">
	<meta charset="UTF-8">
</head>

<body>
    <p style="font-size:40px" align="center">Party Machine v0.96
        <?php
        include("config.php");
        if (isset($_POST['PLAY'])) {
            shell_exec("sudo killall python");
            shell_exec("nohup python " .$python_quiz. " > /dev/null 2>&1 &");
        }
        if (isset($_POST['EXIT'])) {
            shell_exec("sudo python ".$python_clear_buttons);
            shell_exec("sudo killall python");
            header("Location: index.php", true, 301);
            exit();
        }
        shell_exec("sudo nohup python ".$python_quiz ." > /dev/null 2>&1 &");

        ?>

        <div>

            <form method="post">
                <button class="submit" name="PLAY"><b>Restart</b></button>
                <br><br>
                <button class="submit" name="EXIT"><b>Exit</b></button>
                <br><br>
            </form>

    </p>
    </div>


</body>

</html>