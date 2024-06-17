<?php
ini_set("display_errors", 1);
session_start();
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

//1. POSTデータ取得

$PO = !empty($_POST["PO"]) ? $_POST["PO"] : null;
$Code = !empty($_POST["Code"]) ? $_POST["Code"] : null;
$MeasurDate = !empty($_POST["MeasurDate"]) ? $_POST["MeasurDate"] : null;
$Sample = !empty($_POST["Sample"]) ? $_POST["Sample"] : null;
$InjVol = !empty($_POST["InjVol"]) ? $_POST["InjVol"] : null;
$SamplePrep = !empty($_POST["SamplePrep"]) ? $_POST["SamplePrep"] : null;
$ColumnName = !empty($_POST["ColumnName"]) ? $_POST["ColumnName"] : null;
$ColID = !empty($_POST["ColID"]) ? $_POST["ColID"] : null;
$ColTemp = !empty($_POST["ColTemp"]) ? $_POST["ColTemp"] : null;
$MPA = !empty($_POST["MPA"]) ? $_POST["MPA"] : null;
$MPB = !empty($_POST["MPB"]) ? $_POST["MPB"] : null;
$MPC = !empty($_POST["MPC"]) ? $_POST["MPC"] : null;
$MPD = !empty($_POST["MPD"]) ? $_POST["MPD"] : null;
$TimeProg = !empty($_POST["TimeProg"]) ? $_POST["TimeProg"] : null;
$TargetTime = !empty($_POST["TargetTime"]) ? $_POST["TargetTime"] : null;
$RawMatTime = !empty($_POST["RawMatTime"]) ? $_POST["RawMatTime"] : null;
$ImpurityTime = !empty($_POST["ImpurityTime"]) ? $_POST["ImpurityTime"] : null;
$TargetPurity = !empty($_POST["TargetPurity"]) ? $_POST["TargetPurity"] : null;
$RawMatPurity = !empty($_POST["RawMatPurity"]) ? $_POST["RawMatPurity"] : null;
$ImpurityPurity = !empty($_POST["ImpurityPurity"]) ? $_POST["ImpurityPurity"] : null;
$Operator = !empty($_POST["Operator"]) ? $_POST["Operator"] : null;
$Comment = !empty($_POST["Comment"]) ? $_POST["Comment"] : null;
$MW = isset($_POST["MW"]) ? $_POST["MW"] : null;
$OH = isset($_POST["OH"]) ? $_POST["OH"] : null;
$COOH = isset($_POST["COOH"]) ? $_POST["COOH"] : null;
$NH2 = isset($_POST["NH2"]) ? $_POST["NH2"] : null;
$POH3 = isset($_POST["POH3"]) ? $_POST["POH3"] : null;
$id = !empty($_POST["id"]) ? $_POST["id"] : null;

// パラメータの計算を追加
$PerOH = ($OH !== null && $MW !== null) ? $OH * 17.008 / $MW : null;
$AcidBase = ($COOH !== null && $NH2 !== null && $POH3 !== null) ? $COOH - $NH2 + $POH3 : null;

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "UPDATE hplc_results SET 
        PO=:PO, 
        Code=:Code, 
        MeasurDate=:MeasurDate, 
        Sample=:Sample, 
        InjVol=:InjVol, 
        SamplePrep=:SamplePrep, 
        ColumnName=:ColumnName, 
        ColID=:ColID, 
        ColTemp=:ColTemp, 
        MPA=:MPA, 
        MPB=:MPB, 
        MPC=:MPC, 
        MPD=:MPD, 
        TimeProg=:TimeProg, 
        TargetTime=:TargetTime, 
        RawMatTime=:RawMatTime, 
        ImpurityTime=:ImpurityTime, 
        TargetPurity=:TargetPurity, 
        RawMatPurity=:RawMatPurity, 
        ImpurityPurity=:ImpurityPurity, 
        Operator=:Operator,
        Comment=:Comment, 
        MW=:MW, 
        OH=:OH, 
        COOH=:COOH, 
        NH2=:NH2, 
        POH3=:POH3, 
        PerOH=:PerOH,
        AcidBase=:AcidBase
        WHERE id=:id";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':PO', $PO, PDO::PARAM_INT);
$stmt->bindValue(':Code', $Code, PDO::PARAM_STR);
$stmt->bindValue(':MeasurDate', $MeasurDate, PDO::PARAM_STR);
$stmt->bindValue(':Sample', $Sample, PDO::PARAM_STR);
$stmt->bindValue(':InjVol', $InjVol, PDO::PARAM_STR);
$stmt->bindValue(':SamplePrep', $SamplePrep, PDO::PARAM_STR);
$stmt->bindValue(':ColumnName', $ColumnName, PDO::PARAM_STR);
$stmt->bindValue(':ColID', $ColID, PDO::PARAM_STR);
$stmt->bindValue(':ColTemp', $ColTemp, PDO::PARAM_STR);
$stmt->bindValue(':MPA', $MPA, PDO::PARAM_STR);
$stmt->bindValue(':MPB', $MPB, PDO::PARAM_STR);
$stmt->bindValue(':MPC', $MPC, PDO::PARAM_STR);
$stmt->bindValue(':MPD', $MPD, PDO::PARAM_STR);
$stmt->bindValue(':TimeProg', $TimeProg, PDO::PARAM_STR);
$stmt->bindValue(':TargetTime', $TargetTime, PDO::PARAM_STR);
$stmt->bindValue(':RawMatTime', $RawMatTime, PDO::PARAM_STR);
$stmt->bindValue(':ImpurityTime', $ImpurityTime, PDO::PARAM_STR);
$stmt->bindValue(':TargetPurity', $TargetPurity, PDO::PARAM_STR);
$stmt->bindValue(':RawMatPurity', $RawMatPurity, PDO::PARAM_STR);
$stmt->bindValue(':ImpurityPurity', $ImpurityPurity, PDO::PARAM_STR);
$stmt->bindValue(':Operator', $Operator, PDO::PARAM_STR);
$stmt->bindValue(':Comment', $Comment, PDO::PARAM_STR);
$stmt->bindValue(':MW', $MW, PDO::PARAM_STR);
$stmt->bindValue(':OH', $OH, PDO::PARAM_INT);
$stmt->bindValue(':COOH', $COOH, PDO::PARAM_INT);
$stmt->bindValue(':NH2', $NH2, PDO::PARAM_INT);
$stmt->bindValue(':POH3', $POH3, PDO::PARAM_INT);
$stmt->bindValue(':PerOH', $PerOH, PDO::PARAM_STR);
$stmt->bindValue(':AcidBase', $AcidBase, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute();

if (!$status) {
    $errorInfo = $stmt->errorInfo();
    echo "SQLSTATE error code: " . $errorInfo[0] . "\n";
    echo "Driver-specific error code: " . $errorInfo[1] . "\n";
    echo "Driver-specific error message: " . $errorInfo[2] . "\n";
}

//４．データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
        sql_error($stmt);
}else{

   //５．index.phpへリダイレクト "Location: "のコロンの後ろは半スペ！
    redirect("searchTop.php");
}
?>