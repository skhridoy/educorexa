
// (function($) {
//   'use strict';
//   $(function() {
//     var body = $('body');
//     var mainWrapper = $('.main-wrapper');
//     var footer = $('footer');
//     var sidebar = $('.sidebar');
//     var navbar = $('.navbar').not('.top-navbar');
    

//     // Enable feather-icons with SVG markup
//     feather.replace();


//     // initialize clipboard plugin
//     if ($('.btn-clipboard').length) {
//       // Enabling tooltip to all clipboard buttons
//       $('.btn-clipboard').attr('data-bs-toggle', 'tooltip').attr('title', 'Copy to clipboard');

//       var clipboard = new ClipboardJS('.btn-clipboard');

//       clipboard.on('success', function(e) {
//         console.log(e);
//         e.trigger.innerHTML = 'copied';
//         setTimeout(function() {
//           e.trigger.innerHTML = 'copy';
//           e.clearSelection();
//         },700)
//       });
//     }


//     // initializing bootstrap tooltip
//     var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
//     var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
//       return new bootstrap.Tooltip(tooltipTriggerEl)
//     })


//     // initializing bootstrap popover
//     var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
//     var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
//       return new bootstrap.Popover(popoverTriggerEl)
//     })


//     // Applying perfect-scrollbar 
//     if ($('.sidebar .sidebar-body').length) {
//       const sidebarBodyScroll = new PerfectScrollbar('.sidebar-body');
//     }
//     // commented beacuse of hang (scroll from  dropdown.html with small height)
//     // if ($('.content-nav-wrapper').length) {
//     //   const contentNavWrapper = new PerfectScrollbar('.content-nav-wrapper');
//     // }


//     // Close other submenu in sidebar on opening any
//     sidebar.on('show.bs.collapse', '.collapse', function() {
//       sidebar.find('.collapse.show').collapse('hide');
//     });


//     // Sidebar toggle to sidebar-folded
//     $('.sidebar-toggler').on('click', function(e) {
//       e.preventDefault();
//       $('.sidebar-header .sidebar-toggler').toggleClass('active not-active');
//       if (window.matchMedia('(min-width: 992px)').matches) {
//         e.preventDefault();
//         body.toggleClass('sidebar-folded');
//       } else if (window.matchMedia('(max-width: 991px)').matches) {
//         e.preventDefault();
//         body.toggleClass('sidebar-open');
//       }
//     });


//     // commmented because of apex chart width issue in desktop (in lg not in xl)
//     // // sidebar-folded on large devices
//     // function iconSidebar(e) {
//     //   if (e.matches) {
//     //     body.addClass('sidebar-folded');
//     //   } else {
//     //     body.removeClass('sidebar-folded');
//     //   }
//     // }
//     // var desktopMedium = window.matchMedia('(min-width:992px) and (max-width: 1199px)');
//     // desktopMedium.addListener(iconSidebar);
//     // iconSidebar(desktopMedium);


//     // Settings sidebar toggle
//     $('.settings-sidebar-toggler').on('click', function(e) {
//       $('body').toggleClass('settings-open');
//     });


//     // Sidebar theme settings
//     $("input:radio[name=sidebarThemeSettings]").click(function() {
//       $('body').removeClass('sidebar-light sidebar-dark');
//       $('body').addClass($(this).val());
//      })



//     //Add active class to nav-link based on url dynamically
//     function addActiveClass(element) {
//         if (current === "") {
//           //for root url
//           if (element.attr('href').indexOf("index.html")) {
//             element.parents('.nav-item').last().addClass('active');
//             if (element.parents('.sub-menu').length) {
//               element.closest('.collapse').addClass('show');
//               element.addClass('active');
//             }
//           }
//         } else {
//           //for other url
//           if (element.attr('href').indexOf(current)) {
//             element.parents('.nav-item').last().addClass('active');
//             if (element.parents('.sub-menu').length) {
//               element.closest('.collapse').addClass('show');
//               element.addClass('active');
//             }
//             if (element.parents('.submenu-item').length) {
//               element.addClass('active');
//             }
//           }
//         }
//     }

//       var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
//       $('.nav li a', sidebar).each(function() {
//         var $this = $(this);
//         addActiveClass($this);
//       });

//     $('.horizontal-menu .nav li a').each(function() {
//       var $this = $(this);
//       addActiveClass($this);
//     })


//     //  open sidebar-folded when hover
//     $(".sidebar .sidebar-body").hover(
//     function () {
//       if (body.hasClass('sidebar-folded')){
//         body.addClass("open-sidebar-folded");
//       }
//     },
//     function () {
//       if (body.hasClass('sidebar-folded')){
//         body.removeClass("open-sidebar-folded");
//       }
//     });


//     // close sidebar when click outside on mobile/table    
//     $(document).on('click touchstart', function(e){
//       e.stopPropagation();

