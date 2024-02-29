document.addEventListener("DOMContentLoaded", function () {
    var selectedProductId = null;

    var swatchOptions = document.querySelectorAll(".swatch-option");
    swatchOptions.forEach(function (option) {
        option.addEventListener("click", function () {
            var swatchesId = this.dataset.optionId;
            var productImage = document.querySelector(
                ".config-product-image[data-product-id='" + swatchesId + "']"
            );
            var productContainer = this.closest(".product-item");

            console.log(swatchesId);
            var xhr = new XMLHttpRequest();
            xhr.open(
                "GET",
                "swatches/ajax/media/?product_id=" +
                    swatchesId +
                    "&isAjax=true",
                true
            );
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var response = JSON.parse(xhr.responseText);
                    var imageUrl = response.large;
                    productContainer.querySelector(".product-image-photo").src =
                        imageUrl;
                    selectedProductId = swatchesId;
                } else {
                    console.error("AJAX Error:", xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error("AJAX Error:", xhr.statusText);
            };
            xhr.send();
        });
    });

    var secondaryActions = document.querySelectorAll(".actions-secondary");
    secondaryActions.forEach(function (action) {
        action.addEventListener("click", function () {
            var productId = this.dataset.productId;
            var formKey = this.dataset.formKey;
            console.log("clicked");
            console.log(productId);
            console.log(formKey);
            var wishlistUrl =
                "/wishlist/index/add/product/" +
                productId +
                "/form_key/" +
                formKey;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", wishlistUrl, true);
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    console.log("Product added to wishlist.");
                    window.location.href = "/index.php/wishlist/";
                } else {
                    console.error("AJAX Error:", xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error("AJAX Error:", xhr.statusText);
            };
            xhr.send();
        });
    });

    var primaryActions = document.querySelectorAll(".actions-primary");
    primaryActions.forEach(function (action) {
        action.addEventListener("click", function (e) {
            e.preventDefault();
            console.log("clicked");
            var formKey = this.querySelector("input[name=form-key]").value;
            console.log(formKey);
            var message = this.closest(".product-item-actions").querySelector(
                'input[name="uenc"]'
            );
            console.log(message.value);

            console.log(selectedProductId);
            if (selectedProductId == null) {
                message.style.display = "block";
            } else {
                var addToProductUrl =
                    "/checkout/cart/add/product/" +
                    selectedProductId +
                    "/form_key/" +
                    formKey;
                var xhr = new XMLHttpRequest();
                xhr.open("POST", addToProductUrl, true);
                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        console.log("product added to cart successfully");
                        window.location.href = "/index.php/checkout/cart/";
                    } else {
                        console.error("AJAX Error:", xhr.statusText);
                    }
                };
                xhr.onerror = function () {
                    console.error("AJAX Error:", xhr.statusText);
                };
                xhr.send();
            }
        });
    });
});
