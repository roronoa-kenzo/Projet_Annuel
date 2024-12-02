import k from "./../kaplayCtx.js";

export default function gameover(music) {
    music.paused = true;
    let bestScore = k.getData("best-score");
    const currentScore = k.getData("current-score");
    
    // System de Rank
    const rankGrades = ["F", "E", "D", "C", "B", "A", "S"];
    const rankValues = [30, 60, 90, 110, 180, 240, 400];

    let currentRank = "F";
    let bestRank = "F";
    
    // logique por attribution d'un rank
    for (let i = 0; i < rankValues.length; i++) {
        if (rankValues[i] < currentScore) {
          currentRank = rankGrades[i];
        }
    
        if (rankValues[i] < bestScore) {
          bestRank = rankGrades[i];
        }
      }
      
      // battage de record
      if (bestScore < currentScore) {
        k.setData("best-score", currentScore);
        bestScore = currentScore;
        bestRank = currentRank;
      }

      if (["F", "E", "D"].includes(currentRank)) {
        k.play("lost", { volume: 0.2});
    } else {
        k.play("success", { volume: 0.2});
    }
    

      k.add([
        k.text("GAME OVER", { font: "mania", size: 96 }),
        k.anchor("center"),
        k.pos(k.center().x, k.center().y - 300),
      ]);
      k.add([
        k.text(`BEST SCORE : ${bestScore}`, {
          font: "mania",
          size: 64,
        }),
        k.anchor("center"),
        k.pos(k.center().x - 400, k.center().y - 200),
      ]);
      k.add([
        k.text(`CURRENT SCORE : ${currentScore}`, {
          font: "mania",
          size: 64,
        }),
        k.anchor("center"),
        k.pos(k.center().x + 400, k.center().y - 200),
      ]);
    
      const bestRankBox = k.add([
        k.rect(400, 400, { radius: 4 }),
        k.color(0, 0, 0),
        k.area(),
        k.anchor("center"),
        k.outline(6, k.Color.fromArray([255, 255, 255])),
        k.pos(k.center().x - 400, k.center().y + 50),
      ]);
    
      bestRankBox.add([
        k.text(bestRank, { font: "mania", size: 100 }),
        k.anchor("center"),
      ]);
    
      const currentRankBox = k.add([
        k.rect(400, 400, { radius: 4 }),
        k.color(0, 0, 0),
        k.area(),
        k.anchor("center"),
        k.outline(6, k.Color.fromArray([255, 255, 255])),
        k.pos(k.center().x + 400, k.center().y + 50),
      ]);
    
      currentRankBox.add([
        k.text(currentRank, { font: "mania", size: 100 }),
        k.anchor("center"),
      ]);
    
      k.wait(1, () => {
        k.add([
          k.text("Press Space/Click/Touch to Play Again", {
            font: "mania",
            size: 64,
          }),
          k.anchor("center"),
          k.pos(k.center().x, k.center().y + 350),
        ]);
        k.onButtonPress("jump", () => k.go("game", ));
      });
}