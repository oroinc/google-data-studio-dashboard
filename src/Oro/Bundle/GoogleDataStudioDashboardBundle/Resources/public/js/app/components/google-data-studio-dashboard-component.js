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
            defaultValueIds: ['widgets', 'seller_dashboard'],
            googleDataStudioId: 'google_data_studio',
            selectors: {
                type: '[name="oro_dashboard[dashboardType]"]',
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

            if (this.shouldShowDependentField()) {
                this._showEmbedUrl();
            }

            this.fields.type.on('change', this.onTypeChanged.bind(this));
            this.fields.startDashboard.on('change', this.onStartDashboardChanged.bind(this));
        },

        onTypeChanged: function(e) {
            if (this.shouldShowDependentField()) {
                this._showEmbedUrl();
            } else {
                this._hideEmbedUrl();
            }
        },

        onStartDashboardChanged: function(e) {
            if (e.target.value !== '') {
                this._hideEmbedUrl();
            } else {
                this._showEmbedUrl();
            }
        },

        _hideEmbedUrl: function() {
            this.fields.embedUrl.addClass('hide');
            this.fields.embedUrl.closest('div.control-group').addClass('hide');
        },

        _showEmbedUrl: function() {
            if (this.shouldShowDependentField()) {
                this.fields.embedUrl.removeClass('hide');
                this.fields.embedUrl.closest('div.control-group').removeClass('hide');
            }
        },

        isValueSelected: function() {
            return this.fields.type.val() === this.options.googleDataStudioId;
        },

        shouldShowDependentField: function() {
            // We show the embed_url field if we selected this value or not the default one
            // Fallback in case we have several similar dashboards extensions enabled
            return this.isValueSelected()
                || (this.fields.type.val() !== '' && !this.options.defaultValueIds.includes(this.fields.type.val()));
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
        }
    });

    return GoogleDataStudioDashboardComponent;
});
