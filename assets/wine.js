const myWineSlider = document.getElementById("price_wine_slider");
const resetButon = document.getElementById("Reset");
const minValue = 0;
const maxValue = 100;

if (resetButon) {
    resetButon.addEventListener("click", resetSlider);
}

function resetSlider() {
    myWineSlider.noUiSlider.reset();
    document.getElementById("minPrice").value = minValue;
    document.getElementById("maxPrice").value = maxValue;
}

if (myWineSlider) {
    const min = document.getElementById("minPrice");
    const max = document.getElementById("maxPrice");

    const range = window.noUiSlider.create(myWineSlider, {
        start: [Number(min.value) || minValue, Number(max.value) || maxValue],
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
            min.value = Math.round(values[0]);
        }
        if (handle === 1) {
            max.value = Math.round(values[1]);
        }
    });
}
