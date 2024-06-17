<?php

// 以下は検索が二つの時用
//エラー表示
ini_set("display_errors", 1);
session_start();
// select.phpの編集ボタンからの受け取り
$id = $_GET["id"];

// db接続
include("funcs.php");
$pdo = db_conn();

//データ登録SQL作成
$sql = "SELECT * FROM hplc_results WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id,PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
    sql_error($stmt);
}

// 
$row =  $stmt->fetch(); //1行のみ
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RegisterEdit</title>
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
            max-width: 600px;
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
    </style>
    <script>
        function showSpinner() {
            document.getElementById("spinner").style.display = "block";
        }
    </script>

    <!-- <link rel="stylesheet" href="./css/output.css"> -->
    <script src="https://kit.fontawesome.com/862824129a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="">
<!-- HPLCヘッダー -->
<?php include("inc/headerHPLCfuncsNG.html") ?>
<section class="md:flex h-scleen">

<!-- mainLeft -->
<div id="spinner" class="spinner"></div>
<mainLeft id="mainLeft" class="md:w-2/5">
<div class="text-center my-4">
        <h1 class="md:hidden mb-2"><?php echo "Details of your selection are listed on the BOTTOM."; ?></h1>
        <h1 class="hidden md:block mb-2"><?php echo "Details of your selection are listed on the RIGHT."; ?></h1>
        <!-- Formタグ -->
          <div class="w-full ">
            <div class="justify-center w-4/5 mx-auto">
              <div class="bg-gray-200 rounded my-2">PO：<?=$row['PO']?></div>
              <div class="bg-blue-100 rounded my-2">Code：<?=$row['Code']?></div>
              <div class="bg-gray-200 rounded my-2">Sample：<?=$row['Sample']?></div>
              <div class="bg-blue-100 rounded my-2">Operator：<?=$row['Operator']?></div>
              <div class="bg-gray-200 rounded my-2">Target %：<?=$row['TargetPurity']?></div>
              <div class="bg-blue-100 rounded my-2">Comment：<?=$row['Comment']?></div>
              <div class="bg-gray-200 rounded my-2">Reg.Date：<?=$row['Date']?></div>
            </div>
     
        </div>
</div>
</mainLeft>

<!-- mainRight -->
<mainRight id="mainRight" class="md:w-3/5 bg-gray-800 text-gray-200">

