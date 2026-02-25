document.addEventListener("DOMContentLoaded", () => {

  /* ===============================
     IMAGE PRINCIPALE + MINIATURES
  ================================ */
  const currentImage = document.getElementById("currentImage");
  const thumbs = document.querySelectorAll(".thumbs img");
  const prevBtn = document.querySelector(".nav-img.prev");
  const nextBtn = document.querySelector(".nav-img.next");
  const sizeButtons = document.querySelectorAll(".taille-btn");

  let index = 0;
  let startX = 0;

  /* ===============================
     INIT IMAGE (SI PRÉSENTE)
  ================================ */
  if (currentImage && thumbs.length > 0) {
    thumbs[0].classList.add("active");
    currentImage.src = thumbs[0].src;
  }

  /* ===============================
     FONCTION UPDATE IMAGE
  ================================ */
  function updateImage(i) {
    if (!currentImage || thumbs.length === 0) return;
    if (i < 0 || i >= thumbs.length) return;

    thumbs.forEach(t => t.classList.remove("active"));
    thumbs[i].classList.add("active");

    currentImage.style.opacity = "0";

    setTimeout(() => {
      currentImage.src = thumbs[i].src;
      currentImage.style.opacity = "1";
    }, 150);

    index = i;
  }

  /* ===============================
     CLIC MINIATURE
  ================================ */
  thumbs.forEach((thumb, i) => {
    thumb.addEventListener("click", () => updateImage(i));
  });

  /* ===============================
     BOUTONS ← →
  ================================ */
  if (prevBtn && nextBtn) {
    prevBtn.addEventListener("click", () => {
      updateImage((index - 1 + thumbs.length) % thumbs.length);
    });

    nextBtn.addEventListener("click", () => {
      updateImage((index + 1) % thumbs.length);
    });
  }

  /* ===============================
     NAVIGATION CLAVIER
  ================================ */
  document.addEventListener("keydown", (e) => {
    if (!currentImage) return;

    if (e.key === "ArrowLeft") {
      updateImage((index - 1 + thumbs.length) % thumbs.length);
    }

    if (e.key === "ArrowRight") {
      updateImage((index + 1) % thumbs.length);
    }
  });

  /* ===============================
     SWIPE TACTILE (MOBILE)
  ================================ */
  if (currentImage) {
    currentImage.addEventListener("touchstart", (e) => {
      startX = e.touches[0].clientX;
    });

    currentImage.addEventListener("touchend", (e) => {
      const endX = e.changedTouches[0].clientX;
      const diff = startX - endX;

      if (Math.abs(diff) > 50) {
        diff > 0
          ? updateImage((index + 1) % thumbs.length)
          : updateImage((index - 1 + thumbs.length) % thumbs.length);
      }
    });
  }

  /* ===============================
     GESTION DES TAILLES
  ================================ */
  sizeButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      sizeButtons.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      const input = btn.querySelector("input");
      if (input) input.checked = true;
    });
  });

});
