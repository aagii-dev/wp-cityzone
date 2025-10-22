jQuery.noConflict()
jQuery(document).ready(function ($) {
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll(".needs-validation")

  // Loop over them and prevent submission
  Array.from(forms).forEach((form) => {
    //star
    const stars = form.querySelectorAll(".rating-star") // Зөвхөн тухайн формын rating-fill SVG-үүд
    const ratingInput = form.querySelector('input[name="rating"]') // Тухайн формын нуусан input

    stars.forEach((star, index) => {
      star.addEventListener("click", function () {
        // Сонгосон одны индекс дээр үндэслэн үнэлгээ оруулах
        const ratingValue = index + 1
        ratingInput.value = ratingValue // нуусан input-д хадгалах
        // Сонгосон од хүртэл бүх одыг идэвхжүүлж харуулах
        stars.forEach((s, i) => {
          if (i < ratingValue) {
            s.classList.add("active") // active ангилал нэмэх
          } else {
            s.classList.remove("active")
          }
        })
      })
    })

    //validate
    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        event.preventDefault()
        event.stopPropagation()

        // FormData ашиглан өгөгдлийг авах
        const formData = new FormData(form)

        const rating = formData.get("rating") // "name" талбарын утгыг авах
        const name = formData.get("name") // "name" талбарын утгыг авах
        const comment = formData.get("comment") // "name" талбарын утгыг авах
        const page = formData.get("page") // "name" талбарын утгыг авах
        const modalId = formData.get("modal") // "name" талбарын утгыг авах
        var reviewData = {
          action: "submit_review", // AJAX-д ашиглах үйлдлийн нэр
          review_title: name,
          review_content: comment,
          review_rating: rating,
          review_page: page,
          nonce: reviewAjax.nonce, // WordPress-ийн хамгаалалтын nonce
        }

        $.ajax({
          type: "POST",
          url: reviewAjax.ajax_url, // WordPress AJAX URL
          data: reviewData,
          success: function (response) {
            if (response.success) {
              const modalElement = document.getElementById(modalId)
            const currentModal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement)
            currentModal.hide()
            } else {
              alert("Error submitting review: " + response.data)
            }
          },
        })

        form.classList.add("was-validated")
      },
      false
    )
  })
})
