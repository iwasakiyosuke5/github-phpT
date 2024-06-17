<?php

// 以下は検索が二つの時用
//エラー表示
// ini_set("display_errors", 1);
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopPage</title>
    <!-- <link rel="stylesheet" href="./css/output.css"> -->
    <script src="https://kit.fontawesome.com/862824129a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="">
<!-- HPLCヘッダー -->
<?php include("inc/headerHPLCfuncs.html") ?>

<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="text-center mb-20">
      <h1 class="text-gray-600 sm:text-3xl text-2xl font-medium title-font text-gray-900 mb-4">Tools for HPLC</h1>
      <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto text-gray-500s">Please click on the SERVICES you would like to use from the list at the top.</p>
      <div class="flex mt-6 justify-center">
        <div class="w-16 h-1 rounded-full bg-pink-500 inline-flex"></div>
      </div>
    </div>
    
    </div>
  </div>
</section>

<!-- HPLCフッター -->
<?php include("inc/footerSA.html") ?>

</body>
</html>