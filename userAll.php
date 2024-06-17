<?php

// 以下は検索が二つの時用
//エラー表示
ini_set("display_errors", 1);
session_start();

//1.  DB接続します
include("funcs.php");
$pdo = db_conn1();

// 検索クエリの受け取り
// 値が設定されている場合はその値を、設定されていない場合は空の文字列''を$search/Autherに代入している。
$search = isset($_POST['search']) ? $_POST['search'] : '';

// ２．データ登録SQL作成
// $sql = "SELECT * FROM gs_bm2_table";
$sql = "SELECT * FROM user_db";

if ($search !== '') {
  //  $sqlをSELECT * FROM gs_bm2_table WHERE title LIKE :search の形にするため
  $sql .= " WHERE id LIKE :search OR fullName LIKE :search OR employeeId LIKE :search OR team LIKE :search";
}
$stmt = $pdo->prepare("$sql");

// 曖昧検索のプレースホルダーに値をバインド
if ($search !== '') {
  $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSONい値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザー一覧</title>
<!-- <link rel="stylesheet" href="./css/output.css"> -->
<script src="https://cdn.tailwindcss.com"></script>


<style>div{padding: 10px;font-size:16px;}</style>
<style>
        .spinner {
            display: none;
            border: 16px solid black;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            /* width: 120px;
            height: 120px; */
            /*下記はバージョン違い  */

            width: 6em;
            height: 6em;
            margin-top: -3.0em;
            margin-left: -3.0em;
            /* border-radius: 50%;
            border: 0.25em solid #ccc;
            border-top-color: #333; */
            animation: spin 500ms linear infinite;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); 
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
        function showSpinner() {
            document.getElementById("spinner").style.display = "block";
        }
        // form中にformが作れないため関数で対応する。
        function updateKanriFlg(id, value) {
            // JavaScriptでフォームを作成し、送信する
            let form = document.createElement('form'); // 新しいフォームを作成
            form.method = 'GET'; // フォームの送信方法をGETに設定
            form.action = 'updateKanri_flg.php'; // フォームの送信先を設定

            // idフィールドを作成してフォームに追加
            let idField = document.createElement('input'); 
            idField.type = 'hidden'; // 非表示フィールドとして設定
            idField.name = 'id'; // フィールドの名前を設定
            idField.value = id; // フィールドの値を設定
            form.appendChild(idField); // フォームにフィールドを追加

            // kanri_flgフィールドを作成してフォームに追加
            let kanriFlgField = document.createElement('input'); 
            kanriFlgField.type = 'hidden'; // 非表示フィールドとして設定
            kanriFlgField.name = 'kanri_flg'; // フィールドの名前を設定
            kanriFlgField.value = value; // フィールドの値を設定
            form.appendChild(kanriFlgField); // フォームにフィールドを追加

            // 作成したフォームをドキュメントのボディに追加
            document.body.appendChild(form); 
            // フォームを送信
            form.submit(); 
        }

    </script>
</head>
<body id="main">
<!-- Head[Start] -->


<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="w-4/5 flex justify-between navbar-header">
        <div class="text-violet-700 text-2xl">Analysis DB</div>
        <div>Logged in : [<?=$_SESSION["fullName"]?>]<a class="ml-2 mr-2 navbar-brand border-b-2 border-gray-400" href="logout.php">Logout</a></div>
        
      </div>
      <div>
        <nav class="text-red-400 navbar navbar-default">User Veiw</nav>
        
          
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<div id="spinner" class="spinner"></div>
<div style="padding-left: 30px;">
<form id="searchForm" method="POST" action="userAll.php" onsubmit="showSpinner()">
      <input class="bg-slate-300 rounded pl-2" type="text" name="search" placeholder="Search Word">
      <input class="bg-red-300 rounded px-2 cursor-pointer" type="submit" value="Search">
      <button class="bg-red-100 rounded px-2" type="button" onclick="resetForm()">Reset</button>
</form>
</div>

<div class="w-4/5">
<div class="bg-slate-600 text-white w-full rounded-lg container jumbotron">
      <?php if (count($values) > 0): ?>
        <form action="userDelete.php" method="post" onsubmit="showSpinner()">
          <table class="text-center text-xl w-full">
            <tr class="">
              <th class="border-r border-gray-100 px-2">ID</th>
              <th class="border-r border-gray-100 px-2">EmployeeId</th>
              <th class="border-r border-gray-100 px-2">Team</th>
              <th class="border-r border-gray-100 px-2">FullName</th>
              <th class="border-r border-gray-100 px-2">kanri_flg</th>
              <th class="border-r border-gray-100 px-2">life_flg</th>
              <th class="px-2">Delete</th>

            </tr>
            <?php $count = 0; foreach($values as $v){ $count++;?>
              <!-- 「$v){」を「$v):」 とした場合、-->
                <tr class="border-b border-gray-300">
                <td class="border-r border-gray-100"><?=h($v["id"]);?></td>
                <td class="border-r border-gray-100" style="font-size: 14px"><?=h($v["employeeId"]);?></td>
                <td class="border-r border-gray-100" style="font-size: 14px"><?=h($v["team"]);?></td>
                <td class="border-r border-gray-100" style="font-size: 14px"><?=h($v["fullName"]);?></td>
                <td class="border-r border-gray-100" style="font-size: 14px"><?php if($v["id"] !== 3):?>
                      <select class="text-black cursor-pointer" name="kanri_flg" onchange="updateKanriFlg('<?=h($v["id"]);?>', this.value)">
                      <!-- <select name="kanri_flg" onchange="this.form.submit()"> -->
                              <option value="0" <?= $v["kanri_flg"] == 0 ? "selected" : "" ?>>0</option>
                              <option value="1" <?= $v["kanri_flg"] == 1 ? "selected" : "" ?>>1</option>
                              <option value="2" <?= $v["kanri_flg"] == 2 ? "selected" : "" ?>>2</option>
                              <option value="3" <?= $v["kanri_flg"] == 3 ? "selected" : "" ?>>3</option>
                      </select>
                  <?php endif;?>
                <td class="border-r border-gray-100" style="font-size: 14px"><?=h($v["life_flg"]);?></td>
                <td style=""><?php if($v["id"] !== 3):?><input type="checkbox" name="delete_ids[]" value="<?=$v["id"]?>"><?php endif;?></td>
              </tr>

            <?php }?>
            <!-- 「}」を「endforeach;」 とする -->
          </table>
          <input class="bg-gray-900 text-white rounded px-2 mt-1 cursor-pointer" type="submit" value="check User Delete"><br>
        </form>
        Number of display items：<?php echo "$count"; ?><br>
          <?php else: ?>
          No search results found.
          <?php endif; ?>
    </div>

</div>


<!-- Main[End] -->


<script>




//JSON受け取り


// リセット機能
  function resetForm() {
  document.querySelector('#searchForm [name="search"]').value = '';
  document.querySelector('#searchForm').submit();
}
</script>
</body>
</html>
