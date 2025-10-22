document.addEventListener("DOMContentLoaded", function () {
  let lastScrollTop = 0
  const navbar = document.getElementById("mainNavbar")

  window.addEventListener("scroll", function () {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop

    // --- navbar харагдах/нуух
    if (scrollTop > lastScrollTop) {
      navbar.classList.add("nav-up") // Доошоо
    } else {
      navbar.classList.remove("nav-up") // Дээшээ
    }

    // --- scrollTop === 0 үед transparent нэмэх
    if (scrollTop <= 400) {
      navbar.classList.add("ghost")
    } else {
      navbar.classList.remove("ghost")
    }

    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop // iOS fix
  })
})

// jQuery(document).ready(function ($) {
//   $(".menu-item-has-children > a").on("click", function (e) {
//     e.preventDefault() // линк шууд очихоос сэргийлнэ
//     var container = $(this).siblings(".sub-menu-container")
//     const mainNavbar = $("#mainNavbar")
//     mainNavbar.addClass("active")
//     // Нэгийг нь нээхэд бусдыг хаах
//     $(".sub-menu-container").not(container).removeClass("active")

//     container.toggleClass("active")
//   })
// })
jQuery(function ($) {
  const $mainNavbar = $("#mainNavbar")

  // Lenis-г hover дээр түр зогсоогоод, гармагц асаана
  if (window.lenis) {
    $mainNavbar.on("pointerenter.lenis", () => window.lenis.stop()).on("pointerleave.lenis", () => window.lenis.start())
  }

  function bindMobile() {
    $(".menu-item-has-children > a")
      .off(".menuNS")
      .on("click.menuNS", function (e) {
        e.preventDefault()
        const $container = $(this).siblings(".sub-menu-container")
        $mainNavbar.addClass("active")
        $(".sub-menu-container").not($container).removeClass("active")
        $container.toggleClass("active")
      })
  }

  function bindDesktop() {
    // mouseenter биш, pointerenter хэрэглэе
    $(".menu-item-has-children > a")
      .off(".menuNS")
      .on("pointerenter.menuNS", function () {
        const $container = $(this).siblings(".sub-menu-container")
        $mainNavbar.addClass("active")
        $(".sub-menu-container").not($container).removeClass("active")
        $container.addClass("active")
      })

    $(".menu-item-has-children")
      .off(".menuNS")
      .on("pointerleave.menuNS", function () {
        $(this).find(".sub-menu-container").removeClass("active")
      })
  }

  function initMenu() {
    // бүх хуучин эвентүүдийг нэртэйгээр салгах
    $(".menu-item-has-children > a").off(".menuNS")
    $(".menu-item-has-children").off(".menuNS")

    if (window.innerWidth < 992) {
      bindMobile()
    } else {
      bindDesktop()
    }
  }

  initMenu()
  $(window).on("resize", debounce(initMenu, 150))

  function debounce(fn, wait) {
    let t
    return function () {
      clearTimeout(t)
      t = setTimeout(fn, wait)
    }
  }
})

