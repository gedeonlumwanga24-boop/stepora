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




/* ===============================
/* ===============================
   index.js
================================ */
/* ===============================
   animation de l'accueil
================================ */


const shoe = document.getElementById("heroShoe");
const dots = document.querySelectorAll(".color-dot");


/* CHANGEMENT DE COULEUR */
document.addEventListener("DOMContentLoaded", () => {

  const shoe = document.getElementById("heroShoe");
  const dots = document.querySelectorAll(".color-dot");

  const images = {
  white: "air-max.jpg",
  black: "j4-noire.jpg",
  blue: "j-1-retro.jpg"
  };

  const auraColors = {
    white: "rgba(255,255,255,0.25)",
    black: "rgba(120,120,120,0.25)",
    blue: "rgba(59,130,246,0.35)"
  };

  dots.forEach(dot => {
    dot.addEventListener("click", () => {

      dots.forEach(d => d.classList.remove("active"));
      dot.classList.add("active");

      const color = dot.dataset.color;

      // animation image
      shoe.style.opacity = "0";

      setTimeout(() => {
        shoe.src = images[color];
        shoe.style.opacity = "1";

        // 🎨 changement de l’aura
        document
          .querySelector(".hero")
          .style
          .setProperty("--aura-color", auraColors[color]);

      }, 250);
    });
  });

});


const colorDots = document.querySelectorAll('.color-dot');
const buyButton = document.querySelector('.hero-content button');
const heroShoe = document.getElementById('heroShoe');

const colorMap = {
  white: '#065157',
  black: '#111111',
  blue: '#3b82f6'
};

const imageMap = {
  white: "air-max.jpg",
  black: "j4-noire.jpg",
  blue: "j-1-retro.jpg"
  };

colorDots.forEach(dot => {
  dot.addEventListener('click', () => {
    // Supprimer la classe active des autres
    colorDots.forEach(d => d.classList.remove('active'));
    dot.classList.add('active');

    // Changer la couleur du bouton
    const color = dot.getAttribute('data-color');
    buyButton.style.backgroundColor = colorMap[color];

    // Changer l'image de la chaussure
    heroShoe.src = imageMap[color];
  });
});

// Optionnel : effet clic bouton
buyButton.addEventListener('click', () => {
  buyButton.style.transform = 'scale(0.95)';
  setTimeout(() => {
    buyButton.style.transform = 'scale(1)';
  }, 150);
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


  // Valeurs initiales pour la rotation
let rotateX = 12;
let rotateY = -18;

// Mouvement 3D automatique (respiration subtile)
let angle = 0;
function autoRotate() {
  angle += 0.04; // vitesse de rotation automatique
  const autoX = Math.sin(angle) * 3; // amplitude X
  const autoY = Math.cos(angle) * 3; // amplitude Y

  shoe.style.transform = `
    perspective(1200px)
    rotateX(${rotateX + autoX}deg)
    rotateY(${rotateY + autoY}deg)
    translateY(40px)
  `;
  requestAnimationFrame(autoRotate);
}
autoRotate();

// Effet supplémentaire quand la souris bouge
document.addEventListener("mousemove", (e) => {
  const x = (window.innerWidth / 2 - e.clientX) / 40;
  const y = (window.innerHeight / 2 - e.clientY) / 40;

  rotateX = 12 + y;
  rotateY = -18 + x;
});



/* ===============================
 ELEMENTS ENTETE PANIER RECHERCHE
================================ */



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