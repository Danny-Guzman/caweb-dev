import {showPanel} from "@codemirror/view";


function countWords(doc) {
    let count = 0, iter = doc.iter()
    while (!iter.next().done) {
        let inWord = false
        for (let i = 0; i < iter.value.length; i++) {
            let word = /\w/.test(iter.value[i])
            if (word && !inWord) {
                count++
            }
            inWord = word
        }
    }
        
    return `Word count: ${count}`
}

function wordCountPanel(view){
        let dom = document.createElement("div")
        dom.textContent = countWords(view.state.doc)
  
        return {
            dom,
            update(update){
                if (update.docChanged){
                    dom.textContent = countWords(update.state.doc)
                }
            }
        }
}

const wordCounter = [showPanel.of(wordCountPanel)];

export default wordCounter;