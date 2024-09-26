var multipleCardCarousel = document.querySelector(
    "#carouselExampleControls"
  );

if (window.matchMedia("(min-width: 768px)").matches) {
var carousel = new bootstrap.Carousel(multipleCardCarousel, {
    interval: false,
});
var carouselWidth = $(".carousel-inner")[0].scrollWidth;
var cardWidth = $(".carousel-item").width();
var scrollPosition = 0;
$("#carouselExampleControls .carousel-control-next").on("click", function () {
    if (scrollPosition < carouselWidth - cardWidth * 4) {
    scrollPosition += cardWidth;
    $("#carouselExampleControls .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
    );
    }
});
$("#carouselExampleControls .carousel-control-prev").on("click", function () {
    if (scrollPosition > 0) {
    scrollPosition -= cardWidth;
    $("#carouselExampleControls .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
    );
    }
});
} else {
$(multipleCardCarousel).addClass("slide");
}









var multipleCardCarousel2 = document.querySelector(
    "#carouselExampleControls2"
  );

if (window.matchMedia("(min-width: 768px)").matches) {
var carousel = new bootstrap.Carousel(multipleCardCarousel2, {
    interval: false,
});
var carouselWidth = $(".carousel-inner")[0].scrollWidth;
var cardWidth = $(".carousel-item").width();
var scrollPosition = 0;
$("#carouselExampleControls2 .carousel-control-next").on("click", function () {
    if (scrollPosition < carouselWidth - cardWidth * 4) {
    scrollPosition += cardWidth;
    $("#carouselExampleControls2 .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
    );
    }
});
$("#carouselExampleControls2 .carousel-control-prev").on("click", function () {
    if (scrollPosition > 0) {
    scrollPosition -= cardWidth;
    $("#carouselExampleControls2 .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
    );
    }
});
} else {
$(multipleCardCarousel2).addClass("slide");
}




var multipleCardCarousel3 = document.querySelector(
    "#carouselExampleControls3"
  );

if (window.matchMedia("(min-width: 768px)").matches) {
var carousel = new bootstrap.Carousel(multipleCardCarousel3, {
    interval: false,
});
var carouselWidth = $(".carousel-inner")[0].scrollWidth;
var cardWidth = $(".carousel-item").width();
var scrollPosition = 0;
$("#carouselExampleControls3 .carousel-control-next").on("click", function () {
    if (scrollPosition < carouselWidth - cardWidth * 4) {
    scrollPosition += cardWidth;
    $("#carouselExampleControls3 .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
    );
    }
});
$("#carouselExampleControls3 .carousel-control-prev").on("click", function () {
    if (scrollPosition > 0) {
    scrollPosition -= cardWidth;
    $("#carouselExampleControls3 .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
    );
    }
});
} else {
$(multipleCardCarousel3).addClass("slide");
}