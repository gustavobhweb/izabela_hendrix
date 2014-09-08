window.fbAsyncInit = function(){

    FB.init({
        appId:  	'281097135417609',
        xfbml: 		true,
        version: 	'v2.0'
    });

    FB.login(function(response) {
        FB.api('/me', function(fbData){
        	$(function(){
        		$.post('/home/upload_facebook_photo', {idfacebook: fbData.id}, function(response){
        			var fullpath = '/' + response.fullpath;
        			$('.userPhoto').attr('src', fullpath);
        		});	
        	})
        });	
    });

};
    
(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);


}(document, 'script', 'facebook-jssdk'));

