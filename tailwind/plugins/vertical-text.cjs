const plugin = require('tailwindcss/plugin.js');
const verticalText = plugin(({ addUtilities }) => {
  const newUtilities = {
    '.horizontal-tb': {
      writingMode: 'horizontal-tb',
    },
    '.vertical-rl': {
      writingMode: 'vertical-rl',
    },
    '.vertical-lr': {
      writingMode: 'vertical-lr',
    },
  };
  addUtilities(newUtilities);
});

module.exports = { verticalText };
