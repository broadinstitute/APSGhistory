(function($)
{
	$.fn.qtip = function(options)
	{
		var defaults =
		{
			container: 'qtip',
			content: '',
			position: 'center',
			nudge_top: 10,
			nudge_left: 0,
			preRender: function(e, tip){},
			postRender: function(e, tip){},
			onShow: function(e, tip){},
			onHide: function(e, tip){},
            tip_class: 'qtip-wrapper'
		};

		var options = $.extend(defaults, options);

		return this.each(function(i)
		{
			options.preRender($(this), $('#' + options.container + i));

			$('<div></div>').prependTo('body')
							.append($('<div></div>').append(options.content))
							.addClass(options.tip_class)
							.attr('id', options.container + i);

			$(this).hover(function()
			{
				var height = $('#' + options.container + i).height();
				var width = $('#' + options.container + i).width();

				switch(options.position)
				{
					default:
					case 'center':

						var top  = $(this).offset().top - (height + options.nudge_top);
						var left = $(this).offset().left + ($(this).width() / 2) + options.nudge_left - (width / 2);

						break;

					case 'left':

						var top  = $(this).offset().top - (height + options.nudge_top);
						var left = $(this).offset().left + options.nudge_left;

						break;

					case 'right':

						var top  = $(this).offset().top - (height + options.nudge_top);
						var left = $(this).offset().left + $(this).width() + options.nudge_left;

						break;

					case 'bottom':

						var top  = $(this).offset().top + ($(this).height() + options.nudge_top);
						var left = $(this).offset().left + ($(this).width() / 2) + options.nudge_left - (width / 2);

						break;
				}

				$('#' + options.container + i).fadeIn('fast').css('left', left).css('top', top);

				options.onShow($(this), $('#' + options.container + i));
			},
			function()
			{
				$('#' + options.container + i).fadeOut('fast');

				options.onHide($(this), $('#' + options.container + i));
			});

			options.postRender($(this), $('#' + options.container + i));
		});
	};
})(jQuery);