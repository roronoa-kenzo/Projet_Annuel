import k from "./kaplayCtx.js";
import mainMenu from "./scenes/mainMenu.js";
import game from "./scenes/game.js";
import gameover from "./scenes/gameover.js";

/* Mise en place des sprites*/

k.loadSprite("chemical-bg", "./../public/graphics/chemical-bg.png");
k.loadSprite("platforms", "./../public/graphics/platforms.png");
k.loadSprite("sonic", "./../public/graphics/sonic.png", {
   sliceX: 8, 
   sliceY: 2,
   anims: {
      run: {from: 0, to: 7, loop: true, speed : 30},
      jump: {from: 8, to: 15, loop: true, speed : 100},
   },
});
k.loadSprite("rings", "./../public/graphics/ring.png", {
    sliceX: 16, /* Frame par row*/
    sliceY: 1, /* Frame par column*/
    anims: {
      spin: {from: 0, to: 15, loop: true, speed : 30},
    },
});
k.loadSprite("motobugs", "./../public/graphics/motobug.png", {
    sliceX: 5, /* Frame par row*/
    sliceY: 1, /* Frame par column*/
    anims: {
      run: {from: 0, to: 4, loop: true, speed : 8},
    },
});

/* Charge le font*/
k.loadFont("mania", "./../public/fonts/mania.ttf" );

/* Charge les sons*/
k.loadSound("destroy", "./../public/sounds/Destroy.wav" );
k.loadSound("hurt", "./../public/sounds/Hurt.wav" );
k.loadSound("hyper-ring", "./../public/sounds/HyperRing.wav" );
k.loadSound("jump", "./../public/sounds/Jump.wav" );
k.loadSound("ring", "./../public/sounds/Ring.wav" );
k.loadSound("city", "./../public/sounds/music.mp3" );
k.loadSound("success", "./../public/sounds/success.mp3" );
k.loadSound("lost", "./../public/sounds/lost.mp3" );

k.scene("main-menu", mainMenu);
k.scene("game", game);
k.scene("gameover", gameover);

k.go("main-menu");