$(function(){
	$('.imgSolic').tooltip({
        content: function() {
            return "<img width='200' src='" + $(this).attr('src') + "' />";
        },
        track: true
    });
});