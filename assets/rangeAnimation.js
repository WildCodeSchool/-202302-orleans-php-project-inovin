let ranges = document.querySelectorAll("input[type=range]");
for (let i = 0; i < ranges.length; i++) {
    ranges[i].addEventListener("change", function () {
        let total = 0;
        for (let r = 0; r < ranges.length; r++) {
            total += Number(ranges[r].value);
        }
        let containerTotal = document.getElementById("totalDosage");
        containerTotal.innerHTML = total;
    });
}
