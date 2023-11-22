import {language} from "@codemirror/language";
import {php} from "@codemirror/lang-php";
import {javascript} from "@codemirror/lang-javascript";
import {sql} from "@codemirror/lang-sql";

import {phpMsg, sqlMsg} from '../config';

export default function switchLanguages(view, lang = 'php'){
    let languageConf;
  
    view.state.config.compartments.forEach((element,key ) => {
      if(undefined !== element.language && element.language === view.state.facet(language)){
        languageConf = key;
      }
    });
    
    view.dispatch({ 
        effects: languageConf.reconfigure( 'sql' === lang ? sql() : php() ),
        changes: {
          from: 0,
          to: view.state.doc.length,
          insert: 'sql' === lang ? sqlMsg : phpMsg
        }  
      })
  }