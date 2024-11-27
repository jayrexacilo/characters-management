<?= $this->extend('main_layout') ?>

<?= $this->section('page_title'); ?>Login<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <h2 class="text-center fw-bold my-5">View Character Page</h2>
    <div class="w-50 mx-auto" id="character-details">
        <a href="/list-characters" onclick="window.history.back(); return false;" class="text-uppercase"><span><</span> Back to Listing Page</a>
    </div>

<script>

    document.addEventListener("DOMContentLoaded", async function () {
        const url = "https://swapi.dev/api/people/<?= $charID ?>";
        const getData = await fetch(url);
        const response = await getData.json();

        console.log('getData => ', getData);
        console.log('results => ', response);
        if(!response?.name) {
            return;
        }
        
        const charEl = document.createElement("div");
        charEl.innerHTML = `
            <h3>${response.name}</h3>
            <p class="fw-bold">Height: ${response.height}</p>
            <p class="fw-bold">Hair Colour: ${response.hair_color}</p>
            <p class="fw-bold">Gender: ${response.gender}</p>
        `;
        document.getElementById("character-details").appendChild(charEl);
    });
</script>
<?= $this->endSection() ?>
