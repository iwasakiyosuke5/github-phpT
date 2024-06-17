<?php
ini_set("display_errors", 1);

// 関数呼び出し準備
$kanri_flg = $_GET["kanri_flg"];
$id = $_GET["id"];

include("funcs.php");
$pdo = db_conn1();

//３．データ登録SQL作成
$sql = "UPDATE user_db SET kanri_flg=:kanri_flg WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id',$id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

if($status == false){
    sql_error($stmt);
} else {
    redirect("userAll.php");
}

?>