function fetchCategoryData(category) {
    currentCategory = category; // Update the current category

    // Map the table names to Dutch phrases
    const categoryMap = {
        'Feelings': 'voel',
        'Needs': 'wil',
        'Belongings': 'heb',
        'IdentityStatements': 'ben'
    };

    fetch(`./includes/fetch_data.php?category=${category}`)
        .then(response => response.json())
        .then(data => {
            const itemsContainer = document.getElementById('items');
            const sentenceContainer = document.getElementById('sentence');

            // Update the sentence with the correct Dutch phrase
            sentenceContainer.textContent = `Ik ${categoryMap[category]} `;

            // Clear previous items and prepare for the slider
            itemsContainer.innerHTML = '';
            itemsContainer.style.display = 'flex';
            itemsContainer.style.overflowX = 'auto';
            itemsContainer.style.flexWrap = 'nowrap';

            // Populate slider items
            data.data.forEach(item => {
                // Create the container for each item
                const div = document.createElement('div');
                div.className = 'item';
                div.style.minWidth = '120px';

                // Create and append the emoji span
                const emojiSpan = document.createElement('span');
                emojiSpan.textContent = item.Emoji;
                emojiSpan.style.marginRight = '10px';
                div.appendChild(emojiSpan);

                // Create and append the description text
                const textSpan = document.createElement('span');
                textSpan.textContent = item.Description;
                div.appendChild(textSpan);

                // Add click event to update the sentence
                div.onclick = function() {
                    sentenceContainer.textContent = `Ik ${categoryMap[currentCategory]} ${item.Description} ${item.Emoji}`;
                };

                // Append the item to the items container
                itemsContainer.appendChild(div);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}
