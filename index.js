const shoe = document.getElementById("heroShoe");
const dots = document.querySelectorAll(".color-dot");

const images = {
  white: "air-max.jpg",
  black: "j4-noire.jpg",
  blue: "j-1-retro.jpg"
};

/* CHANGEMENT DE COULEUR */
dots.forEach(dot => {
  dot.addEventListener("click", () => {
    dots.forEach(d => d.classList.remove("active"));
    dot.classList.add("active");

    shoe.style.opacity = 0;
    setTimeout(() => {
      shoe.src = images[dot.dataset.color];
      shoe.style.opacity = 1;
    }, 200);
  });
});

/* EFFET 3D AU MOUVEMENT */
document.addEventListener("mousemove", (e) => {
  const x = (window.innerWidth / 2 - e.clientX) / 40;
  const y = (window.innerHeight / 2 - e.clientY) / 40;

  shoe.style.transform = `
    perspective(1200px)
    rotateX(${12 + y}deg)
    rotateY(${-18 + x}deg)
    translateY(40px)
  `;
});
