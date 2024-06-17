<?php

// 以下は検索が二つの時用
//エラー表示
ini_set("display_errors", 1);
session_start();


//1.  DB接続します
include("funcs.php");
$pdo = db_conn();

// 検索クエリの受け取り
// 値が設定されている場合はその値を、設定されていない場合は空の文字列''を$searchPO/Autherに代入している。
$searchPCS = isset($_POST['searchPCS']) ? $_POST['searchPCS'] : '';
$searchOC = isset($_POST['searchOC']) ? $_POST['searchOC'] : '';


// ２．データ登録SQL作成
// $sql = "SELECT * FROM gs_bm2_table";
$sql = "SELECT * FROM hplc_results";
$wehreClauses = [];

if ($searchPCS !== '') {
  //  $sqlをSELECT * FROM gs_bm2_table WHERE title LIKE :search の形にするため
  $whereClauses[] = "(PO LIKE :searchPCS OR Code LIKE :searchPCS OR Sample LIKE :searchPCS)";
}
if ($searchOC !== '') {
  //  $sqlをSELECT * FROM gs_bm2_table WHERE title LIKE :search の形にするため
  $whereClauses[] = "(Operator LIKE :searchOC OR Comment LIKE :searchOC)";
}
if (!empty($whereClauses)) {
  $sql .= " WHERE " . implode(" AND ", $whereClauses);
}
$stmt = $pdo->prepare("$sql");

// 曖昧検索のプレースホルダーに値をバインド
if ($searchPCS !== '') {
  $stmt->bindValue(':searchPCS', '%' . $searchPCS . '%', PDO::PARAM_STR);
}
if ($searchOC !== '') {
  $stmt->bindValue(':searchOC', '%' . $searchOC . '%', PDO::PARAM_STR);
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

// 検索が実行されたかどうかを判定するフラグ(表示の表示非表示用)
$searchExecuted = !empty($searchPCS) || !empty($searchOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SearchTop</title>
    <style>
        mainRight {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: start;
            /* height: 100vh; */
        }
        .container2 {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            /* max-width: 600px; */
            text-align: center;
        }
        h1 {
            font-size: 24px;
            color: #007BFF;
        }
        ol {
            list-style-type: decimal;
            margin: 0;
            padding-left: 20px;
            text-align: left;
        }
        ol li {
            margin: 10px 0;
            font-size: 18px;
        }

        #file {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }
        .file-name {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }


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



/* ファイルデータ用 */
    </style>
    <!-- <link rel="stylesheet" href="./css/output.css"> -->
    <script src="https://kit.fontawesome.com/862824129a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="">
<!-- HPLCヘッダー -->
<?php include("inc/headerHPLCfuncs.html") ?>

<section class="md:flex h-scleen">

<!-- mainLeft -->
<mainLeft id="mainLeft" class="md:w-1/4">
    <div class="text-center my-4">
        <h1 class="mb-2"><?php echo "Search by typing search words."; ?></h1>
        <!-- Formタグ -->
        <div id="spinner" class="spinner"></div>
          <div>
            <form id="searchForm" method="POST" action="searchTop.php"  onsubmit="showSpinner()">
              <div class="mb-2">
                <input class="bg-slate-300 rounded pl-2 mb-1" type="text" name="searchPCS" placeholder="PO, Code, Sample">
                <input class="bg-slate-300 rounded pl-2" type="text" name="searchOC" placeholder="Operator, Comment">
              </div>
              <div class="">
                <input class="bg-pink-300 hover:bg-pink-500 rounded px-2 mb-1 cursor-pointer" type="submit" value="Serach!">
                <button class="bg-pink-100 hover:bg-pink-200 rounded px-2" type="button" onclick="resetForm()">Reset</button>
              </div>
              
            </form>
          </div>

    </div>
</mainLeft>

<!-- mainRight -->
<mainRight id="mainRight" class="md:w-3/4 bg-pink-300">
  <?php if (!$searchExecuted): ?>
    <div name="HowTo" class="container2 my-4">
        <h1 class="text-xl"><?php echo "Searching Scheme"; ?></h1>
        <ol>
            <li><?php echo "1. Search by typing search words."; ?></li>
            <li class="text-gray-500"><?php echo "*Search separately by PO, Code, Sample and Operator, Comment."; ?></li>
            <li><?php echo "2. Not all information will appear in the search results."; ?></li>
            <li class="pl-4"><?php echo "If you want to see all the information, click on the Details button."; ?></li>
        </ol>
    </div>
  <?php else: ?>
    
    <div name="searchResults"  class="my-1">
        <div class="px-1 w-scleen bg-gray-100 rounded-lg container jumbotron">
        <?php if (count($values) > 0): ?>
        <!-- <form action="delete.php" method="post" onsubmit="showSpinner()"> -->
              <table class="text-center w-full">
                <tr class="border-b border-gray-300">
                  <th class="border-r border-pink-200 px-1"></th>
                  <th class="border-r border-pink-200 px-1">PO</th>
                  <th class="border-r border-pink-200 px-1">Code</th>
                  <th class="border-r border-pink-200 px-1">Sample</th>
                  <th class="border-r border-pink-200 px-1">Operator</th>
                  <th class="border-r border-pink-200 px-1">TM Purity</th>
                  <th class="border-r border-pink-200 px-1">Comment</th>
                  <th class="px-1">Reg.Date</th>
                </tr>
                <?php $count = 0; foreach($values as $v){ $count++;?>
                  <!-- 「$v){」を「$v):」 とした場合、-->
                    <tr class="border-b border-gray-300">
                    <td class="border-r border-pink-200 px-1"><a href="searchDetail.php?id=<?=$v["id"]?>">🔍</a></td>                    
                    <td class="border-r border-pink-200 px-1"><?=h($v["PO"]);?></td>
                    <td class="border-r border-pink-200 px-1"><?=h($v["Code"]);?></td>
                    <td class="border-r border-pink-200 px-1"><?=h($v["Sample"]);?></td>
                    <td class="border-r border-pink-200 px-1"><?=h($v["Operator"]);?></td>
                    <td class="border-r border-pink-200 px-1"><?=h($v["TargetPurity"]);?></td>
                    <td class="border-r border-pink-200 px-1"><?=h($v["Comment"]);?></td>
                    <td class="px-1"><?=h($v["Date"]);?></td>
                  </tr>

                <?php }?>
                <!-- 「}」を「endforeach;」 とする -->
              </table>
        <!-- </form> -->
        No. of display items：<?php echo "$count"; ?><br>
      <?php else: ?>
        No search results found.
      <?php endif; ?>
      </div>
  <?php endif; ?>
  </mainRight>
</section>


<!-- HPLCフッター -->
<?php include("inc/footerSA.html") ?>

<script>
// リセット機能
function resetForm() {
  document.querySelector('#searchForm [name="searchPCS"]').value = '';
  document.querySelector('#searchForm [name="searchOC"]').value = '';
  document.querySelector('#searchForm').submit();
}

// 更新雰囲気用
function showSpinner() {
    document.getElementById("spinner").style.display = "block";
}

</script>
</body>
</html>