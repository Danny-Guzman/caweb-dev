import {keymap} from "@codemirror/view";
import {defaultKeymap, history, historyKeymap, indentWithTab} from "@codemirror/commands";

import {execute} from '../commands';

const keyMapping = [
  keymap.of([
    ...defaultKeymap, 
    ...historyKeymap, 
    indentWithTab,
    {
        key: 'Mod-s',
        preventDefault: true,
        run: execute
    }
  ])
]
        
export default keyMapping;