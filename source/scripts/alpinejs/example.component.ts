import Alpine from "alpinejs";

Alpine.data("example", () => {
  return {
    init() {
      console.log("loaded example");
    },
  };
});
