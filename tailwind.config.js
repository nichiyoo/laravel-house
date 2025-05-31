import { fontFamily } from 'tailwindcss/defaultTheme'
import typography from '@tailwindcss/typography'
import forms from '@tailwindcss/forms'
import colors from 'tailwindcss/colors'
import animate from 'tailwindcss-animate'
import plugin from 'tailwindcss/plugin'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  safelist: [
    {
      pattern: /(bg|text|outline)-(base|amber|green|red)-(500)/,
    }
  ],
  theme: {
    extend: {
      container: {
        center: true,
      },
      fontFamily: {
        sans: ['var(--font-sans)', ...fontFamily.sans],
      },
      colors: {
        base: colors.gray,
        primary: colors.amber,
      },
      spacing: {
        side: '2rem',
        navbar: '5rem',
        content: 'calc(100dvh - 5rem)',
      },
      aspectRatio: {
        thumbnail: '3 / 2',
      },
    },
  },
  plugins: [
    typography,
    forms,
    animate,
    plugin(({ addVariant }) => {
      addVariant("both", ["&:focus", "&:hover"])
    })
  ],
}

