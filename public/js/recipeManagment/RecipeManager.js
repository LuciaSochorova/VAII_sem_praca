import {DragAndDropList} from "../dragAndDropList/DragAndDropList.js";


class RecipeManager {
    /**
     *
     * @type {DragAndDropList}
     */
    #stepList;
    #timeOut;


    constructor() {
        this.#stepList = new DragAndDropList(document.getElementById("stepList"));


        for (let tr of document.getElementsByClassName("recipeIngredient")) {
            let rmButton = tr.querySelector("button");
            rmButton.onclick = () => this.removeIngredient(rmButton);
        }

        for (let li of this.#stepList.list.children) {
            this.#stepList.addDragAndDropEvents(li);
            let rmButton = li.querySelector("button");
            rmButton.onclick = () => this.removeStep(rmButton);
        }


        document.getElementById("addStepButton").onclick = () => {
            let stepText = document.getElementById("newStep").value.trim();
            if (stepText) {
                let li = document.createElement("li");
                li.className = "list-group-item d-flex align-items-center justify-content-between";
                li.innerHTML = `
                    <textarea class="form-control mx-3" rows="2">${stepText}</textarea>
                    <button type="button" class="btn btn-sm btn-danger">Odstrániť</button>
                `;
                let rmButton = li.querySelector("button");
                rmButton.onclick = () => this.removeStep(rmButton);
                this.#stepList.addItem(li);
                document.getElementById("newStep").value = "";
            }
        }


        document.getElementById("addIngredientButton").onclick = () => {
            let ingredient = document.getElementById('newRecipeIngredient').value.trim();
            let amount = document.getElementById('ingredientAmount').value.trim();
            if (ingredient && amount) {
                let tr = document.createElement('tr');
                tr.className = "recipeIngredient";
                tr.innerHTML = `
                    <td class="w-50">${ingredient}</td>
                    <td class="w-25">${amount}</td>
                    <td class="text-center"><button class="btn btn-outline-danger btn-sm" type="button">Odstrániť</button></td>
                `;
                let rmButton = tr.querySelector("button");
                rmButton.onclick = () => this.removeIngredient(rmButton);
                document.getElementById("ingredientsTableBody").appendChild(tr);
                document.getElementById('newRecipeIngredient').value = '';
                document.getElementById('ingredientAmount').value = '';
            }
            document.getElementById("ingredientsOptions").innerHTML = "";
        }


        document.getElementById("saveRecipe").onclick = async () => {
            if (this.isValid()) {
                if (await this.#saveRecipe()) {
                    window.location.replace("http://localhost/?c=recipe&a=manage");
                    //history.back();
                } //TODO

            }

        }


        document.getElementById("newRecipeIngredient").addEventListener("input", async () => {
            let param = document.getElementById("newRecipeIngredient").value.toLowerCase().trim();
            const datalist = document.querySelector("datalist");
            datalist.innerHTML = '';
            if (param.length < 2) return;


            clearTimeout(this.#timeOut)
            this.#timeOut = setTimeout(async function () {
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

                let options = await response.json();

                options.forEach((item) => {
                    let option = document.createElement("option");
                    option.value = item.name;
                    datalist.appendChild(option);
                })
            }, 300);


        })


        document.getElementById("unReportButton")?.addEventListener("click", async () => {
            let recipeId = document.getElementById("recipeForm").getAttribute("data-id");
            try {
                let response = await fetch(
                    "http://localhost/?c=recipeApi&a=unReport&id=" + recipeId,
                    {
                        method: "PUT",
                        body: null,
                        headers: {
                            "Content-type": "application/json",
                            "Accept": "application/json",
                        }
                    }
                )

                if (response.status !== 204) {
                    throw Error();
                }

                document.getElementById("unReportButton").hidden = true;
            } catch (e) {
                //todo
            }



        })



    }

    removeStep(button) {
        let li = button.closest("li");
        li.remove();
    }

    removeIngredient(button) {
        let tr = button.closest("tr");
        tr.remove();
    }

    isValid() {
        let valid = document.getElementById("recipeForm").reportValidity();

        if (!document.getElementById("ingredientsTableBody").children.length > 0) {
            let div = document.createElement("div");
            div.className = "alert alert-danger alert-dismissible fade show mb-1 mt-3";
            div.role = "alert";
            let closeButton = document.createElement("button");
            closeButton.type = "button";
            closeButton.className = "btn-close";
            closeButton.setAttribute("data-bs-dismiss", "alert");
            closeButton.setAttribute("aria-label", "Close");

            div.textContent = "Recept musí mať aspoň jednu ingredienciu";
            div.appendChild(closeButton);
            document.getElementById("ingredientsDiv").prepend(div);
            valid = false;


        }

        if (!this.#stepList.list.children.length > 0) {
            let div = document.createElement("div");
            div.className = "alert alert-danger alert-dismissible fade show mb-1 mt-3";
            div.role = "alert";
            let closeButton = document.createElement("button");
            closeButton.type = "button";
            closeButton.className = "btn-close";
            closeButton.setAttribute("data-bs-dismiss", "alert");
            closeButton.setAttribute("aria-label", "Close");

            div.textContent = "Recept musí mať aspoň jeden krok";
            div.appendChild(closeButton);
            let prev = this.#stepList.list.previousSibling.previousSibling
            prev.before(div);
            valid = false;
        }


        return valid;
    }

    async #saveRecipe() {
        try {
            let recipeId = document.getElementById("recipeForm").getAttribute("data-id");
            if (recipeId > 0) {
                let response = await fetch(
                    "http://localhost/?c=recipeApi&a=updateRecipe&id=" + recipeId,
                    {
                        method: "PUT",
                        body: JSON.stringify(this.#createRecipe()),
                        headers: {
                            "Content-type": "application/json",
                            "Accept": "application/json",
                        }
                    }
                )
                return response.status === 204;

            } else {
                let response = await fetch(
                    "http://localhost/?c=recipeApi&a=saveRecipe",
                    {
                        method: "POST",
                        body: JSON.stringify(this.#createRecipe()),
                        headers: {
                            "Content-type": "application/json",
                            "Accept": "application/json",
                        }
                    }
                )
                return response.status === 204;
            }

        } catch (e) {
            return false;
        }
    }

    #createRecipe() {
        let ingredients = [];
        for (let tr of document.getElementsByClassName("recipeIngredient")) {
            ingredients.push({name: tr.children.item(0).textContent, amount: tr.children.item(1).textContent});
        }
        let steps = [];
        for (let li of this.#stepList.list.children) {
            steps.push(li.querySelector("textarea").value);
        }
        return {
            recipe: {
                title: document.getElementById("recipeTitle").value,
                description: document.getElementById("recipeDescription").value,
                minutes: document.getElementById("recipeMinutes").value,
                portions: document.getElementById("recipePortions").value,
                image: document.getElementById("recipeImage").value,
                category: document.getElementById("categoryOfFood").value,
                notes: document.getElementById("recipeNotes").value
            },
            ingredients: ingredients,
            steps: steps
        }
    }


}

export {RecipeManager}

