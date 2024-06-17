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

<form name="form2" action="signupFuncs.php" method="post" class="text-gray-600 body-font">
  <!-- 下記classにはitems-centerがあったがとりあえず削除 -->
  <div class="container px-5 py-24 mx-auto flex flex-wrap"> 
    <div class="lg:w-3/5 md:w-1/2 md:pr-16 lg:pr-0 pr-0">
      <h1 class="title-font font-medium text-3xl text-gray-900">This WEB APP web app will help you with your organic chemistry analytical work. </h1>
      <p class="leading-relaxed mt-4">From searching past results to creating analytical conditions for new compounds, it will help you in a wide range of tasks.<br>If you have any problems with signing up, please contact <span class="text-violet-300">Iwasaki</span> at BPR/PCG.</p>    </div>
    <div class="lg:w-2/6 md:w-1/2 bg-gray-700 rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0">
      <h2 class="text-gray-100 text-lg font-medium title-font mb-5">Sign Up</h2>
      <div class="relative mb-4">
        <label for="employeeId" class="leading-7 text-sm text-gray-300">Employee_ID</label>
        <input type="text" id="employeeId" name="employeeId" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required>
      </div>
      <div class="relative mb-4">
        <label for="team" class="leading-7 text-sm text-gray-300">Your Team</label>
        <input type="text" id="team" name="team" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out required">
      </div>
      <div class="relative mb-4">
        <label for="fullName" class="leading-7 text-sm text-gray-300">Full Name</label>
        <input type="text" id="fullName" name="fullName" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required>
      </div>
      <div class="relative mb-4">
        <label for="lpw" class="leading-7 text-sm text-gray-300">Your Password</label>
        <input type="text" id="lpw" name="lpw" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" autocomplete="off" required>
      </div>
      <div class="relative mb-4">
        <label for="position" class="leading-7 text-sm text-gray-300 flex" required>Your Position</label>
        <div class="flex justify-evenly">
          <div><input type="radio" id="position2" name="position" value="2" ><label class="text-gray-300" for="GM/SMG/MG">GM/SMG/MG</label></div>
          <div><input type="radio" id="position1" name="position" value="1" ><label class="text-gray-300" for="TL">TL</label></div>
          <div><input type="radio" id="position0" name="position" value="0" checked><label class="text-gray-300" for="SSP/SP">SSP/SP</label></div>
        </div>      
      </div>
      <button class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Sign Up!</button>
      <p class="text-xs text-gray-300 mt-3"> If you are new to our site, please <a href="login.php" class="text-red-300">click here</a> to register.
      If you have used this web application at least once, you have definitely registered. Let's do our best to remind you.</p></div>
  </div>
</form>
</body>
</html>