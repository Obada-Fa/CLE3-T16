// Declare a variable to store the current category
let currentCategory = '';
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
            itemsContainer.style.display = 'flex'; // Use 'flex' for horizontal layout
            itemsContainer.style.overflowX = 'auto'; // Enable horizontal scrolling
            itemsContainer.style.flexWrap = 'nowrap'; // Prevent wrapping

            // Populate slider items
            data.data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'item';
                div.style.minWidth = '120px'; // Ensure items have a minimum width
                div.textContent = item.OptionalDescription;
                div.onclick = function() {
                    // Update the sentence with the clicked item
                    sentenceContainer.textContent = `Ik ${categoryMap[currentCategory]} ${this.textContent} `;
                };
                itemsContainer.appendChild(div);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}