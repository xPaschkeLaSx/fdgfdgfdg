const search = document.querySelector('input[placeholder="search test"]');
const testContainer = document.querySelector(".tests");

search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};

        fetch("/search", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (tests) {
           testContainer.innerHTML = "";
            loadTests(tests)
        });
    }
});

function loadTests(tests) {
    tests.forEach(test => {
        console.log(test);
        createTest(test);
    });
}

function createTest(test) {
    const template = document.querySelector("#test-template");

    const clone = template.content.cloneNode(true);
    const div = clone.querySelector("div");
    div.id = test.id;
    const image = clone.querySelector("img");
    image.src = `/public/uploads/${test.image}`;
    const title = clone.querySelector("h2");
    title.innerHTML = test.title;
    const description = clone.querySelector("p");
    description.innerHTML = test.description;
    const like = clone.querySelector(".fa-heart");
    like.innerText = test.like;
    const dislike = clone.querySelector(".fa-minus-square");
    dislike.innerText = test.dislike;

   testContainer.appendChild(clone);
}
