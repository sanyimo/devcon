(function () {
    const speakersInput = document.querySelector('#speakers');

    if (speakersInput) {
        let speakers = [];
        let filteredSpeakers = [];

        const speakersList = document.querySelector('#listing-speakers')
        const speakerHidden = document.querySelector('[name="speaker_id"]')

        getSpeakers();
        speakersInput.addEventListener('input', searchSpeakers)

        if (speakerHidden.value) {
            (async () => {
                const speaker = await getSpeaker(speakerHidden.value)
                const { name, surname } = speaker
 
                // Insertar en el HTML
                const speakerDOM = document.createElement('LI');
                speakerDOM.classList.add('listing-speakers__speaker', 'listing-speakers__speaker--selected');
                speakerDOM.textContent = `${name} ${surname}`
 
                speakersList.appendChild(speakerDOM)
            })()
        }

        async function getSpeakers() {
            const url = `/api/speakers`;
            const response = await fetch(url);
            const result = await response.json();
            formateSpeakers(result)
        }

        async function getSpeaker(id) {
            const url = `/api/speaker?id=${id}`;
            const response = await fetch(url)
            const result = await response.json()
            return result;
        }

        function formateSpeakers(arraySpeakers = []) {
            speakers = arraySpeakers.map( speaker => {
                return {
                    name: `${speaker.name.trim()} ${speaker.surname.trim()}`,
                    id: speaker.id
                } 
            })
        }

        function searchSpeakers(e) {
            const search = e.target.value;

            if (search.length > 3) {
                const expression = new RegExp(search, "i");
                filteredSpeakers = speakers.filter(speaker => {
                    if (speaker.name.toLowerCase().search(expression) != -1) {//-1-no lo encuentra, 0 sí
                        return speaker
                    }
                })
            } else {
                filteredSpeakers = []
            }
            showSpeakers();
        }
        function showSpeakers() {

            while (speakersList.firstChild) {//mejor performance que innerHTML
                speakersList.removeChild(speakersList.firstChild)
            }

            if (filteredSpeakers.length > 0) {
                filteredSpeakers.forEach(speaker => {
                    const speakerHTML = document.createElement('LI');
                    speakerHTML.classList.add('listing-speakers__speaker')
                    speakerHTML.textContent = speaker.name;
                    speakerHTML.dataset.speakerId = speaker.id
                    speakerHTML.onclick = selectSpeaker

                    // Añadir al dom
                    speakersList.appendChild(speakerHTML)
                })
            } else {
                const noResults = document.createElement('P')
                noResults.classList.add('listing-speakers__no-result')
                noResults.textContent = 'No hay resultados para tu búsqueda'
                speakersList.appendChild(noResults)
            }
        }
        function selectSpeaker(e) {
            const speaker = e.target;

            // Remover la clase previa
            const speakerPrev = document.querySelector('.listing-speakers__speaker--selected')
            if (speakerPrev) {
                speakerPrev.classList.remove('listing-speakers__speaker--selected')
            }
            speaker.classList.add('listing-speakers__speaker--selected')

            speakerHidden.value = speaker.dataset.speakerId
        }
    }
})();