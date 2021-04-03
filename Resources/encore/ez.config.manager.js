const path = require('path');

module.exports = (eZConfig, eZConfigManager) => {
    eZConfigManager.add({
        eZConfig,
        entryName: 'ezplatform-richtext-onlineeditor-js',
        newItems: [
            path.resolve(__dirname, '../assets/js/alloyeditor/plugins/word_synonyms.js'),
            path.resolve(__dirname, '../assets/js/alloyeditor/plugins/word_cloud.js'),
            path.resolve(__dirname, '../assets/js/alloyeditor/buttons/word_suggestion.js'),
            path.resolve(__dirname, '../assets/js/alloyeditor/plugins/word_suggestion.js'),
        ],
    });
    eZConfigManager.add({
        eZConfig,
        entryName: 'ezplatform-richtext-onlineeditor-css',
        newItems: [
            path.resolve(__dirname, '../assets/scss/mugo_editor_synonyms.scss'),
            path.resolve(__dirname, '../assets/scss/mugo_editor_cloud.scss'),
            path.resolve(__dirname, '../assets/scss/mugo_editor_suggestion.scss'),
        ],
    });
};