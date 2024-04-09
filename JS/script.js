// Global variable to store the current category
let currentCategory = '';

function updateSentenceWithIcon(category, description, emoji) {
    const sentenceContainer = document.getElementById('sentence');
    if (sentenceContainer) { // Check if the sentenceContainer exists
        sentenceContainer.innerHTML = `Ik ${category} ${description} ${emoji} <span id="speakIcon" style="float: right; cursor: pointer;">🔊</span>`;
    }
}

function fetchCategoryData(category) {
    currentCategory = category;

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
            updateSentenceWithIcon(categoryMap[category], '', '');

            itemsContainer.innerHTML = '';
            data.data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'item';
                div.style.minWidth = '120px';

                const emojiSpan = document.createElement('span');
                emojiSpan.textContent = item.Emoji;
                div.appendChild(emojiSpan);

                const textSpan = document.createElement('span');
                textSpan.textContent = item.Description;
                div.appendChild(textSpan);

                div.onclick = function() {
                    updateSentenceWithIcon(categoryMap[currentCategory], item.Description, item.Emoji);
                };

                itemsContainer.appendChild(div);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}

function speakText(text) {
    if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'nl-NL';

        const voices = window.speechSynthesis.getVoices();
        const dutchVoice = voices.find(voice => voice.lang === 'nl-NL');
        if (dutchVoice) {
            utterance.voice = dutchVoice;
        }

        window.speechSynthesis.speak(utterance);
    } else {
        console.error('Speech synthesis not supported in this browser.');
    }
}
document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.querySelector('#emoji');
    const root = document.createElement('div');
    document.body.appendChild(root);

    const picker = picmo.createPicker({ rootElement: root });

    trigger.addEventListener('click', () => {
        picker.toggle();
    });

    picker.addEventListener('emoji:select', (event) => {
        const emoji = event.detail.emoji;
        trigger.value = emoji;
    });
});


document.body.addEventListener('click', function(event) {
    if (event.target.id === 'sentence' || event.target.closest('#sentence')) {
        const sentenceContainer = document.getElementById('sentence');
        const textToSpeak = sentenceContainer.textContent.replace(/[\u{1F600}-\u{1F64F}\u{1F300}-\u{1F5FF}\u{1F680}-\u{1F6FF}\u{1F700}-\u{1F77F}\u{1F780}-\u{1F7FF}\u{1F800}-\u{1F8FF}\u{1F900}-\u{1F9FF}\u{1FA00}-\u{1FA6F}\u{1FA70}-\u{1FAFF}\u{2600}-\u{26FF}\u{2700}-\u{27BF}\u{2B50}\u{2B55}]/gu, '').trim();
        speakText(textToSpeak);
    }
});

