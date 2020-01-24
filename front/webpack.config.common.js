'use strict';

const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');

module.exports = {
  entry: {
    index: './src/index.js'
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        use: 'vue-loader'
      },
      {
        test: /\.js$/,
        use: 'babel-loader'
      },
      {
        test: /\.(js|vue)$/,
        use: 'eslint-loader',
        enforce: 'pre'
      },
      {
        test: /\.(png|PNG|svg|jpg|gif)$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[path][name].[ext]'
            }
          }
        ]
      }
    ]
  },
  resolve: {
    alias: {
      Animation: path.resolve(__dirname, 'src/animations'),
      Image: path.resolve(__dirname, 'static/img'),
      Component: path.resolve(__dirname, 'src/components'),
      Services: path.resolve(__dirname, 'src/services'),
      ApiClients: path.resolve(__dirname, 'src/services/apiClients'),
      Data: path.resolve(__dirname, 'src/data'),
      Class: path.resolve(__dirname, 'src/class'),
      Asset: path.resolve(__dirname, 'assets'),
      Src: path.resolve(__dirname, 'src'),
      Mixin: path.resolve(__dirname, 'src/mixin'),
      Scss: path.resolve(__dirname, 'src/scss')
    }
  },
  plugins: [
    new HtmlWebpackPlugin({
      title: 'Interface de recherche',
      chunks: ['index', 'vue'],
      filename: 'index.html',
      template: 'index.html',
      inject: true
    }),
    new VueLoaderPlugin(),
    new StyleLintPlugin({
      configFile: '.stylelintrc',
      context: 'src',
      files: ['**/*.{vue,css,scss}'],
      failOnError: false,
      quiet: false
    }),
    new VuetifyLoaderPlugin()
  ],
  optimization: {
    splitChunks: {
      cacheGroups: {
        vue: {
          reuseExistingChunk: true,
          test: /[\\/]node_modules[\\/]vue/,
          name: 'vue',
          chunks: 'all'
        }
      }
    }
  }
};
