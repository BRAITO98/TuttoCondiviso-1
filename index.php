<?php
if(!isset($_COOKIE["nodstrumCalendarV2"]))
{?>

<html>
<title>Calendario</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", Arial, Helvetica, sans-serif}
</style>
<body class="w3-light-grey">

<!-- Navigation Bar -->

<!-- Header -->
<header class="w3-display-container w3-content" style="max-width:1500px;">
  <img class="w3-image" src="immagine/calendario-scolastico.jpeg" alt="cImage" style="min-width:1000px" width="1500" height="800">
  <div class="w3-display-left w3-padding w3-col l6 m8">
    <div class="w3-container w3-red">
      
      
      <h2><i class=" w3-margin-right"></i>CALENDARIO</h2>
    </div>
    <div class="w3-container w3-white w3-padding-16">
      <form action="Calendario.php" target="_blank" method="post">
        <div class="w3-row-padding" style="margin:0 -16px;">
          <div class="w3-half w3-margin-bottom">
            <label>Username</label>
            <input class="w3-input w3-border" type="text" placeholder="Enter your username" name="username" required>
          </div>
          <div class="w3-half">
            <label> Password</label>
            <input class="w3-input w3-border" type="password" placeholder="Enter your password" name="password" required>
          </div>
        </div>
        
        <button class="w3-button w3-dark-grey" type="submit"><i class="fa fa-search w3-margin-right"></i> Log In</button>
      </form>
    </div>
  </div>
</header>

<!-- FINE BLOCCO DEL CALENDARIO-->



<!-- Footer -->
<footer class="w3-padding-32 w3-black w3-center w3-margin-top">
  
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank" class="w3-hover-text-green">w3.css</a></p>
</footer>



</body>
</html>
<?php
}
else
{
    setcookie('nodstrumCalendarV2', '0', time()-3600000);
    header('location: index.php');
}