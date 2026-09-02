/**
 * Resource Hub page
 * - sticky anchor nav that highlights the section you are in
 * - video lightbox for the Videos section
 *
 * NOTE: uses addEventListener, never `window.onscroll =`, because
 * js/scripts.js assigns window.onscroll for the sticky header.
 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {

    /* ------------------------------------------------------------------
       STICKY ANCHOR NAV + SCROLLSPY
       ------------------------------------------------------------------ */
    var navWrap = document.querySelector('.c-hub-nav-wrap');

    if (navWrap) {
      var links  = [].slice.call(navWrap.querySelectorAll('[data-hub-target]'));
      var header = document.getElementById('c-page-header');
      var items  = [];
      var lockUntil = 0;
      var ticking = false;

      links.forEach(function (link) {
        var el = document.getElementById(link.getAttribute('data-hub-target'));
        if (el) {
          items.push({ link: link, el: el });
        } else {
          link.classList.add('is-missing-target');
        }
      });

      // the fixed site header is 80px / 117px depending on breakpoint,
      // so measure it rather than hard-coding the offset
      function headerHeight() {
        return header ? header.offsetHeight : 0;
      }

      function syncOffsets() {
        var h = headerHeight();
        document.documentElement.style.setProperty('--hub-header-height', h + 'px');
        document.documentElement.style.setProperty('--hub-nav-height', navWrap.offsetHeight + 'px');
      }

      // on narrow screens the nav is a horizontal scroll strip - slide the
      // highlighted item into the middle of it (never scrolls the page)
      var navList = navWrap.querySelector('.c-hub-nav__list');

      function keepInView(link) {
        if (!navList || navList.scrollWidth <= navList.clientWidth) {
          return;
        }

        var target = link.parentNode || link;
        var left = target.offsetLeft - (navList.clientWidth - target.offsetWidth) / 2;

        if (navList.scrollTo) {
          navList.scrollTo({ left: Math.max(left, 0), behavior: 'smooth' });
        } else {
          navList.scrollLeft = Math.max(left, 0);
        }
      }

      // sections whose tops line up are shown side by side (News & PR sits
      // next to Webinars on desktop) - those highlight together
      var TIE = 12;

      function groupFor(item) {
        var top = item.el.getBoundingClientRect().top;

        return items.filter(function (other) {
          return Math.abs(other.el.getBoundingClientRect().top - top) <= TIE;
        }).map(function (other) {
          return other.link;
        });
      }

      function setActive(activeLinks) {
        var changed = false;

        links.forEach(function (l) {
          var on = activeLinks.indexOf(l) > -1;
          if (on !== l.classList.contains('is-active')) {
            changed = true;
          }
          l.classList.toggle('is-active', on);
          if (on) {
            l.setAttribute('aria-current', 'true');
          } else {
            l.removeAttribute('aria-current');
          }
        });

        if (changed && activeLinks.length) {
          keepInView(activeLinks[0]);
        }
      }

      function spy() {
        if (!items.length || Date.now() < lockUntil) {
          return;
        }

        // the line just under the header + nav; the section crossing it wins
        var line = headerHeight() + navWrap.offsetHeight + 24;
        var active = items[0];
        var lastTop = null;

        for (var i = 0; i < items.length; i++) {
          var top = items[i].el.getBoundingClientRect().top;
          if (top - line > 1) {
            break;
          }
          // side-by-side sections start at the same offset - hold the first
          // of the pair here, groupFor() lights up the rest of it below
          if (lastTop === null || Math.abs(top - lastTop) > TIE) {
            active = items[i];
            lastTop = top;
          }
        }

        setActive(groupFor(active));
      }

      function onScroll() {
        if (ticking) {
          return;
        }
        ticking = true;
        window.requestAnimationFrame(function () {
          spy();
          ticking = false;
        });
      }

      // anchor clicks: scroll below the header, highlight straight away and
      // hold that highlight while the smooth scroll runs
      items.forEach(function (item) {
        item.link.addEventListener('click', function (e) {
          e.preventDefault();
          setActive(groupFor(item));
          lockUntil = Date.now() + 700;

          var top = item.el.getBoundingClientRect().top + window.pageYOffset
                    - headerHeight() - navWrap.offsetHeight - 16;

          window.scrollTo({ top: Math.max(top, 0), behavior: 'smooth' });

          if (history.replaceState) {
            history.replaceState(null, '', '#' + item.el.id);
          }
        });
      });

      window.addEventListener('scroll', onScroll, { passive: true });
      window.addEventListener('resize', function () {
        syncOffsets();
        onScroll();
      });

      syncOffsets();
      spy();
    }


    /* ------------------------------------------------------------------
       VIDEO LIGHTBOX
       ------------------------------------------------------------------ */
    var modal = document.getElementById('c-hub-modal');

    if (modal) {
      var iframe     = modal.querySelector('.c-hub-modal__iframe');
      var modalTitle = modal.querySelector('.c-hub-modal__title');
      var closeBtn   = modal.querySelector('.c-hub-modal__close');
      var lastFocus  = null;

      function openVideo(url, title, trigger) {
        lastFocus = trigger || null;

        modalTitle.textContent = title || '';
        iframe.src = url + (url.indexOf('?') > -1 ? '&' : '?') + 'autoplay=1';

        modal.hidden = false;
        modal.setAttribute('aria-hidden', 'false');
        // let the browser paint before transitioning
        window.requestAnimationFrame(function () {
          modal.classList.add('is-active');
        });
        document.body.classList.add('has-hub-modal-open');

        if (closeBtn) {
          closeBtn.focus();
        }
      }

      function closeVideo() {
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('has-hub-modal-open');
        iframe.src = ''; // stops playback
        modalTitle.textContent = '';

        window.setTimeout(function () {
          modal.hidden = true;
        }, 300);

        if (lastFocus) {
          lastFocus.focus();
          lastFocus = null;
        }
      }

      document.addEventListener('click', function (e) {
        var trigger = e.target.closest ? e.target.closest('[data-video]') : null;
        if (trigger) {
          e.preventDefault();
          openVideo(trigger.getAttribute('data-video'), trigger.getAttribute('data-video-title'), trigger);
          return;
        }

        if (e.target.closest && e.target.closest('[data-hub-modal-close]')) {
          closeVideo();
        }
      });

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('is-active')) {
          closeVideo();
        }
      });
    }


    /* ------------------------------------------------------------------
       VIDEO COVERFLOW - iTunes-style carousel for the Videos section.
       The markup is a plain scrolling row until this runs, so it still
       works with JS off.
       ------------------------------------------------------------------ */
    [].slice.call(document.querySelectorAll('[data-coverflow]')).forEach(function (flow) {

      var stage   = flow.querySelector('[data-coverflow-stage]');
      var caption = flow.querySelector('[data-coverflow-caption]');
      var prevBtn = flow.querySelector('[data-coverflow-prev]');
      var nextBtn = flow.querySelector('[data-coverflow-next]');
      var covers  = stage ? [].slice.call(stage.querySelectorAll('.c-hub-video')) : [];

      if (!stage || !covers.length) {
        return;
      }

      var total = covers.length;
      var loop = total > 2;   // wrap around once there are enough covers
      var index = 0;          // settled position
      var position = 0;       // live position, fractional while dragging
      var itemWidth = 0;
      var step = 0;
      var laidOut = false;

      flow.classList.add('is-coverflow');

      function layout() {
        var stageWidth = stage.clientWidth || flow.clientWidth;
        if (!stageWidth) {
          return;
        }

        // centre cover is roughly half the stage, within sane bounds
        itemWidth = Math.max(220, Math.min(stageWidth * 0.46, 460));
        step = itemWidth * 0.42;
        stage.style.height = Math.round(itemWidth * 0.5625) + 'px';

        covers.forEach(function (cover) {
          cover.style.width = itemWidth + 'px';
          cover.style.marginLeft = (-itemWidth / 2) + 'px';
        });

        laidOut = true;
        render(position);
      }

      // shortest signed distance from the centre, so covers travel off one
      // edge and reappear at the other
      function relativeOffset(i, pos) {
        var offset = i - pos;

        if (loop) {
          offset = offset % total;
          if (offset > total / 2) {
            offset -= total;
          } else if (offset < -total / 2) {
            offset += total;
          }
        }

        return offset;
      }

      // continuous for fractional offsets, so the covers track a drag
      function render(pos) {
        if (!laidOut) {
          return;
        }

        position = pos;

        covers.forEach(function (cover, i) {
          var offset = relativeOffset(i, pos);
          var dist = Math.abs(offset);
          var sign = offset < 0 ? -1 : 1;
          var trigger = cover.querySelector('.c-hub-video__trigger');

          var near = Math.min(dist, 1);
          var x = sign * (step * near + Math.max(dist - 1, 0) * step * 0.55);
          var rotate = -sign * 48 * near;
          var scale = Math.max(1 - Math.min(dist, 3) * 0.07, 0.7);
          var depth = -Math.min(dist, 3) * 70;
          var opacity = dist <= 3 ? 1 : Math.max(0, 1 - (dist - 3));

          // a cover that just wrapped to the far side must not fly across
          var previous = cover.getAttribute('data-cf-offset');
          if (previous !== null && Math.abs(offset - parseFloat(previous)) > 1.5) {
            cover.style.transition = 'none';
            cover.style.transform = 'translateX(' + x + 'px) translateZ(' + depth + 'px) rotateY(' + rotate + 'deg) scale(' + scale + ')';
            void cover.offsetWidth; // flush, then let CSS drive again
            cover.style.transition = '';
          } else {
            cover.style.transform = 'translateX(' + x + 'px) translateZ(' + depth + 'px) rotateY(' + rotate + 'deg) scale(' + scale + ')';
          }

          cover.setAttribute('data-cf-offset', offset);
          cover.style.zIndex = String(Math.round(100 - dist * 10));
          cover.style.opacity = String(opacity);
          cover.style.pointerEvents = opacity < 0.2 ? 'none' : 'auto';
          cover.classList.toggle('is-active', dist < 0.5);

          if (trigger) {
            trigger.tabIndex = dist < 0.5 ? 0 : -1;
          }
        });

        if (caption) {
          var settled = ((Math.round(pos) % total) + total) % total;
          var title = covers[settled].querySelector('.c-hub-video__title');
          caption.textContent = title ? title.textContent.trim() : '';
        }
      }

      function goTo(i) {
        if (loop) {
          index = ((i % total) + total) % total;
        } else {
          index = Math.max(0, Math.min(i, total - 1));
        }
        render(index);
      }

      // clicking a side cover brings it to the front instead of playing it
      covers.forEach(function (cover, i) {
        cover.addEventListener('click', function (e) {
          if (dragged) {
            e.preventDefault();
            e.stopPropagation();
            return;
          }
          if (Math.abs(relativeOffset(i, index)) > 0.5) {
            e.preventDefault();
            e.stopPropagation();
            goTo(index + relativeOffset(i, index));
          }
        });
      });

      if (prevBtn) {
        prevBtn.addEventListener('click', function () {
          goTo(index - 1);
        });
      }

      if (nextBtn) {
        nextBtn.addEventListener('click', function () {
          goTo(index + 1);
        });
      }

      flow.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') {
          e.preventDefault();
          goTo(index - 1);
        } else if (e.key === 'ArrowRight') {
          e.preventDefault();
          goTo(index + 1);
        }
      });

      /* grab and drag - mouse, pen and touch through pointer events */
      var dragging = false;
      var dragged = false;
      var startX = 0;
      var startPos = 0;

      function dragStart(x) {
        dragging = true;
        dragged = false;
        startX = x;
        startPos = position;
        flow.classList.add('is-dragging');
      }

      function dragMove(x) {
        if (!dragging || !step) {
          return;
        }

        var delta = x - startX;
        if (Math.abs(delta) > 5) {
          dragged = true;
        }

        var pos = startPos - delta / step;
        if (!loop) {
          pos = Math.max(-0.6, Math.min(pos, total - 0.4));
        }

        render(pos);
      }

      function dragEnd() {
        if (!dragging) {
          return;
        }
        dragging = false;
        flow.classList.remove('is-dragging');
        goTo(Math.round(position));

        // let the click that ends the drag through, then re-arm
        window.setTimeout(function () {
          dragged = false;
        }, 0);
      }

      if (window.PointerEvent) {
        stage.addEventListener('pointerdown', function (e) {
          if (e.button && e.button !== 0) {
            return;
          }
          dragStart(e.clientX);
        });

        stage.addEventListener('pointermove', function (e) {
          if (dragging) {
            e.preventDefault();
            dragMove(e.clientX);
          }
        });

        stage.addEventListener('pointerup', dragEnd);
        stage.addEventListener('pointercancel', dragEnd);
        stage.addEventListener('pointerleave', dragEnd);
      } else {
        stage.addEventListener('touchstart', function (e) {
          dragStart(e.touches[0].clientX);
        }, { passive: true });

        stage.addEventListener('touchmove', function (e) {
          dragMove(e.touches[0].clientX);
        }, { passive: true });

        stage.addEventListener('touchend', dragEnd);
      }

      // no dragging the thumbnails out of the page
      stage.addEventListener('dragstart', function (e) {
        e.preventDefault();
      });

      window.addEventListener('resize', layout);

      layout();

      // images can land after first paint and change the stage metrics
      window.addEventListener('load', layout);
    });

  });
})();
