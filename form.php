<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>データベースへのデータ格納と表示</title>
</head>
<body>

<?php
$servername = "localhost"; // データベースサーバーのホスト名
$username = "root"; // データベースユーザー名
$password = ""; // データベースのパスワード
$dbname = "data"; // データベース名

// データベースへの接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続を確認
if ($conn->connect_error) {
    die("データベースへの接続に失敗しました: " . $conn->connect_error);
}

// データをデータベースに登録
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO user (name, mail, comment) VALUES ('$name', '$mail', '$comment')";

    if ($conn->query($sql) === TRUE) {
        echo "データが正常にデータベースに挿入されました";
    } else {
        echo "データベースエラー: " . $conn->error;
    }
}

// データベースからデータを取得する関数
function displayData() {
    global $conn;

    $sql = "SELECT name, mail, comment FROM user";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>データベースのデータ一覧</h2>";
        echo "<table border='1'><tr><th>名前</th><th>メールアドレス</th><th>コメント</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["name"] . "</td><td>" . $row["mail"] . "</td><td>" . $row["comment"] . "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "データベースにデータがありません。";
    }


// データベース接続を閉じる
$conn->close();
}
?>

<h2>データを登録するフォーム</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  名前：<br />
  <input type="text" name="name" size="30" value="" /><br />
  メールアドレス：<br />
  <input type="text" name="mail" size="30" value="" /><br />
  コメント：<br />
  <textarea name="comment" cols="30" rows="5"></textarea><br />
  <br />
  <input type="submit" value="登録する" />
</form>

<!-- 新たにデータを表示するボタン -->
<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <br />
  <input type="submit" name="display" value="データ表示" />
</form>

<?php
// 新たにデータを表示するボタンが押されたときにデータを表示
if (isset($_GET['display'])) {
    displayData();
}
?>

</body>
</html>
