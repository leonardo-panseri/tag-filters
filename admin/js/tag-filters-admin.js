(function ($) {
    'use strict';

    $(function() {
        const tags = {}
        $("#tagfilters-available-tags option").each((id, elem) => {
            tags[elem.value] = {
                used: false,
                name: elem.innerText
            };
        });

        const selectTag = document.getElementById('tagfilters-available-tags');

        const updateOptions = function () {
            const newOptions = []
            for(const tag in tags) {
                if(!tags[tag].used) newOptions.push({
                    name: tags[tag].name,
                    value: tag}
                );
            }
            /* Remove all options from the select list */
            $('#tagfilters-available-tags').empty();

            /* Insert the new ones from the array above */
            newOptions.forEach(function (el) {
                $('#tagfilters-available-tags').append($('<option>', {
                    value: el.value,
                    text: el.name,
                }));
            })
        }

        $("#tagfilters-tags-add-btn").click(function () {
            const selected = selectTag.value;
            if (tags[selected].used) {
                updateOptions()
            } else {
                tags[selected].used = true;
                $('#tagfilters-tags-list').append(`<li>${tags[selected].name}</li>`);
                $('#tagfilters-new-form').append(`<input type="hidden" name="selected_tags[]" value="${selected}">`);
                updateOptions();
            }
        });
    });

})(jQuery);
