const glob = require("glob");
const { autoGrid } = require("./tailwind/plugins/auto-grid.cjs");
const { typography } = require("./tailwind/plugins/typography.cjs");
const { customSpacing } = require("./tailwind/plugins/custom-spacing.cjs");
const { displayByViewport } = require("./tailwind/plugins/display-by-viewport.cjs");
const { calcByVariants } = require("./tailwind/plugins/calc-by-variants.cjs");
const { customRounded } = require("./tailwind/plugins/custom-rounded.cjs");
const { verticalText } = require("./tailwind/plugins/vertical-text.cjs");
const { loadingState } = require("./tailwind/plugins/loading-state.cjs");
const { multiInteraction } = require("./tailwind/plugins/multi-interaction.cjs");
const { kerning } = require("./tailwind/plugins/kerning.cjs");

require("dotenv").config();

const THEME_NAME = process.env.THEME_NAME;
// https://github.com/WebDevStudios/wd_s/pull/804#issuecomment-997018146
const topLevelPhpFiles = glob.sync(`./${THEME_NAME}/*.php`);

/** @type {import("tailwindcss/types").Config} */
module.exports = {
  content: [
    ...topLevelPhpFiles,
    `./${THEME_NAME}/inc/**/*.php`,
    "./**/*.twig",
    "./source/**/*.{js,ts}",
  ],
  future: {
    hoverOnlyWhenSupported: true,
  },
  theme: {
    screens: {
      xs: "768px",
      sm: "960px",
      md: "1280px",
      lg: "1440px",
      xl: "1680px",
    },
    extend: {
      spacing: {
        cap: "1cap",
      },
      fontFamily: {
        sans: ["'Noto Sans JP'", "sans-serif"],
        serif: ["serif"],
      },
      transitionTimingFunction: {
        'sine-in': 'cubic-bezier(0.12, 0, 0.39, 0)',
        'sine-out': 'cubic-bezier(0.61, 1, 0.88, 1)',
        'sine-in-out': 'cubic-bezier(0.37, 0, 0.63, 1)',
        'quad-in': 'cubic-bezier(0.11, 0, 0.5, 0)',
        'quad-out': 'cubic-bezier(0.5, 1, 0.89, 1)',
        'quad-in-out': 'cubic-bezier(0.45, 0, 0.55, 1)',
        'cubic-in': 'cubic-bezier(0.32, 0, 0.67, 0)',
        'cubic-out': 'cubic-bezier(0.33, 1, 0.68, 1)',
        'cubic-in-out': 'cubic-bezier(0.65, 0, 0.35, 1)',
        'quart-in': 'cubic-bezier(0.5, 0, 0.75, 0)',
        'quart-out': 'cubic-bezier(0.25, 1, 0.5, 1)',
        'quart-in-out': 'cubic-bezier(0.76, 0, 0.24, 1)',
        'quint-in': 'cubic-bezier(0.64, 0, 0.78, 0)',
        'quint-out': 'cubic-bezier(0.22, 1, 0.36, 1)',
        'quint-in-out': 'cubic-bezier(0.83, 0, 0.17, 1)',
        'expo-in': 'cubic-bezier(0.7, 0, 0.84, 0)',
        'expo-out': 'cubic-bezier(0.16, 1, 0.3, 1)',
        'expo-in-out': 'cubic-bezier(0.87, 0, 0.13, 1)',
        'circ-in': 'cubic-bezier(0.55, 0, 1, 0.45)',
        'circ-out': 'cubic-bezier(0, 0.55, 0.45, 1)',
        'circ-in-out': 'cubic-bezier(0.85, 0, 0.15, 1)',
        'back-in': 'cubic-bezier(0.36, 0, 0.66, -0.56)',
        'back-out': 'cubic-bezier(0.34, 1.56, 0.64, 1)',
        'back-in-out': 'cubic-bezier(0.68, -0.6, 0.32, 1.6)',
      },
    },
  },

  plugins: [
    kerning,
    autoGrid,
    typography,
    customSpacing({
      spacing: [30],
    }),
    displayByViewport,
    calcByVariants,
    customRounded({
      borderRadius: [48],
    }),
    verticalText,
    loadingState,
    multiInteraction,
  ],
};