<div class="text-center my-4">
        <div class="text-blue-500 mb text-2xl">Edit Details</div>
        <div class="text-blue-500">This is an editing page that can be performed over the TL.</div>
        <div class="text-blue-500 mb-2">Be sure to press the Update button after editing.</div>
        <!-- Formタグ -->
      <form method="POST" action="searchDetailUpdate.php" onsubmit="showSpinner()">
        <div name="edit">
        <div class="flex justify-center">
                  <div>PO：<input class="bg-slate-300 px-1 rounded w-2/3 text-gray-800" type="text" name="PO" value="<?=$row['PO']?>" placeholder="Preferably input"></div>
                  <div>Code：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="Code" value="<?=$row['Code']?>" placeholder="Preferably input"></div>
              </div>
              <div>MeasurDate：<input class="bg-slate-300 mb-1 px-1 rounded w-3/5 text-gray-800" type="text" name="MeasurDate" value="<?=$row['MeasurDate']?>" placeholder="Preferably input"></div>
              <div class="my-1">
                  <div class="flex justify-center">
                      <div>Sample：<input class="bg-slate-300 mb-1 px-1 rounded w-2/3 text-gray-800" type="text" name="Sample" value="<?=$row['Sample']?>" required></div>
                      <div>InjVol：<input class="bg-slate-300 mb-1 px-1 rounded w-2/3 text-gray-800" type="text" name="InjVol" value="<?=$row['InjVol']?>" placeholder="Preferably input"></div>
                  </div>
                  <div>SamplePrep：<input class="bg-slate-300 mb-1 px-1 rounded w-3/5 text-gray-800" type="text" name="SamplePrep" value="<?=$row['SamplePrep']?>" placeholder="Preferably input"></div>
              </div>
              <div class="my-1">
                  <div>Column：<input class="bg-slate-300 mb-1 px-1 rounded w-3/5 text-gray-800" type="text" name="ColumnName" value="<?=$row['ColumnName']?>" placeholder="Preferably input"></div>
                  <div class="flex justify-center">
                      <div>Col-ID：<input class="bg-slate-300 mb-1 px-1 rounded w-2/3 text-gray-800" type="text" name="ColID" value="<?=$row['ColID']?>" placeholder="Empty OK"></div>
                      <div>Col-Temp(℃)：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="ColTemp" value="<?=$row['ColTemp']?>" placeholder="Preferably input"></div>
                  </div>
              </div>
              <div class="my-1">
                  <div>EluentA：<input class="bg-slate-300 mb-1 px-1 rounded w-3/5 text-gray-800" type="text" name="MPA" value="<?=$row['MPA']?>" placeholder="Empty OK"></div>
                  <div>EluentB：<input class="bg-slate-300 mb-1 px-1 rounded w-3/5 text-gray-800" type="text" name="MPB" value="<?=$row['MPB']?>" placeholder="Empty OK"></div>
                  <div>EluentC：<input class="bg-slate-300 mb-1 px-1 rounded w-3/5 text-gray-800" type="text" name="MPC" value="<?=$row['MPC']?>" placeholder="Empty OK"></div>
                  <div>EluentD：<input class="bg-slate-300 mb-1 px-1 rounded w-3/5 text-gray-800" type="text" name="MPD" value="<?=$row['MPD']?>" placeholder="Empty OK"></div>
                  <div>TimeProg：<input class="bg-slate-300 mb-1 px-1 rounded w-4/5 text-gray-800" type="text" name="TimeProg" value="<?=$row['TimeProg']?>" required></div>
              </div>
              <div class="my-1">
                  <div>Target RT(min)：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="TargetTime" value="<?=$row['TargetTime']?>" placeholder="Necessary" required></div>
                  <div class="flex justify-center">
                      <div>RawMat RT：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="RawMatTime" value="<?=$row['RawMatTime']?>" placeholder="Empty OK"></div>
                      <div>Impurity RT：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="ImpurityTime" value="<?=$row['ImpurityTime']?>" placeholder="Empty OK"></div>
                  </div>
              </div>
              <div class="my-1">
                  <div>Target %：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="TargetPurity" value="<?=$row['TargetPurity']?>" placeholder="Necessary" required></div>
                  <div class="flex justify-center">
                      <div>RawMat %：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="RawMatPurity" value="<?=$row['RawMatPurity']?>" placeholder="Empty OK"></div>
                      <div>Impurity %：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="ImpurityPurity" value="<?=$row['ImpurityPurity']?>" placeholder="Empty OK"></div>
                  </div>
              </div>
              <div class="my-1">Operator：<input class="bg-slate-300 mb-1 px-1 rounded w-3/5 text-gray-800" type="text" name="Operator" value="<?=$row['Operator']?>" required></div>
              <div class="my-1 pt-1 bg-pink-800 rounded-md">
                  <div class="flex justify-center">MW ：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="MW" value="<?=$row['MW']?>" placeholder="ex)550.35" required></div>
                  <div>
                      <div class="flex justify-center">
                          <div>-OH/-SH ：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="OH" value="<?=$row['OH']?>" placeholder="ex)0" required></div>
                          <div>-COOH：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="COOH" value="<?=$row['COOH']?>" placeholder="ex)0" required></div>
                      </div>
                      <div class="flex justify-center">
                          <div>-NH2 ：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="NH2" value="<?=$row['NH2']?>" placeholder="ex)0" required></div>
                          <div>-SO3H/-PO4H2：<input class="bg-slate-300 mb-1 px-1 rounded w-2/5 text-gray-800" type="text" name="POH3" value="<?=$row['POH3']?>" placeholder="ex)0" required></div>
                      </div>
                      Be sure to fill in about this area.<br>This information is necessary to suggest candidates for your analysis.
                  </div>
              </div>
                <label>Comment：<br><textarea class="bg-slate-300 mb-1 px-1 rounded-md w-full text-gray-800" name="Comment" rows="4" cols="40" placeholder="Please fill in any incomplete, omitted, misspelled words, special notes, etc. in the form up to this point."><?=$row['Comment']?></textarea></label><br>
                <input type="hidden" name="id" value="<?=$row['id']?>">
                <div class="flex justify-end"><input class="px-2 bg-pink-300 hover:bg-pink-500 rounded text-gray-800 hover:text-gray-200 cursor-pointer"  type="submit" value="Update!"></div>
                
        </div>
      </form>
    </div>

</mainRight>

</section>


<!-- HPLCフッター -->
<?php include("inc/footerSANG.html") ?>





</body>
</html>