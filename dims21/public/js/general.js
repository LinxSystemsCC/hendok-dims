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
            $('#' + key).after(`
                <span class="error-message text-danger">${errors[key][0]}</span><br>
            `);
        }
    }
}
