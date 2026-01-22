/* ===============================
   HEADER COMPLET + PANIER + MENU + RECHERCHE
================================ */

document.addEventListener("DOMContentLoaded", () => {

  // ===============================
  // ELEMENTS
  // ===============================
  const cartBtn = document.getElementById("cartBtn");
  const cartPanel = document.getElementById("cartPanel");
  const closeCartBtn = document.getElementById("closeCart");

  const menuToggle = document.getElementById("menuToggle");
  const mobileMenu = document.getElementById("mobileMenu");
  const closeMenuBtn = document.getElementById("closeMenu");

  const searchBtn = document.getElementById("searchBtn");
  const searchOverlay = document.getElementById("searchOverlay");
  const closeSearchBtn = document.getElementById("closeSearch");
  const searchInput = searchOverlay.querySelector("input");

  const overlay = document.getElementById("overlay");

  // ===============================
  // FONCTION UTILITAIRE : fermer tout
  // ===============================
  function closeAll() {
    cartPanel.classList.remove("open");
    mobileMenu.classList.remove("open");
    searchOverlay.classList.remove("show");
    overlay.classList.remove("show");
    document.body.classList.remove("lock");
    searchInput.value = "";
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
      searchInput.focus();
    });
  }

  if (closeSearchBtn) {
    closeSearchBtn.addEventListener("click", closeAll);
  }

  // Écoute la saisie dans l’input
  searchInput.addEventListener("input", (e) => {
    const query = e.target.value.trim().toLowerCase();
    console.log("Recherche :", query);

    // Ici tu peux filtrer tes produits dynamiquement :
    // const results = products.filter(p => p.name.toLowerCase().includes(query));
    // afficherResults(results);
  });

  // ===============================
  // OVERLAY CLICK = fermer tout
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

// ===============================
// BOUTONS AJOUT PANIER
// ===============================
document.querySelectorAll(".add-to-cart").forEach(btn => {
  btn.addEventListener("click", () => {

    const product = {
      id: btn.dataset.id,
      name: btn.dataset.name,
      price: parseFloat(btn.dataset.price),
      images: [btn.dataset.image]
    };

    addToCart(product); // fonction déjà existante dans ton JS
    alert(`${product.name} ajouté au panier !`);
  });
});


// ---------------------------
// GÉRER LE PANIER
// ---------------------------
window.addToCart = function (product) {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];

  // Vérifier si le produit + taille existe déjà
  const existing = cart.find(
    item => item.id === product.id && item.size === product.size
  );

  if (existing) {
    existing.quantity += 1;
  } else {
    cart.push({ ...product, quantity: 1 });
  }

  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartUI();
};

// ---------------------------
// METTRE À JOUR L’AFFICHAGE DU PANIER
// ---------------------------
function updateCartUI() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const cartItemsContainer = document.getElementById("cartItems");
  const cartCount = document.querySelector(".cart-count");
  const cartTotal = document.getElementById("cartTotal");

  if (!cartItemsContainer || !cartCount || !cartTotal) return;

  if (cart.length === 0) {
    cartItemsContainer.innerHTML = '<p class="empty-cart">Aucun article pour l’instant</p>';
  } else {
    cartItemsContainer.innerHTML = cart
      .map(
        item => `
      <div class="cart-item">
        <img src="${item.images[0]}" alt="${item.name}" />
        <div>
          <p>${item.name} - ${item.size}</p>
          <p>${item.quantity} x ${item.price.toFixed(2)} €</p>
        </div>
      </div>
    `
      )
      .join("");
  }

  cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
  cartTotal.textContent = cart
    .reduce((sum, item) => sum + item.price * item.quantity, 0)
    .toFixed(2);
}

// Mettre à jour le panier au chargement
updateCartUI();



