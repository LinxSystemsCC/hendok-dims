// Initialize dxPopup for validation errors
var generalValidationPopup = $("#generalValidationPopup").dxPopup({
    visible: false,
    title: "Validation Errors",
    showTitle: true,
    width: 450,
    height: 350,
    dragEnabled: true,
    closeOnOutsideClick: true,
    contentTemplate: function() {
        return $("#generalErrorList");
    },
    toolbarItems: [
        {
            widget: "dxButton",
            toolbar: "bottom",
            location: "after",
            options: {
                text: "Okay",
                onClick: function() {
                    generalValidationPopup.hide();
                }
            }
        }
    ]
}).dxPopup("instance");

var generalErrorList = $("#generalErrorList").dxList({
    dataSource: [],
    height: "100%",
    itemTemplate: function (data) {
        return $("<div class='text-danger text-wrap'>").text(data.message);
    }
}).dxList("instance");

function modalSetValidation(modal, xhr)
{
    // Clear previous errors to avoid duplicate messages
    modal.find('.error-message').remove();
    modal.find('#general-error').remove();

    // Display general error message if it exists
    if (xhr.responseJSON.message) {
        modal.find('.modal-body').prepend(`
            <div id="general-error" class="alert alert-danger">${xhr.responseJSON.message}</div>
        `);
    }

    // Display field-specific error messages using a for loop
    let errors = xhr.responseJSON.errors;
    for (let key in errors) {
        if (errors.hasOwnProperty(key)) {
            $('#' + key).parents("div:first").append(`
                <span class="error-message text-danger errorClass">${errors[key][0]}</span>
            `);
        }
    }
}

function formatDateYYYYMMDD(date) {
    var year = date.getFullYear();
    var month = ("0" + (date.getMonth() + 1)).slice(-2);  // Months are zero-based
    var day = ("0" + date.getDate()).slice(-2);
    var hours = ("0" + date.getHours()).slice(-2);
    var minutes = ("0" + date.getMinutes()).slice(-2);
    var seconds = ("0" + date.getSeconds()).slice(-2);  // Capture seconds

    return year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
}

function formatDateDDMMYYY(date) {
    var year = date.getFullYear();
    var month = ("0" + (date.getMonth() + 1)).slice(-2);  // Months are zero-based
    var day = ("0" + date.getDate()).slice(-2);
    var hours = ("0" + date.getHours()).slice(-2);
    var minutes = ("0" + date.getMinutes()).slice(-2);
    var seconds = ("0" + date.getSeconds()).slice(-2);  // Capture seconds

    return day + "-" + month + "-" + year + " " + hours + ":" + minutes + ":" + seconds;
}

function generalAlertPopup(title, message) {
    return new Promise((resolve) => {
        const popup = $("#generalAlertPopup").dxPopup({
            width: 450,
            height: 'auto',
            title: title,
            contentTemplate: function() {
                return $("<div>").html(message);
            },
            showCloseButton: false,
            hideOnOutsideClick: false,
            toolbarItems: [{
                widget: "dxButton",
                toolbar: "bottom",
                location: "after",
                options: {
                    text: "Okay",
                    onClick: function() {
                        popup.hide();
                        resolve(true);
                    }
                }
            }]
        }).dxPopup("instance");

        popup.show();
    });
}

function generalConfirmationPopup(title, message) {
    return new Promise((resolve) => {
        const popup = $("#generalConfirmationPopup").dxPopup({
            width: 450,
            height: 'auto',
            title: title,
            contentTemplate: function() {
                return $("<div>").html(message);
            },
            showCloseButton: false,
            hideOnOutsideClick: false,
            toolbarItems: [{
                widget: "dxButton",
                toolbar: "bottom",
                location: "after",
                options: {
                    text: "YES",
                    onClick: function() {
                        popup.hide();
                        resolve(true);
                    }
                }
            }, {
                widget: "dxButton",
                toolbar: "bottom",
                location: "after",
                options: {
                    text: "NO",
                    onClick: function() {
                        popup.hide();
                        resolve(false);
                    }
                }
            }]
        }).dxPopup("instance");

        popup.show();
    });
}
