<html>

<head>
<title>Login with Facebook Using CodeIgniter</title>
</head>

<body>

<div class="container">
	<form>
		<!-- @user_profile check when user login successed  -->
		<?php if (@$user_profile):  // call var_dump($user_profile) to view all data ?>
		<!-- Display profile photo -->
		<img src="https://graph.facebook.com/<?=$user_profile['id']?>/picture?type=large" style="width: 140px; height: 140px;">
		<!-- Display profile name -->
		<h2><?=$user_profile['name']?></h2>
		<!-- Create link to facebook profile -->
		<a href="<?=$user_profile['link']?>">View Profile</a>
		<!-- Create link logout -->
		<a href="<?= $logout_url ?>">Logout</a> 
	    <!-- Display login when start home page first -->
		<?php else: ?>
		<h2>Login with Facebook Using CodeIgniter</h2>
		<a href="<?= $login_url ?>">Login</a> 
		<?php endif; ?>
	</form>
</div>

</body>

</html>
