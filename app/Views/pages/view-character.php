<?= $this->extend('main_layout') ?>

<?= $this->section('page_title'); ?>Login<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <h2 class="text-center fw-bold my-5">View Character Page</h2>
    <div class="w-50 mx-auto mb-5" id="character-details">
        <a href="/characters" onclick="window.history.back(); return false;" class="text-uppercase mb-5 d-block"><span><i class="bi bi-chevron-left fw-bold" style="font-size: 1.2rem; font-weight: bold;"></i></span> Back to Listing Page</a>
    </div>
    <div class="w-50 mx-auto d-none" id="character-details-buttons">
        <?php if(!$character): ?>
            <button id="save-character-btn" class="btn btn-submit text-uppercase text-sm mt-5 character-btn-action">Save Character</button>
        <?php endif; ?>
        <?php if($character): ?>
            <button id="delete-character-btn" class="btn btn-submit text-uppercase text-sm mt-5 character-btn-action">Delete Character</button>
        <?php endif; ?>
    </div>

<script>

    document.addEventListener("DOMContentLoaded", async function () {
        const url = "https://swapi.dev/api/people/<?= $charID ?>";
        const getData = await fetch(url);
        const response = await getData.json();

        //console.log('getData => ', getData);
        //console.log('results => ', response);
        if(!response?.name) {
            return;
        }
        document.getElementById("character-details-buttons").classList.remove('d-none');
        const charData = response;
        
        const charEl = document.createElement("div");
        charEl.innerHTML = `
            <h3>${response.name}</h3>
            <p class="fw-bold">Height: ${response.height}</p>
            <p class="fw-bold">Hair Colour: ${response.hair_color}</p>
            <p class="fw-bold">Gender: ${response.gender}</p>
        `;
        document.getElementById("character-details").appendChild(charEl);

        document.getElementById("save-character-btn")?.addEventListener('click', async function () {
            const characterData = {
                data: JSON.stringify(charData),
                character_id: <?= $charID ?>
            };
            console.log('characterData => ', characterData);
            const saveCharacter = await fetch('/characters', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(characterData),
            });
            const response = await saveCharacter.json();
            //console.log('save saveCharacter => ', saveCharacter);
            //console.log('save response => ', response);

            if(window.history?.length <= 2) return window.location.href = response.redirect;
            if(response?.redirect && response.status === 'success') window.history.back();
        });
        document.getElementById("delete-character-btn")?.addEventListener('click', async function () {
            const deleteCharacter = await fetch('/characters/<?= $charID ?>', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });
            const response = await deleteCharacter.json();
            //console.log('delete  => ', deleteCharacter);
            //console.log('delete response => ', response);

            if(window.history?.length <= 2) return window.location.href = response.redirect;
            if(response?.redirect && response.status === 'success') window.history.back();
        });
    });
</script>
<?= $this->endSection() ?>
