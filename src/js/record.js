import Swal from 'sweetalert2'
import { t } from './i18n'

(function(){
    let events = [];

    const summary = document.querySelector('#record-summary')
    if(summary) {
            
        const eventsBtn = document.querySelectorAll('.event__add');
        eventsBtn.forEach(btn => btn.addEventListener('click', selectEvent))

        const registerForm = document.querySelector('#record');
        registerForm.addEventListener('submit', submitForm)

        showEvents();

        function selectEvent({target}) {

            if(events.length < 10) {
                // Disable the event
                target.disabled = true
                events = [...events, {
                    id: target.dataset.id,
                    title: target.parentElement.querySelector('.event__name').textContent.trim()
                }]

                showEvents();
            } else {
                Swal.fire({
                    title: t('Error'),
                    text: t('Máximo 10 eventos por registro'),
                    icon: 'error',
                    confirmButtonText: t('OK')
                })
            }
        }

        function showEvents() {
            // Clear the HTML
            cleanEvents();

            if(events.length > 0 ) {
                events.forEach( event => {
                    const eventDOM = document.createElement('DIV')
                    eventDOM.classList.add('record__event')

                    const title = document.createElement('H3')
                    title.classList.add('record__name')
                    title.textContent = event.title

                    const btnDelete = document.createElement('BUTTON')
                    btnDelete.classList.add('record__delete')
                    btnDelete.innerHTML = `<i class="fa-solid fa-trash"></i>`
                    btnDelete.onclick = function() {
                        deleteEvent(event.id)
                    }


                    // Render in the HTML
                    eventDOM.appendChild(title)
                    eventDOM.appendChild(btnDelete)
                    summary.appendChild(eventDOM)
                })
            } else {
                const noRecord = document.createElement('P')
                noRecord.textContent = t('No hay eventos, añade hasta 10 del lado izquierdo')
                noRecord.classList.add('record__text')
                summary.appendChild(noRecord)
            }
        }

        function deleteEvent(id) {
            events = events.filter( event => event.id !== id)
            const addBtn = document.querySelector(`[data-id="${id}"]`)
            addBtn.disabled = false
            showEvents();
        }

        function cleanEvents() {
            while(summary.firstChild) {
                summary.removeChild(summary.firstChild);
            }
        }

        async function submitForm(e) {
            e.preventDefault();

            // Get the gift
            const giftId = document.querySelector('#gift').value
            const eventsId = events.map(event => event.id)

            if(eventsId.length === 0 || giftId === '') {
                 Swal.fire({
                    title: t('Error'),
                    text: t('Elige al menos un evento y un regalo'),
                    icon: 'error',
                    confirmButtonText: t('OK')
                })
                return;
            }

            // FormData object
            const data = new FormData();
            data.append('events', eventsId)
            data.append('gift_id', giftId)

            const url = '/purchase/conferences?token=' + encodeURIComponent(new URLSearchParams(window.location.search).get('token') || '')
            const response = await fetch(url, {
                method: 'POST',
                body: data
            })
            const result = await response.json();

            if(result.result) {
                Swal.fire(
                    t('Éxito!'),
                    t('Tus conferencias se han guardado y tu registro ha sido exitoso, te esperamos en DevCon!'),
                    'success'
                ).then(() => location.href = `/ticket?id=${result.token}`) 
            } else {
                Swal.fire({
                    title: t('Error'),
                    text: t('Ha ocurrido un error'),
                    icon: 'error',
                    confirmButtonText: t('OK')
                }).then( () => location.reload() )
            }
        }
    }
})();