const plugin = require('tailwindcss/plugin.js');
const calcByVariants = plugin(({ addUtilities }) => {
  const fluidSize = (variant) =>
    `max(var(${variant}) / 16 * 1rem, var(${variant}) / 1440 * 100cqi)`;
  const liquidSize = (variant) =>
    `calc(var(${variant}) / 1440 * 100cqi)`;

  addUtilities({
    '.w-fluid-var': {
      width: fluidSize('--w-fluid-var'),
    },
    '.min-w-fluid-var': {
      minWidth: fluidSize('--min-w-fluid-var'),
    },
    '.max-w-fluid-var': {
      maxWidth: fluidSize('--max-w-fluid-var'),
    },

    '.h-fluid-var': {
      height: fluidSize('--h-fluid-var'),
    },
    '.min-h-fluid-var': {
      minHeight: fluidSize('--min-h-fluid-var'),
    },
    '.max-h-fluid-var': {
      maxHeight: fluidSize('--max-h-fluid-var'),
    },

    '.size-fluid-var': {
      width: fluidSize('--size-fluid-var'),
      height: fluidSize('--size-fluid-var'),
    },

    '.p-fluid-var': {
      padding: fluidSize('--p-fluid-var'),
    },
    '.pt-fluid-var': {
      paddingTop: fluidSize('--pt-fluid-var'),
    },
    '.pr-fluid-var': {
      paddingRight: fluidSize('--pr-fluid-var'),
    },
    '.pb-fluid-var': {
      paddingBottom: fluidSize('--pb-fluid-var'),
    },
    '.pl-fluid-var': {
      paddingLeft: fluidSize('--pl-fluid-var'),
    },
    '.px-fluid-var': {
      paddingLeft: fluidSize('--px-fluid-var'),
      paddingRight: fluidSize('--px-fluid-var'),
    },
    '.py-fluid-var': {
      paddingTop: fluidSize('--py-fluid-var'),
      paddingBottom: fluidSize('--py-fluid-var'),
    },

    '.m-fluid-var': {
      margin: fluidSize('--m-fluid-var'),
    },
    '.mt-fluid-var': {
      marginTop: fluidSize('--mt-fluid-var'),
    },
    '.mr-fluid-var': {
      marginRight: fluidSize('--mr-fluid-var'),
    },
    '.mb-fluid-var': {
      marginBottom: fluidSize('--mb-fluid-var'),
    },
    '.ml-fluid-var': {
      marginLeft: fluidSize('--ml-fluid-var'),
    },
    '.mx-fluid-var': {
      marginLeft: fluidSize('--mx-fluid-var'),
      marginRight: fluidSize('--mx-fluid-var'),
    },
    '.my-fluid-var': {
      marginLeft: fluidSize('--my-fluid-var'),
      marginRight: fluidSize('--my-fluid-var'),
    },

    '.rounded-fluid-var': {
      borderRadius: fluidSize('--rounded-fluid-var'),
    },

    '.rounded-t-fluid-var': {
      borderTopLeftRadius: fluidSize('--rounded-t-fluid-var'),
      borderTopRightRadius: fluidSize('--rounded-t-fluid-var'),
    },
    '.rounded-r-fluid-var': {
      borderTopRightRadius: fluidSize('--rounded-r-fluid-var'),
      borderBottomRightRadius: fluidSize('--rounded-r-fluid-var'),
    },
    '.rounded-b-fluid-var': {
      borderBottomLeftRadius: fluidSize('--rounded-b-fluid-var'),
      borderBottomRightRadius: fluidSize('--rounded-b-fluid-var'),
    },
    '.rounded-l-fluid-var': {
      borderTopLeftRadius: fluidSize('--rounded-l-fluid-var'),
      borderBottomLeftRadius: fluidSize('--rounded-l-fluid-var'),
    },

    '.rounded-tr-fluid-var': {
      borderTopRightRadius: fluidSize('--rounded-tr-fluid-var'),
    },
    '.rounded-tl-fluid-var': {
      borderTopLeftRadius: fluidSize('--rounded-tl-fluid-var'),
    },

    '.rounded-br-fluid-var': {
      borderBottomRightRadius: fluidSize('--rounded-br-fluid-var'),
    },
    '.rounded-bl-fluid-var': {
      borderBottomLeftRadius: fluidSize('--rounded-bl-fluid-var'),
    },

    '.top-fluid-var': {
      top: fluidSize('--top-fluid-var'),
    },
    '.right-fluid-var': {
      right: fluidSize('--right-fluid-var'),
    },
    '.bottom-fluid-var': {
      bottom: fluidSize('--bottom-fluid-var'),
    },
    '.left-fluid-var': {
      left: fluidSize('--left-fluid-var'),
    },

    '.text-fluid-var': {
      fontSize: fluidSize('--text-fluid-var'),
    },
  });

  addUtilities({
    '.w-liquid-var': {
      width: liquidSize('--w-liquid-var'),
    },
    '.min-w-liquid-var': {
      minWidth: liquidSize('--min-w-liquid-var'),
    },
    '.max-w-liquid-var': {
      maxWidth: liquidSize('--max-w-liquid-var'),
    },

    '.h-liquid-var': {
      height: liquidSize('--h-liquid-var'),
    },
    '.min-h-liquid-var': {
      minHeight: liquidSize('--min-h-liquid-var'),
    },
    '.max-h-liquid-var': {
      maxHeight: liquidSize('--max-h-liquid-var'),
    },

    '.size-liquid-var': {
      width: liquidSize('--size-liquid-var'),
      height: liquidSize('--size-liquid-var'),
    },

    '.p-liquid-var': {
      padding: liquidSize('--p-liquid-var'),
    },
    '.pt-liquid-var': {
      paddingTop: liquidSize('--pt-liquid-var'),
    },
    '.pr-liquid-var': {
      paddingRight: liquidSize('--pr-liquid-var'),
    },
    '.pb-liquid-var': {
      paddingBottom: liquidSize('--pb-liquid-var'),
    },
    '.pl-liquid-var': {
      paddingLeft: liquidSize('--pl-liquid-var'),
    },
    '.px-liquid-var': {
      paddingLeft: liquidSize('--px-liquid-var'),
      paddingRight: liquidSize('--px-liquid-var'),
    },
    '.py-liquid-var': {
      paddingTop: liquidSize('--py-liquid-var'),
      paddingBottom: liquidSize('--py-liquid-var'),
    },

    '.m-liquid-var': {
      margin: liquidSize('--m-liquid-var'),
    },
    '.mt-liquid-var': {
      marginTop: liquidSize('--mt-liquid-var'),
    },
    '.mr-liquid-var': {
      marginRight: liquidSize('--mr-liquid-var'),
    },
    '.mb-liquid-var': {
      marginBottom: liquidSize('--mb-liquid-var'),
    },
    '.ml-liquid-var': {
      marginLeft: liquidSize('--ml-liquid-var'),
    },
    '.mx-liquid-var': {
      marginLeft: liquidSize('--mx-liquid-var'),
      marginRight: liquidSize('--mx-liquid-var'),
    },
    '.my-liquid-var': {
      marginLeft: liquidSize('--my-liquid-var'),
      marginRight: liquidSize('--my-liquid-var'),
    },

    '.rounded-liquid-var': {
      borderRadius: liquidSize('--rounded-liquid-var'),
    },

    '.rounded-t-liquid-var': {
      borderTopLeftRadius: liquidSize('--rounded-t-liquid-var'),
      borderTopRightRadius: liquidSize('--rounded-t-liquid-var'),
    },
    '.rounded-r-liquid-var': {
      borderTopRightRadius: liquidSize('--rounded-r-liquid-var'),
      borderBottomRightRadius: liquidSize('--rounded-r-liquid-var'),
    },
    '.rounded-b-liquid-var': {
      borderBottomLeftRadius: liquidSize('--rounded-b-liquid-var'),
      borderBottomRightRadius: liquidSize('--rounded-b-liquid-var'),
    },
    '.rounded-l-liquid-var': {
      borderTopLeftRadius: liquidSize('--rounded-l-liquid-var'),
      borderBottomLeftRadius: liquidSize('--rounded-l-liquid-var'),
    },

    '.rounded-tr-liquid-var': {
      borderTopRightRadius: liquidSize('--rounded-tr-liquid-var'),
    },
    '.rounded-tl-liquid-var': {
      borderTopLeftRadius: liquidSize('--rounded-tl-liquid-var'),
    },

    '.rounded-br-liquid-var': {
      borderBottomRightRadius: liquidSize('--rounded-br-liquid-var'),
    },
    '.rounded-bl-liquid-var': {
      borderBottomLeftRadius: liquidSize('--rounded-bl-liquid-var'),
    },

    '.top-liquid-var': {
      top: liquidSize('--top-liquid-var'),
    },
    '.right-liquid-var': {
      right: liquidSize('--right-liquid-var'),
    },
    '.bottom-liquid-var': {
      bottom: liquidSize('--bottom-liquid-var'),
    },
    '.left-liquid-var': {
      left: liquidSize('--left-liquid-var'),
    },

    '.text-liquid-var': {
      fontSize: liquidSize('--text-liquid-var'),
    },
  });

  addUtilities({
    '.w-var': {
      width: `calc(var(--w-var)/16*1rem)`,
    },
    '.h-var': {
      height: `calc(var(--h-var)/16*1rem)`,
    },
    '.size-var': {
      width: `calc(var(--size-var)/16*1rem)`,
      height: `calc(var(--size-var)/16*1rem)`,
    },

    '.p-var': {
      padding: `calc(var(--p-var)/16*1rem)`,
    },
    '.pt-var': {
      paddingTop: `calc(var(--pt-var)/16*1rem)`,
    },
    '.pr-var': {
      paddingRight: `calc(var(--pr-var)/16*1rem)`,
    },
    '.pb-var': {
      paddingBottom: `calc(var(--pb-var)/16*1rem)`,
    },
    '.pl-var': {
      paddingLeft: `calc(var(--pl-var)/16*1rem)`,
    },
    '.px-var': {
      paddingLeft: `calc(var(--px-var)/16*1rem)`,
      paddingRight: `calc(var(--px-var)/16*1rem)`,
    },
    '.py-var': {
      paddingTop: `calc(var(--py-var)/16*1rem)`,
      paddingBottom: `calc(var(--py-var)/16*1rem)`,
    },

    '.m-var': {
      margin: `calc(var(--m-var)/16*1rem)`,
    },
    '.mt-var': {
      marginTop: `calc(var(--mt-var)/16*1rem)`,
    },
    '.mr-var': {
      marginRight: `calc(var(--mr-var)/16*1rem)`,
    },
    '.mb-var': {
      marginBottom: `calc(var(--mb-var)/16*1rem)`,
    },
    '.ml-var': {
      marginLeft: `calc(var(--ml-var)/16*1rem)`,
    },
    '.mx-var': {
      marginLeft: `calc(var(--mx-var)/16*1rem)`,
      marginRight: `calc(var(--mx-var)/16*1rem)`,
    },
    '.my-var': {
      marginTop: `calc(var(--my-var)/16*1rem)`,
      marginBottom: `calc(var(--my-var)/16*1rem)`,
    },

    '.text-var': {
      fontSize: `calc(var(--text-var)/16*1rem)`,
    },
  });
});

module.exports = { calcByVariants };
