  function FacebookStatusChangeCallback(response) {
    console.log('FacebookStatusChangeCallback');
    console.log(response);
    if (response.status === 'connected') {
      FacebookRTDLogin();
    } else if (response.status === 'not_authorized') {	
		console.log('Facebook: Not logged into app');
    } else {
		console.log('Facebook: Not logged into facebook');
    }
  }

  function FacebookCheckLoginState() {
    FB.getLoginStatus(function(response) {
      FacebookStatusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '464888166981399',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.0' // use version 2.0
  });

  FB.getLoginStatus(function(response) {
    FacebookStatusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  function FacebookRTDLogin() {
    console.log('Facebook: Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
		$.ajax({
			dataType: "json",
			url: '/scripts/rtd/facebook.php',
			data: response,
			success: function(data) { 
				if (data) location.reload(true);
			 }
			});
	
    });
  }
