<?php
session_start();
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

if (isset($_GET['reset'])) {
    session_unset();
    session_destroy();
    session_start();
    echo 'Session reset.<br>';
}

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

function extract_data_from_pdf($filePath) {
    $parser = new Parser();
    $pdf = $parser->parseFile($filePath);
    $text = $pdf->getText();
    
    // 抽出されたテキストを表示して確認
    echo '<pre>';
    echo htmlspecialchars($text);
    echo '</pre>';

    $data = [];

    // 正規表現を使って特定の情報を抽出
    if (preg_match('/PO:\s*(.*)/u', $text, $matches)) {
        $data['PO'] = $matches[1];
    } else {
        echo "PO not found.<br>";
    }
    if (preg_match('/Code:\s*(.*)/u', $text, $matches)) {
        $data['Code'] = $matches[1];
    } else {
        echo "Code not found.<br>";
    }
    if (preg_match('/Measur_Date:\s*(.*)/u', $text, $matches)) {
        $data['MeasurDate'] = $matches[1];
    } else {
        echo "Code not found.<br>";
    }
    if (preg_match('/Sample:\s*(.*)/u', $text, $matches)) {
        $data['Sample'] = $matches[1];
    } else {
        echo "Sample not found.<br>";
    }
    if (preg_match('/Sample_Prep:\s*(.*)/u', $text, $matches)) {
        $data['SamplePrep'] = $matches[1];
    } else {
        echo "Sample preparation not found.<br>";
    }
    if (preg_match('/Inj_Vol:\s*(.*)/u', $text, $matches)) {
        $data['InjVol'] = $matches[1];
    } else {
        echo "Injection volume not found.<br>";
    }
    if (preg_match('/Column:\s*(.*)/u', $text, $matches)) {
        $data['ColumnName'] = $matches[1];
    } else {
        echo "Column not found.<br>";
    }
    if (preg_match('/Col_ID:\s*(.*)/u', $text, $matches)) {
        $data['ColID'] = $matches[1];
    } else {
        echo "Column ID not found.<br>";
    }
    if (preg_match('/Col_Temp:\s*(.*)/u', $text, $matches)) {
        $data['ColTemp'] = $matches[1];
    } else {
        echo "Column temperature not found.<br>";
    }
    if (preg_match('/MP_A:\s*(.*)/u', $text, $matches)) {
        $data['MPA'] = $matches[1];
    } else {
        echo "Mobile A not found.<br>";
    }
    if (preg_match('/MP_B:\s*(.*)/u', $text, $matches)) {
        $data['MPB'] = $matches[1];
    } else {
        echo "Mobile B not found.<br>";
    }
    if (preg_match('/MP_C:\s*(.*)/u', $text, $matches)) {
        $data['MPC'] = $matches[1];
    } else {
        echo "Mobile C not found.<br>";
    }
    if (preg_match('/MP_D:\s*(.*)/u', $text, $matches)) {
        $data['MPD'] = $matches[1];
    } else {
        echo "Mobile D not found.<br>";
    }
    if (preg_match('/Time_Prog:\s*(.*)/u', $text, $matches)) {
        $data['TimeProg'] = $matches[1];
    } else {
        echo "Time program not found.<br>";
    }
    if (preg_match('/Total_Time:\s*(.*)/u', $text, $matches)) {
        $data['TotalTime'] = $matches[1];
    } else {
        echo "Total time not found.<br>";
    }
    
    return $data;
}



function save_to_db($data) {
    $Operator = $_SESSION["team"].$_SESSION["fullName"];

    include("funcs.php");
    $pdo = db_conn();
    $sql = "INSERT INTO hplc_results (PO,Code,MeasurDate,Sample,SamplePrep,InjVol,ColumnName,ColID,ColTemp,MPA,MPB,MPC,MPD,TimeProg,TotalTime,Operator,Date) 
                            VALUES (:PO,:Code,:MeasurDate,:Sample,:SamplePrep,:InjVol,:ColumnName,:ColID,:ColTemp,:MPA,:MPB,:MPC,:MPD,:TimeProg,:TotalTime,:Operator,sysdate())";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':PO', $data['PO'], PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':Code', $data['Code'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':MeasurDate', $data['MeasurDate'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':Sample', $data['Sample'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':SamplePrep', $data['SamplePrep'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':InjVol', $data['InjVol'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':ColumnName', $data['ColumnName'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':ColID', $data['ColID'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':ColTemp', $data['ColTemp'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':MPA', $data['MPA'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':MPB', $data['MPB'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':MPC', $data['MPC'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':MPD', $data['MPD'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':TimeProg', $data['TimeProg'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':TotalTime', $data['TotalTime'], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':Operator', $Operator, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $status = $stmt->execute();
    
    $lastInsertId = $pdo->lastInsertId(); // 最後に挿入されたIDを取得

    echo "Data successfully saved to database.<br>";
    return $lastInsertId;
    


}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Form submitted.<br>";
    
    if (isset($_FILES['file'])) {
        echo "File is set.<br>";

        if (!isset($_SESSION['file_uploaded'])) {
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $uploadFileDir = 'uploaded_files/';
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                echo 'File is successfully uploaded.<br>';

                // PDFデータを解析して情報を抽出
                $extractedData = extract_data_from_pdf($dest_path);

                // 抽出したデータを表示して確認
                echo '<pre>';
                print_r($extractedData);
                echo '</pre>';

                // データベースに保存する処理
                $lastInsertId = save_to_db($extractedData);
                // save_to_db($extractedData);
                if ($lastInsertId) {
                    // リダイレクトしてフォームの再送信を防ぐ
                    header('Location: registerEdit.php?id=' . $lastInsertId . '&file=' . $fileName);
                    exit;
                }
                } else {
                echo 'There was some error moving the file to upload directory.<br>';
            }
        } else {
            echo 'File already uploaded.<br>';
        }
    } else {
        echo 'No file uploaded or invalid file.<br>';
    }
} else {
    echo 'No form submission detected.<br>';
}
?>

<a href="upload.php?reset=1">Reset Session</a>
