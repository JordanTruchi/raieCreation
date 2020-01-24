'use strict';

const path = require('path');
const webpack = require('webpack');
const merge = require('webpack-merge');
const Dotenv = require('dotenv-webpack');
const CommonConfig = require('./webpack.config.common.js');

const config = {
  mode: 'development',
  output: {
    filename: 'js/[name].js',
    path: path.resolve(__dirname, 'dist')
  },
  module: {
    rules: [
      {
        test: /\.s(c|a)ss$/,
        use: [
          'vue-style-loader',
          'css-loader',
          {
            loader: 'sass-loader',
            // Requires sass-loader@^7.0.0
            options: {
              implementation: require('sass'),
              fiber: require('fibers')
            }
          }
        ]
      }
    ]
  },
  devServer: {
    index: 'index.html',
    hot: true,
    watchOptions: {
      poll: true
    }
  },
  plugins: [
    new webpack.HotModuleReplacementPlugin(),
    new Dotenv({
      path: './.dev.env',
      safe: true,
      systemvars: true,
      silent: true,
      defaults: false
    })
  ]
};

module.exports = merge.strategy({
  'module.rules': 'prepend'
})(CommonConfig, config);
