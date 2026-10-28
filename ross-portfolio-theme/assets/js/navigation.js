/**
 * Mobile Navigation & Accessibility Keyboard Focus Trap
 *
 * @package RossPortfolio
 */

document.addEventListener('DOMContentLoaded', function () {
  const navToggle = document.getElementById('primary-nav-toggle');
  const primaryNav = document.getElementById('primary-nav');

  if (!navToggle || !primaryNav) {
    return;
  }

  function getFocusableElements(container) {
    return container.querySelectorAll(
      'a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
    );
  }

  function openMenu() {
    navToggle.setAttribute('aria-expanded', 'true');
    primaryNav.classList.add('is-active');
    document.body.style.overflow = 'hidden';

    const focusables = getFocusableElements(primaryNav);
    if (focusables.length > 0) {
      focusables[0].focus();
    }
  }

  function closeMenu() {
    navToggle.setAttribute('aria-expanded', 'false');
    primaryNav.classList.remove('is-active');
    document.body.style.overflow = '';
    navToggle.focus();
  }

  navToggle.addEventListener('click', function () {
    const isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
    if (isExpanded) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' || e.key === 'Esc') {
      if (navToggle.getAttribute('aria-expanded') === 'true') {
        closeMenu();
      }
    }
  });

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
          navToggle.focus();
        } else if (document.activeElement === navToggle) {
          e.preventDefault();
          lastFocusable.focus();
        }
      } else {
        if (document.activeElement === navToggle) {
          e.preventDefault();
          firstFocusable.focus();
        } else if (document.activeElement === lastFocusable) {
          e.preventDefault();
          navToggle.focus();
        }
      }
    }
  });

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
});
