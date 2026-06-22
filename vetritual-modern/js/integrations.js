(function () {
  'use strict';

  var currentScript = document.currentScript;

  if (!currentScript) {
    var scripts = document.getElementsByTagName('script');
    currentScript = scripts[scripts.length - 1];
  }

  if (!currentScript) {
    return;
  }

  var config = {
    mode: currentScript.dataset.mode || 'disabled',
    cookieKey: currentScript.dataset.cookieKey || 'vr_cookie_consent',
    ymId: currentScript.dataset.ymId || '',
    ymWebvisor: currentScript.dataset.ymWebvisor === '1',
    ymEcommerce: currentScript.dataset.ymEcommerce === '1',
    ga4Id: currentScript.dataset.ga4Id || '',
    gtmId: currentScript.dataset.gtmId || '',
    vkId: currentScript.dataset.vkId || '',
    metaId: currentScript.dataset.metaId || '',
    topmailruId: currentScript.dataset.topmailruId || '',
    tiktokId: currentScript.dataset.tiktokId || ''
  };

  var loaded = false;

  function hasConsent() {
    try {
      var value = window.localStorage.getItem(config.cookieKey);
      return ['1', 'true', 'yes', 'accepted'].indexOf(String(value).toLowerCase()) !== -1;
    } catch (error) {
      return false;
    }
  }

  function markConsent() {
    try {
      window.localStorage.setItem(config.cookieKey, 'accepted');
    } catch (error) {
      // localStorage can be blocked in private modes; analytics can still load after direct consent.
    }
  }

  function appendScript(src, id, beforeFirstScript) {
    if (!src || (id && document.getElementById(id))) {
      return null;
    }

    var script = document.createElement('script');
    script.async = true;
    script.src = src;

    if (id) {
      script.id = id;
    }

    if (beforeFirstScript) {
      var firstScript = document.getElementsByTagName('script')[0];
      firstScript.parentNode.insertBefore(script, firstScript);
    } else {
      document.head.appendChild(script);
    }

    return script;
  }

  function loadYandexMetrika() {
    if (!config.ymId || window['yaCounter' + config.ymId]) {
      return;
    }

    window.ym = window.ym || function () {
      (window.ym.a = window.ym.a || []).push(arguments);
    };
    window.ym.l = 1 * new Date();

    var options = {
      clickmap: true,
      trackLinks: true,
      accurateTrackBounce: true,
      webvisor: config.ymWebvisor
    };

    if (config.ymEcommerce) {
      window.dataLayer = window.dataLayer || [];
      options.ecommerce = 'dataLayer';
    }

    window.ym(config.ymId, 'init', options);
    appendScript('https://mc.yandex.ru/metrika/tag.js', 'vr-yandex-metrika', true);
  }

  function loadGa4() {
    if (!config.ga4Id || window.__vrGa4Loaded) {
      return;
    }

    window.__vrGa4Loaded = true;
    window.dataLayer = window.dataLayer || [];
    window.gtag = window.gtag || function () {
      window.dataLayer.push(arguments);
    };

    window.gtag('js', new Date());
    window.gtag('config', config.ga4Id);
    appendScript('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(config.ga4Id), 'vr-ga4');
  }

  function loadGtm() {
    if (!config.gtmId || window.__vrGtmLoaded) {
      return;
    }

    window.__vrGtmLoaded = true;
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
      'gtm.start': new Date().getTime(),
      event: 'gtm.js'
    });
    appendScript('https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(config.gtmId), 'vr-gtm', true);
  }

  function loadVkPixel() {
    if (!config.vkId || window.__vrVkPixelLoaded) {
      return;
    }

    window.__vrVkPixelLoaded = true;
    window.vkAsyncInit = function () {
      if (!window.VK || !window.VK.Retargeting) {
        return;
      }

      window.VK.Retargeting.Init(config.vkId);
      window.VK.Retargeting.Hit();
    };
    appendScript('https://vk.com/js/api/openapi.js?169', 'vr-vk-pixel', true);
  }

  function loadMetaPixel() {
    if (!config.metaId || window.__vrMetaPixelLoaded) {
      return;
    }

    window.__vrMetaPixelLoaded = true;
    window.fbq = window.fbq || function () {
      window.fbq.callMethod ? window.fbq.callMethod.apply(window.fbq, arguments) : window.fbq.queue.push(arguments);
    };

    if (!window._fbq) {
      window._fbq = window.fbq;
    }

    window.fbq.push = window.fbq;
    window.fbq.loaded = true;
    window.fbq.version = '2.0';
    window.fbq.queue = window.fbq.queue || [];
    window.fbq('init', config.metaId);
    window.fbq('track', 'PageView');
    appendScript('https://connect.facebook.net/en_US/fbevents.js', 'vr-meta-pixel', true);
  }

  function loadTopMailRu() {
    if (!config.topmailruId || window.__vrTopMailRuLoaded) {
      return;
    }

    window.__vrTopMailRuLoaded = true;
    window._tmr = window._tmr || [];
    window._tmr.push({
      id: config.topmailruId,
      type: 'pageView',
      start: new Date().getTime()
    });
    appendScript('https://top-fwz1.mail.ru/js/code.js', 'vr-topmailru', true);
  }

  function loadTikTokPixel() {
    if (!config.tiktokId || window.__vrTikTokLoaded) {
      return;
    }

    window.__vrTikTokLoaded = true;
    window.TiktokAnalyticsObject = 'ttq';
    var ttq = window.ttq = window.ttq || [];
    ttq.methods = ['page', 'track', 'identify', 'instances', 'debug', 'on', 'off', 'once', 'ready', 'alias', 'group', 'enableCookie', 'disableCookie'];
    ttq.setAndDefer = function (target, method) {
      target[method] = function () {
        target.push([method].concat(Array.prototype.slice.call(arguments, 0)));
      };
    };

    for (var i = 0; i < ttq.methods.length; i += 1) {
      ttq.setAndDefer(ttq, ttq.methods[i]);
    }

    ttq.instance = function (name) {
      var instance = ttq._i[name] || [];
      for (var i = 0; i < ttq.methods.length; i += 1) {
        ttq.setAndDefer(instance, ttq.methods[i]);
      }
      return instance;
    };
    ttq.load = function (id) {
      ttq._i = ttq._i || {};
      ttq._i[id] = [];
      ttq._i[id]._u = 'https://analytics.tiktok.com/i18n/pixel/events.js';
      ttq._t = ttq._t || {};
      ttq._t[id] = +new Date();
      ttq._o = ttq._o || {};
      ttq._o[id] = {};
      appendScript(ttq._i[id]._u + '?sdkid=' + encodeURIComponent(id) + '&lib=ttq', 'vr-tiktok-pixel');
    };

    ttq.load(config.tiktokId);
    ttq.page();
  }

  function loadAll() {
    if (loaded || config.mode === 'disabled') {
      return;
    }

    loaded = true;
    loadGtm();
    loadGa4();
    loadYandexMetrika();
    loadVkPixel();
    loadMetaPixel();
    loadTopMailRu();
    loadTikTokPixel();
  }

  window.vrLoadAnalytics = loadAll;
  window.vrAcceptAnalytics = function () {
    markConsent();
    loadAll();
  };

  document.addEventListener('vr:cookie-accepted', window.vrAcceptAnalytics);

  if (config.mode === 'always' || (config.mode === 'after_cookie_accept' && hasConsent())) {
    loadAll();
  }
}());
