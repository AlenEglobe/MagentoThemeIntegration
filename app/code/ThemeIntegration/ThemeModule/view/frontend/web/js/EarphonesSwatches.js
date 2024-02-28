require(["jquery"], function ($) {
    $(document).ready(function () {
        var selectedProductId = null;

        $(".swatch-option").click(function () {
            var SwatchesId = $(this).data("option-id");

            var productContainer = $(this).closest(".product-item");
            $.ajax({
                url: "swatches/ajax/media/",
                method: "GET",
                data: { product_id: SwatchesId, isAjax: true },
                success: function (response) {
                    var imageUrl = response.large;
                    productContainer
                        .find(".product-image-photo")
                        .attr("src", imageUrl);
                    selectedProductId = SwatchesId;
                },
            });
        });

        $(".actions-secondary").click(function () {
            var productId = $(this).data("product-id");
            var form_key = $(this).data("form-key");
            console.log("clicked");
            console.log(productId);
            console.log(form_key);
            var wishlistUrl =
                "/wishlist/index/add/product/" +
                productId +
                "/form_key/" +
                form_key;

            $.ajax({
                url: wishlistUrl,
                method: "POST",

                success: function (response) {
                    console.log("Product added to wishlist.");
                    window.location.href = "/index.php/wishlist/";
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                },
            });
        });

        $(".actions-primary").click(function (e) {
            e.preventDefault();
            var form_key = $(this).find("input[name = form-key]").val();
            console.log(form_key);
            let message = $(this)
                .closest(".product-item-actions") // Corrected the class selector
                .find('input[name="uenc"]');
            console.log(message.val());
            // var selectSimpleProductId = $(this)
            //     .closest(".product-item")
            //     .find(".product-image-select")
            //     .data("product-id");

            console.log(selectedProductId);
            if (selectedProductId == null) {
                $(this).find('input[name="uenc"]').show();
            } else {
                var addToProductUrl =
                    "/checkout/cart/add/product/" +
                    selectedProductId +
                    "/form_key/" +
                    form_key;
                $.ajax({
                    url: addToProductUrl,
                    method: "POST",
                    success: function (response) {
                        console.log("product added to cart successfully");
                        window.location.href = "/index.php/checkout/cart/";
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                    },
                });
            }
        });
    });
});
