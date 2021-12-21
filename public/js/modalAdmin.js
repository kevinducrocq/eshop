var exampleModalSuppr = document.getElementById("suppr_product");
exampleModalSuppr.addEventListener("show.bs.modal", function (event) {
  var button = event.relatedTarget;
  var link = button.getAttribute("data-bs-link");
  var modalLinkValue = exampleModalSuppr.querySelector(".btn-suppr");
  modalLinkValue.href = link;
});

var exampleModalActivate = document.getElementById("activate_product");
exampleModalActivate.addEventListener("show.bs.modal", function (event) {
  var button = event.relatedTarget;
  var link = button.getAttribute("data-bs-link");
  var modalLinkValue = exampleModalActivate.querySelector(".btn-activate");
  modalLinkValue.href = link;
});

var exampleModalDelete = document.getElementById("delete_product");
exampleModalDelete.addEventListener("show.bs.modal", function (event) {
  var button = event.relatedTarget;
  var link = button.getAttribute("data-bs-link");
  var modalLinkValue = exampleModalDelete.querySelector(".btn-delete");
  modalLinkValue.href = link;
});

