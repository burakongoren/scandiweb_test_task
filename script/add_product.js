function showForm() {
    var selectedOption = $("#productType").val();
    if (selectedOption === "DVD") {
        $("#size, #type_label1, #type_label11").show();
        $("#weight, #height, #width, #length, #type_label2, #type_label3, #type_label4, #type_label5, #type_label22, #type_label33").hide();
        $("#type_label11").text("Please, provide disk space in MB");
    } else if (selectedOption === "Book") {
        $("#weight, #type_label2, #type_label22").show();
        $("#size, #height, #width, #length, #type_label1, #type_label3, #type_label4, #type_label5, #type_label11, #type_label33").hide();
        $("#type_label22").text("Please, provide book weight in KG");
    } else if (selectedOption === "Furniture") {
        $("#height, #width, #length, #type_label3, #type_label4, #type_label5 , #type_label33").show();
        $("#size, #weight, #type_label1, #type_label2, #type_label11, #type_label22").hide();
        $("#type_label33").text("Please, provide furniture dimensions in CM");
    } else {
        $("#size, #weight, #height, #width, #length, #type_label1, #type_label2, #type_label3, #type_label4, #type_label5, #type_label11, #type_label22, #type_label33").hide();
    }
}
$(document).ready(function() {
    $("#productType").change(function() {
        if ($(this).val() === "DVD") {
            $("#size").prop("required", true);
            $("#weight").prop("required", false);
            $("#height").prop("required", false);
            $("#width").prop("required", false);
            $("#length").prop("required", false);
        } else if ($(this).val() === "Book") {
            $("#size").prop("required", false);
            $("#weight").prop("required", true);
            $("#height").prop("required", false);
            $("#width").prop("required", false);
            $("#length").prop("required", false);
        } else if ($(this).val() === "Furniture") {
            $("#size").prop("required", false);
            $("#weight").prop("required", false);
            $("#height").prop("required", true);
            $("#width").prop("required", true);
            $("#length").prop("required", true);
        }
    });
});