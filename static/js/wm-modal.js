function wmDialog(text)
{

    var $modal = $('#wm-alert').closest('.wm-modal').clone();
    var $body = $modal.find('.wm-modal-body');
    var $container = $modal.find('#wm-alert');
    var $cancel = $modal.find('.wm-modal-btn-cancel');
    var $confirm = $modal.find('.wm-modal-btn-confirm');
    var $close = $modal.find('.wm-modal-close');

    this.height = null;
    this.width = null;
    this.isHTML = false;
    this.btnCancelEnabled = true;

    this.btnCancel;
    this.btnConfirm;

    $confirm.click(function(){
        if ($.isFunction(this.onConfirm)) {
            this.onConfirm(this);
        } else {
            $modal.fadeOut();
        }
        
    });

    $cancel.add($close).click(function(){
        if ($.isFunction(this.onCancel)) {
            this.onCancel(this);
        } else {
            $modal.fadeOut();
        }
    });


    this.open = function(callback) {

        if (!this.btnCancelEnabled) {
            $cancel.remove();
        }

        if (!this.isHTML) {
            $body.text(text).fadeIn(500, callback);
        } else {
            $body.html(text).fadeIn(500, callback);
        }

        $container.height(this.height).width(this.width);

        if ($.isFunction(this.btnConfirm)) {
            this.btnConfirm($confirm);
        }

        if ($.isFunction(this.btnCancel)) {
            this.btnCancel($cancel);
        }

        $modal.appendTo($('body')).fadeIn();
    }

    this.close = function(){
        $modal.fadeOut(500);
    }

}