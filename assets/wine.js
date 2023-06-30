const myWineSlider = document.getElementById("price_wine_slider");
const resetButon = document.getElementById("Reset");

const minValue = Number(myWineSlider.dataset.minPrice);
const maxValue = Number(myWineSlider.dataset.maxPrice);

if (resetButon) {
    resetButon.addEventListener("click", resetSlider);
}

function resetSlider() {
    myWineSlider.noUiSlider.reset();
    document.getElementById("minPrice").value = minValue;
    document.getElementById("maxPrice").value = maxValue;
}

if (myWineSlider) {
    const minPrice = document.getElementById("minPrice");
    const maxPrice = document.getElementById("maxPrice");

    const range = window.noUiSlider.create(myWineSlider, {
        start: [
            Number(minPrice.value) || minValue,
            Number(maxPrice.value) || maxValue,
        ],
        connect: true,
        padding: [0, 0],
        tooltips: true,
        step: 1,
        range: {
            min: minValue,
            max: maxValue,
        },
        format: {
            to: function (value) {
                // format as you like / need:
                return Number(value);
            },
            from: function (value) {
                // format as you like / need:
                return Number(value);
            },
        },
    });

    range.on("slide", function (values, handle) {
        if (handle === 0) {
            minPrice.value = Math.round(values[0]);
        }
        if (handle === 1) {
            maxPrice.value = Math.round(values[1]);
        }
    });

    const inputsRange = [minPrice, maxPrice];

    inputsRange.forEach(function (input, handle) {
        input.addEventListener("change", function () {
            myWineSlider.noUiSlider.setHandle(handle, this.value);
        });

        input.addEventListener("keydown", function (e) {
            var values = myWineSlider.noUiSlider.get();
            var value = Number(values[handle]);

            // [[handle0_down, handle0_up], [handle1_down, handle1_up]]
            var steps = myWineSlider.noUiSlider.steps();

            // [down, up]
            var step = steps[handle];

            var position;

            // 13 is enter,
            // 38 is key up,
            // 40 is key down.
            switch (e.key) {
            case 13:
                myWineSlider.noUiSlider.setHandle(handle, this.value);
                break;

            case 38:
                // Get step to go increase slider value (up)
                position = step[1];

                // false = no step is set
                if (position === false) {
                    position = 1;
                }

                // null = edge of slider
                if (position !== null) {
                    myWineSlider.noUiSlider.setHandle(handle, value + position);
                }

                break;

            case 40:
                position = step[0];

                if (position === false) {
                    position = 1;
                }

                if (position !== null) {
                    myWineSlider.noUiSlider.setHandle(handle, value - position);
                }

                break;
            }
        });
    });
}
