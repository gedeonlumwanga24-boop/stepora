/* ===============================
   ELEMENTS DOM
================================ */
const cartBtn = document.getElementById("cartBtn");
const cartPanel = document.getElementById("cartPanel");
const cartItems = document.getElementById("cartItems");
const cartTotal = document.getElementById("cartTotal");
const cartCount = document.querySelector(".cart-count");

const menuToggle = document.getElementById("menuToggle");
const mobileMenu = document.getElementById("mobileMenu");

const searchBtn = document.getElementById("searchBtn");
const searchOverlay = document.getElementById("searchOverlay");
const searchInput = searchOverlay.querySelector("input");

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

window.addToCart = function(product) {
  const cart = getCart();

  const existing = cart.find(
    item => item.id === product.id && item.size === product.size
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
document.querySelectorAll(".mobile-menu .close-btn").forEach(btn => {
  btn.addEventListener("click", closeMobileMenu);
});
document.querySelectorAll(".cart-panel .close-btn").forEach(btn => {
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
