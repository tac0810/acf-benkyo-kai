import { $ } from "zx";

const argv = minimist(process.argv.slice(2), {
  string: ["path"],
  alias: {
    p: "path",
  },
});

try {
  const { stdout: containerName } = await $`docker ps -f name=wordpress --format "{{.Names}}"`;
  const process = $.spawn("docker", ["exec", containerName.trim(), "bash", argv.path]);

  process.stdout.on("data", (data) => {
    console.log(data.toString());
  });

  process.stderr.on("data", (data) => {
    console.error(`stderr: ${data}`);
  });

  process.on("close", (code) => {
    console.log(`child process exited with code ${code}`);
  });
} catch (e) {
  console.error(e);
}
