const path = require('path');

// Create Theme/Plugin config variable.
// Define path to the project from the WordPress root. This is used to output the correct path to the manifest.json.
const configData = getConfig(
  'wp-content/themes/znanje-za-buducnost/src/blocks/assets',
  'wp-content/themes/znanje-za-buducnost/public'
); // eslint-disable-line no-use-before-define

// Export config to use in other Webpack files.
module.exports = {
  proxyUrl: 'znanje.test',
  absolutePath: configData.absolutePath,
  outputPath: configData.outputPath,
  publicPath: configData.publicPath,
  fontsPath: configData.fontsPath,
  assetsEntry: configData.assetsEntry,
  assetsAdminEntry: configData.assetsAdminEntry,
  blocksEntry: configData.blocksEntry,
  blocksEditorEntry: configData.blocksEditorEntry,
};

// Generate all paths required for Webpack build to work.
function getConfig(assetsPathConfig, outputPathConfig) {

  // Clear all slashes from user config.
  const assetsPathConfigClean = assetsPathConfig.replace(/^\/|\/$/g, '');
  const outputPathConfigClean = outputPathConfig.replace(/^\/|\/$/g, '');

  // Create absolute path from the projects relative path.
  const absolutePath = path.resolve(`${__dirname}`, '..');

  // Create absolut assets path from users config.
  const absoluteAssetsPath = path.resolve(`${absolutePath}`, assetsPathConfigClean);

  // Create relative output path from users config.
  const relativeOutputPath = path.join('/', outputPathConfigClean);

  return {
    absolutePath,

    // Output files absolute location.
    outputPath: path.resolve(`${absolutePath}`, outputPathConfigClean),

    // Output files relative location, added before every output file in manifes.json. Should start and end with "/".
    publicPath: path.join(`${relativeOutputPath}`, '/'),

    // Source files relative locations.
    fontsPath: path.join(`${relativeOutputPath}`, 'fonts'),

    // Source files entries absolute locations.
    assetsEntry: path.resolve(`${absoluteAssetsPath}`, 'application.js'),
    assetsAdminEntry: path.resolve(`${absoluteAssetsPath}`, 'application-admin.js'),
    blocksEntry: path.resolve(`${absoluteAssetsPath}`, 'application-blocks.js'),
    blocksEditorEntry: path.resolve(`${absoluteAssetsPath}`, 'application-blocks-editor.js'),
  };
}
