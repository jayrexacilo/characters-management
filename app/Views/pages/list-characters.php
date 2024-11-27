<?= $this->extend('main_layout') ?>

<?= $this->section('page_title'); ?>Sign Up<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <h2 class="text-center fw-bold my-5">Character Listing Page</h2>

    <div class="w-50 mx-auto">
        <p class="fw-bold">Characters</p>
        <div id="list-characters" class="row gy-4">
        </div>
        <div id="page-nav" class="d-none d-flex">
            <button id="page-prev-btn" class="page-nav-btn">Prev</button>
            <div id="page-number"></div>
            <button id="page-next-btn" class="page-nav-btn">Next</button>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", async function () {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const paramValue = urlParams.get('page') || null;
        const urlParam = paramValue ? `?page=${paramValue}` : '';
        const url = "https://swapi.dev/api/people/";
        let totalItems = 0;
        let itemsPerPage = 10;
        let numberOfPages = 0;

        //console.log('page param => ', paramValue);

        const getData = await fetch(url+urlParam);
        const response = await getData.json();

        //console.log('getData => ', getData);
        //console.log('results => ', response);

        if(!response?.count || !response.results?.length) {
            return;
        }
        document.getElementById("page-nav").classList.remove("d-none");

        totalItems = response?.count;
        itemsPerPage = paramValue === 1 ? response.results?.length : 10;
        numberOfPages = Math.ceil(totalItems / itemsPerPage);

        response.results?.map((item, index) => {
            const postElement = document.createElement("div");
            const url = item.url;
            const parts = url.split('/');
            const lastItem = parts[parts.length - 2];
            const charID = lastItem;
            postElement.classList = "col-md-2 p-0 mx-1 h-100";
            postElement.innerHTML = `
            <div class="character-item p-3" data-id="${charID}">
                <p>${index}</p>
                <p>${item.name}</p>
                <p>${item.gender}</p>
            <div>
            `;
            document.getElementById("list-characters").appendChild(postElement);
        });

        const charItems = document.querySelectorAll('.character-item');
        charItems.forEach(item => {
            item.addEventListener('click', event => {
                const charID = event.currentTarget.getAttribute('data-id');

                console.log("char item clicked => ", event.target);
                console.log("char item clicked 2=> ", );
                console.log("char item clicked 3=> ", event.target.getAttribute('data-id'));

                if(charID) {
                    window.location.href = "/list-characters/"+charID;
                }
            });
        });

        for(let i=1; i <= numberOfPages; i++) {
            const page = document.createElement("a");
            page.classList = "mx-1 btn";
            page.href = "?page="+i;
            if(!paramValue && i === 1) page.classList += " active";
            if(paramValue == i) page.classList += " active";
            page.innerText = i;
            document.getElementById("page-number").appendChild(page);
        }

        const pageNavs = document.querySelectorAll('.page-nav-btn');

        pageNavs.forEach(nav => {
          nav.addEventListener('click', event => {
            if(event.target.id === "page-prev-btn" && paramValue && paramValue > 1) {
                const prevPage = +paramValue - 1;
                window.location.href = "?page="+prevPage;
            }
            if(event.target.id === "page-next-btn" && paramValue && paramValue < numberOfPages) {
                const nextPage = +paramValue + 1;
                window.location.href = "?page="+nextPage;
            }

          });
        });
    });
</script>

<?= $this->endSection() ?>
