import k from "./../kaplayCtx.js";
import { makeSonic } from "./../entities/sonic.js";
import { makeMotobug } from "./../entities/motobug.js";

export default function mainMenu() {
    if (!k.getData("best-score")) k.setData("best-score", 0);
    k.onButtonPress("jump", () => k.go("game"));

    const bgPieceWidth = 1920;

    const bgPieces = [
        k.add([k.sprite("chemical-bg"), k.pos(0, 0), k.scale(2), k.opacity(0.5)]), /* Ajoute un objet*/
        k.add([
            k.sprite("chemical-bg"),
            k.pos(bgPieceWidth, 0),
            k.scale(2),
            k.opacity(0.5),
        ]),
    ];
    
    const platformWidth = 1280
    const platforms = [
        k.add([k.sprite("platforms"), k.pos(0, 450), k.scale(4)]), /* Ajoute un objet*/
        k.add([k.sprite("platforms"), k.pos(platformWidth * 4, 450), k.scale(4)]),
    ];

    k.add([
        k.text("Abyss", { font: "mania", size: 32 }),
        k.anchor("center"),
        k.pos(k.center().x, 100),
      ]);

    k.add([
        k.text("404 Error", { font: "mania", size: 96 }),
        k.anchor("center"),
        k.pos(k.center().x, 200),
      ]);
    
      k.add([
        k.text("Press Space/Click/Touch to Play", { font: "mania", size: 32 }),
        k.anchor("center"),
        k.pos(k.center().x, k.center().y - 200),
      ]);

    makeSonic(k.vec2(200, 745));

    k.onUpdate(() => {
        if (bgPieces[1].pos.x < 0) { // des que le 1er canvas sort de notre visu il va mettre le 2eme bg
            bgPieces[0].moveTo(bgPieces[1].pos.x + bgPieceWidth * 2, 0);
            bgPieces.push(bgPieces.shift()) // repetition push va prendre le dernieres elements de l'array et shift va prendre le premiers et le mettre a la fin
        }
        bgPieces[0].move(-100, 0) // bouge sur la gauche
        bgPieces[1].moveTo(bgPieces[0].pos.x + bgPieceWidth * 2, 0) // Pour suivre

        /*Platforme*/

        if (platforms[1].pos.x < 0) {
            platforms[0].moveTo(platforms[1].pos.x + platforms[1].width * 4, 450);
            platforms.push(platforms.shift());
          }
      
          platforms[0].move(-4000, 0);
          platforms[1].moveTo(platforms[0].pos.x + platforms[1].width * 4, 450);
    });
};