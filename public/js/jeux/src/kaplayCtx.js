import kaplay from "https://unpkg.com/kaplay@3001/dist/kaplay.mjs";

const k = kaplay({
    width: 1920,
    height: 1080,
    letterbox: true,
    background: [0, 0, 0],
    global: false,
    buttons: {
      jump: {
        keyboard: ["space"],
        mouse: "left",
      },
    },
    touchToMouse: true,
    debug: false,
  });

export default k;
