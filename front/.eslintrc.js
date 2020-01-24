module.exports = {
    parserOptions: {
        parser: 'babel-eslint'
    },
    extends: [
        'plugin:vue/recommended',
        'standard'
    ],
    rules: {
        semi: [2, "always"],
        "no-tabs": ["error", { allowIndentationTabs: true }],
        "vue/require-prop-types":0,
        "vue/require-default-prop":0,
        "no-return-assign": 0
    },
    plugins: [
        'vue'
    ]
}