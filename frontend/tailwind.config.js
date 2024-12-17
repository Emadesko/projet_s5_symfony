/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './public/**/*.html', // ou ton répertoire HTML spécifique
    './public/js/**/*.js', // ou ton répertoire JS si tu utilises des classes dans des fichiers JS
    './public/css/**/*.css' // ou ton répertoire CSS spécifique
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

