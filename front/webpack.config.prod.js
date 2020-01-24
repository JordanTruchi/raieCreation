'use strict';

const path = require('path');
const merge = require('webpack-merge');
const Dotenv = require('dotenv-webpack');
const CommonConfig = require('./webpack.config.common.js');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');

const config = {
  mode: 'production',
  output: {
    filename: 'js/[name].min.js',
    path: path.resolve(__dirname, 'dist')
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: {
              publicPath: '../'
            }
          },
          'css-loader',
          'sass-loader'
        ]
      }
    ]
  },
  plugins: [
    new CleanWebpackPlugin(),
    new CopyWebpackPlugin([{
      from: path.resolve(__dirname, 'static/img'),
      to: path.resolve(__dirname, 'dist/static/img'),
      toType: 'dir'
    }]),
    new MiniCssExtractPlugin({
      filename: 'css/[name].css'
    }),
    new Dotenv({
      path: './.prod.env',
      safe: true,
      systemvars: true,
      silent: true,
      defaults: false
    })
  ],
  optimization: {
    minimizer: [
      new TerserJSPlugin({}),
      new OptimizeCSSAssetsPlugin({})
    ]
  }
};

module.exports = merge.strategy({
  'module.rules': 'prepend'
})(CommonConfig, config);
