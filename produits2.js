/* ===============================
   ELEMENTS
================================ */
const recentContainer = document.getElementById("recent");
const likedContainer = document.getElementById("liked");
const cheapContainer = document.getElementById("cheap");

const sneakersContainer = document.getElementById("sneakers");
const mocassinsContainer = document.getElementById("mocassins");
const basketsContainer = document.getElementById("Baskets");
const timberlandContainer = document.getElementById("Timberland");

const searchInput = document.getElementById("searchInput");

/* ===============================
   CREATION CARTE PRODUIT
================================ */
function createProductCard(product) {
  const card = document.createElement("div");
  card.className = "product-card";
  card.dataset.id = product.id;

  card.innerHTML = `
    <img src="${product.images[0]}" alt="${product.name}">
    <h3>${product.name}</h3>
    <p class="price">${product.price} €</p>
  `;

  // 🔥 REDIRECTION PRODUIT
  card.addEventListener("click", () => {
    window.location.href = `produit.html?id=${product.id}`;
  });

  return card;
}

/* ===============================
   AFFICHAGE PAR SECTION
================================ */
function renderProducts(container, list) {
  container.innerHTML = "";
  list.forEach((product) => {
    container.appendChild(createProductCard(product));
  });
}

/* ===============================
   INITIAL RENDER
================================ */

// 🆕 Les plus récents
renderProducts(
  recentContainer,
  products.filter((p) => p.isNew),
);

// 🔥 Les plus likés
renderProducts(
  likedContainer,
  [...products].sort((a, b) => b.likes - a.likes),
);

// 💸 Meilleurs prix
renderProducts(
  cheapContainer,
  [...products].sort((a, b) => a.price - b.price),
);

// 👟 Sneakers
renderProducts(
  sneakersContainer,
  products.filter((p) => p.category === "sneakers"),
);

// 🥿 Mocassins
renderProducts(
  mocassinsContainer,
  products.filter((p) => p.category === "mocassins"),
);

// 🏀 Baskets
renderProducts(
  basketsContainer,
  products.filter((p) => p.category === "basketball"),
);

// 🌲 Timberland
renderProducts(
  timberlandContainer,
  products.filter((p) => p.brand === "Timberland"),
);

/* ===============================
   SEARCH (LIVE)
================================ */
searchInput.addEventListener("input", () => {
  const value = searchInput.value.toLowerCase();

  const filtered = products.filter(
    (p) =>
      p.name.toLowerCase().includes(value) ||
      p.brand.toLowerCase().includes(value),
  );

  // On affiche les résultats dans "Les plus récents"
  renderProducts(recentContainer, filtered);

  // On vide les autres sections
  likedContainer.innerHTML = "";
  cheapContainer.innerHTML = "";
  sneakersContainer.innerHTML = "";
  mocassinsContainer.innerHTML = "";
  basketsContainer.innerHTML = "";
  timberlandContainer.innerHTML = "";
});

/* ===============================
 ELEMENTS ENTETE PANIER RECHERCHE
================================ */

const searchBtn = document.getElementById("searchBtn");
const searchOverlay = document.getElementById("searchOverlay");

const cartBtn = document.getElementById("cartBtn");
const cartPanel = document.getElementById("cartPanel");

const menuToggle = document.getElementById("menuToggle");
const mobileMenu = document.getElementById("mobileMenu");

/* ===== SEARCH ===== */
searchBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  searchOverlay.style.display = "flex";
  cartPanel.classList.remove("active");
  mobileMenu.classList.remove("active");
  searchInput.focus();
});

// clic sur le fond → ferme
searchOverlay.addEventListener("click", () => {
  searchOverlay.style.display = "none";
});

// clic dans l'input → ne ferme pas
searchInput.addEventListener("click", (e) => {
  e.stopPropagation();
});

/* ===== CART ===== */
cartBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  cartPanel.classList.toggle("active");
  searchOverlay.style.display = "none";
  mobileMenu.classList.remove("active");
});

// clic en dehors du panier → ferme
document.addEventListener("click", (e) => {
  if (!cartPanel.contains(e.target) && !cartBtn.contains(e.target)) {
    cartPanel.classList.remove("active");
  }
});

// clic sur bouton ou lien du panier → ferme
cartPanel.querySelectorAll("button, a").forEach((el) => {
  el.addEventListener("click", () => {
    cartPanel.classList.remove("active");
  });
});

/* ===== MOBILE MENU ===== */
menuToggle.addEventListener("click", (e) => {
  e.stopPropagation();
  mobileMenu.classList.toggle("active");
  cartPanel.classList.remove("active");
  searchOverlay.style.display = "none";
});

