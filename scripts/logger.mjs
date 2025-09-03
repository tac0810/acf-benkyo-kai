import fs from "fs/promises";
import path from "path";
import { Tail } from "tail";
import { config } from "dotenv";

config();

const root = path.dirname(path.dirname(new URL(import.meta.url).pathname));
const filePath = path.resolve(root, process.env.THEME_NAME, "my-errors.log");

// ファイルの内容を消去する関数
async function clearFileContents(filePath) {
  try {
    await fs.writeFile(filePath, ''); // 空の内容で上書きする
    console.log(`ファイル ${filePath} の内容を消去しました。`);
  } catch (error) {
    console.error("ファイルの内容の消去中にエラーが発生しました:", error);
  }
}

// my-errors.logファイルの内容を消去
clearFileContents(filePath)
.then(() => {
  // tailを開始
  const tail = new Tail(filePath);

  tail.on("line", (data) => {
    console.log(data);
  });

  tail.on("error", (error) => {
    console.error("Error:", error);
  });
})
.catch((error) => {
  console.error("ファイルの内容の消去中にエラーが発生しました:", error);
});
