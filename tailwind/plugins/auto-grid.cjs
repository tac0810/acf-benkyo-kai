const plugin = require('tailwindcss/plugin');
/**
 * Create a responsive grid layout without media queries using CSS Grid.
 *
 * This plugin is based on a method provided by Andy Bell on piccalil.li.
 * See: https://piccalil.li/tutorial/create-a-responsive-grid-layout-with-no-media-queries-using-css-grid/
 */
const autoGrid = plugin(
  ({ addComponents, matchComponents, theme }) => {
    const values = theme('autoGrid');

    matchComponents(
      {
        'auto-grid': (value) => ({
          display: 'grid',
          'grid-template-columns': `repeat(auto-fill, minmax(min(${value}, 100%), 1fr))`,
        }),
      },
      { values },
    );

    addComponents({
      '.auto-grid-none': {
        display: 'revert',
        'grid-template-columns': 'revert',
      },
    });
  },
  {
    theme: {
      autoGrid: ({ theme }) => ({
        ...theme('spacing'),
      }),
    },
  },
);

module.exports = { autoGrid };
