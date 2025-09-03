const plugin = require('tailwindcss/plugin.js');
const loadingState = plugin(({ addVariant }) => {
  addVariant('loading', 'html[data-loading] :where(&)');
});

module.exports = { loadingState };
