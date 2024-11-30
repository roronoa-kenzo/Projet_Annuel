import k from "./../kaplayCtx.js";
import { makeSonic } from "./../entities/sonic.js";
import { makeMotobug } from "./../entities/motobug.js";
import { makeRings } from "./../entities/rings.js";

export default function game() {
  k.setGravity(3100);
  const music = k.play("city", { volume: 0.2, loop: true});

  const bgPieceWidth = 1920;
  const bgPieces = [
    k.add([k.sprite("chemical-bg"), k.pos(0, 0), k.scale(2), k.opacity(0.8)]),
    k.add([
      k.sprite("chemical-bg"),
      k.pos(bgPieceWidth, 0),
      k.scale(2),
      k.opacity(0.8),
    ]),
  ];

    const platforms = [
        k.add([k.sprite("platforms"), k.pos(0, 450), k.scale(4)]), /* Ajoute un objet*/
        k.add([k.sprite("platforms"), k.pos(384 * 4, 450), k.scale(4)]),
    ];

    let score = 0;
    let scoreMultiplier = 0;

    const scoreText = k.add([
        k.text("Score : 0", { font: "mania", size: 52 }),
        k.pos(40, 40),
    ])

    const sonic = makeSonic(k.vec2(200, 745));
    sonic.setControls();
    sonic.setEvents();
    sonic.onCollide("enemy", (enemy) => {
        if (!sonic.isGrounded()){
            k.play("destroy", { volume: 0.5 });
            k.play("hyper-ring", { volume: 0.5 });
            k.destroy(enemy);
            sonic.play("jump");
            sonic.jump()
            scoreMultiplier += 1;
            score += 10 * scoreMultiplier;
            scoreText.text = `Score : ${score}`;
            if (scoreMultiplier === 1)
                sonic.ringCollectUI.text = `+${10 * scoreMultiplier}`;
              if (scoreMultiplier > 1) sonic.ringCollectUI.text = `x${scoreMultiplier}`;
              k.wait(1, () => {
                sonic.ringCollectUI.text = "";
              });
            return;
        }
        k.play("hurt" , { volume: 0.5 })
        k.setData("current-score", score)
        k.go("gameover", music);
    })
    sonic.onCollide("rings", (rings) => {
            k.play("ring", { volume: 0.5 });
            k.destroy(rings);
            score++;
            scoreText.text = `Score : ${score}`
            sonic.ringCollectUI.text = "+1";
            k.wait(1, () => {
               sonic.ringCollectUI.text = "";
            });
    });

    let gameSpeed = 300;
    k.loop(1, () => {
        gameSpeed += 50;
    });

    const spawnMotoBug = () => {
        const motobug = makeMotobug(k.vec2(1950, 773));
        motobug.onUpdate(() => {
            if (gameSpeed < 3000) {
                motobug.move(-(gameSpeed + 300), 0)
                return;
            }

            motobug.move(-gameSpeed, 0);
        })

        motobug.onExitScreen(() => {
            if (motobug.pos.x < 0){
                k.destroy(motobug);
            }
        })
        const waitTime = k.rand(0.5, 2.5)
        k.wait(waitTime, spawnMotoBug); //pour re appeler la function apres un certains temps
    }
    spawnMotoBug();

    const spawnRings = () => {
        const rings = makeRings(k.vec2(1950, 745));
        rings.onUpdate(() => {
            rings.move(-gameSpeed, 0);
        })

        rings.onExitScreen(() => {
            if (rings.pos.x < 0){
                k.destroy(rings);
            }
        })
        const waitTime = k.rand(0.5, 3)
        k.wait(waitTime, spawnRings); //pour re appeler la function apres un certains temps
    }
    spawnRings();
    
    // physique de la plateform
    k.add([
        k.rect(1920, 300),
        k.opacity(0),
        k.area(),
        k.pos(0, 832),
        k.body({ isStatic: true }), // permet de fixer l'objet a la gravité comme un mur
    ]);

    k.onUpdate(() => {
        if (sonic.isGrounded()) scoreMultiplier = 0;

        if (bgPieces[1].pos.x < 0) { // des que le 1er canvas sort de notre visu il va mettre le 2eme bg
            bgPieces[0].moveTo(bgPieces[1].pos.x + bgPieceWidth * 2, 0);
            bgPieces.push(bgPieces.shift()) // repetition push va prendre le dernieres elements de l'array et shift va prendre le premiers et le mettre a la fin
        }
        bgPieces[0].move(-100, 0) // bouge sur la gauche
        bgPieces[1].moveTo(bgPieces[0].pos.x + bgPieceWidth * 2, 0) // Pour suivre

        // for jump effect
           bgPieces[0].moveTo(bgPieces[0].pos.x, -sonic.pos.y / 10 - 50);
           bgPieces[1].moveTo(bgPieces[1].pos.x, -sonic.pos.y / 10 - 50);

        /*Platforme*/

        if (platforms[1].pos.x < 0) {
            platforms[0].moveTo(platforms[1].pos.x + platforms[1].width * 4, 450);
            platforms.push(platforms.shift());
          }
      
          platforms[0].move(-gameSpeed, 0);
          platforms[1].moveTo(platforms[0].pos.x + platforms[1].width * 4, 450);
    });
}