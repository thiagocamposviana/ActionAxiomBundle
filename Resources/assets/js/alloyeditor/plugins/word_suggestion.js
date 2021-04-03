(function (global) {
    if (CKEDITOR.plugins.get('word_suggestion')) {
        return;
    }

    const InsertText = {
        exec: function (editor, text) {
            const lastIndex = window.mugo_suggestion_current_text.lastIndexOf(" ");
            const rootText = window.mugo_suggestion_current_text.substring(0, lastIndex);
            editor.insertHtml( rootText + ' ' + text + ' ');
        },
    };

    global.CKEDITOR.plugins.add('word_suggestion', {
        init: (editor) => editor.addCommand('InsertText', InsertText),
    });
    global.CKEDITOR.on('instanceCreated', function (e) {
        // not using "key" event because the current text is updated after
        e.editor.on('change', function (event) {
            // gets the text from the begining of the paragraph to the current position
            var r = (event.editor.getSelection().getRanges()[ 0 ]);
            r.collapse( 1 );
            r.setStartAt( ( r.startPath().block || r.startPath().blockLimit ).getFirst(), global.CKEDITOR.POSITION_AFTER_START );

            var docFr = r.cloneContents();
            // not using docFr.getHtml() because we want just the raw text
            window.mugo_suggestion_current_text = docFr.$.textContent;
            window.mugo_suggestion_current_editor = e.editor;

        });
    });

})(window);