(function ($) {
    'use strict';

    // On Document ready
    $(function() {
        // Function that updates options of the select element
        const updateOptions = function () {
            // New list of options, every option is represented as an object
            // containing the display name and the value of a tag
            const newOptions = []
            for(const tag in tags) {
                // Add to newOptions only tags that are not already used
                if(!tags[tag].used) newOptions.push({
                    name: tags[tag].name,
                    value: tag}
                );
            }
            // Remove all options from the select list
            $('#tagfilters-available-tags').empty();

            // Insert the new ones from the array above
            newOptions.forEach(function (el) {
                $('#tagfilters-available-tags').append($('<option>', {
                    value: el.value,
                    text: el.name,
                }));
            })
        }

        // Initialize an object mapping tag keys to their names and a variable that represents if the tag key is selected
        const tags = {}
        $("#tagfilters-available-tags option").each((id, elem) => {
            tags[elem.value] = {
                used: elem.dataset.used === 'true',
                name: elem.innerText
            };
        });
        updateOptions();

        // Gets the select element used to add new tags to the list
        const selectTag = document.getElementById('tagfilters-available-tags');

        // Register event listener for click on the tag add button
        $("#tagfilters-tags-add-btn").click(function () {
            // Gets the selected tag value
            const selected = selectTag.value;
            if (tags[selected].used) {
                // If we end up here, an error has occurred, try to fix it updating the select list
                updateOptions()
            } else {
                // Marks the tag as used
                tags[selected].used = true;
                // Appends the tag name to the ul, just for showing the user what tags are already selected
                $('#tagfilters-tags-list').append(`<li id="tagfilters-list-v${selected}">${tags[selected].name}</li>`);
                // Appends a new hidden input element to the meta box, php will interpret this as an array
                // of integers in the POST request, thanks to the square brackets in the name field
                $('#tagfilters-meta-box').append(`<input id="tagfilters-input-v${selected}" type="hidden" name="selected_tags[]" value="${selected}">`);
                // Updates the select list
                updateOptions();
            }
        });
    });

})(jQuery);
