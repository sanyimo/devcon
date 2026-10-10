import Swal from 'sweetalert2';
import { t } from './i18n';

document.addEventListener('submit', (event) => {
    const form = event.target.closest('form[data-confirm-message]');

    if (!form || form.dataset.confirmed === 'true') {
        return;
    }

    event.preventDefault();

    Swal.fire({
        title: t('Confirmar acción'),
        text: form.dataset.confirmMessage,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: t('Sí, continuar'),
        cancelButtonText: t('Cancelar'),
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.dataset.confirmed = 'true';
            form.requestSubmit();
        }
    });
});
