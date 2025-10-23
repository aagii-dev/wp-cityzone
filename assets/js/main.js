let lenis; // глобал ашиглая

// Header/Footer ачаалсны дараа дуудагдана
async function loadPartials() {
  // const header = await fetch("components/menu.html").then((r) => r.text());
  // document.getElementById("menu")?.insertAdjacentHTML("beforeend", header);

  // const footer = await fetch("components/footer.html").then((r) => r.text());
  // document.getElementById("footer")?.insertAdjacentHTML("beforeend", footer);

  updateFooterLink();
  updateFooterText();

  initLenis();
  initPageHeroParallax();
  initMenu();
  initScrollTop();
}

// 1) LENIS setup
function initLenis() {
  if (window.Lenis) {
    const lenis = new Lenis({
      duration: 1.5,
      easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      smooth: true,
    });

    lenis.on("scroll", updatePageHeroParallax);

    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);

    // Дотоод anchor линкүүдийг зөөлөн хөдөлгөх
    document.body.addEventListener("click", (e) => {
      const a = e.target.closest('a[href^="#"]');
      if (!a) return;

      const target = a.getAttribute("href");
      if (target && target !== "#" && document.querySelector(target)) {
        e.preventDefault();
        lenis.scrollTo(target, { offset: 0 }); // шаардвал offset тавиарай
      }
    });
  }
}

// ---------------- HERO PARALLAX ----------------
// ====== Config ======
const PAGE_PARALLAX_SPEED = 0.25; // 0.15–0.35 орчим
const HERO_ZOOM = {
  mode: "in", // "in" | "out" | "both"
  min: 1.02, // багын scale
  max: 1.32, // ихийн scale
  pivot: 0.5, // "both" үед хаана эргүүлэх (0..1)
  ease: (t) => 1 - (1 - t) * (1 - t), // easeOutQuad
};

let _heroEl,
  _heroImg,
  _ticking = false;

function lerp(a, b, t) {
  return a + (b - a) * t;
}

function updatePageHeroParallax() {
  if (!_heroEl || !_heroImg) return;

  const rect = _heroEl.getBoundingClientRect();
  const vh = window.innerHeight;
  // үзэгдэхгүй байвал алгас
  if (rect.bottom <= 0 || rect.top >= vh) return;

  // translateY
  const y = Math.round(-rect.top * PAGE_PARALLAX_SPEED);

  // 0..1 progress
  const raw = 1 - Math.min(Math.max(rect.top / vh, 0), 1);
  const t = HERO_ZOOM.ease ? HERO_ZOOM.ease(raw) : raw;

  // scale (in | out | both)
  const { mode, min, max, pivot } = HERO_ZOOM;
  let scale;
  if (mode === "in") {
    scale = lerp(min, max, t);
  } else if (mode === "out") {
    scale = lerp(max, min, t);
  } else {
    // both: эхний хагаст IN, дараагийн хагаст OUT
    if (t <= pivot) {
      scale = lerp(min, max, t / pivot);
    } else {
      scale = lerp(max, min, (t - pivot) / (1 - pivot));
    }
  }

  _heroImg.style.transform = `translate3d(0, ${y}px, 0) scale(${scale})`;
}

function requestTick() {
  if (_ticking) return;
  _ticking = true;
  requestAnimationFrame(() => {
    _ticking = false;
    updatePageHeroParallax();
  });
}

function initPageHeroParallax() {
  _heroEl = document.querySelector(".page-hero");
  _heroImg = _heroEl?.querySelector("img");
  if (!_heroEl || !_heroImg) return;

  // (сонголтоор) HTML-ээс горим унших: <div class="page-hero" data-zoom="out">
  const dz = _heroEl.dataset.zoom;
  if (dz === "in" || dz === "out" || dz === "both") HERO_ZOOM.mode = dz;

  _heroImg.style.willChange = "transform";

  updatePageHeroParallax();
  window.addEventListener("scroll", requestTick, { passive: true });
  window.addEventListener("resize", requestTick);
}

// дууд
initPageHeroParallax();

// 2) MENU toggle – нээгдэхэд scroll lock, хаагдахдаа unlock
function initMenu() {
  const overlay = document.getElementById("menuOverlay");
  const btn = document.getElementById("menuBtn");
  if (!overlay || !btn) return;

  function toggleMenu(force) {
    const willOpen =
      typeof force === "boolean" ? force : !overlay.classList.contains("show");
    overlay.classList.toggle("show", willOpen);
    document.body.classList.toggle("menu-open", willOpen);

    // Lenis-г зогсоож/асгана (underlying scroll-ыг барих)
    if (lenis) {
      willOpen ? lenis.stop() : lenis.start();
    }
  }

  btn.addEventListener("click", () => toggleMenu());
  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape") toggleMenu(false);
  });
}

// 3) Arrow-up – Lenis-ээр дээш зөөлөн очих
function initScrollTop() {
  const arrow = document.getElementById("scrollTop"); // footer доторх сум
  if (!arrow) return;

  const goTop = () => {
    if (lenis) lenis.scrollTo(0);
    else window.scrollTo({ top: 0, behavior: "smooth" });
  };

  arrow.addEventListener("click", goTop);
  arrow.addEventListener("keydown", (e) => {
    if (e.key === "Enter" || e.key === " ") goTop();
  });
}

function updateFooterText() {
  // const textEl = document.querySelector(".footer-head .text");
  // if (!textEl) return;

  // const spanEl = textEl.querySelector("span");
  // const path = (window.location.pathname || "").replace(/\/+$/, "");

  // if (/\/about\.html$/i.test(path)) {
  //   textEl.firstChild.textContent = "төсөл хэрэгжүүлэгчийн";
  //   if (spanEl) spanEl.textContent = " талаарх дэлгэрэнгүй";
  // } else {
  //   textEl.firstChild.textContent = "Та онлайн брошуртай танилцсанаар";
  //   if (spanEl) spanEl.textContent = " дэлгэрэнгүй мэдээлэл авах боломжтой";
  // }
}

function updateFooterLink() {
  // const link = document.getElementById("footer-link");
  // if (!link) return;

  // const path = (window.location.pathname || "").replace(/\/+$/, "");

  // if (/\/about\.html$/i.test(path)) {
  //   setLink(
  //     link,
  //     "https://tesoproperties.mn/mn/%d0%b1%d0%b8%d0%b4%d0%bd%d0%b8%d0%b9-%d1%82%d1%83%d1%85%d0%b0%d0%b9/",
  //     "Дэлгэрэнгүй"
  //   );
  // } else {
  //   setLink(link, "/assets/pdf/room.pdf", "Танилцах");
  //   link.setAttribute("download", "cityzone-brochure.pdf");
  // }
}

function setLink(el, href, text) {
  el.href = href;
  const span = el.querySelector("span");
  if (span) span.textContent = text;
  else el.textContent = text;
}

// DOM ready
document.addEventListener("DOMContentLoaded", loadPartials);
