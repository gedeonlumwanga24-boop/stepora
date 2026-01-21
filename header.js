/* ===============================
   HEADER + PANIER + MOBILE + SEARCH
================================ */

document.addEventListener("DOMContentLoaded", () => {

  // ELEMENTS
  const cartBtn = document.getElementById("cartBtn");
  const cartPanel = document.getElementById("cartPanel");
  const menuToggle = document.getElementById("menuToggle");
  const mobileMenu = document.getElementById("mobileMenu");
  const searchBtn = document.getElementById("searchBtn");
  const searchOverlay = document.getElementById("searchOverlay");
  const overlay = document.getElementById("overlay");

  const closeCartBtn = document.getElementById("closeCart");
  const closeMenuBtn = document.getElementById("closeMenu");
  const closeSearchBtn = document.getElementById("closeSearch");

  // UTIL : fermer tout
  function closeAll() {
    cartPanel.classList.remove("open");
    mobileMenu.classList.remove("open");
    searchOverlay.classList.remove("show");
    overlay.classList.remove("show");
    document.body.classList.remove("lock");
  }

  // ===============================
  // PANIER
  // ===============================
  if (cartBtn && cartPanel) {
    cartBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      closeAll();
      cartPanel.classList.add("open");
      overlay.classList.add("show");
      document.body.classList.add("lock");
    });
  }

  if (closeCartBtn) {
    closeCartBtn.addEventListener("click", closeAll);
  }

  // ===============================
  // MENU MOBILE
  // ===============================
  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener("click", (e) => {
      e.stopPropagation();
      closeAll();
      mobileMenu.classList.add("open");
      overlay.classList.add("show");
      document.body.classList.add("lock");
    });
  }

  if (closeMenuBtn) {
    closeMenuBtn.addEventListener("click", closeAll);
  }

  // ===============================
  // RECHERCHE
  // ===============================
  if (searchBtn && searchOverlay) {
    searchBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      closeAll();
      searchOverlay.classList.add("show");
      overlay.classList.add("show");
      document.body.classList.add("lock");
    });
  }

  if (closeSearchBtn) {
    closeSearchBtn.addEventListener("click", closeAll);
  }

  // ===============================
  // OVERLAY CLICK
  // ===============================
  if (overlay) {
    overlay.addEventListener("click", closeAll);
  }

  // ===============================
  // RESIZE : desktop > 1024px
  // ===============================
  window.addEventListener("resize", () => {
    if (window.innerWidth > 1024) closeAll();
  });

});
