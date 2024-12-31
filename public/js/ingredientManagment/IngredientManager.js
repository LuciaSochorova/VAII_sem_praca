class IngredientManager {
    #ingredientList;
    #deleteModal;

    constructor() {
        this.#ingredientList = document.getElementById("ingredientList").children
        this.#deleteModal = document.getElementById("deleteModal");
        this.#init()
    }

    #init() {
        this.#deleteModal.addEventListener("show.bs.modal", (event) => {
            let button = event.relatedTarget;
            let ingredientName = button.getAttribute("data-ingredientName")
            let ingredientId = button.getAttribute("data-ingredientId");
            this.#deleteModal.querySelector(".modal-body").innerText = "Ste si istý, že chcete vymazať " + ingredientName + "? Ingrediencia bude vymazaná zo všetkých receptov kde sa nachádza!"
            this.#deleteModal.querySelector(".btn-danger").onclick = async () => {
                if (await this.#deleteIngredient(ingredientId)) {
                    button.closest(".ingredient-div").remove()
                } else {
                    //todo
                }
            };
        })


        for (let child of this.#ingredientList) {
            const editButton = child.querySelector(".edit-btn")
            const saveButton = child.querySelector(".save-btn")
            const input = child.querySelector("input")
            editButton.onclick = () => {
                input.disabled = false;
                this.#switchButtonsDisplay(editButton, saveButton)
            }
            saveButton.onclick = async () => {
                let change = await this.#changeIngredient(input.value, saveButton.getAttribute("data-ingredientId"))

                if (change === null) {
                    input.closest(".ingredient-div").remove()
                } else if (change.name !== undefined) {
                    input.value = change.name
                    this.#switchButtonsDisplay(saveButton, editButton)
                    input.disabled = true;
                } else {
                    //todo
                }

            }
        }

    }

    #switchButtonsDisplay(hide, show) {
        hide.hidden = true;
        show.hidden = false;
    }

    async #deleteIngredient(ingredientId) {
        try {
            let response = await fetch(
                "http://localhost/?c=ingredientApi&a=deleteIngredient&id=" + ingredientId,
                {
                    method: "DELETE",
                    body: null,
                    headers: {
                        "Content-type": "application/json",
                        "Accept": "application/json",
                    }
                }
            )
            return response.status === 204;

        } catch (e) {
            return false;
        }
    }

    async #changeIngredient(newName, ingredientId) {
        try {
            let response = await fetch(
                "http://localhost/?c=ingredientApi&a=changeIngredient&id=" + ingredientId,
                {
                    method: "PUT",
                    body: JSON.stringify( {name: newName}),
                    headers: {
                        "Content-type": "application/json",
                        "Accept": "application/json",
                    }
                }
            )
            if (response.status === 204) {
                return null;
            } else if(response.status ===200) {
                return await response.json()
            } else {
                return false;
            }

        } catch (e) {
            return false;
        }
    }
}

export {IngredientManager}
