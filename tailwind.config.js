const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  variants: {
    display: ['responsive', 'group-hover'],
  },
  plugins: [
    require('@tailwindcss/ui'),
  ],
  purge: {
    content: [
      './assets/js/admin/**/*.vue',
      './templates/**/*.html.twig',
    ],
    options: {
      // https://tailwindui.com/documentation#update-your-purgecss-configuration
      defaultExtractor: content => content.match(/[\w-/.:]+(?<!:)/g) || [],
    },
  },
}