//       // closing of sidebar menu when clicking outside of it
//       if (!$(e.target).closest('.sidebar-toggler').length) {
//         var sidebar = $(e.target).closest('.sidebar').length;
//         var sidebarBody = $(e.target).closest('.sidebar-body').length;
//         if (!sidebar && !sidebarBody) {
//         if ($('body').hasClass('sidebar-open')) {
//           $('body').removeClass('sidebar-open');
//         }
//         }
//       }
//     });


//     //Horizontal menu in mobile
//     $('[data-toggle="horizontal-menu-toggle"]').on("click", function() {
//       $(".horizontal-menu .bottom-navbar").toggleClass("header-toggled");
//     });
//     // Horizontal menu navigation in mobile menu on click
//     var navItemClicked = $('.horizontal-menu .page-navigation >.nav-item');
//     navItemClicked.on("click", function(event) {
//       if(window.matchMedia('(max-width: 991px)').matches) {
//         if(!($(this).hasClass('show-submenu'))) {
//           navItemClicked.removeClass('show-submenu');
//         }
//         $(this).toggleClass('show-submenu');
//       }        
//     })

//     $(window).scroll(function() {
//       if(window.matchMedia('(min-width: 992px)').matches) {
//         var header = $('.horizontal-menu');
//         if ($(window).scrollTop() >= 60) {
//           $(header).addClass('fixed-on-scroll');
//         } else {
//           $(header).removeClass('fixed-on-scroll');
//         }
//       }
//     });


//     // Prevent body scrolling while sidebar scroll
//     $('.sidebar .sidebar-body').hover(function () {
//       $('body').addClass('overflow-hidden');
//     }, function () {
//       $('body').removeClass('overflow-hidden');
//     });
   

//   });
// })(jQuery);

