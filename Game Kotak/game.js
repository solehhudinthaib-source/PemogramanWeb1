class Player {
  constructor(element) {
    this.element = element;
    this.x = 0;
    this.y = 0;
    this.speed = 20;
  }

  moveLeft() { if (this.x > 0) this.x -= this.speed; this.updatePosition(); }
  moveRight() { if (this.x < 360) this.x += this.speed; this.updatePosition(); }
  moveUp() { if (this.y > 0) this.y -= this.speed; this.updatePosition(); }
  moveDown() { if (this.y < 360) this.y += this.speed; this.updatePosition(); }

  updatePosition() {
    this.element.style.left = this.x + "px";
    this.element.style.top = this.y + "px";
  }
}

const playerElement = document.getElementById("player");
const player = new Player(playerElement);

document.addEventListener("keydown", (event) => {
  console.log("Tombol ditekan:", event.key);
  switch (event.key) {
    case "ArrowLeft": player.moveLeft(); break;
    case "ArrowRight": player.moveRight(); break;
    case "ArrowUp": player.moveUp(); break;
    case "ArrowDown": player.moveDown(); break;
  }
});
