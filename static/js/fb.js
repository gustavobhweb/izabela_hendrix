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
                    $('#enviar-foto').fadeOut(400, function(){
                        $('#crop').fadeIn();
                        var url = response.url;

                        $('.jcrop').html('<div class="cropMain"></div><p>Ajustar o zoom:</p><div class="cropSlider"></div>');
                        var one = new CROP();
                        one.init('.jcrop');
                        one.loadImg(url);

                        $('.btn-make-crop').click(function(){
                            var _thisBtn = $(this);
                            $('.return-modal-menu').hide(0, function(){
                                _thisBtn.html('Salvando...');
                                _thisBtn.attr('disabled', 'disabled');
                            });

                            base64data = response.base64;
                            $.ajax({
                                url: '/home/cropimage/?' + $.param(coordinates(one)),
                                type: 'POST',
                                data: {
                                    img: base64data
                                },
                                success: function(data) {
                                    $('.modal-photo').fadeOut(500, function(){
                                        $('#crop').hide();
                                        $('#enviar-foto').show();
                                        $('.userPhoto.after-choice').attr({
                                            'src': data.url,
                                            'data-selected': 'true'
                                        });
                                    });
                                },
                                error: function()
                                {
                                    alert('Problemas na conexão!');
                                }
                            });
                            imageFile = null;
                        });
                    });
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