// tailwind.config.js
const colors = require('tailwindcss/colors')

module.exports = {
  purge: [
     './resources/**/*.blade.php',
     './resources/**/*.js',
     './resources/**/*.vue',
   ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      keyframes: {
        'bounce': {
        '0%, 100%': { transform: 'translateY(0)' },
        '50%': { transform: 'translateY(-5px)' },
        }
      },
      animation: {
        'bounce': 'bounce 1s ease-in-out infinite',
      }
    },
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      black: colors.black,
      white: colors.white,
      gray: colors.trueGray,
      indigo: colors.indigo,
      red: colors.rose,
      yellow: colors.amber,
      blue: {
        'lightest': '#326a8c',
        'light': '#0c5988',
        'DEFAULT': '#003452',
      },
      pink: {
        'light': '#f7c3bd',
        'DEFAULT': '#db928a',
      }
    }
  },
  variants: {
    extend: {},
  },
}
