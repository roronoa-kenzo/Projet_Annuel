import k from "./../kaplayCtx.js";

export function makeRings(pos) {
  return k.add([
    k.sprite("rings", { anim: "spin" }),
    k.area({ shape: new k.Rect(k.vec2(-5, 0), 32, 32) }),
    k.scale(4),
    k.anchor("center"),
    k.pos(pos),
    k.offscreen(), // permet de supprimer des ennemis offscreen pour la perf
    "rings",
  ]);
}