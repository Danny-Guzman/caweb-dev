/**
 * 
 * @see https://getbootstrap.com/docs/5.3/getting-started/webpack/#import-bootstrap
 * @see https://www.toptal.com/react/webpack-react-tutorial-pt-1
 */
const path = require('path');

//import path from 'path';

module.exports = {
  mode: 'none',
  entry: {
    admin: [
      './src/scss/admin.scss',
      'bootstrap/dist/js/bootstrap.bundle.js',
      './src/js/codemirror/',
    ]
  },
  module:{
      rules: [
        { 
          test: /\.s[ac]ss$/i, 
          use: [
            'style-loader', // Adds CSS to the DOM by injecting a `<style>` tag
            'css-loader', // Interprets `@import` and `url()` like `import/require()` and will resolve them
            {
              // Loader for webpack to process CSS with PostCSS
              loader: 'postcss-loader',
              options: {
                postcssOptions: {
                  plugins: () => [
                    autoprefixer
                  ]
                }
              }
            },
            'sass-loader', // Loads a SASS/SCSS file and compiles it to CSS
          ]
        }
      ],
  }
}