(function($) {
  'use strict';
  $(function() {
    var body = $('body');
    var mainWrapper = $('.main-wrapper');
    var footer = $('footer');
    var sidebar = $('.sidebar');
    var navbar = $('.navbar').not('.top-navbar');

    // -------------- Config ----------------
    // set to true to remember last opened menu between page loads
    var rememberOpenMenu = true;
    var storageKeyOpenMenu = 'nobleui_open_menu';

    // -------------- Helpers ----------------
    function normalizePath(p) {
      // returns path without trailing slash, decode URI
      try {
        p = decodeURIComponent(p);
      } catch (e) { /* ignore */ }
      if (!p) return '/';
      return p.replace(/\/+$/, '') || '/';
    }

    function hrefToPath(href) {
      // convert href (relative/absolute) to pathname
      if (!href) return null;
      // ignore anchors and javascript
      if (href.indexOf('javascript:') === 0 || href.indexOf('#') === 0) return null;
      try {
        var url = new URL(href, window.location.origin);
        return normalizePath(url.pathname);
      } catch (e) {
        // fallback: try to extract path via anchor element
        var a = document.createElement('a'); a.href = href;
        return normalizePath(a.pathname);
      }
    }

    // -------------- Enable feather-icons ----------------
    if (typeof feather !== 'undefined') {
      feather.replace();
    }

    // -------------- Clipboard ----------------
    if (typeof ClipboardJS !== 'undefined' && $('.btn-clipboard').length) {
      $('.btn-clipboard').attr('data-bs-toggle', 'tooltip').attr('title', 'Copy to clipboard');
      var clipboard = new ClipboardJS('.btn-clipboard');
      clipboard.on('success', function(e) {
        e.trigger.innerHTML = 'copied';
        setTimeout(function() {
          e.trigger.innerHTML = 'copy';
          e.clearSelection();
        },700);
      });
    }

    // -------------- Tooltips & Popovers ----------------
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });

    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (el) { return new bootstrap.Popover(el); });

    // -------------- PerfectScrollbar ----------------
    if ($('.sidebar .sidebar-body').length && typeof PerfectScrollbar !== 'undefined') {
      try {
        const sidebarBodyScroll = new PerfectScrollbar('.sidebar-body');
      } catch (e) { /* fail silently */ }
    }

    // -------------- Sidebar collapse behavior (only one open at a time) --------------
    sidebar.on('show.bs.collapse', '.collapse', function() {
      // close other open menus
      sidebar.find('.collapse.show').not(this).collapse('hide');
    });

    // on collapse shown/hidden store last opened menu (if enabled)
    sidebar.on('shown.bs.collapse', '.collapse', function() {
      if (!rememberOpenMenu) return;
      var id = $(this).attr('id') || '';
      if (id) localStorage.setItem(storageKeyOpenMenu, id);
    });
    sidebar.on('hidden.bs.collapse', '.collapse', function() {
      if (!rememberOpenMenu) return;
      var id = $(this).attr('id') || '';
      // if hidden menu was the stored one, remove it
      if (localStorage.getItem(storageKeyOpenMenu) === id) {
        localStorage.removeItem(storageKeyOpenMenu);
      }
    });

    // -------------- Sidebar toggler ----------------
    $('.sidebar-toggler').on('click', function(e) {
      e.preventDefault();
      $('.sidebar-header .sidebar-toggler').toggleClass('active not-active');
      if (window.matchMedia('(min-width: 992px)').matches) {
        body.toggleClass('sidebar-folded');
      } else {
        body.toggleClass('sidebar-open');
      }
    });

    // -------------- Settings sidebar toggle ----------------
    $('.settings-sidebar-toggler').on('click', function(e) {
      e.preventDefault();
      $('body').toggleClass('settings-open');
    });

    // -------------- Sidebar theme settings ----------------
    $("input:radio[name=sidebarThemeSettings]").click(function() {
      $('body').removeClass('sidebar-light sidebar-dark');
      $('body').addClass($(this).val());
    });

    // -------------- ACTIVE LINK LOGIC (exact match only) ----------------
    (function setupActiveSidebar() {

      // Normalize current path
      var currentPath = normalizePath(window.location.pathname);

      // Clear existing active/show (useful if page had server-side classes)
      sidebar.find('.nav-item').removeClass('active');
      sidebar.find('.sub-menu .nav-link').removeClass('active');
      sidebar.find('.collapse').removeClass('show');
      sidebar.find('.nav-link').removeClass('active');

      // If saved open menu exists, open it first (we'll still mark active link below)
      if (rememberOpenMenu) {
        var saved = localStorage.getItem(storageKeyOpenMenu);
        if (saved) {
          var savedCollapse = $('#' + saved);
          if (savedCollapse.length) savedCollapse.addClass('show');
        }
      }

      // iterate through links
      sidebar.find('.nav-item a.nav-link').each(function() {
        var $link = $(this);
        var href = $link.attr('href');

        var linkPath = hrefToPath(href);
        if (!linkPath) return; // skip anchors / JS links

        // EXACT path comparison (no partial matches)
        if (linkPath === currentPath) {
          // mark this link active
          $link.addClass('active');

          // mark its closest nav-item active
          $link.closest('.nav-item').addClass('active');

          // if it's inside a sub-menu, open parent collapse and mark parent link active
          var subMenu = $link.closest('.sub-menu');
          if (subMenu.length) {
            var collapseParent = subMenu.closest('.collapse');
            if (collapseParent.length) {
              collapseParent.addClass('show');
              // parent link (the toggler) is previous sibling .nav-link
              var parentToggler = collapseParent.prev('.nav-link');
              parentToggler.addClass('active');
              parentToggler.closest('.nav-item').addClass('active');
              // remember this opened menu
              if (rememberOpenMenu && collapseParent.attr('id')) {
                localStorage.setItem(storageKeyOpenMenu, collapseParent.attr('id'));
              }
            }
          }
        }
      });

      // Some templates set index.html as root link - support that
      if (currentPath === '/' || currentPath === '') {
        sidebar.find('.nav-item a.nav-link').each(function() {
          var $link = $(this);
          var href = $link.attr('href') || '';
          if (href.indexOf('index.html') !== -1) {
            $link.addClass('active');
            $link.closest('.nav-item').addClass('active');
            if ($link.parents('.sub-menu').length) {
              $link.closest('.collapse').addClass('show');
            }
          }
        });
      }
    })();

    // -------------- open sidebar-folded on hover ----------------
    $(".sidebar .sidebar-body").hover(
      function () {
        if (body.hasClass('sidebar-folded')){
          body.addClass("open-sidebar-folded");
        }
      },
      function () {
        if (body.hasClass('sidebar-folded')){
          body.removeClass("open-sidebar-folded");
        }
      }
    );

    // -------------- close sidebar when click outside on mobile/table ----------------
    $(document).on('click touchstart', function(e){
      // don't close if clicking the toggler
      if ($(e.target).closest('.sidebar-toggler').length) return;

      var isSidebar = $(e.target).closest('.sidebar').length;
      var isSidebarBody = $(e.target).closest('.sidebar-body').length;

      if (!isSidebar && !isSidebarBody) {
        if ($('body').hasClass('sidebar-open')) {
          $('body').removeClass('sidebar-open');
        }
      }
    });

    // -------------- Horizontal menu mobile behaviour ----------------
    $('[data-toggle="horizontal-menu-toggle"]').on("click", function() {
      $(".horizontal-menu .bottom-navbar").toggleClass("header-toggled");
    });

    var navItemClicked = $('.horizontal-menu .page-navigation > .nav-item');
    navItemClicked.on("click", function(event) {
      if(window.matchMedia('(max-width: 991px)').matches) {
        if(!($(this).hasClass('show-submenu'))) {
          navItemClicked.removeClass('show-submenu');
        }
        $(this).toggleClass('show-submenu');
      }
    });

    $(window).scroll(function() {
      if(window.matchMedia('(min-width: 992px)').matches) {
        var header = $('.horizontal-menu');
        if ($(window).scrollTop() >= 60) {
          $(header).addClass('fixed-on-scroll');
        } else {
          $(header).removeClass('fixed-on-scroll');
        }
      }
    });

    // -------------- Prevent body scrolling while sidebar scroll ----------------
    $('.sidebar .sidebar-body').hover(function () {
      $('body').addClass('overflow-hidden');
    }, function () {
      $('body').removeClass('overflow-hidden');
    });

    // -------------- Misc: close other submenus when one opens - already handled above --------------

  });
})(jQuery);
