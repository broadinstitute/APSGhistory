define([PhpGen.Module.MooTools], function() {

    PhpGen.DropDownButton = new Class({
        Implements: Events,

        initialize: function(container)
        {
            var self = this;
            this.cancelBlur = false; // Workaround for hide menu on button blur

            this.container = container;
            this.container.wrap('<div></div>');

            this.drowDownHandler = $('<button>Menu</button>');
            this.container.after(this.drowDownHandler);
            this.defaultValue = this.container.val();

            this.list = $('#' + this.container.attr('data-drop-down-list'));
            this.list.addClass('ui-widget');
            this.list.mouseleave(function()
            {
                if (self.menuVisible && self.cancelBlur)
                    self._hideMenu();
            });

            this.itemCount = this.list.find('li').length;
            this.list.find('li').each(function(index, item)
            {
                if ($(item).attr('data-value') == self.container.attr('value'))
                    $(item).addClass('pgui-default');
                $(item).addClass('ui-state-default');
                if (index == 0)
                    $(item).addClass('ui-corner-tr');
                else if (index == self.itemCount - 1)
                    $(item).addClass('ui-corner-bottom');
            });
            this.list.find('li').hover(function()
            {
                $(this).addClass('ui-state-hover');
                $(this).css('cursor', 'pointer');
            },function()
            {
                $(this).removeClass('ui-state-hover');
                $(this).css('cursor', 'default');
            }).mousedown(function()
            {
                self.cancelBlur = true;
            })
            .click(function()
            {
                var value = $(this).attr('data-value');
                self.setDefaultAction(value);
                self._hideMenu();
                self._setHiddenInputValue(self.container.attr('name'), value);
                self.container.click();
                self.container.val(this.defaultValue);
            });

            this.menuVisible = false;

            this.container
                .button()
                .click(function(event) {
                    event.preventDefault();
                    var value = this.container.val();
                    if (self._findItemByValue(value) != null)
                        self._findItemByValue(value).trigger('item-click');
                }.bind(this))
                .next()
                    .button({
                        text: false,
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        }
                    })
                    .click(function(event){
                        event.preventDefault();
                        self.cancelBlur = false;
                        if (this.menuVisible)
                            this._hideMenu();
                        else
                            this._showMenu();
                    }.bind(this))
                    .blur(function()
                    {
                        (function() {
                            if (!self.cancelBlur)
                                this._hideMenu();
                        }).bind(this).delay(50);
                    }.bind(this))
                .parent().buttonset();
        },

        _findItemByValue: function(value)
        {
            var result = null;
            this.list.find('li').each(function(index, item)
            {
                if ($(item).attr('data-value') == value)
                    result = $(item);
            });
            return result;
        },

        _setHiddenInputValue: function(name, value)
        {
            if (!this.hiddenInput)
            {
                this.hiddenInput = $('<input type="hidden" />')
                this.container.after(this.hiddenInput);
            }

            this.hiddenInput.attr('name', name);
            this.hiddenInput.val(value);
        },

        onChangeAction: function(callback)
        {
            this.addEvent('onChangeActionEvent', callback);
        },

        setDefaultAction: function(eventValue)
        {
            var self = this;
            this.list.find('li').each(function(index, item)
            {
                if ($(item).attr('data-value') == eventValue)
                {
                    var value = $(item).attr('data-value');
                    //var text = $(item).text();
                    //self.container.button('option', 'label', text);
                    self.container.val(value);
                    self.fireEvent('onChangeActionEvent', [value]);
                }
            });
        },

        _showMenu: function()
        {
            this.container.removeClass('ui-corner-left').addClass('ui-corner-tl');
            this.drowDownHandler.removeClass('ui-corner-right').addClass('ui-corner-tr');
            this.list.show();
            this.menuVisible = true;
        },

        _hideMenu: function()
        {
            this.container.addClass('ui-corner-left').removeClass('ui-corner-tl');
            this.drowDownHandler.addClass('ui-corner-right').removeClass('ui-corner-tr');
            this.list.hide();
            this.menuVisible = false;
        }
    });

    PhpGen.createDropDownButton = function(container, options)
    {
        var buttons = options.buttons;

        var defaultButton = _.find(buttons, function(button) { return button.isDefault; });
       
        var saveButtonElement =
            $('<button type="button"></button>')
            .html(options.defaultButtonCaption)
            .val(defaultButton.value)
            .attr('data-drop-down-list', 'submit-button-list')
            .appendTo(container);

        var dropDownMenuItemsContainer = $('<div></div>');
        dropDownMenuItemsContainer.addClass('dropdown-button-menu');
        dropDownMenuItemsContainer.css('z-index', '100000');

        var dropDownMenuItems = $('<ul></ul>');
        dropDownMenuItems.css('z-index', '100000');
        dropDownMenuItems.hide();
        dropDownMenuItems.attr('id', 'submit-button-list');

        _.each(buttons, function(button)
        {
            var item = $('<li></li>');
            item.html(button.caption);
            item.attr('data-value', button.value);
            item.bind('item-click', button.click);
            dropDownMenuItems.append(item);
        });

        dropDownMenuItems.appendTo(dropDownMenuItemsContainer);
        dropDownMenuItemsContainer.appendTo(container);

        return saveButtonElement;
    };

});
