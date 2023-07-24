let ranges = document.querySelectorAll("input[type=range]");
for (var i = 0; i < ranges.length; i++) {
    ranges[i].addEventListener("change", function () {
        let total = 0;
        for (var r = 0; r < ranges.length; r++) {
            total += Number(ranges[r].value);
        }
        let containerTotal = document.getElementById("totalDosage");
        containerTotal.innerHTML = total;
    });
}
