import {syntaxTree} from "@codemirror/language"

export default function javascriptLint(view){
    let lintDiagnostics = [];
    
    syntaxTree(view.state).cursor().iterate(node => {
        // no regex
        if (node.name == "RegExp"){
          lintDiagnostics.push({
            from: node.from,
            to: node.to,
            severity: "warning",
            message: "Regular expressions are FORBIDDEN",
            actions: [{
              name: "Remove",
              apply(view, from, to) { view.dispatch({changes: {from, to}}) }
            }]
          })
        } 
      })

      return lintDiagnostics;
}