// clic sur lien du menu → ferme
document.querySelectorAll(".mobile-menu a").forEach((link) => {
  link.addEventListener("click", () => {
    mobileMenu.classList.remove("active");
  });
});



/* ===============================
/* ===============================
   header.js
================================ */
/* ===============================
   gere le panier tous les menus de header
================================ */

/* ===============================
   ELEMENTS DOM
================================ */

const cartItems = document.getElementById("cartItems");
const cartTotal = document.getElementById("cartTotal");
const cartCount = document.querySelector(".cart-count");

const overlay = document.getElementById("overlay");

/* ===============================
   UTILS CART
================================ */
function getCart() {
  return JSON.parse(localStorage.getItem("cart")) || [];
}

function saveCart(cart) {
  localStorage.setItem("cart", JSON.stringify(cart));
}

window.addToCart = function (product) {
  const cart = getCart();

  const existing = cart.find(
    (item) => item.id === product.id && item.size === product.size,
  );

  if (existing) {
    existing.quantity += 1;
  } else {
    cart.push({ ...product, quantity: 1 });
  }

  saveCart(cart);
  updateCartUI();
  openCart();
};

function removeFromCart(index) {
  const cart = getCart();
  cart.splice(index, 1);
  saveCart(cart);
  updateCartUI();
}

/* ===============================
   UPDATE CART UI
================================ */
function updateCartUI() {
  const cart = getCart();
  cartItems.innerHTML = "";

  if (cart.length === 0) {
    cartItems.innerHTML = `<p class="empty-cart">Aucun article pour l’instant</p>`;
    cartCount.textContent = "0";
    cartTotal.textContent = "0.00";
    cartCount.style.display = "none";
    return;
  }

  let total = 0;
  let count = 0;

  cart.forEach((item, index) => {
    total += item.price * item.quantity;
    count += item.quantity;

    const div = document.createElement("div");
    div.className = "cart-item";

    div.innerHTML = `
      <img src="${item.image}" alt="${item.name}">
      <div class="cart-info">
        <strong>${item.name}</strong>
        <span>Taille : ${item.size}</span>
        <p>${item.quantity} × ${item.price.toFixed(2)} €</p>
      </div>
      <button class="remove-btn">×</button>
    `;

    div.querySelector(".remove-btn").addEventListener("click", () => {
      removeFromCart(index);
    });

    cartItems.appendChild(div);
  });

  cartCount.textContent = count;
  cartCount.style.display = count === 0 ? "none" : "inline-block";
  cartTotal.textContent = total.toFixed(2);
}

/* ===============================
   OPEN / CLOSE CART
================================ */
function openCart() {
  cartPanel.classList.add("open");
  overlay.classList.add("show");
  mobileMenu.classList.remove("open");
}

function closeCart() {
  cartPanel.classList.remove("open");
  overlay.classList.remove("show");
}

/* ===============================
   OPEN / CLOSE MOBILE MENU
================================ */
function openMobileMenu() {
  mobileMenu.classList.add("open");
  overlay.classList.add("show");
  cartPanel.classList.remove("open");
}

function closeMobileMenu() {
  mobileMenu.classList.remove("open");
  overlay.classList.remove("show");
}

/* ===============================
   EVENT LISTENERS
================================ */
// Cart button
cartBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  if (cartPanel.classList.contains("open")) {
    closeCart();
  } else {
    openCart();
  }
});

// Menu toggle
menuToggle.addEventListener("click", (e) => {
  e.stopPropagation();
  if (mobileMenu.classList.contains("open")) {
    closeMobileMenu();
  } else {
    openMobileMenu();
  }
});

// Close buttons inside mobile menu or cart
document.querySelectorAll(".mobile-menu .close-btn").forEach((btn) => {
  btn.addEventListener("click", closeMobileMenu);
});
document.querySelectorAll(".cart-panel .close-btn").forEach((btn) => {
  btn.addEventListener("click", closeCart);
});

// Click overlay to close
overlay.addEventListener("click", () => {
  closeCart();
  closeMobileMenu();
});

// Click outside → ferme
document.addEventListener("click", (e) => {
  if (
    !cartPanel.contains(e.target) &&
    !cartBtn.contains(e.target) &&
    !mobileMenu.contains(e.target) &&
    !menuToggle.contains(e.target)
  ) {
    closeCart();
    closeMobileMenu();
  }
});

// Search
searchBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  searchOverlay.classList.add("show");
  overlay.classList.add("show");
  closeCart();
  closeMobileMenu();
});

searchOverlay.addEventListener("click", () => {
  searchOverlay.classList.remove("show");
  overlay.classList.remove("show");
});
searchInput.addEventListener("click", (e) => e.stopPropagation());

/* ===============================
   INIT
================================ */
updateCartUI();
