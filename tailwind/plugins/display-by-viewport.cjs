const plugin = require('tailwindcss/plugin.js');
const displayByViewport = plugin(({ addComponents }) => {
  const displays = [
    'inline',
    'inline-block',
    'block',
    'inline-flex',
    'flex',
    'inline-grid',
    'grid',
  ];

  addComponents(
    displays.reduce((previousValue, currentValue) => {
      return {
        ...previousValue,
        [`.mobile-${currentValue}`]: {
          display: currentValue,
          '@screen sm': {
            display: 'none',
          },
        },

        // Add for tablet
        // [`.tablet-${currentValue}`]: {
        //   display: 'none',
        //   '@screen sm': { // @screen md
        //     display: currentValue,
        //   },
        //   '@screen sm': {
        //     display: 'none',
        //   },
        // },

        [`.desktop-${currentValue}`]: {
          display: 'none',
          '@screen sm': {
            display: currentValue,
          },
        },
      };
    }, {}),
  );
});

module.exports = { displayByViewport };
