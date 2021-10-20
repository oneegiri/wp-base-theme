window.addEventListener('DOMContentLoaded', function () {
  var slider = tns({
    container: '.slider__body',
    items: 1,
    slideBy: 'page',
    autoplay: false,
    controls: false,
    navPosition: 'bottom',
    speed: 500,
  });

  var closeButton = document.body.querySelector('.close');
  var mobileMenu = closeButton.closest('.navbar-collapse');
  closeButton.addEventListener('click', function (e) {
    e.preventDefault();
    mobileMenu.classList.remove('show');
  });

  var navbar = document.body.querySelector('.navbar');
  var navbarHeight = navbar.offsetHeight;

  window.addEventListener('scroll', function () {
    var position = Math.round(document.documentElement.scrollTop);
    if (position > navbarHeight) {
      navbar.classList.add('alt');
    } else {
      navbar.classList.remove('alt');
    }
  });

  var sliderNav = document.body.querySelector('.slider__nav');

  sliderNav.addEventListener('click', function (e) {
    e.preventDefault();

    if (e.target.classList.contains('slider__prev')) {
      slider.goTo('prev');
    }

    if (e.target.classList.contains('slider__next')) {
      slider.goTo('next');
    }
  });


  var products = document.body.querySelector('#cta');
  products.addEventListener('click', function (e) {
    e.preventDefault();
    var content = e.target.querySelector('span');
    var redirect = e.target.getAttribute('data-redirect-to');
    if (redirect) {
      window.location = redirect;
    } else {
      content.textContent = 'Adding...';
      var productId = parseInt(e.target.getAttribute('data-product-id'));
      var query = window.location.href + `?add-to-cart=${productId}&quantity=1`;

      var xhr = new XMLHttpRequest();

      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          content.textContent = 'Go to cart';
          e.target.setAttribute('data-redirect-to', window.location.href + '/cart');
        } else {
          console.log('The request failed!');
        }
      };
      xhr.open('GET', query);
      xhr.send();
    }
  });

  var instances = {};
  var pins = document.querySelectorAll('.pin');
  initializeMobileLighboxes();

  var pinContentArray = [];
  var markers = [];

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 13.2,
    center: new google.maps.LatLng(37.774929, -122.419418),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    disableDefaultUI: true
  });

  function initMap() {
    generatePinContent();
    startMutationObserver();

    var index = 0;

    pins.forEach(function (pin) {
      var address = pin.querySelector('.pin__address').textContent.trim();

      var service = new google.maps.places.PlacesService(map);

      var request = {
        query: address,
        fields: ['geometry'],
      };

      service.findPlaceFromQuery(request, function (results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            createMarker(results[i], index);
            index += 1;
          }
        }
      });
    });
  }

  var infowindow = new google.maps.InfoWindow({
    pixelOffset: new google.maps.Size(240, 200)
  });

  function createMarker(place, i) {
    if (!place.geometry || !place.geometry.location) return;

    var marker = new google.maps.Marker({
      map,
      position: place.geometry.location,
      icon: 'https://webtailor.xyz/vigor/wp-content/themes/vigor/assets/images/pin.svg'
    });

    markers.push(marker);

    google.maps.event.addListener(marker, "click", function () {
      infowindow.setContent(pinContentArray[i]);

      infowindow.open(map, marker);

      for (var j = 0; j < markers.length; j += 1) {
        markers[j].setIcon("https://webtailor.xyz/vigor/wp-content/themes/vigor/assets/images/pin.svg");
      }
      marker.setIcon("https://webtailor.xyz/vigor/wp-content/themes/vigor/assets/images/pin-selected.svg");
    });
  }

  function initializeMobileLighboxes() {
    pins.forEach(function (pin) {
      var galleryID = pin.querySelector('.gallery').id.trim();
      instances[galleryID] = GLightbox({
        selector: '.gallery__link',
        touchNavigation: true,
        loop: true,
      });
    });
  }

  function generatePinContent() {
    pins.forEach(function (pin) {
      var el = document.createElement('div');
      el.classList.add('pin--wrap');
      var content = pin.innerHTML;
      el.innerHTML = content;

      pinContentArray.push(el);

    });
  }

  function startMutationObserver() {
    var map = document.querySelector('#map');

    // Options for the observer (which mutations to observe)
    var config = {
      attributes: true,
      childList: true,
      subtree: true
    };

    var callback = function (mutationsList, observer) {
      Array.prototype.forEach.call(mutationsList, function (mutation) {
        if (mutation.type === 'childList') {
          var curInfoWindow = map.querySelector('.gm-style-iw.gm-style-iw-c');
          if (curInfoWindow) {
            var content = curInfoWindow.querySelector('.pin__gallery');
            if (content) {
              GLightbox({
                selector: '.gallery__link',
                touchNavigation: true,
                loop: true,
              });
            }
          }
        }
      });
    };

    // Create an observer instance linked to the callback function
    var observer = new MutationObserver(callback);

    // Start observing the target node for configured mutations
    observer.observe(map, config);
  }

  initMap();
});