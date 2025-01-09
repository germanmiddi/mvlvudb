module.exports = {
  mode: 'jit',
  content: [
    './src/**/*.{vue,js,ts,jsx,tsx}',
  ],
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // Opciones: 'media', 'class', false
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],

  
}
