FB.init({appId: "PUT_YOUR_FACEBOOK_API_KEY_HERE", status: true, cookie: true});
 
	  function postToFeed() {

		// calling the API ...
		var obj = {
		  method: 'feed',
		  redirect_uri: 'http://noble-soft.com?thankyou',
		  link: 'http://noble-soft.com?facebook',
		  picture: document.getElementById('tqv-picture-url').value,
		  name: 'Noble Soft',
		  caption: 'http://noble-soft.com',
		  description: 'This #verse picture from the holy #quran is created with the help of #software from #noble-soft.com'
		  
		};
		
		function callback(response) {
		  document.getElementById('fb_post_id').innerHTML = "Post ID: " + response['post_id'];
		}
 
		FB.ui(obj, callback);
	  }

