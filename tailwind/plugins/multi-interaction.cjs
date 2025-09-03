const plugin = require("tailwindcss/plugin.js");
const multiInteraction = plugin(({ addVariant }) => {
  addVariant("multi-interaction", "&:is(:hover,:focus,.is-tapped)");
  addVariant("has-multi-interaction", "&:has(:hover,:focus,.is-tapped)");

  addVariant(
    "group-multi-interaction",
    ":merge(.group\\/multi-interaction):is(:hover,:focus,.is-tapped) &",
  );
});

module.exports = { multiInteraction };
