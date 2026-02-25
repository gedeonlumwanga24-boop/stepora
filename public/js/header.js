document.addEventListener("DOMContentLoaded", () => {
  const menuToggle = document.getElementById("menuToggle");
  const mobileMenu = document.getElementById("mobileMenu");
  const overlay = document.getElementById("overlay");
  const body = document.body;

  if (!menuToggle || !mobileMenu || !overlay) {
    console.error("Menu mobile : élément manquant");
    return;
  }

  // OUVERTURE
  menuToggle.addEventListener("click", () => {
    mobileMenu.classList.add("open");
    overlay.classList.add("show");
    body.classList.add("lock"); // 👈 IMPORTANT
  });

  // FERMETURE (overlay)
  overlay.addEventListener("click", closeMenu);

  // FERMETURE (clic lien)
  mobileMenu.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", closeMenu);
  });

  function closeMenu() {
    mobileMenu.classList.remove("open");
    overlay.classList.remove("show");
    body.classList.remove("lock");
  }
});