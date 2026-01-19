
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
  if (!productId) {
    alert("Produit introuvable");
    return;
  }

  currentProduct = products.find(p => p.id == productId);
  if (!currentProduct) {
    alert("Produit non trouvé");
    return;
  }

  // Infos produit
  productName.textContent = currentProduct.name;
  productPrice.textContent = `${currentProduct.price} €`;

  // Image principale
  mainImage.src = currentProduct.images[0];

  // Thumbnails
  thumbnailsContainer.innerHTML = "";
  currentProduct.images.forEach((img, index) => {
    const thumb = document.createElement("img");
    thumb.src = img;
    thumb.classList.toggle("active", index === 0);
    thumb.setAttribute("tabindex", 0); // accessible clavier
    thumb.addEventListener("click", () => changeImage(index));
    thumbnailsContainer.appendChild(thumb);
  });

  // Tailles
  sizesContainer.innerHTML = "";
  currentProduct.sizes.forEach(size => {
    const btn = document.createElement("button");
    btn.textContent = size;
    btn.setAttribute("tabindex", 0); // accessible clavier
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
  currentImageIndex = (currentImageIndex + 1) % currentProduct.images.length;
  changeImage(currentImageIndex);
}

function prevImage() {
  currentImageIndex =
    (currentImageIndex - 1 + currentProduct.images.length) % currentProduct.images.length;
  changeImage(currentImageIndex);
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
   AJOUT AU PANIER
================================ */
addToCartBtn.addEventListener("click", () => {
  if (!selectedSize) {
    alert("Veuillez sélectionner une taille");
    return;
  }

  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart.push({
    id: currentProduct.id,
    name: currentProduct.name,
    price: currentProduct.price,
    image: currentProduct.images[0],
    size: selectedSize,
    quantity: 1
  });
  localStorage.setItem("cart", JSON.stringify(cart));

  addToCartBtn.textContent = "✔ Ajouté";
  addToCartBtn.disabled = true;
  setTimeout(() => {
    addToCartBtn.textContent = "Ajouter au panier";
    addToCartBtn.disabled = false;
  }, 1500);
});

/* ===============================
   EVENTS
================================ */
nextBtn.addEventListener("click", nextImage);
prevBtn.addEventListener("click", prevImage);

/* ===============================
   NAVIGATION CLAVIER
================================ */
document.addEventListener("keydown", (e) => {
  switch (e.key) {
    case "ArrowLeft":
      prevImage();
      break;
    case "ArrowRight":
      nextImage();
      break;
    case "Enter":
    case " ":
      const active = document.activeElement;
      if (active.parentElement === sizesContainer || active === addToCartBtn) {
        active.click();
        e.preventDefault();
      }
      break;
  }
});

/* ===============================
   INIT
================================ */
loadProduct();
