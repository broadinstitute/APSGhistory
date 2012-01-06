define([PhpGen.Module.PG.Utils], function ()
{
    (function ($)
    {
        var methods =
        {
            init: function(options)
            {
                function ProcessImageThumbnails(context)
                {
                    var imagesToZoom = $("a[rel=zoom]", context);
                    if (imagesToZoom.length > 0)
                    {
                        require(PhpGen.ModuleList([PhpGen.Module.LightBox]), function()
                        {
                            imagesToZoom.lightbox();
                        });
                    }
                }

                function ProcessHeaderHints(context)
                {
                    $('.hinted_header', context).each(function(i) {
                        if ($(this).children('div.box_hidden_header').html())
                        {
                            require(PhpGen.ModuleList([PhpGen.Module.QTips]), function() {
                                $(this).qtip({
                                        container:  ('header_tip_' + i),
                                        content:($(this).children('div.box_hidden_header').html()),
                                        position: 'center',
                                        tip_class: 'qtip-wrapper-header'
                                    });

                            }.bind(this));
                        }
                    });
                }

                function ProcessHints(context)
                {
                    $('span.more_hint', context).each(function(i)
                    {
                        require(PhpGen.ModuleList([PhpGen.Module.QTips]), function() {
                            $(this).qtip(
                                {
                                    container: ('tip_' + i),
                                    content: ($(this).children('div.box_hidden').html()),
                                    position: 'center'
                                }
                            );
                        }.bind(this));
                    });
                }

                function ProcessValidationForms(context)
                {
                    ExtendedValidate();
                }

                function ProcessFixedHeader(context)
                {
                    if (IsBrowserVersion({msie: 8, opera: 'none'}))
                    {
                        if ($('table[fixed-header=true]', context).length > 0)
                        {
                            require([PhpGen.Module.FixedHeader], function()
                            {
                                if ($.browser.msie)
                                {
                                    $('table.grid th#actions', context).width('1%');
                                    $('table.grid th.row-selector', context).width('1%');
                                }

                                $('table[fixed-header=true]', context).fixedtableheader({
                                   headerrowsize: $('table[fixed-header=true]', context).attr('header-row-size')
                                });
                            });
                        }

                    }
                }

                function ProcessModalView(context)
                {
                    var link = $('a[modal-view=true]', context);
                    if (link.length > 0)
                    {
                        require(["pgui.modal_view"], function(modalView)
                        {
                            link.each(function(index, item)
                            {
                                var modalViewLink = new modalView.ModalViewLink($(item));
                            });
                        });
                    }
                }

                function ProcessModalCopy(context)
                {
                    var link = $('a[modal-copy=true]', context);
                    if (link.length > 0)
                    {
                        require(["pgui.modal_copy"], function(modalCopy)
                        {
                            link.each(function(index, item)
                            {
                                var modalCopyLink = new modalCopy.ModalCopyLink($(item));
                            });
                        });
                    }
                }

                function ProcessModalEdit(context)
                {
                    var link = $('a[modal-edit=true]', context);
                    if (link.length > 0)
                    {
                        require(["pgui.modal_edit"], function(modalEdit)
                        {
                            link.each(function(index, item)
                            {
                                var isInsert =  $(item).attr("is-insert") == 'true';
                                if (isInsert) return true;
                                
                                var modalEditLink = new modalEdit.ModalEditLink($(item));
                                $(item).data('modal-edit', modalEditLink);
                            });
                        });
                    }
                }

                function ProcessModalInsert(context)
                {
                    var link = $('a[modal-edit=true]', context);
                    if (link.length > 0)
                    {
                        require(["pgui.modal_insert"], function(modalInsert)
                        {
                            link.each(function(index, item)
                            {
                                var isInsert =  $(item).attr("is-insert") == 'true';
                                if (!isInsert) return true;

                                var modalInsertLink = new modalInsert.ModalInsertLink($(item));
                            });
                        });
                    }
                }

                function ProcessShortCuts(context)
                {
                    var buttonsWithShortCut = $('a[pgui-shortcut]', context);
                    if (buttonsWithShortCut.length > 0)
                    {
                        require([PhpGen.Module.PG.Shortcuts], function(shortcuts)
                        {
                            buttonsWithShortCut.each(function(index, item)
                            {
                                shortcuts.InitializeShortCuts($(item));
                            });
                        })
                    }
                }

                this.each(function(index, element)
                {
                    ProcessImageThumbnails(element);
                    ProcessValidationForms(element);
                    ProcessFixedHeader(element);
                    ProcessHints(element);
                    ProcessHeaderHints(element);
                    ProcessModalView(element);
                    ProcessModalCopy(element);
                    ProcessModalEdit(element);
                    ProcessModalInsert(element);
                    ProcessShortCuts(element);
                });
            }
        }

        $.fn.pgui_unobtrusive = function( method )
        {
            if (methods[method])
            {
                return methods[method].apply(this,
                    Array.prototype.slice.call(arguments, 1)
                );
            }
            else if (typeof method === 'object' || !method)
            {
                return methods.init.apply(this, arguments);
            }
            else
            {
                $.error('Method ' +  method + ' does not exist on jQuery.pgui_effects');
            }
        };
    })(jQuery);

    $(function()
    {
        $(document).pgui_unobtrusive();
    });

});
