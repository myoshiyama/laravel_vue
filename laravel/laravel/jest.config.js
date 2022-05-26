module.exports = {
  preset: '@vue/cli-plugin-unit-jest/presets/no-babel',
  moduleFileExtensions: [
    'js',
    'vue'
  ],
  transform: {
    '^.+\\.vue$': '@vue/vue3-jest'
  }
}