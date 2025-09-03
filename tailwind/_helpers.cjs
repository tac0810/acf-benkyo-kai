const rem = (px) => `${px / 16}rem`;

const fluid = (size, min = 1440) => `max(${rem(size)}, ${size} / ${min} * 100cqi)`;

const parseProperties = (font) => (base, screens) => {
  const props = { ...font, ...base };

  if (screens && screens.sm) {
    props["@screen sm"] = screens.sm;
  }

  if (screens && screens.md) {
    props["@screen md"] = screens.md;
  }

  if (screens && screens.lg) {
    props["@screen lg"] = screens.lg;
  }

  return props;
};

const text = (fontSize, fontWeight, lineHeight, letterSpacing, fontFeatureSettings = "") => {
  const props = {
    fontSize,
    fontStyle: "normal",
    fontWeight,
    lineHeight,
    letterSpacing,
  };

  if (fontFeatureSettings) {
    props["fontFeatureSettings"] = fontFeatureSettings;
  }

  return props;
};

module.exports = { rem, fluid, parseProperties, text };
