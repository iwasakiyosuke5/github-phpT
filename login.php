<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="./css/output.css"> -->
    <script src="https://cdn.tailwindcss.com"></script>


</head>
<body>
<?php include("inc/header1.html") ?>


<form name="form1" action="loginInsert.php" method="post" class="text-gray-600 body-font">
  <!-- 下記classにはitems-centerがあったがとりあえず削除 -->
  <div class="container px-5 py-24 mx-auto flex flex-wrap">
    <div class="lg:w-3/5 md:w-1/2 md:pr-16 lg:pr-0 pr-0">
      <h1 class="title-font font-medium text-3xl text-gray-900">This WEB APP web app will help you with your organic chemistry analytical work. </h1>
      <p class="leading-relaxed mt-4">From searching past results to creating analytical conditions for new compounds, it will help you in a wide range of tasks.<br>If you have any problems with signing up, please contact <span class="text-violet-300">Iwasaki</span> at BPR/PCG.</p>
    </div>
    <div class="lg:w-2/6 md:w-1/2 bg-gray-100 rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0">
      <h2 class="text-gray-900 text-lg font-medium title-font mb-5">Login</h2>
      <div class="relative mb-4">
        <label for="employeeId" class="leading-7 text-sm text-gray-600">Employee_ID</label>
        <input type="text" id="employeeId" name="employeeId" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
      </div>
      <div class="relative mb-4">
        <label for="lpw" class="leading-7 text-sm text-gray-600">Your Password</label>
        <input type="password" id="lpw" name="lpw" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" autocomplete="off">
      </div>
      <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">login!</button>
      <p class="text-xs text-gray-500 mt-3"> If you are new to our site, please <a href="signup.php" class="text-red-300">click here</a> to register.</p>
      
    </div>
  </div>
</form>
</body>
</html>