import collect from "collect.js";
import { Carousel } from "@fancyapps/ui/dist/carousel/carousel.esm.js";
import { Fancybox } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
window.Fancybox = Fancybox;
export default class GeneralFunctions {
    initManageBooking(states) {
        return {
            toggle: {},

            init() {
                this.toggle = JSON.parse(states);
            },

            toggleChanged(model) {
                let newValue = this.toggle[model];
                let final = {};

                let movie_shows = [];

                collect(this.toggle).map((t, k) => {
                    let splitted = k.split("_");

                    if (k.startsWith(model) && k != model) {
                        final = { ...final, [k]: newValue };

                        if (splitted.length - 1 === 3) {
                            movie_shows.push({
                                movie_show_id: splitted[splitted.length - 1],
                                visibility: newValue,
                            });
                        }
                    } else {
                        final = { ...final, [k]: t };

                        if (splitted.length - 1 === 3) {
                            movie_shows.push({
                                movie_show_id: splitted[splitted.length - 1],
                                visibility: t,
                            });
                        }
                    }
                    return t;
                });

                this.toggle = final;

                this.$wire.updateVisibility(movie_shows);
            },
        };
    }

    initPriceSettings() {
        return {
            conditions: [{ day: "", price: "0" }],
            defaultPrice: "",
            days: [
                { key: "monday", label: "Monday", used: 0 },
                { key: "tuesday", label: "Tuesday", used: 0 },
                { key: "wednesday", label: "Wednesday", used: 0 },
                { key: "thursday", label: "Thursday", used: 0 },
                { key: "friday", label: "Friday", used: 0 },
                { key: "saturday", label: "Saturday", used: 0 },
                { key: "sunday", label: "Sunday", used: 0 },
            ],

            updateValueState() {
                let conditions = collect(this.conditions).filter().toArray();
                this.$wire.value = {
                    defaultPrice: this.defaultPrice,
                    conditions: conditions,
                };
            },

            init() {
                let initalValue = this.$wire.value;

                this.defaultPrice = initalValue.defaultPrice;
                this.conditions = initalValue.conditions;

                console.log(this.conditions);

                this.$watch("conditions", (value) => {
                    this.updateValueState();
                });

                this.$watch("defaultPrice", (value) => {
                    this.updateValueState();
                });
            },

            addCondition() {
                this.conditions.push({ day: "", price: "0" });
            },

            deleteCondition(index) {
                this.conditions.splice(index, 1);
                this.updateValueState();
            },
        };
    }

    initConditions() {
        return {
            open: false,
            conditions: [""],
            defaultPercentage: "",

            async handleValueChanged(event) {
                let response = await this.$wire.getData(event.detail.selected);

                this.defaultPercentage = response.original.defaultPercentage;
                this.conditions = response.original.conditions;

                // console.log("value changed" , event);
            },

            async handleValueSelected(event) {
                let response = await this.$wire.getData(event.detail.selected);
                this.defaultPercentage = response.original.defaultPercentage;
                this.conditions = response.original.conditions;
            },

            updateValueState() {
                let conditions = collect(this.conditions).filter().toArray();

                this.$wire.value = {
                    defaultPercentage: this.defaultPercentage,
                    conditions: conditions,
                };
            },

            init() {
                let initalValue = this.$wire.value;

                this.defaultPercentage = initalValue.defaultPercentage;
                this.conditions = initalValue.conditions;

                this.$watch("conditions", (value) => {
                    this.updateValueState();
                });

                this.$watch("defaultPercentage", (value) => {
                    this.updateValueState();
                });
            },

            addCondition() {
                this.conditions.push("");
            },

            deleteCondition(index) {
                this.conditions.splice(index, 1);
                this.updateValueState();
            },
        };
    }

