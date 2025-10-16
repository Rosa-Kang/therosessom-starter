/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './*.php',
    './inc/**/*.php',
    './template-parts/**/*.php',
    './assets/js/**/*.js'
  ],
  theme: {
    extend: {
      colors: {
        // Base colors from the design
        cream: {
          light: '#FBF8EF',
          DEFAULT: '#EBE5DD',
          dark: '#E3DDD3'
        },
        green: {
          light : '#EAE8DC'
        },
        brown: {
          light: '#8B7355',
          DEFAULT: '#6B5444',
          dark: '#4A3C2F'
        },
        pink: {
          light: '#F4C7C7',
          DEFAULT: '#E6B8B8',
          dark: '#D4A5A5'
        },
        taupe: '#B8AFA5',
        charcoal: '#2C2C2C'
      },
      fontFamily: {
        sans: ['Heebo', 'system-ui', '-apple-system', 'sans-serif'],
        serif: ['Scope One', 'Georgia', 'serif'],
        mono: ['Courier New', 'monospace'],
        cursive: ['Calligraffitti', 'cursive']
      },
      spacing: {
        '128': '32rem',
        '144': '36rem',
      },
      maxWidth: {
        '8xl': '88rem',
        '9xl': '96rem',
      },
      animation: {
        'fade-in': 'fadeIn 0.6s ease-in-out',
        'slide-up': 'slideUp 0.8s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        }
      }
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
  ],
}