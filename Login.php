<?php

echo '<div style="display: none; margin-top: 10px;" id="loginBox">
			<b>Login</b>
			<br>
			<form action="index.php" method="post">
				Username: <input type="text" name="username" size="20" value="">
				<br>
				Password: <input type="password" name="password" size="20" value="">
				<br>
				<input type="hidden" name="action" value="login">
				<input type="submit" value="Login">
				<a href="#" onClick="Element.hide(\'loginBox\');">Close</a>
			</form>
		</div>';

