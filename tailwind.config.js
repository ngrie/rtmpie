const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  variants: {},
  plugins: [
    require('@tailwindcss/ui'),
  ],
  purge: {
    content: [
      './assets/js/admin/**/*.vue',
    ],
    options: {
      // https://tailwindui.com/documentation#update-your-purgecss-configuration
      defaultExtractor: content => content.match(/[\w-/.:]+(?<!:)/g) || [],
    },
  },
}
