<?php

// 以下は検索が二つの時用
//エラー表示
ini_set("display_errors", 1);
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RegisterTOP</title>
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
<mainLeft id="mainLeft" class="md:w-2/5">
    <div class="text-center my-4">
        <h1 class="mb-2"><?php echo "Import the HPLC measurement data (pdf)."; ?></h1>
        <!-- Formタグ -->
        <form action="upload.php" method="post" enctype="multipart/form-data">
          <div class="file-input-container">
            <label for="file" class="custom-file-label border-2 border-pink-500 rounded p-1 cursor-pointer hover:bg-pink-200">Choose PDF file:</label><br>
            <input type="file" name="file" id="file" class="file-input" accept=".pdf" onchange="updateFileName()" required>
          </div>
          <span id="file-name" class="file-name">No file chosen</span><br>
          <input class="rounded border border-gray-300 px-2 cursor-pointer hover:bg-pink-500" type="submit" value="Upload PDF" name="submit">
        </form>
    </div>
</mainLeft>

<!-- mainRight -->
<mainRight id="mainRight" class="md:w-3/5">
    <div class="container2 my-4">
        <h1 class="text-xl"><?php echo "Register's Scheme"; ?></h1>
        <ol>
            <li><?php echo "1. Import the HPLC measurement data (pdf)."; ?></li>
            <li><?php echo "2. Review, correct, and add to the extracted data."; ?></li>
            <li><?php echo "3. Upload!"; ?></li>
        </ol>
    </div>
</mainRight>

</section>


<!-- HPLCフッター -->
<?php include("inc/footerSA.html") ?>

<script>
        function updateFileName() {
            const fileInput = document.getElementById('file');
            const fileNameDisplay = document.getElementById('file-name');
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = fileInput.files[0].name;
            } else {
                fileNameDisplay.textContent = 'No file chosen';
            }
        }
</script>



</body>
</html>