const path = require('path');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

module.exports = {
  entry: './js/scripts.js',

  output: {
    // output to ./js/scripts-bundle.js
    path: path.resolve(__dirname, 'js'),
    filename: 'scripts-bundled.js',
    // the link to the js file is
    //   http://localhost:8080/assets/scripts-bundled.js
    publicPath: '/assets/',
  },

  module: {
    rules: [
      {
        test: /\.js$/, // what extension the rule applies to
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
        },
      },
    ],
  },

  plugins: [
    // new HtmlWebpackPlugin({
    //   template: './src/index.html',
    //   filename: './index.html',
    // }),
    new BrowserSyncPlugin(
      {
        host: 'localhost',
        port: 3000,
        files: ['*.php'],
        // proxy request to the Apache server
        proxy: 'http://localhost/wordpress',
      },
      {
        // prevent BrowserSync from reloading the page
        // and let Webpack Dev Server take care of this
        // Webpack Dev Server will try to update with HMR
        // before trying to reload the whole page
        reload: false,
      }
    ),
  ],
};
