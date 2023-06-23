var myWineSlider = document.getElementById("price_wine_slider");
var resetButon = document.getElementById("Reset");

if (resetButon) {
    resetButon.addEventListener("click", resetSlider);
}

function resetSlider() {
    myWineSlider.noUiSlider.reset();
}

if (myWineSlider) {
    const min = document.getElementById("minPrice");
    const max = document.getElementById("maxPrice");

    const range = window.noUiSlider.create(myWineSlider, {
        start: [Number(min.value) || 0, Number(max.value) || 100],
        connect: true,
        padding: [0, 0],
        tooltips: true,
        step: 1,
        range: {
            min: 0,
            max: 100,
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
