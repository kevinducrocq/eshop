$("#btn-minus").on("click", function () {
  var qty = parseInt($("#qty").val());
  if (qty > 1) {
    $("#qty").val(qty - 1);
  }
});

$("#btn-plus").on("click", function () {
  var qty = parseInt($("#qty").val());
  var max = $("#qty").data("max");
  if (qty < max) {
    $("#qty").val(qty + 1);
  }
});

function widget_cart() {
  var url = $(".cart-link").data("url");
  $.ajax({
    url: url,
    success: function (data, status) {
      $(".cart-link").html(data);
    },
    error: function (result, status, error) {
      console.log(error);
    },
  });
}

$(document).ready(function () {
  widget_cart();
});

$(".add_to_cart").on("click", function () {
  var qty = parseInt($("#qty").val());
  var price = $(this).data("price");
  var url = $(this).data("url");
  $.ajax({
    url: url,
    type: "POST",
    dataType: "html",
    data: { qty: qty, price: price },
    success: function (data, status) {
      widget_cart();
      var html =
        '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Produit ajouté au panier</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
      $(".notifications").html(html);
      setTimeout(function () {
        $(".alert-success").fadeOut(400);
      }, 2500);
    },
    error: function (data, status, error) {
      console.log(error);
    },
  });
});
