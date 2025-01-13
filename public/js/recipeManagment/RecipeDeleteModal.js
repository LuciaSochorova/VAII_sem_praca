
class RecipeDeleteModal {
    #deleteModal

    constructor() {
        this.#deleteModal = document.getElementById("deleteModal");
        this.#init()
    }

    #init() {
        this.#deleteModal.addEventListener("show.bs.modal", (event) => {
            let button = event.relatedTarget;
            let recipeName = button.getAttribute("data-recipeName")
            let recipeId = button.getAttribute("data-recipeId");
            this.#deleteModal.querySelector(".modal-body").innerText = "Ste si istý, že chcete vymazať recept " + recipeName + "? Táto akcia sa nedá vrátiť!"
            this.#deleteModal.querySelector(".btn-danger").onclick =  () => {
                const params = new URLSearchParams();
                params.append("id", recipeId)
                window.location.href = `http://localhost/?c=recipe&a=delete&${params.toString()}`
            };
        })
    }
}
export {RecipeDeleteModal}