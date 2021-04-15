jQuery(document).ready(function (){
    const $ = jQuery;

    $("#add-more-currency").on("click", function (){
        var clone = $("#markup-to-clone").clone();
        clone.removeAttr("id");

        $("#currency-changer-table").append(clone);
    })

    $(".form-table").on("click", ".wpccbks-remove-currency", function (){
        $(this).closest("tr").remove();
    })

});