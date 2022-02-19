(function ($) {
    'use strict';

    // On DOM loaded
    $(function() {
        // Object mapping tag keys to their names and a variable that represents if the tag key is selected
        const tags = {}

        const metaBox = $('#tagfilters-meta-box');
        const displayList = $('#tagfilters-tags-list');
        const selectList = $('#tagfilters-available-tags');

        // Function that updates options of the select element
        const updateOptions = function (newOptions) {
            // Remove all options from the select list
            selectList.empty();

            // Insert the new ones from the array
            newOptions.forEach(function (el) {
                selectList.append($('<option>', {
                    value: el.value,
                    text: el.name,
                }));
            })
        }

        const getListId = function (value) {
            return `tagfilters-list-v${value}`;
        }

        const getInputId = function (value) {
            return `tagfilters-input-v${value}`;
        }

        // Function to update the DOM to set the given tag as used,
        // adds the display name to the display list
        // and adds a hidden input element for sending data with POST
        const setTagUsed = function (name, value) {
            // Gets the ids of the elements to add
            const listId = getListId(value);
            const inputId = getInputId(value);

            // If the element is already present, do not try to add it again
            if(!$(`#${listId}`).length) {
                // Appends the tag name to the ul, just for showing the user what tags are already selected
                displayList.append(`<li id="${listId}">${name}</li>`);
            }

            if(!$(`#${inputId}`).length) {
                // Appends a new hidden input element to the meta box, php will interpret this as an array
                // of integers in the POST request, thanks to the square brackets in the name field
                metaBox.append(`<input id="${inputId}" type="hidden" name="selected_tags[]" value="${value}">`);
            }
        }

        // Function to update the DOM to set the given tag an unused,
        // removes the display name and the hidden input element
        const setTagUnused = function (name, value) {
            // Gets the ids of the elements to remove
            const listId = getListId(value);
            const inputId = getInputId(value);

            // Removes the elements from the DOM, if present
            displayList.remove(`#${listId}`);
            metaBox.remove(`#${inputId}`);
        }

        const update = function () {
            // New list of options, every option is represented as an object
            // containing the display name and the value of a tag
            const newOptions = []
            for(const tag in tags) {
                const name = tags[tag].name;
                const toUpdate = tags[tag].changed;
                // Add to newOptions only tags that are not already used
                if(!tags[tag].used) {
                    newOptions.push({
                        name: name,
                        value: tag
                    });
                    if(toUpdate) setTagUnused(name, tag);
                } else {
                    if(toUpdate) setTagUsed(name, tag);
                }
                if(toUpdate) delete tags[tag].changed;
            }

            updateOptions(newOptions);
        }

        // Initialize the tags object
        $("#tagfilters-available-tags option").each((id, elem) => {
            tags[elem.value] = {
                used: elem.dataset.used === 'true',
                name: elem.innerText,
                changed: true
            };
        });
        update();

        // Gets the select element used to add new tags to the list
        const selectTag = document.getElementById('tagfilters-available-tags');

        // Register event listener for click on the tag add button
        $("#tagfilters-tags-add-btn").click(function () {
            // Gets the selected tag value
            const selected = selectTag.value;
            if (!tags[selected].used) {
                // Marks the tag as used, and set the changed flag to update the DOM
                tags[selected].used = true;
                tags[selected].changed = true;
            }

            update();
        });
    });

})(jQuery);
