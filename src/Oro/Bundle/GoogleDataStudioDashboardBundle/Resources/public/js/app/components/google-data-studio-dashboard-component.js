define(function(require) {
    'use strict';

    const BaseComponent = require('oroui/js/app/components/base/component');

    const GoogleDataStudioDashboardComponent = BaseComponent.extend({
        /**
         * @property {Object}
         */
        fields: {},

        /**
         * @property {Object}
         */
        options: {
            googleDataStudioId: 'google_data_studio',
            selectors: {
                type: '[name="oro_dashboard[type]"]',
                embedUrl: '[name="oro_dashboard[embed_url]"]',
                startDashboard: '[name="oro_dashboard[startDashboard]"]',
            }
        },

        /**
         * @inheritDoc
         */
        constructor: function GoogleDataStudioDashboardComponent(options) {
            GoogleDataStudioDashboardComponent.__super__.constructor.call(this, options);
        },

        /**
         * @constructor
         *
         * @param {Object} options
         */
        initialize: function(options) {
            this.form = options._sourceElement.closest('form');
            this.fields.type = this.form.find(this.options.selectors.type);
            this.fields.embedUrl = this.form.find(this.options.selectors.embedUrl);
            this.fields.startDashboard = this.form.find(this.options.selectors.startDashboard);

            this.fields.type.on('change', this.onTypeChanged.bind(this));
            this.fields.startDashboard.on('change', this.onStartDashboardChanged.bind(this));
        },

        onTypeChanged: function(e) {
            if (e.target.value === this.options.googleDataStudioId) {
                this._showEmbedUrl();
            } else {
                this._hideEmbedUrl();
            }
        },

        onStartDashboardChanged: function(e) {
            if (e.target.value !== '') {
                this._hideType();
                this._hideEmbedUrl();
            } else {
                this._showType();
                this._showEmbedUrl();
            }
        },

        _hideType: function() {
            this.fields.type.addClass('hide');
            this.fields.type.closest('div.control-group').addClass('hide');
        },

        _showType: function() {
            this.fields.type.removeClass('hide');
            this.fields.type.closest('div.control-group').removeClass('hide');
        },

        _hideEmbedUrl: function() {
            this.fields.embedUrl.addClass('hide');
            this.fields.embedUrl.closest('div.control-group').addClass('hide');
        },

        _showEmbedUrl: function() {
            if (this.fields.type.val() === this.options.googleDataStudioId) {
                this.fields.embedUrl.removeClass('hide');
                this.fields.embedUrl.closest('div.control-group').removeClass('hide');
            }
        },

        /**
         * @inheritDoc
         */
        dispose: function() {
            if (this.disposed) {
                return;
            }

            this.form = null;
            this.fields = {};

            GoogleDataStudioDashboardComponent.__super__.dispose.call(this);
        },
    });

    return GoogleDataStudioDashboardComponent;
});
