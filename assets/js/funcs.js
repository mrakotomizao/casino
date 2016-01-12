(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&appId=1574460986104343&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function displayWALL(score) {
	var capt = "Voici le score que j\'ai fait: " + score;
	FB.ui({
			method:'feed',
			link:'http://localhost:8888/index.php',
			caption:'toto',},
			function(response){});
};

function displaySHARE(title) {
	FB.ui(
			{
				method: 'apprequests',
				display: 'popup',
				message: title
			});
};