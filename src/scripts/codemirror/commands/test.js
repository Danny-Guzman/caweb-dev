import { syntaxHighlighting, HighlightStyle } from "@codemirror/language"

export default function test(view){
    console.log('Editor View')
    console.log(view);  
  
    console.log('Editor View State')
    console.log(view.state);  
  
    view.state.config.compartments.forEach((element,key ) => {
      console.log( element)
    });

    console.log(HighlightStyle);

  }