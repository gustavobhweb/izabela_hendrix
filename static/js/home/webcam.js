$(document).ready(function(){

	pathArray = window.location.href.split( '/' );
	protocol = pathArray[0];
	host = pathArray[2];
	window.url = protocol + '//' + host;
	window.url = window.url + '/izabela_hendrix';

	$(function() {

		var pos = 0, ctx = null, image = [];

		var canvas = document.createElement("canvas");
		canvas.setAttribute('width', 320);
		canvas.setAttribute('height', 240);
		
		if (canvas.toDataURL) {

			ctx = canvas.getContext("2d");
			
			image = ctx.getImageData(0, 0, 320, 240);
		
			window.saveCB = function(data) {
				
				var col = data.split(";");
				var img = image;

				for(var i = 0; i < 320; i++) {
					var tmp = parseInt(col[i]);
					img.data[pos + 0] = (tmp >> 16) & 0xff;
					img.data[pos + 1] = (tmp >> 8) & 0xff;
					img.data[pos + 2] = tmp & 0xff;
					img.data[pos + 3] = 0xff;
					pos+= 4;
				}

				if (pos >= 4 * 320 * 240) {
					ctx.putImageData(img, 0, 0);
					$.post(window.url+"/home/upload_webcam_image/", {type: "data", image: canvas.toDataURL("image/png")});
					pos = 0;
				}

			};

		} else {

			window.saveCB = function(data) {
				image.push(data);
				
				pos+= 4 * 320;
				
				if (pos >= 4 * 320 * 240) {
					$.post(window.url+"/home/upload_webcam_image/", {type: "pixel", image: image.join('|')});
					pos = 0;
				}

			};
		}

		$('#btn-take-photo').click(function(){
			$('#enviar-foto').fadeOut(function(){
				$('#webcam').show();
				$("#camera").webcam({
					width: 320,
					height: 240,
					mode: "callback",
					swffile: window.url+"/static/js/home/jscam.swf",
					onTick: function() {},
					onSave: window.saveCB,
					onCapture: function() {
						webcam.save();
						//$('.userPhoto').attr('src', window.url+"/static/imagens/"+window.namePhoto);
					},
					debug: function() {},
					onLoad: function() {
						var a = 0;
						$('#takephoto').click(function(){
							if (a<1) {
								a++;
								$(this).click();
							} else {
								a = 0;
							}
							var datetimenow = new Date().getTime();
							window.namePhoto = $(this).attr('data-id') + '.png?time='+datetimenow;
							webcam.capture();
							$('.userPhoto').attr('src', window.url+"/static/imagens/"+window.namePhoto);
						});
					}
				});
			});	
		});

	});

})