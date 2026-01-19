/* ===============================
   BASE DE DONNÉES PRODUITS (FRONT)
================================ */

const products = [
  {
    id: 1,
    name: " Air Force one Tous categories",
    brand: "Nike",
    category: "running",
    price: 179.99,
    likes: 245,
    rating: 4.8,
    isNew: true,
    images: [
      "R1-LV.png",
      "R1-din.png",
      "R1-LV.png",
      "R1-FORCE.png",
    ],
    sizes: [
      "US 6","US 6.5","US 7","US 7.5","US 8",
      "US 8.5","US 9","US 9.5","US 10","US 10.5",
      "US 11","US 12","US 13"
    ],
    description: "Chaussure de running ultra légère avec retour d’énergie maximal."
  },

  {
    id: 2,
    name: "Adidas Ultraboost Light",
    brand: "Adidas",
    category: "running",
    price: 189.99,
    likes: 312,
    rating: 4.9,
    isNew: true,
    images: [
      "AIR JORDAN 1 MID SE(1).png",
      "AIR JORDAN 1 MID SE.png",
      "AIR JORDAN 1 MID SE(0).png",
      "AIR JORDAN 1 MID SE(1).png"
    ],
    sizes: [
      "US 6","US 7","US 8","US 9","US 10","US 11","US 12"
    ],
    description: "Confort extrême et amorti Boost pour les longues distances."
  },

  {
    id: 3,
    name: "Nike Air Jordan 1 Retro",
    brand: "Nike",
    category: "basketball",
    price: 199.99,
    likes: 540,
    rating: 5.0,
    isNew: false,
    images: [
      "AIR JORDAN 4 RETRO OG FC(1).png",
      "AIR JORDAN 4 RETRO OG FC(0).png",
      "AIR JORDAN 4 RETRO OG FC.png",
      "AIR JORDAN 4 RETRO OG FC(0).png"
    ],
    sizes: [
      "US 7","US 8","US 9","US 10","US 11","US 12","US 13"
    ],
    description: "Icône du basketball et du streetwear."
  },

  {
    id: 4,
    name: "Puma RS-X Tech",
    brand: "Puma",
    category: "sneakers",
    price: 139.99,
    likes: 188,
    rating: 4.5,
    isNew: false,
    images: [
      "W NIKE SHOX TL(1).png",
      "W NIKE SHOX TL(2).png",
      "W NIKE SHOX TL(3).png",
      "W NIKE SHOX TL(1).png"
    ],
    sizes: [
      "US 6","US 7","US 8","US 9","US 10","US 11"
    ],
    description: "Sneaker lifestyle au design futuriste."
  },

  {
    id: 5,
    name: "New Balance 550",
    brand: "New Balance",
    category: "sneakers",
    price: 159.99,
    likes: 421,
    rating: 4.7,
    isNew: true,
    images: [
      "new-balance-bleu-blanc.jpg",
      "new-balance-gris.jpg",
      "new-balance95.jpg",
      "new-balance-rose.jpg"
    ],
    sizes: [
      "US 7","US 8","US 9","US 10","US 11","US 12"
    ],
    description: "Style rétro inspiré du basketball des années 80."
  },

  {
    id: 6,
    name: "Under Armour Curry Flow 10",
    brand: "Under Armour",
    category: "basketball",
    price: 169.99,
    likes: 290,
    rating: 4.8,
    isNew: false,
    images: [
      "nocta-blanche.jpg",
      "nocta-noire.png",
      "nocta-jaune.jpg",
      "nocta-noire.png"
    ],
    sizes: [
      "US 7","US 8","US 9","US 10","US 11","US 12","US 13"
    ],
    description: "Performance ultime pour le basketball moderne."
  },

  {
    id: 7,
    name: "Timberland Classic Boot",
    brand: "Timberland",
    category: "mocassins",
    price: 189.99,
    likes: 260,
    rating: 4.6,
    isNew: false,
    images: [
      "AIR JORDAN 3 RETRO(3).png",
      "AIR JORDAN 3 RETRO.png",
      "AIR JORDAN 3 RETRO(0).png",
      "AIR JORDAN 3 RETRO(3).png"
    ],
    sizes: [
      "US 7","US 8","US 9","US 10","US 11","US 12"
    ],
    description: "Chaussure robuste et élégante pour toutes les saisons."
  }

];

/* ===============================
   CATÉGORIES DISPONIBLES
================================ */

const categories = [
  { id: "running", label: "Running" },
  { id: "basketball", label: "Basketball" },
  { id: "sneakers", label: "Sneakers" },
  { id: "mocassins", label: "Mocassins" }
];

/* ===============================
   UTILS (FILTRES)
================================ */

// Produits récents
const getNewProducts = () =>
  products.filter(p => p.isNew);

// Produits les plus likés
const getMostLikedProducts = () =>
  [...products].sort((a, b) => b.likes - a.likes);

// Meilleurs prix
const getCheapestProducts = () =>
  [...products].sort((a, b) => a.price - b.price);

// Par catégorie
const getProductsByCategory = category =>
  products.filter(p => p.category === category);

// Recherche
const searchProducts = keyword =>
  products.filter(p =>
    p.name.toLowerCase().includes(keyword.toLowerCase()) ||
    p.brand.toLowerCase().includes(keyword.toLowerCase())
  );
