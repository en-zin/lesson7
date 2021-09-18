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

if ($success) {
  $result = mysqli_query($link, $read_query);
  while ($row = mysqli_fetch_array($result)) {
    $users[] = [$row['id'], $row['name']];
  }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_POST['name'])) {
    //名前の追加用のQueryを書く。
    $name = $_POST['name'];
    $insert_query = "INSERT INTO `users`(`name`) VALUES ('{$name}')";
    mysqli_query($link, $insert_query);
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
    <form method="post" action="./answer.php">
      <div style="display: flex;flex-direction: row;margin-bottom: 1rem;">
        <p>name: </p>
        <input type='text' name='name'>
      </div>
      <input type="submit" value="投稿" style="padding: 0.5rem 3rem;border-radius: 1rem;font-weight: bold;text-align: center;text-transform: uppercase;transition: 0.5s;background-size: 200% auto;box-shadow: 0 0 20px #eee;margin-top: 1rem;">
    </form>

    <hr>

    <!-- content -->
    <?php foreach ($users as $name) : ?>
      <p>name => <?php echo $name[1] ?></p>
      <form method="post">
        <input type="hidden" name="del" value="<?php echo $name[0] ?>">
        <input type="submit" value="削除" class="deleteComment">
      </form>
    <?php endforeach; ?>
  </section>
</body>

</html>