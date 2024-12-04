export class DragAndDropList {
    /**
     *
     * @type {Element}
     */
    #list;

    /**
     *
     * @type {Element}
     */
    #draggedElement;


    /**
     * @param {Element} list
     */
    constructor(list) {
        this.#list = list;
        this.#draggedElement = null;
    }

    /**
     * @param {Element} li
     */
    addItem(li) {

        this.addDragAndDropEvents(li);
        this.#list.appendChild(li);
    }


    get list() {
        return this.#list;
    }

    addDragAndDropEvents(li) {
        li.draggable = true;

        li.addEventListener("dragstart", () => {
                li.classList.add('dragging');
                this.#draggedElement = li;
            }
        )

        li.addEventListener("dragover", (event) => {
            event.preventDefault();
        })

        li.addEventListener("drop", (event) => {
            event.preventDefault();
            const targetItem = event.target;
            if (targetItem !== this.#draggedElement) {
                if (event.clientY > targetItem.getBoundingClientRect().top + (targetItem.offsetHeight / 2)) {
                    targetItem.parentNode.insertBefore(this.#draggedElement, targetItem.nextSibling);
                } else {
                    targetItem.parentNode.insertBefore(this.#draggedElement, targetItem);
                }
            }
            this.#draggedElement = null;
        })
    }
}