    calendar() {
        return {
            wire: null,
            drawers: {
                createDrawer: false,
                editDrawer: false,
                editAllDrawer: false,
            },
            selected: [],
            draggedEvent: null,
            draggableBox: null,
            disableDrop: false,
            offsetY: 0,

            init() {
                this.wire = () => {
                    return this.$wire;
                };

                this.$watch("selected", () => {
                    this.$wire.selected = this.selected;

                    window.dispatchEvent(
                        new CustomEvent("selectedshows", {
                            detail: {
                                selected: this.selected,
                            },
                        })
                    );
                });
            },

            deleteMovieShows() {
                this.wire().deleteMovieShows();
                this.selected.forEach((selection) => {
                    try {
                        document
                            .querySelector(
                                '.event-box[data-id="' + selection + '"]'
                            )
                            .remove();
                    } catch (error) {}
                });
            },

            emptySelection() {
                this.selected = [];
            },
            theaterChanged() {
                console.log("HEREEE");

                this.wire().updateEvents();
            },

            selectGroup() {
                let selectedEventId = this.selected[0];

                let selectedEvent = document.querySelector(
                    ".event-box[data-id='" + selectedEventId + "']"
                );

                if (selectedEvent == null) {
                    return;
                }

                let group = selectedEvent.getAttribute("data-group");

                let allGroupEvents = document.querySelectorAll(
                    ".event-box[data-group='" + group + "']"
                );

                let selected = collect([]);

                allGroupEvents.forEach((node) => {
                    selected.push(node.getAttribute("data-id"));
                });
                selected = selected.unique().filter().toArray();

                this.selected = selected;
            },

            async updateInfo(id, dateIndex, timeIndex) {
                this.wire().updateInfo(id, dateIndex, timeIndex);
            },

            handleCreateCallback() {
                this.wire().updateEvents();

                this.drawers = {
                    createDrawer: false,
                    editDrawer: false,
                    editAllDrawer: false,
                };

                this.selected = [];
            },

            handleErrorCallback() {
                this.drawers = {
                    createDrawer: false,
                    editDrawer: false,
                    editAllDrawer: false,
                };

                this.selected = [];
            },

            dragStart(event) {
                this.disableDrop = false;
                this.draggedEvent = JSON.parse(event);

                this.$event.dataTransfer.setData("text/plain", event.id);
                this.$event.dataTransfer.effectAllowed = "move";

                this.draggableItem = this.$event.target;

                this.offsetY = this.$event.offsetY;

                setTimeout(() => {
                    this.draggableItem.style.visibility = "hidden";
                }, 0);
            },

            dragEnd(event) {
                event.preventDefault();
                this.draggedEvent = null;
                setTimeout(() => {
                    this.draggableItem.style.visibility = "visible";
                }, 0);
            },

            dragOver(event) {
                event.preventDefault();

                let column = event.target;

                const rect = column.getBoundingClientRect();

                let newTop = event.clientY - rect.top - this.offsetY;

                if (newTop < 0) {
                    this.disableDrop = true;
                    return;
                }

                newTop = Math.round(newTop / 30) * 30;

                let mainIndex = newTop / 30;

                let columnID = column.getAttribute("data-id");

                document
                    .querySelectorAll(".slot")
                    .forEach((el) => el.classList.remove("active-slot"));

                let slots = document.querySelectorAll(
                    "#twa-calendar-column-back-" + columnID + " .slot"
                );

                slots[mainIndex].classList.add("active-slot");

                // twa-calendar-column-back

                document
                    .querySelectorAll(".time")
                    .forEach((el) => el.classList.remove("active-time"));

                let times = document.querySelectorAll(".time");

                times[mainIndex + 1].classList.add("active-time");
            },

            drop() {
                this.draggableItem.style.visibility = "visible";

                if (this.disableDrop) {
                    return;
                }

                let column = this.$event.target;

                const rect = column.getBoundingClientRect();

                let newTop = this.$event.clientY - rect.top - this.offsetY;

                newTop = Math.round(newTop / 30) * 30;

                let timeIndex = newTop / 30;
                let columnIndex = column.getAttribute("data-id");

                let draggableElement = document.querySelector(
                    ".event-box[data-id='" + this.draggedEvent.id + "']"
                );

                if (draggableElement == null) {
                    return;
                }

                draggableElement.style.top = newTop + "px";
                column.appendChild(draggableElement);

                this.updateInfo(this.draggedEvent.id, columnIndex, timeIndex);
                this.draggedEvent = null;
            },

            openDrawer(event, drawer) {
                event.stopPropagation();
                this.drawers = {
                    ...this.drawers,
                    [drawer]: true,
                };
            },

            closeDrawer(event, drawer) {
                event.stopPropagation();
                this.drawers = {
                    ...this.drawers,
                    [drawer]: false,
                };
            },
        };
    }

