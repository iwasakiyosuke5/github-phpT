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
    <title>TopPage</title>
    <!-- <link rel="stylesheet" href="./css/output.css"> -->
    <script src="https://kit.fontawesome.com/862824129a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<?php include("inc/headerSA.html") ?>
<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="text-center mb-20">
      <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 mb-4">Welcome to Analysis DB</h1>
      <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto text-gray-500s">Please select the analytical instrument you wish to check.</p>
      <div class="flex mt-6 justify-center">
        <div class="w-16 h-1 rounded-full bg-indigo-500 inline-flex"></div>
      </div>
    </div>
    <!-- HPLC -->
    <div class="flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4 md:space-y-0 space-y-6">
      <div class="p-4 md:w-1/3 flex flex-col text-center items-center">
        <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
        <div class="text-4xl text-pink-500 fa-solid fa-pills"></div>
        </div>
        <div class="flex-grow">
          <h2 class="text-gray-900 text-lg title-font font-medium mb-3">HPLC</h2>
          <p class="leading-relaxed text-base">Search for registered analysis data<br>Registration of analysis data
<br>Help with suitable analysis conditions</p>
          <a href="hplcTop.php" class="mt-3 text-pink-500 hover:text-pink-800 inline-flex items-center">Go HPLC
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
              <path d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
      <!-- GC -->
      <div class="p-4 md:w-1/3 flex flex-col text-center items-center">
        <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
        <div class="text-4xl text-green-500 fa-solid fa-vial"></div>
        </div>
        <div class="flex-grow">
          <h2 class="text-gray-900 text-lg title-font font-medium mb-3">GC</h2>
          <p class="leading-relaxed text-base">Sorry! We are building the service.</p>
          <a class="mt-3 text-green-500 hover:text-green-800 inline-flex items-center">Go GC
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
              <path d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
      <!-- NMR -->
      <div class="p-4 md:w-1/3 flex flex-col text-center items-center">
        <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
            <div class="text-4xl text-purple-500 fa-solid fa-magnet"></div>
        </div>
        <div class="flex-grow">
          <h2 class="text-gray-900 text-lg title-font font-medium mb-3">NMR</h2>
          <p class="leading-relaxed text-base">Sorry! We are building the service.</p>
          <a class="mt-3 text-purple-500 hover:text-purple-800 inline-flex items-center">Go NMR
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
              <path d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>


</body>
</html>