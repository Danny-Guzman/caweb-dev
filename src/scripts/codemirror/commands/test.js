import { syntaxHighlighting, HighlightStyle, syntaxTree, language } from "@codemirror/language"
import {getStyleTags, tags, highlightTree } from "@lezer/highlight"

export default function test(view){
    //console.log('Editor View')
    //console.log(view);  
  
    //console.log('Editor View State')
    //console.log(view.state);  
  
    /*view.state.config.compartments.forEach((element,key ) => {
      console.log( element)
    });*/

    let tree = syntaxTree(view.state);

    console.log(tree);

    tree.cursor().iterate(node => {
      console.log(node.name);

      if( 'ExpressionStatement' === node.name ){
        //console.log(node.name);
        //console.log(node.type);
      }

      if( node.type.isError ){
        console.log(`from: ${node.from}, to: ${node.to}`);
      }
    })
    //console.log(HighlightStyle);

  }