<?php
//1. POSTデータ取得
$ids = $_POST["delete_ids"];

if(empty($ids)){
    echo "一つも選択されていないので削除できません。";
    echo "<br>";
    echo "<span id='countdown'>3</span>秒後に自動的に戻ります。";
    echo '<script>';
    echo "let countdown = 3;
            let countdownElement = document.getElementById('countdown');
            setInterval(function(){
                if (countdown >0){
                    countdown--;
                    countdownElement.textContent = countdown;
                }
            },1000);";
    echo 'setTimeout(function() {window.location.href = "allUser.php";}, 2900);'; // 2秒後にリダイレクト
    echo '</script>';
    exit();
}
//2. DB接続します
include("funcs.php");
$pdo = db_conn1();


// プレースホルダー生成用のコールバック関数を定義
$placeholder = function($key) {
    return ":id{$key}";
};
// echo $placeholder;
// プレースホルダーを生成
$placeholders = array_map($placeholder, array_keys($ids));
$sql = "DELETE FROM user_db WHERE id IN (" . implode(',', $placeholders) . ")";
// 上記でDELETE FROM gs_bm2_table WHERE id IN ("id1,1d3,id4")となるイメージ
$stmt = $pdo->prepare($sql);
// プレースホルダーに値をバインド
foreach ($ids as $index => $id) {
    $stmt->bindValue(":id{$index}", $id, PDO::PARAM_INT);
}
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("userall.php");

    exit;
}


?>
<!-- // ページ遷移用のカウントダウン用scriptタグ -->
<!-- <span id='countdown'>3</span>秒後に自動的に戻ります。 -->
<!-- <script>
let countdown = 2;
let countdownElement = document.getElementById('countdown');
setInterval(function(){
    if (countdown >0){
        countdown--;
        countdownElement.textContent = countdown;
    }
},1000);
</script> -->