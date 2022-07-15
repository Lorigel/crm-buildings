import attributeClasses from "../utils/attributeClasses";
// import Input from "./Input"
// import Radio from "./Radio";

class Repeater {
    /**
   *
   * @param {HTMLElement} el
   */
  constructor(el) {
    this.repeater = el;
    this.repatedItemsContainer = this.repeater.querySelector("[data-repeated-items-container]");
    this.cloneTemplate = this.repeater.querySelector("#data-repeater-clone");
    this.repeaterButtonAdd = this.repeater.querySelector("[data-repeater-add]");
    this.index = 0;

    const items = [...this.repatedItemsContainer.querySelectorAll("[data-repeated-item]")]
    if(items.length){
      this.index = items.length;
    }
    if (items.length >= this.maxRepeat) {
      this.repeaterButtonAdd.classList.remove(...attributeClasses(this.repeaterButtonAdd, "data-enabled-classes"))
      this.repeaterButtonAdd.classList.add(...attributeClasses(this.repeaterButtonAdd, "data-disabled-classes"))
    }

    this.addListeners();
  }


  addListeners() {
    this.repeater.addEventListener("click", (e) => {
      const openTarget = e.target.closest("[data-repeater-add]")
      const closeTarget = e.target.closest("[data-repeater-remove]");
      if (openTarget) {
        this.addItem()
      }
      if (closeTarget) {
        this.closeItem(closeTarget);
      }
    })
  }

  addItem(defaultValues = {}) {
    const items = [...this.repatedItemsContainer.querySelectorAll("[data-repeated-item]")]

    const newItem = this.cloneTemplate.content.children[0].cloneNode(true);
    const baseName = newItem.getAttribute("data-repeater-base-name")
    const itemNames = newItem.querySelectorAll("[name]");

    itemNames.forEach((e, key) => {
      e.setAttribute("name", `${baseName}_${this.index}_${e.name}`)
      e.value = ''

      // if(e.type == 'radio'){
      //   const radio = new Radio(e.closest('[input-radio]'));
      //   radio.id = baseName + this.index + key
      // }
    })

    this.index = this.index + 1;
    this.repatedItemsContainer.appendChild(newItem);

    this.triggerAddedItem(newItem, this.index)
  }

  closeItem(el) {
    const items = [...this.repatedItemsContainer.querySelectorAll("[data-repeated-item]")]
    const item = el.closest("[data-repeated-item]");
    this.repatedItemsContainer.removeChild(item)
  }

  triggerAddedItem(item, index) {
    document.dispatchEvent(new CustomEvent("repeater_item_added", {
      detail: {
        item: item,
        index: index
      }
    }));
  }

}

function init() {
  const repeaters = document.querySelectorAll("[data-repeater]")

  repeaters.forEach(repeater => {
    new Repeater(repeater)
  });
}

export default { init };
