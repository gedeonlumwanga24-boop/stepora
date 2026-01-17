const products = [
  {
    id: 1,
    name: "Adidas Samba OG Beige",
    price: 102,
    likes: 210,
    date: "2026-01-16",
    category: "sneakers",
    image: "R1.jpg"
  },
  {
    id: 2,
    name: "Adidas Samba Rose",
    price: 90,
    likes: 350,
    date: "2026-01-10",
    category: "sneakers",
    image: "NB.jpg"
  },
  {
    id: 3,
    name: "Sneakers minimalistes blanches",
    price: 19.99,
    likes: 80,
    date: "2026-01-05",
    category: "sneakers",
    image: "air-max.jpg"
  },
  {
    id: 4,
    name: "Mocassins cuir noir",
    price: 34.99,
    likes: 140,
    date: "2026-01-08",
    category: "mocassins",
    image: "air-max2.jpg"
  },
  {
    id: 5,
    name: "Mocassins daim moka",
    price: 24.13,
    likes: 60,
    date: "2026-01-02",
    category: "mocassins",
    image: "air-max95.jpg"
  }

];



const grids = {
  recent: document.getElementById("recent"),
  liked: document.getElementById("liked"),
  cheap: document.getElementById("cheap"),
  sneakers: document.getElementById("sneakers"),
  mocassins: document.getElementById("mocassins")
};

function cardTemplate(p) {
  return `
    <div class="product-card" onclick="openProduct(${p.id})">
      <div class="product-image">
        <img src="${p.image}" alt="${p.name}">
      </div>
      <div class="like-btn">❤️</div>
      <div class="product-info">
        <p>${p.name}</p>
        <span>${p.price} €</span>
      </div>
    </div>
  `;
}

function openProduct(id) {
  window.location.href = `produit.html?id=${id}`;
}


function render(list) {
  Object.values(grids).forEach(g => g.innerHTML = "");

  [...list].sort((a,b)=>new Date(b.date)-new Date(a.date))
    .forEach(p => grids.recent.innerHTML += cardTemplate(p));

  [...list].sort((a,b)=>b.likes-a.likes)
    .forEach(p => grids.liked.innerHTML += cardTemplate(p));

  [...list].sort((a,b)=>a.price-b.price)
    .forEach(p => grids.cheap.innerHTML += cardTemplate(p));

  list.filter(p=>p.category==="sneakers")
    .forEach(p => grids.sneakers.innerHTML += cardTemplate(p));

  list.filter(p=>p.category==="mocassins")
    .forEach(p => grids.mocassins.innerHTML += cardTemplate(p));
}

render(products);

/* SEARCH */
document.getElementById("searchInput").addEventListener("input", e => {
  const value = e.target.value.toLowerCase();
  const filtered = products.filter(p =>
    p.name.toLowerCase().includes(value)
  );
  render(filtered);
});