const path = require('path');
// const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
  entry: './js/scripts.js',
  // entry: './src/index.js',

  output: {
    // output to ./assets/scripts-bundle.js
    //
    path: path.resolve(__dirname, 'js'),
    filename: 'scripts-bundled.js',
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
  // plugins: [
  //   new HtmlWebpackPlugin({
  //     template: './src/index.html',
  //     filename: './index.html',
  //   }),
  // ],
};
