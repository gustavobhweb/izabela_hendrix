window.fbAsyncInit = function(){
    FB.init({
        appId: '281097135417609',
        xfbml:  true,
        version:'v2.0'
    });


    $(function(){

        var facebookCallAction;
        
        var me = function(){
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

                $.post('/home/upload_facebook_photo', {idfacebook: fbData.id}, function(response){
                    console.log(response)
                }); 
            });
        }

        FB.getLoginStatus(function(response) {

            if (response.status == 'connected') {
                facebookCallAction = function(e){
                    e.preventDefault();
                    me();                    
                }

            } else if(response.status == 'not_authorized'){

                facebookCallAction = function(e){
                    e.preventDefault();
                   
                    new wmDialog('Acesso não autorizado.', {
                        isHTML: true, 
                        width: 350,
                        height: 240,
                        btnCancelEnabled: false,
                        title: 'Alerta'
                    }).open();
                }

            } else {
            
                facebookCallAction = function(e){
                    e.preventDefault();
                    
                    FB.login(function(response) {
                        if (response.authResponse) {
                            me();
                            console.log('after timeout, call this');
                        }   
                    });
                }

            }
            
            $(document).on('click', '.btn-fb-photo', facebookCallAction);    
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