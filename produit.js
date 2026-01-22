/* ===============================
   RÉCUPÉRATION ID PRODUIT
================================ */
const params = new URLSearchParams(window.location.search);
const productId = params.get("id");

/* ===============================
   ÉLÉMENTS DOM
================================ */
const mainImage = document.getElementById("mainImage");
const thumbnailsContainer = document.getElementById("thumbnails");
const productName = document.getElementById("productName");
const productPrice = document.getElementById("productPrice");
const sizesContainer = document.getElementById("sizes");
const addToCartBtn = document.getElementById("addToCart");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

/* ===============================
   VARIABLES
================================ */
let currentImageIndex = 0;
let selectedSize = null;
let currentProduct = null;

/* ===============================
   CHARGEMENT PRODUIT
================================ */
function loadProduct() {
  if (!productId || typeof products === "undefined") {
    console.error("Produit ou base de données introuvable");
    return;
  }

  currentProduct = products.find(p => String(p.id) === String(productId));

  if (!currentProduct) {
    console.error("Produit non trouvé");
    return;
  }

  // Infos produit
  productName.textContent = currentProduct.name;
  productPrice.textContent = `${currentProduct.price.toFixed(2)} €`;

  // Image principale
  mainImage.src = currentProduct.images[0];

  // Thumbnails
  thumbnailsContainer.innerHTML = "";
  currentProduct.images.forEach((img, index) => {
    const thumb = document.createElement("img");
    thumb.src = img;
    thumb.classList.toggle("active", index === 0);
    thumb.addEventListener("click", () => changeImage(index));
    thumbnailsContainer.appendChild(thumb);
  });

  // Tailles
  sizesContainer.innerHTML = "";
  currentProduct.sizes.forEach(size => {
    const btn = document.createElement("button");
    btn.textContent = size;
    btn.addEventListener("click", () => selectSize(btn, size));
    sizesContainer.appendChild(btn);
  });
}

/* ===============================
   GALERIE IMAGES
================================ */
function changeImage(index) {
  currentImageIndex = index;
  mainImage.src = currentProduct.images[index];
  document.querySelectorAll(".thumbnails img").forEach((img, i) => {
    img.classList.toggle("active", i === index);
  });
}

function nextImage() {
  changeImage((currentImageIndex + 1) % currentProduct.images.length);
}

function prevImage() {
  changeImage(
    (currentImageIndex - 1 + currentProduct.images.length) %
    currentProduct.images.length
  );
}

/* ===============================
   SÉLECTION TAILLE
================================ */
function selectSize(button, size) {
  document.querySelectorAll(".sizes button").forEach(btn =>
    btn.classList.remove("active")
  );
  button.classList.add("active");
  selectedSize = size;
}

/* ===============================
   AJOUT AU PANIER ✅
================================ */
addToCartBtn.addEventListener("click", () => {

  if (!selectedSize) {
    alert("Veuillez sélectionner une taille");
    return;
  }

  if (typeof window.addToCart !== "function") {
    console.error("addToCart n'est pas défini (header.js manquant)");
    return;
  }

  window.addToCart({
    id: currentProduct.id,
    name: currentProduct.name,
    price: currentProduct.price,
    image: currentProduct.images[0],
    size: selectedSize
  });

  // Feedback bouton
  addToCartBtn.textContent = "✔ Ajouté";
  addToCartBtn.disabled = true;

  setTimeout(() => {
    addToCartBtn.textContent = "Ajouter au panier";
    addToCartBtn.disabled = false;
  }, 1200);
});

/* ===============================
   EVENTS
================================ */
prevBtn.addEventListener("click", prevImage);
nextBtn.addEventListener("click", nextImage);

/* ===============================
   INIT
================================ */
loadProduct();