    initMap() {
        return {
            maxRow: null,
            maxColumn: null,
            cells: [],
            loading: false,
            gridGenerated: false,
            managingSeats: false,
            showNextStep: false,
            savedSeats: [],
            debounceTimeout: null,
            selectedType: null,
            zones: [],
            selectedZone: null,
            characters: [],
            selectedLetters: [],
            numberingOrder: "same",
            isSaving: false,

            changeRowLetter(rowIndex) {
                this.selectedLetters[rowIndex] = this.$event.target.value
                    .slice(-1)
                    .toUpperCase()
                    .replace(/[^A-Z]/g, "A");

                this.generateSeats();

                this.saveSeats();
            },

            init() {
                this.characters = [..."ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("")];

                this.cells = this.$wire.value;

                var maxSeatsPerRow = null;
                var firstSeatPerRow = null;
                this.cells.forEach((Xcells, indexX) => {
                    maxSeatsPerRow = collect(Xcells)
                        .where("isSeat", true)
                        .count();

                    firstSeatPerRow = collect(Xcells)
                        .where("isSeat", true)
                        .first();

                    this.selectedLetters[indexX] =
                        maxSeatsPerRow > 0 ? firstSeatPerRow?.row : null;
                });

                if (this.cells.length > 0) {
                    this.managingSeats = true;
                }
            },

            async getZones(reset) {
                if (this.selectedType != null) {
                    let response = await this.$wire.getZones(this.selectedType);
                    this.zones = response.original;
                    let zone = collect(this.zones).where("default", 1).first();

                    if (reset) {
                        var array = [];
                        this.cells.forEach((Xcells, indexX) => {
                            if (!Array.isArray(array[indexX] ?? null)) {
                                array[indexX] = [];
                            }
                            Xcells.forEach((cell, index) => {
                                array[indexX][index] = {
                                    ...cell,
                                    zone: zone.id,
                                    color: zone.color,
                                };
                            });
                        });

                        this.cells = array;
                    }

                    this.selectedZone = zone.id;
                    this.$refs.selectedZone.value = zone.id;
                }
            },

            handleValueSelected(event) {
                this.selectedType = event.detail.selected;
                this.getZones(false);

                const currentMaxRow = parseInt(this.maxRow) || 0;
                const currentMaxColumn = parseInt(this.maxColumn) || 0;
                if (
                    currentMaxRow > 0 &&
                    currentMaxColumn > 0 &&
                    this.selectedType > 0
                ) {
                    this.generateGrid();
                }
            },

            handleValueChanged(event) {
                var oldSelectedType = this.selectedType;

                this.selectedType = event.detail.selected;

                if (this.selectedType == null) {
                    this.gridGenerated = false;
                    this.managingSeats = false;
                    this.cells = [];
                    return;
                }

                const currentMaxRow = parseInt(this.maxRow) || 0;
                const currentMaxColumn = parseInt(this.maxColumn) || 0;
                this.getZones(true);
                if (
                    currentMaxRow > 0 &&
                    currentMaxColumn > 0 &&
                    this.selectedType > 0 &&
                    oldSelectedType != null
                ) {
                    // this.gridGenerated = false;
                    // this.managingSeats = false;
                    // this.maxRow = null;
                    // this.maxColumn = null;
                    // this.cells = [];

                    this.generateSeats();
                } else if (
                    currentMaxRow > 0 &&
                    currentMaxColumn > 0 &&
                    this.selectedType > 0
                ) {
                    this.generateGrid();
                }
            },

            checkAndGenerate() {
                const currentMaxRow = parseInt(this.maxRow) || 0;
                const currentMaxColumn = parseInt(this.maxColumn) || 0;

                if (currentMaxRow > 0 && currentMaxColumn > 0) {
                    if (this.selectedType != null) {
                        this.generateGrid();
                    } else {
                        window.Functions.TWAToast(
                            "Type selection required!",
                            "Please select type",
                            "danger",
                            "top-right"
                        );
                        return;
                    }
                } else {
                    this.cells = [];
                    this.gridGenerated = false;
                    this.loading = false;
                }
            },

            async generateGrid() {
                this.cells = [];
                await this.simulateLoading();

                var defaultZone = collect(this.zones)
                    .where("default", 1)
                    .first();

                this.selectedZone = defaultZone.id;

                const newCells = [];

                for (let row = 0; row < this.maxRow; row++) {
                    let array = [];

                    for (let col = 0; col < this.maxColumn; col++) {
                        // var old = this.cells[row] && this.cells[row][column] !== undefined ? this.cells[row][col] : {};

                        array.push({
                            isSeat: false,
                            color: defaultZone.color,
                            zone: defaultZone.id,
                            code: null,
                        });
                    }

                    newCells.push(array);
                }

                this.cells = newCells;

                this.gridGenerated = true;
                this.checkIfSeatSelected();
            },

            simulateLoading() {
                return new Promise((resolve) => {
                    let interval = setInterval(() => {
                        if (this.zones.length > 0) {
                            clearInterval(interval);
                            resolve();
                        }
                    }, 500);
                });
            },

            checkIfSeatSelected() {
                this.showNextStep = !this.cells
                    .flat()
                    .some((cell) => cell.isSeat);
            },
            toggleSeat(cell) {
                let zone = collect(this.zones)
                    .where("id", this.selectedZone)
                    .first();

                cell.isSeat = !cell.isSeat;
                cell.color = zone.color;

                this.checkIfSeatSelected();
            },

            saveSeats() {
                this.$wire.value = this.cells;

                window.Functions.TWAToast(
                    "Map Updated",
                    "Updates are successfully updated",
                    "success",
                    "top-right"
                );
            },

            handleSeatClick(cell) {
                this.selectedZone = parseInt(this.$refs.selectedZone.value);

                let zone = collect(this.zones)
                    .where("id", parseInt(this.selectedZone))
                    .first();

                if (zone) {
                    cell.color = zone.color;
                    cell.zone = zone.id;
                }

                this.saveSeats();
            },

            toggleAllSeats() {
                var array = [];

                this.cells.forEach((Xcells, indexX) => {
                    if (!Array.isArray(array[indexX] ?? null)) {
                        array[indexX] = [];
                    }
                    Xcells.forEach((cell, index) => {
                        array[indexX][index] = {
                            ...cell,
                            isSeat: !cell.isSeat,
                        };
                    });
                });

                this.cells = array;

                this.checkIfSeatSelected();
            },

            generateSeats() {
                var array = [];
                var rowNumber = 0;
                var maxSeatsPerRow = 0;
                var code = "";

                var direction = 1;

                var character = "";
                this.cells.forEach((Xcells, indexX) => {
                    maxSeatsPerRow = collect(Xcells)
                        .where("isSeat", true)
                        .count();

                    if (!Array.isArray(array[indexX] ?? null)) {
                        array[indexX] = [];
                    }

                    rowNumber = 0;

                    if (this.numberingOrder == "reverse") {
                        direction = 1;
                    } else {
                        maxSeatsPerRow = -1;
                        direction = -1;
                    }

                    character = this.selectedLetters[indexX];

                    Xcells.forEach((cell, index) => {
                        if (cell.isSeat) {
                            rowNumber++;
                            code = (maxSeatsPerRow + 1 - rowNumber) * direction;
                        }

                        array[indexX][index] = {
                            ...cell,
                            code: cell.isSeat ? character + code : null,
                            row: cell.isSeat ? character : null,
                            column: cell.isSeat ? code : null,
                        };
                    });
                });

                this.cells = array;
            },

            fillSelectedLetters() {
                var maxSeatsPerRow = 0;
                var characterIndex = -1;

                this.cells.forEach((Xcells, indexX) => {
                    maxSeatsPerRow = collect(Xcells)
                        .where("isSeat", true)
                        .count();

                    if (maxSeatsPerRow > 0) {
                        characterIndex++;
                    }

                    this.selectedLetters[indexX] =
                        maxSeatsPerRow > 0
                            ? this.characters[characterIndex]
                            : null;
                });
            },

            manageSeats() {
                if (this.selectedType == null) {
                    window.Functions.TWAToast(
                        "Type not selected",
                        "Please select type",
                        "danger",
                        "top-right"
                    );
                    return;
                }

                this.fillSelectedLetters();
                this.generateSeats();

                this.managingSeats = true;

                this.saveSeats();
            },

            resetSeats() {
                this.maxRow = "";
                this.maxColumn = "";

                this.$wire.value = [];

                this.gridGenerated = false;
                this.managingSeats = false;
            },
        };
    }

    slideshow() {
        const container = document.getElementById("slideshow");
        const options = {
            autoplay: {
                enabled: true, // Enable autoplay
                timeout: 2000, // Set timeout for 2 seconds
            },
        };

        new Carousel(container, options); // Pass the options directly to Carousel
    }
    animation() {
        return {
            counter: 0,
            animate(finalCount) {
                let duration = 1000; // Total animation duration in ms
                let interval = 15; // Update interval in ms
                let step = Math.ceil(finalCount / (duration / interval)); // Calculate step value

                let timer = setInterval(() => {
                    this.counter += step;
                    if (this.counter >= finalCount) {
                        this.counter = finalCount; // Ensure the final count is accurate
                        clearInterval(timer); // Stop the interval
                    }
                }, interval);
            },
        };
    }
    openYoutube(link) {
        new window.Fancybox([
            {
                src: link,
            },
        ]);
    }
}
