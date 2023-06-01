import {syntaxTree} from "@codemirror/language"

export default function phpLint(view){
    let lintDiagnostics = [];
    let lintActions = [{
      name: "Remove",
      apply(view, from, to) { 
        view.dispatch({
          changes: {
            from: 0, 
            to, 
            insert:'hi'
          }
        }) 
      }
    }];

    syntaxTree(view.state).cursor().iterate(node => {
      if( node.type.isError ){
        lintDiagnostics.push({
          from: node.from,
          to: node.to,
          severity: "error",
          message: "An error was detected",
          actions: []
        })
      }

    })
    /*
    syntaxTree(view.state).cursor().iterate(node => {
      
      if( node.type.isError ){
        console.log(node);
        console.log(`from: ${node.from}, to: ${node.to}`);
        
      }
    })*/

    return lintDiagnostics;
}
