

class RecipeSearch {
    #searchInput;
    #suggestionsBox;
    #selectedItems;
    #recipesContainer;
    #searchButton;
    #selectedIngredients;
    #inputTimeout
    #timeSelect

    constructor() {
        this.#searchInput = document.getElementById("searchInput");
        this.#suggestionsBox = document.getElementById("suggestionsBox");
        this.#selectedItems = document.getElementById("selectedItems");
        this.#recipesContainer = document.getElementById("recipesContainer");
        this.#searchButton = document.getElementById("searchButton");
        this.#timeSelect = document.querySelector("select");
        this.#selectedIngredients = [];

        this.#initializeEvents();
    }


    #initializeEvents() {
        this.#searchInput.addEventListener("input", () => this.#fetchSuggestions());
        this.#searchButton.addEventListener("click", () => this.#searchRecipes());

        this.#selectedItems.querySelectorAll("button").forEach(
            button => {
                let ingredient = button.innerText.trim();
                button.addEventListener("click", () => this.#removeIngredient(ingredient, button));
                this.#selectedIngredients.push(ingredient);
            }
        )

        if (this.#selectedIngredients.length === 0 ) {
            this.#timeSelect.hidden = true;
        }

    }

    #fetchSuggestions() {
        const param = this.#searchInput.value.trim().toLowerCase();
        if (param.length > 0) {
            clearTimeout(this.#inputTimeout)
            this.#suggestionsBox.innerHTML = "";
            this.#suggestionsBox.classList.remove('d-none');
            this.#inputTimeout = setTimeout(
                async () => {
                    let response = await fetch(
                        "http://localhost/?c=ingredientApi&a=getIngredients&param=" + param,
                        {
                            method: "GET",
                            body: null,
                            headers: {
                                "Content-type": "application/json",
                                "Accept": "application/json",
                            }
                        }
                    )

                    let ingredients = await response.json();
                    ingredients.forEach( ingredient => {
                            const suggestion = document.createElement("button");
                            suggestion.className = "btn btn-outline-secondary"
                            suggestion.textContent = ingredient.name;

                            suggestion.addEventListener("click", () => {
                                if (this.#addIngredient(ingredient.name)){
                                    this.#suggestionsBox.classList.add("d-none")
                                    this.#searchInput.value = ""
                                }

                            });

                            this.#suggestionsBox.appendChild(suggestion);
                        }
                    )
                },
                300
            )
        } else {
            this.#suggestionsBox.classList.add("d-none");
        }
    }

    #addIngredient(ingredient) {

        if (!this.#selectedIngredients.includes(ingredient)) {
            this.#selectedIngredients.push(ingredient);

            const button = document.createElement("button");
            button.type = "button";
            button.className = "btn btn-secondary";
            button.innerHTML = `${ingredient} <i class="bi bi-x"></i>`;

            button.addEventListener("click", () => this.#removeIngredient(ingredient, button));

            this.#selectedItems.appendChild(button);
            document.querySelector("select").hidden = false;
            return true
        }
        return false
    }

    #removeIngredient(ingredient, button) {
        this.#selectedIngredients = this.#selectedIngredients.filter(item => item !== ingredient);
        this.#selectedItems.removeChild(button);
        if (this.#selectedIngredients.length === 0) {
            this.#timeSelect.hidden = true;
            this.#timeSelect.options[0].selected = true;
        }
    }

    async #searchRecipes()  {
        const params = new URLSearchParams();
        if (document.getElementById("filterTime").value > 0) {
            params.append("time", document.getElementById("filterTime").value)
        }

        if (this.#selectedIngredients.length > 0) {
            const encodedIngredients = this.#selectedIngredients.map(ingredient => encodeURIComponent(ingredient));
            params.append('ingredients', encodedIngredients.join(','));
        }

        window.location.href = `http://localhost/?c=search&${params.toString()}`

    }
}

export {RecipeSearch}