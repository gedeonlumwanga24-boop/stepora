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
