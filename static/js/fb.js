window.fbAsyncInit = function(){

    FB.init({
        appId:  	'281097135417609',
        xfbml: 		true,
        version: 	'v2.0'
    });

    FB.login(function(response) {
        FB.api('/me', function(fbData){
            if (!$.isEmptyObject(fbData.error)) {   

                new wmDialog('Erro ao processar os dados. Atualize a página e tente novamente.', {
                    isHTML: true, 
                    width: 350,
                    height: 240,
                    btnCancelEnabled: false,
                    title: 'Alerta'
                }).open();
            }

        	$(function(){
        		$.post('/home/upload_facebook_photo', {idfacebook: fbData.id}, function(response){
        			var fullpath = '/' + response.fullpath;
                    $('.modal-photo').fadeOut(400, function(){
                        $('.userPhoto').attr({'src': fullpath, 'data-selected': "true"});    
                    });
        			
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