jQuery(function ($) {
  const mainNavbar = $("#mainNavbar")
  const $containers = $(".sub-menu-container")

  function closeAll() {
    // ✅ Mobile меню нээлттэй бол хаахгүй
    const mobileMenuEl = document.getElementById("mobileMenu")
    const isMobileMenuOpen = mobileMenuEl && mobileMenuEl.classList.contains("open")
    if (isMobileMenuOpen) return

    // ✅ Дараах нь desktop submenu-уудыг хаах хэсэг
    mainNavbar.removeClass("active")
    $containers.removeClass("active").hide()
  }

  // Скролл болсон даруй хаана (performance тулд throttle)
  let ticking = false
  $(window).on("scroll wheel touchmove", function () {
    if (!ticking) {
      ticking = true
      requestAnimationFrame(function () {
        closeAll()
        ticking = false
      })
    }
  })

  // Гадна талд дарахад хаах (сонголтоор)
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".menu-item-has-children").length) {
      closeAll()
    }
  })

  // ESC дарвал хаах (сонголтоор)
  $(document).on("keydown", function (e) {
    if (e.key === "Escape") closeAll()
  })
})
document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.querySelector(".toggle-btn")
  const mobileMenu = document.getElementById("mobileMenu")
  const closeBtn = document.querySelector(".mobile-menu__close")
  const overlay = document.getElementById("mobileMenuOverlay")

  if (!toggleBtn || !mobileMenu || !overlay) return

  function openMenu() {
    mobileMenu.classList.add("open")
    document.body.classList.add("no-scroll")
    overlay.hidden = false
    requestAnimationFrame(() => overlay.classList.add("show"))
    toggleBtn.setAttribute("aria-expanded", "true")
    mobileMenu.setAttribute("aria-hidden", "false")
  }

  function closeMenu() {
    mobileMenu.classList.remove("open")
    document.body.classList.remove("no-scroll")
    overlay.classList.remove("show")
    toggleBtn.setAttribute("aria-expanded", "false")
    mobileMenu.setAttribute("aria-hidden", "true")
    // overlay-г transition дуусмагц нуух
    setTimeout(() => {
      overlay.hidden = true
    }, 200)
  }

  function toggleMenu() {
    mobileMenu.classList.contains("open") ? closeMenu() : openMenu()
  }

  // Event bindings
  toggleBtn.addEventListener("click", toggleMenu)
  closeBtn && closeBtn.addEventListener("click", closeMenu)
  overlay.addEventListener("click", closeMenu)

  // Esc дарвал хаах
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && mobileMenu.classList.contains("open")) closeMenu()
  })

  // Mobile меню доторхи линк дээр дарвал хаах
  mobileMenu.addEventListener("click", (e) => {
    const a = e.target.closest("a")
    if (a) {
      const href = a.getAttribute("href") || ""

      // href #, #_ гэх мэт бол цэсээ битгий хаа
      if (href === "#" || href === "#_") {
        e.preventDefault() // scrollTop руу үсрэхээс сэргийлнэ
        return
      }

      // Үлдсэн жинхэнэ линк бол хаана
      closeMenu()
    }
  })
})
document.addEventListener("DOMContentLoaded", () => {
  const mobileMenu = document.getElementById("mobileMenu")
  if (!mobileMenu) return

  let openCount = 0
  const lockPage = () => {
    if (openCount > 0) return
    document.documentElement.classList.add("mobile-menu-open")
    document.body.classList.add("mobile-menu-open")
    window.lenis?.stop?.()
  }
  const unlockPage = () => {
    if (openCount === 0) {
      document.documentElement.classList.remove("mobile-menu-open")
      document.body.classList.remove("mobile-menu-open")
      window.lenis?.start?.()
    }
  }

  mobileMenu.querySelectorAll(".menu-item-has-children").forEach((li) => {
    const link = li.querySelector(".nav-link")
    const submenu = li.querySelector(".sub-menu-container")
    if (!link || !submenu) return

    // Эхлэх төлөв
    li.classList.remove("is-open")
    submenu.style.display = "none"

    // ⬇️ pointer даралт/чиргээ ялгах
    let startX = 0,
      startY = 0,
      moved = false,
      pointerId = null

    const onPointerDown = (e) => {
      pointerId = e.pointerId ?? null
      startX = e.clientX
      startY = e.clientY
      moved = false
      link.setPointerCapture?.(pointerId)
    }

    const onPointerMove = (e) => {
      if (pointerId !== null && e.pointerId !== pointerId) return
      const dx = Math.abs(e.clientX - startX)
      const dy = Math.abs(e.clientY - startY)
      if (dx > 8 || dy > 8) moved = true // ← 8px-с их хөдөлбөл scroll гэж үзнэ
    }

    const onPointerUp = (e) => {
      if (pointerId !== null && e.pointerId !== pointerId) return
      link.releasePointerCapture?.(pointerId)
      pointerId = null

      // moved бол toggle ХИЙХГҮЙ (scroll байсан)
      if (moved) return

      // 1) Эхлээд бусад нээлттэй parent-үүдийг хаа (accordion behavior)
      mobileMenu.querySelectorAll(".menu-item-has-children.is-open").forEach((other) => {
        if (other !== li) {
          other.classList.remove("is-open")
          const sm = other.querySelector(".sub-menu-container")
          if (sm) sm.style.display = "none"
        }
      })

      // 2) Одоо зөвхөн энэ LI-г toggle
      const willOpen = !li.classList.contains("is-open")
      li.classList.toggle("is-open", willOpen)
      submenu.style.display = willOpen ? "block" : "none"

      // 3) Нийт нээлттэй тоог бодоод lock/unlock хийх
      openCount = mobileMenu.querySelectorAll(".menu-item-has-children.is-open").length
      if (openCount > 0) {
        lockPage()
      } else {
        unlockPage()
      }

      // 4) Anchor нь hash бол навигацыг саатуулах
      const href = link.getAttribute("href") || ""
      if (href === "#" || href === "#_" || href.startsWith("#")) {
        e.preventDefault()
      }
    }

    // click эвентыг бүр мөсөн ашиглахгүй — учир нь touch→click болж ирээд дахин toggle хийдэг
    link.addEventListener("click", (e) => {
      const href = link.getAttribute("href") || ""
      if (href === "#" || href === "#_" || href.startsWith("#")) e.preventDefault()
    })

    link.addEventListener("pointerdown", onPointerDown, { passive: true })
    link.addEventListener("pointermove", onPointerMove, { passive: true })
    link.addEventListener("pointerup", onPointerUp)

    // submenu доторх гүйлгээг window руу дамжуулахгүй (зарим theme scroll дээр хаадаг)
    ;["wheel", "touchmove"].forEach((ev) => {
      submenu.addEventListener(ev, (e) => e.stopPropagation(), { passive: true })
    })
  })
})



document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".sub-menu").forEach(ul => {
    const items = ul.querySelectorAll(":scope > li");
    if (items.length <= 1) return; // ганц li бол орхино

    const first = items[0];
    const rest = Array.from(items).slice(1);

    // right-group div үүсгэх
    const wrapper = document.createElement("div");
    wrapper.className = "right-group";

    // үлдсэн LI-үүдийг wrapper руу зөөх
    rest.forEach(li => wrapper.appendChild(li));

    // wrapper-ийг UL дотор хамгийн сүүлд оруулна
    ul.appendChild(wrapper);
  });
});