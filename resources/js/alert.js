import Swal from 'sweetalert2';

const sweetAlertBase = {
    customClass: {
        popup: 'ruang-cinema-swal',
        title: 'ruang-cinema-swal-title',
        htmlContainer: 'ruang-cinema-swal-text',
        confirmButton: 'ruang-cinema-swal-confirm',
        cancelButton: 'ruang-cinema-swal-cancel',
    },
    buttonsStyling: false,
    reverseButtons: true,
    backdrop: 'rgba(15, 23, 42, 0.45)',
};

export function showSuccessAlert(title, message) {
    return Swal.fire({
        ...sweetAlertBase,

        icon: 'success',

        title,
        text: message,

        confirmButtonText: 'OK',

        showConfirmButton: true,

        showCloseButton: true,

        allowOutsideClick: true,

        timer: 3500,
        timerProgressBar: true,
    });
}


export function showErrorAlert(title, message) {
    return Swal.fire({
        ...sweetAlertBase,

        icon: 'error',

        title,
        text: message,

        confirmButtonText: 'OK',

        showConfirmButton: true,

        showCloseButton: true,

        allowOutsideClick: true,
    });
}


export function showInfoAlert(title, message) {
    return Swal.fire({
        ...sweetAlertBase,

        icon: 'info',

        title,
        text: message,

        confirmButtonText: 'OK',

        showConfirmButton: true,

        showCloseButton: true,
    });
}


export function showWarningAlert(title, message) {
    return Swal.fire({
        ...sweetAlertBase,

        icon: 'warning',

        title,
        text: message,

        confirmButtonText: 'OK',

        showConfirmButton: true,

        showCloseButton: true,
    });
}


export function showConfirmAlert(title, message) {
    return Swal.fire({
        ...sweetAlertBase,

        icon: 'question',

        title,
        text: message,

        showCancelButton: true,

        confirmButtonText: 'Remove',
        cancelButtonText: 'Cancel',

        showCloseButton: true,

        allowOutsideClick: false,
    });
}

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('[data-confirm-favorite]').forEach((form) => {

        form.addEventListener('submit', async (event) => {

            event.preventDefault();

            const movieTitle = form.dataset.movieTitle;

            const result = await showConfirmAlert(
                'Remove from Favorites?',
                `"${movieTitle}" will be removed from your favorites.`
            );

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});

window.showSuccessAlert = showSuccessAlert;
window.showErrorAlert = showErrorAlert;
window.showInfoAlert = showInfoAlert;
window.showWarningAlert = showWarningAlert;
window.showConfirmAlert = showConfirmAlert;
