import {linter, lintGutter} from "@codemirror/lint"

import phpLint from './php';
import javascriptLint from './javascript';

const regexLinter = linter(view => {
  return [].concat(
    phpLint(view),
  );
})

const linting = [
    regexLinter, 
    lintGutter()
  ];

  
export default linting;
