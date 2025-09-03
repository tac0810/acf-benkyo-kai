const plugin = require("tailwindcss/plugin.js");
const { rem, fluid, parseProperties, text } = require("../_helpers.cjs");
const typography = plugin(({ addUtilities, addComponents, theme }) => {
  const type = {
    en: {
      degular: {
        fontFamily: "'degular', sans-serif",
        fontStyle: "normal",
      },
    },
    ja: {
      noto: {
        fontFamily: "'Noto Sans JP', serif",
        fontStyle: "normal",
        fontOpticalSizing: "auto",
      },
    },
  };

  const en = parseProperties(type.en.degular);
  const ja = parseProperties(type.ja.noto);

  // En.Degular
  addComponents({
    ".font-degular": {
      ...type.en.degular,
    },
    ".text-en-headline-l": en(
      {
        ...text(rem(64), 200, "110%", "-0.03em"),
      },
      {
        sm: {
          fontSize: fluid(120),
        },
      },
    ),
    ".text-en-headline-m": en(
      {
        ...text(rem(56), 200, "85%", "-0.03em"),
      },
      {
        sm: {
          fontSize: fluid(72),
        },
      },
    ),
    ".text-en-headline-s": en(
      {
        ...text(rem(48), 200, "85%", "-0.03em"),
      },
      {
        sm: {
          fontSize: fluid(64),
        },
      },
    ),
    ".text-en-label-l": en(
      {
        ...text(rem(36), 400, "normal", "0em"),
      },
      {
        sm: {
          fontSize: fluid(36),
        },
      },
    ),
    ".text-en-label-m": en(
      {
        ...text(rem(24), 400, "normal", "0em"),
      },
      {
        sm: {
          fontSize: fluid(24),
        },
      },
    ),
    ".text-en-label-s": en({
      ...text(fluid(14), 400, "normal", "0em"),
    }),
    ".text-en-button-l": en(
      {
        ...text(rem(40), 200, "75%", "-0.03em"),
      },
      {
        sm: {
          fontSize: fluid(48),
        },
      },
    ),
    ".text-en-button-m": en({
      ...text(fluid(15), 500, "normal", "0em"),
    }),
    ".text-en-caption-l": en(
      {
        ...text(rem(18), 600, "normal", "0em"),
      },
      {
        sm: {
          fontSize: fluid(18),
        },
      },
    ),
    ".text-en-caption-m": en(
      {
        ...text(rem(14), 600, "normal", "0em"),
      },
      {
        sm: {
          fontSize: fluid(14),
        },
      },
    ),
    ".text-en-caption-s": en({
      ...text(fluid(13), 400, "normal", "0em"),
    }),
  });

  // Ja.Noto
  addComponents({
    ".text-ja-headline-l": ja(
      {
        ...text(rem(32), 500, "150%", "0.03em", "'palt' on"),
      },
      {
        sm: {
          fontSize: fluid(42),
        },
      },
    ),
    ".text-ja-headline-m": ja(
      {
        ...text(rem(24), 500, "108%", "0.08em", "'halt' on"),
      },
      {
        sm: {
          fontSize: fluid(32),
        },
      },
    ),
    ".text-ja-headline-s": ja(
      {
        ...text(rem(18), 500, "180%", "0.08em", "'halt' on"),
      },
      {
        sm: {
          fontSize: fluid(28),
        },
      },
    ),
    ".text-ja-label-l": ja(
      {
        ...text(rem(16), 500, "180%", "0.1em", "'palt' on"),
      },
      {
        sm: {
          fontSize: fluid(18),
        },
      },
    ),
    ".text-ja-label-m": ja(
      {
        ...text(rem(14), 600, "180%", "0.1em", "'palt' on"),
      },
      {
        sm: {
          fontSize: fluid(14),
        },
      },
    ),
    ".text-ja-label-s": ja(
      {
        ...text(rem(13), 700, "170%", "0.1em", "'palt' on"),
      },
      {
        sm: {
          fontSize: fluid(13),
        },
      },
    ),
    ".text-ja-button-l": ja(
      {
        ...text(rem(16), 400, "150%", "0.1em", "'palt' on"),
      },
      {
        sm: {
          fontSize: fluid(16),
        },
      },
    ),
    ".text-ja-button-m": ja(
      {
        ...text(rem(14), 500, "100%", "0em"),
      },
      {
        sm: {
          fontSize: fluid(14),
        },
      },
    ),
    ".text-ja-button-s": ja(
      {
        ...text(rem(14), 500, "100%", "0em"),
      },
      {
        sm: {
          fontSize: fluid(14),
        },
      },
    ),
    ".text-ja-body-l": ja(
      {
        ...text(rem(16), 400, "240%", "0.1em", "'palt' on"),
      },
      {
        sm: {
          fontSize: fluid(16),
        },
      },
    ),
    ".text-ja-body-m": ja(
      {
        ...text(rem(14), 400, "200%", "0.1em", "'palt' on"),
      },
      {
        sm: {
          fontSize: fluid(14),
        },
      },
    ),
    ".text-ja-body-s": ja(
      {
        ...text(rem(14), 300, "200%", "0.12em", "'palt' on"),
      },
      {
        sm: {
          fontSize: fluid(14),
        },
      },
    ),
    ".text-ja-caption-m": ja(
      {
        ...text(rem(14), 300, "200%", "0.12em", "'halt' on"),
      },
      {
        sm: {
          fontSize: fluid(14),
        },
      },
    ),
    ".text-ja-caption-s": ja({
      ...text(rem(13), 300, "150%", "0.13em", "'halt' on"),
    }),
  });

  addUtilities({
    ".break-phrase": {
      wordBreak: "auto-phrase",
    },
  });

  addComponents(
    Object.keys(theme("fontSize"))
      .filter((k) => !isNaN(k))
      .reduce((previousValue, currentValue) => {
        return {
          ...previousValue,
          [`.text-fluid-${currentValue}`]: {
            fontSize: fluid(Number(currentValue)),
          },
        };
      }, {}),
  );
});

module.exports = { typography };
