import fs from "fs/promises";
import f from "fs";
import path from "path";
import { input, password, confirm } from "@inquirer/prompts";

const root = path.dirname(path.dirname(new URL(import.meta.url).pathname));
const envFilePath = path.resolve(root, ".env");

async function generateEnvFile(themeName) {
  try {
    const content = `THEME_NAME=${themeName}\nVITE_THEME_NAME=${themeName}`;
    await fs.writeFile(envFilePath, content);
    console.log(".env file has been created and updated with new THEME_NAME:", themeName);
  } catch (error) {
    console.error(error);
  }
}

async function updateEnvFile(key, value) {
  try {
    const data = await fs.readFile(envFilePath, "utf8");
    let newData = data.trim();

    const envData = newData.split("\n").reduce((acc, line) => {
      const [k, v] = line.split("=");
      if (k) {
        acc[k.trim()] = v.trim();
      }
      return acc;
    }, {});

    envData[key] = value;

    newData = Object.entries(envData)
      .map(([k, v]) => `${k}=${v}`)
      .join("\n");

    await fs.writeFile(envFilePath, newData);
    console.log(".envファイルを更新しました。");
  } catch (error) {
    console.error("エラー:", error);
  }
}

async function renameTheme(themeName) {
  try {
    const oldDirectoryName = path.resolve(root, "mytheme");
    const newDirectoryName = path.resolve(root, themeName);
    await fs.rename(oldDirectoryName, newDirectoryName);
  } catch (error) {
    console.error(error);
  }
}

async function generateAuthJson(token) {
  const authJsonFilePath = path.resolve(root, "auth.json");
  try {
    const content = `{
  "http-basic": {
    "connect.advancedcustomfields.com": {
      "username": "${token}",
      "password": "https://example.com"
    }
  }
}`;
    await fs.writeFile(authJsonFilePath, content);
    console.log("auth.json file has been created and updated");
  } catch (error) {
    console.error(error);
  }
}

async function generateThemeStyle(themeName) {
  const themeStyleFilePath = path.resolve(root, themeName, "style.css");
  try {
    const content = `/*
Theme Name: ${themeName}
*/
`;
    await fs.writeFile(themeStyleFilePath, content);
    console.log("style.css file has been created and updated with new THEME_NAME:", themeName);
  } catch (error) {
    console.error(error);
  }
}

function getThemeDirName() {
  const directories = f.readdirSync(root).filter((file) => {
    return f.statSync(path.join(root, file)).isDirectory();
  });

  // `theme.json`を含むディレクトリを探す
  let themeDir = "";
  for (const dir of directories) {
    const themeJsonPath = path.join(root, dir, "theme.json");
    if (f.existsSync(themeJsonPath)) {
      themeDir = dir;
      break;
    }
  }

  return themeDir;
}

const confirmInit = await confirm({
  message: `Initialize?`,
  default: false,
});

if (!confirmInit) {
  process.exit(0);
}

let themeName = getThemeDirName();

const confirmRename = await confirm({
  message: `Rename theme name? current theme name: ${themeName}.`,
  default: false,
});

if(confirmRename) {
  themeName = await input({ message: "Input theme name...", default: themeName });
  await renameTheme(themeName);
  await generateThemeStyle(themeName);
}

await generateEnvFile(themeName);

const confirmGenerateAuthJson = await confirm({
  message: `Generate auth.json?`,
});

if (confirmGenerateAuthJson) {
  const token = await password({ message: "Input ACF PRO LICENCE KEY..." });
  await generateAuthJson(token);
  await updateEnvFile("ACF_PRO_KEY", token);
}
