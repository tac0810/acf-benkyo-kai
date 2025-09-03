const plugin = require("tailwindcss/plugin.js");
const { rem } = require("../_helpers.cjs");
const customSpacing = plugin.withOptions(
  () => {
    return () => {
      // empty
    };
  },
  (options) => {
    const fluidSize = (size) => `max(${rem(size * 4)}, ${size * 4} / 1440 * 100cqi)`;
    const liquidSize = (size) => `calc(${size * 4} / 1440 * 100cqi)`;
    const spacing = require("tailwindcss/defaultTheme").spacing;
    const spacingKeys = Object.keys(spacing);

    spacingKeys.push(
      ...options.spacing.map((size) => {
        return size / 4;
      }),
    );

    const fluidSpacing = spacingKeys.reduce((previousValue, currentValue) => {
      return {
        ...previousValue,
        [`fluid-${currentValue}`]: fluidSize(Number(currentValue)),
        [`liquid-${currentValue}`]: liquidSize(Number(currentValue)),
      };
    }, {});

    const customSpacing = options.spacing.reduce((previousValue, currentValue) => {
      return {
        ...previousValue,
        [currentValue / 4]: rem(currentValue),
      };
    }, {});

    const columnSpacing = new Array(36).fill(null).reduce((previousValue, _, currentIndex) => {
      return {
        ...previousValue,
        [`col-${currentIndex}`]: fluidSize(currentIndex * 10),
      };
    }, {});

    return {
      theme: {
        extend: {
          spacing: () => {
            return {
              ...customSpacing,
              ...fluidSpacing,
              ...columnSpacing,
            };
          },
        },
      },
    };
  },
);

module.exports = { customSpacing };
