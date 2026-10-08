(function () {//IIFE
    const tagsInput = document.querySelector('#tags_input')

    if (tagsInput) {

        const tagsDiv = document.querySelector('#tags');
        const tagsInputHidden = document.querySelector('[name="tags"]');

        let tags = [];

        // Recuperar del input oculto
        if (tagsInputHidden.value !== '') {
            tags = tagsInputHidden.value.split(',');
            showTags();
        }

        //escuchar los cambios en el input
        tagsInput.addEventListener('keypress', saveTag)

        function saveTag(e) {
            if (e.keyCode === 32) {//32 es 'space'
                if (e.target.value.trim() === '' || e.target.value < 1) {
                    return
                }
                e.preventDefault();
                tags = [...tags, e.target.value.trim()];
                tagsInput.value = '';
                showTags();
            }
        }

        function showTags() {
            tagsDiv.textContent = '';
            tags.forEach(tag => {
                const etiqueta = document.createElement('LI');
                etiqueta.classList.add('form__tag')
                etiqueta.textContent = tag;
                etiqueta.onclick = deleteTag
                tagsDiv.appendChild(etiqueta)
            })
            updateInputHidden();
        }

        function deleteTag(e) {
            e.target.remove()
            tags = tags.filter(tag => tag !== e.target.textContent)
            updateInputHidden();
        }
        
        function updateInputHidden() {
            tagsInputHidden.value = tags.toString();
        }
    }
})();