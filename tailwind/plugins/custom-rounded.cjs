const plugin = require("tailwindcss/plugin.js");
const { fluid } = require("../_helpers.cjs");
const customRounded = plugin.withOptions(
  () => {
    return () => {
      // empty
    };
  },
  (options) => {
    const rem = (px) => `${px / 16}rem`;
    const fluidSize = (rem) => {
      const size = rem.replace(/rem$/, "");
      return fluid(size * 16);
    };

    const borderRadius = require("tailwindcss/defaultTheme").borderRadius;
    const borderRadiusKeys = Object.keys(borderRadius).filter(
      (key) => ["full", "DEFAULT", "none"].indexOf(key) === -1,
    );

    borderRadiusKeys.push(
      ...options.borderRadius.map((size) => {
        return size / 4;
      }),
    );

    return {
      theme: {
        extend: {
          borderRadius: {
            ...borderRadiusKeys.reduce((previousValue, currentValue) => {
              if (borderRadius[currentValue]) {
                return {
                  ...previousValue,
                  [`fluid-${currentValue}`]: fluidSize(borderRadius[currentValue]),
                };
              }

              return {
                ...previousValue,
                [`fluid-${currentValue}`]: fluidSize(rem(currentValue * 4)),
              };
            }, borderRadius),
            ...options.borderRadius.reduce((previousValue, currentValue) => {
              return {
                ...previousValue,
                [currentValue / 4]: rem(currentValue),
              };
            }, {}),
          },
        },
      },
    };
  },
);

module.exports = { customRounded };
