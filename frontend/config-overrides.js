/* eslint import/no-extraneous-dependencies:0 */
const { addBabelPlugin, override } = require("customize-cra");

module.exports = override(
  addBabelPlugin([
    "babel-plugin-root-import",
    {
      rootPathSuffix: "src"
    }
  ])
);
