
const toggleFilters = document.getElementById("toggleFilters");
const filtersPanel = document.getElementById("filtersPanel");
const priceRange = document.getElementById("priceRange");
const priceValue = document.getElementById("priceValue");
const sortSelect = document.getElementById("sortSelect");
const cards = [...document.querySelectorAll(".product-card")];
const grid = document.getElementById("produitsGrid");

/* Toggle filtres mobile */
toggleFilters.addEventListener("click", () => {
  filtersPanel.classList.toggle("open");
});

/* Prix affichage */
priceRange.addEventListener("input", () => {
  priceValue.textContent = priceRange.value + " FC";

  cards.forEach(card => {
    card.style.display =
      card.dataset.price <= priceRange.value ? "block" : "none";
  });
});

/* Tri */
sortSelect.addEventListener("change", () => {
  let sorted = [...cards];

  if (sortSelect.value === "price_asc") {
    sorted.sort((a, b) => a.dataset.price - b.dataset.price);
  }

  if (sortSelect.value === "price_desc") {
    sorted.sort((a, b) => b.dataset.price - a.dataset.price);
  }

  grid.innerHTML = "";
  sorted.forEach(c => grid.appendChild(c));
});





