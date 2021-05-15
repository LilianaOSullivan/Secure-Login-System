function sort_table(n) {
    /*
        Sorting codebase adapted from here
        https://www.w3schools.com/howto/howto_js_sort_table.asp
    */
    var table = document.getElementById("logs_table");
    var loop = true;
    var sort_direction = "asc";
    var x, y, perform_switch, switch_count = 0;

    const convert_to_type = (x) => {
        if (!isNaN(Date.parse(x))) // If Date
            return Date.parse(x);
        else if (!isNaN(x) && !isNaN(parseFloat(x))) // If int
            return parseInt(x)
        return x.toLowerCase(); // else string
    };
    while (loop) {
        loop = false;
        var rows = table.rows;

        for (var i = 1; i < (rows.length - 1); i++) // Start at 1, 0 is the table head
        {
            perform_switch = false;
            x = rows[i].getElementsByTagName("td")[n];
            y = rows[i + 1].getElementsByTagName("td")[n];

            x = convert_to_type(x.innerHTML);
            y = convert_to_type(y.innerHTML);

            if (sort_direction === "asc") {
                if (x > y) {
                    perform_switch = true;
                    break;
                }
            }
            else {
                if (x < y) {
                    perform_switch = true;
                    break;
                }
            }
        }
        if (perform_switch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            loop = true;
            switch_count++;
        }
        else {
            if (switch_count === 0 && sort_direction === "asc") {
                sort_direction = "desc";
                loop = true;
            }
        }
    }

    var cells = table.rows[0].cells;
    for (var i = 0; i < cells.length; i++) { // Remove ▼ or ▲
        cells[i].classList.remove("asc");
        cells[i].classList.remove("desc");
    }
    table.rows[0].cells[n].classList.add(sort_direction);
}