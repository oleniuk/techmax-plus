const products = document.querySelectorAll(".product-card");

products.forEach((product) => {
  const productName = product.querySelector(".productname").innerHTML.trim();

  const button = product.querySelector(".btn-shop");

  button.addEventListener("click", () => sendForm(productName));
});

function sendForm(productName) {
  /*let form = $("." + $(this).attr("id"))[0];
  let fd = new FormData(form);*/
  let fd = new FormData();

  const name = window.localStorage.getItem("name");
  const phone = window.localStorage.getItem("phone");
  fd.append("name", name);
  fd.append("phone", phone);
  fd.append("productname", productName);

  // let productData = window.localStorage.getItem("order list");
  // fd.append("productData", productData);

  $.ajax({
    url: "/sendformadd.php",
    type: "POST",
    data: fd,
    processData: false,
    contentType: false,
    beforeSend: () => {},
    success: function success(res) {},
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(
        thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText
      );
    },
  });
}
