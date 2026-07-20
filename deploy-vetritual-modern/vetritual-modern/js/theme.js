(function () {
  var hero = document.querySelector(".vr-page-hero");
  var heroTitle = hero ? hero.querySelector("h1") : null;
  var pageTitle = heroTitle ? heroTitle.textContent.toLowerCase() : "";
  var contentTitle = document.querySelector(".vr-text-page h1, .vr-text-page h2");
  var combinedTitle = pageTitle + " " + (contentTitle ? contentTitle.textContent.toLowerCase() : "");

  if (hero && combinedTitle) {
    var serviceClass = "";

    if (combinedTitle.indexOf("усыпление кош") !== -1) {
      serviceClass = "vr-page-hero--cats";
    } else if (combinedTitle.indexOf("усыпление собак") !== -1) {
      serviceClass = "vr-page-hero--dogs";
    } else if (combinedTitle.indexOf("усыпление") !== -1) {
      serviceClass = "vr-page-hero--euthanasia";
    } else if (combinedTitle.indexOf("индивидуальная кремация") !== -1) {
      serviceClass = "vr-page-hero--individual-cremation";
    } else if (combinedTitle.indexOf("общая кремация") !== -1) {
      serviceClass = "vr-page-hero--common-cremation";
    } else if (combinedTitle.indexOf("кремация") !== -1) {
      serviceClass = "vr-page-hero--cremation";
    } else if (combinedTitle.indexOf("вывоз") !== -1 || combinedTitle.indexOf("транспортиров") !== -1) {
      serviceClass = "vr-page-hero--transport";
    } else if (combinedTitle.indexOf("услуги") !== -1) {
      serviceClass = "vr-page-hero--services";
    }

    if (serviceClass) {
      hero.classList.remove(
        "vr-page-hero--services",
        "vr-page-hero--euthanasia",
        "vr-page-hero--cats",
        "vr-page-hero--dogs",
        "vr-page-hero--cremation",
        "vr-page-hero--common-cremation",
        "vr-page-hero--individual-cremation",
        "vr-page-hero--transport"
      );
      hero.classList.add(serviceClass);
    }
  }

  var reduceMotionQuery = window.matchMedia("(prefers-reduced-motion: reduce)");
  var shouldReduceMotion = function () {
    return reduceMotionQuery.matches;
  };

  if (!shouldReduceMotion()) {
    document.body.classList.add("vr-motion-ready");
  }

  var getHashTarget = function (hash) {
    if (!hash || hash.length < 2) {
      return null;
    }

    try {
      return document.getElementById(decodeURIComponent(hash.slice(1)));
    } catch (error) {
      return document.getElementById(hash.slice(1));
    }
  };

  document.addEventListener("click", function (event) {
    var link = event.target.closest ? event.target.closest("a[href^='#']") : null;

    if (!link || link.hash.length < 2 || link.pathname !== window.location.pathname) {
      return;
    }

    var target = getHashTarget(link.hash);
    if (!target) {
      return;
    }

    event.preventDefault();

    var header = document.querySelector(".vr-header");
    var headerHeight = header ? header.getBoundingClientRect().height : 0;
    var targetTop = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 10;
    var menu = document.querySelector("[data-vr-menu]");
    var toggle = document.querySelector("[data-vr-menu-toggle]");

    if (menu && toggle) {
      menu.classList.remove("is-open");
      toggle.setAttribute("aria-expanded", "false");
    }

    window.history.pushState(null, "", link.hash);
    window.scrollTo({
      top: Math.max(0, targetTop),
      behavior: shouldReduceMotion() ? "auto" : "smooth"
    });

    window.setTimeout(function () {
      target.setAttribute("tabindex", "-1");
      target.focus({ preventScroll: true });
    }, shouldReduceMotion() ? 0 : 520);
  });

  var revealItems = document.querySelectorAll([
    ".vr-section__head",
    ".vr-about__copy",
    ".vr-promise li",
    ".vr-service-card",
    ".vr-feature-card",
    ".vr-option-card",
    ".vr-note-list",
    ".vr-included article",
    ".vr-price-card",
    ".vr-process li",
    ".vr-reviews article",
    ".vr-contact__panel",
    ".vr-text-page"
  ].join(", "));

  if (revealItems.length && !shouldReduceMotion()) {
    Array.prototype.forEach.call(revealItems, function (item, index) {
      item.classList.add("vr-reveal");
      item.style.setProperty("--vr-reveal-delay", Math.min(index % 4, 3) * 70 + "ms");
    });

    if ("IntersectionObserver" in window) {
      var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) {
            return;
          }

          entry.target.classList.add("is-visible");
          revealObserver.unobserve(entry.target);
        });
      }, {
        rootMargin: "0px 0px -8% 0px",
        threshold: 0.12
      });

      Array.prototype.forEach.call(revealItems, function (item) {
        revealObserver.observe(item);
      });
    } else {
      Array.prototype.forEach.call(revealItems, function (item) {
        item.classList.add("is-visible");
      });
    }
  }

  var servicesSlider = document.querySelector("[data-vr-services-slider]");
  var servicesTrack = servicesSlider ? servicesSlider.querySelector("[data-vr-services-track]") : null;
  var servicesPrev = servicesSlider ? servicesSlider.querySelector("[data-vr-services-prev]") : null;
  var servicesNext = servicesSlider ? servicesSlider.querySelector("[data-vr-services-next]") : null;

  if (servicesTrack && servicesPrev && servicesNext) {
    Array.prototype.forEach.call(servicesTrack.querySelectorAll("img"), function (image) {
      image.setAttribute("draggable", "false");
    });

    var serviceDrag = {
      isDown: false,
      hasMoved: false,
      startX: 0,
      scrollLeft: 0
    };

    var getServiceStep = function () {
      var firstCard = servicesTrack.querySelector(".vr-service-card");
      if (!firstCard) {
        return servicesTrack.clientWidth;
      }

      var styles = window.getComputedStyle(servicesTrack);
      var gap = parseFloat(styles.columnGap || styles.gap || "0") || 0;
      return firstCard.getBoundingClientRect().width + gap;
    };

    var updateServiceControls = function () {
      var maxScroll = servicesTrack.scrollWidth - servicesTrack.clientWidth - 1;
      servicesPrev.disabled = servicesTrack.scrollLeft <= 1;
      servicesNext.disabled = servicesTrack.scrollLeft >= maxScroll;
    };

    servicesPrev.addEventListener("click", function () {
      servicesTrack.scrollBy({ left: -getServiceStep(), behavior: "smooth" });
    });

    servicesNext.addEventListener("click", function () {
      servicesTrack.scrollBy({ left: getServiceStep(), behavior: "smooth" });
    });

    servicesTrack.addEventListener("scroll", updateServiceControls, { passive: true });
    window.addEventListener("resize", updateServiceControls);

    servicesTrack.addEventListener("pointerdown", function (event) {
      if (event.button !== undefined && event.button !== 0) {
        return;
      }

      serviceDrag.isDown = true;
      serviceDrag.hasMoved = false;
      serviceDrag.startX = event.clientX;
      serviceDrag.scrollLeft = servicesTrack.scrollLeft;
      servicesTrack.classList.add("is-dragging");
      event.preventDefault();

      if (servicesTrack.setPointerCapture) {
        servicesTrack.setPointerCapture(event.pointerId);
      }
    });

    var moveServiceDrag = function (event) {
      if (!serviceDrag.isDown) {
        return;
      }

      var walk = event.clientX - serviceDrag.startX;
      if (Math.abs(walk) > 5) {
        serviceDrag.hasMoved = true;
      }

      servicesTrack.scrollLeft = serviceDrag.scrollLeft - walk;
      event.preventDefault();
    };

    var stopServiceDrag = function (event) {
      if (!serviceDrag.isDown) {
        return;
      }

      serviceDrag.isDown = false;
      servicesTrack.classList.remove("is-dragging");

      if (event && servicesTrack.hasPointerCapture && servicesTrack.hasPointerCapture(event.pointerId)) {
        servicesTrack.releasePointerCapture(event.pointerId);
      }

      window.setTimeout(function () {
        serviceDrag.hasMoved = false;
      }, 0);
    };

    window.addEventListener("pointermove", moveServiceDrag, { passive: false });
    window.addEventListener("pointerup", stopServiceDrag);
    servicesTrack.addEventListener("pointercancel", stopServiceDrag);
    servicesTrack.addEventListener("mouseleave", stopServiceDrag);

    servicesTrack.addEventListener("click", function (event) {
      if (serviceDrag.hasMoved) {
        event.preventDefault();
        event.stopPropagation();
      }
    }, true);

    updateServiceControls();
  }

  var cookieBanner = document.querySelector("[data-vr-cookie-banner]");
  var cookieAccept = cookieBanner ? cookieBanner.querySelector("[data-vr-cookie-accept]") : null;
  var cookieKey = window.vrCookieConsentKey || "vr_cookie_consent";

  var hasCookieConsent = function () {
    var cookieAccepted = document.cookie.indexOf(cookieKey + "=accepted") !== -1;

    try {
      return window.localStorage.getItem(cookieKey) === "accepted" || cookieAccepted;
    } catch (error) {
      return cookieAccepted;
    }
  };

  var saveCookieConsent = function () {
    try {
      window.localStorage.setItem(cookieKey, "accepted");
    } catch (error) {
      // localStorage can be unavailable in strict privacy modes.
    }

    document.cookie = cookieKey + "=accepted; max-age=31536000; path=/; SameSite=Lax";

    if (typeof window.vrAcceptAnalytics === "function") {
      window.vrAcceptAnalytics();
    }
  };

  if (cookieBanner && cookieAccept) {
    if (!hasCookieConsent()) {
      cookieBanner.hidden = false;
    }

    cookieAccept.addEventListener("click", function () {
      saveCookieConsent();
      cookieBanner.hidden = true;
    });
  }

  var toggle = document.querySelector("[data-vr-menu-toggle]");
  var menu = document.querySelector("[data-vr-menu]");

  if (!toggle || !menu) {
    return;
  }

  toggle.addEventListener("click", function () {
    var isOpen = menu.classList.toggle("is-open");
    toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
  });

  menu.addEventListener("click", function (event) {
    if (event.target.tagName === "A") {
      menu.classList.remove("is-open");
      toggle.setAttribute("aria-expanded", "false");
    }
  });
})();
