export class DragAndDropList {
    /**
     *
     * @type {Element}
     */
    #stepList;

    /**
     *
     * @type {Element}
     */
    #draggedElement;


    /**
     * @param {Element} stepList
     */
    constructor(stepList) {
        this.#stepList = stepList;
        this.#draggedElement = null;
    }

    /**
     * @param {Element} li
     */
    addItem(li) {
        li.draggable = true;
        this.#addDragAndDropEvents(li);
        this.#stepList.appendChild(li);
    }

    #addDragAndDropEvents(li) {


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