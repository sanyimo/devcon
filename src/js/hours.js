(function () {
    const hours = document.querySelector('#hours')

    if (hours) {
        const category = document.querySelector('[name="category_id"]');
        const days = document.querySelectorAll('[name="day"]');
        const inputHiddenDay = document.querySelector('[name="day_id"]');
        const inputHiddenHour = document.querySelector('[name="hour_id"]');

        category.addEventListener('change', searchTerm)
        days.forEach(day => day.addEventListener('change', searchTerm))

        let searching = {
            category_id: +category.value || '',
            day: +inputHiddenDay.value || ''
        }

        if (!Object.values(searching).includes('')) {
            (async () => {
                await searchEvents();

                const id = inputHiddenHour.value;

                // Resaltar la hora actual
                const selectedHour = document.querySelector(`[data-hour-id="${id}"]`)
                selectedHour.classList.remove('hours__hour--disabled')
                selectedHour.classList.add('hours__hour--selected')

                selectedHour.onclick = selectHour;
            })()
        }
        
        function searchTerm(e) {
            searching[e.target.name] = e.target.value;
            
            // Reiniciar los campos ocultos y el selector de horas
            inputHiddenHour.value = '';
            inputHiddenDay.value = '';
            
            const prevHour = document.querySelector('.hours__hour--selected')
            if (prevHour) {
                prevHour.classList.remove('hours__hour--selected')
            }
            
            if(Object.values(searching).includes('')) {
                return
            }
            searchEvents();
        }
        async function searchEvents() {
            const { day, category_id } = searching
            const url = `/api/events-schedule?day_id=${day}&category_id=${category_id}`;

            const result = await fetch(url);
            const events = await result.json();
            getAvailableHours(events);
        }

        function getAvailableHours(events) {
            // Reiniciar las horas
            const hoursList = document.querySelectorAll('#hours li');
            hoursList.forEach(li => li.classList.add('hours__hour--disabled'))
            // Comprobar events ya tomados, y quitar la variable de deshabilitado
            const hoursOccupied = events.map(event => event.hour_id);            
            const hoursListArray = Array.from(hoursList);

            const result = hoursListArray.filter(li => !hoursOccupied.includes(li.dataset.hourId));
            
            result.forEach(li => li.classList.remove('hours__hour--disabled'))

            const hoursAvailable = document.querySelectorAll('#hours li:not(.hours__hour--disabled)');
            hoursAvailable.forEach( hour => hour.addEventListener('click', selectHour));
        }

        function selectHour(e) {
            // Deshabilitar la hora previa, si hay un nuevo click
            const prevHour = document.querySelector('.hours__hour--selected')
            if (prevHour) {
                prevHour.classList.remove('hours__hour--selected')
            }

            // Agregar clase de seleccionado
            e.target.classList.add('hours__hour--selected')

            inputHiddenHour.value = e.target.dataset.hourId

            // Llenar el campo oculto de dia
            inputHiddenDay.value = document.querySelector('[name="day"]:checked').value
        }
    }
})();