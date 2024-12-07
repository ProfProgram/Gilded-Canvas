let products = {
    data: [
        // Abstract Art
        { productName: "Serene Dream", category: "Abstract Art", price: "£57", image: "./Search Images/serene-dream.png" },
        { productName: "Colour Harmony", category: "Abstract Art", price: "£40", image: "./Search Images/colour-harmony.jpeg" },
        { productName: "Earth Rhythm", category: "Abstract Art", price: "£65", image: "./Search Images/earth-rhythm.png" },
        { productName: "Silent Shadows", category: "Abstract Art", price: "£70", image: "./Search Images/silent-shadows.jpeg" },
        { productName: "Colour Wave", category: "Abstract Art", price: "£35", image: "./Search Images/colour-wave.png" },

        // Landscape Art
        { productName: "Golden Glow", category: "Landscape Art", price: "£150", image: "./Search Images/golden-glow.jpeg" },
        { productName: "Peaceful Hills", category: "Landscape Art", price: "£175", image: "./Search Images/peaceful-hills.png" },
        { productName: "Tranquil Valley", category: "Landscape Art", price: "£120", image: "./Search Images/tranquil-valley.png" },
        { productName: "Golden Fields", category: "Landscape Art", price: "£100", image: "./Search Images/golden-fields.png" },
        { productName: "Calm Lake", category: "Landscape Art", price: "£200", image: "./Search Images/calm-lake.jpeg" },

        // Decorative Art
        { productName: "Golden Harmony Knot Sculpture", category: "Decorative Art", price: "£220", image: "./Search Images/golden-harmony-knot-sculpture.png" },
        { productName: "Glided Frame Art", category: "Decorative Art", price: "£199.99", image: "./Search Images/glided-frame-art.jpeg" },
        { productName: "Golden Bloom Vase", category: "Decorative Art", price: "£149.99", image: "./Search Images/golden-bloom-vase.jpeg" },
        { productName: "Luxury Wall Clock", category: "Decorative Art", price: "£249.99", image: "./Search Images/luxury-wall-clock.jpeg" },
        { productName: "Classic Brown Frame", category: "Decorative Art", price: "£85", image: "./Search Images/classic-brown-frame.PNG" },

        // Figurative Art
        { productName: "Calm Figure", category: "Figurative Art", price: "£55", image: "./Search Images/calm-figure.png" },
        { productName: "Quiet Strength", category: "Figurative Art", price: "£50", image: "./Search Images/quiet-strength.png" },
        { productName: "Graceful Profile", category: "Figurative Art", price: "£70", image: "./Search Images/graceful-profile.jpeg" },
        { productName: "The Apple Basket", category: "Figurative Art", price: "£100", image: "./Search Images/the-apple-basket.png" },
        { productName: "Tabletop Harmony", category: "Figurative Art", price: "£125", image: "./Search Images/tabletop-harmony.png" },

        // Modern Art
        { productName: "Golden Night Tree", category: "Modern Art", price: "£50", image: "./Search Images/golden-night-tree.jpeg" },
        { productName: "Soft Marble Smoke", category: "Modern Art", price: "£75", image: "./Search Images/soft-marble-smoke.jpg" },
        { productName: "Two Moons", category: "Modern Art", price: "£60", image: "./Search Images/two-moons.PNG" },
        { productName: "Black Wave", category: "Modern Art", price: "£90", image: "./Search Images/black-wave.PNG" },
        { productName: "Midnight Shape", category: "Modern Art", price: "£50", image: "./Search Images/midnight-shape.PNG" },
    ],
};

let basket = [];

function displayProducts() {
    document.getElementById("products").innerHTML = "";
    for (let i of products.data) {
        let card = document.createElement("div");
        card.classList.add("card", i.category.replace(/\s+/g, "-"));

        let imgContainer = document.createElement("div");
        imgContainer.classList.add("image-container");

        let image = document.createElement("img");
        image.setAttribute("src", i.image);
        imgContainer.appendChild(image);
        card.appendChild(imgContainer);

        let name = document.createElement("h5");
        name.classList.add("product-name");
        name.innerText = i.productName.toUpperCase();
        card.appendChild(name);

        let price = document.createElement("h6");
        price.classList.add("product-price");
        price.innerText = i.price;
        card.appendChild(price);

        let addButton = document.createElement("button");
        addButton.innerText = "Add to Basket";
        addButton.classList.add("button-value", "add-to-basket-btn");
        addButton.addEventListener("click", () => {
            basket.push(i);
            alert(`${i.productName} has been added to your basket!`);
        });
        card.appendChild(addButton);

        document.getElementById("products").appendChild(card);
    }
}

function filterProduct(value) {
    let buttons = document.querySelectorAll(".button-value");
    buttons.forEach(button => {
        if (value.toUpperCase() === button.innerText.toUpperCase()) {
            button.classList.add("active");
        } else {
            button.classList.remove("active");
        }
    });

    let elements = document.querySelectorAll(".card");
    elements.forEach(element => {
        if (value === "all") {
            element.classList.remove("hide");
        } else {
            if (element.classList.contains(value.replace(/\s+/g, "-"))) {
                element.classList.remove("hide");
            } else {
                element.classList.add("hide");
            }
        }
    });
}

document.getElementById("search").addEventListener("click", () => {
    let searchInput = document.getElementById("search-input").value.toLowerCase();
    let elements = document.querySelectorAll(".product-name");
    let cards = document.querySelectorAll(".card");

    elements.forEach((element, index) => {
        if (element.innerText.toLowerCase().includes(searchInput)) {
            cards[index].classList.remove("hide");
        } else {
            cards[index].classList.add("hide");
        }
    });
});

window.onload = () => {
    displayProducts();
    filterProduct("all");
};
