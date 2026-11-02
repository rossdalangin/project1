/**
 * Mobile Navigation & Accessibility Keyboard Focus Trap
 *
 * @package RossPortfolio
 */

(function () {
  function initNav() {
    const navToggle = document.getElementById('primary-nav-toggle');
    const primaryNav = document.getElementById('primary-nav');
    const navClose = document.getElementById('mobile-nav-close');

    if (!navToggle || !primaryNav) {
      return;
    }

    // Create backdrop overlay if not already present
    let navBackdrop = document.querySelector('.nav-backdrop');
    if (!navBackdrop) {
      navBackdrop = document.createElement('div');
      navBackdrop.className = 'nav-backdrop';
      navBackdrop.setAttribute('aria-hidden', 'true');
      document.body.appendChild(navBackdrop);
    }

    function getFocusableElements(container) {
      return container.querySelectorAll(
        'a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
      );
    }

    function openMenu() {
      navToggle.setAttribute('aria-expanded', 'true');
      primaryNav.classList.add('is-active');
      navBackdrop.classList.add('is-active');
      document.body.classList.add('menu-open');
      document.body.style.overflow = 'hidden';

      // Focus close button or first element inside menu
      setTimeout(function () {
        if (navClose) {
          navClose.focus();
        } else {
          const focusables = getFocusableElements(primaryNav);
          if (focusables.length > 0) {
            focusables[0].focus();
          }
        }
      }, 50);
    }

    function closeMenu() {
      if (navToggle.getAttribute('aria-expanded') !== 'true') {
        return;
      }
      navToggle.setAttribute('aria-expanded', 'false');
      primaryNav.classList.remove('is-active');
      navBackdrop.classList.remove('is-active');
      document.body.classList.remove('menu-open');
      document.body.style.overflow = '';
      navToggle.focus();
    }

    navToggle.addEventListener('click', function (e) {
      e.preventDefault();
      const isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
      if (isExpanded) {
        closeMenu();
      } else {
        openMenu();
      }
    });

    if (navClose) {
      navClose.addEventListener('click', function (e) {
        e.preventDefault();
        closeMenu();
      });
    }

    // Close when clicking the backdrop overlay
    navBackdrop.addEventListener('click', function () {
      closeMenu();
    });

    // Close menu when clicking internal anchor links inside the mobile drawer
    const navLinks = primaryNav.querySelectorAll('a');
    navLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        // If it's a mobile viewport, automatically close the drawer after link click
        if (window.innerWidth < 900) {
          closeMenu();
        }
      });
    });

    // Close menu on Escape key press
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' || e.key === 'Esc') {
        if (navToggle.getAttribute('aria-expanded') === 'true') {
          closeMenu();
        }
      }
    });

    // WCAG 2.2 Keyboard Focus Trap inside open mobile menu
    primaryNav.addEventListener('keydown', function (e) {
      if (navToggle.getAttribute('aria-expanded') !== 'true') {
        return;
      }

      if (e.key === 'Tab') {
        const focusables = Array.from(getFocusableElements(primaryNav));
        if (focusables.length === 0) return;

        const firstFocusable = focusables[0];
        const lastFocusable = focusables[focusables.length - 1];

        if (e.shiftKey) {
          if (document.activeElement === firstFocusable) {
            e.preventDefault();
            lastFocusable.focus();
          }
        } else {
          if (document.activeElement === lastFocusable) {
            e.preventDefault();
            firstFocusable.focus();
          }
        }
      }
    });

    // Interactive FAQ Accordion
    const faqTriggers = document.querySelectorAll('.faq-trigger');
    faqTriggers.forEach(function (trigger) {
      trigger.addEventListener('click', function () {
        const expanded = trigger.getAttribute('aria-expanded') === 'true';
        const panelId = trigger.getAttribute('aria-controls');
        const panel = document.getElementById(panelId);

        faqTriggers.forEach(function (otherTrigger) {
          if (otherTrigger !== trigger) {
            otherTrigger.setAttribute('aria-expanded', 'false');
            const otherPanelId = otherTrigger.getAttribute('aria-controls');
            const otherPanel = document.getElementById(otherPanelId);
            if (otherPanel) {
              otherPanel.hidden = true;
            }
          }
        });

        trigger.setAttribute('aria-expanded', !expanded);
        if (panel) {
          panel.hidden = expanded;
        }
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNav);
  } else {
    initNav();
  }
})();
