define([], function()
{
    var exports = {};

    PhpGen.Localizer = new Class({
        initialize: function(localizationResource)
        {
            this.localizationResource = localizationResource;
            this.localizedStrings = {};
        },

        loadLocalization: function()
        {
            $.getJSON(this.localizationResource,
                function (data) {
                    _.extend(this.localizedStrings, data);
                }.bind(this));
        },

        getString: function(code, defaultValue)
        {
            return _.isUndefined(this.localizedStrings[code]) ? defaultValue : this.localizedStrings[code];
        }
    });

    exports.localizer = new PhpGen.Localizer('components/js/jslang.php');
    exports.localizer.loadLocalization();

    return exports;
});