<?= $this->extend('main_layout') ?>

<?= $this->section('page_title'); ?>Sign Up<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <h2 class="text-center fw-bold my-5">Saved Character Listing Page</h2>

    <div class="w-75 mx-auto">
        <p class="fw-bold px-5 mx-3">Characters</p>
        <div id="list-characters" class="row gy-4 justify-content-center">
            <p id="item-placeholder" class="placeholder-glow">
              <span class="placeholder col-12"></span>
            </p>
        </div>
        <div id="page-nav" class="d-none d-flex mt-5 justify-content-center">
            <button id="page-prev-btn" class="btn page-nav-btn"><i class="bi bi-triangle-fill rotate-left"></i></button>
            <div id="page-number"></div>
            <button id="page-next-btn" class="btn page-nav-btn"><i class="bi bi-triangle-fill rotate-right"></i></button>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", async function () {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const paramValue = urlParams.get('page') || 1;
        const urlParam = `?page=${paramValue}`;
        let totalItems = 0;
        let itemsPerPage = 10;
        let numberOfPages = 0;

        console.log('page param => ', paramValue);
        console.log('page urlParam => ', urlParam);

        const getData = await fetch('/user/characters/page/'+paramValue, {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
        });
        const response = await getData.json();
        document.getElementById("item-placeholder").classList.add("d-none");

        console.log('getData => ', getData);
        console.log('results => ', response);

        if(!response?.count || !response.results?.length) {
            if(paramValue == 1 || !paramValue) {
                const el = document.createElement("p");
                el.innerHTML = `No data found.`;
                document.getElementById("list-characters").appendChild(el);
                return;
            }
            window.location.href = `/user/characters?page=1`;
            return;
        }

        totalItems = response?.count;
        itemsPerPage = paramValue === 1 ? response.results?.length : 10;
        numberOfPages = Math.ceil(totalItems / itemsPerPage);

        if(numberOfPages > 1) {
            document.getElementById("page-nav").classList.remove("d-none");
        }

        response.results?.map((data, index) => {
            const item = JSON.parse(data.data);
            const postElement = document.createElement("div");
            const url = item.url;
            const parts = url.split('/');
            const lastItem = parts[parts.length - 2];
            const charID = lastItem;
            postElement.classList = "col-md-2 p-0 mx-1 h-100";
            //postElement.innerHTML = `
            //<div class="character-item p-3" data-id="${charID}">
            //    <p>ID: ${charID}</p>
            //    <p>Name: ${item.name}</p>
            //    <p>Gender: ${item.gender}</p>
            //<div>
            //`;
            postElement.innerHTML = `
            <div class="character-item col-6 col-md-4 col-lg-3" data-id="${charID}">
                <div class="card border-0 rounded-0">
                  <div class="p-3">
                    <p>ID: ${charID}</p>
                    <p>NAME: ${item.name}</p>
                    <p>GENDER: ${item.gender}</p>
                  </div>
                  <!--<div class="p-2">
                    <a href="#" class="view-more">— VIEW MORE</a>
                  </div>-->
                </div>
              </div>`;
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
                    window.location.href = "/characters/"+charID;
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
            if(event.currentTarget.id === "page-prev-btn" && paramValue && paramValue > 1) {
                const prevPage = +paramValue - 1;
                window.location.href = "?page="+prevPage;
            }
            if(event.currentTarget.id === "page-next-btn" && paramValue && paramValue < numberOfPages) {
                const nextPage = +paramValue + 1;
                window.location.href = "?page="+nextPage;
            }

          });
        });
    });
</script>

<?= $this->endSection() ?>
