import {DragAndDropList} from "../dragAndDropList/DragAndDropList.js";


class RecipeManager {
    /**
     *
     * @type {DragAndDropList}
     */
    #stepList;


    constructor() {
        this.#stepList = new DragAndDropList(document.getElementById("stepList"));


        document.getElementById("addStepButton").onclick = () => {
            let stepText = document.getElementById("newStep").value.trim();
            if (stepText) {
                let li = document.createElement('li');
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
        }
    }

    removeStep(button) {
        let li = button.closest("li");
        li.remove();
    }

    removeIngredient(button) {
        let tr = button.closest("tr");
        tr.remove();
    }

}

export {RecipeManager}

