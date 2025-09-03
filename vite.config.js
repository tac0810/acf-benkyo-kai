import { defineConfig, loadEnv } from "vite";

export default defineConfig(({ mode }) => {
  const { THEME_NAME } = loadEnv(mode, process.cwd(), "");
  return {
    build: {
      outDir: `./${THEME_NAME}/build`,
      assetsDir: "",
      manifest: true,
      rollupOptions: {
        input: "./source/index.ts",
      },
    },
    server: {
      hmr: true,
      port: 3000,
      origin: "http://localhost:8080",
    },
  };
});
