(function (global) {
    // TODO: make this global
    var stopWords = {
        eng: ["i", "me", "my", "myself", "we", "our", "ours", "ourselves", "you", "your", "yours", "yourself", "yourselves", "he", "him", "his", "himself", "she", "her", "hers", "herself", "it", "its", "itself", "they", "them", "their", "theirs", "themselves", "what", "which", "who", "whom", "this", "that", "these", "those", "am", "is", "are", "was", "were", "be", "been", "being", "have", "has", "had", "having", "do", "does", "did", "doing", "a", "an", "the", "and", "but", "if", "or", "because", "as", "until", "while", "of", "at", "by", "for", "with", "about", "against", "between", "into", "through", "during", "before", "after", "above", "below", "to", "from", "up", "down", "in", "out", "on", "off", "over", "under", "again", "further", "then", "once", "here", "there", "when", "where", "why", "how", "all", "any", "both", "each", "few", "more", "most", "other", "some", "such", "no", "nor", "not", "only", "own", "same", "so", "than", "too", "very", "s", "t", "can", "will", "just", "don", "should", "now"],
        por: ["a","acerca","adeus","agora","ainda","alem","algmas","algo","algumas","alguns","ali","além","ambas","ambos","ano","anos","antes","ao","aonde","aos","apenas","apoio","apontar","apos","após","aquela","aquelas","aquele","aqueles","aqui","aquilo","as","assim","através","atrás","até","aí","baixo","bastante","bem","boa","boas","bom","bons","breve","cada","caminho","catorze","cedo","cento","certamente","certeza","cima","cinco","coisa","com","como","comprido","conhecido","conselho","contra","contudo","corrente","cuja","cujas","cujo","cujos","custa","cá","da","daquela","daquelas","daquele","daqueles","dar","das","de","debaixo","dela","delas","dele","deles","demais","dentro","depois","desde","desligado","dessa","dessas","desse","desses","desta","destas","deste","destes","deve","devem","deverá","dez","dezanove","dezasseis","dezassete","dezoito","dia","diante","direita","dispoe","dispoem","diversa","diversas","diversos","diz","dizem","dizer","do","dois","dos","doze","duas","durante","dá","dão","dúvida","e","ela","elas","ele","eles","em","embora","enquanto","entao","entre","então","era","eram","essa","essas","esse","esses","esta","estado","estamos","estar","estará","estas","estava","estavam","este","esteja","estejam","estejamos","estes","esteve","estive","estivemos","estiver","estivera","estiveram","estiverem","estivermos","estivesse","estivessem","estiveste","estivestes","estivéramos","estivéssemos","estou","está","estás","estávamos","estão","eu","exemplo","falta","fará","favor","faz","fazeis","fazem","fazemos","fazer","fazes","fazia","faço","fez","fim","final","foi","fomos","for","fora","foram","forem","forma","formos","fosse","fossem","foste","fostes","fui","fôramos","fôssemos","geral","grande","grandes","grupo","ha","haja","hajam","hajamos","havemos","havia","hei","hoje","hora","horas","houve","houvemos","houver","houvera","houveram","houverei","houverem","houveremos","houveria","houveriam","houvermos","houverá","houverão","houveríamos","houvesse","houvessem","houvéramos","houvéssemos","há","hão","iniciar","inicio","ir","irá","isso","ista","iste","isto","já","lado","lhe","lhes","ligado","local","logo","longe","lugar","lá","maior","maioria","maiorias","mais","mal","mas","me","mediante","meio","menor","menos","meses","mesma","mesmas","mesmo","mesmos","meu","meus","mil","minha","minhas","momento","muito","muitos","máximo","mês","na","nada","nao","naquela","naquelas","naquele","naqueles","nas","nem","nenhuma","nessa","nessas","nesse","nesses","nesta","nestas","neste","nestes","no","noite","nome","nos","nossa","nossas","nosso","nossos","nova","novas","nove","novo","novos","num","numa","numas","nunca","nuns","não","nível","nós","número","o","obra","obrigada","obrigado","oitava","oitavo","oito","onde","ontem","onze","os","ou","outra","outras","outro","outros","para","parece","parte","partir","paucas","pegar","pela","pelas","pelo","pelos","perante","perto","pessoas","pode","podem","poder","poderá","podia","pois","ponto","pontos","por","porque","porquê","portanto","posição","possivelmente","posso","possível","pouca","pouco","poucos","povo","primeira","primeiras","primeiro","primeiros","promeiro","propios","proprio","própria","próprias","próprio","próprios","próxima","próximas","próximo","próximos","puderam","pôde","põe","põem","quais","qual","qualquer","quando","quanto","quarta","quarto","quatro","que","quem","quer","quereis","querem","queremas","queres","quero","questão","quieto","quinta","quinto","quinze","quáis","quê","relação","sabe","sabem","saber","se","segunda","segundo","sei","seis","seja","sejam","sejamos","sem","sempre","sendo","ser","serei","seremos","seria","seriam","será","serão","seríamos","sete","seu","seus","sexta","sexto","sim","sistema","sob","sobre","sois","somente","somos","sou","sua","suas","são","sétima","sétimo","só","tal","talvez","tambem","também","tanta","tantas","tanto","tarde","te","tem","temos","tempo","tendes","tenha","tenham","tenhamos","tenho","tens","tentar","tentaram","tente","tentei","ter","terceira","terceiro","terei","teremos","teria","teriam","terá","terão","teríamos","teu","teus","teve","tinha","tinham","tipo","tive","tivemos","tiver","tivera","tiveram","tiverem","tivermos","tivesse","tivessem","tiveste","tivestes","tivéramos","tivéssemos","toda","todas","todo","todos","trabalhar","trabalho","treze","três","tu","tua","tuas","tudo","tão","tém","têm","tínhamos","um","uma","umas","uns","usa","usar","vai","vais","valor","veja","vem","vens","ver","verdade","verdadeiro","vez","vezes","viagem","vindo","vinte","você","vocês","vos","vossa","vossas","vosso","vossos","vários","vão","vêm","vós","zero","à","às","área","é","éramos","és","último"],
    };
    if (CKEDITOR.plugins.get('word_synonyms')) {
        return;
    }

    global.CKEDITOR.on('instanceCreated', function (e) {
        const language = $('meta[name="LanguageCode"]').attr('content').split('-')[0];
        const instanceEditor = e.editor;
        const replaceRegexTag = function(text)
        {
            if( text.includes('<tag>') )
            {
                text = text.replace('<tag>', '<span style="background-color:#f9fcb3;">');
            }
            else
            {
               text = '<span style="background-color:#f9fcb3;">' + text;
            }
            if( text.includes('</tag>') )
            {
                text = text.replace('</tag>', '</span>');
            }
            else
            {
               text += '</span>';
            }
            return text;
        }
        var currentSelection = '';
        $('#' + instanceEditor.name).parent().find('.ez-richtext-tools').before(
                `
                <div class="mugo_action_axiom_operations">
                    <button class="btn getSynonymsAntonyms">Synonyms / Antonyms</button>
                    <button class="btn getEnding">Ending with</button>
                    <button class="btn getStarting">Starting with</button>
                    <button class="btn getContaining">Containing</button>
                    <br>
                    <button class="btn highlightLongSentences">Long sentences</button>
                    <button class="btn highlightEchoes">Echoes</button>
                    <button class="btn highlightNonNeutral">Non neutral</button>
                    <button class="btn highlightFlexion">Flexion</button>
                    <button class="btn highlightSuperlative">Superlatives</button>
                    <button class="btn highlightUncertainty">Uncertainties</button>
                    <div class="d-none">
                        Classifier Model: <input type="text" id="classifier_model" value="svm">
                        <br>Stemmer <input type="text" id="classifier_stemmer" value="true">
                    </div>
                    <br>
                    <button class="btn classifyParagraphs">Classify Paragraphs</button>
                    <br>
                    <button class="btn clearAll">Clear All</button>
                </div>
                <div class="mugo_word_synonyms">
                    <div class="results"></div>
                </div>
                <div class="mugo_word_long_sentences">
                    <div class="results"></div>
                </div>
                <div class="mugo_word_echoes">
                    <div class="results"></div>
                </div>
                <div class="mugo_word_neutral_analysis">
                    <div class="results"></div>
                </div>
                <div class="mugo_word_flexion_analysis">
                    <div class="results"></div>
                </div>
                <div class="mugo_word_superlatives">
                    <div class="results"></div>
                </div>
                <div class="mugo_word_uncertainties">
                    <div class="results"></div>
                </div>
                <div class="mugo_classifier">
                    <div class="results"></div>
                </div>
                `
        );
        const getSynonymsAntonyms = function()
        {
            $.ajax({
                    type: 'GET',
                    url: window.mugo_word_synonyms_get_url + '/' + window.mugo_word_synonyms_language + '/' + encodeURI(currentSelection),
                    dataType: "json",
                    success: function (data) {
                        var $html = '';
                        if(data.length > 0)
                        {
                            for(var i = 0; i < data.length; i++)
                            {
                                $html += '<div class="item">';
                                $html += '<h5>Type: ' + data[i].type + '</h5>';

                                $html += '<div class="row">';
                                    $html += '<div class="col-6 synonyms"><p>';
                                    $html += data[i].synonyms.join(', ');
                                    $html += '</p></div>';

                                    $html += '<div class="col-6 antonyms"><p>';
                                    $html += data[i].antonyms.join(', ');
                                    $html += '</p></div>';

                                $html += '</div>';
                                $html += '</div>';
                            }
                        }
                        else
                        {
                            $html = '<div class="item"><h5>Synonyms/Antonyms:</h5><div class="row"><div class="col-12 synonyms"><p>No results</p></div></div></div>';
                        }
                        $('#' + instanceEditor.name).parent().find('.mugo_word_synonyms .results').html($html);
                    }
            });
        }
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .clearAll').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            $('#' + instanceEditor.name).parent().find('.mugo_word_neutral_analysis .results').html('');
            $('#' + instanceEditor.name).parent().find('.mugo_word_synonyms .results').html('');
            $('#' + instanceEditor.name).parent().find('.mugo_word_echoes .results').html('');
            $('#' + instanceEditor.name).parent().find('.mugo_word_long_sentences .results').html('');
            $('#' + instanceEditor.name).parent().find('.mugo_word_flexion_analysis .results').html('');
            $('#' + instanceEditor.name).parent().find('.mugo_word_neutral_analysis .results').html('');
            $('#' + instanceEditor.name).parent().find('.mugo_word_superlatives .results').html('');
            $('#' + instanceEditor.name).parent().find('.mugo_word_uncertainties .results').html('');
            $('#' + instanceEditor.name).parent().find('.mugo_classifier .results').html('');
        });
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .highlightFlexion').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            // checking supported languages
            if(!['por'].includes(language))
            {
                alert('Not supported for ' + language + ' yet');
                return;
            }
            $('#' + instanceEditor.name).parent().find('.mugo_word_flexion_analysis .results').html('');
            $('#' + instanceEditor.name).find('p').each(function(){
                if( language == 'por' )
                {
                    $('#' + instanceEditor.name).parent().find('.mugo_word_flexion_analysis .results').append(
                        '<p>' +
                        $(this).text()
                            //.replace(/<\/?[^>]+(>|$)/g, " ") - not necessary to replace tags as it is already stripped
                            //.replace(/([`~!@#$%^&*()_|+\-=?;:'"“”,–.<>\{\}\[\]\\\/])/gi,' $1 ') - not replacing non word characters as we are going to show them
                            .replace(/&nbsp;/gimu, ' ')
                            // utf8 nbsp
                            .replace(/ /gimu, ' ')
                            // neutral
                            // [!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ] ponctuation excluding <>
                            .replace(/([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])(de|se|quase|e)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gimu,
                                        '$1<span class="neutralW">$2</span>$3')
                            // singular
                            .replace(/([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])(é|um)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gimu,
                                        '$1<span class="singularW">$2</span>$3')
                            // neutral
                            .replace(/([^!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ]+)?(ando)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gimu,
                                '<span class="neutralW">$1$2</span>$3')
                            // plural
                            .replace(/([^!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ]+)?(rão|entes|ões|am|são|ais)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gimu,
                                '<span class="pluralW">$1$2</span>$3')
                            // plural
                            .replace(/([^!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ]+)?(os|as|es)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gimu,
                                '<span class="pluralW">$1$2</span>$3')
                            // singular
                            .replace(/([^!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ]+)?(o|a|e|al)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gimu,
                                '<span class="singularW">$1$2</span>$3') +
                        '</p>'
                    );
                }
            });

        });
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .highlightSuperlative').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            // checking supported languages
            if(!['por', 'eng'].includes(language))
            {
                alert('Not supported for ' + language + ' yet');
                return;
            }
            $('#' + instanceEditor.name).parent().find('.mugo_word_superlatives .results').html('');
            $('#' + instanceEditor.name).find('p').each(function(){
                if( typeof window.mugo_data_dictionary_superlative !== 'undefined' )
                {
                    let currentText = $(this).text();
                    for(var i in window.mugo_data_dictionary_superlative)
                    {
                        let regexMap = window.mugo_data_dictionary_superlative[i].split('=>');
                        currentText = currentText.replace(new RegExp(regexMap[0], "gimu"), replaceRegexTag(regexMap[1]));
                    }
                    $('#' + instanceEditor.name).parent().find('.mugo_word_superlatives .results').append(
                        '<p>' + currentText + '</p>'
                    );
                }
            });

        });
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .highlightUncertainty').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            // checking supported languages
            if(!['por', 'eng'].includes(language))
            {
                alert('Not supported for ' + language + ' yet');
                return;
            }
            $('#' + instanceEditor.name).parent().find('.mugo_word_uncertainties .results').html('');
            $('#' + instanceEditor.name).find('p').each(function(){
                if( typeof window.mugo_data_dictionary_uncertainty !== 'undefined' )
                {
                    let currentText = $(this).text();
                    for(var i in window.mugo_data_dictionary_uncertainty)
                    {
                        let regexMap = window.mugo_data_dictionary_uncertainty[i].split('=>');
                        currentText = currentText.replace(new RegExp(regexMap[0], "gimu"), replaceRegexTag(regexMap[1]));
                    }
                    $('#' + instanceEditor.name).parent().find('.mugo_word_uncertainties .results').append(
                        '<p>' + currentText + '</p>'
                    );
                }
            });

        });
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .classifyParagraphs').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            // checking supported languages
            if(!['por', 'eng'].includes(language))
            {
                alert('Not supported for ' + language + ' yet');
                return;
            }
            $('#' + instanceEditor.name).parent().find('.mugo_classifier .results').html('');
            let paragraphs = [];
            $('#' + instanceEditor.name).find('p').each(function(){
                paragraphs.push($(this).text());
            });
            $.ajax({
                type: 'POST',
                url: window.mugo_mugo_classify_paragraphs_url + '/'+ $('#classifier_model').val() + '/' + window.mugo_word_synonyms_language + '/' + $('#classifier_stemmer').val(),
                data: { paragraphs: JSON.stringify(paragraphs) },
                dataType: "json",
                success: function (data) {
                    for(var i in data)
                    {
                        $('#' + instanceEditor.name).parent().find('.mugo_classifier .results').append('<p>' + data[i] + '</p>');
                    }
                }
            });
        });
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .highlightNonNeutral').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            // checking supported languages
            if(!['por', 'eng'].includes(language))
            {
                alert('Not supported for ' + language + ' yet');
                return;
            }
            $('#' + instanceEditor.name).parent().find('.mugo_word_neutral_analysis .results').html('');
            $('#' + instanceEditor.name).find('p').each(function(){
                switch(language)
                {
                    case 'por':
                        $('#' + instanceEditor.name).parent().find('.mugo_word_neutral_analysis .results').append(
                            '<p>' +
                            $(this).text()
                                .replace(/&nbsp;/gi, ' ')
                                // utf8 nbsp
                                .replace(/ /gi, ' ')
                                .replace(/([^!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ]+)?(ao|ão|endo|ente|entes)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gi,
                                    '<span class="neutralW">$1$2</span>$3')
                                .replace(/([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])(como)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gi,
                                    ' <span class="neutralW">$2</span>$3')
                                .replace(/([^!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ]+)?(a|as)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gi,
                                    '<span class="feminineW">$1$2</span>$3')
                                .replace(/([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])(um)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gi,
                                    ' <span class="masculineW">$2</span>$3')
                                .replace(/([^!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ]+)?(o|os)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gi,
                                    '<span class="masculineW">$1$2</span>$3') +
                            '</p>'
                        );
                        break;
                    case 'eng':
                        $('#' + instanceEditor.name).parent().find('.mugo_word_neutral_analysis .results').append(
                            '<p>' +
                            $(this).text()
                                .replace(/&nbsp;/gi, ' ')
                                // utf8 nbsp
                                .replace(/ /gi, ' ')
                                .replace(/([^!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ]+)?(she|her|herself|woman|women|girl|girls|female|females)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gi,
                                    '<span class="feminineW">$1$2</span>$3')
                                .replace(/([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])(he|his|himself|man|men|boy|boys|male|males)([!"#$%&'()*+,-.\/:;=?@\[\]\\^_‘\{|\}~ ])/gi,
                                    ' <span class="masculineW">$2</span>$3')
                                +
                            '</p>'
                        );
                        break;
                }
            });

        });
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .getSynonymsAntonyms').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            getSynonymsAntonyms();
        });
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .highlightLongSentences').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            $('#' + instanceEditor.name).parent().find('.mugo_word_long_sentences .results').html('');
            $('#' + instanceEditor.name).find('p').each(function(){
                let $currentParagraph = $(this);
                $currentParagraph.removeData('has-long-sentence');
                let $sentences = $currentParagraph.text().match(/[^\.!\?]+[\.!\?]+["']?|.+$/g);
                for(let i in $sentences)
                {
                    let wordsArray = $sentences[i]
                    .replace(/[`~!@#$%^&*()_|+\-=?;:'"“”,–.<>\{\}\[\]\\\/]/gi,' ')
                    .replace(/nbsp/gi, ' ')
                    // utf8 nbsp
                    .replace(/ /gi, ' ')
                    .split(' ')
                    .filter(function (el) {
                        return el.trim() != '';
                    });
                    if( wordsArray.length >= 35 )
                    {
                        $currentParagraph.data('has-long-sentence', 'true');
                        $currentParagraph.css('background-color', '#ffb0b0');
                        $('#' + instanceEditor.name).parent().find('.mugo_word_long_sentences .results').append('<p style="background-color:#ffb0b0;">' + $sentences[i] + '</p>');
                    }
                    else if( wordsArray.length >= 25 && !$currentParagraph.data('has-long-sentence'))
                    {
                        $currentParagraph.data('has-long-sentence', 'true');
                        $currentParagraph.css('background-color', '#fcfcc0');
                        $('#' + instanceEditor.name).parent().find('.mugo_word_long_sentences .results').append('<p style="background-color:#fcfcc0;">' + $sentences[i] + '</p>');
                    }
                    else if(!$currentParagraph.data('has-long-sentence'))
                    {
                        $currentParagraph.css('background-color', '');
                    }
                };
            });

        });
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .highlightEchoes').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            $('#' + instanceEditor.name).parent().find('.mugo_word_echoes .results').html('');
            let $text = instanceEditor.getData();
            let $textArray = $text
                .replace(/<\/?[^>]+(>|$)/g, " ")
                .toLowerCase()
                .replace(/[`~!@#$%^&*()_|+\-=?;:'"“”,–.<>\{\}\[\]\\\/]/gi,' ')
                .replace(/nbsp/gi, ' ')
                // utf8 nbsp
                .replace(/ /gi, ' ')
                .split(' ');

            let $echoes = [];
            for(let i in $textArray)
            {

                if( $textArray[i].trim() != '' )
                {
                    let $echoCounter = 0;
                    let indexVal = parseInt(i);
                    let rangeDiff = !stopWords[language].includes($textArray[i]) ? 125 : 2;
                    let $partialText = $textArray.slice( Math.max(0, indexVal - rangeDiff), Math.min($textArray.length - 1, indexVal + rangeDiff) );


                    for(let k in $partialText)
                    {
                        if( $partialText[k].startsWith($textArray[i]) )
                        {
                            $echoCounter++;
                            $partialText[k] = '<span style="background-color:#ffb0b0;">' + $partialText[k] + '</span>';

                        }
                    }
                    if( $echoCounter > 1 )
                    {
                        $echoes.push( $partialText.join(' ') );
                    }
                }
            }
            while( $echoes.length > 0 )
            {
                let $echo = $echoes.shift();
                let $found = false;
                $echoCompare = $echo.split('</span>');
                $echoCompare.pop();
                $echoCompare = $echoCompare.join('</span>').split('<span style="background-color:#ffb0b0;">');
                $echoCompare.shift();
                $echoCompare = $echoCompare.join('<span style="background-color:#ffb0b0;">');

                for(let i in $echoes)
                {
                    if($echoes[i].includes($echoCompare))
                    {
                        $found = true;
                        break;
                    }
                }
                if( !$found )
                {
                    $('#' + instanceEditor.name).parent().find('.mugo_word_echoes .results').append( $echo + '<br><br>' );
                }
            }

        });
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .getEnding').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            $.ajax({
                    type: 'GET',
                    url: window.mugo_word_synonyms_ending_url + '/' + window.mugo_word_synonyms_language + '/' + encodeURI(currentSelection),
                    dataType: "json",
                    success: function (data) {
                        var $html = '';
                        if(data.length > 0)
                        {
                            $html = '<div class="item"><h5>Ending:</h5><div class="row"><div class="col-12 synonyms"><p>' + data.join(', ') + '</p></div></div></div>';
                        }
                        else
                        {
                            $html = '<div class="item"><h5>Ending:</h5><div class="row"><div class="col-12 synonyms"><p>No results</p></div></div></div>';
                        }
                        $('#' + instanceEditor.name).parent().find('.mugo_word_synonyms .results').html($html);
                    }
            });
        });
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .getStarting').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            $.ajax({
                    type: 'GET',
                    url: window.mugo_word_synonyms_starting_url + '/' + window.mugo_word_synonyms_language + '/' + encodeURI(currentSelection),
                    dataType: "json",
                    success: function (data) {
                        var $html = '';
                        if(data.length > 0)
                        {
                            $html = '<div class="item"><h5>Starting:</h5><div class="row"><div class="col-12 synonyms"><p>' + data.join(', ') + '</p></div></div></div>';
                        }
                        else
                        {
                            $html = '<div class="item"><h5>Starting:</h5><div class="row"><div class="col-12 synonyms"><p>No results</p></div></div></div>';
                        }
                        $('#' + instanceEditor.name).parent().find('.mugo_word_synonyms .results').html($html);
                    }
            });
        });
        $('#' + instanceEditor.name).parent().find('.mugo_action_axiom_operations .getContaining').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            $.ajax({
                    type: 'GET',
                    url: window.mugo_word_synonyms_containing_url + '/' + window.mugo_word_synonyms_language + '/' + encodeURI(currentSelection),
                    dataType: "json",
                    success: function (data) {
                        var $html = '';
                        if(data.length > 0)
                        {
                            $html = '<div class="item"><h5>Containing:</h5><div class="row"><div class="col-12 synonyms"><p>' + data.join(', ') + '</p></div></div></div>';
                        }
                        else
                        {
                            $html = '<div class="item"><h5>Containing:</h5><div class="row"><div class="col-12 synonyms"><p>No results</p></div></div></div>';
                        }
                        $('#' + instanceEditor.name).parent().find('.mugo_word_synonyms .results').html($html);
                    }
            });
        });
        const handleSelection = function()
        {
            if (instanceEditor.isSelectionEmpty())
            {
                $('#' + instanceEditor.name).parent().find('.mugo_word_synonyms .results').html('');
                $('#' + instanceEditor.name).parent().find('.mugo_word_synonyms').hide();
            } else
            {
                $('#' + instanceEditor.name).parent().find('.mugo_word_synonyms').show();
                // gets the text from the begining of the paragraph to the current position
                var r = (instanceEditor.getSelection().getRanges()[ 0 ]);
                var docFr = r.cloneContents();
                currentSelection = docFr.$.textContent.trim();
            }
        }

        $('#' + instanceEditor.name).parent().keyup(handleSelection);
        $('#' + instanceEditor.name).parent().mouseup(handleSelection);
    });
})(window);