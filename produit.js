const images = [
  "R1.jpg",
  "R1.jpg",
  "i.jpg",
  "images/shoe4.jpg"
];

let index = 0;
const mainImage = document.getElementById("mainImage");

/* GALLERY */
function changeImage(el) {
  mainImage.src = el.src;
}

function nextImage() {
  index = (index + 1) % images.length;
  mainImage.src = images[index];
}

function prevImage() {
  index = (index - 1 + images.length) % images.length;
  mainImage.src = images[index];
}

/* SIZE SELECT */
document.querySelectorAll(".sizes button").forEach(btn => {
  btn.addEventListener("click", () => {
    document.querySelectorAll(".sizes button")
      .forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
  });
});

/* CART */
document.querySelector(".add-to-cart").addEventListener("click", () => {
  const selected = document.querySelector(".sizes button.active");
  if (!selected) {
    alert("Veuillez sélectionner une taille");
    return;
  }
  alert("Ajouté au panier ✔");
});


document.querySelector("h1").textContent = product.name;
document.querySelector(".price").textContent = product.price + " €";



/* THUMBNAILS */
const thumbnails = document.querySelector(".thumbnails");
thumbnails.innerHTML = "";

product.images.forEach(img => {
  thumbnails.innerHTML += `
    <img src="${img}" onclick="changeImage(this)">
  `;
});

/* SIZES */
const sizesContainer = document.querySelector(".sizes");
sizesContainer.innerHTML = "";

product.sizes.forEach(size => {
  sizesContainer.innerHTML += `<button>${size}</button>`;
});


document.addEventListener("click", e => {
  if (e.target.parentElement.classList.contains("sizes")) {
    document.querySelectorAll(".sizes button")
      .forEach(b => b.classList.remove("active"));
    e.target.classList.add("active");
  }
});


document.querySelector(".add-to-cart").addEventListener("click", () => {
  const size = document.querySelector(".sizes button.active");
  if (!size) {
    alert("Choisissez une taille");
    return;
  }

  const cartItem = {
    id: product.id,
    name: product.name,
    price: product.price,
    size: size.textContent,
    image: product.images[0],
    qty: 1
  };

  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart.push(cartItem);
  localStorage.setItem("cart", JSON.stringify(cart));

  alert("Produit ajouté au panier ✔");
});


/* GET ID FROM URL */
const params = new URLSearchParams(window.location.search);
const productId = parseInt(params.get("id"));

/* FIND PRODUCT */
const product = PRODUCTS.find(p => p.id === productId);

if (!product) {
  document.body.innerHTML = "<h2>Produit introuvable</h2>";
}


