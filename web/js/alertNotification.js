const showToastr = (type, message, duration = 10000) => {
    $('#app-alert').addClass('show').removeClass('d-none');
    if(type == "success") {
        $("#app-alert-bg").addClass("bg-success").removeClass("bg-danger").removeClass("bg-info");
        $("#app-alert-title").html('<i class="far fa-check-square"></i> Success');
        $("#app-alert-body").html(message);
    } else if(type == "info") {
        $("#app-alert-bg").addClass("bg-info");
        $("#app-alert-title").html('<i class="fas fa-exclamation-triangle"></i> Info');
        $("#app-alert-body").html(message);
    } else {
        $("#app-alert-bg").addClass("bg-danger");
        $("#app-alert-title").html('<i class="fas fa-times"></i> Error');
        $("#app-alert-body").html(message);
    }
    
    // Hide alert on given duration
    setTimeout(() => {
        $('#app-alert').removeClass('show').addClass('d-none');
    }, duration);
}