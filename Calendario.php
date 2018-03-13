                <?php 
                include('databaseConnection.php');
        
               if(!isset($_COOKIE["nodstrumCalendarV2"])){  //mettere a posto login, cambia colore , grafica
                $username = $_POST['username'];
                $password = $_POST['password'];
               }
			if($username == "" || $password == "") {
				// Stop, someone tried entering nothing into here.
				// Show an error.
				$loginMsg = 'You must enter a username and password';
			} else {
				// The input seems to be ok, check it against the database.
				$checkDetails = mysql_query("SELECT `username`, `password` FROM `user` WHERE username ='$username' AND password ='$password'", $conn );
				if($checkDetails) {
					if(mysql_num_rows($checkDetails) > 0) {
						setcookie('nodstrumCalendarV2', '1', time()+3600);
                                                $loginMsg = 'Login eseguito';// Cookie will expire in 1 hour.
						// $loginMsg = '<span style="color: green">You are logged in<i>!</i></span>';
					} else {
						$loginMsg = 'Your username or password was incorrect';
					}
				} else {
					$loginMsg = 'There was an error logging you in';
				}
			}
                
                if(isset($_POST["CambiaColore"]))
                {
                        $dc = $_POST['dayColor'];
			$wc = $_POST['weekendColor'];
			$tc = $_POST['todayColor'];
			$ec = $_POST['eventColor'];
			$ic1 = $_POST['iteratorColor1'];
			$ic2 = $_POST['iteratorColor2'];
			
			$updateColours = mysql_query("UPDATE settings SET dayColor='$dc', weekendColor='$wc', todayColor='$tc', eventColor='$ec', iteratorColor1='$ic1', iteratorColor2='$ic2' WHERE id='1' LIMIT 1", $conn);
			
			if($updateColours) {
				$loginMsg = '<span style="color: green">Your colours have been updated :)</span>';
			} else {
				$loginMsg = 'There was a problem updating the colours';
			}
                }
                
                if(isset($_POST["CambiaPassword"]))
                {
                    $pass1 = $_POST['password1'];
                    $pass2 = $_POST['password2'];
			
			if($pass1 == $pass2) {
				$updatePassword = mysql_query("UPDATE user SET password='$pass1' WHERE username='admin' LIMIT 1", $conn);
				if($updatePassword) {
					$loginMsg = '<span style="color: green">Your password has been changed :)</span>';
				} else {
					$loginMsg = 'There was an error updating your password.';
				}
			} else {
				$loginMsg = 'Your passwords did not match, please try again.';
			}
                }
          
	include('settings.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", Arial, Helvetica, sans-serif}
</style>

<title>Calendario</title>

<script src="js/lib/prototype.js" type="text/javascript"></script>
<script src="js/src/scriptaculous.js" type="text/javascript"></script>

<style>
	body {
		font-family: Tahoma;
		font-size: 12px;
	}
	
	.calendarBox {
		position: centre;
		top: 30px;
		margin: 0 auto;
		padding: 5px;
                    width: 254px;
		border: 1px solid #000;
	}

	.calendarFloat {
		float: left;
		width: 31px;
		height: 25px;
		margin: 1px 0px 0px 1px;
		padding: 1px;
		border: 1px solid #000;
	}
</style>

<script type="text/javascript">
	function highlightCalendarCell(element) {
		$(element).style.border = '1px solid #999999';
	}

	function resetCalendarCell(element) {
		$(element).style.border = '1px solid #000000';
	}
	
	function startCalendar(month, year) {
		new Ajax.Updater('calendarInternal', 'rpc.php', {method: 'post', postBody: 'action=startCalendar&month='+month+'&year='+year+''});
	}
	
	function showEventForm(day) {
		$('evtDay').value = day;
		$('evtMonth').value = $F('ccMonth');
		$('evtYear').value = $F('ccYear');
		
		displayEvents(day, $F('ccMonth'), $F('ccYear'));
		
		if(Element.visible('addEventForm')) {
			// do nothing.
		} else {
			Element.show('addEventForm');
		}
	}
	
	function displayEvents(day, month, year) {
		new Ajax.Updater('eventList', 'rpc.php', {method: 'post', postBody: 'action=listEvents&&d='+day+'&m='+month+'&y='+year+''});
		if(Element.visible('eventList')) {
			// do nothing, its already visble.
		} else {
			setTimeout("Element.show('eventList')", 300);
		}
	}
	
	function addEvent(day, month, year, body) {
		if(day && month && year && body) {
			// alert('Add Event\nDay: '+day+'\nMonth: '+month+'\nYear: '+year+'\nBody: '+body);
			new Ajax.Request('rpc.php', {method: 'post', postBody: 'action=addEvent&d='+day+'&m='+month+'&y='+year+'&body='+body+'', onSuccess: highlightEvent(day)});
			$('evtBody').value = '';
		} else {
			alert('There was an unexpected script error.\nPlease ensure that you have not altered parts of it.');
		}
		
		// highlightEvent(day);
	} // addEvent.
	
	function highlightEvent(day) {
		Element.hide('addEventForm');
		$('calendarDay_'+day+'').style.background = '#<?= $eventColor ?>';
	}
	
	function showLoginBox() {
		Element.show('loginBox');
	}
	
	function showCP() {
		Element.show('cpBox');
	}
	
	function deleteEvent(eid) {
		confirmation = confirm('Are you sure you wish to delete this event?\n\nOnce the event is deleted, it is gone forever!');
		if(confirmation == true) {
			new Ajax.Request('rpc.php', {method: 'post', postBody: 'action=deleteEvent&eid='+eid+'', onSuccess: Element.hide('event_'+eid+'')});
		} else {
			// Do not delete it!.
		}
	}
</script>

</head>
<body class="w3-light-grey">
    <header class="w3-display-container w3-content" style="max-width:1500px;">
  <img class="w3-image" src="immagine/calendario-scolastico.jpeg" alt="cImage" style="min-width:1000px" width="1500" height="800">
  <div class="w3-display-left w3-padding w3-col l6 m8">
    <div class="w3-container w3-red">
      
      
      <h2><i class=" w3-margin-right"></i>CALENDARIO</h2>
    </div>

        <div class="w3-bar w3-white w3-large">
        <a href="Calendario.php" class="w3-bar-item w3-button w3-red w3-mobile"><i class="w3-margin-right"></i>HOME</a>
            
        <a href="Impostazioni.php" class="w3-bar-item w3-button w3-mobile">IMPOSTAZIONI</a>
        
        
        <a href="CambiaPAssword.php" class="w3-bar-item w3-button w3-mobile">CAMBIA PASSWORD</a>
        
        <a href="index.php" class="w3-bar-item w3-button w3-mobile">LOGOUT</a>
        <!--
        <a href="#contact" class="w3-bar-item w3-button w3-mobile">Contact</a>
        <a href="#contact" class="w3-bar-item w3-button w3-right w3-light-grey w3-mobile">Book Now</a>
        -->
  
        </div>
	<div id="calendar" class="calendarBox">
		<div id="calendarInternal">
			&nbsp;
		</div>
		<br style="clear: both;">
		<div id="eventList" style="display: none;"></div>
		<div style="display: none; margin-top: 10px;" id="addEventForm">
			<b>Add Event</b>
			<br>
			Date: <input type="text" size="2" id="evtDay" disabled> <input type="text" size="2" id="evtMonth" disabled> <input type="text" size="4" id="evtYear" disabled>
			<br>
			<textarea id="evtBody" cols="32" rows="5"></textarea>
			<br>
			<input type="button" value="Add Event" onClick="addEvent($F('evtDay'), $F('evtMonth'), $F('evtYear'), $F('evtBody'));">
			<a href="#" onClick="Element.hide('addEventForm');">Close</a>
		</div>
		
		
		
	</div>
      <div class="w3-margin-right">
		
                    
      </div>
	</div> <!-- FINAL DIV DO NOT REMOVE -->
	
	<script type="text/javascript">
		startCalendar(0,0);
	</script>

</body>
</html>




