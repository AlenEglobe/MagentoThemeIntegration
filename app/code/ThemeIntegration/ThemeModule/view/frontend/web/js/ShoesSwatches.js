require(["jquery"], function ($) {
    $(document).ready(function () {
        var selectedProductId = null;
        $(".swatch-option").click(function () {
            var SwatchesID = $(this).data("option-id");
            var $productImage = $(
                ".config-product-image[data-product-id='" + SwatchesID + "']"
            );
            var $productContainer = $(this).closest(".product-item");

            // console.log(ImageUrl);
            console.log(SwatchesID);
            $.ajax({
                url: "swatches/ajax/media/",
                method: "GET",
                data: { product_id: SwatchesID, isAjax: true },
                success: function (response) {
                    var imageUrl = response.large;
                    // $productImage.attr("src", imageUrl);
                    $productContainer
                        .find(".product-image-photo")
                        .attr("src", imageUrl);
                    selectedProductId = SwatchesID;
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
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
            console.log("clicked");
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
                $(this)
                    .closest(".product-item-actions")
                    .find('input[name="uenc"]')
                    .show();
            }
        });
    });
});
