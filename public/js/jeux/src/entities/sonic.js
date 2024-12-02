import k from "./../kaplayCtx.js";

export function makeSonic(pos){
     const sonic = k.add([
        k.sprite("sonic", { anim: "run" }),
        k.scale(4),
        k.area(),
        k.anchor("center"),
        k.pos(pos),
        k.body({jumpForce: 1700}),
        {
            ringCollectUI: null,
            setControls() {
              k.onButtonPress("jump", () => {
                if (this.isGrounded()) { // isGrounded si il a un body donc succombe a la gravité
                    this.play("jump"); // pour jouer l'animation
                    this.jump() // kaplay a deja la logique de saut d'un body
                    k.play("jump", { volume: 0.5 }) // pour jouer les sons
                }
              });
            },
            setEvents() {
                this.onGround(() => {
                   this.play("run");
                });
            },
        },
     ]);

     sonic.ringCollectUI = sonic.add([
        k.text("", { font: "mania", size: 14 }),
        k.color(255, 255, 0),
        k.anchor("center"),
        k.pos(30, -10),
     ])

     return sonic;
}