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
      "AIR FORCE 1 '07 FLYEASE.png",
      "AIR FORCE 1 '07 FLYEASE(0).png",
      "AIR FORCE 1 '07 FLYEASE(5).png",
      "AIR FORCE 1 '07 FLYEASE(3).png",
      "AIR FORCE 1 '07 FLYEASE(7).png",
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
    name: "AIR MAX 95 BIG BUBBLE ZIP",
    brand: "Adidas",
    category: "running",
    price: 189.99,
    likes: 312,
    rating: 4.9,
    isNew: true,
    images: [
      "AIR MAX 95 BIG BUBBLE ZIP SP.png",
      "AIR MAX 95 BIG BUBBLE ZIP SP(1).png",
      "AIR MAX 95 BIG BUBBLE ZIP SP(2).png",
      "AIR MAX 95 BIG BUBBLE ZIP SP(3).png"
    ],
    sizes: [
      "US 6","US 7","US 8","US 9","US 10","US 11","US 12"
    ],
    description: "Confort extrême et amorti Boost pour les longues distances."
  },

  {
    id: 3,
    name: "AIR JORDAN 1 MID SE",
    brand: "Nike",
    category: "basketball",
    price: 199.99,
    likes: 540,
    rating: 5.0,
    isNew: false,
    images: [
      "AIR JORDAN 1 MID SE(3).png",
      "AIR JORDAN 1 MID SE.png",
      "AIR JORDAN 1 MID SE(4).png",
      "AIR JORDAN 1 MID SE(2).png"
    ],
    sizes: [
      "US 7","US 8","US 9","US 10","US 11","US 12","US 13"
    ],
    description: "Icône du basketball et du streetwear."
  },

  {
    id: 4,
    name: "W NIKE SHOX TL",
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
    name: "JORDAN SPIZIKE LOW",
    brand: "Under Armour",
    category: "basketball",
    price: 169.99,
    likes: 290,
    rating: 4.8,
    isNew: false,
    images: [
      "JORDAN SPIZIKE LOW.png",
      "JORDAN SPIZIKE LOW(1).png",
      "JORDAN SPIZIKE LOW(0).png",
      "JORDAN SPIZIKE LOW(3).png",
      "JORDAN SPIZIKE LOW(2).png"
    ],
    sizes: [
      "US 7","US 8","US 9","US 10","US 11","US 12","US 13"
    ],
    description: "Performance ultime pour le basketball moderne."
  },

  {
    id: 7,
    name: "AIR JORDAN 3 RETRO",
    brand: "Basketsurbaines",
    category: "Basketsurbaines",
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
      "US 7","US 8","US 9","US 10","US 11","US 12","US 14","US 18"
    ],
    description: "Chaussure robuste et élégante pour toutes les saisons."
  },


    {
    id: 8,
    name: "NIKE AIR MAX 90",
    brand: "SneakersLifestyle",
    category: "SneakersLifestyle",
    price: 189.99,
    likes: 260,
    rating: 4.6,
    isNew: false,
    images: [
      "NIKE AIR MAX 90.png",
      "NIKE AIR MAX 90(1).png",
      "NIKE AIR MAX 90(3).png",
      "NIKE AIR MAX 90(2).png"
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
  { id: "Basketsurbaines", label: "Basketsurbaines" },
  { id: "SneakersLifestyle", label: "SneakersLifestyle" }
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
