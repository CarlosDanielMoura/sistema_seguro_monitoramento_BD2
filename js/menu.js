$(document).ready(function () {
  $(".menuToggle").click(function () {
    $(".navigation").toggleClass("active");
  });
  $(".list").click(function () {
    $(".list").removeClass("active");
    $(this).addClass("active");
  });
});
