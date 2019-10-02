// Other build files.
const config = require('./webpack/config');

// Load plugins for postcss.
const autoPrefixer = require('autoprefixer');
const cssMqpacker = require('css-mqpacker');
const postcssFontMagician = require('postcss-font-magician');
const cssNano = require('cssnano');

// All Plugins used in production and development build.
const plugins = [
  autoPrefixer,
  postcssFontMagician({
    display: 'swap',
    hosted: [config.fontsPath],
    foundries: ['hosted'],
  }),
  cssMqpacker,
];

module.exports = () => {

  // // Use only for production build
  if (config.env === 'production') {
    plugins.push(cssNano);
  }

  return { plugins };
};
