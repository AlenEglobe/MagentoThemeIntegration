require(["jquery"], function ($) {
    $(document).ready(function () {
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
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                },
            });
        });
    });
});
