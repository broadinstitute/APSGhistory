/**
 * jQuery-Plugin "clearField"
 * 
 * @version: 1.0, 31.07.2009
 * 
 * @author: Stijn Van Minnebruggen
 *          stijn@donotfold.be
 *          http://www.donotfold.be
 * 
 * @example: $('selector').clearField();
 * @example: $('selector').clearField({ blurClass: 'myBlurredClass', activeClass: 'myActiveClass' });
 * 
 */

(function($) {

    jQuery.fn.clearField = function(settings) {
	
        settings = jQuery.extend({
            blurClass: 'clearFieldBlurred',
            activeClass: 'clearFieldActive'
        }, settings);

        jQuery(this).each(function() {
		
            var el = jQuery(this);

            if (el.attr('value') == undefined || el.attr('value') == '') {
                el.attr('value', el.attr('blur-text')).addClass(settings.blurClass);
            }

            if(el.attr('rel') == undefined) {
                el.attr('rel', el.attr('blur-text')).addClass(settings.blurClass);
            }
            el.focus(function() {	
                if(el.val() == el.attr('rel')) {
                    el.val('').removeClass(settings.blurClass).addClass(settings.activeClass);
                }	
            });
            el.blur(function() {
                if(el.val() == '') {
                    el.val(el.attr('rel')).removeClass(settings.activeClass).addClass(settings.blurClass);
                }
            });
        });
        return jQuery;
    };

})(jQuery);
