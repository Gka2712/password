<?php
    $hostname='127.0.0.1';
    $username='root';
    $pass='dbpass';
    $dbname='password';
    $tablename='password';
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $password=$_POST["password"];
        
        mysqli_report(MYSQLI_REPORT_OFF);
        $link=mysqli_connect($hostname,$username,$pass,$dbname);
        if(!$link){exit("connect error!");}
        $result=mysqli_query($link,"SELECT * FROM $tablename");
        if(!$result){exit("select error!");}
        while($row=mysqli_fetch_assoc($result))
        {
            $pass_compare=hash("sha256",$row['salt'].$password);
            if($pass_compare===$row['password'])
            {
                exit("認証成功");
            }
        }
        exit("認証失敗");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>ページタイトル</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <form method="post" action="">
            <input type="password" name="password">
            <input type="submit" value="検索">
        </form>
    </body>
</html>