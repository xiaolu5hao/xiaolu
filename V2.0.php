<?php
// 读取JSON文件
$json = file_get_contents('data.json');
$data = json_decode($json, true);

// 处理添加和删除的逻辑
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['add'])) {
    // 检查网站名称是否已存在
    $name = $_POST['name'];
    $url = $_POST['url'];
    $exists = false;
    foreach ($data['data'] as $item) {
      if ($item['name'] === $name) {
        $exists = true;
        break;
      }
    }

    if (!$exists) {
      // 添加逻辑
      $newData = ['id' => count($data['data']) + 1, 'name' => $name, 'url' => $url];
      array_push($data['data'], $newData);
      file_put_contents('data.json', json_encode($data));
      header('Location: V2.0.php'); // 重定向到同一页面或目标页面
      exit();
    } else {
      // 网站已存在，可以设置一个变量用于显示提示信息
      $nameExists = true;
    }
  } elseif (isset($_POST['delete'])) {
    // 删除逻辑
    $idToDelete = $_POST['id'];
    $data['data'] = array_filter($data['data'], function ($item) use ($idToDelete) {
      return $item['id'] != $idToDelete;
    });
    $data['data'] = array_values($data['data']); // 重新索引数组
    file_put_contents('data.json', json_encode($data));
    header('Location: V2.0.php'); // 重定向到同一页面或目标页面
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>小陆空间 - 网站列表</title>
  <link rel="icon" type="image/png" href="./img/icon.png">
  <link rel="stylesheet" href="./css/1.css">
  <link rel="stylesheet" href="./css/V2.0.css">
</head>

<body>
  <!-- 遮罩层 -->
  <div class="mask" onclick="closeForm()"></div>

  <button id="toggleAddForm">添加网站</button>
  <form id="addForm" action="" method="post">
    <div>
      <h2>添加网站</h2><img src="./img/gb11.png" onclick="closeForm()" class="imgq" title="关闭页面">
    </div>
    <input type="text" name="name" placeholder="网站名称" required>
    <input type="text" name="url" placeholder="网站URL" required>
    <button type="submit" name="add">提交</button>
    <!-- <button type="button" onclick="closeForm()">关闭</button> -->
  </form>

  <button id="toggleDeleteForm">删除网站</button>
  <form id="deleteForm" action="" method="post">
    <div>
      <h2>删除网站</h2><img src="./img/gb11.png" onclick="closeForm()" class="imgq" title="关闭页面">
    </div>
    <select name="id" id="idToDelete">
      <?php foreach ($data['data'] as $item) : ?>
        <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit" name="delete">删除</button>
    <!-- <button type="button" onclick="closeForm()">关闭</button> -->
  </form>

  <!-- 表格 -->
  <table border="1">
    <tr>
      <th>名称</th>
      <!-- <th>URL</th> -->
    </tr>
    <?php foreach ($data['data'] as $item) : ?>
      <tr>
        <td><a href="<?php echo $item['url']; ?>" target="_blank"><?php echo $item['name']; ?></a></td>
        <!-- <td><?php echo $item['url']; ?></td> -->
      </tr>
    <?php endforeach; ?>
  </table>

<script src="./js/V2.0.js"></script>
</body>

</html>