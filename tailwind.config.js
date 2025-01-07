// tailwind.config.js
module.exports = {
  content: [
    "./resources/**/*.{html,blade.php,js}",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      animation: {
        fadeIn: 'fadeIn 1s ease-in',
        flyIn: 'flyIn 0.5s ease-out forwards', // fly-in animation over 0.5s
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: 0 },
          '100%': { opacity: 1 },
        },
        flyIn: {
          '0%': { transform: 'translateX(-100%)', opacity: 0 },
          '100%': { transform: 'translateX(0)', opacity: 1 },
        },
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}


