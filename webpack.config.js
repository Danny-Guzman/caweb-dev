/**
 * 
 * @see https://getbootstrap.com/docs/5.3/getting-started/webpack/#import-bootstrap
 * @see https://www.toptal.com/react/webpack-react-tutorial-pt-1
 */
const MiniCssExtractPlugin = require("mini-css-extract-plugin")
//import path from 'path';

module.exports = {
  mode: 'none',
  plugins: [new MiniCssExtractPlugin({
    linkType: "text/css",
  })],
  output: {
    clean: true
  },
  experiments: {
    topLevelAwait: true
  },
  entry: {
    admin: [
      './src/scripts/admin',
      './src/styles/admin.scss',
      'bootstrap/dist/js/bootstrap.bundle.js',
      './src/scripts/codemirror/',
    ]
  },
  module:{
      rules: [
        { 
          test: /\.[s]?css$/i, 
          use: [
           //MiniCssExtractPlugin.loader,
           'style-loader',
           'css-loader', // Interprets `@import` and `url()` like `import/require()` and will resolve them
            {
              // Loader for webpack to process CSS with PostCSS
              loader: 'postcss-loader',
              options: {
                postcssOptions: {
                  plugins: [
                    "autoprefixer" ,
                  ]
                }
              }
            },
            'sass-loader', // Loads a SASS/SCSS file and compiles it to CSS,
            /*{
              loader: 'style-loader',
              options: {
                injectType: 'linkTag'
              }
            },*/
            //'file-loader',
          ]
        }
      ],
  }
}