define([PhpGen.Module.MooTools], function()
{
    PhpGen.EditorsGlobalNotifier = new Class({
        Implements: Events,

        valueChanged: function(fieldName)
        {
            this.fireEvent('onValueChangedEvent', [fieldName], 0);
        },

        onValueChanged: function(callback)
        {
            this.addEvent('onValueChangedEvent', callback);
        }
    });

    PhpGen.CustomEditor = new Class({
        Implements: Events,

        initialize: function(rootElement)
        {
            this.rootElement = rootElement;
            this.fieldName = this.rootElement.attr('data-field-name');
            this.readOnly = this.rootElement.attr('data-editable') == 'false';
        },

        doChanged: function()
        {
            this.fireEvent('onChangeEvent', [this], 0);
        },

        getValue: function() { return null; },

        setValue: function(value) { },

        onChange: function(callback)
        {
            this.addEvent('onChangeEvent', callback);
        },

        finalizeEditor: function()
        { },

        getRootElement: function()
        {
            return this.rootElement;
        },

        getFieldName: function()
        {
            return this.fieldName;
        },

        isReadOnly: function()
        {
            return this.readOnly;
        },

        enabled: function(value) { return true; }
    });

    PhpGen.PlainEditor = new Class({ Extends: PhpGen.CustomEditor,
        initialize: function(rootElement)
        {
            this.parent(rootElement);
            this.rootElement.change(
                function() { this.doChanged(); }.bind(this)
            );
        },

        getValue: function()
        {
            return this.rootElement.val();
        },

        setValue: function(value)
        {
            this.rootElement.val(value);
        },

        isReadOnly: function()
        {
            return this.rootElement.attr('data-editable') == 'false';
        },

        enabled: function(value)
        {
            if (_.isUndefined(value))
            {
                return !this.rootElement.hasAttr('disabled');
            }
            else
            {
                if (this.enabled() != value)
                {
                    if (!value)
                    {
                        this.rootElement.addClass('disabled-editor');
                        this.rootElement.attr('disabled', 'true');
                    }
                    else
                    {
                        this.rootElement.removeClass('disabled-editor');
                        this.rootElement.removeAttr('disabled');
                    }
                }
            }
        }
    });

    PhpGen.CheckBox = new Class({ Extends: PhpGen.PlainEditor,
        getValue: function()
        {
            return this.rootElement.is(':checked');
        },

        setValue: function(value)
        {
            this.rootElement.attr('checked', value);
        }
    });

    PhpGen.TextEdit = new Class({ Extends: PhpGen.PlainEditor });

    PhpGen.TextArea = new Class({ Extends: PhpGen.PlainEditor });

    PhpGen.SpinEdit = new Class({ Extends: PhpGen.PlainEditor });

    PhpGen.htmlEditorGlobalNotifier = new PhpGen.EditorsGlobalNotifier();

    PhpGen.HtmlEditor = new Class({ Extends: PhpGen.CustomEditor,
        initialize: function(rootElement)
        {
            this.parent(rootElement);
            PhpGen.htmlEditorGlobalNotifier.onValueChanged(function(fieldName)
            {
                if (this.getFieldName() == fieldName)
                    this.doChanged();
            }.bind(this));
        },

        enabled: function(value)
        {
            if (_.isUndefined(value))
                return tinymce.get(this.rootElement.attr('id')).getDoc().designMode.toLowerCase() == 'on';
            else
                tinymce.get(this.rootElement.attr('id')).getDoc().designMode = (value ? 'On' : 'Off');
        },

        finalizeEditor: function()
        {
            if (tinyMCE)
                if (tinyMCE.get(this.getRootElement().attr('id')))
                    tinyMCE.get(this.getRootElement().attr('id')).remove();
        },

        getValue: function()
        {
            return this.rootElement.html();
        },

        setValue: function(value)
        {
            this.rootElement.html(value);
        }
    });

    PhpGen.dateTimeGlobalNotifier = new PhpGen.EditorsGlobalNotifier();

    PhpGen.DateTimeEdit = new Class({ Extends: PhpGen.PlainEditor,
        initialize: function(rootElement)
        {
            this.parent(rootElement);
            PhpGen.dateTimeGlobalNotifier.onValueChanged(function(fieldName)
            {
                if (this.getFieldName() == fieldName)
                    this.doChanged();
            }.bind(this));
        }
    });

    PhpGen.ComboBoxEditor = new Class({ Extends: PhpGen.PlainEditor,

        getValue: function()
        {
            if (this.isReadOnly())
                return this.rootElement.text();
            else
                return this.parent();
        },

        clear: function()
        {
            if (!this.isReadOnly())
            {
                this.rootElement.find("option:enabled[value!='']").remove();
            }
        },

        addItem: function(value, caption)
        {
            if (!this.isReadOnly())
            {
                this.rootElement.append($("<option></option>").attr('value', value).html(caption));
            }
        },

        getItems: function()
        {
            if (!this.isReadOnly())
            {
                return this.rootElement.find("option:enabled[value!='']").map(function(i, item)
                {
                    return { value: $(item).attr('value'), caption: $(item).text() };
                });
            }
            return [];
        }
    });

    PhpGen.RadioEdit = new Class({ Extends: PhpGen.CustomEditor,

        getValue: function()
        {
            return this.rootElement.find("input:checked").attr('value');
        },

        setValue: function(value)
        {
            this.rootElement.find("input").each(function(i, item)
            {
                if ($(item).attr('value') == value)
                    $(item).attr('checked', true);
            });
        },

        clear: function()
        {
            if (!this.isReadOnly())
            {
                this.rootElement.find("label").remove();
            }
        },

        addItem: function(value, caption)
        {
            if (!this.isReadOnly())
            {
                this.rootElement.append(
                    $("<label></label>")
                        .append(
                            $("<input>")
                                .attr('value', value)
                                .attr('type', 'radio')
                                .attr('name', this.rootElement.attr('data-editor-name'))
                                .attr('id', this.rootElement.attr('data-editor-name'))
                        )
                        .append($('<span></span>').text(caption))
                );
            }
        },

        getItems: function()
        {
            if (!this.isReadOnly())
            {
                return this.rootElement.find("input").map(function(i, item)
                {
                    return { value: $(item).attr('value'), caption: $(item).closest('label').text() };
                });
            }
            return [];
        }

    });

    PhpGen.CheckBoxGroup = new Class({ Extends: PhpGen.CustomEditor,

        initialize: function(rootElement)
        {
            this.parent(rootElement);
            this.rootElement.find("input").change(function() {
                this.doChanged();
            }.bind(this));
        },

        getValue: function()
        {
            return _.toArray(this.rootElement.find("input:checked").map(function(index, item)
                {
                    return $(item).attr('value');
                }));
        },

        setValue: function(value)
        {
            if (_.isString(value))
            {
                this.rootElement.find("input").each(function(i, item)
                {
                    if ($(item).attr('value') == value)
                        $(item).attr('checked', true);
                });
            }
            else
            {
                this.rootElement.find("input").each(function(i, item)
                {
                    if ($(item).attr('value') == value)
                        $(item).attr('checked', true);
                });
            }

        },

        clear: function()
        {
            if (!this.isReadOnly())
            {
                this.rootElement.find("label").remove();
            }
        },

        addItem: function(value, caption)
        {
            if (!this.isReadOnly())
            {
                this.rootElement.append(
                    $("<label></label>")
                        .append(
                            $("<input>")
                                .attr('value', value)
                                .attr('type', 'checkbox')
                                .attr('name', this.rootElement.attr('data-editor-name'))
                                .attr('id', this.rootElement.attr('data-editor-name'))
                        )
                        .append($('<span></span>').text(caption))
                );
            }
        },

        getItems: function()
        {
            if (!this.isReadOnly())
            {
                return this.rootElement.find("input").map(function(i, item)
                {
                    return { value: $(item).attr('value'), caption: $(item).closest('label').text() };
                });
            }
            return [];
        }
    });

    PhpGen.autoCompleteGlobalNotifier = new PhpGen.EditorsGlobalNotifier();

    PhpGen.AutoComplete = new Class({ Extends: PhpGen.CustomEditor,

        initialize: function(rootElement)
        {
            this.parent(rootElement);
            PhpGen.autoCompleteGlobalNotifier.onValueChanged(function(fieldName)
            {
                if (this.getFieldName() == fieldName)
                    this.doChanged();

            }.bind(this));
        },

        getValue: function()
        {
            return this.rootElement.find("input.autocomplete-hidden").attr('value');
        },

        setValue: function(value)
        {
        }
    });

    PhpGen.MaskEdit = new Class({ Extends: PhpGen.PlainEditor });

    PhpGen.TimeEdit = new Class({ Extends: PhpGen.PlainEditor });

    PhpGen.EditorsController = new Class({
        Implements: Events,

        initialize: function(context)
        {
            this.context = context;
            this.editors = {};
            this.editorClasses =
            {
                TextEdit: PhpGen.TextEdit,
                TextArea: PhpGen.TextArea,
                SpinEdit: PhpGen.SpinEdit,
                HtmlEditor: PhpGen.HtmlEditor,
                DateTimeEdit: PhpGen.DateTimeEdit,
                ComboBox: PhpGen.ComboBoxEditor,
                MaskEdit: PhpGen.MaskEdit,
                TimeEdit: PhpGen.TimeEdit,
                CheckBox: PhpGen.CheckBox,
                RadioGroup: PhpGen.RadioEdit,
                CheckBoxGroup: PhpGen.CheckBoxGroup,
                Autocomplete: PhpGen.AutoComplete
            };
        },

        finalizeEditors: function()
        {
            for (var name in this.editors)
            {
                this.editors[name].finalizeEditor();
            }
        },

        captureEditors: function()
        {
            this._processEditors();
            this.fireEvent('onInitializedEvent', [this.editors]);
        },

        _getEditorClassByString: function(className)
        {
            for(var name in this.editorClasses) {
                if (name == className)
                    return this.editorClasses[name];
            }
        },

        _processEditors: function()
        {
            this.context.find("*[data-editor='true']").each(function(index, item)
            {
                var dataEditorClassStr = $(item).attr('data-editor-class');
                var editor = new (this._getEditorClassByString(dataEditorClassStr))($(item));

                this.editors[editor.getFieldName()] = editor;
                editor.onChange(function(sender) {
                    this.fireEvent('onEditorValueChangeEvent', [sender, this.editors])
                }.bind(this));
            }.bind(this));
        },

        onInitialized: function(callback)
        {
            this.addEvent('onInitializedEvent', callback);
        },

        onEditorValueChange: function(callback)
        {
            this.addEvent('onEditorValueChangeEvent', callback);
        }
    });

    PhpGen.DataOperation = {
        Edit: 1,
        Insert: 2
    };

    PhpGen.InitializeEditorsController = function(operation, context)
    {
        var callBacks =
        {
            EditorValuesChanged: function(){},
            InitForm: function(){}
        };

        if (operation == PhpGen.DataOperation.Edit)
        {
            if (_.isFunction(window.EditForm_EditorValuesChanged))
                callBacks.EditorValuesChanged = EditForm_EditorValuesChanged;
            if (_.isFunction(window.EditForm_Initialized))
                callBacks.InitForm = EditForm_Initialized;
        }
        else if (operation == PhpGen.DataOperation.Insert)
        {
            if (_.isFunction(window.InsertForm_EditorValuesChanged))
                callBacks.EditorValuesChanged = InsertForm_EditorValuesChanged;
            if (_.isFunction(window.InsertForm_Initialized))
                callBacks.InitForm = InsertForm_Initialized;
        }

        var editorsController = new PhpGen.EditorsController(context);
        editorsController.onInitialized(function(editors)
        {
            callBacks.InitForm(editors);
        });
        editorsController.onEditorValueChange(function(sender, editors)
        {
            callBacks.EditorValuesChanged(sender, editors);
        });
        editorsController.captureEditors();
        return editorsController;
    }

});
