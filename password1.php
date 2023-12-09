<?php
$hostname='127.0.0.1';
$username='root';
$pass='dbpass';
$dbname='password';
$tablename='password';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームから入力を受け取る
    $password = $_POST["password"];

    // ランダムなソルトを生成
    $salt = bin2hex(random_bytes(16));

    // ソルトをパスワードに結合
    $saltedPassword = $salt . $password;

    // ソルト付きのパスワードをSHA-256ハッシュに変換
    $hashedPassword = hash("sha256", $saltedPassword);

    // ハッシュ化された値とソルトを表示
    echo "入力されたパスワード: $password<br>";
    echo "ハッシュ化されたパスワード: $hashedPassword<br>";
    echo "使用されたソルト: $salt";
    mysqli_report(MYSQLI_REPORT_OFF);
    $link=mysqli_connect($hostname,$username,$pass);
    if(!$link){exit("connect error!");}
    $result=mysqli_query($link,"USE $dbname");
    if(!$link){exit("use error!");}
    $result=mysqli_query($link,"INSERT INTO $tablename SET salt='$salt',password='$hashedPassword'");
    if(!$result){exit("insert error!");}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ハッシュ化プログラム</title>
</head>
<body>
    <form method="post" action="">
        <label>パスワード:</label>
        <input type="password" name="password">
        <input type="submit" value="ハッシュ化">
    </form>
</body>
</html>