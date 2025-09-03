const { loadEnv } = require("vite");

const { THEME_NAME } = loadEnv(process.env.NODE_ENV, process.cwd(), "");

module.exports = {
  files: ["*"],
  variables: {
    theme: THEME_NAME,
  },
};
