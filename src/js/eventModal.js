const modal = document.querySelector('.event-modal');
const modalBody = modal ? modal.querySelector('.event-modal__body') : null;
const closeButton = modal ? modal.querySelector('.event-modal__close') : null;

if (modal && modalBody && closeButton) {
    const closeModal = () => {
        modal.classList.remove('event-modal--visible');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    };

    const openModal = (event) => {
        const information = event.querySelector('.event__information');

        if (!information) {
            return;
        }

        modalBody.replaceChildren(information.cloneNode(true));
        modal.classList.add('event-modal--visible');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
    };

    document.querySelectorAll('.event').forEach((event) => {
        event.addEventListener('click', (e) => {
            if (e.target.closest('a, button')) {
                return;
            }

            openModal(event);
        });
    });

    closeButton.addEventListener('click', closeModal);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('event-modal--visible')) {
            closeModal();
        }
    });
}
