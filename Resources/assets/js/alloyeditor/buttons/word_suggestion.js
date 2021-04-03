import PropTypes from 'prop-types';
import AlloyEditor from 'alloyeditor';
import EzButton
    from '../../../../../../../../vendor/ezsystems/ezplatform-richtext/src/bundle/Resources/public/js/OnlineEditor/buttons/base/ez-button.js';

export default class BtnWordSuggestion extends EzButton {
    static get key() {
        return 'word_suggestion';
    }

    insertText(data) {
        this.execCommand(data);
    }

    render() {
        if( window.mugo_suggestion_current_text.endsWith(' ') || window.mugo_suggestion_current_text === '' )
        {
            return (<i></i>);
        }
        let words = window.mugo_word_suggestion_bag;
        let currentText = window.mugo_suggestion_current_text.split(" ").splice(-1)[0];

        let wordsStartingWith = words.filter(
                (word) => word.toLowerCase().startsWith(currentText.toLowerCase())
        );
        let items = [];
        for (let i = 0; i < wordsStartingWith.length && i < 15; i++) {
                wordsStartingWith[i] = currentText + wordsStartingWith[i].replace(currentText.toLowerCase(), '');
                let text = wordsStartingWith[i];
                items.push(<button
                                    className="ae-button ez-btn-ae ez-btn-ae--word_suggestion"
                                    onClick={this.insertText.bind(this, wordsStartingWith[i])}
                                    title={text}>
                                    {text}
                            </button>
                        )
        }
        if( items.length > 0 )
        {
            return (
                <div tabIndex={this.props.tabIndex} className="word-suggestion-area">
                    {items}
                </div>
            );
        }
        return (<i></i>);
    }
}

AlloyEditor.Buttons[BtnWordSuggestion.key] = AlloyEditor.BtnWordSuggestion = BtnWordSuggestion;
eZ.addConfig('ezAlloyEditor.BtnWordSuggestion', BtnWordSuggestion);

BtnWordSuggestion.propTypes = {
    command: PropTypes.string,
};

BtnWordSuggestion.defaultProps = {
    command: 'InsertText',
};