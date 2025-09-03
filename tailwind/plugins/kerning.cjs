const plugin = require("tailwindcss/plugin.js");

const kerning = plugin(function ({ addUtilities }) {
  addUtilities({
    ".kerning": {
      fontKerning: "auto",
      fontFeatureSettings: "'palt'",
    },
    ".not-kerning": {
      fontKerning: "none",
      fontFeatureSettings: "normal",
    },
  });
});

module.exports = { kerning };