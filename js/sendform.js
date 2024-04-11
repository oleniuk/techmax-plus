const forms = document.querySelectorAll(".order-form");

forms.forEach((form) => {
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    /*let form = $("." + $(this).attr("id"))[0];
    let fd = new FormData(form);*/
    let fd = new FormData(form);

    const pathname = window.location.pathname;
    const link = pathname.split("/").pop();
    fd.append("link", link);

    window.localStorage.setItem("name", JSON.stringify(fd.get("name")));
    window.localStorage.setItem("phone", JSON.stringify(fd.get("phone")));

    // let productData = window.localStorage.getItem("order list");
    // fd.append("productData", productData);

    $.ajax({
      url: "/sendform.php",
      type: "POST",
      data: fd,
      processData: false,
      contentType: false,
      beforeSend: () => {
        //$(".preloader").addClass("preloader_active");
      },
      success: function success(res) {
        //alert("1");
        //$(".preloader").removeClass("preloader_active");
        //console.log(res);
        if (res == '"SUCCESS"') {
          location.assign("/form.html");
        } else {
          alert("Помилка, спробуйте ще раз!");
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(
          thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText
        );
      },
    });
  });
});
