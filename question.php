<?php
$user = 'root';
$password = 'root';
$db = 'lesson7'; //各々で作ったDBの名前をここに入れる
$host = 'localhost';
$port = 3306;

$link = mysqli_init();

$success = mysqli_real_connect(
  $link,
  $host,
  $user,
  $password,
  $db,
  $port
);

// [[id1, name1], [id2, name2], ... ,[id_n, name_n]];
$users = [];
$name = '';


// MySQLからデータを取得
$read_query = "SELECT * FROM `users`";
$result = mysqli_query($link,$read_query);

if ($success) {
    while($row = mysqli_fetch_row($result)) {
        $users[] = [$row[1],$row[2]];
    }
}

  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_POST['name'])) {
    //名前の追加用のQueryを書く。   
    $name = $_POST['name'];
    mysqli_query($link,"INSERT INTO `users`(`name`) VALUES ('{$name}')");
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
    exit;
  }
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta name="viewport" content="width=device-width, initial-scale= 1.0">
  <meta http-equiv="content-type" charset="utf-8">
  <title>Laravel news</title>
</head>

<body>
  <h1>MySQL練習</h1>

  <section>

    <!--投稿-->
    <form method="post" action="./question.php">
      <div style="display: flex;flex-direction: row;margin-bottom: 1rem;">
        <p>name: </p>
        <input type='text' name='name'>
      </div>
      <input type="submit" value="投稿">
    </form>

    <hr>

    <!-- content -->
    <?php foreach ($users as $name) : ?>
      <p>name => <?php echo $name[1] ?></p>
    <?php endforeach; ?>
  </section>
</body>

</html>